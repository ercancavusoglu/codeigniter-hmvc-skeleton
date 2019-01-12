<?php
$peers = array();
?>

    <link rel="stylesheet" href="<?php echo site_url('assets/lib/jquery.orgchart/css/demo.css') ?>"/>
    <link rel="stylesheet" href="<?php echo site_url('assets/lib/jquery.orgchart/css/jquery.orgchart.css') ?>"/>
    <style>
        div.orgChart div.node {
            cursor: pointer;
        }

        div.orgChart div.node.big {
            width: 150px;
            height: 220px;
        }

        div.orgChart div.node.big img {
            /*border: 2px solid black;
            border-radius: 4px;*/
            width: 144px;
            height: 198px;
        }

        #orgtree {
            width: 1024px;
            height: 768px;
            overflow: scroll;
            border: 1px solid;
        }
    </style>


<div id="orgsdiv" style="display:none;">
    <?php echo $org_data?>
</div>
<div id="orgtree" class="orgChart" style="width: 1024px; height: 768px; border: none; overflow:scroll">

</div>
