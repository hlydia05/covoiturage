<?php

@include 'config.php';

if(isset($_POST['submit'])){

   $nom = mysqli_real_escape_string($conn, $_POST['nom']);
   $prenom = mysqli_real_escape_string($conn, $_POST['prenom']);
   $tel = mysqli_real_escape_string($conn, $_POST['tel']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $matricule = mysqli_real_escape_string($conn, $_POST['matricule']);
   $pass = md5($_POST['password']);
   $cpass = md5($_POST['cpassword']);
   //$user_type = $_POST['user_type'];

   $select = " SELECT * FROM utilisateur WHERE email = '$email'";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){

      $error[] = 'user already exist!';

   }else{

      if($pass != $cpass){
         $error[] = 'password not matched!';
      }else{
         $insert = "INSERT INTO utilisateur(nom, prenom, num_tel, email, mat_etd, mdp) VALUES('$nom', '$prenom', '$tel', '$email', '$matricule', '$pass')";
         mysqli_query($conn, $insert);
         header('location:login_form.php');
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
  <div class="login">
     <h3>register now</h3>
     <?php
     if(isset($error)){
        foreach($error as $error){
           echo '<span class="error-msg">'.$error.'</span>';
        };
     };
     ?>
     <div class="form-group inputBx"><input type="text" name="nom" required placeholder="Nom" class="form-control"></div>
     <div class="form-group inputBx"><input type="text" name="prenom" required placeholder="Prenom" class="form-control"></div>
     <div class="form-group inputBx"><input type="tel" name="tel" required placeholder="Numéro de téléphone" class="form-control"></div>
     <div class="form-group inputBx"><input type="email" name="email" required placeholder="Email" class="form-control"></div>
     <div class="form-group inputBx"><input type="text" name="matricule" required placeholder="Matricule" class="form-control"></div>
     <div class="form-group inputBx"><input type="password" name="password" required placeholder="Mot de passe" class="form-control"></div>
     <div class="form-group inputBx"><input type="password" name="cpassword" required placeholder="Confirmation mot de passe" class="form-control"></div>
     <!-- <div class="inputBx"><select name="user_type">
        <option value="user">user</option>
        <option value="admin">admin</option>
        <option value="driver">driver</option>
     </select>-->
     <div class="form-group inputBx"><input type="submit" name="submit" value="register now" class="btn btn-primary"></div>
     <div class="links text-center"><p>already have an account? <a href="login_form.php">login</a></p></div>
  </div>
  </div>
  </div>
</div>
</form>

</div>
</div>


</body>
</html>
