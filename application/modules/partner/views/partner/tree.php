<?php
$peers = array();
?>

    <link rel="stylesheet" href="<?php echo site_url('assets/lib/jquery.orgchart/css/demo.css') ?>"/>
    <link rel="stylesheet" href="<?php echo site_url('assets/lib/jquery.orgchart/css/jquery.orgchart.css') ?>"/>
    <style>

        div.orgChart div.node  {
            border: none;
            background-color: transparent;
            display: inline-block;
            margin-right: 10px;
            margin-left: 10px;
            -webkit-box-shadow: none;
        }

        div.orgChart div.node  img {
            display: inline-block;
            width: 44px;
            margin-right: 10px;
            margin-left: 10px;
        }

        div.orgChart div.node.level0-node0 {
            border: none;
            background-color: transparent;
            display: inline-block;
            width: 150px;
            margin-right: 10px;
            margin-left: 10px;
            -webkit-box-shadow: none;
        }

        div.orgChart div.node.level0-node0 img {
            display: inline-block;
            width: 117px;
            margin-right: 10px;
            margin-left: 10px;
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
<div id="orgtree" class="orgChart" style="width: 1024px; height: 768px; border: none; overflow:auto">

</div>
