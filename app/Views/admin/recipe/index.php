<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items center">
                <h3>Liste des recettes</h3>
                <a href="<?= base_url("admin/recipe/new")?>" class="btn btn-sm btn-primary text-center my-auto"><i class="fas fa-plus"></i> Nouvelle recette</a>
            </div>
            <div class="card-body">
                <table id="recipesTable" class="table table-sm table-bordered table-striped" >
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
                    <!-- Les données seront chargées via AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        var baseUrl = "<?= base_url(); ?>";
        var table = $('#recipesTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?= base_url('datatable/searchdatatable') ?>',
                type: 'POST',
                data: {
                    model: 'RecipeModel'
                }
            },
            columns: [
                {data:'id'},
                {data:'name'},
                {data:'creator_name'},
                {data:'updated_at'},
                {data:'deleted_at'},//Afficher ou non le statut actif de la recette
                {
                    data: null,
                    orderable: false,
                    render: function(data, type, row) {
                        return `
                            <div class="btn-group" role="group">
                                <button onclick="showModal(${row.id},'${row.name}')" class="btn btn-sm btn-warning" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="deletePerm(${row.id})" class="btn btn-sm btn-danger" title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        `;
                    }
                }
            ],
            order: [[0, 'desc']],
            pageLength: 10,
            language: {
                url: baseUrl + 'js/datatable/datatable-2.1.4-fr-FR.json',
            }
        });
        // Fonction pour actualiser la table
        window.refreshTable = function() {
            table.ajax.reload(null, false); // false pour garder la pagination
        };
    });
</script>
