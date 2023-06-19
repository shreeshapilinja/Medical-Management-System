<?php session_start(); /* Starts the session */

if(!isset($_SESSION['UserData']['Username'])){
  header("location:login.php");
  exit;
}
?> 
  <head>
    <title>Sales report</title>
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

// Select all records from the SALES table
$select_query = "SELECT * FROM SALES";
$result = mysqli_query($conn, $select_query);

// Close the connection
?>

<h2>Sales Report</h2>
<table>
  <tr>
    <th>Sale ID</th>
    <th>Sale Date</th>
    <th>Sale Time</th>
    <th>Total Amount</th>
    <th>Customer ID</th>
    <th>Employee ID</th>
  </tr>
  <?php $total_sales = 0;
  while ($row = mysqli_fetch_assoc($result)) { ?>
  <tr>
    <td><?php echo $row['S_ID']; ?></td>
    <td><?php echo $row['S_Date']; ?></td>
    <td><?php echo $row['S_Time']; ?></td>
    <td><?php echo $row['Total_Amt']; ?></td>
    <td><?php echo $row['C_ID']; ?></td>
    <td><?php echo $row['E_ID']; ?></td>
  </tr>
  <?php $total_sales += $row['Total_Amt']; } ?>
</table>
<h1 style="color:red;"><center>
<?php
  echo "Total Sales: Rs:" . $total_sales;
  ?>
</h1></center>
</div>
