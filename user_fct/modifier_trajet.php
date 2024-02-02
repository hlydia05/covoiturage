<?php

@include '../config.php';


$id = $_GET['edit'];

if(isset($_POST['update_product'])){

   $date = $_POST['date'];
   $heure = $_POST['heure'];
   $nb_pass = $_POST['nb_pass'];
   
   

   if(empty($date) || empty($heure) || empty($nb_pass)){
      $message[] = 'please fill out all!';    
   }else{

      $update_data = "UPDATE trajet SET date_dep='$date',  heure_dep ='$heure', nb_passager='$nb_pass'
       WHERE id_trajet= '$id'";
      $upload = mysqli_query($conn, $update_data);

      if($upload){
        $success = "Les modifications ont été enregistrées avec succès.";
      }

}
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="../css/curd.css">
</head>
<body>

<?php
   if(isset($message)){
      foreach($message as $message){
         echo '<span class="message">'.$message.'</span>';
      }
   }
?>

<div class="container">


<div class="admin-product-form-container centered">

   <?php
      
      $select = mysqli_query($conn, "SELECT * FROM trajet WHERE id_trajet = '$id'");
      while($row = mysqli_fetch_assoc($select)){

   ?>
   
   <form action="" method="post" enctype="multipart/form-data">
      <h3 class="title">Modifier trajet</h3>

      <?php
       if (isset($error)) {
      echo '<span class="error-msg">' . $error . '</span>';
       } elseif (isset($success)) {
      echo '<span class="success-msg">' . $success . '</span>';
       }
      ?>


      <input type="date" class="box" name="date" value="<?php echo $row['date_dep']; ?>" placeholder="deta de depart">
      <input type="time" class="box" name="heure" value="<?php echo $row['heure_dep']; ?>" placeholder="lieu de depart">

      <input type="text" class="box" name="nb_pass" value="<?php echo $row['nb_passager']; ?>" placeholder="nombre de passagers sur le trajets">
      
      

      <input type="submit" value="enregister les modifications" name="update_product" class="btn">
      <a href="consulter_mes_trajets.php" class="btn">Revenir</a>
   </form>
   


   <?php }; ?>

   

</div>

</div>

</body>
</html>