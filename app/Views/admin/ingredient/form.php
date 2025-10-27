<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h1>
                    <?php if(isset($ingredient)) : ?>
                    Modification de <?= esc($ingredient['name']);?>
                    <?php  else : ?>
                    Création d'un ingrédient
                    <?php endif ; ?>
                </h1>
            </div>
            <?php
            if(isset($ingredient)):
                echo form_open_multipart('admin/ingredient/update', ['class' => 'needs-validation', 'novalidate' => true]); ?>
                <input type="hidden" name="id_ingredient" value="<?= $ingredient['id'] ?>">
            <?php
            else :
                echo form_open_multipart('admin/ingredient/insert',['class' => 'needs-validation', 'novalidate' => true]);
            endif;
            ?>
            <div class="card-body">
                <div class="row g-3">
                    <!-- Nom de l'ingrédient -->
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input class="form-control" type="text" id="name" name="name" value="<?= isset($ingredient) ? esc($ingredient['name']): set_value('name'); ?>" required>
                            <label for="name">Nom de l'ingrédient<span class="text-danger">*</span></label>
                            <div class="invalid-feedback">
                                <?= validation_show_error('username') ?>
                            </div>
                        </div>
                    </div>
                    <!-- Image-->
                    <div class="col-md-6">
                        <div class="row g-2">
                            <div class="img-thumbnail text-center mb-2">
                                <img src="<?= base_url($ingredient['img']) ?? base_url('assets/img/default-avatar.png') ?>" alt="image de l'ingrédient" title="Image de
                                l'ingrédient" id="img-ing">
                            </div>
                        </div>
                        <div class="row g-2">
                            <input type="file" name="image" id="image" class="form-control">
                        </div>
                    </div>
                    <!-- Description de l'ingrédient -->
                    <div class="col-12">
                        <div class="form-floating">
                            <textarea class= form-control name="description" id="description" rows="3" placeholder="Description de l'ingrédient">
                                <?= isset($ingredient['description']) ? esc($ingredient['description']): set_value('description'); ?>
                            </textarea>
                            <div class="invalid-feedback">
                                <?= validation_show_error('username') ?>
                            </div>
                        </div>
                    </div>
                    <!-- Sélection de la marque et de la catégorie -->
                    <div class="row g-3">
                        <div class="col-md-6" id="zone-brand">
                            <div>
                                <select class="form-select select-brand" name="id_brand" id="id_brand">
                                    <?php if(isset($ingredient['id_brand'])) { ?>
                                        <option value="<?= $ingredient['id_brand']?>" selected><?= $brand['name']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6" id="zone-categ">
                            <div>
                                <select class="form-select select-categ" name="id_categ" id="id_categ" required>
                                    <?php if(isset($ingredient['id_categ'])) { ?>
                                        <option value="<?= $ingredient['id_categ']?>" selected><?= $category['name']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Partie substituts -->
                    <div class="row g-3">
                    <!-- Sélection des substituts de l'ingrédient -->
                        <div class="col-md-6" id="zone-substitute">
                            <div class="tab-pane" id="substitute-tab-pane" role="tabpanel">
                                <div class="card mb-2">
                                    <div class="card-header">
                                        <?php if(isset($ingredient)) : ?>
                                        Ingrédients qui substituent <span class="fw-bolder"><?=isset($ingredient['name']) ? $ingredient['name']: ""?></span> :
                                        <?php else : ?>
                                        Ingrédients qui le substitue :
                                        <?php endif ; ?>
                                    </div>
                                    <div class="card-body">
                                        <?php if(isset($substitutes)) :
                                            $cpt_sub=0;
                                            foreach ($substitutes as $sub) :
                                                $cpt_sub++;
                                                ?>
                                                <div class="row mb-2 row-substitute">
                                                    <div class="col">
                                                        <div class="input-group">
                                                            <span class="input-group-text">
                                                                 <i class="fas fa-trash-alt text-danger supp-substitute"></i>
                                                            </span>
                                                            <select class="form-select flex-fill select-substitute" name="substitute[<?= $cpt_sub?>][id_ingredient_sub]">
                                                                <option value="<?= $sub['id_ingredient_sub']?>"><?= $sub['sub_name']?></option>
                                                            </select>
                                                            <?php if(isset($ingredient)) : ?>
                                                                <input type="hidden" name="substitute[<?=$cpt_sub?>][id_ingredient_base]" value="<?=$ingredient['id']?>">
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                        <?php endforeach ;
                                        endif ; ?>
                                    </div>
                                    <div class="card-footer text-end">
                                        <span class="btn btn-primary" id="add-substitute">
                                            <i class="fas fa-plus"></i> Ajouter un substitut
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if(isset($ingredient)){ ?>
                            <!-- Affichage des ingrédients que celui-ci substituent -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <?php if(empty($substituted)) : ?>
                                        Aucun ingrédient n'est substitué par<span class="fw-bolder mx-1"><?=$ingredient['name']?></span>
                                    <?php else : ?>
                                        Ingrédients substitués par <span class="fw-bolder mx-1"><?=$ingredient['name']?></span> :
                                    <?php endif; ?>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped table-sm">
                                        <thead>
                                        <tr>
                                            <th class="col-md-4">Nom</th>
                                            <th class="col-md-8">Description</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($substituted as $subd ) : ?>
                                            <tr>
                                                <td><a href="<?= base_url('admin/ingredient/'.$subd['id_ingredient_base']) ?>"><?= $subd['base_name'] ?></a></td>
                                                <td><?= $subd['description'] ?></td>
                                            </tr>
                                        <?php endforeach ; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-end mt-2">
                    <?php if(!isset($ingredient)):?>
                        <button type="reset" class="btn btn-outline-secondary me-2">
                            <i class="fas fa-undo me-1"></i> Réinitialiser
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i> Créer l'ingrédient
                        </button>
                    <?php else :?>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Modifier l'ingrédient
                        </button>
                    <?php endif; ?>
                </div>
            </div>
            <?php form_close();?>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        //zone de texte améliorée pour la description
        tinymce.init({
            selector:'#description',
            height:'200',
            language:'fr_FR',
            menubar:false,
            plugins:[
                'preview','fullscreen','wordcount','link','lists',
            ],
            skin:'oxide',
            content_encoding:'text',
            toolbar: 'undo redo | formatselect | ' +
                'bold italic link forecolor backcolor removeformat | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +' fullscreen  preview code'
        });
    });
    // Ici, on ouvre une "fonction auto-exécutée".
    // Cela veut dire que ce bloc de code va s'exécuter tout seul dès que la page est chargée.
    (function() {
        'use strict';
        // "use strict" demande à JavaScript d’être plus strict.
        // Par exemple, il interdit certaines mauvaises pratiques de code.
        // C’est une bonne habitude pour éviter des erreurs.

        // On sélectionne TOUS les formulaires qui ont la classe "needs-validation"
        // (c’est une classe Bootstrap utilisée pour la mise en forme et la validation).
        var forms = document.querySelectorAll('.needs-validation');

        // Comme "forms" contient une liste (plusieurs formulaires),
        // on transforme cette liste en tableau avec "Array.prototype.slice.call(forms)".
        // Ça permet de pouvoir faire "forEach" dessus (boucle).
        Array.prototype.slice.call(forms).forEach(function(form) {

            // Pour chaque formulaire trouvé, on ajoute un "écouteur d’événement".
            // Ici, on écoute quand le formulaire veut être envoyé ("submit").
            form.addEventListener('submit', function(event) {

                // Si le formulaire n’est PAS valide...
                // (par exemple : un champ "required" est vide)
                if (!form.checkValidity()) {

                    // ... alors on empêche l’envoi du formulaire au serveur
                    event.preventDefault();

                    // ... et on arrête aussi d’autres actions liées à l’événement
                    event.stopPropagation();
                }

                // Dans tous les cas, on ajoute la classe "was-validated" au formulaire.
                // C’est une classe CSS de Bootstrap qui va afficher les messages d’erreurs
                // et mettre en rouge les champs invalides.
                form.classList.add('was-validated');

            }, false); // "false" signifie qu’on utilise le mode "bulle" par défaut pour l’événement
        });
    })();
    //Compteur pour nos substituts
    let cpt_sub = $('#zone-substitute .card-body .row-substitute').length;
    //url pour les requetes Ajax
    baseUrl = "<?= base_url(); ?>";
    //Action du clic sur l'ajout d'un subsitut
    $('#add-substitute').on('click', function () {
        cpt_sub++; //augmente le compteur de 1
        let row = `

                    <div class="row mb-3 row-substitute">
                        <div class="col">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-trash-alt text-danger supp-substitute"></i>
                                </span>
                                <select class="form-select flex-fill select-substitute" name="substitute[${cpt_sub}][id_ingredient_sub]">
                                </select>
                                <?php if(isset($ingredient)) { ?>
                                <input type="hidden" name="substitute[${cpt_sub}][id_ingredient_base]" value="<?=$ingredient['id'] ?>">
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                `;
        $('#zone-substitute .card-body').append(row);
        initAjaxSelect2('#zone-substitute .select-substitute', {
            url: baseUrl + 'admin/ingredient/search',
            placeholder: 'Rechercher un ingrédient...',
            searchFields: 'name,description',
            showDescription: true,
            delay: 250
        });
    });
    //Action du bouton de suppression des substituts
    $('#zone-substitute').on('click','.supp-substitute',function() {
        $(this).closest('.row-substitute').remove();
    });
    //Initialisation dès le départ de nos Select pour substitut
    initAjaxSelect2('#zone-substitute .select-substitute', {
        url: baseUrl + 'admin/ingredient/search',
        placeholder: 'Rechercher un ingrédient...',
        searchFields: 'name,description',
        showDescription: true,
        delay: 250
    });

    //Champ de sélection pour la marque
    initAjaxSelect2('#zone-brand .select-brand', {
        url: baseUrl + 'admin/brand/search',
        placeholder: 'Rechercher une marque...',
        searchFields: 'name,description',
        showDescription: true,
        delay: 250,
    });

    initAjaxSelect2('#zone-categ .select-categ', {
        url: baseUrl + 'admin/categ-ing/search',
        placeholder: 'Rechercher une catégorie...',
        searchFields: 'name',
        showDescription: true,
        delay: 250,
    });
</script>
<style>
    .supp-substitute {
        cursor:pointer;
    }
    #img-ing{
        width:200px;
        height: 200px;
        object-fit: contain;
    }
</style>