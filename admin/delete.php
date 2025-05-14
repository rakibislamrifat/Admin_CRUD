<?php
require '../config/db.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT image FROM orders WHERE id = ?");
$stmt->execute([$id]);
$image = $stmt->fetchColumn();

if ($image && file_exists("../uploads/$image")) {
    unlink("../uploads/$image");
}

$stmt = $pdo->prepare("DELETE FROM orders WHERE id = ?");
$stmt->execute([$id]);

header("Location: index.php");
exit;
