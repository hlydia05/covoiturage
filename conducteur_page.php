<?php

@include 'config.php';
session_start();

if(!isset($_SESSION['email'])){

   header('location:login.php');

}

// Vérifier si l'encadreur est connecté
if(isset($_SESSION['email'])){

  // Récupérer l'identifiant de l'encadreur à partir de l'adresse e-mail stockée dans la session
  $email = $_SESSION['email'];
  $select_user = "SELECT  nom, prenom, mat_etd FROM utilisateur WHERE email='$email'";
  $result_user = mysqli_query($conn, $select_user);
  $row_user = mysqli_fetch_assoc($result_user);

  $nom_user = $row_user['nom'];
  $prenom_user = $row_user['prenom'];
  $mat_user = $row_user['mat_etd'];
};

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/user.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./js/anime.min.js"></script>
    <script src="js/intro.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
    <title>Conducteur</title>

    <style>
    .header {
        
        padding: 20px;
        text-align: center;
    }

    .IntroMsg {
        margin-bottom: 20px;
    }

    h1 {
        font-size: 24px;
        color: #333;
        margin-bottom: 10px;
    }

    h2 {
        font-size: 18px;
        color: #555;
        margin-bottom: 10px;
    }

    h3 {
        font-size: 16px;
        color: #777;
        margin-bottom: 10px;
    }
</style>
 
</head>

<body>
    <div class="navBar" id="nv">
        <nav>
            <ul>
                <li><a href='admin_page.php'>ACCUEIL</a></li>

                <li><a href='nous.html'>À PROPOS</a></li>

                <li><a href='contact.html'>CONTACT</a></li>



                <li class="socialIcon"><a href="call:111-111-111"><i class="bi bi-telephone-forward"></i></a></li>

                <li class="socialIcon"><a href="https://www.instagram.com"><i class="bi bi-instagram"></i></a></li>

                <li class="socialIcon"><a href="mailto:example@example.com"><i class="bi bi-envelope-fill"></i></a></li>

              

                <li style="float:right"class="socialIcon logoutBtn">

                <a href="#" id="logoutDropdown">

                    <i class="bi bi-box-arrow-right"></i>

                </a>

                <ul class="dropdown">

                    <li class="couleur"><a href="logout.php">Déconnexion</a></li>

                </ul>

            </li>

            </ul>

        </nav>

    </div>

    <div class="sidebar">  

             <ul>
             <li>
        <a class="nav-item" href="user_fct/ajouter_trajet.php">Ajouter un trajet</a>
      </li>

      <li>
        <a class="nav-item" href="user_fct/consulter_mes_trajets.php">Consulter mes trajets</a>
      </li>
      <li>
        <a class="nav-item" href="user_fct/consultation_reservation.php">Consulter reservation</a>
      </li>
      

      


    </ul>

        </div>

        <div class="header">
    <div class="IntroMsg">
        <div class="container">
            <div class="content">
            <h1>Bonjour <span><?php echo $nom_user . " " . $prenom_user; ?></span></h1>
            <h2>Vous êtes sur cette plateforme en tant que conducteur</h2>
            </div>
        </div>

</div>
        </div>
    </div>

</body>
</html>