<?php session_start(); /* Starts the session */

if(!isset($_SESSION['UserData']['Username'])){
  header("location:login.php");
  exit;
}
?> 
  <head>
    <title>Add Sales/invoice</title>
  </head>
<link rel="stylesheet" href="add.css" type="text/css">
<?php
  include './sidenav/sidenav.html';
?>
<div class = "rightbox"><br>
<form action="add_invoice.php" method="post">
  <label for="S_ID">Sales ID:</label><br>
  <input type="text" id="S_ID" name="S_ID"><br>
  <label for="S_Date">Date:</label><br>
  <input type="date" id="S_Date" name="S_Date"><br>
  <label for="S_Time">Time:</label><br>
  <input type="time" id="S_Time" name="S_Time"><br><br>
  <label for="Total_Amt">Total Amount:</label>
  <input type="number" id="Total_Amt" name="Total_Amt"><br><br>
  <label for="C_ID">Customer ID:</label><br>
  <input type="text" id="C_ID" name="C_ID"><br>
  <label for="E_ID">Employee ID:</label><br>
  <input type="text" id="E_ID" name="E_ID"><br><br>
  <input type="submit" value="Submit">
</form> 

<?php

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the form data
  $S_ID = $_POST["S_ID"];
  $S_Date = $_POST["S_Date"];
  $S_Time = $_POST["S_Time"];
  $Total_Amt = $_POST["Total_Amt"];
  $C_ID = $_POST["C_ID"];
  $E_ID = $_POST["E_ID"];

  // Validate the form data
  $error_msg = "";
  if (empty($S_ID)) {
    $error_msg .= "Invoice ID is required<br>";
  }
  if (empty($S_Date)) {
    $error_msg .= "Date is required<br>";
  }
  if (empty($S_Time)) {
    $error_msg .= "Time is required<br>";
  }
  if (empty($Total_Amt)) {
    $error_msg .= "Total amount is required<br>";
  } elseif (!is_numeric($Total_Amt)) {
    $error_msg .= "Total amount must be a number<br>";
  }
  if (empty($C_ID)) {
    $error_msg .= "Customer ID is required<br>";
  }
  if (empty($E_ID)) {
    $error_msg .= "Employee ID is required<br>";
  }

// If there are no errors, insert the new invoice into the database
if (empty($error_msg)) {
  // Connect to the database
  $conn = mysqli_connect("localhost", "root", "", "medical");

  // Check the connection
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  // Insert the new invoice into the database
  $sql = "INSERT INTO SALES (S_ID, S_Date, S_Time, Total_Amt, C_ID, E_ID)
          VALUES ('$S_ID', '$S_Date', '$S_Time', '$Total_Amt', '$C_ID', '$E_ID')";
  if (mysqli_query($conn, $sql)) {
    echo "<center><h2>New invoice added successfully</center></h2>";
  } else {
    echo "<center><h2>Error: " . $sql . "<br>" . mysqli_error($conn)."</center></h2>";
  }

  // Close the connection
  mysqli_close($conn);
}
}
?>
</div>