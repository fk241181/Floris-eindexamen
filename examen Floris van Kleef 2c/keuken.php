<?php
session_start();
require_once 'db-conn.php';

// Controleer of de gebruiker is ingelogd (optioneel, indien gewenst)
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

// Verwerk status-update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['status'];

    // Update de status in de database
    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $order_id);

    if ($stmt->execute()) {
        echo "<script>alert('Status bijgewerkt!');</script>";
    } else {
        echo "<script>alert('Fout bij bijwerken status: " . $conn->error . "');</script>";
    }
}

// Haal alle bestellingen op uit de database
$query = "SELECT * FROM orders ORDER BY besteld_op DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keukenoverzicht</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h1 class="text-center">Keukenoverzicht</h1>
    <table class="table table-bordered mt-4">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Tafel</th>
                <th>Menu Naam</th>
                <th>Aantal</th>
                <th>TVG (Toevoegingen/Allergieën)</th>
                <th>Status</th>
                <th>Besteld Op</th>
                <th>Actie</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['tafel']; ?></td>
                <td><?php echo htmlspecialchars($row['menu_naam']); ?></td>
                <td><?php echo $row['aantal']; ?></td>
                <td><?php echo htmlspecialchars($row['TVG']); ?></td>
                <td><?php echo htmlspecialchars($row['status']); ?></td>
                <td><?php echo $row['besteld_op']; ?></td>
                <td>
                    <!-- Formulier om status bij te werken -->
                    <form method="POST">
                        <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
                        <select name="status" class="form-select">
                            <option value="In Behandeling" <?php if ($row['status'] == 'In Behandeling') echo 'selected'; ?>>In Behandeling</option>
                            <option value="Klaar" <?php if ($row['status'] == 'Klaar') echo 'selected'; ?>>Klaar</option>
                            <option value="Geleverd" <?php if ($row['status'] == 'Geleverd') echo 'selected'; ?>>Geleverd</option>
                        </select>
                        <button type="submit" name="update_status" class="btn btn-primary btn-sm mt-2">Bijwerken</button>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="text-center mt-4">
        <a href="logout.php" class="btn btn-danger">Uitloggen</a>
    </div>
</div>
</body>
</html>
