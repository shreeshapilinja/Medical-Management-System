<?php session_start(); /* Starts the session */

if(!isset($_SESSION['UserData']['Username'])){
  header("location:login.php");
  exit;
}
?> 
  <head>
    <title>Add Employees</title>
  </head>
<link rel="stylesheet" href="add.css" type="text/css">
<?php
  include './sidenav/sidenav.html';
?>

<div class = "rightbox">
<form action="add_employee.php" method="post">
  <label for="E_ID">Employee ID:</label><br>
  <input type="text" id="E_ID" name="E_ID"><br>
  <label for="E_Name">Employee Name:</label><br>
  <input type="text" id="E_Name" name="E_Name"><br>
  <label for="E_Mail">Email:</label><br>
  <input type="text" id="E_Mail" name="E_Mail"><br>
  <label for="E_Phone">Phone Number:</label><br>
  <input type="text" id="E_Phone" name="E_Phone"><br>
  <label for="E_Role">Role:</label><br>
  <select id="E_Role" name="E_Role">
    <option value="Manager">Manager</option>
    <option value="Clerk">Clerk</option>
  </select><br>
  <label for="E_Bdate">Birth Date:</label><br>
  <input type="date" id="E_Bdate" name="E_Bdate"><br>
  <label for="E_Type">Type:</label><br>
  <select id="E_Type" name="E_Type">
    <option value="Part-Time">Part-Time</option>
    <option value="Full-Time">Full-Time</option>
  </select><br>
  <label for="E_Jdate">Join Date:</label><br>
  <input type="date" id="E_Jdate" name="E_Jdate"><br>
  <label for="E_Sex">Sex:</label><br>
  <input type="text" id="E_Sex" name="E_Sex" value="Male"><br>
  <label for="E_Salary">Salary:</label><br>
  <input type="text" id="E_Salary" name="E_Salary" value="0"><br>
  <label for="E_Add">Address:</label><br>
  <input type="text" id="E_Add" name="E_Add" value=""><br><br>
  <input type="submit" value="Submit">
</form> 


<?php

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the form data
  $E_ID = $_POST["E_ID"];
  $E_Name = $_POST["E_Name"];
  $E_Mail = $_POST["E_Mail"];
  $E_Phone = $_POST["E_Phone"];
  $E_Role = $_POST["E_Role"];
  $E_Bdate = $_POST["E_Bdate"];
  $E_Type = $_POST["E_Type"];
  $E_Jdate = $_POST["E_Jdate"];
  $E_Sex = $_POST["E_Sex"];
  $E_Salary = $_POST["E_Salary"];
  $E_Add = $_POST["E_Add"];

  // Validate the form data
  $error_msg = "";
  if (empty($E_ID)) {
    $error_msg .= "Employee ID is required<br>";
  }
  if (empty($E_Name)) {
    $error_msg .= "Name is required<br>";
  }
  if (empty($E_Mail)) {
    $error_msg .= "Email is required<br>";
  } elseif (!filter_var($E_Mail, FILTER_VALIDATE_EMAIL)) {
    $error_msg .= "Invalid email format<br>";
  }
  if (empty($E_Phone)) {
    $error_msg .= "Phone number is required<br>";
  } elseif (!is_numeric($E_Phone)) {
    $error_msg .= "Phone number must be a number<br>";
  }
  if (empty($E_Role)) {
    $error_msg .= "Role is required<br>";
  }
  if (empty($E_Bdate)) {
    $error_msg .= "Birth date is required<br>";
  }
  if (empty($E_Type)) {
    $error_msg .= "Type is required<br>";
  }
  if (empty($E_Jdate)) {
    $error_msg .= "Join date is required<br>";
  }
  if (empty($E_Sex)) {
    $error_msg .= "Sex is required<br>";
  }
  if (empty($E_Salary)) {
    $error_msg .= "Salary is required<br>";
  } elseif (!is_numeric($E_Salary)) {
    $error_msg .= "Salary must be a number<br>";
  }
  if (empty($E_Add)) {
    $error_msg .= "Address is required<br>";
  }

  if (empty($error_msg)) {
  // Connect to the database
  $conn = mysqli_connect("localhost", "root", "", "medical");

  // Check the connection
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  // Insert the new employee into the database
  $sql = "INSERT INTO EMPLOYEE (E_ID, E_Name, E_Mail, E_Phone, E_Role, E_Bdate, E_Type, E_Jdate, E_Sex, E_Salary, E_Add)
          VALUES ('$E_ID', '$E_Name', '$E_Mail', '$E_Phone', '$E_Role', '$E_Bdate', '$E_Type', '$E_Jdate', '$E_Sex', '$E_Salary', '$E_Add')";
  if (mysqli_query($conn, $sql)) {
    echo "<center><h2>New employee added successfully</center></h2>";
  } else {
    echo "<center><h2>Error: " . $sql . "<br>" . mysqli_error($conn)."</center></h2>";
  }

  // Close the connection
  mysqli_close($conn);
}
}
?>
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