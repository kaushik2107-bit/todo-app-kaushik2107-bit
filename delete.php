<?php
    $id = $_GET['id'];
    include 'connection.php';
    session_start();
    $ss = "use sql6520365";
    mysqli_query($conn, $ss);
    $query = "Delete from task_info where user_name = '".$_SESSION['user']."' and id = '".$id."'";

    $s = mysqli_query($conn, $query);

    if ($s) {
        echo "<script> alert('Deleted Successfully.')</script>";
    } else {
        echo "<script> alert('Try again some time later')</script>";
    }

    header('location: task_app.php');

?>