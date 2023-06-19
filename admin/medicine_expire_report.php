<?php session_start(); /* Starts the session */

if(!isset($_SESSION['UserData']['Username'])){
  header("location:login.php");
  exit;
}
?> 
  <head>
    <title>Medicine Expire < 30 days </title>
  </head>
<?php
  include './sidenav/sidenav.html';
?>
<div class = "rightbox">
<?php
// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "medical");

// Check the connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Select the medicines that are soon to expire (within 30 days)
$sql = "SELECT MEDICINES.Med_ID, MEDICINES.Med_Name, PURCHASE.Exp_Date
        FROM MEDICINES
        INNER JOIN PURCHASE ON MEDICINES.Med_ID = PURCHASE.Med_ID
        WHERE DATEDIFF(PURCHASE.Exp_Date, CURDATE()) <= 30";
$result = mysqli_query($conn, $sql);

// Check if there are any results
if (mysqli_num_rows($result) > 0) {
  // Output the results in a table
  echo "<table>";
  echo "<tr><th>Medicine ID</th><th>Medicine Name</th><th>Expiration Date</th></tr>";
  while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row["Med_ID"] . "</td>";
    echo "<td>" . $row["Med_Name"] . "</td>";
    echo "<td>" . $row["Exp_Date"] . "</td>";
    echo "</tr>";
      }
      echo "</table>";
    } else {
      echo "<center><h2>No soon-to-expire medicines found</center></h2>";
    }
    
    // Close the connection
    mysqli_close($conn);

    ?>
</div>
<style>
table {
  border-collapse: collapse;
  width: 80%;
  margin: 20px auto;
  text-align: center;
}

th, td {
  border: 1px solid #dddddd;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}

th {
  background-color: #4CAF50;
  color: white;
}
form {
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 20px 0;
}

input[type="text"] {
  width: 50%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
  border: 2px solid #ccc;
  border-radius: 4px;
}

button[type="submit"] {
  width: 20%;
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

button[type="submit"]:hover {
  background-color: #45a049;
}

</style>