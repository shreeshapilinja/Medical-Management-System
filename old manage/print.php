<?php
  include './sidenav/sidenav.html';
?>
<div class = "rightbox">
<?php

// Connect to the database
$conn = mysqli_connect('localhost', 'root', '', 'medical');

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the id parameter is set
if (isset($_GET['id'])) {
    // Get the id parameter
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Build the SELECT statement
    $sql = "SELECT S.S_ID, C.C_Fname, C.C_Lname, S.S_Date, S.Total_Amt, SI.Med_ID, M.Med_Name, SI.Sale_Qty, SI.Tot_Price
            FROM SALES AS S
            JOIN CUSTOMER AS C ON S.C_ID = C.C_ID
            JOIN SALES_ITEMS AS SI ON S.S_ID = SI.S_ID
            JOIN MEDICINES AS M ON SI.Med_ID = M.Med_ID
            WHERE S.S_ID = '$id'";

    // Execute the query and store the result
    $result = mysqli_query($conn, $sql);

    // If there are results, store them in an array
    if (mysqli_num_rows($result) > 0) {
        $invoice = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $invoice[] = $row;
        }
    }
}

?>
</div>