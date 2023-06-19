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
$p_id = "";
$med_id = "";
$sup_id = "";
$pur_date = "";
$mfg_date = "";
$exp_date = "";
$p_qty = "";
$p_cost = "";

// Save changes when form is submitted
if (isset($_POST['save_changes'])) {
  $p_id = mysqli_real_escape_string($conn, $_POST['p_id']);
  $med_id = mysqli_real_escape_string($conn, $_POST['med_id']);
  $sup_id = mysqli_real_escape_string($conn, $_POST['sup_id']);
  $pur_date = mysqli_real_escape_string($conn, $_POST['pur_date']);
  $mfg_date = mysqli_real_escape_string($conn, $_POST['mfg_date']);
  $exp_date = mysqli_real_escape_string($conn, $_POST['exp_date']);
  $p_qty = mysqli_real_escape_string($conn, $_POST['p_qty']);
  $p_cost = mysqli_real_escape_string($conn, $_POST['p_cost']);

  // Update the record in the database
  $update_query = "UPDATE PURCHASE SET Med_ID='$med_id', Sup_ID='$sup_id', Pur_Date='$pur_date', Mfg_Date='$mfg_date', Exp_Date='$exp_date', P_Qty='$p_qty', P_Cost='$p_cost' WHERE P_ID='$p_id'";
  mysqli_query($conn, $update_query);
}

// Delete the record when the form is submitted
if (isset($_POST['delete'])) {
  $p_id = mysqli_real_escape_string($conn, $_POST['p_id']);
  $med_id = mysqli_real_escape_string($conn, $_POST['med_id']);

  // Delete the record from the database
  $delete_query = "DELETE FROM PURCHASE WHERE P_ID='$p_id' AND Med_ID='$med_id'";
  mysqli_query($conn,$delete_query);                        
}

// Select all records from the PURCHASE table
$select_query = "SELECT P.P_ID, M.Med_Name, S.Sup_Name, P.Pur_Date, P.Mfg_Date, P.Exp_Date, P.P_Qty, P.P_Cost FROM PURCHASE P INNER JOIN MEDICINES M ON P.Med_ID=M.Med_ID INNER JOIN SUPPLIERS S ON P.Sup_ID=S.Sup_ID";
$result = mysqli_query($conn, $select_query);
?>

<table>
  <tr>
    <th>Purchase ID</th>
    <th>Medicine Name</th>
    <th>Supplier Name</th>
    <th>Purchase Date</th>
    <th>Manufacture Date</th>
    <th>Expiry Date</th>
    <th>Quantity</th>
    <th>Cost</th>
    <th>Actions</th>
  </tr>
  <?php while ($row = mysqli_fetch_assoc($result)) { ?>
  <tr>
    <td><?php echo $row['P_ID']; ?></td>
    <td><?php echo $row['Med_Name']; ?></td>
    <td><?php echo $row['Sup_Name']; ?></td>
    <td><?php echo $row['Pur_Date']; ?></td>
    <td><?php echo $row['Mfg_Date']; ?></td>
    <td><?php echo $row['Exp_Date']; ?></td>
    <td><?php echo $row['P_Qty']; ?></td>
    <td><?php echo $row['P_Cost']; ?></td>
    <td>
      <!-- Edit button -->
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <input type="hidden" name="p_id" value="<?php echo $row['P_ID']; ?>">
        <input type="hidden" name="med_id" value="<?php echo $row['Med_ID']; ?>">
        <input type="submit" name="save_changes" value="Edit">
      </form>
       <!-- Delete button -->
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <input type="hidden" name="p_id" value="<?php echo $row['P_ID']; ?>">
        <input type="hidden" name="med_id" value="<?php echo $row['Med_ID']; ?>">
        <input type="submit" name="delete" value="Delete" onclick="return confirm('Are you sure you want to delete this record?');">
      </form>
    </td>
  </tr>
  <?php } 
 if (isset($_POST['edit'])) {
  // Retrieve the record's data from the database
  $p_id = mysqli_real_escape_string($conn, $_POST['p_id']);
  $med_id = mysqli_real_escape_string($conn, $_POST['med_id']);
  $select_query = "SELECT * FROM PURCHASE WHERE P_ID='$p_id' AND Med_ID='$med_id'";
  $result = mysqli_query($conn, $select_query);
  $row = mysqli_fetch_assoc($result);

  // Populate the form fields with the record's data
  $p_id = $row['P_ID'];
  $med_id = $row['Med_ID'];
  $sup_id = $row['Sup_ID'];
  $pur_date = $row['Pur_Date'];
  $mfg_date = $row['Mfg_Date'];
  $exp_date = $row['Exp_Date'];
  $p_qty = $row['P_Qty'];
  $p_cost = $row['P_Cost'];
}
  
  ?>
</table>
<!-- HTML form for editing purchasing medicines -->
<!-- HTML form for editing purchasing medicines -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <div class="form-group">
    <label for="p_id">Purchase ID</label>
    <input type="text" class="form-control" name="p_id" value="<?php echo $p_id; ?>" readonly>
  </div>
  <div class="form-group">
    <label for="med_id">Medicine ID</label>
    <input type="text" class="form-control" name="med_id" value="<?php echo $med_id; ?>" readonly>
  </div>
  <div class="form-group">
    <label for="sup_id">Supplier ID</label>
    <input type="text" class="form-control" name="sup_id" value="<?php echo $sup_id; ?>" readonly>
  </div>
  <div class="form-group">
    <label for="pur_date">Purchase Date</label>
    <input type="date" class="form-control" name="pur_date" value="<?php echo $pur_date; ?>" required>
  </div>
  <div class="form-group">
    <label for="mfg_date">Manufacturing Date</label>
    <input type="date" class="form-control" name="mfg_date" value="<?php echo $mfg_date; ?>" required>
  </div>
  <div class="form-group">
    <label for="exp_date">Expiry Date</label>
    <input type="date" class="form-control" name="exp_date" value="<?php echo $exp_date; ?>" required>
  </div>
  <div class="form-group">
    <label for="p_qty">Quantity</label>
    <input type="number" class="form-control" name="p_qty" value="<?php echo $p_qty; ?>" required>
  </div>
  <div class="form-group">
    <label for="p_cost">Cost</label>
    <input type="number" class="form-control" name="p_cost" value="<?php echo $p_cost; ?>" required>
  </div>
  <button type="submit" class="btn" name="save_changes">Save Changes</button>
</form>

</div>
