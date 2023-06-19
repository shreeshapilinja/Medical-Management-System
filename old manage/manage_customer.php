<?php
  include './sidenav/sidenav.html';
?>
<div class = "rightbox">
<!-- Customers table -->
<table>
    <tr>
        <th>ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Address</th>
        <th>Age</th>
        <th>Sex</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Action</th>
    </tr>
<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medical";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize variables
$editId = 0;
$fname = '';
$lname = '';
$address = '';
$age = 0;
$sex = '';
$phone = '';
$mail = '';
$error = '';
$editMode = false;

    // Get all the customers
    $sql = "SELECT * FROM CUSTOMER";
    $result = mysqli_query($conn, $sql);

    // Loop through the results and display them in the table
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['C_ID'] . "</td>";
        echo "<td>" . $row['C_Fname'] . "</td>";
        echo "<td>" . $row['C_Lname'] . "</td>";
        echo "<td>" . $row['C_Address'] . "</td>";
        echo "<td>" . $row['C_Age'] . "</td>";
        echo "<td>" . $row['C_Sex'] . "</td>";
        echo "<td>" . $row['C_Phone'] . "</td>";
        echo "<td>" . $row['C_Mail'] . "</td>";
        echo "<td>";
        echo "<a href='manage_customer.php?edit=" . $row['C_ID'] . "' class='edit'><i class='fa fa-edit'></i></a>";
        echo "<a href='manage_customer.php?delete=" . $row['C_ID'] . "' class='delete'><i class='fa fa-trash'></i></a>";
        echo "</td>";
        echo "</tr>";
}

