<?php
    require_once("header_include.php");
    session_start();
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Title</title>

    <script src="./script/js/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <script type="text/javascript" src="//code.jquery.com/jquery-1.12.4.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

    <style type="text/css">
        .btnlogout {
            float: right;
            padding-right: 2%;

        }
        table{
            border: 2px solid black

        }
        td{
            margin-left: 15%;
        }
        .settable{
            border-collapse: collapse;
            border: 2px solid black;
        }
        .settbl-head{
            background-color: rgba(0, 0, 0, 0.91);
            color: aqua;
            font-weight: bold;
            font-size: x-large;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function () {
            /*function sessiondata()
            {
                //$(document).onload(function(){
                   $.ajax({
                      type:"POST",
                      url:"http://localhost:1212/fetchsession",
                      success :function(res){
                          console.log(res);
                          //$("#uname").text();
                      },
                      error : function(err){
                          console.log(err);
                      }
                   });
                //});
            }*/

            //sessiondata();

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
            function removedata(_id) {
                console.log(_id);
                $req = "http://192.168.200.83:1212/delete/" + _id
                $.ajax({
                    type: "DELETE",
                    url: $req,
                    data: {id: _id},
                    success: function (res) {
                            swal("Your selected data has been deleted successfully!", {
                                icon: "success",
                            });
                            loadmydata();
                    },
                    error: function (err) {
                        alert(err);
                    }
                });
            }
            function updatedata(){
                formdataget();
                $.ajax({
                    type: "POST",
                    url: "http://192.168.200.83:1212/updatebyid/" + $id,
                    data: {name: $name, email: $email},
                    success: function (res) {
                        if (res) {
                            swal("Your data successfully updated...!", {
                                icon: "success",
                            });
                            clearformdata();
                            loadmydata();
                        }
                    },
                    error: function (err) {
                        alert("update error");
                    }
                });
            }
            function savedata(){
                formdataget();
                $.ajax({
                    type: "POST",
                    url: "http://192.168.200.83:1212/insert",
                    data: {name: $name, email: $email, password: $pwd},
                    success: function (res) {
                        if (res) {
                            clearformdata();
                            loadmydata();
                        }
                    },
                    error: function (err) {
                        alert(err);
                    }
                });
            }
            function loadmydata() {
                $("#up").hide();

                //alert("load function call");
                $.ajax({
                    type: "GET",
                    url: "http://192.168.200.83:1212/show",//"API/fetch_all_record.php",
                    success: function (res) {
                        console.log(res);
                        var len = res.length;
                        var txt = "";
                        if (len > 0) {
                            for (var i = 0; i < len; i++) {
                                if (res[i].name && res[i].email && res[i].password) {
                                    txt += '<tr class="settable">';
                                    txt += '<td>' + res[i].name + '</td>';
                                    txt += '<td>' + res[i].email + '</td>';
                                    txt += '<td><a class="_Editdata" _id="' + res[i].id + '">Edit</a> | ';
                                    txt += '<a class="_Removedata model" _id="' + res[i].id + '">Remove</a></td>'
                                    txt += '</tr>';
                                }
                            }
                        }
                        if (txt !== "") {
                            $("#tblbody").html(txt);
                            $("#tbl").DataTable();
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
                    });

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

                                $("#register").text("update");
                            },
                            error: function (err) {
                                alert(err);
                            }
                        });
                    });
                });
            };

            loadmydata();

            $("#register").click(function () {
                formdataget();
                if($id=="-1") savedata();
                else updatedata();

            });
            $("#cancel").click(function(){
                clearformdata();
                $("#up").hide();
            });
            $("#logout").click(function(){
                $.ajax({
                    type: "GET",
                    url: "logout.php",
                    data:{data:data},
                    success: function (res) {
                        console.log("logout");
                    },
                    error: function (err) {
                        alert(err);
                    }
                });
            });
            $("#chktbl").DataTable();
            //$("#tbl").DataTable();
        });
    </script>
</head>
<body>
<br>
<div class="row">
    <div class="col-sm-5">
        Welcome <span id="uname"></span>
    </div>
    <div class="col-sm-5">

    </div>
    <div class="col-sm-2">
        <a href="logout.php">
            <button class="btn btn-danger" id="logout">
                <i class="fa fa-power-off"></i> Logout
            </button>
        </a>
    </div>
