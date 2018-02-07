<html>
<head>
    <meta charset="UTF-8">
    <title>Demo | Register</title>

    <?php
        require_once("header_include.php");
    ?>

    <script type="text/javascript">
        $(document).ready(function () {

            function formdataget(){
                $id = $("#data_id").val();
                $name = $("#name").val();
                $email = $("#email").val();
                $pwd = $("#pwd").val();
            }
            function clearformdata(){
                $("#data_id").val("-1");
                $("#name").val("");
                $("#email").val("");
                $("#pwd").val("");
            }

            function savedata(){
                var id = $("#data_id").val();
                var name = $("#name").val();
                var email = $("#email").val();
                var pwd = $("#pwd").val();

                console.log(email+pwd+name);

                $.ajax({
                    type: "POST",
                    url: "http://192.168.200.83:1212/insert",
                    data: {name: name, email: email, password: pwd},
                    success: function (res) {

                        /*var regres = JSON.parse(res);


                        if(regres.created == 1){
                            window.location="home.php";
                        }
                        else{
                            alert("not reg");
                        }*/
                        window.location="home.php";
                        //$("#datasource").html();
                        //loadmydata();
                    },
                    error: function (err) {
                        alert("error"+err);
                    }
                });
            }

            function loadmydata() {
                //$("#up").hide();
                //alert("load function call");
                $.ajax({
                    type: "GET",
                    url: "http://192.168.200.83:1212/show",//"API/fetch_all_record.php",
                    success: function (res) {
                        console.log(res);
                        var len = res.length;
                        var txt = "";
                        if (len > 0) {
                            txt += "<table class='table table-bordered table-hover' border='1'>";
                            txt += '<thead>';
                            txt += '<tr>';
                            txt += '<th>Name</th>';
                            txt += '<th>Email</th>';
                            txt += '<th colspan="2">Action</th>';
                            txt += '</tr>';
                            txt += '</thead>';

                            txt += '<tbody>';
                            for (var i = 0; i < len; i++) {
                                if (res[i].name && res[i].email && res[i].password) {
                                    txt += '<tr>';
                                    txt += '<td>' + res[i].name + '</td>';
                                    txt += '<td>' + res[i].email + '</td>';
                                    txt += '<td><a class="_Editdata" _id="' + res[i].id + '">Edit</a> | ';
                                    txt += '<a class="_Removedata model" _id="' + res[i].id + '">Remove</a></td>'
                                    txt += '</tr>';
                                }
                            }
                            txt += '</tbody>';
                            txt += "</table>";
                        }
                        if (txt !== "") {
                            $("#datasource").html(txt);
                        }
                    },
                    error: function (err) {
                        console.log('error');
                        alert("error"+err);
                    }
                }).done(function () {
                    $("._Removedata").click(function () {
                        $("#up").hide();
                        swal({
                            title: "Are you sure?",
                            text: "Once deleted, you will not be able to recover selected record!",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        }).then((willDelete) => {
                            if (willDelete) {
                                var _id = $(this).attr("_id");
                                removedata(_id);
                            }
                            else
                            {
                                swal("your selected record canceled...");
                            }
                        });
                    })

                    $("._Editdata").click(function () {
                        var _id = $(this).attr("_id");

                        $req = "http://192.168.200.83:1212/fetchbyid/" + _id;
                        $.ajax({
                            type: "GET",
                            url: $req,
                            data: {id: _id},
                            success: function (res) {
                                $("#up").show();
                                $("#data_id").val(res[0].id);
                                $("#name").val(res[0].name);
                                $("#email").val(res[0].email);
                                $("#pwd").val(res[0].password);

                                $("#register").text("update");
                            },
                            error: function (err) {
                                alert(err);
                            }
                        });
                    })
                });
            }

            $("#register").click(function () {
                formdataget();
                if($id=="-1") savedata();
                else updatedata();

            });
            $("#cancel").click(function(){
                clearformdata();
            })
        });
    </script>
</head>
<body>

    <br>

    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4 well" style="height:70%">
            <center><h2>Register</h2></center>
            <input type="hidden" id="data_id" value="-1"><br>
            <div class="form-group">
                <label for="text">Name:</label>
                <input type="text" class="form-control" id="name">
            </div><br>
            <div class="form-group">
                <label for="email">Email address:</label>
                <input type="email" class="form-control" id="email">
            </div><br>
            <div class="form-group">
                <label for="pwd">Password:</label>
                <input type="password" class="form-control" id="pwd">
            </div><br>
<!--            <div class="form-group">-->
<!--                <label for="profile">Profile:</label>-->
<!--                <input type="file" class="" id="profile">-->
<!--            </div><br>-->
            <center>
                <div class="col-sm-6">
                    <button type="submit" class="btn btn-info btnregister" name="register" id="register">Register</button>
                </div>
                <div class="col-sm-6">
                    <button type="submit" class="btn btn-danger" name="cancel" id="cancel">Cancel</button>
                </div><br>
            </center>

            <br><br>
            Click Here <a href="index.php">Login</a>
        </div>
    </div>



<br><br>
<div id="datasource">

</div>

</body>
</html>