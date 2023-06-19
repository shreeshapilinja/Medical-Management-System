<?php
include './sidenav/sidenav.html';
?>
<div class = "rightbox">
<!-- HTML form with checkboxes for each table and a search input field -->
<form method="post" action="search.php">
  <label for="employee_table">Employee</label>
  <input type="checkbox" name="tables[]" id="employee_table" value="EMPLOYEE">
  <br>
  <label for="customer_table">Customer</label>
  <input type="checkbox" name="tables[]" id="customer_table" value="CUSTOMER">
  <br>
  <label for="sales_table">Sales</label>
  <input type="checkbox" name="tables[]" id="sales_table" value="SALES">
  <br>
  <label for="medicines_table">Medicines</label>
  <input type="checkbox" name="tables[]" id="medicines_table" value="MEDICINES">
  <br>
  <label for="suppliers_table">Suppliers</label>
  <input type="checkbox" name="tables[]" id="suppliers_table" value="SUPPLIERS">
  <br>
  <label for="purchase_table">Purchase</label>
  <input type="checkbox" name="tables[]" id="purchase_table" value="PURCHASE">
  <br>
  <label for="sales_items_table">Sales Items</label>
  <input type="checkbox" name="tables[]" id="sales_items_table" value="SALES_ITEMS">
  <br>
  <label for="search">Search:</label>
  <input type="text" name="search" id="search">
  <br>
  <input type="submit" value="Submit">
</form>

<!-- PHP code to execute SELECT statements for each checked table and display the results -->
<?php
if (isset($_POST['tables']) && isset($_POST['search'])) {
  // Connect to the database
  $conn = mysqli_connect("localhost", "root", "", "medical");

  // Escape the search string to prevent SQL injection attacks
  $search = mysqli_real_escape_string($conn, $_POST['search']);

  // Loop through each checked table
  foreach ($_POST['tables'] as $table) {
    // Execute a SELECT statement for the table
    $query = "SELECT * FROM $table WHERE E_Name LIKE '%$search%' OR C_Fname LIKE '%$search%' OR C_Lname LIKE '%$search%' OR Med_Name LIKE '%$search%' OR Sup_Name LIKE '%$search%'";
    $result = mysqli_query($conn, $query);

    // Display the results in an HTML table
    if (mysqli_num_rows($result) > 0) {
        echo "<h2>$table</h2>";
        echo "<table>";
        // Print the column names
        $row = mysqli_fetch_assoc($result);
        echo "<tr>";
        foreach ($row as $col => $value) {
          echo "<th>$col</th>";
        }
        echo "</tr>";
        // Print the data for each row
        mysqli_data_seek($result, 0);
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr>";
          foreach ($row as $col => $value) {
            echo "<td>$value</td>";
          }
          echo "</tr>";
        }
        echo "</table>";
      }
    }
  }
  ?>
  </div>
<style>
table {
  border-collapse: collapse;
  width: 100%;
}

th, td {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}

form {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin: 50px 0;
}

label {
  margin: 10px 0;
}

input[type="text"] {
  width: 300px;
  height: 25px;
  border: 1px solid #dddddd;
  border-radius: 5px;
  padding: 0 10px;
}

input[type="checkbox"] {
  margin: 0 10px;
}

input[type="submit"] {
  width: 100px;
  height: 30px;
  background-color: #4CAF50;
  border: none;
  color: white;
  border-radius: 5px;
  cursor: pointer;
}
</style>