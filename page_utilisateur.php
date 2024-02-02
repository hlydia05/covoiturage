<?php

@include 'config.php';
session_start();

if(!isset($_SESSION['email'])){

   header('location:login.php');

}

// Vérifier si l'urtilisateur est connecté
if(isset($_SESSION['email'])){

    // Récupérer l'identifiant de l'utilisateur à partir de l'adresse e-mail stockée dans la session
    $email = $_SESSION['email'];

    $select_user = "SELECT  nom, prenom, mat_etd FROM user WHERE email='$email'";

    
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
    <title>Utilisateur</title>


<style>
   .centered-title {
      text-align: center;
      margin-top: 30px;
      margin-bottom: 50px;
   }
</style>
    

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
        <a class="nav-item" href="user_fct/rechercher_trajet.php">Rechercher trajet</a>
    </li>

      <li>
        <a class="nav-item" href="user_fct/reserver_trajet.php">Reserver trajet</a>
      </li>

      <li>
        <a class="nav-item" href="user_fct/consult_reserv.php">Consulter mes reservations</a>
      </li>

      


    </ul>

        </div>

        <div class="header">
    <div class="IntroMsg">
        <div class="container">

        <h1 class="centered-title">TRAJETS</h1>
   <?php

   $select = mysqli_query($conn, "SELECT t.depart, t.destination, t.date_dep, t.heure_dep, t.nb_passager, u.nom, u.prenom, t.place_dispo
                                    FROM trajet t
                                    INNER JOIN utilisateur u ON t.conducteur = u.mat_etd
                                    WHERE t.place_dispo > 0
                                    AND (
                                    t.date_dep > CURRENT_DATE
                                    OR (t.date_dep = CURRENT_DATE AND t.heure_dep > CURRENT_TIME)
                                    )
                                    ORDER BY t.date_dep DESC  ");
   
   ?>
   <div class="product-display" style="overflow-x: auto;">
      <table class="product-display-table">
         <thead>
         <tr>
            <th>Depart</th>
            <th>Destination</th>
            <th>Date de depart</th>
            <th>heure de depart</th>
            <th>Nombre de passagers</th>
            <th>Place disponible</th>
            <th>Conducteur</th>
            
            
         </tr>
         </thead>
         <?php while($row = mysqli_fetch_assoc($select)){ ?>
            <tr>
                 <td> <?php echo  $row['depart'] ; ?></td>
                 <td> <?php echo  $row['destination'] ; ?></td>

                 <td> <?php echo  $row['date_dep'] ; ?> </td>
                 <td> <?php echo  $row['heure_dep'] ; ?> </td>
                 <td> <?php echo  $row['nb_passager'] ; ?> </td>
                 <td> <?php echo  $row['place_dispo'] ; ?> </td>
                 <td><?php echo $row['nom'] . ' ' . $row['prenom']; ?></td>
                 
                 
                 
           
            
         </tr>
      <?php } ?>
      </table>



      <h1 class="centered-title">TRAJETS A PROXIMITE</h1>
   

<?php


// Récupérer les données de géolocalisation depuis le corps de la requête POST
$data = json_decode(file_get_contents('php://input'), true);

// Vérifier si les données sont présentes et valides
if (isset($data['latitude']) && isset($data['longitude'])) {
    $latitude = mysqli_real_escape_string($conn, $data['latitude']);
    $longitude = mysqli_real_escape_string($conn, $data['longitude']);
   
    // Mettre à jour la base de données avec les nouvelles coordonnées
    $updateQuery = "UPDATE user SET latitude = '$latitude', longitude = '$longitude' WHERE mat_etd =  '$mat_user'";
    echo "Latitude: $latitude, Longitude: $longitude, mat_user: $mat_user";
    
    if (mysqli_query($conn, $updateQuery)) {
        // Succès de la mise à jour
        echo "Mise à jour de la géolocalisation réussie.";
    } else {
        // Erreur lors de la mise à jour
        echo "Erreur lors de la mise à jour de la géolocalisation : " . mysqli_error($conn);
    }
}

$userQuery = mysqli_query($conn, "SELECT latitude, longitude FROM `user` WHERE mat_etd = '$mat_user'");
if ($userQuery) {
    $userData = mysqli_fetch_assoc($userQuery);
    $userLatitude = $userData['latitude'];
    $userLongitude = $userData['longitude'];

} else {
    echo "Erreur lors de la récupération des données utilisateur: " . mysqli_error($conn);
}


/// Rayon en kilomètres
$rayon = 5;

// Requête SQL pour sélectionner les trajets dans le rayon et ceux ayant la même position
/*$query = "SELECT *
          FROM trajet
          WHERE 
          (6371 * ACOS(
            COS(RADIANS($userLatitude)) * COS(RADIANS(latitude)) * COS(RADIANS(longitude) - RADIANS($userLongitude)) + 
            SIN(RADIANS($userLatitude)) * SIN(RADIANS(latitude))
          )) <= $rayon";
*/

$query = "SELECT t.depart, t.destination, t.date_dep, t.heure_dep, t.nb_passager, u.nom, u.prenom,t.latitude ,t.longitude,t.place_dispo
          FROM trajet t
          INNER JOIN utilisateur u ON t.conducteur = u.mat_etd
          WHERE t.place_dispo > 0
          AND t.date_dep >= CURRENT_DATE
          AND
          (6371 * ACOS(
            COS(RADIANS($userLatitude)) * COS(RADIANS(t.latitude)) * COS(RADIANS(t.longitude) - RADIANS($userLongitude)) + 
            SIN(RADIANS($userLatitude)) * SIN(RADIANS(t.latitude))
          )) <= $rayon
          ORDER BY t.date_dep DESC, heure_dep DESC";
        




$result = mysqli_query($conn, $query);
$result2 = mysqli_query($conn, $query);

//verifier les trajts trouves et afficher leur nombre
if ($result) {
    
    $numRows = mysqli_num_rows($result);
    
    echo "Nombre de trajets trouvés : $numRows";
    
}
/*
//afficher la distance trouvé pour deboger
while ($row = mysqli_fetch_assoc($result)) {
    // Afficher la distance calculée pour débogage
    $distance = (6371 * acos(
        cos(deg2rad($userLatitude)) * cos(deg2rad($row['latitude'])) * cos(deg2rad($row['longitude']) - deg2rad($userLongitude)) + 
        sin(deg2rad($userLatitude)) * sin(deg2rad($row['latitude']))
    ));
    echo "Distance calculée : $distance";
}
*/
//fin de la verification

?>

   
   <div class="product-display" style="overflow-x: auto;">
      <table class="product-display-table">
         <thead>
         <tr>
            <th>Depart</th>
            <th>Destination</th>
            <th>Date de depart</th>
            <th>heure de depart</th>
            <th>Nombre de passagers</th>
            <th>Place disponible</th>
            <th>Conducteur</th>
            <th>distance</th>
            
            
         </tr>
         </thead>
         <?php while($row = mysqli_fetch_assoc($result2)){

            $distance = (6371 * acos(
                cos(deg2rad($userLatitude)) * cos(deg2rad($row['latitude'])) * cos(deg2rad($row['longitude']) - deg2rad($userLongitude)) + 
                sin(deg2rad($userLatitude)) * sin(deg2rad($row['latitude']))
            ));
             ?>
                
            <tr>
                 <td> <?php echo  $row['depart'] ; ?></td>
                 <td> <?php echo  $row['destination'] ; ?></td>

                 <td> <?php echo  $row['date_dep'] ; ?> </td>
                 <td> <?php echo  $row['heure_dep'] ; ?> </td>
                 <td> <?php echo  $row['nb_passager'] ; ?> </td>
                 <td> <?php echo  $row['place_dispo'] ; ?> </td>
                 <td><?php echo $row['nom'] . ' ' . $row['prenom']; ?></td>
                 <td> <?php echo  $distance. 'km' ; ?></td>
            
         </tr>
         
      <?php } ?>
      </table>
      


     

</div>
        </div>
    </div>

    <script>
        function updateLocation(position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;

            // Envoyer les nouvelles coordonnées au serveur
            sendLocationToServer(latitude, longitude);
        }

        function sendLocationToServer(latitude, longitude) {
            fetch('page_utilisateur.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ latitude: latitude, longitude: longitude }),
            });
        }

        function handleError(error) {
            console.error('Erreur de géolocalisation : ', error.message);
        }

        // Utiliser watchPosition pour suivre en continu les changements de position
        var watchId = navigator.geolocation.watchPosition(updateLocation, handleError);

        // Arrêter la surveillance lorsque la page est fermée ou que l'utilisateur part
        window.addEventListener('unload', function () {
            navigator.geolocation.clearWatch(watchId);
        });
</script>
</body>
</html>










                                   