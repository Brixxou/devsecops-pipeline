<?php
// Credentials via environment variables (no hardcoded secrets)
$host = getenv('DB_HOST') ?: 'devsecops-bdd';
$db   = getenv('DB_NAME') ?: 'myapp';
$user = getenv('DB_USER') ?: 'appuser';
$pass = getenv('DB_PASSWORD') ?: 'apppassword';

try {
    $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion BDD.");
}

$search = $_GET['search'] ?? '';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Annuaire Interne</title>
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; style-src 'self' 'unsafe-inline'">
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta http-equiv="X-Frame-Options" content="DENY">
    <style>body { font-family: sans-serif; padding: 20px; }</style>
</head>
<body>
    <h1>Annuaire de l'entreprise</h1>

    <p>Résultats de recherche pour : <b><?php echo htmlspecialchars($search, ENT_QUOTES, 'UTF-8'); ?></b></p>

    <form method="GET">
        <input type="text" name="search" placeholder="Rechercher un collègue..." value="<?php echo htmlspecialchars($search, ENT_QUOTES, 'UTF-8'); ?>">
        <button type="submit">Rechercher</button>
    </form>
    <hr>

    <?php
    if ($search) {
        // FIX SQLi: prepared statement instead of string concatenation
        $sql = "SELECT username, role FROM users WHERE username = :search";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':search' => $search]);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($results) {
                echo "<ul>";
                foreach ($results as $row) {
                    echo "<li><strong>" . htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8') . "</strong></li>";
                }
                echo "</ul>";
            } else {
                echo "Aucun utilisateur trouvé.";
            }
        } catch (PDOException $e) {
            echo "Erreur lors de la recherche.";
        }
    }
    ?>

    <hr>
    <div style="background-color: #d4edda; padding: 10px; border: 1px solid #c3e6cb;">
        <h3>Zone Admin : Diagnostic Réseau</h3>
        <p>Vérifier la connectivité d'un serveur interne.</p>

        <form method="GET">
            <input type="hidden" name="search" value="<?php echo htmlspecialchars($search, ENT_QUOTES, 'UTF-8'); ?>">
            <label>IP à tester :</label>
            <input type="text" name="ip" placeholder="ex: 8.8.8.8" value="<?php echo htmlspecialchars($_GET['ip'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
            <button type="submit">Pinger</button>
        </form>

        <?php
        if (isset($_GET['ip']) && !empty($_GET['ip'])) {
            $ip = $_GET['ip'];

            // FIX RCE: validate IP format before passing to system command
            if (filter_var($ip, FILTER_VALIDATE_IP)) {
                echo "<pre>";
                echo "Test de ping sur : " . htmlspecialchars($ip, ENT_QUOTES, 'UTF-8') . "\n";
                echo "--------------------------\n";
                system("ping -c 2 " . escapeshellarg($ip));
                echo "</pre>";
            } else {
                echo "<p style='color:red'>Adresse IP invalide.</p>";
            }
        }
        ?>
    </div>
</body>
</html>
