<?php

if(isset($_GET['id'])) {
    include "connect.php";
    $id = $_GET['id'];

    $query = "DELETE FROM students WHERE student_id =$id";
    $connection->query($query);
}

header("location: /crud/index.php");
exit;