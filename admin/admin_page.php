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

    <div class="col-lg-5 col-sm-5">
    
      <div class="card mb-2">
        <div class="card-header p-3 pt-2">
          <div class="text-end pt-1">
            <p class="text-sm mb-0 text-capitalize">Utilisateurs</p>
            <?php
            $currentUsers = getCurrentNumber("user");
            $prevUsers = getPrevNumber("user");
            ?>
            <h4 class="mb-0"><?= $currentUsers; ?></h4>
          </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-3">
          <p class="mb-0"><span class="text-success text-sm font-weight-bolder">
            <?php 
              echo round(($currentUsers/$prevUsers-1)*100);
            ?>%  
          </span> que le mois précédent</p>
        </div>
      </div>
      
      <div class="card mb-2">
        <div class="card-header p-3 pt-2">
          <div class="text-end pt-1">
            <p class="text-sm mb-0 text-capitalize">Conducteurs</p>
            <?php
            $currentDrivers = getCurrentNumber("utilisateur");
            $prevDrivers = getPrevNumber("utilisateur");
            ?>
            <h4 class="mb-0"><?php echo $currentDrivers; ?></h4>
          </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-3">
          <p class="mb-0"><span class="text-success text-sm font-weight-bolder">
            <?php 
              echo round(($currentDrivers/$prevDrivers-1)*100);
            ?>%
          </span> que le mois précédent</p>
        </div>
      </div>
      
    </div>

    <div class="col-lg-5 col-sm-5 mt-sm-0 mt-4">
    
      <!--<div class="card mb-2">
        <div class="card-header p-3 pt-2">
          <div class="text-center pt-1">
            <p class="text-sm mb-0 text-capitalize">Revenus mensuels</p>
          </div>
        </div>
        <div class="card-body p-3">
          <canvas id="revenueChart"></canvas>
          <script>
            // Générer le graphique à partir des données SQL  
            const data = {
              labels: [...], 
              datasets: [
                {
                  label: 'Revenus',
                  data: [...], // revenus mensuels
                }
              ]
            };

            new Chart(document.getElementById('revenueChart'), {
              type: 'line',
              data: data
            });
          </script>
        </div>
      </div>-->
      
      <div class="card">
        <form action="code.php" method="POST">
          <div class="card-header p-3 pt-2">
            <div class="text-center pt-1">
              <p class="text-sm mb-0 text-capitalize">Modifier capacité maximale</p> 
            </div>
          </div>
          <div class="card-body p-3">
            <div class="form-group">
                <?php
                global $conn;
                $max_query  = "SELECT MAX(max_passagers) AS max FROM trajet";
                $max_result = mysqli_query($conn, $max_query);
                $rowmax = mysqli_fetch_assoc($max_result);
                ?>
              <label>Nombre maximum de passagers</label>
              <input type="number" name="maxPass" placeholder="<?= $rowmax['max'] ?>" class="form-control">
            </div>
            <button type="submit" name="max_passagers" class="btn btn-primary">Modifier</button>
          </div>
        </form>
      </div>
      
    </div>

  </div>
  
</div>

<?php

@include 'includes/adminFooter.php';

?>
