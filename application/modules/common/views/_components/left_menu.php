<nav class="menu ul menuAdi menuIcon">


<ul class="nav pull-left">

    <?php foreach ($leftmenu as $menu_item) { ?>
        <?php if (isset($menu_item['module']) || isset($menu_item['link']) || (isset($menu_item['subitems']) && count($menu_item['subitems']) > 0)) { ?>
            <li class="<?php echo(isset($menu_item['subitems']) && count($menu_item['subitems']) > 0 ? 'dropdown' : '') ?>">
                <a href="<?php echo(isset($menu_item['module']) ? site_url($context . '/' . $menu_item['module'] . (isset($menu_item['action']) ? '/' . $menu_item['action'] : '')) : (isset($menu_item['link']) ? site_url($menu_item['link']) : "#")) ?>">
                    <?php if (isset($menu_item['icon']) || isset($menu_item['module']) && isset($modules[$menu_item['module']]['icon'])) { ?>
                        <img src="<?php site_url('/assets/img/' . ( isset($menu_item['icon']) ? $menu_item['icon'] : $modules[$menu_item['module']]['icon']) ) ?>" alt="" />
                    <?php } ?>
                    <?php echo(isset($menu_item['title']) ? $menu_item['title'] : $modules[$menu_item['module']]['title']) ?>
                </a>

                <?php if (isset($menu_item['subitems']) && count($menu_item['subitems']) > 0) { ?>
                    <ul class="sub_menu">
                        <?php foreach ($menu_item['subitems'] as $lvl1_menu_item) { ?>
                            <?php if (isset($lvl1_menu_item['module']) || isset($lvl1_menu_item['link']) || (isset($lvl1_menu_item['subitems']) && count($lvl1_menu_item['subitems']) > 0)) { ?>
                                <li class="<?php echo(isset($lvl1_menu_item['subitems']) && count($lvl1_menu_item['subitems']) > 0 ? 'dropdown' : '') ?>">
                                    <a href="<?php echo(isset($lvl1_menu_item['module']) ? site_url($context . '/' . $lvl1_menu_item['module'] . (isset($lvl1_menu_item['action']) ? '/' . $lvl1_menu_item['action'] : '')) : (isset($lvl1_menu_item['link']) ? site_url($lvl1_menu_item['link']) : "#")) ?>">
                                        <?php if (isset($lvl1_menu_item['icon']) || isset($lvl1_menu_item['module']) && isset($modules[$lvl1_menu_item['module']]['icon'])) { ?>
                                            <img src="<?php site_url('/assets/img/' . ( isset($lvl1_menu_item['icon']) ? $lvl1_menu_item['icon'] : $modules[$lvl1_menu_item['module']]['icon']) ) ?>" alt="" />
                                        <?php } ?>
                                        <?php echo(isset($lvl1_menu_item['title']) ? $lvl1_menu_item['title'] : $modules[$lvl1_menu_item['module']]['title']) ?>
                                    </a>
                                </li>
                            <?php } ?>
                        <?php } ?>
                    </ul>
                <?php } ?>
            </li>
        <?php } ?>
    <?php } ?>
</ul><ul class="nav pull-right"></ul>
</nav>