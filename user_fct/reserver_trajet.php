<?php

@include '../config.php';

session_start();

// Vérifier si l'encadreur est connecté
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
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./js/anime.min.js"></script>
    <script src="js/intro.js"></script>
    <link rel="stylesheet" href="../css/curd.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
    <title>resever trajet</title>


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
   
<div class="container">

<h1 class="centered-title"> RESERVER UN TRAJET</h1>
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
}?>


<?php
//selectionner les trajets
   $result = mysqli_query($conn, "SELECT * FROM trajet t
                                    INNER JOIN utilisateur u ON t.conducteur = u.mat_etd
                                    WHERE t.place_dispo > 0
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
                                    <th>distance</th>
                                    <th>prix(DA)</th>
                                    <th>action</th>
                                   


                                </tr>
                            </thead>
                            <?php while ($row = mysqli_fetch_assoc($result)) { 
                                 $distance = (6371 * acos(
                                    cos(deg2rad($userLatitude)) * cos(deg2rad($row['latitude'])) * cos(deg2rad($row['longitude']) - deg2rad($userLongitude)) + 
                                    sin(deg2rad($userLatitude)) * sin(deg2rad($row['latitude']))
                                ));
                                ?>
                                <tr>
                                    <td><?php echo $row['depart']; ?></td>
                                    <td><?php echo $row['destination']; ?></td>
                                    <td><?php echo $row['date_dep']; ?> </td>
                                    <td><?php echo $row['heure_dep']; ?> </td>
                                    <td><?php echo $row['nb_passager']; ?> </td>
                                    <td> <?php echo  $row['place_dispo'] ; ?> </td>
                                    <td><?php echo $row['nom'] . ' ' . $row['prenom']; ?></td>
                                    <td> <?php echo  $distance. 'km' ; ?></td>
                                    <td><?php echo $row['prix']; ?> </td>
                                    <td>
                                     <a href="reserve.php?edit=<?php echo $row['id_trajet']; ?>" class="btn_ed"> <i class="fas fa-edit"></i> reserver </a>
                                    </td>  
                                    </tr> 
                                   
      <?php } ?>
      </table>
   </div>
        <div class="profile-button">
        <a href="../page_utilisateur.php" class="btn"><i class="fas fa-user"></i> Mon profil</a>
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
