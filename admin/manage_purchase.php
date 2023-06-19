<?php session_start(); /* Starts the session */

if(!isset($_SESSION['UserData']['Username'])){
  header("location:login.php");
  exit;
}
?> 
  <head>
    <title>Manage Purchase</title>
  </head>
<?php
  include './sidenav/sidenav.html';
?>
<link rel="stylesheet" href="manage.css" type="text/css">
<div class = "rightbox"><br>
<?php

// Connect to MySQL database
$host = "localhost";
$user = "root";
$password = "";
$dbname = "medical";

$conn = mysqli_connect($host, $user, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Handle delete action

// Retrieve records from PURCHASE table
$sql = "SELECT * FROM PURCHASE";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  // Output data in HTML table
  echo "<table>";
  echo "<tr><th>Purchase ID</th><th>Medicine ID</th><th>Supplier ID</th><th>Purchase Date</th><th>Manufacturing Date</th><th>Expiry Date</th><th>Quantity</th><th>Cost</th><th>Actions</th></tr>";
  while($row = mysqli_fetch_assoc($result)) {
    $purchase_id = $row['P_ID'];
    echo "<tr>";
    echo "<td>" . $row['P_ID'] . "</td>";
    echo "<td>" . $row['Med_ID'] . "</td>";
    echo "<td>". $row['Sup_ID'] . "</td>";
echo "<td>" . $row['Pur_Date'] . "</td>";
echo "<td>" . $row['Mfg_Date'] . "</td>";
echo "<td>" . $row['Exp_Date'] . "</td>";
echo "<td>" . $row['P_Qty'] . "</td>";
echo "<td>" . $row['P_Cost'] . "</td>";
echo "<td>
<form method='get' action='manage_purchase.php?edit=true'>
<input type='hidden' name='purchase_id' value='$purchase_id'>
<input type='submit' name='edit' value='edit'>
</form>

<a href='manage_purchase.php?delete=$purchase_id'><button style='background-color: #4CAF50;color: white;padding: 12px 20px;'>Delete</button></a>
</td>";
echo "</tr>";
}
echo "</table>";
} else {
echo "No records found";
}

if (isset($_GET['edit'])) {
$purchase_id = $_GET['purchase_id'];

$sql = "SELECT * FROM PURCHASE WHERE P_ID = '$purchase_id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
$row = mysqli_fetch_assoc($result);
$purchase_id = $row['P_ID'];
$med_id = $row['Med_ID'];
$sup_id = $row['Sup_ID'];
$pur_date = $row['Pur_Date'];
$mfg_date = $row['Mfg_Date'];
$exp_date = $row['Exp_Date'];
$p_qty = $row['P_Qty'];
$p_cost = $row['P_Cost'];
} else {
echo "No records found";
}
}

if (isset($_GET['delete'])) {
$purchase_id = $_GET['delete'];

// Confirm delete
if (isset($_GET['confirm'])) {
// Delete record from PURCHASE table
$sql = "DELETE FROM PURCHASE WHERE P_ID = '$purchase_id'";
if (mysqli_query($conn, $sql)) {
// Record deleted successfully
echo "<center><h2>Record deleted successfully</center></h2>";
} else {
echo "<center><h2>Error deleting record: " . mysqli_error($conn)."<center><h2>";
}
} else {
// Display delete confirmation message
echo "<center><h2>Are you sure you want to delete this record?</center></h2>";
echo "<center><h1><a href='manage_purchase.php?delete=$purchase_id&confirm=true'>Yes</a> | <a href='manage_purchase.php'>No</a></h1></center>";
exit;
}
}



// Update record in PURCHASE table
if (isset($_POST['update'])) {
$purchase_id = $_POST['purchase_id'];
$med_id = $_POST['med_id'];
$sup_id = $_POST['sup_id'];
$pur_date = $_POST['pur_date'];
$mfg_date = $_POST['mfg_date'];
$exp_date = $_POST['exp_date'];
$p_qty = $_POST['p_qty'];
$p_cost = $_POST['p_cost'];

$sql = "UPDATE PURCHASE SET Med_ID = '$med_id', Sup_ID = '$sup_id', Pur_Date = '$pur_date', Mfg_Date = '$mfg_date', Exp_Date = '$exp_date', P_Qty = '$p_qty', P_Cost = '$p_cost' WHERE P_ID = '$purchase_id'";
if (mysqli_query($conn, $sql)) {
// Record updated successfully
echo "<center><h2>Record updated successfully</center></h2>";
} else {
echo "<center><h2>Error updating record: " . mysqli_error($conn)."</center></h2>";
}
}
?>
<!-- if (isset($purchase_id)) {
echo $purchase_id;
} else {
echo 'Please click on edit button in top';
}
 -->

<!-- Form to edit a purchase record -->
<center><h3>update Purchase</h3></center>
<form method="post" action="manage_purchase.php">
  <input type="hidden" name="purchase_id" value="<?php echo $purchase_id; ?>">
  <label for="med_id">Medicine ID:</label><br>
  <input type="text" id="med_id" name="med_id" value="<?php if (isset($med_id)) { echo $med_id; } else { echo 'Please click on edit button in top';} ?>"><br>
  <label for="sup_id">Supplier ID:</label><br>
  <input type="text" id="sup_id" name="sup_id" value="<?php if (isset($sup_id)) { echo $sup_id; } else { echo 'Please click on edit button in top'; } ?>"><br>
  <label for="pur_date">Purchase Date:</label><br>
  <input type="text" id="pur_date" name="pur_date" value="<?php if (isset($pur_date)) {  echo $pur_date; } else { echo 'Please click on edit button in top'; } ?>"><br>
  <label for="mfg_date">Manufacturing Date:</label><br>
  <input type="text" id="mfg_date" name="mfg_date" value="<?php if (isset($mfg_date)) { echo $mfg_date; } else { echo 'Please click on edit button in top'; } ?>"><br>
  <label for="exp_date">Expiry Date:</label><br>
  <input type="text" id="exp_date" name="exp_date" value="<?php if (isset($exp_date)) { echo $exp_date; } else { echo 'Please click on edit button in top'; } ?>"><br>
  <label for="p_qty">Quantity:</label><br>
  <input type="text" id="p_qty" name="p_qty" value="<?php if (isset($p_qty)) { echo $p_qty; } else { echo 'Please click on edit button in top'; }  ?>"><br>
  <label for="p_cost">Cost:</label><br>
  <input type="text" id="p_cost" name="p_cost" value="<?php if (isset($p_cost)) {echo $p_cost; } else { echo 'Please click on edit button in top';} ?>"><br><br>
<input type="submit" name="update" value="Update">
</form>
</div>

<?php mysqli_close($conn); ?>

