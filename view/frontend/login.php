<?php
ob_start();
?>

<div class="container py-5 extra">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6 mx-auto">

                    <!-- form card login -->
                    <div class="card rounded-0">
                        <div class="card-header">
                            <h3 class="mb-0">Identification</h3>
                        </div>
                        <div class="card-body">
                            <form   method="POST" action="routes.php?" name="">
                                <div class="form-group">
                                    <label for="username">Utilisateur</label>
                                    <input type="text" class="form-control form-control-lg rounded-0" name="username" id="username" required="" >
                                    <div class="invalid-feedback">Oops, you missed this one.</div>
                                </div>
                                <div class="form-group">
                                    <label for="pwd">Mot de passe</label>
                                    <input type="password" class="form-control form-control-lg rounded-0" name="password" id="password" required="" autocomplete="new-password">
                                    <div class="invalid-feedback">Enter your password too!</div>
                                </div>
                                <div>
                                    <label class="checkbox">
                                      <input type="checkbox" name="rememberme">
                                      <span class="custom-control-indicator"></span>
                                      <span class="custom-control-description small text-dark">Se souvenir de moi</span>
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-success btn-lg float-right" id="btnLogin" name='toto' >Login</button>
                            </form>
                        </div>
                        <!--/card-block-->
                    </div>
                    <!-- /form card login -->

                </div>


            </div>
            <!--/row-->

        </div>
        <!--/col-->
    </div>
    <!--/row-->
</div>
<!--/container-->
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>