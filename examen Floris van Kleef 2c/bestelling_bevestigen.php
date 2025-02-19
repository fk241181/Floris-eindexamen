<?php
session_start();
require_once 'db-conn.php';

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Haal het tafelnummer op uit de sessie
$tafel = $_SESSION['tafel'];

// Haal de laatst geplaatste bestelling op voor deze tafel
$stmt = $conn->prepare("SELECT eten, drinken, toetje, status FROM orders WHERE tafel = ? ORDER BY id DESC LIMIT 1");
$stmt->bind_param("i", $tafel);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestelling Bevestigen</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h1 class="text-center">Bevestiging van je Bestelling</h1>

    <div class="alert alert-success mt-4" role="alert">
        <h4>Je bestelling is geplaatst!</h4>
        <p><strong>Eten:</strong> <?= htmlspecialchars($order['eten']) ?></p>
        <p><strong>Drinken:</strong> <?= htmlspecialchars($order['drinken']) ?></p>
        <p><strong>Toetje:</strong> <?= htmlspecialchars($order['toetje']) ?></p>
        <p><strong>Status:</strong> <?= htmlspecialchars($order['status']) ?></p>
    </div>

    <div class="text-center mt-4">
        <a href="home.php" class="btn btn-primary">Nieuwe bestelling plaatsen</a>
    </div>
</div>

</body>
</html>
