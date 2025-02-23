<?php
require_once 'db-conn.php';

// Haal alle unieke tafelnummers op die bestellingen hebben
$query = "SELECT DISTINCT tafel FROM orders ORDER BY tafel ASC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kassa Overzicht</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center">Kassa Overzicht</h1>
        <div class="row">
            <?php while ($row = $result->fetch_assoc()) { ?>
                <div class="col-md-3">
                    <div class="card text-center p-3 mb-3">
                        <h3>Tafel <?= htmlspecialchars($row['tafel']); ?></h3>
                        <a href="bon.php?tafel=<?= $row['tafel']; ?>" class="btn btn-primary">Bekijk Bon</a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <a href="admin-dashboard.php" class="btn btn-secondary">🔙 Terug naar dashboard</a>
</body>
</html>
