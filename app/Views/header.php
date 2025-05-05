<!-- ***** Preloader Start ***** -->
<div id="preloader">
    <div class="jumper">
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>
<!-- ***** Preloader End ***** -->
<!-- ***** Header Area Start ***** -->
<header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav class="main-nav">
                    <!-- aaa -->
                    <!-- ***** Logo Start ***** -->
                    <a class="logo" href="<?php  echo base_url('home') ?>">
                        <img src="<?php echo base_url("assets/images/logo-sibekisar.png") ?>" alt="logo" style="width: 180px" />
                    </a>
                    <!-- ***** Logo End ***** -->
                    <!-- ***** Menu Start ***** -->
                    <ul class="nav">
                        <li class="scroll-to-section"><a href="<?php  echo base_url('home') ?>" >Home</a></li>
                        <!-- <li class="scroll-to-section"><a href="" >Tentang</a></li> -->
                        <li class="scroll-to-section"><a href="<?php echo base_url('read/opd') ?>" >Perangkat Daerah</a></li>
                        <!-- <li class="scroll-to-section"><a href="<?php echo base_url('read/kab') ?>" >Kab/Kota</a></li> -->
                        <li class="scroll-to-section"><a href="#" id="nav-indikator">Indikator</a></li>

                        <li class="scroll-to-section" style="border-left: 2px solid #eee; padding-left: 20px;">
                            <a href="<?php echo base_url('auth') ?>" >Login</a>
                        </li>
                    </ul>
                    
                    <a class='menu-trigger'>
                        <span>Menu</span>
                    </a>
                    <!-- ***** Menu End ***** -->
                </nav>
            </div>

            <div class="col-md-6 offset-6" style="position: relative;">
                <div class="sub-menu" id="sub-menu">
                    <div class="konteks-title">
                        <div class="title active">
                            Perangkat Daerah
                        </div>
                        <div class="title">
                            Kabupaten/Kota
                        </div>
                    </div>

                    <span class="text-keterangan" style="display: block; padding: 0px 5px; font-size: 8pt; color: #aaa;">
                        Klik pada indikator dibawah ini untuk melihat nilai per indikator
                    </span>

                    <div class="konteks-indikator custom-scrollbar">
                        
                    </div>
                </div>
            </div>
        </div>

        <div id="template-loading" style="display: none;">
            <div class="loading">
                <img src="<?php echo base_url("assets/images/loading.svg") ?>" alt="logo" style="width: 20%"/>
                <div style="color: #aaa;">
                    Sedang Mengambil Data. Harap Tunggu ...
                </div>
            </div>
        </div>
    </div>
</header>
<!-- ***** Header Area End ***** -->