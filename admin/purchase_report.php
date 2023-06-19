<?php session_start(); /* Starts the session */

if(!isset($_SESSION['UserData']['Username'])){
  header("location:login.php");
  exit;
}
?> 
<!DOCTYPE html>
<html>
<head>
  <title>Purchase Report</title>
  <style>
    table {
      border-collapse: collapse;
      width: 100%;
      background-color:yellow ;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 8px;
      text-align: left;
    }
    th {
      background-color: #f1f1f1;
      font-weight: bold;
    }
  </style>
</head>
<body>
<?php
include './sidenav/sidenav.html';
?>
<div class = "rightbox">


 <center> <h1>Purchase Report</h1></center>
<?php

// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "medical");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query to select all purchases from the PURCHASE table
$query = "SELECT * FROM PURCHASE";
$result = mysqli_query($conn, $query);

// Query to calculate the total purchase cost by summing the P_Cost from the PURCHASE table
$query_total = "SELECT SUM(P_Cost) as total_cost FROM PURCHASE";
$result_total = mysqli_query($conn, $query_total);
$total = mysqli_fetch_assoc($result_total);

?>


  <table>
    <tr>
      <th>Purchase ID</th>
      <th>Medicine ID</th>
      <th>Supplier ID</th>
      <th>Purchase Date</th>
      <th>Manufacture Date</th>
      <th>Expiration Date</th>
      <th>Quantity</th>
      <th>Cost</th>
    </tr>
    <?php while($purchase = mysqli_fetch_assoc($result)) { ?>
      <tr>
        <td><?php echo $purchase['P_ID']; ?></td>
        <td><?php echo $purchase['Med_ID']; ?></td>
        <td><?php echo $purchase['Sup_ID']; ?></td>
        <td><?php echo $purchase['Pur_Date'];?></td>
        <td><?php echo $purchase['Mfg_Date']; ?></td>
        <td><?php echo $purchase['Exp_Date']; ?></td>
        <td><?php echo $purchase['P_Qty']; ?></td>
        <td><?php echo $purchase['P_Cost']; ?></td>
      </tr>
    <?php } ?>
    <tr>
      <td colspan="7" style="text-align: right;">Total Cost in Rs:</td>
      <td><?php echo $total['total_cost']; ?></td>
    </tr>
  </table>

</div>
</body>
</html>
