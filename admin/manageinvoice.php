<?php session_start(); /* Starts the session */

if(!isset($_SESSION['UserData']['Username'])){
  header("location:login.php");
  exit;
}
?> 
<?php
  include './sidenav/sidenav.html';
?>
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
$s_id = "";
$s_date = "";
$s_time = "";
$total_amt = "";
$c_id = "";
$e_id = "";

// Save changes when form is submitted
if (isset($_POST['save_changes'])) {
  $s_id = mysqli_real_escape_string($conn, $_POST['s_id']);
  $s_date = mysqli_real_escape_string($conn, $_POST['s_date']);
  $s_time = mysqli_real_escape_string($conn, $_POST['s_time']);
  $total_amt = mysqli_real_escape_string($conn, $_POST['total_amt']);
  $c_id = mysqli_real_escape_string($conn, $_POST['c_id']);
  $e_id = mysqli_real_escape_string($conn, $_POST['e_id']);

  // Update the record in the database
  $update_query = "UPDATE SALES SET S_Date='$s_date', S_Time='$s_time', Total_Amt='$total_amt', C_ID='$c_id', E_ID='$e_id' WHERE S_ID='$s_id'";
  mysqli_query($conn, $update_query);
}

// Delete the record when the form is submitted
if (isset($_POST['delete'])) {
  $s_id = mysqli_real_escape_string($conn, $_POST['s_id']);

  // Delete the record from the database
  $delete_query = "DELETE FROM SALES WHERE S_ID='$s_id'";
  mysqli_query($conn, $delete_query);
}

// Select all records from the SALES table
$select_query = "SELECT * FROM SALES";
$result = mysqli_query($conn, $select_query);

// Close the connection
?>
 

<table>
  <tr>
    <th>Sale ID</th>
    <th>Sale Date</th>
    <th>Sale Time</th>
    <th>Total Amount</th>
    <th>Customer ID</th>
    <th>Employee ID</th>
    <th>Actions</th>
  </tr>
  <?php while ($row = mysqli_fetch_assoc($result)) { ?>
  <tr>
    <td><?php echo $row['S_ID']; ?></td>
    <td><?php echo $row['S_Date']; ?></td>
    <td><?php echo $row['S_Time']; ?></td>
  <td><?php echo $row['Total_Amt']; ?></td>
  <td><?php echo $row['C_ID']; ?></td>
  <td><?php echo $row['E_ID']; ?></td>
  <td>
    <!-- Edit button -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      <input type="hidden" name="s_id" value="<?php echo $row['S_ID']; ?>">
      <button type="submit" class="btn" name="edit">Edit</button>
    </form>


    <!-- Delete button -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      <input type="hidden" name="s_id" value="<?php echo $row['S_ID']; ?>">
      <button type="submit" class="btn" name="delete">Delete</button>
    </form>
  </td>
</tr>
<?php } ?>
</table>

<?php
// Initialize variables for the form
$s_id = "";
$s_date = "";
$s_time = "";
$total_amt = "";
$c_id = "";
$e_id = "";

// Edit the record when the form is submitted
if (isset($_POST['edit'])) {
  $s_id = mysqli_real_escape_string($conn, $_POST['s_id']);

  // Select the record from the database
  $select_query = "SELECT * FROM SALES WHERE S_ID='$s_id'";
  $result = mysqli_query($conn, $select_query);
  $row = mysqli_fetch_assoc($result);

  // Initialize variables with the selected values
  $s_id = $row['S_ID'];
  $s_date = $row['S_Date'];
  $s_time = $row['S_Time'];
  $total_amt = $row['Total_Amt'];
  $c_id = $row['C_ID'];
  $e_id = $row['E_ID'];
}


?>

<!-- Form for editing or adding a record -->
<!-- Form for editing or adding a record -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <input type="hidden" name="s_id" value="<?php echo $s_id; ?>">
  <label for="s_date">Sale Date:</label><br>
  <input type="date" name="s_date" value="<?php echo $s_date; ?>"><br>
  <label for="s_time">Sale Time:</label><br>
  <input type="time" name="s_time" value="<?php echo $s_time; ?>"><br>
  <label for="total_amt">Total Amount:</label><br>
  <input type="text" name="total_amt" value="<?php echo $total_amt; ?>"><br>
  <label for="c_id">Customer ID:</label><br>
  <input type="text" name="c_id" value="<?php echo $c_id; ?>"><br>
  <label for="e_id">Employee ID:</label><br>
  <input type="text" name="e_id" value="<?php echo $e_id; ?>"><br><br>
  <button type="submit" class="btn" name="save_changes">Save Changes</button>
</form> 

</div>

