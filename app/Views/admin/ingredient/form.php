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
                echo form_open('admin/ingredient/update', ['class' => 'needs-validation', 'novalidate' => true]); ?>
                <input type="hidden" name="id_ingredient" value="<?= $ingredient['id'] ?>">
            <?php
            else :
                echo form_open('admin/ingredient/insert',['class' => 'needs-validation', 'novalidate' => true]);
            endif;
            ?>
            <div class="card-body">
                <div class="row g-3">
                    <!-- Nom de l'ingrédient -->
                    <div class="col-12">
                        <div class="form-floating">
                            <input class="form-control" type="text" id="name" name="name" value="<?= isset($ingredient) ? esc($ingredient['name']): set_value('name'); ?>" required>
                            <label for="name">Nom de l'ingrédient<span class="text-danger">*</span></label>
                            <div class="invalid-feedback">
                                <?= validation_show_error('username') ?>
                            </div>
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
                    <div class="col-md-6">
                        <div class="form-floating">
                            <select class="form-select" name="id_brand" id="id_brand">
                                <option value="">Pas de marque</option>
                                <?php if(isset($brands) && is_array($brands)) :
                                foreach ($brands as $brand): ?>
                                    <option value="<?=$brand['id']?>"
                                        <?= (isset($ingredient) && $ingredient['id_brand']==$brand['id'])||set_value('id_brand') == $brand['id']? 'selected' : ''?>
                                    >
                                        <?=esc($brand['name'])?>
                                    </option>
                                <?php endforeach;
                                endif;?>
                            </select>
                            <label for="brand">Marque de l'ingrédient</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <select class="form-select" name="id_categ" id="id_categ" required>
                                <?php if(isset($categories) && is_array($categories)) :
                                    foreach ($categories as $category): ?>
                                        <option value="<?=($category['id'])?>"
                                        <?= (isset($ingredient) && $ingredient['id_categ']==$category['id'])||set_value('id_categ') == $category['id']? 'selected' : ''?>
                                        >
                                            <?=esc($category['name'])?>
                                        </option>
                                    <?php endforeach;
                                endif;?>
                            </select>
                            <label for="brand">Catégorie de l'ingrédient</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <?php if(!isset($ingredient)):?>
                    <button type="reset" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-undo me-1"></i>Réinitialiser
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
</script>