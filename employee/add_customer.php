<link rel="stylesheet" href="add.css" type="text/css">
<?php
  include './sidenav/sidenav.html';
?>
  <head>
    <title>Add Customers </title>
  </head>
<div class = "rightbox">
<form action="add_customer.php" method="post">
  <label for="C_ID">Customer ID:</label><br>
  <input type="text" id="C_ID" name="C_ID"><br>
  <label for="C_Fname">First Name:</label><br>
  <input type="text" id="C_Fname" name="C_Fname"><br>
  <label for="C_Lname">Last Name:</label><br>
  <input type="text" id="C_Lname" name="C_Lname"><br>
  <label for="C_Address">Address:</label><br>
  <input type="text" id="C_Address" name="C_Address"><br>
  <label for="C_Age">Age:</label><br>
  <input type="text" id="C_Age" name="C_Age"><br>
  <label for="C_Sex">Sex:</label><br>
  <input type="text" id="C_Sex" name="C_Sex"><br>
  <label for="C_Phone">Phone Number:</label><br>
  <input type="text" id="C_Phone" name="C_Phone"><br>
  <label for="C_Mail">Email:</label><br>
  <input type="text" id="C_Mail" name="C_Mail"><br><br>
  <input type="submit" value="Submit">
</form> 
<center>
<?php
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the form data
  $C_ID = $_POST["C_ID"];
  $C_Fname = $_POST["C_Fname"];
  $C_Lname = $_POST["C_Lname"];
  $C_Address = $_POST["C_Address"];
  $C_Age = $_POST["C_Age"];
  $C_Sex = $_POST["C_Sex"];
  $C_Phone = $_POST["C_Phone"];
  $C_Mail = $_POST["C_Mail"];

  // Validate the form data
  $error_msg = "";
  if (empty($C_ID)) {
    $error_msg .= "Customer ID is required<br>";
  }
  if (empty($C_Fname)) {
    $error_msg .= "First name is required<br>";
  }
  if (empty($C_Lname)) {
    $error_msg .= "Last name is required<br>";
  }
  if (empty($C_Address)) {
    $error_msg .= "Address is required<br>";
  }
  if (empty($C_Age)) {
    $error_msg .= "Age is required<br>";
  } elseif (!is_numeric($C_Age)) {
    $error_msg .= "Age must be a number<br>";
  }
  if (empty($C_Sex)) {
    $error_msg .= "Sex is required<br>";
  }
  if (empty($C_Phone)) {
    $error_msg .= "Phone number is required<br>";
  } elseif (!is_numeric($C_Phone)) {
    $error_msg .= "Phone number must be a number<br>";
  }
  if (empty($C_Mail)) {
    $error_msg .= "Email is required<br>";
  } elseif (!filter_var($C_Mail, FILTER_VALIDATE_EMAIL)) {
    $error_msg .= "Invalid email format<br>";
  }

// If there are no errors, insert the new customer into the database
  if (empty($error_msg)) {
    // Connect to the database
    $conn = mysqli_connect("localhost", "root", "", "medical");

    // Check the connection
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }
	
// Check if the stored procedure exists
$procedure_exists = false;
$result = mysqli_query($conn, "SHOW PROCEDURE STATUS WHERE Db = 'medical' AND Name = 'add_customer'");
while ($row = mysqli_fetch_array($result)) {
  $procedure_exists = true;
}

// Create the stored procedure if it doesn't exist
if (!$procedure_exists) {
  $sql = "CREATE PROCEDURE add_customer(
    IN C_ID VARCHAR(6),
    IN C_Fname VARCHAR(30),
    IN C_Lname VARCHAR(30),
    IN C_Address VARCHAR(30),
    IN C_Age INT(11),
    IN C_Sex VARCHAR(6),
    IN C_Phone DECIMAL(10,0),
    IN C_Mail VARCHAR(40)
  )
  BEGIN
    INSERT INTO CUSTOMER (C_ID, C_Fname, C_Lname, C_Address, C_Age, C_Sex, C_Phone, C_Mail)
    VALUES (C_ID, C_Fname, C_Lname, C_Address, C_Age, C_Sex, C_Phone, C_Mail);
  END";
  mysqli_query($conn, $sql);
}

    // Insert the new customer into the database
    $sql = "CALL add_customer('$C_ID', '$C_Fname', '$C_Lname', '$C_Address', '$C_Age', '$C_Sex', '$C_Phone', '$C_Mail')";
    if (mysqli_query($conn, $sql)) {
      echo "<center><h2>New customer added successfully</center></h2>";
    } else {
      echo "<center><h2>Error adding new customer: " . $sql . "<br>" . mysqli_error($conn)."</center></h2>";
    }

    // Close the connection
    mysqli_close($conn);
}
}
?>
</center>
</div>
<!-- <style>
form {
  width: 400px;
  margin: 0 auto;
  text-align: left;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

label {
  display: block;
  margin-bottom: 8px;
}

input[type="text"], input[type="number"] {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  margin-bottom: 16px;
  resize: vertical;
}

input[type="submit"] {
  background-color: #4CAF50;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type="submit"]:hover {
  background-color: #45a049;
}
</style> -->