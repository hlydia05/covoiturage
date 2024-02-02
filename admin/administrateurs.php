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
                    <h4>Administrateurs</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Matricule</th>
                                <th>Nom</th>
                                <th>Prenom</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                              $admin= getAll("administrateur");
                              if(mysqli_num_rows($admin) > 0){
                                foreach($admin as $item){
                                    ?>
                                    <tr>
                                        <td><?= $item['mat_etd'] ?></td>
                                        <td><?= $item['nom'] ?></td>
                                        <td><?= $item['prenom'] ?></td>
                                        <td><?= $item['email'] ?></td>
                                    </tr>
                            <?php
                                }
                              }
                              else{
                                echo 'aucun administrateur trouvé';
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