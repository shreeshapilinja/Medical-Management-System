  <head>
    <title>Manage Medicines</title>
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
$med_id = "";
$med_name = "";
$med_qty = "";
$category = "";
$med_price = "";
$location_rack = "";

// Save changes when form is submitted
if (isset($_POST['save_changes'])) {
  $med_id = mysqli_real_escape_string($conn, $_POST['med_id']);
  $med_name = mysqli_real_escape_string($conn, $_POST['med_name']);
  $med_qty = mysqli_real_escape_string($conn, $_POST['med_qty']);
  $category = mysqli_real_escape_string($conn, $_POST['category']);
  $med_price = mysqli_real_escape_string($conn, $_POST['med_price']);
  $location_rack = mysqli_real_escape_string($conn, $_POST['location_rack']);

  // Update the record in the database
  $update_query = "UPDATE MEDICINES SET Med_Name='$med_name', Med_Qty='$med_qty', Category='$category', Med_Price='$med_price', Location_Rack='$location_rack' WHERE Med_ID='$med_id'";
  //mysqli_query($conn, $update_query);
  	if (mysqli_query($conn, $update_query)) {
	// Record updated successfully
	echo "<center><h2>Record updated successfully</center></h2>";
	} else {
	echo "<center><h2>Error updating record: " . mysqli_error($conn)."</center></h2>";
	}
}

// Select all records from the MEDICINES table
$select_query = "SELECT * FROM MEDICINES";
$result = mysqli_query($conn, $select_query);

// Close the connection
?>
 

<table>
  <tr>
    <th>Medicine ID</th>
    <th>Medicine Name</th>
    <th>Quantity</th>
    <th>Category</th>
    <th>Price(Rs)</th>
    <th>Location Rack</th>
    <th>Actions</th>
  </tr>
  <?php while ($row = mysqli_fetch_assoc($result)) { ?>
  <tr>
    <td><?php echo $row['Med_ID']; ?></td>
    <td><?php echo $row['Med_Name']; ?></td>
    <td><?php echo $row['Med_Qty']; ?></td>
    <td><?php echo $row['Category']; ?></td>
    <td><?php echo $row['Med_Price']; ?></td>
    <td><?php echo $row['Location_Rack']; ?></td>
    <td>
      <!-- Edit button -->
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <input type="hidden" name="med_id" value="<?php echo $row['Med_ID']; ?>">
        <button type="submit" class="btn" name="edit">Edit</button>
      </form>
    </td>
  </tr>
  <?php } 
  
  if (isset($_POST['edit'])) {
    $med_id = mysqli_real_escape_string($conn, $_POST['med_id']);
  
    // Retrieve the record's data from the database
    $select_query = "SELECT * FROM MEDICINES WHERE Med_ID='$med_id'";
    $result = mysqli_query($conn, $select_query);
    $row = mysqli_fetch_assoc($result);
  
    // Populate the form fields with the record's data
    $med_id = $row['Med_ID'];
    $med_name = $row['Med_Name'];
    $med_qty = $row['Med_Qty'];
    $category = $row['Category'];
    $med_price = $row['Med_Price'];
    $location_rack = $row['Location_Rack'];
  }  
  ?>
  </table><br><br>
<!-- HTML form for managing medicines -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <div class="form-group">
    <label for="med_id">Medicine ID</label>
    <input type="text" class="form-control" name="med_id" value="<?php echo $med_id; ?>" readonly>
  </div>
  <div class="form-group">
    <label for="med_name">Medicine Name</label>
    <input type="text" class="form-control" name="med_name" value="<?php echo $med_name; ?>" readonly>
  </div>
  <div class="form-group">
    <label for="med_qty">Quantity</label>
    <input type="number" class="form-control" name="med_qty" value="<?php echo $med_qty; ?>">
  </div>
  <div class="form-group" hidden>
    <label for="category">Category</label>
    <input type="text" class="form-control" name="category" value="<?php echo $category; ?>" readonly>
  </div>
  <div class="form-group" hidden>
    <label for="med_price">Price</label>
    <input type="number" class="form-control" name="med_price" value="<?php echo $med_price; ?>" readonly>
  </div>
  <div class="form-group" hidden>
    <label for="location_rack">Location Rack</label>
    <input type="text" class="form-control" name="location_rack" value="<?php echo $location_rack; ?>" readonly >
  </div>
  <button type="submit" class="btn" name="save_changes">Save Changes</button>
</form>
</div><br>
<br>
<style>
  /* Add some styling to the form */
  form {
    max-width: 100%;
    margin: 5px auto;
    border: 1px solid #ddd;
    padding: 10px;
  }

  /* Style the input fields */
  .form-control {
    border: 1px solid #ddd;
    padding: 10px;
    font-size: 16px;
    margin:8px;
  }

  /* Style the submit button */
  button[type="submit"] {
    background-color: #4CAF50;
    color: white;
    font-size: 16px;
    border: none;
    cursor: pointer;
    width: 100%;
    margin-bottom: 10px;
  }

  /* Style the delete button */
  button[name="delete"] {
    background-color: #f44336;
    color: white;
    font-size: 16px;
    border: none;
    cursor: pointer;
    width: 100%;
  }

  /* Style the table */
  table {
    width: 100%;
    border-collapse: collapse;
  }

  /* Style the table cells */
  td, th {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
  }

  /* Style the table headings */
  th {
    background-color: #4CAF50;
    color: white;
  }

  /* Style the 'Edit' and 'Delete' buttons in the table */
  .btn {
    background-color: #f44336;
    border: none;
    color: white;
    cursor: pointer;
    padding: 5px 10px;
    font-size: 14px;
  }
</style>
