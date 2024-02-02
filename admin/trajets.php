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
                    <h4>Trajets</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>id_trajet</th>
                                <th>lieu_dep</th>
                                <th>lieu_dest</th>
                                <th>heure_dep</th>
                                <th>nb_passagers</th>
                                <th>mat_conducteur</th>
                                <th>Supprimer</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                              $trajet= getAll("trajet");
                              if(mysqli_num_rows($trajet) > 0){
                                foreach($trajet as $item){
                                    ?>
                                    <tr>
                                        <td><?= $item['id_trajet'] ?></td>
                                        <td><?= $item['depart'] ?></td>
                                        <td><?= $item['destination'] ?></td>
                                        <td><?= $item['heure_dep'] ?></td>
                                        <td><?= $item['nb_passager'] ?></td>
                                        <td><?= $item['conducteur'] ?></td>
                                        <td>
                                        <form action="code.php" method="POST">
                                            <input type="hidden" name="id_trajet" value="<?= $item['id_trajet'] ?>"/>
                                            <button type="submit" class="btn btn-danger" name="delete_trajet_btn">supprimer</button>
                                            </form>
                                        </td>
                                    </tr>
                            <?php
                                }
                              }
                              else{
                                echo 'aucun trajet trouvé';
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