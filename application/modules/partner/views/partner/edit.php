    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <header class="dark">
                    Kişisel Bilgilerim
                </header>
                <?php if (validation_errors() != '') { ?>
                <div class="alert alert-warning">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <strong>Uyarı!</strong> <?php echo validation_errors(); ?>
                </div>
                <?php } ?>
                <div id="collapse2" class="body">
                    <form enctype="multipart/form-data" action="<?php echo site_url('/partner/partner/edit') ?>/<?php echo empty($profile->user_id) ? "" : $profile->user_id ?>" method="POST" class="form-horizontal" id="popup-validation">
                        <div class="form-group">
                            <label class="control-label col-lg-4">Ad soyad</label>
                            <div class=" col-lg-5">
                                <input class="validate[required] form-control" type="text" name="fullname" id="fullname"  value="<?php echo !empty($profile->user_id) ? $profile->fullname : '' ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4">Adres Satırı 1</label>
                            <div class=" col-lg-5">
                                <input class="validate[required] form-control" type="text" name="address1" id="address1"  value="<?php echo !empty($profile->user_id) ? $profile->address1 : '' ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4">Adres Satırı 2</label>
                            <div class=" col-lg-5">
                                <input class="validate[required] form-control" type="text" name="address2" id="address2"  value="<?php echo !empty($profile->user_id) ? $profile->address2 : '' ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4">İlçe</label>
                            <div class=" col-lg-5">
                                <input class="validate[required] form-control" type="text" name="district" id="district"  value="<?php echo !empty($profile->user_id) ? $profile->district : '' ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4">İl</label>
                            <div class=" col-lg-5">
                                <input class="validate[required] form-control" type="text" name="city" id="city"  value="<?php echo !empty($profile->user_id) ? $profile->city : '' ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4">Ülke</label>
                            <div class=" col-lg-5">
                                <input class="validate[required] form-control" type="text" name="country" id="country"  value="<?php echo !empty($profile->user_id) ? $profile->country : '' ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4">Telefon No</label>
                            <div class=" col-lg-5">
                                <input class="validate[required] form-control" type="text" name="phonenumber" id="phonenumber" value="<?php echo !empty($profile->user_id) ? $profile->phonenumber : '' ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4">T.C. Kimlik No</label>
                            <div class=" col-lg-5">
                                <input class="validate[required] form-control" type="text" name="idnumber" id="idnumber" data-mask="99999999999" value="<?php echo !empty($profile->user_id) ? $profile->idnumber : '' ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4">IBAN</label>
                            <div class=" col-lg-5">
                                <div class="input-group">
                                    <span class="input-group-addon">TR</span>
                                    <input class="validate[required] form-control" type="text" name="iban" id="iban" value="<?php echo !empty($profile->user_id) ? $profile->iban : '' ?>"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4">Cinsiyet</label>
                            <div class=" col-lg-5">
                                <select name="gender" id="gender" class="validate[required] form-control">
                                    <?php
                                    $options = array(array('key' => '1', 'value' => 'Kadın'), array('key' => '2', 'value' => 'Erkek'));
                                    foreach ($options as $row) { ?>
                                        <option value="<?php echo $row['key']?>" <?php echo (!empty($profile->gender) && $row['key'] == $profile->gender ? "selected" : "") ?>><?php echo $row['value']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4">Doğum Tarihi</label>
                            <div class=" col-lg-5">
                                <input class="validate[required] form-control" type="text" name="birthdate" id="birthdate" data-mask="99/99/9999" value="<?php echo !empty($profile->user_id) ? date("d/m/Y", strtotime($profile->birthdate)) : '' ?>"/>
                            </div>
                        </div>
                        <div class="form-actions no-margin-bottom">
                            <input type="submit" value="Kaydet" class="btn btn-primary">
                            <a href="<?php echo site_url('/partner/') ?>" id="cancel" class="btn btn-secondary" name="cancel" value="">Vazgeç</a>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
