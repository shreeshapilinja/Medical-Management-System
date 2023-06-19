<!DOCTYPE html>
<html>
<head>
  <title>Sales log</title>
</head>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
.sales-table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

.sales-table td, .sales-table th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

.sales-table tr:nth-child(even) {
  background-color: #dddddd;
}

</style>
<body>
<?php
include './sidenav/sidenav.html';
?>
<div class = "rightbox">
<!-- Display the table -->
<table class="sales-table">
  <tr>
    <th>S_ID</th>
    <th>C_ID</th>
    <th>E_ID</th>
    <th>S_Date</th>
    <th>S_Time</th>
    <th>Total_Amt</th>
  </tr>
  <?php
  // Connect to the database
  $conn = mysqli_connect("localhost", "root", "", "medical");

  // Check the connection
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }
  
  // Select all rows from the sales_log table
  $sql = "SELECT * FROM sales_log";
  $result = mysqli_query($conn, $sql);

  // If there are rows, output the data for each row
  if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      echo "<tr>";
      echo "<td>" . $row["S_ID"] . "</td>";
      echo "<td>" . $row["C_ID"] . "</td>";
      echo "<td>" . $row["E_ID"] . "</td>";
      echo "<td>" . $row["S_Date"] . "</td>";
      echo "<td>" . $row["S_Time"] . "</td>";
      echo "<td>" . $row["Total_Amt"] . "</td>";
      echo "</tr>";
    }
  } else {
    echo "0 results";
  }

  ?>
</table>
</div>
</body>
</html>