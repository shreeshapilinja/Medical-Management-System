<?php
session_start();

if(!isset($_SESSION['UserData']['Username'])){
  header("location:login.php");
  exit;
}
?>
<head>
<title>Manage Sales Item</title>
</head>
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
$med_id = "";
$sale_qty = "";
$tot_price = "";


// Save changes when form is submitted
if (isset($_POST['save_changes'])) {
  $s_id = mysqli_real_escape_string($conn, $_POST['s_id']);
  $med_id = mysqli_real_escape_string($conn, $_POST['med_id']);
  $sale_qty = mysqli_real_escape_string($conn, $_POST['sale_qty']);
  $tot_price = mysqli_real_escape_string($conn, $_POST['tot_price']);

  // Update the record in the database
  $update_query = "UPDATE SALES_ITEMS SET Sale_Qty='$sale_qty', Tot_Price='$tot_price' WHERE S_ID='$s_id' AND Med_ID='$med_id'";
  if (mysqli_query($conn, $update_query)) {
    // Record updated successfully
    echo "<center><h2>Record updated successfully</center></h2>";
  } else {
    echo "<center><h2>Error updating record: " . mysqli_error($conn)."</center></h2>";
  }
}

// Delete the record when the form is submitted
if (isset($_POST['delete'])) {
  $s_id = mysqli_real_escape_string($conn, $_POST['s_id']);
  $med_id = mysqli_real_escape_string($conn, $_POST['med_id']);

  // Delete the record from the database
  $delete_query = "DELETE FROM SALES_ITEMS WHERE S_ID='$s_id' AND Med_ID='$med_id'";
  if (mysqli_query($conn, $delete_query)) {
    // Record deleted successfully
    echo "<center><h2>Record deleted successfully</center></h2>";
  } else {
    echo "<center><h2>Error deleting record: " . mysqli_error($conn)."</center></h2>";
  }
}


// if (isset($_POST['action']) && $_POST['action'] == 'edit') {
//   // Get the values of the selected row
//   $s_id = mysqli_real_escape_string($conn, $_POST['s_id']);
//   $med_id = mysqli_real_escape_string($conn, $_POST['med_id']);

//   // Query the database to get the selected row
//   $edit_query = "SELECT * FROM SALES_ITEMS WHERE S_ID='$s_id' AND Med_ID='$med_id'";
//   $edit_result = mysqli_query($conn, $edit_query);
//   $row = mysqli_fetch_assoc($edit_result);
// }



// Select all records from the SALES table, along with the customer name and employee name
$select_query = "SELECT * FROM SALES_ITEMS";
$result = mysqli_query($conn, $select_query);

?>

<table>
  <tr>
    <th>Sale ID</th>
    <th>Medical ID</th>
    <th>Sale Quantity</th>
    <th>Total Price(Rs)</th>
    <th>Actions</th>
  </tr>
  <?php while ($row = mysqli_fetch_assoc($result)) { ?>
  <tr>
    <td><?php echo $row['S_ID']; ?></td>
    <td><?php echo $row['Med_ID']; ?></td>
    <td><?php echo $row['Sale_Qty']; ?></td>
    <td><?php echo $row['Tot_Price']; ?></td>
    <td>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <input type="hidden" name="s_id" value="<?php echo $row['S_ID']; ?>">
        <input type="hidden" name="med_id" value="<?php echo $row['Med_ID']; ?>">
        <button type="submit" class="btn" name="edit">Edit</button>
  </form>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <input type="hidden" name="s_id" value="<?php echo $row['S_ID']; ?>">
        <input type="hidden" name="med_id" value="<?php echo $row['Med_ID']; ?>">
        <button type="submit" class="btn" name="delete" onclick="return confirm('Are you sure you want to delete this record?');">Delete</button>
      </form>
    </td>
  </tr>
  <?php } 
  if (isset($_POST['edit'])) {
    // Get the values of the selected row
    $s_id = mysqli_real_escape_string($conn, $_POST['s_id']);
    $med_id = mysqli_real_escape_string($conn, $_POST['med_id']);
  
    // Query the database to get the selected row
    $edit_query = "SELECT * FROM SALES_ITEMS WHERE S_ID='$s_id' AND Med_ID='$med_id'";
    $edit_result = mysqli_query($conn, $edit_query);
    $row = mysqli_fetch_assoc($edit_result);
  }
  ?>
</table>
<br><br>
<div class = "formbox">
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
 <div class="form-group">
    <label for="Sale_ID">Sale ID</label>
    <input type="text" name="s_id" class="form-control" id="s_id" value="<?php echo isset($row) ? $row['S_ID'] : ''; ?>" required>
  </div>
  <div class="form-group">
    <label for="Med_ID">Medical ID</label>
    <input type="text" name="med_id" class="form-control" id="med_id" value="<?php echo isset($row) ? $row['Med_ID'] : ''; ?>" required>
  </div>
  <div class="form-group">
    <label for="Sale_Qty">Sale Quantity</label>
    <input type="number" name="sale_qty" class="form-control" id="sale_qty" value="<?php echo isset($row) ? $row['Sale_Qty'] : ''; ?>" required>
  </div><br>
  <div class="form-group">
    <label for="Tot_Price">Total Price</label>
    <input type="number" name="tot_price" class="form-control" id="tot_price" value="<?php echo isset($row) ? $row['Tot_Price'] : ''; ?>" required>
  </div>
  <div class="form-group">
  <input type="submit" name="save_changes" value="Save Changes">
</div>
</form> <br><br><br>
</div>
</div>
