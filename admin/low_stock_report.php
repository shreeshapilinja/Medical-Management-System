<?php session_start(); /* Starts the session */

if(!isset($_SESSION['UserData']['Username'])){
  header("location:login.php");
  exit;
}
?> 
  <head>
    <title>Low stock report < 10</title>
  </head>
<?php
  include './sidenav/sidenav.html';
?>
<div class = "rightbox"><br>
<form>
  <h2> Search:</h2>  <input type="text" id="searchInput" onkeyup="searchTable()">
</form>
<?php
// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "medical");

// Check the connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Select the medicines with low stock (less than 10 units)
$sql = "SELECT Med_ID, Med_Name, Med_Qty FROM MEDICINES WHERE Med_Qty < 10";
$result = mysqli_query($conn, $sql);

// Check if there are any results
if (mysqli_num_rows($result) > 0) {
  // Output the results in a table
  echo "<table id='medicineTable'>";
  echo "<tr><th>Medicine ID</th><th>Medicine Name</th><th>Quantity</th></tr>";
  while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row["Med_ID"] . "</td>";
    echo "<td>" . $row["Med_Name"] . "</td>";
    echo "<td>" . $row["Med_Qty"] . "</td>";
    echo "</tr>";
  }
  echo "</table>";
} else {
  echo "<center><h2>No medicines with low stock found</h2></center>";
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
<script>
function searchTable() {
  // Get the search input and table
  var input = document.getElementById("searchInput");
  var table = document.getElementById("medicineTable");

  // Get the rows in the table
  var rows = table.getElementsByTagName("tr");

  // Loop through all rows
  for (var i = 0; i < rows.length; i++) {
    // Get the cells in the current row
    var cells = rows[i].getElementsByTagName("td");

    // Check if any of the cells contain the search text
    var found = false;
    for (var j = 0; j < cells.length; j++) {
      if (cells[j].textContent.toLowerCase().indexOf(input.value.toLowerCase()) > -1) {
        found = true;
        break;
      }
    }

    // If the search text was found in the current row, display it
    // Otherwise, hide it
    if (found) {
      rows[i].style.display = "";
    } else {
      rows[i].style.display = "none";
    }
  }
}
</script>