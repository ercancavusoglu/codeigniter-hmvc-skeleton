<script type="text/javascript">
    $(function(){

        try {
            $("#organisation").orgChart({container: $("#orgtree"),  interactive: true, showLevels : 3 });

        } catch(e){}
        try {

            var $select = $('.select2').select2({
                placeholder: "Seçiniz",
                allowClear: true
            });
        } catch(e){}


        try {
            <?php !$this->data['useDatatables'] || $this->load->view('common/_components/datatable_script'); ?>
        } catch(e){}


        $('nav.menu ul li').hover(
            function () {
                //show its submenu
                $('ul', this).slideDown(150);
            },
            function () {
                //hide its submenu
                $('ul', this).slideUp(150);
            }
        );
    });
</script>
</body>
</html>