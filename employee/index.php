<!DOCTYPE html>
<html>
<head>
  <title>Dashboard for Employees</title>
  <style>
    .count-box {
      display: inline-block;
      background-color: #f1f1f1;
      border: 1px solid #ccc;
      padding: 30px;
      margin: 12px;
      text-align: center;
    }
    .count-label {
      font-size: 20px;
      font-weight: bold;
      margin-bottom: 10px;
    }
    .count-value {
      font-size: 40px;
      font-weight: bold;
    }
  </style>
</head>
<body>
<?php
include './sidenav/sidenav.html';
?>
<div class = "rightbox">
<center><h1>Dashboard For Employees</h1></center>
<?php

// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "medical");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query to count the number of customers in the CUSTOMER table
$query_customers = "SELECT COUNT(*) as total_customers FROM CUSTOMER";
$result_customers = mysqli_query($conn, $query_customers);
$customers = mysqli_fetch_assoc($result_customers);

// Query to count the number of suppliers in the SUPPLIERS table
$query_suppliers = "SELECT COUNT(*) as total_suppliers FROM SUPPLIERS";
$result_suppliers = mysqli_query($conn, $query_suppliers);
$suppliers = mysqli_fetch_assoc($result_suppliers);

// Query to count the number of medicines in the MEDICINES table
$query_medicines = "SELECT COUNT(*) as total_medicines FROM MEDICINES";
$result_medicines = mysqli_query($conn, $query_medicines);
$medicines = mysqli_fetch_assoc($result_medicines);

// Query to count the number of medicines with a quantity of 0 in the MEDICINES table
$query_outofstock = "SELECT COUNT(*) as total_outofstock FROM MEDICINES WHERE Med_Qty < 10";
$result_outofstock = mysqli_query($conn, $query_outofstock);
$outofstock = mysqli_fetch_assoc($result_outofstock);

// Query to count the number of expired medicines in the PURCHASE table
$query_expired = "SELECT COUNT(*) as total_expired FROM PURCHASE WHERE Exp_Date < CURDATE()";
$result_expired = mysqli_query($conn, $query_expired);
$expired = mysqli_fetch_assoc($result_expired);

// Query to count the number of sales in the SALES table
$query_sales = "SELECT COUNT(*) as total_sales FROM SALES";
$result_sales = mysqli_query($conn, $query_sales);
$sales = mysqli_fetch_assoc($result_sales);

// Query to count the number of purchases in the PURCHASE table
$query_purchases = "SELECT COUNT(*) as total_purchases FROM PURCHASE";
$result_purchases = mysqli_query($conn, $query_purchases);
$purchases = mysqli_fetch_assoc($result_purchases);

// Query to calculate the profit by summing the Total_Amt from the SALES table and subtracting the sum of the P_Cost from the PURCHASE table
$query_profit = "SELECT SUM(Total_Amt) - (SELECT SUM(P_Cost) FROM PURCHASE) as total_profit FROM SALES";
$result_profit = mysqli_query($conn, $query_profit);
$profit = mysqli_fetch_assoc($result_profit);

// Query to count the number of sales for today's date in the SALES table
$query_salesc = "SELECT COUNT(*) as total_sales FROM SALES WHERE S_Date = CURDATE()";
$result_salesc = mysqli_query($conn, $query_salesc);
$salesc = mysqli_fetch_assoc($result_salesc);

// Query to count the number of purchases for today's date in the PURCHASE table
$queryc_purchases = "SELECT COUNT(*) as total_purchases FROM PURCHASE WHERE Pur_Date = CURDATE()";
$resultc_purchases = mysqli_query($conn, $queryc_purchases);
$purchasesc = mysqli_fetch_assoc($resultc_purchases);


// Query to count the number of employees in the EMPLOYEE table
$query = "SELECT COUNT(*) as total_employees FROM EMPLOYEE";
$result = mysqli_query($conn, $query);
$employees = mysqli_fetch_assoc($result);

// Close the database connection
?>

<hr>
  <div class="count-box" onclick="window.location.href = './manage_customer.php';">
    <div class="count-label">Total Customers</div>
    <div class="count-value"><?php echo $customers['total_customers']; ?></div>
  </div>
  <div class="count-box" onclick="window.location.href = './manage_medicine.php';">
    <div class="count-label">Total Medicines</div>
    <div class="count-value"><?php echo $medicines['total_medicines']; ?></div>
  </div>
  <div class="count-box" onclick="window.location.href = './low_stock_report.php';">
    <div class="count-label">Low & Out of Stock</div>
    <div class="count-value"><?php echo $outofstock['total_outofstock']; ?></div>
  </div>
  <br>
  <div class="count-box" onclick="window.location.href = './medicine_expire_report.php';">
    <div class="count-label">Expired</div>
    <div class="count-value"><?php echo $expired['total_expired']; ?></div>
  </div>
  <div class="count-box">
    <div class="count-label">Total Sales</div>
    <div class="count-value"><?php echo $sales['total_sales']; ?></div>
  </div>
  <div class="count-box">
    <div class="count-label">Today's Sales</div>
    <div class="count-value"><?php echo $salesc['total_sales']; ?></div>
  </div>
<hr>

  <div class="box" onclick="location.href='add_invoice.php'">
    <img src="./img/sale_icon.png" alt="Create New Sale">
    <p>Create New Sale</p>
  </div>
  <div class="box" onclick="location.href='add_customer.php'">
    <img src="./img/customer_icon.png" alt="Add New Customer">
    <p>Add New Customer</p>
  </div>
<?php mysqli_close($conn); ?>
 <style>
    .box {
      display: inline-block;
      width: 400px;
      height: 250px;
      background-color: #f1f1f1;
      border: 1px solid #ccc;
      margin: 10px;
      text-align: center;
      vertical-align: middle;
      cursor: pointer;
	  align:center;
    }
    .box img {
      width: 60%;
      height: 50%;
      margin: 12px;
    }
    .box p {
      font-size: 18px;
      margin: 10px;
    }
  </style>
</div>
</body>
</html>



