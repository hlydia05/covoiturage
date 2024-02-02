<?php
@include 'config.php';
session_start();

if(!isset($_SESSION['email'])){

   header('location:../login.php');

}
@include 'includes/adminHeader.php';
@include '../functions/myfunctions.php';
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Utilisateurs</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Matricule</th>
                                <th>Nom</th>
                                <th>Prenom</th>
                                <th>Email</th>
                                <th>Num_tel</th>
                                <th>SUpprimer</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                              $user= getAll("user");
                              if(mysqli_num_rows($user) > 0){
                                foreach($user as $item){
                                    ?>
                                    <tr>
                                        <td><?= $item['mat_etd'] ?></td>
                                        <td><?= $item['nom'] ?></td>
                                        <td><?= $item['prenom'] ?></td>
                                        <td><?= $item['email'] ?></td>
                                        <td><?= $item['num_tel'] ?></td>
                                        <td>
                                            <form action="code.php" method="POST">
                                            <input type="hidden" name="mat_etd" value="<?= $item['mat_etd'] ?>"/>
                                            <button type="submit" class="btn btn-danger" name="delete_user_btn">supprimer</button>
                                            </form>
                                        </td>
                                    </tr>
                            <?php
                                }
                              }
                              else{
                                echo 'aucun utilisateur trouvé';
                              }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
@include 'includes/adminFooter.php';
?>