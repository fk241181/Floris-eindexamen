<?php
// Zorg ervoor dat je verbinding maakt met de database
require_once 'db-conn.php';

// Controleer of de formulier is ingediend
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['status'])) {
    $order_id = $_POST['order_id'];  // Haal het order_id op uit het formulier
    $new_status = $_POST['status'];  // Haal de nieuwe status op uit het formulier

    // Update de status in de database
    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $order_id);
    $stmt->execute();

    // Eventueel een succesmelding toevoegen
    if ($stmt->affected_rows > 0) {
        echo "<script>alert('Status bijgewerkt!');</script>";
    } else {
        echo "<script>alert('Er is iets misgegaan bij het bijwerken van de status!');</script>";
    }
}


// Haal alle bestellingen op
$query = "SELECT * FROM orders ORDER BY besteld_op DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Keuken Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center">Keuken Dashboard</h1>

        <?php if (isset($success)) : ?>
            <div class="alert alert-success"><?= htmlspecialchars($success); ?></div>
        <?php endif; ?>
        <?php if (isset($error)) : ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <table class="table table-bordered mt-4">
    <thead class="table-dark">
        <tr>
            <th>Tafel</th>
            <th>Aantal</th>
            <th>TVG (Allergieën)</th>
            <th>Status</th>
            <th>Menu naam</th>
            <th>Actie</th>
            
        </tr>
    </thead>
    <tbody>
        <?php
        // Haal de bestellingen op uit de database
        $query = "SELECT * FROM orders";
        $result = $conn->query($query);

        // Loop door de bestellingen
        while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= htmlspecialchars($row['tafel']); ?></td>
            <td><?= htmlspecialchars($row['aantal']); ?></td>
            <td><?= htmlspecialchars($row['TVG']); ?></td>
            <td><?= htmlspecialchars($row['status']); ?></td>
            <td><?= htmlspecialchars($row['menu_naam']); ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="order_id" value="<?= $row['id']; ?>">
                    <select name="status" class="form-select mb-2">
                        <option value="besteld" <?= ($row['status'] == 'besteld') ? 'selected' : ''; ?>>Besteld</option>
                        <option value="in voorbereiding" <?= ($row['status'] == 'in voorbereiding') ? 'selected' : ''; ?>>In voorbereiding</option>
                        <option value="geserveerd" <?= ($row['status'] == 'geserveerd') ? 'selected' : ''; ?>>Geserveerd</option>
                    </select>
                    <button type="submit" class="btn btn-primary btn-sm">Bijwerken</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<div class="text-center mt-4">
    <a href="menu-toevoegen.php" class="btn btn-success">➕ Product Toevoegen</a>
</div>

<a href="kassa.php" class="btn btn-success">🔹 Ga naar Kassa</a>

        <div class="text-center mt-4">
            <a href="logout.php" class="btn btn-danger">Uitloggen</a>
        </div>
    </div>
</body>
</html>
