<html>
<head>
    <meta charset="UTF-8">
    <title>Demo | Index</title>

    <style type="text/css">
        .required{
            border:solid 1px red !important;
        }
    </style>
    <?php
        require_once("header_include.php");
    ?>

    <script type="text/javascript">
        $(document).ready(function () {
            //alert("load data");
            $("#err").text("");
            function formdataget() {
                $id = $("#data_id").val();
                $email = $("#email").val();
                $pwd = $("#pwd").val();
            }

            function clearformdata() {
                $("#data_id").val("-1");
                $("#email").val("");
                $("#pwd").val("");
            }

            $("#cancel").click(function(){
                clearformdata();
            });

            $("#login").click(function(){
                //alert("event call");
                $email=$("#email").val();
                $pwd=$("#pwd").val();

                $("#err").text("");
                var isvalid=true;

                $(".req").each(function(){
                    var val = $(this).val().trim();
                   $(this).removeClass("required");
                   if(val=="")
                   {
                       isvalid=false;
                       $(this).addClass("required");
                   }
                });
                if(isvalid)
                {
                   // alert("hi");
                    $.ajax({
                        type: "POST",
                        url: "http://192.168.200.83:1212/login",
                        data: { email: $email, password: $pwd},
                        success: function (data){
                            console.log(data);
                            if(data) {
                                window.location = "home.php";
                            }
                        },
                        error: function (err){
                            alert("error"+err);
                            $("#err").text("");
                        }
                    });
                }
                else {
                    $("#err").text("please enter required field")
                }
            });
        });
    </script>

</head>
<body>
<form method="post">
<input type="hidden" id="uid">
<br>
<div class="row">
    <div class="col-sm-4"></div>
    <div class="col-sm-4 well" style="height:500px">
        <center><h2>Login</h2></center>
        <span type="text" id="err" style="color: red;"></span>
        <input type="hidden" id="data_id" value="-1"><br>
        <div class="form-group">
            <label for="email">Email address:</label>
            <input type="email" class="form-control req" name="email" id="email" >
        </div><br>
        <div class="form-group">
            <label for="pwd">Password:</label>
            <input type="password" class="form-control req" name="password" id="pwd" >
        </div><br>
        <center>
            <div class="col-sm-6">
                <button class="btn btn-info" name="login" id="login">Login</button>
            </div>
            <div class="col-sm-6">
                <button class="btn btn-danger" name="cancel" id="cancel">Cancel</button>
            </div><br>
        </center>
        <br><br>
        Click Here <a href="register.php">Register</a>
    </div>
</div>
</form>
</body>
</html>

