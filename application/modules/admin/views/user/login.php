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

            <?php echo form_open('admin/user/login', array('class' => 'form-signin')) ?>
                <p class="text-muted text-center">
                    Kullanıcı adı ve şifrenizi giriniz
                </p>
                <?php print_r(validation_errors()) ?>
                <input type="text" placeholder="Kullanıcı Adı" name="username" class="form-control">
                <input type="password" placeholder="Şifre" name="password" class="form-control">
                    <div class="form-actions no-margin-bottom" style="text-align: right">
                        <input type="submit" value="Giriş" class="btn btn-primary">
                        <a href="<?php echo site_url('admin/user/register')?>" id="cancel" class="btn btn-primary" name="register">Kaydol</a>
                    </div>


    <?php echo form_close() ?>

</div><!-- /container -->
<script src="<?php echo site_url('assets/lib/jquery.min.js"') ?>></script>
<script src="<?php echo site_url('assets/lib/bootstrap/js/bootstrap.js"') ?>></script>
</body>
</html>
