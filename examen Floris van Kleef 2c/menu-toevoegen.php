<?php
session_start();
require_once 'db-conn.php';


// Verwerken van het formulier
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categorie = $_POST['categorie'];
    $naam = $_POST['naam'];
    $prijs = $_POST['prijs'];
    $beschrijving = $_POST['beschrijving'];

    // Afbeelding uploaden
    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES["afbeelding"]["name"]);
    move_uploaded_file($_FILES["afbeelding"]["tmp_name"], $target_file);

    // Invoegen in de database
    $stmt = $conn->prepare("INSERT INTO menu (categorie, naam, prijs, afbeelding, beschrijving) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdss", $categorie, $naam, $prijs, $target_file, $beschrijving);

    if ($stmt->execute()) {
        echo "<script>alert('Product succesvol toegevoegd!'); window.location.href='admin-dashboard.php';</script>";
    } else {
        echo "<script>alert('Fout bij toevoegen!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Toevoegen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-center">➕ Product Toevoegen</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Categorie</label>
                <select name="categorie" class="form-select" required>
                    <option value="Eten">Eten</option>
                    <option value="Drinken">Drinken</option>
                    <option value="Toetje">Toetje</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Naam</label>
                <input type="text" name="naam" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Prijs (€)</label>
                <input type="number" name="prijs" step="0.01" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Afbeelding</label>
                <input type="file" name="afbeelding" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Beschrijving</label>
                <textarea name="beschrijving" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">✔️ Toevoegen</button>
            <a href="admin-dashboard.php" class="btn btn-secondary">🔙 Terug</a>
        </form>
    </div>
</body>
</html>
