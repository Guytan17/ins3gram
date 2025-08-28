<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <?php if(isset($user->username)): ?>
                <h1>Modification de <?=($user->username); else :?></h1>
                <h1>Création d'un utilisateur</h1><?php endif;?>
            </div>
            <?php
            if(isset($user)):
               echo form_open('admin/user/update');
            else:
                echo form_open('admin/user/create');
            endif;
            ?>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" placeholder="Nom" id="last_name" value="<?= (isset($user->last_name)?($user->last_name):"");?>" >
                            <label for="last-name">Nom</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" placeholder="Prénom" id="first_name" value="<?= (isset($user->first_name)?($user->first_name):"");?>">
                            <label for="first_name">Prénom</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-floating mb-3">
                        <input type="date" class="form-control" placeholder="Date de naissance" id="birthdate" value="<?= (isset($user->birthdate)?($user->birthdate):"");?>">
                        <label for="birthdate">Date de naissance</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-floating mb-3">
                            <select class="form-select" aria-label="role">
                                <?php foreach($permissions as $perm) : ?>
                                <option value="<?=$perm["id"] ; ?>"
                                    <?=(isset($user->id_permission)&&($user->id_permission==$perm["id"])) ? 'selected' : '';?>
                                >
                                    <?= $perm["name"]?>
                                </option>
                                <?php endforeach ?>
                            </select>
                            <label for="role">Rôle</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="pseudo" value="<?= (isset($user->username)?($user->username):"");?>">
                            <label for="email">Pseudo</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" value="<?= (isset($user->email)?($user->email):"");?>">
                            <label for="email">Adresse Email</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="password" value="<?= (isset ($user) ?'placeholder=""':'required');?>">
                            <label for="password">Mot de passe</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-end">
                    <button class="btn btn-primary"><?= (isset($user))?"Modifier":"Créer"; ?></button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>