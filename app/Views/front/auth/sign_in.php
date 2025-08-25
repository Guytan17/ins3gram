
<div class="row flex-column align-content-center">
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                Se connecter
            </div>
            <form action="<?=base_url('auth/login');?>" method="POST">
                <div class="card-body">

                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" name ="email" id="floatingInput" placeholder="name@example.com" required>
                            <label for="floatingInput">Adresse Email</label>
                        </div>
                        <div class="form-floating">
                            <input type="password" class="form-control" name="password" id="floatingPassword" placeholder="Password" required>
                            <label for="floatingPassword">Mot de passe</label>
                        </div>
                </div>
                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">Se connecter</button>
                </div>
            </form>
        </div>
    </div>
</div>