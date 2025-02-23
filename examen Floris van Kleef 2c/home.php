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
if (isset($_POST['menu_ids']) && isset($_POST['aantallen']) && isset($_POST['TVG'])) {
    $menu_ids = $_POST['menu_ids'];
    $aantallen = $_POST['aantallen'];
    $TVGs = $_POST['TVG']; // Toevoegingen/allergieën ophalen

    for ($i = 0; $i < count($menu_ids); $i++) {
        $menu_id = $menu_ids[$i];
        $aantal = (int) $aantallen[$i];
        $TVG = htmlspecialchars($TVGs[$i]); // Voorkom XSS-aanvallen

        if ($aantal > 0) {
            $query = "SELECT naam FROM menu WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $menu_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $menu_naam = $row['naam'];

            // Update de database-invoeging met de TVG-waarde
            $stmt = $conn->prepare("INSERT INTO orders (tafel, menu_id, aantal, menu_naam, TVG) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("iiiss", $tafel, $menu_id, $aantal, $menu_naam, $TVG);

            if (!$stmt->execute()) {
                echo "Fout bij bestelling: " . $conn->error;
            }
        }
    }  // Succesbericht na de bestelling
        echo "<script>alert('Bestelling geplaatst!');</script>";
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
                    <th>Naam</th>
                    <th>Beschrijving</th>
                    <th>Prijs</th>
                    <th>Aantal</th>
                    <th>Extra toevoegingen/allergieën</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><img src="images/<?php echo $row['afbeelding']; ?>" width="50"></td>
                    <td><?php echo htmlspecialchars($row['naam']); ?></td>
                    <td><?php echo htmlspecialchars($row['beschrijving']); ?></td>
                    <td>&euro;<?php echo number_format($row['prijs'], 2, ',', '.'); ?></td>
                    <td>
                        <input type="hidden" name="menu_ids[]" value="<?php echo $row['id']; ?>">
                        <input type="number" name="aantallen[]" value="0" min="0" class="form-control">
                    </td>
                    <td>
    <input type="text" name="TVG[]" class="form-control" placeholder="Bijv. geen ui, extra kaas">
</td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Bestelling Plaatsen</button>
        </div>
    </form>
    <a href="bon-klant.php" class="btn btn-success">Bekijk Bonnetje</a>
    <div class="text-center mt-4">
        <a href="logout.php" class="btn btn-danger">Uitloggen</a>
    </div>
</div>
</body>
</html>
