<?php

@include '../config.php';


session_start();

if(!isset($_SESSION['email'])){

   header('location:../login.php');

}



if(isset($_POST['submit'])){


   

   $depart = mysqli_real_escape_string($conn, $_POST['depart']);
   $latitude = mysqli_real_escape_string($conn, $_POST['latitude']);
   $longitude = mysqli_real_escape_string($conn, $_POST['longitude']);
   $destination = mysqli_real_escape_string($conn, $_POST['destination']);
   $date_dep = mysqli_real_escape_string($conn, $_POST['start_date']);
   $heure_dep = mysqli_real_escape_string($conn, $_POST['start_time']);
   $passager = mysqli_real_escape_string($conn, $_POST['nb_passager']);


   


   
        
        
}

;



?>


<html lang="en">

<head>
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600&display=swap">
    <link rel="stylesheet" href="../css/style.css">
    <title>rechercher un trajet</title>
  
  <style>
.form-container form .error-msg{
   margin:10px 0;
   display: block;
   background: crimson;
   color:#fff;
   border-radius: 5px;
   font-size: 20px;
   padding:10px;
}
</style>
</head>

<body>

    
            
            <div class="form-container">

          
            <form action="resultat_recherche.php" method="post">
            <?php
                if (isset($_GET['error'])) {
                    $errorMessage = $_GET['error'];
                    echo '<span class="error-msg">' . $errorMessage . '</span>';
                }
                ?>

                    <h3>Rechercher un trajet</h3>
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


                    <!-- <label for="pasager">nombre de place pour le trajet :</label>
                    <input type="number" name="nb_passager" required placeholder="nombre de place pour le trajet"> -->

                    <input type="submit" name="submit" value="rechercher" class="form-btn">

                    
                <p>Vous souhaitez retouner sur votre profil? <a href="../page_utilisateur.php"> <br> Mon profil</a></p>
                    
                </form>




               


        </div>
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
        
    

           
</body>

</html>