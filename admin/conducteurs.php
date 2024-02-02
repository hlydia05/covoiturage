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
                    <h4>Conducteurs</h4>
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
                                <th>Mat_voiture</th>
                                <th>Supprimer</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                              $conduct= getAll("utilisateur");
                              if(mysqli_num_rows($conduct) > 0){
                                foreach($conduct as $item){
                                    ?>
                                    <tr>
                                        <td><?= $item['mat_etd'] ?></td>
                                        <td><?= $item['nom'] ?></td>
                                        <td><?= $item['prenom'] ?></td>
                                        <td><?= $item['email'] ?></td>
                                        <td><?= $item['num_tel'] ?></td>
                                        <td><?= $item['matricule_v'] ?></td>
                                        <td>
                                        <form action="code.php" method="POST">
                                            <input type="hidden" name="mat_etd" value="<?= $item['mat_etd'] ?>"/>
                                            <button type="submit" class="btn btn-danger" name="delete_conducteur_btn">supprimer</button>
                                            </form>
                                        </td>
                                    </tr>
                            <?php
                                }
                              }
                              else{
                                echo 'conducteur trouvé';
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