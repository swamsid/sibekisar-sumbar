<!-- partial -->
<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item navbar-brand-mini-wrapper">
            <a class="nav-link navbar-brand brand-logo-mini" href="<?php echo base_url('apps/dashboard')?>"><img src="<?php echo base_url("assets/images/logo-mini.svg") ?>" alt="logo" /></a>
        </li>
        <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
                <div class="profile-image">
                    <img class="img-xs rounded-circle" src="<?php echo base_url("assets/images/logo.png") ?>" alt="profile image">
                    <div class="dot-indicator bg-success"></div>
                </div>
                <div class="text-wrapper">
                    <p class="profile-name"><?php echo (isset($user)?$user->nama:'') ?></p>
                    <p class="designation"><?php echo (isset($user) && $user->id_role==1?'Administrator':'Operator') ?></p>
                </div>
                <div class="icon-container">
                    <i class="icon-bubbles"></i>
                    <div class="dot-indicator bg-danger"></div>
                </div>
            </a>
        </li>
        <li class="nav-item nav-category">
            <span class="nav-link">Dashboard</span>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('apps/dashboard') ?>">
                <span class="menu-title">Dashboard</span>
                <i class="icon-screen-desktop menu-icon"></i>
            </a>




       <?php  if ($_SESSION['user']->id_role==1 or ($_SESSION['user']->id_role==2 && !empty($_SESSION['user']->id_unit))){ ?>
        <li class="nav-item nav-category">
            <span class="nav-link">Penilaian</span>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('apps/evaluasi') ?>">
                <span class="menu-title">Penilaian<br>Perangkat Daerah</span>
                <i class="icon-star menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('apps/evaluasi/kab') ?>">
                <span class="menu-title">Penilaian<br>Kab/Kota</span>
                <i class="icon-book-open menu-icon"></i>
            </a>
        </li>
          <!-- <li class="nav-item nav-category">
               <span class="nav-link">Verifikasi</span>
           </li>
           <li class="nav-item">
               <a class="nav-link" href="<?php //echo base_url('apps/verifikasi') ?>">
                   <span class="menu-title">Verifikasi & Validasi<br>Penilaian PD</span>
                   <i class="icon-diamond menu-icon"></i>
               </a>
           </li>
           <li class="nav-item">
            <a class="nav-link" href="<?php //echo base_url('apps/verifikasi/kab') ?>">
                <span class="menu-title">Verifikasi & Validasi<br>Penilaian Kab/Kota</span>
                <i class="icon-layers menu-icon"></i>
            </a>
        </li>-->
        <?php } ?>
        <li class="nav-item nav-category"><span class="nav-link">RAPOR</span></li>

        <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('apps/rapor/opd') ?>">
                <span class="menu-title">Rapor PD</span>
                <i class="icon-book-open menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('apps/rapor/kab') ?>">
                <span class="menu-title">Rapor Kab/Kota</span>
                <i class="icon-paper-clip menu-icon"></i>
            </a>
        </li>
        <li class="nav-item nav-category"><span class="nav-link">REKAP</span></li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#page-layouts" aria-expanded="false" aria-controls="page-layouts">
                <span class="menu-title">Rangking PD</span>
                <i class="icon-chart menu-icon"></i>
            </a>
            <div class="collapse" id="page-layouts">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="<?php echo base_url('apps/rangking/cettar') ?>">Dalam CETTAR</a></li>
                    <li class="nav-item"> <a class="nav-link" href="<?php echo base_url('apps/rangking/spirit') ?>">Dalam Spirit</a></li>
                    <!--<li class="nav-item"> <a class="nav-link" href="<?php //echo base_url('apps/rangking/indikator') ?>">Berdasarkan Indikator</a></li>-->
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#page-layouts" aria-expanded="false" aria-controls="page-layouts">
                <span class="menu-title">Rangking Kab/Kota</span>
                <i class="icon-pie-chart menu-icon"></i>
            </a>
            <div class="collapse" id="page-layouts">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="<?php echo base_url('apps/rangking/cettar/kab') ?>">Dalam CETTAR</a></li>
                    <li class="nav-item"> <a class="nav-link" href="<?php echo base_url('apps/rangking/spirit/kab') ?>">Dalam Spirit</a></li>
                    <!--<li class="nav-item"> <a class="nav-link" href="<?php //echo base_url('apps/rangking/indikator') ?>">Berdasarkan Indikator</a></li>-->
                </ul>
            </div>
        </li>


          <?php
       /* $aspek=array();
        foreach ($indikator as $key):
               $temp = array(
                    "id_aspek" => $key->id_aspek,
                    "aspek" => $key->aspek,
                    'icon' => $key->icon
                );
                if (!in_array($temp, $aspek)) array_push($aspek, $temp);
        endforeach;
        foreach($aspek as $row):
            ?>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#<?php echo $row['id_aspek'];  ?>" aria-expanded="false" aria-controls="ui-basic">
                    <span class="menu-title"><?php echo ucWords($row['aspek']); ?></span>
                    <i class="<?php echo $row['icon'];  ?> menu-icon"></i>
                </a>
                <div class="collapse" id="<?php echo $row['id_aspek'];  ?>">
                    <ul class="nav flex-column sub-menu">
                        <?php
                        foreach ($indikator as $key) {
                            if ($key->id_aspek == $row['id_aspek']) {
                                ?>
                                <li class="nav-item"> <a class="nav-link" href="<?php echo base_url('apps/evaluasi/'.$key->id_indikator) ?>"><?php echo $key->indikator ?></a></li>
                                <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
            </li>
        <?php
        endforeach;*/
          if($_SESSION['user']->id_role==1) {
        ?>

        <li class="nav-item nav-category"><span class="nav-link">SETTINGS</span></li>

        <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('module/users') ?>">
                <span class="menu-title">Pengguna</span>
                <i class="icon-grid menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#link-indikator" aria-expanded="false" aria-controls="page-layouts">
                <span class="menu-title">Indikator</span>
                <i class="icon-folder menu-icon"></i>
            </a>
            <div class="collapse" id="link-indikator">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="<?php echo base_url('module/master/indikator') ?>">Indikator PD</a></li>
                    <li class="nav-item"> <a class="nav-link" href="<?php echo base_url('module/master/indikator/kab') ?>">Indikator Kab/Kota</a></li>

                </ul>
            </div>

            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#link-prof" aria-expanded="false" aria-controls="page-layouts">
                    <span class="menu-title">Profil PD & Kab/Kota</span>
                    <i class="icon-anchor menu-icon"></i>
                </a>
                <div class="collapse" id="link-prof">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="<?php echo base_url('module/master/unit') ?>">Profil PD</a></li>
                        <li class="nav-item"> <a class="nav-link" href="<?php echo base_url('module/master/unit/kab') ?>">Profil Kab/Kota</a></li>

                    </ul>
                </div>
            </li>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('module/master/periode') ?>">
                <span class="menu-title">Periode Tahun</span>
                <i class="icon-calendar menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('module/api/index') ?>">
                <span class="menu-title">API Center</span>
                <i class="icon-share menu-icon"></i>
            </a>
        </li>
    <?php } ?>
        <li class="nav-item nav-category"><span class="nav-link">Help</span></li>
        <li class="nav-item">
            <a class="nav-link" href="#" target="_blank">
            <span class="menu-title">Documentation</span>
            <i class="icon-folder-alt menu-icon"></i>
            </a>
        </li>
    </ul>
</nav>