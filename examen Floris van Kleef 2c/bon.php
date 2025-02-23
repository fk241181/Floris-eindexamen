<?php
session_start();
require_once 'db-conn.php';

// Controleer of een tafelnummer is meegegeven
if (!isset($_GET['tafel'])) {
    die("Geen tafel geselecteerd.");
}

$tafel = $_GET['tafel'];

// Controleer of op "Betaling voltooid" is geklikt
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['verwijder_bon'])) {
    $stmt = $conn->prepare("DELETE FROM orders WHERE tafel = ?");
    $stmt->bind_param("i", $tafel);
    if ($stmt->execute()) {
        echo "<script>alert('Bon verwijderd!'); window.location.href = 'kassa.php';</script>";
        exit();
    } else {
        echo "<script>alert('Fout bij verwijderen bon.');</script>";
    }
}

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
    <title>Bon voor Tafel <?= htmlspecialchars($tafel); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-center">Bon - Tafel <?= htmlspecialchars($tafel); ?></h2>
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

        <!-- Print en Betaal knop -->
        <div class="text-center">
            <button onclick="window.print();" class="btn btn-primary">🖨️ Print Bon</button>
            <form method="POST" class="d-inline">
                <button type="submit" name="verwijder_bon" class="btn btn-danger">🗑️ Betaling Voltooid (Bon Verwijderen)</button>
            </form>
            <a href="kassa.php" class="btn btn-secondary">🔙 Terug naar Kassa</a>
        </div>
    </div>
</body>
</html>
