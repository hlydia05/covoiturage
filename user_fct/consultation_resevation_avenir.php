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
  


	// Sélectionner tous les trajet reserve du conducteur spécifique
    $select_reserv = "SELECT * FROM reservation WHERE conducteur='$mat_user'  AND (
        date_dep > CURRENT_DATE
        OR (date_dep = CURRENT_DATE AND heure_dep > CURRENT_TIME)
        ) ORDER BY date_dep DESC, heure_dep DESC";
    $result_reserv = mysqli_query($conn, $select_reserv);


   
   };



 if (isset($_GET['delete'])) {
   $id_reservation = $_GET['delete'];

   // Récupérer l'ID du trajet associé à la réservation
   $select_trajet_id = "SELECT trajet FROM reservation WHERE id_reservation = $id_reservation";
   $result_trajet_id = mysqli_query($conn, $select_trajet_id);

   if ($result_trajet_id) {
       $row_trajet_id = mysqli_fetch_assoc($result_trajet_id);
       $id_trajet = $row_trajet_id['trajet'];

       // Supprimer la réservation
       mysqli_query($conn, "DELETE FROM reservation WHERE id_reservation = $id_reservation");

       // Mettre à jour le nombre de places disponibles dans la table trajet
       mysqli_query($conn, "UPDATE trajet SET place_dispo = place_dispo + 1 WHERE id_trajet = $id_trajet");

       header('location:consultation_reservation.php');
   } else {
       die('Erreur lors de la récupération de l\'ID du trajet : ' . mysqli_error($conn));
   }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>resevation</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/curd.css">

   <style>
      .centered-title {
         text-align: center;
         margin-top: 30px;
         margin-bottom: 50px;
      }
   </style>

</head>
<body>
<div class="navBar" id="nv">
   <nav>
<ul>
               <li>
                  <a href="consultation_reservation.php">toutes vos reservations</a>
               </li>
               <li>
                  <a href="consultation_resevation_avenir.php">vos reservation a venir</a>
               </li>
               
                


                
   </ul>
   </nav>
</div>
   
<div class="container">

<h1 class="centered-title">VOS RESEVATIONS POUR LES TRAJETS A VENIR</h1>

   <div class="product-display" style="overflow-x: auto;">
      <table class="product-display-table">
         <thead>
         <tr>
            <th>Depart</th>
            <th>Destination</th>
            <th>date de depart</th>
            <th>heure de depart</th>
            <th>passager</th>
            <th>identifiant du passager</th>
            <th>prix</th>
            <th>action</th>
            
         </tr>
         </thead>
         <?php  while($row = mysqli_fetch_assoc($result_reserv)){ 
             $select_PRIX = "SELECT * FROM trajet WHERE id_trajet='" . $row['trajet'] . "'";
             $result_PRIX = mysqli_query($conn, $select_PRIX);
             $row_prix = mysqli_fetch_assoc($result_PRIX);
             ?>
         <tr>
                 <td> <?php echo  $row['depart'] ; ?></td>
                 <td> <?php echo  $row['destination'] ; ?></td>
                 <td> <?php echo  $row['date_dep'] ; ?> </td>
                 <td> <?php echo  $row['heure_dep'] ; ?> </td>
                 <td> <?php echo  $row['nom_voyageur'] ; ?> </td>
                 <td> <?php echo  $row['user'] ; ?> </td>
                 <td> <?php echo  $row_prix['prix'] ; ?> </td>
            <td>

              <a href="consultation_reservation.php?delete=<?php echo $row['id_reservation']; ?>" class="btn"> <i class="fas fa-trash"></i> annuller la reservation</a>
              
            </td>
            </td>
            
         </tr>
      <?php } ?>
      </table>
   </div>
        <div class="profile-button">
        <a href="../conducteur_page.php" class="btn"><i class="fas fa-user"></i> Mon profil</a>
   </div>

</div>


</body>
</html>
