<?php
session_start();
require_once 'db-conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tafel = $_POST['tafel'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE tafel = ?");
    $stmt->bind_param("i", $tafel);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['tafel'] = $tafel;
            header("Location: home.php");
            exit();
        } else {
            $error = "Ongeldig wachtwoord!";
        }
    } else {
        $error = "Tafelnummer niet gevonden!";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inloggen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow" style="max-width: 400px; width: 100%;">
            <h2 class="text-center">Inloggen</h2>
            <?php if (isset($error)) : ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <form method="post">
                <div class="mb-3">
                    <label for="tafel" class="form-label">Tafelnummer</label>
                    <select class="form-select" id="tafel" name="tafel" required>
                        <?php for ($i = 1; $i <= 20; $i++): ?> 
                            <option value="<?= $i; ?>">Tafel <?= $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Wachtwoord</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Inloggen</button>
            </form>
        </div>
    </div>
</body>
</html>
