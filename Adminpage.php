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
  margin: 0 auto;
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
include 'configure.php';

// Get a list of users
$query = "SELECT * FROM users";
$result = $conn->query($query);
$users = $result->fetch_all(MYSQLI_ASSOC);

?>


<!-- Display a list of users -->
<br>
  <a href="Enrolluser.php"> <button  type="submit" name="create" class="btn btn-primary">Create User</button></a>
<br><br>
<table>
  <tr>
    <th >ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Password</th>
    <th style = "text-align: center" colspan =2 Actions</th>
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
      <form action="process.php" method="post">
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
      <form action="process.php" method="post">
        <input type="hidden" name="id" value="<?php echo $user['UserID'] ?>">
        <button type="submit" name="delete">Delete</button>
      </form>
    </td>
   
  </tr>
  <?php endforeach; ?>

  
</table>
<?php

function saveDbToExcel($host, $username, $password, $dbname) {
    // Connect to the database
    include 'configure.php';
    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // Select the data
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);
    // Open the Excel file in write mode
    $file = fopen('users.csv', 'w');
    // Write the header row
    fputcsv($file, array('Name', 'Email', 'Password'));
    // Write the data
    while($row = $result->fetch_assoc()) {
        fputcsv($file, array($row['UserName'], $row['UserEmail'], $row['UserPass']));
    }
    // Close the file
    fclose($file);
    // Close the connection
    $conn->close();
}

if(empty($users)){
  echo "data is empty";
}else{

  saveDbToExcel("localhost", "root", "", "admindb");
  // Create the download button
  echo '<a href="users.csv" download="users.csv">Download</a>';
}
?>
</body>

</html>