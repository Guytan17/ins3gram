<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Liste des ingrédients</h3>
                <a href="<?= base_url('/admin/ingredient/new')?>" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nouvel ingrédient
                </a>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped" id="ingredientsTable" >
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Marque</th>
                        <th>Catégorie</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var baseUrl = "<?= base_url();?>";
        var table = $('#ingredientsTable').DataTable({
            processing: true, //Affiche de process une animation pendant les chargements
            serverside: true, //Indique que les traitements lourds sont fait côté serveur et pas dans le navigateur (récupération des données de la DB, tri,...)
            ajax: {
                url: '<?=base_url('datatable/searchdatatable')?>',
                type: 'POST',
                data: {
                    model: 'IngredientModel'
                }
            },
            columns: [
                {data: 'id'},
                {data: 'name'},
                {data: 'description'},
                {data: 'brand'},
                {data: 'category'},
                {
                    data: null,// permet de ne pas prendre de données existantes et créer ses propres données(ici les boutons de modif et de suppression
                    orderable: false,
                    render: function (data, type, row) {
                        return `
                            <div class="btn-group" role="group">
                                <a href="${baseUrl}/admin/ingredient/${row.id}" class="btn btn-sm btn-warning" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button onclick="deleteIngredient(${row.id})" class="btn btn-sm btn-danger" title="Supprimer">
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

    function deleteIngredient(id){
        Swal.fire({
            title: `Êtes-vous sûr ?`,
            text: `Voulez-vous vraiment supprimer cet ingrédient ?`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#28a745",
            cancelButtonColor: "#6c757d",
            confirmButtonText: `Oui !`,
            cancelButtonText: "Annuler",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('/admin/ingredient/delete') ?>',
                    type: 'POST',
                    data: {
                        id: id,
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Succès !',
                                text: response.message,
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            // Actualiser la table
                            refreshTable();
                        } else {
                            console.log(response.message)
                            Swal.fire({
                                title: 'Erreur !',
                                text: 'Une erreur est survenue',
                                icon: 'error'
                            });
                        }
                    }
                })
            }
        });
    }
</script>