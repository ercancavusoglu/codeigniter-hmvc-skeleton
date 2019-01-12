<?php $this->load->view('common/_components/page_head'); ?>
    <header>
        <div id="mainDynamicData"></div>
        <div class="topBackground"><img src="<?php echo site_url('/assets/img/bg.png') ?>" alt="" />
            <div class="topLogo"><a href="<?php echo site_url($this->session->userdata('user_type') . '/dashboard') ?>">
            <img src="<?php echo site_url('/assets/img/logo.png') ?>" title="" alt="" /></a></div>
        </div>
    </header>

    <section class="main">
        <div class="mainMenu">
            <div class="contentMenu">

                <div class="menuall">
                    <div class="kisiBilgi ">
                        <div class="koseResim goldimg">
                            <img src="<?php echo site_url('/assets/img/gold.png') ?>" alt=""><div class="gold">Müdür</div>
                        </div><!-- .koseResim .goldImg -->
                        <div class="kisiIsim"><?php echo $this->session->userdata('fullname')?></div><!-- .kisiIsim -->
                        <div class="kisiResim ResimArka">
                            <img src="<?php echo ($this->session->userdata('picture') != '' ? site_url('/assets/img/members/' . $this->session->userdata('picture')) : '') ?>" /></div><!-- .kisiResim .ResimArka -->
                        <div class="kisiYazi">
                            <!-- <span class="kisi_bilgileri2"><a href="/authake/user">Profil Ayarları</a> </span> -->
                            <span class="kisi_bilgileri2"><?php echo $this->session->userdata('email') ?></span>
                        </div><!-- .kisiYazi -->

                    </div><!-- .kisiBilgi -->
                    <?php $this->load->view('common/_components/left_menu'); ?>
                </div><!-- .menuAll -->
            </div><!-- .contentMenu -->
            <div class="cikis">
                <div class="cikisBilgi">
                    <span class="menuisim2"><a href="<?php echo site_url('public/user/logout') ?>">Çıkış Yap</a></span>
                    <div class="cikisResim"><img src="<?php echo site_url('/assets/img/cikis.png') ?>" alt="" /></div>
                </div>
            </div><!-- .cikis -->
            <div class="menuisim2 menuisimfooter"></div>
        </div><!-- .mainMenu -->

        <div class="allmain">
            <section class="content">

                <div class="contentMain">
                    <div class="contentGenel">
                        <?php $this->load->view($subview); ?>
                    </div><!-- .contentGenel -->
                </div><!-- .contetnMain -->

            </section><!-- .content -->
        </div><!-- .allMain -->
    </section>  <!-- .main -->
<?php $this->load->view('common/_components/page_tail'); ?>