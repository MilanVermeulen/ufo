<?php 
require 'header.php';
// retrieve the ID from the URL and decrypt it
$id = decryptId($_GET['id']);

// update the corresponding row in the database
$query = "UPDATE aliens SET approved=1 WHERE id=$id";
$result = mysqli_query($connection, $query);

// display a success message
echo "Row with ID $id has been approved!";
require 'footer.php';
?>