<?php

@include '../config.php';

session_start();

if(!isset($_SESSION['email'])){

   header('../location:login.php');

}


// Vérifier si le formulaire a été soumis
if(isset($_POST['submit'])) {
    // Récupérer les valeurs du formulaire
    $destination = mysqli_real_escape_string($conn, $_POST['destination']);
    $depart = mysqli_real_escape_string($conn, $_POST['depart']);
    $date_dep = mysqli_real_escape_string($conn, $_POST['start_date']);
    //$passager = mysqli_real_escape_string($conn, $_POST['nb_passager']);
    $latitude = mysqli_real_escape_string($conn, $_POST['latitude']);
   $longitude = mysqli_real_escape_string($conn, $_POST['longitude']);

    $rayon = 5;
    // Effectuer la recherche dans la base de données
    $query = "SELECT * FROM trajet t
          INNER JOIN utilisateur u ON t.conducteur = u.mat_etd
          WHERE t.destination = '$destination'
          /* AND t.depart = '$depart' */
          AND t.date_dep = '$date_dep'
          AND t.place_dispo > 0
          AND (6371 * ACOS(
            COS(RADIANS($latitude)) * COS(RADIANS(t.latitude)) * COS(RADIANS(t.longitude) - RADIANS($longitude)) + 
            SIN(RADIANS($latitude)) * SIN(RADIANS(t.latitude))
          )) <= $rayon
          ORDER BY (6371 * ACOS(
            COS(RADIANS($latitude)) * COS(RADIANS(t.latitude)) * COS(RADIANS(t.longitude) - RADIANS($longitude)) + 
            SIN(RADIANS($latitude)) * SIN(RADIANS(t.latitude))
          )) ASC"; // DESC pour trier du plus éloigné au plus proche

          
    $result = mysqli_query($conn, $query);

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
    <title>trajet</title>


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



<!-- tab resulat -->


<div class="header">
        <div class="IntroMsg">
            <div class="container">

                <h1 class="centered-title">TRAJETS TROUVES</h1>

                <?php if ($result) { ?>

                    <div class="container">


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
                                    <th>prix</th>
                                    <th>action</th>
                                   


                                </tr>
                            </thead>
                            <?php while ($row = mysqli_fetch_assoc($result)) { 
                                $distance = (6371 * acos(
                                    cos(deg2rad($latitude)) * cos(deg2rad($row['latitude'])) * cos(deg2rad($row['longitude']) - deg2rad($longitude)) + 
                                    sin(deg2rad($latitude)) * sin(deg2rad($row['latitude']))
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
                                   
                            <?php } ?>
                        </table>
                    </div>
                    </div>
        <div class="profile-button">
        <a href="../page_utilisateur.php" class="btn"><i class="fas fa-user"></i> Mon profil</a>
   </div>

                <?php } else {

                    echo "Erreur lors de la recherche dans la base de données : " . mysqli_error($conn);
                } ?>

                <?php
                if (mysqli_num_rows($result) == 0) {
                    echo "Aucun résultat trouvé.";
                }

                // Libérer les résultats de la mémoire
                mysqli_free_result($result);

                // Fermer la connexion à la base de données
                mysqli_close($conn);
                ?>
            </div>
        </div>
    </div>


<!-- tab resulat -->

<?php
   }else{
         
        echo "Erreur lors de la recherche dans la base de données : " . mysqli_error($conn);
    }





    

?>

</body>
</html>
