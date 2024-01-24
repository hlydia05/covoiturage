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

      if($row['type'] == 'admin'){

         $_SESSION['mat_etd'] = $row['mat_etd'];
         header('location:admin_page.php');

      }elseif($row['type'] == 'user'){

         $_SESSION['mat_etd'] = $row['mat_etd'];
         header('location:user_page.php');

      }elseif($row['type'] == 'driver'){

         $_SESSION['mat_etd'] = $row['mat_etd'];
         header('location:driver_page.php');

      }
     
   }else{
      $error[] = 'incorrect email or password!';
   }

};
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login form</title>

   <!-- Bootstrap CDN link -->
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style2.css">

</head>
<body>
   
<div class="contain">
<div class="container">

<form action="" method="post">
<div class="row">
  <div class="col-md-6 offset-md-3">
  <div class="ring">
    <i style="--clr:#00ff0a;"></i>
    <i style="--clr:#ff0057;"></i>
    <i style="--clr:#fffd44;"></i>
    <div class="login">
      <h3>login now</h3>
      <?php
         if(isset($error)){
         foreach($error as $error){
           echo '<span class="error-msg">'.$error.'</span>';
         };
       };
      ?>
      <div class="form-group inputBx"><input type="email" name="email" required placeholder="entez votre email" class="form-control"></div>
      <div class="form-group inputBx"><input type="password" name="password" required placeholder="entez votre mot de passe" class="form-control"></div>
      <div class="form-group inputBx"><input type="submit" name="submit" value="login now" class="btn btn-primary"></div>
      <div class="links text-center"><p>don't have an account? <a href="register_form.php">Sign up</a></p></div>
    </div>
  </div>
  </div>
</div>
</form>

</div>
</div>


</body>
</html>
