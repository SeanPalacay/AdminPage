<?php

include 'configure.php';


$output ="";


if(isset($_POST['submit']))
{
    $query = "SELECT * FROM users";
    $result = $db->query($query);
    $users = $result->fetch_all(MYSQLI_ASSOC);
}




?>