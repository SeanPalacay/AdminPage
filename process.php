<?php

// Connect to the database
include 'configure.php';



$name = $email = $password = "";
$nameErr = $emailErr = $passwordErr = "";

function testinput($input){
  $input = trim($input);
  $input = stripslashes($input);
  $input = htmlspecialchars($input);
  return $input;
}


// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Handle the form

  if (!empty($_POST)) {
    // Create a new user
  if (isset($_POST['create'])) {
    if(empty($_POST['name'])){
      $nameErr = "Name is required";
    } else {
      $name = testinput($_POST["name"]);
      $name = $conn->real_escape_string($_POST['name']);
      if (!preg_match("/^[a-zA-Z-' ]*$/",$name)){
        $nameErr = "Invalid Name, only letters and white spaces are allowed";
}
     }

     if(empty($_POST['email'])){
      $emailErr = "Email is required";
     } else {
      $email = testinput($_POST['email']);
      $email = $conn->real_escape_string($_POST['email']);
     }

     if(empty($_POST['password'])){
      $passwordErr = "Password is required";
     } else {
      $password = testinput($_POST['password']);
    $password = $conn->real_escape_string($_POST['password']);
     }
     
    $query = "INSERT INTO users (UserName, UserEmail, UserPass) VALUES ('$name', '$email', '$password')";
    $conn->query($query);
  
    header('Location: Adminpage.php');
    exit();

  } elseif (isset($_POST['edit'])) {
    // Edit an existing user
    $id = $conn->real_escape_string($_POST['id']);
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);
    $query = "UPDATE users SET UserName = '$name', UserEmail = '$email', UserPass = '$password' WHERE UserID = $id";
    $conn->query($query);

    header('Location: Adminpage.php');
    exit();

  } elseif (isset($_POST['delete'])) {
    // Delete an existing user
    $id = $conn->real_escape_string($_POST['id']);
    $query = "DELETE FROM users WHERE UserID  = $id";
    $conn->query($query);

    header('Location: Adminpage.php');
    exit();

  }
}
}


?>