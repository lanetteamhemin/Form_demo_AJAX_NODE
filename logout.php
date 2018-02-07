

<?php
require_once("header_include.php");
session_start();
unset($_SESSION['uname']);
unset($_SESSION['id']);
session_destroy();
?>

<script>
    swal("successfully logout...!", {
        icon: "success",
    },()=>{
        <?php
        if(!(isset($_SESSION['uname'])))
        {
            header("location:index.php");
        }

        ?>
    });
</script>


