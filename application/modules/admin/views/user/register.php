<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $meta_title ?></title>
    <meta name="msapplication-TileColor" content="#5bc0de" />
    <meta name="msapplication-TileImage" content="assets/img/metis-tile.png') ?>" />
    <link rel="stylesheet" href="<?php echo site_url('assets/lib/bootstrap/css/bootstrap.css') ?>">
    <link rel="stylesheet" href="<?php echo site_url('assets/css/main.css') ?>">
    <link rel="stylesheet" href="<?php echo site_url('assets/lib/magic/magic.css') ?>">
</head>
<body class="login">
<div class="container">
    <div class="text-center">
        <img src="<?php echo site_url('assets/img/logo.png') ?>" alt="Logo">
    </div>
    <div class="row">
        <div class="col-lg-6  center form">
            <div class="box">
                <header class="dark">
                    <h5>Kayıt Formu</h5>
                </header>
                <?php print_r(validation_errors()) ?>
                <div id="collapse2" class="body">
                    <form action="<?php echo site_url('/admin/user/register') ?>" method="POST" class="form-horizontal" id="popup-validation">
                        <div class="form-group">
                            <label class="control-label col-lg-4">E-mail</label>
                            <div class=" col-lg-5">
                                <input class="validate[required,custom[email]] form-control" type="text" name="email" id="email" placeholder="" value="<?php echo !empty($user->id) ? $user->email : '' ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4">Şifre</label>
                            <div class=" col-lg-5">
                                <input class="validate[required] form-control" type="password" name="password" id="password" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4">Şifre (Tekrar)</label>
                            <div class=" col-lg-5">
                                <input class="validate[required,equals[password]] form-control" type="password" name="pass2" id="pass2" />
                            </div>
                        </div>
                        <div class="form-actions no-margin-bottom">
                            <input type="submit" value="Kaydol" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
</div><!-- /container -->
<script src="<?php echo site_url('assets/lib/jquery.min.js"') ?>></script>
<script src="<?php echo site_url('assets/lib/bootstrap/js/bootstrap.js"') ?>></script>
</body>
</html>
