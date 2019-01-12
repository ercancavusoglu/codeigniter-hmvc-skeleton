<section>
    <h3>Müşteri Listesi

        <a href="<?php echo site_url('/admin/member/edit') ?>" class="btn btn-default btn-info pull-right"><span class="glyphicon glyphicon-plus"></span> Müşteri Ekle</a>
    </h3>
    <hr>

    <div>
        <table cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered">
            <thead>
            <tr>
                <th width="1%">ID</th>
                <th width="15%">Ad Soyad</th>
                <th width="15%">E-mail</th>
                <th width="1%">Durum</th>
                <th width="1%" class="actions">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td colspan="5" class="dataTables_empty">Sunucudan veri alınıyor...</td>
            </tr>
            </tbody>
            <tfoot>
            <tr>
                <th>ID</th>
                <th>Ad Soyad</th>
                <th>E-mail</th>
                <th>Durum</th>
                <th>&nbsp;</th>
            </tr>
            </tfoot>
        </table>
    </div>
</section>