<?php

@include 'config.php';
//@include 'includes/header.php';

session_start();

// Récupération des informations de l'utilisateur connecté
if (isset($_SESSION['mat_etd'])) {
  $mat_etd = $_SESSION['mat_etd'];
  $sql = "SELECT * FROM utilisateur WHERE mat_etd = '$mat_etd'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nom = $row['nom'];
    $prenom = $row['prenom'];
    $num_tel = $row['num_tel'];
    $email = $row['email'];
  } else {
    echo "Utilisateur introuvable";
    exit();
  }
} else {
  header("Location: login_form.php");
  exit();
}


if(isset($_POST['submit'])){

   $nom2 = mysqli_real_escape_string($conn, $_POST['nom']);
   $prenom2 = mysqli_real_escape_string($conn, $_POST['prenom']);
   $tel2 = mysqli_real_escape_string($conn, $_POST['tel']);
   $email2 = mysqli_real_escape_string($conn, $_POST['email']);
   $matricule2 = mysqli_real_escape_string($conn, $_POST['matricule']);
   //$user_type = $_POST['user_type'];

   //$select = " SELECT * FROM utilisateur WHERE email = '$email'";

   //$result = mysqli_query($conn, $select);

  // if(mysqli_num_rows($result) > 0){
        $update = "UPDATE utilisateur SET nom='$nom2', prenom='$prenom2', num_tel='$tel2', email='$email2', mat_etd='$matricule2' WHERE mat_etd='$mat_etd'";
         mysqli_query($conn, $update);
         header('location:login_form.php');
  // }

};


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>updating form</title>

   <!-- Bootstrap CDN link -->
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style2.css">

</head>
<body>

<?php @include 'includes/header.php'; ?>
 
<div class="contain">
<div class="container">

<form action="" method="post">
<div class="row">
  <div class="col-md-6 offset-md-3">
  <div class="ring">
  <div class="login">
     <h3>update now</h3>
     <?php
     if(isset($error)){
        foreach($error as $error){
           echo '<span class="error-msg">'.$error.'</span>';
        };
     };
     ?>
     <div class="form-group inputBx"><input type="text" name="nom" required placeholder="Nom" class="form-control" value=<?php echo $nom ?>></div>
     <div class="form-group inputBx"><input type="text" name="prenom" required placeholder="Prenom" class="form-control" value=<?php echo $prenom ?>></div>
     <div class="form-group inputBx"><input type="tel" name="tel" required placeholder="Numéro de téléphone" class="form-control" value=<?php echo $num_tel ?>></div>
     <div class="form-group inputBx"><input type="email" name="email" required placeholder="Email" class="form-control" value=<?php echo $email ?>></div>
     <div class="form-group inputBx"><input type="text" name="matricule" required placeholder="Matricule" class="form-control" value=<?php echo $mat_etd ?>></div>
     <!-- <div class="inputBx"><select name="user_type">
        <option value="user">user</option>
        <option value="admin">admin</option>
        <option value="driver">driver</option>
     </select>-->
     <div class="form-group inputBx"><input type="submit" name="submit" value="modify now" class="btn btn-primary"></div>
  </div>
  </div>
  </div>
</div>
</form>

</div>
</div>


</body>
</html>
