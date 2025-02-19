<?php
session_start();
require_once 'db-conn.php';

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

$tafel = $_SESSION['tafel'];

// Haal het menu op uit de database
$query = "SELECT * FROM menu";
$result = $conn->query($query);

// Verwerken van de bestelling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Controleer of zowel menu_ids als aantallen zijn ingediend
    if (isset($_POST['menu_ids']) && isset($_POST['aantallen'])) {
        $menu_ids = $_POST['menu_ids'];
        $aantallen = $_POST['aantallen'];

        // Itereren door alle items en de bestelling opslaan in de database
        for ($i = 0; $i < count($menu_ids); $i++) {
            $menu_id = $menu_ids[$i];
            $aantal = (int) $aantallen[$i];  // Zorg ervoor dat het aantal een integer is

            // Alleen invoeren als het aantal groter dan 0 is
            if ($aantal > 0) {
                // Haal de naam van het menu-item op uit de database
                $query = "SELECT beschrijving FROM menu WHERE id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $menu_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $menu_naam = $row['beschrijving'];

                // Bereid de query voor om de bestelling met naam op te slaan
                $stmt = $conn->prepare("INSERT INTO orders (tafel, menu_id, aantal, menu_naam) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("iiis", $tafel, $menu_id, $aantal, $menu_naam);

                if (!$stmt->execute()) {
                    echo "Fout bij bestelling: " . $conn->error;
                }
            }
        }

        // Succesbericht na de bestelling
        echo "<script>alert('Bestelling geplaatst!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestellen</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h1 class="text-center">Plaats je Bestelling</h1>
    <form method="POST">
        <table class="table table-bordered mt-4">
            <thead class="table-dark">
                <tr>
                    <th>Afbeelding</th>
                    <th>Beschrijving</th>
                    <th>Prijs</th>
                    <th>Aantal</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><img src="images/<?php echo $row['afbeelding']; ?>" width="50"></td>
                    <td><?php echo htmlspecialchars($row['beschrijving']); ?></td>
                    <td>&euro;<?php echo number_format($row['prijs'], 2, ',', '.'); ?></td>
                    <td>
                        <input type="hidden" name="menu_ids[]" value="<?php echo $row['id']; ?>">
                        <input type="number" name="aantallen[]" value="0" min="0" class="form-control">
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Bestelling Plaatsen</button>
        </div>
    </form>
    <div class="text-center mt-4">
        <a href="logout.php" class="btn btn-danger">Uitloggen</a>
    </div>
</div>
</body>
</html>