// Check if the save button was submitted
if (isset($_POST['save'])) {
    // Get the form data
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $sex = mysqli_real_escape_string($conn, $_POST['sex']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $mail = mysqli_real_escape_string($conn, $_POST['mail']);

    // Check if the customer already exists
    $sql = "SELECT * FROM CUSTOMER WHERE C_Phone='$phone' OR C_Mail='$mail'";
    $result = mysqli_query($conn, $sql);
    $customer = mysqli_fetch_assoc($result);
    if ($customer && $customer['C_ID'] != $id) {
        // Customer already exists
        $error = "Customer already exists with the same phone or email.";
    } else {
        // Build the INSERT or UPDATE statement
        if ($id) {
            // Update the customer
            $sql = "UPDATE CUSTOMER SET C_Fname='$fname', C_Lname='$lname', C_Address='$address', C_Age='$age', C_Sex='$sex', C_Phone='$phone', C_Mail='$mail' WHERE C_ID='$id'";
        } else {
            // Add the customer
            // Add the customer
$sql = "INSERT INTO CUSTOMER (C_Fname, C_Lname, C_Address, C_Age, C_Sex, C_Phone, C_Mail) VALUES ('$fname', '$lname', '$address', '$age', '$sex', '$phone', '$mail')";
}

// Execute the query
if (mysqli_query($conn, $sql)) {
    // Success
    header('Location: manage_customer.php');
    exit;
} else {
    // Error
    $error = "Error: " . $sql . "<br>" . mysqli_error($conn);
}
}

// Check if the edit parameter is set in the URL query string
if (isset($_GET['edit'])) {
    // Get the customer id from the URL query string
    $editId = mysqli_real_escape_string($conn, $_GET['edit']);

    // Send an HTTP GET request to the server to get the customer data
    $sql = "SELECT * FROM CUSTOMER WHERE C_ID='$editId'";
    $result = mysqli_query($conn, $sql);
    $customer = mysqli_fetch_assoc($result);
    if ($customer) {
        // Set the form values
        $fname = $customer['C_Fname'];
        $lname = $customer['C_Lname'];
        $address = $customer['C_Address'];
        $age = $customer['C_Age'];
        $sex = $customer['C_Sex'];
        $phone = $customer['C_Phone'];
        $mail = $customer['C_Mail'];
        $editMode = true;
} else {
$error = "Customer not found.";
}
}

// Check if the delete parameter is set in the URL query string
if (isset($_GET['delete'])) {
    // Get the customer id from the URL query string
    $deleteId = mysqli_real_escape_string($conn, $_GET['delete']);

    // Send an HTTP DELETE request to the server to delete the customer
    $sql = "DELETE FROM CUSTOMER WHERE C_ID='$deleteId'";
    if (mysqli_query($conn, $sql)) {
        // Success
        header('Location: manage_customer.php');
        exit;
    } else {
        // Error
        $error = "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
}

?>  
</table>
<!-- Customer form -->
<form method="post" action="manage_customer.php">
    <!-- Form fields for editing a customer -->
    <input type="hidden" name="id" value="<?php echo $editId; ?>">
    <input type="text" name="fname" value="<?php echo $fname; ?>" placeholder="First Name" required>
    <input type="text" name="lname" value="<?php echo $lname; ?>" placeholder="Last Name" required>
    <input type="text" name="address" value="<?php echo $address; ?>" placeholder="Address" required>
    <input type="number" name="age" value="<?php echo $age; ?>" placeholder="Age" required>
    <input type="text" name="sex" value="<?php echo $sex; ?>" placeholder="Sex" required>
    <input type="tel" name="phone" value="<?php echo $phone; ?>" placeholder="Phone" required>
    <input type="email" name="mail" value="<?php echo $mail; ?>" placeholder="Email" required>
    <!-- Save button -->
    <input type="submit" name="save" value="<?php echo $editMode ? 'Save' : 'Add'; ?>">
</form>   
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

tr:nth-child(even) {
    background-color: #f2f2f2;
}

th {
    background-color: #4caf50;
    color: white;
}

form {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: center;
}

form input[type="text"],
form input[type="number"],
form input[type="tel"],
form input[type="email"] {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    box-sizing: border-box;
    border: 2px solid #ccc;
    border-radius: 4px;
}

form input[type="submit"] {
    width: 100%;
    background-color: #4caf50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

form input[type="submit"]:hover {
    background-color: #45a049;
}

.fa {
    font-size: 18px;
}

</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get the delete links
    var deleteLinks = document.querySelectorAll('.fa-trash');

    // Loop through the delete links
    for (var i = 0; i < deleteLinks.length; i++) {
        // Add a click event listener to each delete link
        deleteLinks[i].addEventListener('click', function(event) {
            // Confirm the delete action
            if (!confirm('Are you sure you want to delete this customer?')) {
                // Prevent the default action (redirecting to the delete page)
                event.preventDefault();
            }
        });
    }

    // Get the edit links
    var editLinks = document.querySelectorAll('.fa-edit');

    // Loop through the edit links
    for (var i = 0; i < editLinks.length; i++) {
        // Add a click event listener to each edit link
        editLinks[i].addEventListener('click', function(event) {
            // Prevent the default action (redirecting to
// Prevent the default action (redirecting to the edit page)
event.preventDefault();

// Get the customer id from the URL query string
var customerId = this.getAttribute('href').split('=')[1];

// Send an HTTP GET request to the server to get the customer data
fetch('manage_customer.php?get=' + customerId)
    .then(function(response) {
        return response.json();
    })
    .then(function(customer) {
        // Fill the form with the customer data
        document.querySelector('input[name="id"]').value = customer.C_ID;
        document.querySelector('input[name="fname"]').value = customer.C_Fname;
        document.querySelector('input[name="lname"]').value = customer.C_Lname;
        document.querySelector('input[name="address"]').value = customer.C_Address;
        document.querySelector('input[name="age"]').value = customer.C_Age;
        document.querySelector('input[name="sex"]').value = customer.C_Sex;
        document.querySelector('input[name="phone"]').value = customer.C_Phone;
        document.querySelector('input[name="mail"]').value = customer.C_Mail;
        // Change the save button text
        document.querySelector('input[type="submit"]').value = 'Save';
    });
});
</script>