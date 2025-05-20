<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Connexion - NiniProno</title>
  <link rel="icon" href="favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
  <style>
    body {
      background-color: #f8f9fa;
    }
    .bg-royal-blue {
      background-color: #002366;
    }
    .text-gold {
      color: #FFD700;
    }
  </style>
</head>
<body>

  <!-- En-tête -->
  <header class="bg-royal-blue text-white py-3">
    <div class="container text-center">
      <h1 class="mb-0">Connexion à NiniProno</h1>
    </div>
  </header>

  <!-- Message de confirmation -->
  <div class="container my-3">
    <?php
    session_start();
    if (isset($_SESSION['message'])) {
        echo '<div class="alert alert-success">' . $_SESSION['message'] . '</div>';
        unset($_SESSION['message']); // Supprimer le message après l'avoir affiché
    }
    ?>
  </div>

  <!-- Formulaire de connexion -->
  <main class="container my-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <form action="traitement_connexion.php" method="POST" class="border p-4 shadow rounded bg-white">
          <h2 class="mb-4 text-center text-royal-blue">Se connecter</h2>

          <div class="mb-3">
            <label for="email" class="form-label">Adresse e-mail</label>
            <input type="email" class="form-control" id="email" name="email" required />
          </div>

          <div class="mb-3">
            <label for="motdepasse" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="motdepasse" name="motdepasse" required />
          </div>

          <button type="submit" class="btn btn-primary w-100 bg-royal-blue text-gold border-0">Se connecter</button>
        </form>
      </div>
    </div>
  </main>

  <!-- Pied de page -->
  <footer class="bg-royal-blue text-white text-center py-3">
    <div class="container">
      <p>&copy; 2025 NiniProno. Tous droits réservés.</p>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
