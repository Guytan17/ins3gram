<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items center">
                <h3>Liste des recettes</h3>
                <a href="<?= base_url("admin/recipe/new")?>" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Nouvelle recette</a>
            </div>
            <div class="card-body">
                <table class="table table-sm table-bordered table-striped" id="table Recipe">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Créateur</th>
                        <th>Date modif.</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>

                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        //TODO TOUT FAIRE
    })
</script>
