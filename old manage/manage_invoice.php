<?php
  include './sidenav/sidenav.html';
?>
<div class = "rightbox"><br>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <input type="text" name="search" value="">
    <input type="submit" name="submit" value="Search">
</form>
<?php

// Connect to the database
$conn = mysqli_connect('localhost', 'root', '', 'medical');

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize variables
$search = '';
$results = array();

// Check if the search form has been submitted
if (isset($_POST['submit'])) {
    // Get the search term
    $search = mysqli_real_escape_string($conn, $_POST['search']);

    // Build the SELECT statement
    $sql = "SELECT * FROM Invoices
            WHERE S_ID = '$search' OR (C_Fname = '$search' OR C_Lname = '$search') OR S_Date = '$search'";

    // Execute the query and store the result
    $result = mysqli_query($conn, $sql);

    // If there are results, store them in an array
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $results[] = $row;
        }
    }
}
?>
<table>
    <tr>
        <th>Serial Number</th>
        <th>Sales Number</th>
        <th>Date</th>
        <th>Total Amount</th>
        <th>Action</th>
    </tr>
    <?php
    $i = 1;
    foreach ($results as $result) {
        echo "<tr>";
        echo "<td>" . $i . "</td>";
        echo "<td>" . $result['S_ID'] . "</td>";
        echo "<td>" . $result['S_Date'] . "</td>";
        echo "<td>" . $result['Total_Amt'] . "</td>";
        echo "<td>";
        echo "<a href='delete_invoice.php?id=" . $result['S_ID'] . "'><i class='fa fa-trash'></i></a>";
        echo "<a href='print.php?id=" . $result['S_ID'] . "'><i class='fa fa-print'></i></a>";
        echo "</td>";
        echo "</tr>";
        $i++;
    }
?>        
</div>
<style>
table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    text-align: left;
    padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}

th {
    background-color: #4CAF50;
    color: white;
}

.fa {
    cursor: pointer;
}

.fa-trash {
    color: red;
}

.fa-print {
    color: blue;
}
</style>