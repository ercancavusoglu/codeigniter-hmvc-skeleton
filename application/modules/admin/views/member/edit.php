<link href="<?php echo site_url('assets/lib/select2-3.4.2/select2.css') ?>" rel="stylesheet"/>
<link href="<?php echo site_url('assets/lib/select2-3.4.2/select2-bootstrap.css') ?>" rel="stylesheet"/>

    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <header class="dark">
                    <h5>Müşteri <?php echo empty($member->id) ? "Ekle" : "Düzenle: " . $member->email ?></h5> <?php echo (!empty($member->id) ? '<a href="' . site_url('/admin/member/tree/' . $member->id) . '" class="btn btn-secondary">Ağacı Göster</a>' : '' )?>
                </header>
                <div id="collapse2" class="body">
                    <form enctype="multipart/form-data" action="<?php echo site_url('/admin/member/edit') ?>/<?php echo empty($member->id) ? "" : $member->id ?>" method="POST" class="form-horizontal" id="popup-validation">
                        <div class="form-group">
                            <label class="control-label col-lg-4">Bağlı Olduğu Üye</label>
                            <div class="col-lg-5">
                                <select name="parent_id" id="parent_id" class="validate form-control select2">
                                    <option value=""></option>
                                    <?php foreach ($member_list as $row) { ?>
                                        <option value="<?php echo $row->user_id?>" <?php echo (!empty($member->parent_id) && $row->user_id == $member->parent_id ? "selected" : "") ?>><?php echo $row->fullname?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4">E-mail</label>
                            <div class=" col-lg-5">
                                <input class="validate[required,custom[email]] form-control" type="text" name="email" id="email"  value="<?php echo !empty($member->id) ? $member->email : '' ?>"/>
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
                        <div class="form-group">
                            <label class="control-label col-lg-4">Resim</label>
                            <div class="col-lg-4">
                                <div class="fileinput fileinput-<?php echo ( empty($profile->picture) ? "new" : "exists") ?>" data-provides="fileinput">
                                    <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 90px; height: 90px;">
                                        <?php if (!empty($profile->picture)) { ?><img src="<?php echo site_url('assets/img/members/' .  $profile->picture) ?>" alt="..."><?php } ?>
                                    </div>
                                    <div>
                                    <span class="btn btn-default btn-file">
                                        <span class="fileinput-new">Resim seçiniz</span>
                                        <span class="fileinput-exists">Değiştir</span>
                                        <input type="file" name="picture">
                                    </span>
                                        <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Kaldır</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4">Ad soyad</label>
                            <div class=" col-lg-5">
                                <input class="validate[required] form-control" type="text" name="fullname" id="fullname"  value="<?php echo !empty($member->id) ? $profile->fullname : '' ?>"/>
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
                            <label class="control-label col-lg-4">T.C. Kimlik No</label>
                            <div class=" col-lg-5">
                                <input class="validate[required] form-control" type="text" name="idnumber" id="idnumber" data-mask="99999999999" value="<?php echo !empty($member->id) ? $profile->idnumber : '' ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4">Doğum Tarihi</label>
                            <div class=" col-lg-5">
                                <input class="validate[required] form-control" type="text" name="birthdate" id="birthdate" data-mask="99/99/9999" value="<?php echo !empty($member->id) ? date("d/m/Y", strtotime($profile->birthdate)) : '' ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4">IBAN</label>
                            <div class=" col-lg-5">
                                <div class="input-group">
                                    <span class="input-group-addon">TR</span>
                                    <input class="validate[required] form-control" type="text" name="iban" id="iban" value="<?php echo !empty($member->id) ? $profile->iban : '' ?>"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4">Telefon</label>
                            <div class=" col-lg-5">
                                <input class="validate[required] form-control" type="text" name="phonenumber" id="phonenumber" value="<?php echo !empty($member->id) ? $profile->phonenumber : '' ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4">Adres Satırı 1</label>
                            <div class=" col-lg-5">
                                <input class="validate[required] form-control" type="text" name="address1" id="address1"  value="<?php echo !empty($member->id) ? $profile->address1 : '' ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4">Adres Satırı 2</label>
                            <div class=" col-lg-5">
                                <input class="validate[required] form-control" type="text" name="address2" id="address2"  value="<?php echo !empty($member->id) ? $profile->address2 : '' ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4">İlçe</label>
                            <div class=" col-lg-5">
                                <input class="validate[required] form-control" type="text" name="district" id="district"  value="<?php echo !empty($member->id) ? $profile->district : '' ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4">İl</label>
                            <div class=" col-lg-5">
                                <input class="validate[required] form-control" type="text" name="city" id="city"  value="<?php echo !empty($member->id) ? $profile->city : '' ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4">Ülke</label>
                            <div class=" col-lg-5">
                                <input class="validate[required] form-control" type="text" name="country" id="country"  value="<?php echo !empty($member->id) ? $profile->country : '' ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4">Durum</label>
                            <div class=" col-lg-5">
                                <select name="status" id="status" class="validate[required] form-control">
                                    <?php
                                        $options = array(array('key' => 'active', 'value' => 'Aktif'), array('key' => 'pending', 'value' => 'Onay Bekliyor'), array('key' => 'rejected', 'value' => 'Reddedildi'), array('key' => 'suspended', 'value' => 'Donduruldu'));
                                        foreach ($options as $row) { ?>
                                        <option value="<?php echo $row['key']?>" <?php echo (!empty($member->status) && $row['key'] == $member->status ? "selected" : "") ?>><?php echo $row['value']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-actions no-margin-bottom">
                            <input type="submit" value="Kaydet" class="btn btn-primary">
                            <a href="<?php echo site_url('/admin/member') ?>" id="cancel" class="btn btn-secondary" name="cancel" value="">Vazgeç</a>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
