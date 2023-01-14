

<?php 
include 'Adminpage.php';
?>

<table border = "1">
  <td>
<form method="post" action = "process.php">
  <h3 style="text-align: center">Create a New User</h3>
  <table >
    <tr> 
      <td> 
      Name: <input type="text" id="name" name="name" required>
 
      </td>
    </tr>
    <tr> 
      <td> 
      Email: <input type="email" id="email" name="email" required>
    
      </td>
    </tr>
    <tr> 
      <td> 
      Password: <input type="text" id="password" name="password" required>
   
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
