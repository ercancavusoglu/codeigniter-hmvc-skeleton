<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sistem Mesajı</title>
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
        <div class="col-lg-6">
            <div class="box">
                <header class="dark">
                    <h5>Sistem Mesajı</h5>
                </header>
                <div id="collapse2" class="body">
                    <?php echo $message ?>
                </div>
            </div>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
</div><!-- /container -->
</body>
</html>
