<?php
  include './sidenav/sidenav.html';
?>
  <head>
    <title>Manage Customers</title>
  </head>
<link rel="stylesheet" href="manage.css" type="text/css">
<div class = "rightbox">
<?php
// Connect to the database
$conn = mysqli_connect('localhost', 'root', '', 'medical');

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize variables
$c_id = "";
$c_fname = "";
$c_lname = "";
$c_address = "";
$c_age = "";
$c_sex = "";
$c_phone = "";
$c_mail = "";

// Save changes when form is submitted
if (isset($_POST['save_changes'])) {
  $c_id = mysqli_real_escape_string($conn, $_POST['c_id']);
  $c_fname = mysqli_real_escape_string($conn, $_POST['c_fname']);
  $c_lname = mysqli_real_escape_string($conn, $_POST['c_lname']);
  $c_address = mysqli_real_escape_string($conn, $_POST['c_address']);
  $c_age = mysqli_real_escape_string($conn, $_POST['c_age']);
  $c_sex = mysqli_real_escape_string($conn, $_POST['c_sex']);
  $c_phone = mysqli_real_escape_string($conn, $_POST['c_phone']);
  $c_mail = mysqli_real_escape_string($conn, $_POST['c_mail']);

  // Update the record in the database
  $update_query = "UPDATE CUSTOMER SET C_Fname='$c_fname', C_Lname='$c_lname', C_Address='$c_address', C_Age='$c_age', C_Sex='$c_sex', C_Phone='$c_phone', C_Mail='$c_mail' WHERE C_ID='$c_id'";
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
  $c_id = mysqli_real_escape_string($conn, $_POST['c_id']);

  // Delete the record from the database
  $delete_query = "DELETE FROM CUSTOMER WHERE C_ID='$c_id'";
  mysqli_query($conn, $delete_query);
}

// Select all records from the CUSTOMER table
$select_query = "SELECT * FROM CUSTOMER";
$result = mysqli_query($conn, $select_query);

// Close the connection

?>

<!-- HTML table to display the records -->
<table>
  <tr>
    <th>Customer ID</th>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Address</th>
    <th>Age</th>
    <th>Sex</th>
    <th>Phone</th>
    <th>Email</th>
    <th>Actions</th>
  </tr>
  <?php while ($row = mysqli_fetch_assoc($result)) { ?>
  <tr>
    <td><?php echo $row['C_ID']; ?></td>
    <td><?php echo $row['C_Fname']; ?></td>
    <td><?php echo $row['C_Lname']; ?></td>
    <td><?php echo $row['C_Address']; ?></td>
    <td><?php echo $row['C_Age']; ?></td>
    <td><?php echo $row['C_Sex']; ?></td>
    <td><?php echo $row['C_Phone']; ?></td>
    <td><?php echo $row['C_Mail']; ?></td>
    <td>
      <!-- Edit button -->
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <input type="hidden" name="c_id" value="<?php echo $row['C_ID']; ?>">
        <button type="submit" class="btn" name="edit">Edit</button>
      </form>

      <!-- Delete button -->
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <input type="hidden" name="c_id" value="<?php echo $row['C_ID']; ?>">
        <button type="submit" class="btn" name="delete" onclick="return confirm('Are you sure you want to delete this record?');">Delete</button>
      </form>
    </td>
  </tr>
  <?php } 
  
  // Check if the "edit" form was submitted
  if (isset($_POST['edit'])) {
    // Get the record data from the database
    $c_id = mysqli_real_escape_string($conn, $_POST['c_id']);
    $select_query = "SELECT * FROM CUSTOMER WHERE C_ID='$c_id'";
    $result = mysqli_query($conn, $select_query);
    $row = mysqli_fetch_assoc($result);

    // Set the form values
    $c_id = $row['C_ID'];
    $c_fname = $row['C_Fname'];
    $c_lname = $row['C_Lname'];
    $c_address = $row['C_Address'];
    $c_age = $row['C_Age'];
    $c_sex = $row['C_Sex'];
    $c_phone = $row['C_Phone'];
    $c_mail = $row['C_Mail'];
  }
  ?>
</table>
<br><br>
<!-- Form to add/update a record -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<!-- Hidden field to store the ID of the record being edited -->
<input type="hidden" name="c_id" value="<?php echo $c_id; ?>">
<label for="c_fname">First Name:</label><br>
<input type="text" id="c_fname" name="c_fname" value="<?php echo $c_fname; ?>"><br>
<label for="c_lname">Last Name:</label><br>
<input type="text" id="c_lname" name="c_lname" value="<?php echo $c_lname; ?>"><br>
<label for="c_address">Address:</label><br>
<input type="text" id="c_address" name="c_address" value="<?php echo $c_address; ?>"><br>
<label for="c_age">Age:</label><br>
<input type="number" id="c_age" name="c_age" value="<?php echo $c_age; ?>"><br><br>
<label for="c_sex">Sex:</label><br>
<input type="text" id="c_sex" name="c_sex" value="<?php echo $c_sex; ?>"><br>
<label for="c_phone">Phone:</label><br>
<input type="number" id="c_phone" name="c_phone" value="<?php echo $c_phone; ?>"><br><br>
<label for="c_mail">Email:</label><br>
<input type="email" id="c_mail" name="c_mail" value="<?php echo $c_mail; ?>"><br><br>
<!-- Submit button -->
<?php if ($c_id != "") { ?>
  <!-- Update button when editing a record -->
  <button type="submit" name="save_changes">Update</button>
<?php } else { ?>
  <!-- Add button when adding a new record -->
  <button type="submit" name="add" style="background-color: #4CAF50;color: white;padding: 10px 20px;margin: 8px 0;border: none;cursor: pointer;width: 100%;">Add</button>
<?php } ?>
</form>

</div>
<br>
<?php mysqli_close($conn); ?>