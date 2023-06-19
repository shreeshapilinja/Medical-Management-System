<?php session_start(); /* Starts the session */

if(!isset($_SESSION['UserData']['Username'])){
  header("location:login.php");
  exit;
}
?> 

<head>
    <title>Transaction report</title>
  </head>
<?php
  include './sidenav/sidenav.html';
?>
<div class = "rightbox">
  <br>
<form method="post" action="" onsubmit="return validateForm()">
  Start Date: <input type="date" name="start_date">
  End Date: <input type="date" name="end_date">
  <input type="submit" name="submit" value="Generate Report">
</form>

<?php
if (isset($_POST["submit"])) {
  // Connect to the database
  $conn = mysqli_connect("localhost", "root", "", "medical");

  // Check the connection
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  // Get the start and end dates from the form
  $start_date = $_POST["start_date"];
  $end_date = $_POST["end_date"];

  // Select the transactions between the given dates
  $sql = "SELECT S_ID, S_Date, E_ID, C_ID, Total_Amt
          FROM SALES
          WHERE S_Date BETWEEN '$start_date' AND '$end_date'";
  $result = mysqli_query($conn, $sql);

  // Check if there are any results
  if (mysqli_num_rows($result) > 0) {
    // Output the results in a table
    echo "<table>";
    echo "<tr><th>Transaction ID</th><th>Date</th><th>Employee ID</th><th>Customer ID</th><th>Total Amount</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
      echo "<tr>";
      echo "<td>" . $row["S_ID"] . "</td>";
      echo "<td>" . $row["S_Date"] . "</td>";
      echo "<td>" . $row["E_ID"] . "</td>";
      echo "<td>" . $row["C_ID"] . "</td>";
      echo "<td>" . $row["Total_Amt"] . "</td>";
      echo "</tr>";
    }
    echo "</table>";
  } else {
    echo "<center><h2>No transactions found between the given dates</h2></center>";
  }

  // Close the connection
  mysqli_close($conn);
}
?>
</div>
<style>
form {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-bottom: 20px;
}

input[type="date"] {
  width: 200px;
  height: 35px;
  margin: 10px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 0 10px;
}

input[type="submit"] {
  width: 120px;
  height: 35px;
  margin: 10px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 4px;
  background-color: #4CAF50;
  color: white;
  cursor: pointer;
}

table {
  border-collapse: collapse;
  width: 80%;
  margin: 0 auto;
}

th, td {
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #f2f2f2;
}

th {
  background-color: #4CAF50;
  color: white;
}
</style>
<script>
function validateForm() {
  var start_date = document.forms["transactions_form"]["start_date"].value;
  var end_date = document.forms["transactions_form"]["end_date"].value;
  if (start_date == "" || end_date == "") {
    alert("Start date and end date are required");
    return false;
  }
  if (start_date > end_date) {
    alert("Start date must be before end date");
    return false;
  }
}

</script>