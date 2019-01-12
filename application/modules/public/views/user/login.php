<!DOCTYPE html>
<head>
    <title>Giriş</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="/favicon.ico" type="image/x-icon" rel="icon" />
    <link href="/favicon.ico" type="image/x-icon" rel="shortcut icon" />
    <link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/css/bootstrap.min.css') ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/css/custom.css') ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/css/main.css') ?>" />

</head>
<body id="engaggerContent">
<header>
    <div id="mainDynamicData"> </div>
    <div class="container">
        <ul class="nav nav-pills pull-left" id="small">
            <li id="farmaLogo">
                <a href="/"><img src="<?php echo site_url('assets/img/logo.png') ?>" title="farmalife" alt="" /></a>
            </li>
        </ul>

        <ul class="nav nav-pills pull-right" id="small">
            <!--<li class="pull-right"><a href="/authake/user/register">Kayıt Ol</a></li>-->
            <!-- <li class="pull-right"><a href="/authake/user/login">Giriş Yap</a></li>		-->
        </ul>
    </div>
</header>
<div class="container">
    <div id="content">
        <div class="container">
            <div class="section span6 offset3">
                <div class="row-fluid">
                    <form action="<?php echo site_url('public/user/login') ?>" id="UserLoginForm" method="post" accept-charset="utf-8">
                        <div style="display:none;">
                            <input type="hidden" name="_method" value="POST"/>
                        </div>
                        <div class="section-header">
                            <h3>Giriş Yap</h3>
<!--                            <div class="section-actions">
                                <a href="/authake/user/lost_password" class="btn btn-mini">Şifremi unuttum ...</a>						 											</div>-->
                        </div>
                        <?php if (!empty($error)) { ?>
                        <div class="section-body">
                            <div class="section-body">
                                <?php echo $error ?>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="section-body">
                            <div class="input text"><label for="UserLogin">Giriş Yap</label><input name="username" size="255" maxlength="255" type="text" id="UserLogin"/></div>
                            <div class="input password"><label for="UserPassword">Şifre</label><input name="password" value="" size="14" type="password" id="UserPassword"/></div>
                        </div>
                        <div class="section-footer">
                            <div class="control-group">
                                <div class="form-actions">
                                    <input  class="action input-action btn btn-info" type="submit" value="Giriş Yap"/>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<footer>
    <div class="bottomImg"></div>
</footer>
</body>
</html>