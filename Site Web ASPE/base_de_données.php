<!-- Version finale - Page Base de Données -->



<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=membres_aspe;charset=utf8;', 'root', '');

// Traitement d'inscription

$isSignUpMode = false;

if(isset($_POST['envoi_inscription'])) {
  if(!empty($_POST['username']) && !empty($_POST['pseudo']) && !empty($_POST['mdp']) && !empty($_POST['mdp_confirm'])) {
      $username = htmlspecialchars($_POST['username']);
      $pseudo = htmlspecialchars($_POST['pseudo']);
      $mdp = sha1($_POST['mdp']);
      $mdp_confirm = sha1($_POST['mdp_confirm']);

      if ($mdp === $mdp_confirm) {
          $insertUser = $bdd->prepare('INSERT INTO users(username, pseudo, mdp) VALUES(?, ?, ?)');
          $insertUser->execute(array($username, $pseudo, $mdp));

          $_SESSION['username'] = $username;
          $_SESSION['pseudo'] = $pseudo;
          $_SESSION['mdp'] = $mdp;
          $_SESSION['id'] = $bdd->lastInsertId();
          $success_message_inscription = "Inscription réussie !";
          $isSignUpMode = true;
      } else {
          $isSignUpMode = true;
          $error_message_inscription = "Les mots de passe ne correspondent pas";
      }
  } else {
      $isSignUpMode = true;
      $error_message_inscription = "Veuillez compléter tous les champs";
  }
}

// Traitement de connexion

if(isset($_POST['envoi_connexion'])){
    if(!empty($_POST['pseudo']) && !empty($_POST['mdp'])){
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $mdp = sha1($_POST['mdp']);

        $recupUser = $bdd->prepare('SELECT * FROM users WHERE pseudo = ? AND mdp = ?');
        $recupUser->execute(array($pseudo, $mdp));

        if($recupUser->rowCount() > 0){
            $_SESSION['pseudo'] = $pseudo;
            $_SESSION['mdp'] = $mdp;
            $_SESSION['id'] = $recupUser->fetch()['id'];
            header('Location: index + connecter.html'); // Redirection vers la page index après la connexion
            exit;
        } else {
            $error_message_connexion = "Vos identifiants sont incorrects";
        }
    } else {
        $error_message_connexion = "Veuillez compléter tous les champs";
    }
}

// Traitement de déconnexion

if(isset($_GET['action']) && $_GET['action'] === 'deconnexion'){
    $_SESSION = array();
    session_destroy();
    exit;
}
?>

<!-- Code HTML -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="base_de_données.css">
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <title>Formulaire d'inscription et de connexion</title>
</head>
<body>
    
<!-- contenu HTML de l'interface d'inscription/connexion -->

    <div class="container <?php echo ($isSignUpMode) ? 'sign-up-mode' : ''; ?>">
      <div class="forms-container">
        <div class="signin-signup">
          <form method="POST" action="" class="sign-in-form">
            <h2 class="title">Connexion</h2>

<?php if(isset($error_message_connexion)): ?>
    <p class="error-message"><?php echo $error_message_connexion; ?></p>
<?php endif; ?>

            <div class="input-field">
              <i class="fas fa-envelope"></i>
              <input type="email" placeholder="Adresse Mail" name="pseudo">
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" placeholder="Mot de passe" name="mdp">
            </div>
            <div class="remember-forgot">
              <label><input type="checkbox"> Se souvenir de moi</label>
              <a href="modification_mdp\mot_de_passe_oublie.php">Mot de passe oublié ?</a>
          </div>
            <input type="submit" value="Se connecter" class="btn solid" name="envoi_connexion">
            <p class="social-text">Ou se connecter via les réseaux sociaux</p>
            <div class="social-media">
              <a href="#" class="social-icon">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-twitter"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-google"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-linkedin-in"></i>
              </a>
            </div>
          </form>
          <form method="POST" action="" class="sign-up-form">
            <h2 class="title">Créer un compte</h2>

<?php if(isset($success_message_inscription)): ?>
    <p class="success-message"><?php echo $success_message_inscription; ?></p>
<?php endif; ?>

<?php if(isset($error_message_inscription)): ?>
    <p class="error-message"><?php echo $error_message_inscription; ?></p>
<?php endif; ?>

            <div class="input-field">
              <i class="fas fa-envelope"></i>
              <input type="text" placeholder="Votre prénom" name="username">
            </div>
            <div class="input-field">
              <i class="fas fa-envelope"></i>
              <input type="email" placeholder="Adresse Mail" name="pseudo">
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" placeholder="Mot de passe" name="mdp">
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" placeholder="Confirmation du mot de passe" name="mdp_confirm">
            </div>
            <input type="submit" class="btn" value="S'inscrire" name="envoi_inscription">
            <p class="social-text">Ou s'inscrire via les réseaux sociaux</p>
            <div class="social-media">
              <a href="#" class="social-icon">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-twitter"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-google"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-linkedin-in"></i>
              </a>
            </div>
          </form>
        </div>
      </div>

      <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
            <h3>Première visite sur la plateforme ?</h3>
            <p>
              Rejoignez la communauté ASPE !
            </p>
            <button class="btn transparent" id="sign-up-btn">
              S'inscrire
            </button>
          </div>
          <img src="img\undraw_right_direction_tge8.svg" class="image" alt="">
        </div>
        <div class="panel right-panel">
          <div class="content">
            <h3>Déjà inscrit(e) ?</h3>
            <p>
              Connectez-vous à votre espace personnel pour découvrir les dernières nouveautés.
            </p>
            <button class="btn transparent" id="sign-in-btn">
              Se connecter
            </button>
          </div>
          <img src="img\undraw_goals_re_lu76.svg" class="image" alt="">
        </div>
      </div>
    </div>

    <!-- JavaScript -->
    
    <script>

        const sign_in_btn = document.querySelector("#sign-in-btn");
        const sign_up_btn = document.querySelector("#sign-up-btn");
        const container = document.querySelector(".container");

        sign_up_btn.addEventListener("click", () => {
            container.classList.add("sign-up-mode");
        });

        sign_in_btn.addEventListener("click", () => {
            container.classList.remove("sign-up-mode");
        });
        
    </script>

</body>
</html>