<?php
require_once 'db-conn.php';

if (!isset($_GET['tafel'])) {
    die("Geen tafel geselecteerd.");
}

$tafel = (int)$_GET['tafel'];

// Verwijder de bestelling uit de database
$query = "DELETE FROM orders WHERE tafel = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $tafel);

if ($stmt->execute()) {
    echo "<script>alert('Bestelling verwijderd!'); window.location='kassa.php';</script>";
} else {
    echo "Fout bij verwijderen: " . $conn->error;
}
?>
