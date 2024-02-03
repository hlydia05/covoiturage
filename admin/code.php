<?php

@include '../config.php';
@include '../functions/myfunctions.php';
session_start();


if(isset($_POST['max_passagers'])){
    $maxPass = mysqli_real_escape_string($conn, $_POST['maxPass']);
    $max_query = "UPDATE trajet SET  max_passagers=$maxPass"; 
    $max_query_run = mysqli_query($conn, $max_query);

    if($max_query_run){
        redirect("admin_page.php", "max passengers altered successfully");
    }
    else{
        redirect("admin_page.php", "something went wrong");
    }
}

if(isset($_POST['ajout_admin'])){
    $nom = mysqli_real_escape_string($conn, $_POST['nom']);
    $prenom = mysqli_real_escape_string($conn, $_POST['prenom']);
    $mail = mysqli_real_escape_string($conn, $_POST['email']);
    $matricule = mysqli_real_escape_string($conn, $_POST['mat_etd']);
    $password = md5($_POST['mdp']);
    
    $admin_query = "INSERT INTO administrateur(nom, prenom, email, mat_etd, mdp) VALUES('$nom', '$prenom', '$mail', '$matricule', '$password')";
    $admin_query_run = mysqli_query($conn, $admin_query);

    if($admin_query_run){
        redirect("addAdmins.php", "admin added successfully");
    }
    else{
        redirect("addAdmins.php", "something went wrong");
    }
}
elseif(isset($_POST['delete_user_btn'])){
    $userid = mysqli_real_escape_string($conn, $_POST['mat_etd']);
    $delete_user_query="DELETE FROM user WHERE mat_etd='$userid'";
    $delete_user_query_run=mysqli_query($conn, $delete_user_query);
    if($delete_user_query_run){
        redirect("users.php", "user deleted successfully");
    }
    else{
        redirect("users.php", "something went wrong");
    }
}
elseif(isset($_POST['delete_conducteur_btn'])){
    $conducteurid = mysqli_real_escape_string($conn, $_POST['mat_etd']);
    $delete_conducteur_query="DELETE FROM utilisateur WHERE mat_etd='$conducteurid'";
    $delete_conducteur_query_run=mysqli_query($conn, $delete_conducteur_query);
    if($delete_conducteur_query_run){
        redirect("conducteurs.php", "driver deleted successfully");
    }
    else{
        redirect("conducteurs.php", "something went wrong");
    }
}
elseif(isset($_POST['delete_trajet_btn'])){
    $trajetid = mysqli_real_escape_string($conn, $_POST['id_trajet']);
    $delete_trajet_query="DELETE FROM trajet WHERE mat_etd='$trajetid'";
    $delete_trajet_query_run=mysqli_query($conn, $delete_trajet_query);
    if($delete_trajet_query_run){
        redirect("trajets.php", "trajet deleted successfully");
    }
    else{
        redirect("trajets.php", "something went wrong");
    }
}


?>
