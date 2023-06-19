<?php session_start(); /* Starts the session */

if(!isset($_SESSION['UserData']['Username'])){
  header("location:login.php");
  exit;
}
?> 
  <head>
    <title>Add medicines</title>
  </head>
<link rel="stylesheet" href="add.css" type="text/css">
<?php
  include './sidenav/sidenav.html';
?>
<div class = "rightbox"><br>
<form action="add_medicine.php" method="post">
  <label for="Med_ID">Medicine ID:</label><br>
  <input type="text" id="Med_ID" name="Med_ID"><br>
  <label for="Med_Name">Name:</label><br>
  <input type="text" id="Med_Name" name="Med_Name"><br>
  <label for="Med_Qty">Quantity:</label>
  <input type="number" id="Med_Qty" name="Med_Qty"><br><br>
  <label for="Category">Category:</label><br>
  <select id="Category" name="Category">
    <option value="Capsule">Capsule</option>
    <option value="Tablet">Tablet</option>
    <option value="Syrup">Syrup</option>
    <option value="Antibiotic">Antibiotic</option>
    <option value="Diabetes">Diabetes</option>
    <option value="Pain Relief">Pain Relief</option>
  </select><br>
  <label for="Med_Price">Price:</label>
  <input type="number" id="Med_Price" name="Med_Price"><br><br>
  <label for="Location_Rack">Location/Rack:</label><br>
  <input type="text" id="Location_Rack" name="Location_Rack"><br><br>
  <input type="submit" value="Submit">
</form> 

<?php

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the form data
  $Med_ID = $_POST["Med_ID"];
  $Med_Name = $_POST["Med_Name"];
  $Med_Qty = $_POST["Med_Qty"];
  $Category = $_POST["Category"];
  $Med_Price = $_POST["Med_Price"];
  $Location_Rack = $_POST["Location_Rack"];

  // Validate the form data
  $error_msg = "";
  if (empty($Med_ID)) {
    $error_msg .= "Medicine ID is required<br>";
  }
  if (empty($Med_Name)) {
    $error_msg .= "Name is required<br>";
  }
  if (empty($Med_Qty)) {
    $error_msg .= "Quantity is required<br>";
  } elseif (!is_numeric($Med_Qty)) {
    $error_msg .= "Quantity must be a number<br>";
  }
  if (empty($Category)) {
    $error_msg .= "Category is required<br>";
  }
  if (empty($Med_Price)) {
    $error_msg .= "Price is required<br>";
  } elseif (!is_numeric($Med_Price)) {
    $error_msg .= "Price must be a number<br>";
  }
  if (empty($Location_Rack)) {
    $error_msg .= "Location/Rack is required<br>";
  }
  
  // If there are no errors, insert the new medicine into the database
  if (empty($error_msg)) {
    // Connect to the database
    $conn = mysqli_connect("localhost", "root", "", "medical");
  
    // Check the connection
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }
  
    // Insert the new medicine into the database
    $sql = "INSERT INTO MEDICINES (Med_ID, Med_Name, Med_Qty, Category, Med_Price, Location_Rack)
            VALUES ('$Med_ID', '$Med_Name', '$Med_Qty', '$Category', '$Med_Price', '$Location_Rack')";
    if (mysqli_query($conn, $sql)) {
      echo "<center><h2>New medicine added successfully</center></h2>";
    } else {
      echo "<center><h2>Error: " . $sql . "<br>" . mysqli_error($conn)."</center></h2>";
    }
  
    // Close the connection
    mysqli_close($conn);
  }
}
?>
</div>