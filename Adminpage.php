<!DOCTYPE html>
<html>
  <head>
    <title> Admin Page to create / edit / delete user</title>
    
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

  </head>
<body>
  
  


<style>
  /* Add some styling to the form */
  form {
    width: 500px;
    margin: auto;
    background-color: lightgray;
    padding: 20px;
  }

  /* Add some styling to the table */
  table {
  border-collapse: collapse;
  width: 100%;
}

th {
  background-color: #dddddd;
  text-align: left;
  padding: 8px;
}

td {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #f2f2f2;
}


  /* Add some styling to the input fields */
  input[type="text"], input[type="email"], input[type="password"] {
    width: 100%;
    border: none;
    border-bottom: 2px solid black;
    background-color: transparent;
  }

  /* Add some styling to the buttons */
  button[type="submit"] {
    background-color: blue;
    color: white;
    border: none;
    padding: 10px;
    cursor: pointer;
  }

  /* Add some styling to the error messages */
  .error {
    color: red;
  }
</style>
<?php

// Connect to the database
$db = new mysqli('localhost', 'root', '', 'admindb');



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

  
    // Create a new user
  if (isset($_POST['create'])) {
    if(empty($_POST['name'])){
      $nameErr = "Name is required";
    } else {
      $name = testinput($_POST["name"]);
      $name = $db->real_escape_string($_POST['name']);
      if (!preg_match("/^[a-zA-Z-' ]*$/",$name)){
        $nameErr = "Invalid Name, only letters and white spaces are allowed";
}
     }

     if(empty($_POST['email'])){
      $emailErr = "Email is required";
     } else {
      $email = testinput($_POST['email']);
      $email = $db->real_escape_string($_POST['email']);
     }

     if(empty($_POST['password'])){
      $passwordErr = "Password is required";
     } else {
      $password = testinput($_POST['password']);
    $password = $db->real_escape_string($_POST['password']);
     }
     
    $query = "INSERT INTO users (UserName, UserEmail, UserPass) VALUES ('$name', '$email', '$password')";
    $db->query($query);


  } elseif (isset($_POST['edit'])) {
    // Edit an existing user
    $id = $db->real_escape_string($_POST['id']);
    $name = $db->real_escape_string($_POST['name']);
    $email = $db->real_escape_string($_POST['email']);
    $password = $db->real_escape_string($_POST['password']);
    $query = "UPDATE users SET UserName = '$name', UserEmail = '$email', UserPass = '$password' WHERE UserID = $id";
    $db->query($query);
  } elseif (isset($_POST['delete'])) {
    // Delete an existing user
    $id = $db->real_escape_string($_POST['id']);
    $query = "DELETE FROM users WHERE UserID  = $id";
    $db->query($query);
  }
}

// Get a list of users
$query = "SELECT * FROM users";
$result = $db->query($query);
$users = $result->fetch_all(MYSQLI_ASSOC);

?>

<!-- Display the form -->
<table border = "1">
  <td>
<form method="post" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <h3 style="text-align: center">Create a New User</h3>
  <table >
    <tr> 
      <td> 
      Name: <input type="text" id="name" name="name" required>
      <span class ="error">* <?php echo $nameErr?></span>
      </td>
    </tr>
    <tr> 
      <td> 
      Email: <input type="email" id="email" name="email" required>
      <span class ="error">* <?php echo $emailErr?></span>
      </td>
    </tr>
    <tr> 
      <td> 
      Password: <input type="password" id="password" name="password" required>
      <span class ="error">* <?php echo $passwordErr?></span>
      </td>
    </tr>
    <tr>
      <td>
        <br>
      <button type="submit" name="create">Create</button>
      </td>
    </tr>
    </table>
</form>
</td>
</table>
<hr>

<!-- Display a list of users -->

<table>
  <tr>
    <th >ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Password</th>
    <th style = "text-align: center" colspan = 2> Actions</th>
  </tr>
  <?php foreach ($users as $user): ?>
  <tr>
    <td><?php echo $user['UserID'] ?></td>
    <td><?php echo $user['UserName'] ?></td>
    <td><?php echo $user['UserEmail'] ?></td>
    <td><?php echo $user['UserPass'] ?></td>
    <td>
      <br>

      <!-- Edit form -->
      <form method="post">
          <input type="hidden" name="id" value="<?php echo $user['UserID'] ?>">
      Name: <input type="text" id="name" name="name" value="<?php echo $user['UserName'] ?>">
      Email: <input type="email" id="email" name="email" value="<?php echo $user['UserEmail'] ?>">
      Password: <input type="password" id="password" name="password" value="<?php echo $user['UserPass'] ?>">
      <br><br>
      <button type="submit" name="edit">Edit</button>
      </form>
</td>
<td>
  <br>

      <!-- Delete form -->
      <form method="post">
        <input type="hidden" name="id" value="<?php echo $user['UserID'] ?>">
        <button type="submit" name="delete">Delete</button>
      </form>
      
    </td>
  </tr>
  <?php endforeach; ?>
</table>

</body>

</html>