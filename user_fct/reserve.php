<?php
@include '../config.php';

session_start();

if(!isset($_SESSION['email'])){

    header('location:../login.php');
    exit();
 
 }



if (isset($_GET['edit'])) {

    //on reccupere l'id du trajet qui est envoye dans le lien
    $idtrajet = mysqli_real_escape_string($conn, $_GET['edit']);
    //on reccupere l'id de l'utilisateur a partir de la session
    $email_user = $_SESSION['email'];

    // Récupérer les info de l'utilisateur
	 $select_user = "SELECT  mat_etd , nom , prenom FROM user WHERE email='$email_user'";
	 $result_user = mysqli_query($conn, $select_user);
	 $row_user = mysqli_fetch_assoc($result_user);
	 $user = $row_user['nom'] . ' '.$row_user['prenom'] ;
   $mat = $row_user['mat_etd'];



     //on verifie si l'utilisateur a deja reserver ce trajer
    $checkreserv = "SELECT * FROM reservation WHERE (trajet = '$idtrajet'AND user='$mat' ) ";
    $resultreserv = mysqli_query($conn, $checkreserv );

    if (mysqli_num_rows($resultreserv) > 0) {
    // Afficher un message d'erreur ou rediriger vers une page appropriée
    $error = "Vous avez déjà réservé ce trajet.";
    header('location:consult_reserv.php?error=' . urlencode($error));
    exit();
   } else {




    // Récupérer les informations du trajet

     $selecttrajet = "SELECT t.depart, t.destination, t.date_dep, t.heure_dep, u.nom, u.prenom, t.conducteur FROM trajet t
       INNER JOIN utilisateur u ON t.conducteur = u.mat_etd
       WHERE id_trajet = $idtrajet";
     $resulttrajet = mysqli_query($conn, $selecttrajet);
     $row_trajet = mysqli_fetch_assoc($resulttrajet);

     $depart = $row_trajet['depart'];
     $destination = $row_trajet['destination'];
     $start_date = $row_trajet['date_dep'];
     $start_time = $row_trajet['heure_dep'];
     $conducteur = $row_trajet['nom'] . ' ' .$row_trajet['prenom'];
     $mat_cond = $row_trajet['conducteur'];


    $insert_reserve = "INSERT INTO reservation (user, conducteur,trajet ,depart, destination, nom_cond , nom_voyageur, date_dep, heure_dep) 
    VALUES ('$mat','$mat_cond', '$idtrajet', '$depart', '$destination', '$conducteur', '$user','$start_date','$start_time' )";
    mysqli_query($conn, $insert_reserve);

    // Mettre à jour le nombre de place dispo
    $updatetrajet = "UPDATE trajet SET place_dispo = place_dispo-1 WHERE id_trajet = $idtrajet";
    mysqli_query($conn, $updatetrajet);

 
    header('location:consult_reserv.php');
    exit();
}
}

?>
