<div class="row">
    <div class="col-lg-5">
        <div class="box">
            <header class="dark">
                <h5>Paket <?php echo empty($package->id) ? "Ekle" : "Düzenle: " . $package->title ?></h5>
            </header>
            <div id="collapse2" class="body">
                <form enctype="multipart/form-data" action="<?php site_url('/admin/package') . '/edit/' . (empty($package->id) ? "" : $package->id) ?>" method="POST" class="form-horizontal" id="popup-validation">
                    <div class="form-group">
                        <label class="control-label col-lg-4">Paket Adı</label>
                        <div class="col-lg-4">
                            <input type="text" class="validate[required] form-control" name="title" id="title" placeholder="" value="<?php echo !empty($package->id) ? $package->title : '' ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-4">Paket Açıklaması</label>
                        <div class="col-lg-4">
                            <input type="text" class="validate[required] form-control" name="description" id="description" placeholder="" value="<?php echo !empty($package->id) ? $package->description : '' ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-4">Paket Fiyatı</label>
                        <div class="col-lg-4">
                            <input type="text" class="validate[required] form-control" name="price" id="name" placeholder="" value="<?php echo !empty($package->id) ? $package->price : '' ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-4">Resim</label>
                        <div class="col-lg-4">
                            <div class="fileinput fileinput-<?php echo ( empty($package->picture) ? "new" : "exists") ?>" data-provides="fileinput">
                                <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 90px; height: 90px;">
                                    <?php if (!empty($package->picture)) { ?><img src="<?php echo site_url('assets/images/packages/' .  $package->picture) ?>" alt="..."><?php } ?>
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
                        <label class="control-label col-lg-4">Durum</label>
                        <div class="col-lg-4">
                            <select class="form-control" name="status">
                                <option value="active" <?php echo (empty($package->id) ? "" : (($package->status == "active") ? "selected" : "")) ?>>Active</option>
                                <option value="inactive" <?php echo (empty($package->id) ? "selected" : (($package->status == "inactive") ? "selected" : "")) ?>>Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-actions no-margin-bottom">
                        <input type="submit" value="Kaydet" class="btn btn-primary">
                        <a href="<?php echo site_url('/admin/package') ?>" id="cancel" class="btn btn-secondary" name="cancel" value="">Vazgeç</a>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->
