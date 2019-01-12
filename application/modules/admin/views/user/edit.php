    <div class="row">
        <div class="col-lg-6">
            <div class="box">
                <header class="dark">
                    <h5>Yetkili <?php echo empty($user->id) ? "Ekle" : "Düzenle: " . $user->username ?></h5>
                </header>
                <div id="collapse2" class="body">
                    <form action="<?php echo site_url('/admin/user/edit') ?>/<?php echo empty($user->id) ? "" : $user->id ?>" method="POST" class="form-horizontal" id="popup-validation">
                        <div class="form-group">
                            <label class="control-label col-lg-4">Kullanıcı Adı</label>
                            <div class="col-lg-5">
                                <input type="text" class="validate[required] form-control" name="username" id="username" placeholder="" value="<?php echo !empty($user->id) ? $user->username : '' ?>">
                            </div>
                        </div>
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
                            <div class=" col-lg-4">
                                <input class="validate[required,equals[password]] form-control" type="password" name="pass2" id="pass2" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4">Rol</label>
                            <div class="col-lg-5">
                                <select name="role" id="role" class="validate[required] form-control">
                                    <option value="">Seçiniz</option>
                                    <option value="0" <?php echo (!empty($user->id) && 0 == $user->role_id ? "selected" : "") ?>>Süper Admin</option>
                                    <?php foreach ($role_list as $row) { ?>
                                    <option value="<?php echo $row->id?>" <?php echo (!empty($user->id) && $row->id == $user->role_id ? "selected" : "") ?>><?php echo $row->name?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-actions no-margin-bottom">
                            <input type="submit" value="Kaydet" class="btn btn-primary">
                            <a href="<?php echo site_url('/admin/user') ?>" id="cancel" class="btn btn-secondary" name="cancel" value="">Vazgeç</a>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
