<?php
  include './sidenav/sidenav.html';
?>
  <head>
    <title>Manage Medicines</title>
  </head>
<link rel="stylesheet" href="manage.css" type="text/css">
<div class = "rightbox">
<?php
// Connect to the database
$conn = mysqli_connect('localhost', 'root', '', 'medical');

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>
<html>
<head>
  <title>Display Medicines</title>
</head>
<body>
  <table>
    <thead>
      <tr>
        <th>Med_ID</th>
        <th>Med_Name</th>
        <th>Med_Qty</th>
        <th>Category</th>
        <th>Med_Price(Rs)</th>
        <th>Location_Rack</th>
      </tr>
    </thead>
    <tbody>
      <?php
        // Select all rows from the MEDICINES table
        $sql = "SELECT * FROM MEDICINES";
        $result = mysqli_query($conn, $sql);

        // Output the result
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>".$row["Med_ID"]."</td>
                        <td>".$row["Med_Name"]."</td>
                        <td>".$row["Med_Qty"]."</td>
                        <td>".$row["Category"]."</td>
                        <td>".$row["Med_Price"]."</td>
                        <td>".$row["Location_Rack"]."</td>
                      </tr>";
            }
        } else {
            echo "<center>0 results</center>";
        }

        // Close the connection
        mysqli_close($conn);
      ?>
    </tbody>
  </table>
</div><br>
<br>
<style>

  /* Style the table */
  table {
    width: 100%;
    border-collapse: collapse;
  }

  /* Style the table cells */
  td, th {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
  }

  /* Style the table headings */
  th {
    background-color: #4CAF50;
    color: white;
  }

</style>
</body>
</html>
<!--
  <table>
    <thead>
      <tr>
        <th>Med_ID</th>
        <th>Med_Name</th>
        <th>Med_Qty</th>
        <th>Category</th>
        <th>Med_Price</th>
        <th>Location_Rack</th>
      </tr>
    </thead>
    <tbody>
 <php>     
        // Select all rows from the MEDICINES table
        $sql = "SELECT * FROM MEDICINES";
        $result = mysqli_query($conn, $sql);

        // Output the result
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>".$row["Med_ID"]."</td>
                        <td>".$row["Med_Name"]."</td>
                        <td>".$row["Med_Qty"]."</td>
                        <td>".$row["Category"]."</td>
                        <td>".$row["Med_Price"]."</td>
                        <td>".$row["Location_Rack"]."</td>
                      </tr>";
            }
        } else {
            echo "<center>0 results</center>";
        }

        // Close the connection
        mysqli_close($conn);
</php>
    </tbody>
  </table>
 -->