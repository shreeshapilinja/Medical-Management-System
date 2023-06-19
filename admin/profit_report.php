<?php session_start(); /* Starts the session */

if(!isset($_SESSION['UserData']['Username'])){
  header("location:login.php");
  exit;
}
?> 
  <head>
    <title>Profit report</title>
  </head>
<?php
  include './sidenav/sidenav.html';
?>
<div class = "rightbox">
<?php
// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "medical");

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}

$result_sales = mysqli_query($conn, "SELECT SUM(Total_Amt) as total_sales FROM SALES");
$result_purchase = mysqli_query($conn, "SELECT SUM(P_Cost) as total_purchase FROM PURCHASE");

if (!$result_sales || !$result_purchase) {
  echo "Error executing query: " . mysqli_error($conn);
  exit();
}

// Fetch the result row
$row_sales = mysqli_fetch_assoc($result_sales);
$row_purchase = mysqli_fetch_assoc($result_purchase);

// Assign the values
$total_sales = $row_sales['total_sales'];
$total_purchase = $row_purchase['total_purchase'];

// Calculate the profit
$total_profit = $total_sales - $total_purchase;

// Generate HTML table to display the report
echo "<table>";
echo "<tr><th>Total Sales in Rs</th><th>Total Purchase in Rs</th><th>Total Profit in Rs</th></tr>";
echo "<tr><td>" . $total_sales . "</td><td>" . $total_purchase . "</td><td>" . $total_profit . "</td></tr>";
echo "</table>";


?>

</div>
<style>
table {
  border-collapse: collapse;
  width: 80%;
  margin: 20px auto;
}

th, td {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: left;
}

tr:nth-child(even) {
  background-color: #f2f2f2;
}

th {
  background-color: #4caf50;
  color: white;
}

</style>