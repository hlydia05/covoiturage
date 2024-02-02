<?php

@include 'config.php';

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $prenom = mysqli_real_escape_string($conn, $_POST['prenom']);
   $tel = mysqli_real_escape_string($conn, $_POST['phone']);
   $mat = mysqli_real_escape_string($conn, $_POST['mat']);
   $mat_v = mysqli_real_escape_string($conn, $_POST['mat_v']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = md5($_POST['password']);
   $cpass = md5($_POST['cpassword']);
  

   $select = " SELECT * FROM utilisateur WHERE email = '$email' && mdp = '$pass' ";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){

      $error[] = 'user already exist!';

   }else{

      if($pass != $cpass){
         $error[] = 'password not matched!';
      }else{
         $insert = "INSERT INTO utilisateur(nom , prenom ,num_tel,  mat_etd, email, mdp, matricule_v ) VALUES('$name', '$prenom','$tel' , '$mat' , '$email','$pass','$mat_v ' )";
         mysqli_query($conn, $insert);
         header('location:login.php');
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
   <title>register form</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<div class="form-container">

   <form action="" method="post">
      <h3>inscrivez-vous</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      <input type="text" name="name" required placeholder="entrer votre nom">
      <input type="text" name="prenom" required placeholder="entrer votre prenom">
      <input type="email" name="email" required placeholder="entrer votre email">
      <input type="tel" name="phone" required placeholder="entrer votre numero de telephone">
      <input type="text" name="mat" required placeholder="entrer votre matricule">
      <input type="text" name="mat_v" required placeholder="entrer la plaque d'immatriculation du vehicule">
      <input type="password" name="password" required placeholder="enterr votre mot de passe">
      <input type="password" name="cpassword" required placeholder="confirmer votre mot de passe">

    
      <input type="submit" name="submit" value="register now" class="form-btn">
      <p>deja inscrit? <a href="login_form.php">connectez</a></p>
   </form>

</div>

</body>
</html>