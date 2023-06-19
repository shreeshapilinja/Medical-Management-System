<?php session_start(); /* Starts the session */

if(!isset($_SESSION['UserData']['Username'])){
  header("location:login.php");
  exit;
}
?> 
  <head>
    <title>Manage Supplies</title>
  </head>
<?php
  include './sidenav/sidenav.html';
?>
<div class = "rightbox">
<link rel="stylesheet" href="manage.css" type="text/css">
<?php
// Connect to the database
$conn = mysqli_connect('localhost', 'root', '', 'medical');

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize variables
$sup_id = "";
$sup_name = "";
$sup_mail = "";
$sup_phone = "";
$sup_add = "";

// Save changes when form is submitted
if (isset($_POST['save_changes'])) {
  $sup_id = mysqli_real_escape_string($conn, $_POST['sup_id']);
  $sup_name = mysqli_real_escape_string($conn, $_POST['sup_name']);
  $sup_mail = mysqli_real_escape_string($conn, $_POST['sup_mail']);
  $sup_phone = mysqli_real_escape_string($conn, $_POST['sup_phone']);
  $sup_add = mysqli_real_escape_string($conn, $_POST['sup_add']);

  // Update the record in the database
  $update_query = "UPDATE SUPPLIERS SET Sup_Name='$sup_name', Sup_Mail='$sup_mail', Sup_Phone='$sup_phone', Sup_Add='$sup_add' WHERE Sup_ID='$sup_id'";
//  mysqli_query($conn, $update_query);
	if (mysqli_query($conn, $update_query)) {
	// Record updated successfully
	echo "<center><h2>Record updated successfully</center></h2>";
	} else {
	echo "<center><h2>Error updating record: " . mysqli_error($conn)."</center></h2>";
	}

}

// Delete the record when the form is submitted
if (isset($_POST['delete'])) {
  $sup_id = mysqli_real_escape_string($conn, $_POST['sup_id']);

  // Delete the record from the database
  $delete_query = "DELETE FROM SUPPLIERS WHERE Sup_ID='$sup_id'";
  //mysqli_query($conn, $delete_query);
  if (mysqli_query($conn, $delete_query)) {
	// Record updated successfully
	echo "<center><h2>Record Deleated successfully</center></h2>";
	} else {
	echo "<center><h2>Error deleting record: " . mysqli_error($conn)."</center></h2>";
  }
}

// Select all records from the SUPPLIERS table
$select_query = "SELECT * FROM SUPPLIERS";
$result = mysqli_query($conn, $select_query);

// Close the connection
?>

<table>
  <tr>
    <th>Supplier ID</th>
    <th>Supplier Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Address</th>
    <th>Actions</th>
  </tr>
  <?php while ($row = mysqli_fetch_assoc($result)) { ?>
  <tr>
    <td><?php echo $row['Sup_ID']; ?></td>
    <td><?php echo $row['Sup_Name']; ?></td>
    <td><?php echo $row['Sup_Mail']; ?></td>
    <td><?php echo $row['Sup_Phone']; ?></td>
    <td><?php echo $row['Sup_Add']; ?></td>
    <td>
      <!-- Edit button -->
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <input type="hidden" name="sup_id" value="<?php echo $row['Sup_ID']; ?>">
        <button type="submit" class="btn" name="edit">Edit</button>
      </form>

      <!-- Delete button -->
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <input type="hidden" name="sup_id" value="<?php echo $row['Sup_ID']; ?>">
        <button type="submit" class="btn" name="delete" onclick="return confirm('Are you sure you want to delete this record?');">Delete</button>
      </form>
    </td>
  </tr>
  <?php } 
  
  // Check if the "edit" form was submitted
  if (isset($_POST['edit'])) {
    // Get the record data from the database
    $sup_id = mysqli_real_escape_string($conn, $_POST['sup_id']);
    $select_query = "SELECT * FROM SUPPLIERS WHERE Sup_ID='$sup_id'";
    $result = mysqli_query($conn, $select_query);
    $row = mysqli_fetch_assoc($result);
    $sup_id = $row['Sup_ID'];
    $sup_name = $row['Sup_Name'];
    $sup_mail = $row['Sup_Mail'];
    $sup_phone = $row['Sup_Phone'];
    $sup_add = $row['Sup_Add'];
  }
  
  // Close the connection

  ?>
  </table>
  <!-- Form to add/update a record -->
<br><br>
  <form method="post" id="format" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <!-- Hidden field to store the ID of the record being edited -->
    <input type="hidden" name="sup_id" value="<?php echo $sup_id; ?>">
    <label for="sup_name">Supplier Name:</label><br>
    <input type="text" id="sup_name" name="sup_name" value="<?php echo $sup_name; ?>"><br>
    <label for="sup_mail">Email:</label><br>
    <input type="email" id="sup_mail" name="sup_mail" value="<?php echo $sup_mail; ?>"><br>
    <label for="sup_phone">Phone:</label><br>
    <input type="number" id="sup_phone" name="sup_phone" value="<?php echo $sup_phone; ?>"><br>
    <label for="sup_add">Address:</label><br>
    <input type="text" id="sup_add" name="sup_add" value="<?php echo $sup_add; ?>"><br><br>
    <!-- Submit button -->
    <?php if ($sup_id != "") { ?>
      <!-- Update button when editing a record -->
      <button type="submit" name="save_changes">Update</button>
    <?php } else { ?>
      <!-- Add button when adding a new record -->
      <button type="submit" name="add" style="background-color: #4CAF50;color: white;padding: 10px 20px;margin: 8px 0;border: none;cursor: pointer;width: 100%;">Add</button><br><br>
    <?php } ?>
  </form>

<php  mysqli_close($conn); ?>

</div>

