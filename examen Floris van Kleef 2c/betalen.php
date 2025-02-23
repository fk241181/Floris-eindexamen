<?php
session_start();
require_once 'db-conn.php';
require 'vendor/autoload.php'; // PHPMailer laden

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!isset($_SESSION['tafel'])) {
    echo "Geen bestelling gevonden.";
    exit();
}

$tafel = $_SESSION['tafel'];
$melding = "";

// Verwerk betaling en verwijder bestelling
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = $_POST['email'];

    // Haal de bestelling op
    $query = "SELECT menu_naam, aantal FROM orders WHERE tafel = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $tafel);
    $stmt->execute();
    $result = $stmt->get_result();

    $bontekst = "Tafel: $tafel\n\nBestelling:\n";
    while ($row = $result->fetch_assoc()) {
        $bontekst .= "{$row['menu_naam']} x{$row['aantal']}\n";
    }

    // Verzend e-mail met PHPMailer
    $mail = new PHPMailer(true);
    try {
        // Instellingen voor SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; 
        $mail->SMTPAuth   = true;
        $mail->Username   = 'jouwgmail@gmail.com'; // Vervang met je Gmail-adres
        $mail->Password   = 'jouwGmailWachtwoord'; // Gebruik een app-wachtwoord (zie uitleg hieronder)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Instellingen afzender en ontvanger
        $mail->setFrom('jouwgmail@gmail.com', 'Restaurant');
        $mail->addAddress($email); // Klant e-mailadres

        // E-mail inhoud
        $mail->isHTML(false);
        $mail->Subject = 'Uw bonnetje van Restaurant';
        $mail->Body    = $bontekst;

        $mail->send();

        // Verwijder bestelling na succesvolle verzending
        $query = "DELETE FROM orders WHERE tafel = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $tafel);
        $stmt->execute();

        $melding = "Betaling voltooid! Uw bonnetje is verstuurd naar $email.";
    } catch (Exception $e) {
        $melding = "Fout bij verzenden: {$mail->ErrorInfo}";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Betalen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card p-4 shadow" style="max-width: 400px; margin: auto;">
            <h2 class="text-center">Afrekenen</h2>
            <?php if (!empty($melding)) : ?>
                <div class="alert alert-info"><?= htmlspecialchars($melding); ?></div>
            <?php else : ?>
                <form method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Uw e-mailadres</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Betalen & Bon Ontvangen</button>
                </form>
            <?php endif; ?>
            <a href="home.php" class="btn btn-secondary w-100 mt-2">Terug</a>
        </div>
    </div>
</body>
</html>
