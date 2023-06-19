<?php
  include './sidenav/sidenav.html';
?>
<html>
<head>
  <title>Display Employees</title>
</head>
<body>
<link rel="stylesheet" href="manage.css" type="text/css">
<div class = "rightbox"><br>
<?php
// Connect to the database
$conn = mysqli_connect('localhost', 'root', '', 'medical');

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

  <table>
    <thead>
      <tr>
        <th>E_ID</th>
        <th>E_Name</th>
        <th>E_Role</th>
      </tr>
    </thead>
    <tbody>
      <?php
        // Select the E_ID, E_Name, and E_Role of all employees
        $sql = "SELECT E_ID, E_Name, E_Role FROM EMPLOYEE";
        $result = mysqli_query($conn, $sql);

        // Output the result
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>".$row["E_ID"]."</td>
                        <td>".$row["E_Name"]."</td>
                        <td>".$row["E_Role"]."</td>
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
</div>
</body>
</html>
