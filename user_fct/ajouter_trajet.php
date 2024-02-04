<?php

@include '../config.php';

session_start();

// Vérifier si l'encadreur est connecté
if(isset($_SESSION['email'])){

    // Récupérer l'identifiant de l'utilisateur à partir de l'adresse e-mail stockée dans la session
    $email = $_SESSION['email'];

    $select_user = "SELECT  nom, prenom, mat_etd FROM utilisateur WHERE email='$email'";

    $result_user = mysqli_query($conn, $select_user);

    $row_user = mysqli_fetch_assoc($result_user);
  
    $nom_user = $row_user['nom'];
    $prenom_user = $row_user['prenom'];
    $mat_user = $row_user['mat_etd'];
  };


if(isset($_POST['submit'])){

   $depart = mysqli_real_escape_string($conn, $_POST['depart']);
   $destination = mysqli_real_escape_string($conn, $_POST['destination']);
   $latitude = mysqli_real_escape_string($conn, $_POST['latitude']);
   $longitude = mysqli_real_escape_string($conn, $_POST['longitude']);
   $date_dep = mysqli_real_escape_string($conn, $_POST['start_date']);
   $heure_dep = mysqli_real_escape_string($conn, $_POST['start_time']);
   $passager = mysqli_real_escape_string($conn, $_POST['nb_passager']);
   $prix =mysqli_real_escape_string($conn, $_POST['prix']);


    $insert = "INSERT INTO trajet ( depart, destination, latitude , longitude , date_dep , heure_dep , nb_passager , conducteur, place_dispo,prix ) 
    VALUES('$depart', '$destination', '$latitude','$longitude','$date_dep','$heure_dep','$passager' , '$mat_user' , '$passager' , '$prix')";
    $result=mysqli_query($conn, $insert);

    if ($result) {
    $success = "Le trajet a bien été enregistré.";
    } else {
    $error = "Une erreur s'est produite lors de l'enregistrement.";
    }
        
        
}

;



?>


<html lang="en">

<head>
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600&display=swap">
    <link rel="stylesheet" href="../css/style.css">
    <title>ajouter un trajet</title>
</head>

<body>
    
            
            <div class="form-container">

            
                <form action="" method="post">
                    <h3>Ajouter un trajet</h3>
                    <?php
            if (isset($error)) {
                echo '<span class="error-msg">' . $error . '</span>';
            } elseif (isset($success)) {
                echo '<span class="success-msg">' . $success . '</span>';
            }
            ?>

             <?php if(isset($errorr)): 
               echo '<span class="error-msg">' . $errorr . '</span>';
             endif; ?>

                    <div>
                    <!-- reccuperation de la poisition -->
                    <label for="depart">Départ :</label>
                    <input type="text" name="depart" id="depart" required placeholder="Obtention automatique de la position">
                      <!-- Bouton pour déclencher la géolocalisation -->
                    <button type="button" id="get-location-btn" class="form-btn"> Obtenir la position actuelle</button>
                    </div>

                    <!-- reccuperation des coordonnées gps -->
                    <input type="hidden" name="latitude" id="latitude" value="">
                    <input type="hidden" name="longitude" id="longitude" value="">

                    <div>
                    <label for="destination">Destination :</label>
                    <input type="text" name="destination" required placeholder="Destination">
                    </div>

                    <label for="depart_date">Date de depart :</label>
                    <input type="date" name="start_date" required>

                    <label for="depart_time">Heure de départ :</label>
                    <input type="time" name="start_time" required>

                    <label for="pasager">nombre de place pour le trajet :</label>
                    <input type="number" name="nb_passager" required placeholder="nombre de place pour le trajet">

                    <label for="prix">Prix trajet :</label>
                    <input type="number" name="prix" required placeholder="prix en DA">

                    <input type="submit" name="submit" value="Ajouter" class="form-btn">

                    
                <p>Vous souhaitez retouner sur votre profil? <a href="../conducteur_page.php"> <br> Mon profil</a></p>
                    
                </form>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        var departInput = document.getElementById('depart');
        var latitudeInput = document.getElementById('latitude');
        var longitudeInput = document.getElementById('longitude');
        var getLocationBtn = document.getElementById('get-location-btn');

        getLocationBtn.addEventListener('click', function () {
            // Vérifie si la géolocalisation est prise en charge
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function (position) {
                        // Succès : position obtenue
                        var latitude = position.coords.latitude;
                        var longitude = position.coords.longitude;

                        // Mettez à jour les champs de latitude et longitude
                        latitudeInput.value = latitude;
                        longitudeInput.value = longitude;

                        // Mettez à jour le champ de texte visible avec l'adresse  
                        // Appel à l'API de géocodage pour obtenir l'adresse
                        fetch('https://nominatim.openstreetmap.org/reverse?format=json&lat=' + latitude + '&lon=' + longitude)
                            .then(response => response.json())
                            .then(data => {
                                var address = data.display_name;
                                departInput.value = address;
                            })
                            .catch(error => {
                                console.error('Erreur lors de la récupération de l\'adresse:', error);
                            });

                        // Alerte pour indiquer le succès
                        alert('Position obtenue avec succès. Latitude : ' + latitude + ', Longitude : ' + longitude);
                    },
                    function (error) {
                        // Gestion des erreurs
                        console.error('Erreur de géolocalisation :', error);

                        // Alerte pour indiquer une erreur
                        alert('Erreur lors de la récupération de la position.');
                    }
                );
            } else {
                // La géolocalisation n'est pas supportée par le navigateur
                console.log('La géolocalisation n\'est pas supportée par ce navigateur.');

                // Alerte pour indiquer une non-prise en charge
                alert('La géolocalisation n\'est pas supportée par ce navigateur.');
            }
        });
    });
</script>


               


        </div>
        
    

           
</body>

</html>
