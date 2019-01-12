$('.datatable').dataTable( {
    "bProcessing": true,
    "bServerSide": true,
    "sPaginationType": "bs_full",
    "sAjaxSource": '<?php echo site_url($sAjaxSource); ?>',
    "oLanguage": {
        "sProcessing":   "<div style=\"position: fixed; top: 0; left: 0; width:100%; height:100%; background-color: rgba(100, 100, 100, 0.5); z-index: 100000;\"><div style=\"margin-left: -16px; top: 50%; margin-top: -16px;width: 52px; height: 52px; border: 1px solid black; background-color:#ffffff; padding: 10px; position: fixed;left: 50%;\"><img src=\"<?php echo site_url('assets/img/ajax_loader_gray_32.gif')?>\"></div></div>",
        "sLengthMenu":   "Sayfada _MENU_ Kayıt Göster",
        "sZeroRecords":  "Eşleşen Kayıt Bulunmadı",
        "sInfo":         "  _TOTAL_ Kayıttan _START_ - _END_ Arası Kayıtlar",
        "sInfoEmpty":    "Kayıt Yok",
        "sInfoFiltered": "( _MAX_ Kayıt İçerisinden Bulunan)",
        "sInfoPostFix":  "",
        "sSearch":       "Bul:",
        "sUrl":          "",
        "oPaginate": {
            "sFirst":    "İlk",
            "sPrevious": "Önceki",
            "sNext":     "Sonraki",
            "sLast":     "Son"
        }
    },
    'fnServerData': function (sSource, aoData, fnCallback) {
        $.ajax({
            'dataType': 'json',
            'type': 'POST',
            'url': sSource,
            'data': aoData,
            'success': fnCallback
        });
    },
    "aoColumnDefs": [
        { "bSortable": false, "aTargets": [ 'actions' ] }
    ]
});
$('.datatable').each(function(){
    var datatable = $(this);
    // SEARCH - Add the placeholder for Search and Turn this into in-line form control
    var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
    search_input.attr('placeholder', 'Bul');
    search_input.addClass('form-control input-sm');
    // LENGTH - Inline-Form control
    var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
    length_sel.addClass('form-control input-sm');
});