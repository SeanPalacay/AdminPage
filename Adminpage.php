<!DOCTYPE html>
<html>
  <head>
    <title> Admin Page to create / edit / delete user</title>
  </head>
<body>
  
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
        Echo "Invalid Name, only letters and white spaces are allowed";
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
  <h3 style="text-align: center">Create a new user</h3>
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
    <th> Actions</th>
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