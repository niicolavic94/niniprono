<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identifiant = $_POST['identifiant'];
    $motdepasse = $_POST['motdepasse'];

    // Connexion à la base de données (à adapter selon votre configuration)
    $pdo = new PDO('mysql:host=localhost;dbname=votre_base_de_donnees', 'utilisateur', 'motdepasse');

    // Vérifier si l'identifiant est un email ou un pseudo
    if (filter_var($identifiant, FILTER_VALIDATE_EMAIL)) {
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
    } else {
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE pseudo = ?");
    }

    $stmt->execute([$identifiant]);
    $user = $stmt->fetch();

    if ($user && password_verify($motdepasse, $user['motdepasse'])) {
        // Connexion réussie
        $_SESSION['user_id'] = $user['id'];
        header("Location: accueil.php");
        exit();
    } else {
        // Connexion échouée
        $_SESSION['error'] = "Identifiant ou mot de passe incorrect.";
        header("Location: connexion.php");
        exit();
    }
}
?>
