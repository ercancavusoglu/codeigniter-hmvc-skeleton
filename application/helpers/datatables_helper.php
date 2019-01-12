<?php
    function link_content($uri, $text) {
        return anchor($uri, $text);
    }

    function btn_edit($uri) {
        return anchor($uri, '<i class="glyphicon glyphicon-edit"></i>', array('class' => 'btn btn-default btn-primary btn-xs'));
    }

    function btn_delete($uri, $is_deletable = TRUE) {
        return anchor($uri, '<i class="glyphicon glyphicon-remove"></i>', array('class' => 'btn btn-default btn-danger btn-xs', 'onclick' => ($is_deletable ? "return confirm('Silmek istediğinize emin misiniz?')" : "alert('Kayıt silinemiyor, kullanımda olabilir!');return false;")));
    }

    function btn_confirm($uri) {
        return anchor($uri, '<i class="glyphicon glyphicon-ok"></i>', array('class' => 'btn btn-default btn-primary btn-xs'));
    }

    function btn_reject($uri) {
        return anchor($uri, '<i class="glyphicon glyphicon-remove"></i>', array('class' => 'btn btn-default btn-danger btn-xs'));
    }

    function show_pic($uri, $style=NULL) {
        return "<img src='" . $uri . "' style='" . $style . "'  >";
    }

    function show_ajax_toggle($uri) {

    }