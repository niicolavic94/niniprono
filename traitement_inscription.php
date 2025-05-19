<?php
// Connexion à la base de données
$host = 'localhost';
$db   = 'votre_base_de_donnees';
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
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $pseudo = trim($_POST['pseudo']);
    $email = trim($_POST['email']);
    $age = trim($_POST['age']);
    $motdepasse = $_POST['motdepasse'];
    $confirm_motdepasse = $_POST['confirm_motdepasse'];

    // Valider les données
    $errors = [];

    if (empty($pseudo)) {
        $errors[] = "Le pseudo est requis.";
    }

    $email_regex = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
    if (!preg_match($email_regex, $email)) {
        $errors[] = "Format d'email invalide.";
    }

    if (empty($age) || !is_numeric($age) || $age < 0) {
        $errors[] = "Un âge valide est requis.";
    }

    $password_regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/';
    if (empty($motdepasse)) {
        $errors[] = "Le mot de passe est requis.";
    } elseif (!preg_match($password_regex, $motdepasse)) {
        $errors[] = "Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule et un chiffre.";
    }

    if ($motdepasse !== $confirm_motdepasse) {
        $errors[] = "Les mots de passe ne correspondent pas.";
    }

    // Si aucune erreur, traiter les données
    if (empty($errors)) {
        // Hacher le mot de passe
        $motdepasse_hache = password_hash($motdepasse, PASSWORD_DEFAULT);

        // Préparer la requête SQL
        $stmt = $pdo->prepare("INSERT INTO users (pseudo, email, age, motdepasse) VALUES (?, ?, ?, ?)");

        try {
            // Exécuter la requête
            $stmt->execute([$pseudo, $email, $age, $motdepasse_hache]);

            // Afficher un message de confirmation et rediriger vers la page de connexion
            echo "<h1>Inscription réussie !</h1>";
            echo "<p>Votre compte a été créé avec succès. Vous allez être redirigé vers la page de connexion.</p>";
            echo "<script>setTimeout(function() { window.location.href = 'connexion.html'; }, 3000);</script>";
            exit();
        } catch (\PDOException $e) {
            $errors[] = "Une erreur est survenue lors de l'inscription.";
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
    header("Location: inscription.html");
    exit();
}
?>
