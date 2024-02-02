<?php

@include '../config.php';

session_start();

// Vérifier si l'urtilisateur est connecté
if(isset($_SESSION['email'])){

    // Récupérer l'identifiant de l'utilisateur à partir de l'adresse e-mail stockée dans la session
    $email = $_SESSION['email'];

    $select_user = "SELECT  nom, prenom, mat_etd FROM utilisateur WHERE email='$email'";

    $result_user = mysqli_query($conn, $select_user);

    $row_user = mysqli_fetch_assoc($result_user);
  
    $nom_user = $row_user['nom'];
    $prenom_user = $row_user['prenom'];
    $mat_user = $row_user['mat_etd'];

     // Sélectionner tous les trajets ajoutés par l'utilisateur spécifique
     $select_sujets = "SELECT * FROM trajet WHERE conducteur='$mat_user'  ORDER BY date_dep DESC,heure_dep DESC ";
     $result_sujets = mysqli_query($conn, $select_sujets);

  };


if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM trajet WHERE id_trajet = $id");
    header('location: consulter_mes_trajets.php');
 };

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>consulter trajets</title>

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
                  <a href="consulter_mes_trajets.php">tous vos trajets</a>
               </li>
               <li>
                  <a href="consulter_mes_trajets_avenir.php">vos trajets a venir</a>
               </li>
               
                


                
   </ul>
   </nav>
</div>
   
<div class="container">

  
<h1 class="centered-title">TOUS LES TRAJETS QUE VOUS AVEZ PUBLIER</h1>

   <div class="product-display" style="overflow-x: auto;">
      <table class="product-display-table">
         <thead>
         <tr>
            <th>Depart</th>
            <th>Destination</th>
            <th>Date de depart</th>
            <th>heure de depart</th>
            <th>Nombre de passagers</th>
            <th>Conducteur</th>
            <th>action</th>
            
            
         </tr>
         </thead>
         <?php  while($row = mysqli_fetch_assoc($result_sujets)){ ?>
         <tr>
                 <td> <?php echo  $row['depart'] ; ?></td>
                 <td> <?php echo  $row['destination'] ; ?></td>

                 <td> <?php echo  $row['date_dep'] ; ?> </td>
                 <td> <?php echo  $row['heure_dep'] ; ?> </td>
                 <td> <?php echo  $row['nb_passager'] ; ?> </td>
                 <td> <?php echo  $nom_user . " " . $prenom_user . "";?> </td>
                 
                 <td>
                 <a href="modifier_trajet.php?edit=<?php echo $row['id_trajet']; ?>" class="btn"> <i class="fas fa-edit"></i> edit </a>
                 <a href="consulter_mes_trajets.php?delete=<?php echo $row['id_trajet']; ?>" class="btn"> <i class="fas fa-trash"></i> delete </a>
                 </td>

                 
           
            
         </tr>


      <?php } ?>
      
      </table>
   </div>
        <div class="profile-button">
        <a href="../conducteur_page.php" class="btn"><i class="fas fa-user"></i> Mon profil</a>
   </div>

</div>







<script>
  var prevScrollpos = window.pageYOffset;
window.onscroll = function() {
  var currentScrollPos = window.pageYOffset;
  if (prevScrollpos > currentScrollPos) {
    document.getElementById("nv").style.top = "0";
  } else {
    document.getElementById("nv").style.top = "-100px";
  }
  prevScrollpos = currentScrollPos;
}

</script>

</body>
</html>