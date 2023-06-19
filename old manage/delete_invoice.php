<?php
  include './sidenav/sidenav.html';
?>
<div class = "rightbox"><br>
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

    // Build the DELETE statement
    $sql = "DELETE FROM SALES WHERE S_ID = '$id'";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        // Redirect to the invoices page
        echo "<center><h2>deleted</h2></center>";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}

?>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get all the delete icons
    var deleteIcons = document.querySelectorAll('.fa-trash');

    // Add a click event listener to each delete icon
    deleteIcons.forEach(function(icon) {
        icon.addEventListener('click', function() {
            // Get the sales number of the invoice
            var id = this.parentNode.href.split('=')[1];

            // Confirm that the user wants to delete the invoice
            if (confirm('Are you sure you want to delete this invoice?')) {
                // Submit a form to delete the invoice
                var form = document.createElement('form');
                form.method = 'post';
                form.action = 'delete.php';

                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'id';
                input.value = id;
                form.appendChild(input);

                document.body.appendChild(form);
                form.submit();
            }
        });
    });

    // Get all the print icons
    var printIcons = document.querySelectorAll('.fa-print');

    // Add a click event listener to each print icon
    printIcons.forEach(function(icon) {
        icon.addEventListener('click', function() {
            // Open the print page in a new window
            window.open(this.parentNode.href, '_blank');
        });
    });
});
</script>