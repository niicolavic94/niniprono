<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.html");
    exit();
}

// Connexion à la base de données
$host = 'localhost';
$db   = 'niniprono';
$user = 'votre_utilisateur';
$pass = 'votre_mot_de_passe';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $user_id = (int)$_SESSION['user_id']; // Assurez-vous que c'est un entier
    $subscription_type = $_POST['subscription_type']; // 1_month, 3_months, ou 6_months

    // Valider les données
    $errors = [];

    if (!in_array($subscription_type, ['1_month', '3_months', '6_months'])) {
        $errors[] = "Type d'abonnement invalide.";
    }

    // Si aucune erreur, traiter les données
    if (empty($errors)) {
        // Calculer les dates de début et de fin de l'abonnement
        $start_date = date('Y-m-d');
        $end_date = date('Y-m-d', strtotime("+1 month")); // Par défaut, 1 mois

        if ($subscription_type == '3_months') {
            $end_date = date('Y-m-d', strtotime("+3 months"));
        } elseif ($subscription_type == '6_months') {
            $end_date = date('Y-m-d', strtotime("+6 months"));
        }

        // Préparer la requête SQL pour insérer l'abonnement
        $stmt = $pdo->prepare("INSERT INTO subscriptions (user_id, type, start_date, end_date) VALUES (?, ?, ?, ?)");

        try {
            // Exécuter la requête
            $stmt->execute([$user_id, $subscription_type, $start_date, $end_date]);

            // Afficher un message de confirmation
            echo "<h1>Abonnement réussi !</h1>";
            echo "<p>Votre abonnement a été créé avec succès.</p>";
            exit();
        } catch (\PDOException $e) {
            $errors[] = "Une erreur est survenue lors de la création de l'abonnement: " . $e->getMessage();
        }
    }

    // Afficher les erreurs
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p>" . htmlspecialchars($error, ENT_QUOTES, 'UTF-8') . "</p>";
        }
    }
} else {
    // Rediriger si le formulaire n'a pas été soumis
    header("Location: vip.html");
    exit();
}
?>
