<?php
@include 'config.php';
@include 'includes/adminHeader.php';
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Ajoute Nouveau Admin</h4>
                </div>
                <div class="card-body">
                    <form action="code.php" method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">nom</label>
                                <input type="text" name="nom" placeholder="Entrez le nom de l'administrateur"
                                    class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="">prenom</label>
                                <input type="text" name="prenom" placeholder="Entrez le prenom de l'administrateur"
                                    class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="">email</label>
                                <input type="text" name="email" placeholder="Entrez le mail l'administrateur"
                                    class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="">matricule</label>
                                <input type="text" name="mat_etd" placeholder="Entrez le matricule de l'administrateur"
                                    class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="">password</label>
                                <input type="password" name="mdp" placeholder="Entrez le password de l'administrateur"
                                    class="form-control">
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary" name="ajout_admin">Enregistrer</button>
                            </div>
                        </div>
                    </form>


                </div>
            </div>

        </div>
    </div>
</div>

<?php
@include 'includes/adminFooter.php';
?>