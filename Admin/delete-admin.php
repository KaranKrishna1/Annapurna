<?php

    include ('../config/constants.php');

    echo $id = $_GET['id'];
    $sql = "DELETE FROM tbl_admin WHERE id = $id";
    $res = mysqli_query($conn, $sql);

    if($res == true){
        echo "Admin Deleted Successfully.";
        $_SESSION['delete'] = "<div class = 'success'>Admin Deleted Successfully.</div>";
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
    else{
        $_SESSION['delete'] = "<div class = 'error'>Failed to Delete Admin. Try Again.</div>";
        header('location:'.SITEURL.'admin/manage-admin.php');
        ;
    }
?>