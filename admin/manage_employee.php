<?php session_start(); /* Starts the session */

if(!isset($_SESSION['UserData']['Username'])){
  header("location:login.php");
  exit;
}
?> 
  <head>
    <title>Manange Employees</title>
  </head>
<?php
  include './sidenav/sidenav.html';
?>
<link rel="stylesheet" href="manage.css" type="text/css">
<div class = "rightbox"><br>
<?php
// Connect to the database
$conn = mysqli_connect('localhost', 'root', '', 'medical');

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize variables
$e_id = "";
$e_name = "";
$e_mail = "";
$e_phone = "";
$e_role = "";
$e_bdate = "";
$e_type = "";
$e_jdate = "";
$e_sex = "";
$e_salary = "";
$e_add = "";

// Save changes when form is submitted
if (isset($_POST['save_changes'])) {
  $e_id = mysqli_real_escape_string($conn, $_POST['e_id']);
  $e_name = mysqli_real_escape_string($conn, $_POST['e_name']);
  $e_mail = mysqli_real_escape_string($conn, $_POST['e_mail']);
  $e_phone = mysqli_real_escape_string($conn, $_POST['e_phone']);
  $e_role = mysqli_real_escape_string($conn, $_POST['e_role']);
  $e_bdate = mysqli_real_escape_string($conn, $_POST['e_bdate']);
  $e_type = mysqli_real_escape_string($conn, $_POST['e_type']);
  $e_jdate = mysqli_real_escape_string($conn, $_POST['e_jdate']);
  $e_sex = mysqli_real_escape_string($conn, $_POST['e_sex']);
  $e_salary = mysqli_real_escape_string($conn, $_POST['e_salary']);
  $e_add = mysqli_real_escape_string($conn, $_POST['e_add']);

  // Update the record in the database
  $update_query = "UPDATE EMPLOYEE SET E_Name='$e_name', E_Mail='$e_mail', E_Phone='$e_phone', E_Role='$e_role', E_Bdate='$e_bdate', E_Type='$e_type', E_Jdate='$e_jdate', E_Sex='$e_sex', E_Salary='$e_salary', E_Add='$e_add' WHERE E_ID='$e_id'";
  //mysqli_query($conn, $update_query);
  	if (mysqli_query($conn, $update_query)) {
	// Record updated successfully
	echo "<center><h2>Record updated successfully</center></h2>";
	} else {
	echo "<center><h2>Error updating record: " . mysqli_error($conn)."</center></h2>";
	}
}


// Delete the record when the form is submitted
if (isset($_POST['delete'])) {
  $e_id = mysqli_real_escape_string($conn, $_POST['e_id']);

  // Delete the record from the database
  $delete_query = "DELETE FROM EMPLOYEE WHERE E_ID='$e_id'";
  mysqli_query($conn,$delete_query);                        

}
// Select all records from the EMPLOYEE table
$select_query = "SELECT * FROM EMPLOYEE";
$result = mysqli_query($conn, $select_query);
?>

<table>
  <tr>
    <th>Employee ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Role</th>
    <th>Birth Date</th>
    <th>Type</th>
    <th>Join Date</th>
    <th>Sex</th>
    <th>Salary</th>
    <th>Address</th>
    <th>Actions</th>
  </tr>
  <?php while ($row = mysqli_fetch_assoc($result)) { ?>
  <tr>
    <td><?php echo $row['E_ID']; ?></td>
    <td><?php echo $row['E_Name']; ?></td>
    <td><?php echo $row['E_Mail']; ?></td>
    <td><?php echo $row['E_Phone']; ?></td>
    <td><?php echo $row['E_Role']; ?></td>
    <td><?php echo $row['E_Bdate']; ?></td>
    <td><?php echo $row['E_Type']; ?></td>
    <td><?php echo $row['E_Jdate']; ?></td>
    <td><?php echo $row['E_Sex']; ?></td>
    <td><?php echo $row['E_Salary']; ?></td>
    <td><?php echo $row['E_Add']; ?></td>
    <td>
      <!-- Edit button -->
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <input type="hidden" name="e_id" value="<?php echo $row['E_ID']; ?>">
        <button type="submit" class="btn" name="edit">Edit</button>
      </form>

      <!-- Delete button -->
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <input type="hidden" name="e_id" value="<?php echo $row['E_ID']; ?>">
        <button type="submit" class="btn" name="delete" onclick="return confirm('Are you sure you want to delete this record?');">Delete</button>
      </form>
    </td>
  </tr>
  <?php } 
  
  // Check if the "edit" form was submitted
  if (isset($_POST['edit'])) {
    // Get the record data from the database
    $e_id = mysqli_real_escape_string($conn, $_POST['e_id']);
    $select_query = "SELECT * FROM EMPLOYEE WHERE E_ID='$e_id'";
    $result = mysqli_query($conn, $select_query);
    $row = mysqli_fetch_assoc($result);
    
    // Populate the form with the record data
    $e_id = $row['E_ID'];
    $e_name = $row['E_Name'];
    $e_mail = $row['E_Mail'];
    $e_phone = $row['E_Phone'];
    $e_role = $row['E_Role'];
    $e_bdate = $row['E_Bdate'];
    $e_type = $row['E_Type'];
    $e_jdate = $row['E_Jdate'];
    $e_sex = $row['E_Sex'];
    $e_salary = $row['E_Salary'];
    $e_add = $row['E_Add'];
  }
  ?>
</table>
<br><br>
<!-- HTML code for the form and table -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <label for="e_id">Employee ID:</label><br>  
  <input type="text" id="e_id" name="e_id" value="<?php echo $e_id; ?>" readonly><br>
  <label for="e_name">Name:</label><br>
  <input type="text" id="e_name" name="e_name" value="<?php echo $e_name; ?>"><br>
  <label for="e_mail">Email:</label><br>
  <input type="text" id="e_mail" name="e_mail" value="<?php echo $e_mail; ?>"><br>
  <label for="e_phone">Phone:</label><br>
  <input type="text" id="e_phone" name="e_phone" value="<?php echo $e_phone; ?>"><br>
  <label for="e_role">Role:</label><br>
  <input type="text" id="e_role" name="e_role" value="<?php echo $e_role; ?>"><br>
  <label for="e_bdate">Birth date:</label><br>
  <input type="text" id="e_bdate" name="e_bdate" value="<?php echo $e_bdate; ?>"><br>
  <label for="e_type">Type:</label><br>
  <input type="text" id="e_type" name="e_type" value="<?php echo $e_type; ?>"><br>
  <label for="e_jdate">Join date:</label><br>
  <input type="text" id="e_jdate" name="e_jdate" value="<?php echo $e_jdate; ?>"><br>
  <label for="e_sex">Sex:</label><br>
  <input type="text" id="e_sex" name="e_sex" value="<?php echo $e_sex; ?>"><br>
  <label for="e_salary">Salary:</label><br>
  <input type="text" id="e_salary" name="e_salary" value="<?php echo $e_salary; ?>"><br>
  <label for="e_add">Address:</label><br>
  <input type="text" id="e_add" name="e_add" value="<?php echo $e_add; ?>"><br><br>
  <input type="submit" value="Save Changes" name="save_changes">
</form> 

</div>
