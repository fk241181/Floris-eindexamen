<?php
session_start();
require_once 'db-conn.php';

// Controleer of de gebruiker is ingelogd en een tafelnummer heeft
if (!isset($_SESSION['tafel'])) {
    die("Je moet ingelogd zijn om je bon te bekijken.");
}

$tafel = $_SESSION['tafel'];

// Haal de bestelling op inclusief prijs uit de menu-tabel
$query = "
    SELECT o.menu_naam, o.aantal, m.prijs 
    FROM orders o
    JOIN menu m ON o.menu_id = m.id
    WHERE o.tafel = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $tafel);
$stmt->execute();
$result = $stmt->get_result();

$totaal = 0;
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mijn Bon - Tafel <?= htmlspecialchars($tafel); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-center">Mijn Bon - Tafel <?= htmlspecialchars($tafel); ?></h2>
        <table class="table table-bordered mt-4">
            <thead class="table-dark">
                <tr>
                    <th>Menu Item</th>
                    <th>Aantal</th>
                    <th>Prijs per stuk</th>
                    <th>Subtotaal</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : 
                    $subtotaal = $row['aantal'] * $row['prijs'];
                    $totaal += $subtotaal;
                ?>
                <tr>
                    <td><?= htmlspecialchars($row['menu_naam']); ?></td>
                    <td><?= htmlspecialchars($row['aantal']); ?></td>
                    <td>€<?= number_format($row['prijs'], 2, ',', '.'); ?></td>
                    <td>€<?= number_format($subtotaal, 2, ',', '.'); ?></td>
                </tr>
                <?php endwhile; ?>
                <tr class="table-success">
                    <td colspan="3"><strong>Totaal</strong></td>
                    <td><strong>€<?= number_format($totaal, 2, ',', '.'); ?></strong></td>
                </tr>
            </tbody>
        </table>

        <!-- Print-knop voor klant -->
        <div class="text-center">
            <a href="home.php" class="btn btn-secondary">🔙 Terug naar menu</a>
        </div>
    </div>
</body>
</html>
