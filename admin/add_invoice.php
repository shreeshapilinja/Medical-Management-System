<?php session_start(); /* Starts the session */

if(!isset($_SESSION['UserData']['Username'])){
  header("location:login.php");
  exit;
}
?>
<?php
  include './sidenav/sidenav.html';
?> 
<html>
  <head>
  <head>
    <title>Add Sales/invoice</title>
    <style>
body {
  font-family: Arial, sans-serif;
}

form {
  width: 400px;
  margin: 0 auto;
}

label {
  font-weight: bold;
  display: block;
  margin-bottom: 5px;
}

input[type="text"], input[type="date"], input[type="time"], input[type="number"] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
  border: 1px solid #ccc;
  border-radius: 4px;
}

input[type="submit"] {
  width: 100%;
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type="submit"]:hover {
  background-color: #45a049;
}

table {
  width: 100%;
  border-collapse: collapse;
}

th, td {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: left;
}

th {
  background-color: #f2f2f2;
}

button {
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

button:hover {
  background-color: #45a049;
}
</style>
  </head>
    <script>
      function calculateTotal() {
        // get the table containing the sales items
        var table = document.getElementById("sales_items");
        // initialize total_amt to 0
        var total_amt = 0;

        // iterate through each row of the table
        for (var i = 1, row; row = table.rows[i]; i++) {
          // get the quantity and price cells for the current row
          var qtyCell = row.cells[1];
          var priceCell = row.cells[2];

          // get the quantity and price for the current row
          var qty = qtyCell.getElementsByTagName("input")[0].value;
          var price = priceCell.getElementsByTagName("input")[0].value;

          // calculate the total price for the current row
          var rowTotal = qty * price;

          // update the total price cell for the current row
          priceCell.getElementsByTagName("input")[1].value = rowTotal;

          // add the total price for the current row to the total_amt
          total_amt += rowTotal;
        }

        // update the total_amt input field with the calculated total_amt
        document.getElementById("total_amt").value = total_amt;
      }
    </script>
    <script>
  function validateForm() {
    // get the form inputs
    var sales_id = document.forms["sales_form"]["sales_id"].value;
    var sale_date = document.forms["sales_form"]["sale_date"].value;
    var sale_time = document.forms["sales_form"]["sale_time"].value;
    var customer_id = document.forms["sales_form"]["customer_id"].value;
    var employee_id = document.forms["sales_form"]["employee_id"].value;

    // check if the sales_id is not empty
    if (sales_id == "") {
      alert("Sales ID must be filled out");
      return false;
    }

    // check if the sale_date is not empty
    if (sale_date == "") {
      alert("Sale date must be filled out");
      return false;
    }

    // check if the sale_time is not empty
    if (sale_time == "") {
      alert("Sale time must be filled out");
      return false;
    }

    // check if the customer_id is not empty
    if (customer_id == "") {
      alert("customer id must be filled out");
      return false;
    }

    // check if the employee_id is not empty
    if (employee_id == "") {
      alert("employee id must be filled out");
      return false;
    }

  }
</script>

  </head>
  <body>
  <div class = "rightbox"><br>
  <form method="post" action="" name="sales_form" onsubmit="return validateForm()">
  <script>
if(validateForm()) {
  alert("Total Amount: " + document.getElementById("total_amt").value);
}
  </script>
      Sales ID: <input type="text" name="sales_id" required><br><br>
      Sale Date: <input type="date" name="sale_date" required><br><br>
      Sale Time: <input type="time" name="sale_time" required><br><br>
      Customer ID: <input type="text" name="customer_id" required><br><br>
      Employee ID: <input type="text" name="employee_id" required><br><br>
      <br><br>
      <table id="sales_items" border="1">
        <tr>
          <th>Medicine ID</th>
          <th>Sale Quantity</th>
          <th hidden>Total Price</th>
        </tr>
        <tr>
          <td>
            <input type="text" name="med_id[]" required oninput="calculateTotal()">
          </td>
          <td>
            <input type="number" name="sale_qty[]" required oninput="calculateTotal()">
          </td>
          <td hidden>
            <input type="number" name="tot_price[]" readonly>
          </td>
        </tr>
      </table>
      <br>
      <button type="button" onclick="addRow()">Add Row</button>
      <br><br>
      <!-- Total Amount: --><input type="number" name="total_amt" id="total_amt" readonly hidden>
      <br><br>
      <input type="submit" name="submit" value="Submit">
      </form>
  <script>
    function addRow() {
      // get the table containing the sales items
      var table = document.getElementById("sales_items");

      // create a new row
      var row = table.insertRow(table.rows.length);

      // create new cells for the new row
      var medIdCell = row.insertCell(0);
      var qtyCell = row.insertCell(1);
      var priceCell = row.insertCell(2);

      // add input fields to the new cells
      medIdCell.innerHTML = '<input type="text" name="med_id[]" required oninput="calculateTotal()">';
      qtyCell.innerHTML = '<input type="number" name="sale_qty[]" required oninput="calculateTotal()">';
      priceCell.innerHTML = '<input type="number" name="tot_price[]" readonly hidden>';
    }
  </script>
<center>
<?php
// Create connection
$conn = new mysqli('localhost','root','','medical');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['submit'])){

  $sales_id = $_POST['sales_id'];
  $sale_date = $_POST['sale_date'];
  $sale_time = $_POST['sale_time'];
  $customer_id = $_POST['customer_id'];
  $employee_id = $_POST['employee_id'];

  $medicine_id = $_POST['med_id'];
  $sale_qty = $_POST['sale_qty'];
  $n = count($medicine_id);
  $total_amt = 0;

  for($i=0; $i<$n; $i++){
    //Get price of each medicine
    $med_price_query = "SELECT Med_Price FROM MEDICINES WHERE Med_ID = '$medicine_id[$i]'";
    $med_price_result = mysqli_query($conn, $med_price_query);
    $med_price_row = mysqli_fetch_assoc($med_price_result);
    $med_price = $med_price_row['Med_Price'];
    $tot_price[$i] = $med_price*$sale_qty[$i];
    $total_amt += $tot_price[$i];
  }
  
  // Insert data to the sales table
  $sql_sales = "INSERT INTO SALES (s_id,s_date,s_time,total_amt,c_id,e_id) VALUES ('$sales_id','$sale_date','$sale_time','$total_amt','$customer_id','$employee_id')";

  // Insert data to the sales_items table
  for($i=0; $i<$n; $i++){
    $sql_sales_items = "INSERT INTO SALES_ITEMS (s_id,med_id,sale_qty,tot_price) VALUES ('$sales_id','$medicine_id[$i]','$sale_qty[$i]','$tot_price[$i]')";
  }
  
  // execute the queries
  if(mysqli_query($conn, $sql_sales) && mysqli_query($conn, $sql_sales_items)){
    for($i=0; $i<$n; $i++){
      $med_qty_query = "SELECT Med_Qty FROM MEDICINES WHERE Med_ID = '$medicine_id[$i]'";
      $med_qty_result = mysqli_query($conn, $med_qty_query);
      $med_qty_row = mysqli_fetch_assoc($med_qty_result);
      $med_qty = $med_qty_row['Med_Qty'];
      if($sale_qty[$i] > $med_qty){
        echo "Error: Not enough stock of Medicine ID: $medicine_id[$i]";
        return;
      }
      $updated_qty = $med_qty-$sale_qty[$i];
      $update_med_qty = "UPDATE MEDICINES SET Med_Qty = '$updated_qty' WHERE Med_ID = '$medicine_id[$i]'";
      mysqli_query($conn, $update_med_qty);
    }
    echo "<h1>Data inserted successfully.</h1><script>alert('Total amount in Rs: $total_amt')</script>";
  } else {
    echo "Error: " . $sql_sales . "<br>" . $conn->error;
    echo "Error: " . $sql_sales_items . "<br>" . $conn->error;
  }
  $conn->close();
}
?></center>
</div>

</body>
</html>