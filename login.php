<?php

@include 'config.php';

session_start();

if(isset($_POST['submit'])){

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = md5($_POST['password']);

   $select = " SELECT * FROM utilisateur WHERE email = '$email' && mdp = '$pass' ";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){

      $row = mysqli_fetch_array($result);
      $_SESSION['email'] = $row['email'];
      header('location:conducteur_page.php');
     
   }else{
      $select = " SELECT * FROM user WHERE email = '$email' && mdp = '$pass' ";
      $result = mysqli_query($conn, $select);
      if(mysqli_num_rows($result) > 0){
         $row = mysqli_fetch_array($result);
         $_SESSION['email'] = $row['email'];
         header('location:page_utilisateur.php');
      }else{
         $select = " SELECT * FROM administrateur WHERE email = '$email' && mdp = '$pass' ";
         $result = mysqli_query($conn, $select);
        if(mysqli_num_rows($result) > 0){
           $row = mysqli_fetch_array($result);
           $_SESSION['email'] = $row['email'];
           header('location:admin/admin_page.php');
      }else{
         $error[] = 'incorrect email or password!';
      }
   }

};
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login form</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<div class="form-container">

   <form action="" method="post">
      <h3>login now</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      <input type="email" name="email" required placeholder="entrer votre email">
      <input type="password" name="password" required placeholder="enter votre mot de passe">
      <input type="submit" name="submit" value="login now" class="form-btn">
      <p>vous n'avez pas de compte? <a href="register_form.php">register now</a></p>
   </form>

</div>

</body>
</html>