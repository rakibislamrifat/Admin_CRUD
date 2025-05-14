<?php
require '../config/db.php';

$id = $_GET['id'];

// Use MySQLi to select the image name
$query = "SELECT image FROM orders WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $id); // 'i' for integer
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$image = mysqli_fetch_assoc($result)['image'];

// If the image exists and the file exists, delete the file
if ($image && file_exists("../uploads/$image")) {
    unlink("../uploads/$image");
}

// Now delete the order from the database
$query = "DELETE FROM orders WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $id); // 'i' for integer
mysqli_stmt_execute($stmt);

header("Location: index.php");
exit;
?>
