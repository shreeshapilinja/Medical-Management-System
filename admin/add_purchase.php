<?php session_start(); /* Starts the session */

if(!isset($_SESSION['UserData']['Username'])){
  header("location:login.php");
  exit;
}
?> 
  <head>
    <title>Add Purchase</title>
  </head>
<link rel="stylesheet" href="add.css" type="text/css">
<?php
  include './sidenav/sidenav.html';
?>
<div class = "rightbox">
<form action="add_purchase.php" method="post">
  <label for="P_ID">Purchase ID:</label><br>
  <input type="text" id="P_ID" name="P_ID"><br>
  <label for="Med_ID">Medicine ID:</label><br>
  <input type="text" id="Med_ID" name="Med_ID"><br>
  <label for="Sup_ID">Supplier ID:</label><br>
  <input type="text" id="Sup_ID" name="Sup_ID"><br>
  <label for="Pur_Date">Purchase Date:</label><br>
  <input type="date" id="Pur_Date" name="Pur_Date"><br>
  <label for="Mfg_Date">Manufacture Date:</label><br>
  <input type="date" id="Mfg_Date" name="Mfg_Date"><br>
  <label for="Exp_Date">Expiry Date:</label><br>
  <input type="date" id="Exp_Date" name="Exp_Date"><br>
  <label for="P_Qty">Quantity:</label><br>
  <input type="number" id="P_Qty" name="P_Qty"><br>
  <label for="P_Cost">Cost:</label><br>
  <input type="number" id="P_Cost" name="P_Cost"><br><br>
  <input type="submit" value="Submit">
</form> 

<?php

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the form data
  $P_ID = $_POST["P_ID"];
  $Med_ID = $_POST["Med_ID"];
  $Sup_ID = $_POST["Sup_ID"];
  $Pur_Date = $_POST["Pur_Date"];
  $Mfg_Date = $_POST["Mfg_Date"];
  $Exp_Date = $_POST["Exp_Date"];
  $P_Qty = $_POST["P_Qty"];
  $P_Cost = $_POST["P_Cost"];

  // Validate the form data
  $error_msg = "";
  if (empty($P_ID)) {
    $error_msg .= "Purchase ID is required<br>";
  }
  if (empty($Med_ID)) {
    $error_msg .= "Medicine ID is required<br>";
  }
  if (empty($Sup_ID)) {
    $error_msg .= "Supplier ID is required<br>";
  }
  if (empty($Pur_Date)) {
    $error_msg .= "Purchase date is required<br>";
  }
  if (empty($Mfg_Date)) {
    $error_msg .= "Manufacture date is required<br>";
  }
  if (empty($Exp_Date)) {
    $error_msg .= "Expiry date is required<br>";
  }
  if (empty($P_Qty)) {
    $error_msg .= "Quantity is required<br>";
  } elseif (!is_numeric($P_Qty)) {
    $error_msg .= "Quantity must be a number<br>";
  }
  if (empty($P_Cost)) {
    $error_msg .= "Cost is required<br>";
  } elseif (!is_numeric($P_Cost)) {
    $error_msg .= "Cost must be a number<br>";
  }

// If there are no errors, insert the new purchase into the database
if (empty($error_msg)) {
  // Connect to the database
  $conn = mysqli_connect("localhost", "root", "", "medical");

  // Check the connection
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  // Insert the new purchase into the database
  $sql = "INSERT INTO PURCHASE (P_ID, Med_ID, Sup_ID, Pur_Date, Mfg_Date, Exp_Date, P_Qty, P_Cost)
  VALUES ('$P_ID', '$Med_ID', '$Sup_ID', '$Pur_Date', '$Mfg_Date', '$Exp_Date', '$P_Qty', '$P_Cost')";
if (mysqli_query($conn, $sql)) {
echo "<center><h2>New purchase added successfully</center></h2>";
} else {
echo "<center><h2>Error: " . $sql . "<br>" . mysqli_error($conn)."</center></h2>";
}

// Close the connection
mysqli_close($conn);
}
}
?>
</div>