</div>
<h2>Display Record</h2>
<div class="row" id="up">
    <div class="col-sm-3">
        <input type="hidden" id="data_id" value="-1"><br>
        <div class="form-group">
            <label for="text">Name:</label>
            <input type="text" class="form-control" id="name">
        </div>
        <div class="form-group">
            <label for="email">Email address:</label>
            <input type="email" class="form-control" id="email">
        </div>
        <button type="submit" class="btn btn-info btnregister" name="register" id="register">Register</button>
        <button type="submit" class="btn btn-danger" name="cancel" id="cancel">Cancel</button>
    </div>
</div>


<br>
<div id="datasource" class="well">
    <table id="tbl" class="table settable">
        <thead class="settbl-head">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="tblbody">
        </tbody>
    </table>
</div>
<!--<table id="chktbl">-->
<!--    <thead>-->
<!--    <tr>-->
<!--        <th>name</th>-->
<!--        <th>email</th>-->
<!--        <th>action</th>-->
<!--    </tr>-->
<!--    </thead>-->
<!--    <tbody>-->
<!--        <tr>-->
<!--            <td>a</td>-->
<!--            <td>1</td>-->
<!--            <td>1</td>-->
<!--        </tr>-->
<!--        <tr>-->
<!--            <td>a</td>-->
<!--            <td>1</td>-->
<!--            <td>1</td>-->
<!--        </tr>-->
<!--        <tr>-->
<!--            <td>a</td>-->
<!--            <td>1</td>-->
<!--            <td>1</td>-->
<!--        </tr>-->
<!--        <tr>-->
<!--            <td>a</td>-->
<!--            <td>1</td>-->
<!--            <td>1</td>-->
<!--        </tr>-->
<!--        <tr>-->
<!--            <td>a</td>-->
<!--            <td>1</td>-->
<!--            <td>1</td>-->
<!--        </tr>-->
<!--        <tr>-->
<!--            <td>a</td>-->
<!--            <td>1</td>-->
<!--            <td>1</td>-->
<!--        </tr>-->
<!--        <tr>-->
<!--            <td>a</td>-->
<!--            <td>1</td>-->
<!--            <td>1</td>-->
<!--        </tr>-->
<!--        <tr>-->
<!--            <td>a</td>-->
<!--            <td>1</td>-->
<!--            <td>1</td>-->
<!--        </tr>-->
<!--        <tr>-->
<!--            <td>a</td>-->
<!--            <td>1</td>-->
<!--            <td>1</td>-->
<!--        </tr>-->
<!--        <tr>-->
<!--            <td>a</td>-->
<!--            <td>1</td>-->
<!--            <td>1</td>-->
<!--        </tr>-->
<!--        <tr>-->
<!--            <td>a</td>-->
<!--            <td>1</td>-->
<!--            <td>12</td>-->
<!--        </tr>-->
<!--        <tr>-->
<!--            <td>a</td>-->
<!--            <td>16</td>-->
<!--            <td>13</td>-->
<!--        </tr>-->
<!--        <tr>-->
<!--            <td>a</td>-->
<!--            <td>15</td>-->
<!--            <td>15</td>-->
<!--        </tr>-->
<!--        <tr>-->
<!--            <td>a</td>-->
<!--            <td>15</td>-->
<!--            <td>15</td>-->
<!--        </tr>-->
<!--        <tr>-->
<!--            <td>a</td>-->
<!--            <td>51</td>-->
<!--            <td>1d</td>-->
<!--        </tr>-->
<!--        <tr>-->
<!--            <td>a</td>-->
<!--            <td>16</td>-->
<!--            <td>1fsdg</td>-->
<!--        </tr>-->
<!--        <tr>-->
<!--            <td>a</td>-->
<!--            <td>15</td>-->
<!--            <td>1sd</td>-->
<!--        </tr>-->
<!--        <tr>-->
<!--            <td>a</td>-->
<!--            <td>2</td>-->
<!--            <td>14</td>-->
<!--        </tr><tr>-->
<!--            <td>a</td>-->
<!--            <td>13</td>-->
<!--            <td>13</td>-->
<!--        </tr>-->
<!--    </tbody>-->
<!--</table>-->
</body>
</html>