<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="SIBEKISAR, CETTAR">
    <meta name="author" content="TemplateMo">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <title>Sibekisar - Sistem Integrasi Bersama Kinerja Implementasi Budaya CETTAR</title>

    <!-- Additional CSS Files -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/landing/css/bootstraps.min.css") ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/landing/css/font-awesome.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/landing/css/main.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/landing/css/owl-carousel.css") ?>">
    
    <link rel="stylesheet" href="<?php echo base_url("assets/landing/css/custom.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/vendors/simple-line-icons/css/simple-line-icons.css") ?>">
    
    <link rel="shortcut icon" href="<?php echo base_url("assets/images/favicon.ico") ?>">
    <script>
        base_url = "<?php echo base_url(); ?>";
    </script>

    <style>
        #layout{
            position: fixed;
            width: 100%;
            height: 1000px;
            background: rgba(0,0,0,0.8);
            z-index: 999;
            text-align: center;
            padding-top: 50%;
            /* display: none; */
        }

        #layout .konten{
            position: fixed;
            top: 50%;
            left: 50%;
            color: white;
            transform: translate(-50%, -50%);
            z-index: 9999;
        }

        .animated-text{
            background: linear-gradient(
                to right,
                #048063 20%,
                #127084 30%,
                #0190cd 70%,
                #245ab0 80%
            );
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            text-fill-color: transparent;
            background-size: 500% auto;
            animation: textShine 3s ease-in-out infinite alternate;
        }

        @keyframes textShine {
            0% {
                background-position: 0% 50%;
            }
            100% {
                background-position: 100% 50%;
            }
        }
    </style>
</head>

<body>

<div id="layout">
    <div class="konten">
        Menyiapkan Data, Harap Tunggu ...
    </div>
</div>

<?php echo view('header') ?>
<!-- ***** Welcome Area Start ***** -->
<div class="welcome-area" id="welcome">

    <!-- ***** Header Text Start ***** -->
    <div class="header-text" style=" background-image: url(<?php echo base_url("assets/landing/images/banner-bg1b.png") ?>);
  background-repeat: no-repeat;
  background-position: left top;margin-left:0!important;">
        <div class="container">
            <div class="row">
                <div class="left-text col-lg-6 col-md-12 col-sm-12 col-xs-12"
                     data-scroll-reveal="enter left move 30px over 0.6s after 0.4s" style="left: 55px!important;">
                    <h1 class="heading">Sistem Integrasi Bersama Kinerja Implementasi Budaya CETTAR <em>(SIBEKISAR)</em></h1>
                    <p style="line-height: normal">Sistem yang menilai kinerja Perangkat Daerah sebagai upaya untuk menguatkan kinerja dengan berbasis aplikasi yang digunakan dengan tetap mengedepankan slogan CETTAR.
                    </p>
                    <a href="<?php echo base_url("read/tentang") ?>" class="main-button-slider">
                        Selengkapnya &nbsp;
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- ***** Header Text End ***** -->
</div>
<!-- ***** Welcome Area End ***** -->

<!-- ***** Features Big Item Start ***** -->
<section class="section" id="promotion">
    <div class="container">
        <div class="center-heading">
            <div class="row">
                <div class="col-md-9" style="padding-top: 7px;">
                    <h3 style="font-weight: 800; font-size: 20pt;">10 Perangkat Daerah, UOBK dan Kab/Kota <span style="font-weight: normal;">Ter</span> <span style="color: #008d5a;">CETTAR</span></h3>
                </div>

                <div class="col-md-3" style="padding-top: 8px;">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Periode</span>
                        </div>

                        <select name="tahun" class="form-control" id="tahun">
                            <?php
                                foreach($dataPeriode as $key => $dPeriode){
                                    $selected = ($key == (count($dataPeriode) - 1)) ? 'selected' : '';
                                    echo '<option value="'.$dPeriode->id_periode.'" '.$selected.'>'.$dPeriode->tahun_periode.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mobile-bottom-fix-big"  style="margin-top: 30px;">
            <div class="col-lg-12 col-md-12 col-sm-12" data-scroll-reveal="enter left move 20px over 0.6s after 0.1s" style="top:0px !important; padding: 0px 5px; margin-bottom: 50px;">
                <div style="padding: 20px; background: white; box-shadow: 0px 0px 10px #ccc; border-radius: 10px;">
                    <div style="text-align: center; font-weight: bold; margin-bottom: 10px; padding-bottom: 20px; border-bottom: 2px dashed #f0f0f0;">
                        <table width="100%">
                            <tr>
                                <td width="80%" style="font-size: 20pt; text-align: center;">
                                    10 Perangkat Daerah <span style="font-weight: normal;">Ter</span> Cettar
                                </td>
                                <td width="20%">
                                    <form class="text-right" method="GET" action="<?php echo base_url("read/detail/spirit/opd") ?>">
                                        <input type="hidden" class="input-periode" name="p" value="<?= $dataPeriode[count($dataPeriode) - 1]->tahun_periode ?>" readonly>
                                        <input type="hidden" class="input-tahun" name="t" value="<?= $dataPeriode[count($dataPeriode) - 1]->id_periode ?>" readonly>

                                        <button type="submit" class="btn second-button btn-xs">
                                            Selengkapnya &nbsp;
                                            <i class="fa fa-arrow-right"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div id="chart"></div>
                </div>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12" data-scroll-reveal="enter left move 20px over 0.6s after 0.1s" style="top:0px !important; padding: 0px 5px; margin-bottom: 50px;">
                <div style="padding: 20px; background: white; box-shadow: 0px 0px 10px #ccc; border-radius: 10px;">
                    <div style="text-align: center; font-weight: bold; margin-bottom: 10px; padding-bottom: 20px; border-bottom: 2px dashed #f0f0f0;">
                        <table width="100%">
                            <tr>
                                <td width="80%" style="font-size: 20pt; text-align: center;">
                                    Unit Organisasi Bersifat Khusus (UOBK) <span style="font-weight: normal;">Ter</span> Cettar
                                </td>

                                <td width="20%">
                                    <form class="text-right" method="GET" action="<?php echo base_url("read/detail/spirit/opd") ?>">
                                        <input type="hidden" class="input-periode" name="p" value="<?= $dataPeriode[count($dataPeriode) - 1]->tahun_periode ?>" readonly>
                                        <input type="hidden" class="input-tahun" name="t" value="<?= $dataPeriode[count($dataPeriode) - 1]->id_periode ?>" readonly>
                                        <input type="hidden" class="input-tag" name="tags" value="uobk" readonly>

                                        <button type="submit" class="btn second-button btn-xs">
                                            Selengkapnya &nbsp;
                                            <i class="fa fa-arrow-right"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div id="chart-uobk"></div>
                </div>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12"  style="top:0px !important; padding: 0px 5px; margin-bottom: 0px;">
                <div style="padding: 20px; background: white; box-shadow: 0px 0px 10px #ccc; border-radius: 10px;">
                    <div style="text-align: center; font-weight: bold; margin-bottom: 10px; padding-bottom: 20px; border-bottom: 2px dashed #f0f0f0;">
                        <table width="100%">
                            <tr>
                                <td width="80%" style="font-size: 20pt; text-align: center;">
                                    10 Kabupaten/Kota Provinsi Jawa Timur <span style="font-weight: normal;">Ter</span> Cettar
                                </td>

                                <td width="20%">
                                    <form class="text-right" method="GET" action="<?php echo base_url("read/detail/spirit/kab") ?>">
                                        <input type="hidden" class="input-periode" name="p" value="<?= $dataPeriode[count($dataPeriode) - 1]->tahun_periode ?>" readonly>
                                        <input type="hidden" class="input-tahun" name="t" value="<?= $dataPeriode[count($dataPeriode) - 1]->id_periode ?>" readonly>

                                        <button type="submit" class="btn second-button btn-xs">
                                            Selengkapnya &nbsp;
                                            <i class="fa fa-arrow-right"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div id="chart-kab"></div>
                </div>
            </div>
        </div>

        <!-- <div class="row mobile-bottom-fix" style="padding-top:20px!important">
            <?php 
                $keys   = 0;
                $icons  = [
                    base_url("assets/landing/images/fast-time1.png"),
                    base_url("assets/landing/images/time-management1.png"),
                    base_url("assets/landing/images/rocket1.png"),
                    base_url("assets/landing/images/accounting1.png"),
                    base_url("assets/landing/images/user1.png"),
                    base_url("assets/landing/images/clock1.png"),
                ];
                
                foreach($aspek as $key => $dataView) { 
            ?>

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" data-scroll-reveal="enter right move 30px over 0.6s after 0.1s" style="margin-bottom: 30px;">
                    <div class="features-item row" style="padding: 30px;">
                        <div class="col-md-12" style="font-weight: bold; font-size: 20pt;">
                            <img src="<?php echo $icons[$keys]  ?>" alt="" style="width: 5%; margin-top: 40px;"> &nbsp;&nbsp;
                            5 Perangkat Daerah, UOBK dan Kabupaten/Kota <?= $keys ?> <span style="font-weight: normal;">Ter</span> 
                            <span class="animated-text"><?= ucfirst($dataView->aspek) ?></span>
                        </div>

                        <div class="col-md-12 p-0">
                            <div class="row">
                                <div class="col-md-4">
                                    <div id="chart-<?= $keys ?>"></div>
                                    <div style="margin-top: 35px;">
                                        <div class="features-icon">
                                            <div class="text">
                                                <div style="font-size: 14pt !important; margin-bottom: 15px;">
                                                    Perangkat Daerah <br> ter <b><?= ucfirst($dataView->aspek) ?></b>
                                                </div>
                                                <div style="font-size: 14pt !important; font-weight: bold;">
                                                    <span class="text-danger lbl-tercepat aspek-info" id="aspek_<?= $key ?>">
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
        
                                <div class="col-md-4">
                                    <div id="chart-uobk-<?= $keys ?>"></div>
                                    <div style="margin-top: 35px;">
                                        <div class="features-icon">
                                            <div class="text">
                                                <div style="font-size: 14pt !important; margin-bottom: 15px;">
                                                    UOBK <br> ter <b><?= ucfirst($dataView->aspek) ?></b>
                                                </div>
                                                <div style="font-size: 14pt !important; font-weight: bold;">
                                                    <span class="text-danger lbl-tercepat aspek-info" id="uobk_ter_<?= $key ?>">
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
        
                                <div class="col-md-4">
                                    <div id="chart-kab-<?= $keys ?>"></div>
                                    <div style="margin-top: 35px;">
                                        <div class="features-icon">
                                            <div class="text">
                                                <div style="font-size: 14pt !important; margin-bottom: 15px;">
                                                    Kab/Kota <br> ter <b><?= ucfirst($dataView->aspek) ?></b>
                                                </div>
                                                <div style="font-size: 14pt !important; font-weight: bold;">
                                                    <span class="text-danger lbl-tercepat aspek-info" id="kab_ter_<?= $key ?>">
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4" style="text-align: center; padding-top: 30px;">
                                    <form class="text-center" method="GET" action="<?php echo base_url("read/detail/".str_replace(' ', '-', $key))?>1/opd">
                                        <input type="hidden" class="input-periode" name="p" value="<?= $dataPeriode[count($dataPeriode) - 1]->tahun_periode ?>" readonly>
                                        <input type="hidden" class="input-tahun" name="t" value="<?= $dataPeriode[count($dataPeriode) - 1]->id_periode ?>" readonly>
                                        <input type="hidden" name="ids" value="<?= ($dataView) ? $dataView->id_aspek : null ?>" readonly>

                                        <button type="submit" style="font-size: 10pt; color: #999; border: none; background: none; padding: 0px; outline: none;">
                                            Selengkapnya &nbsp;
                                            <i class="fa fa-arrow-right"></i>
                                        </button>
                                    </form>
                                </div>

                                <div class="col-md-4" style="text-align: center; padding-top: 30px;">
                                    <form class="text-center" method="GET" action="<?php echo base_url("read/detail/".str_replace(' ', '-', $key))?>1/opd">
                                        <input type="hidden" class="input-periode" name="p" value="<?= $dataPeriode[count($dataPeriode) - 1]->tahun_periode ?>" readonly>
                                        <input type="hidden" class="input-tahun" name="t" value="<?= $dataPeriode[count($dataPeriode) - 1]->id_periode ?>" readonly>
                                        <input type="hidden" name="ids" value="<?= ($dataView) ? $dataView->id_aspek : null ?>" readonly>
                                        <input type="hidden" name="tags" value="uobk" readonly>

                                        <button type="submit" style="font-size: 10pt; color: #999; border: none; background: none; padding: 0px; outline: none;">
                                            Selengkapnya &nbsp;
                                            <i class="fa fa-arrow-right"></i>
                                        </button>
                                    </form>
                                </div>

                                <div class="col-md-4" style="text-align: center; padding-top: 30px;">
                                    <form class="text-center" method="GET" action="<?php echo base_url("read/detail/".str_replace(' ', '-', $key))?>1/kab">
                                        <input type="hidden" class="input-periode" name="p" value="<?= $dataPeriode[count($dataPeriode) - 1]->tahun_periode ?>" readonly>
                                        <input type="hidden" class="input-tahun" name="t" value="<?= $dataPeriode[count($dataPeriode) - 1]->id_periode ?>" readonly>
                                        <input type="hidden" name="ids" value="<?= (count($aspekKab) && $aspekKab[$key]) ? $aspekKab[$key]->id_aspek : '' ?>" readonly>

                                        <button type="submit" style="font-size: 10pt; color: #999; border: none; background: none; padding: 0px; outline: none;">
                                            Selengkapnya &nbsp;
                                            <i class="fa fa-arrow-right"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php $keys++; } ?>
        </div> -->

    </div>
</section>
<!-- ***** Features Big Item End ***** -->

<!--<div class="right-image-decor"></div>-->

<!-- ***** Testimonials Starts ***** -->
<!--<section class="section" id="kategori">
    <div class="container">
        <div class="row" id="testimonials">
            <div class="col-lg-8 offset-lg-2">
                <div class="center-heading">
                    <h2>Kategori Perangkat Daerah <em>Terbaik</em></h2>
                    <p>Parameter CETTAR terintegrasi dengan mekanisme kerja organisasi dalam upaya mencapai produktivitas kerja yang prima, sehingga perumusan indikator CETTAR ditetapkan sesuai dengan sistem dan mekanisme kerja organisasi yang ada.</p>
                </div>
            </div>
            <div class="col-lg-10 col-md-12 col-sm-12 mobile-bottom-fix-big"
                 data-scroll-reveal="enter left move 30px over 0.6s after 0.4s">
                <div class="owl-carousel owl-theme">
                    <?php
                    /*if($cettar){
                        $i=0;
                        foreach ($cettar as $key){
                            $i++;
                            ?>
                            <div class="item service-item">
                                <div class="author">
                                    <i><img src="<?php echo base_url("assets/landing/images/terbaik".$i.".png") ?>" alt="Author One"></i>
                                </div>
                                <div class="testimonial-content">
                                    <h4>Predikat: <?php echo $key->predikat?></h4>
                                    <h4><?php echo $key->unit?></h4>
                                    <p>Nilai CETTAR: <?php echo $key->nilai_huruf?></p>
                                    <span>Total Nilai: <?php echo $key->nilai?></span>
                                </div>
                            </div>
                            <?php
                        }
                    }*/
                    ?>

                </div>
            </div>
        </div>
    </div>
</section>-->
<!-- ***** Testimonials Ends ***** -->


<!-- ***** Footer Start ***** -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="sub-footer">
                    <p>Copyright &copy; 2021 | Biro Organisasi Pemerintah Propinsi Jawa Timur</p>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- jQuery -->
<script src="<?php echo base_url("assets/landing/js/jquery-2.1.0.min.js") ?>"></script>

<!-- Bootstrap -->
<script src="<?php echo base_url("assets/landing/js/popper.js") ?>"></script>
<script src="<?php echo base_url("assets/landing/js/bootstrap.min.js") ?>"></script>

<!-- Plugins -->
<script src="<?php echo base_url("assets/landing/js/owl-carousel.js") ?>"></script>
<script src="<?php echo base_url("assets/landing/js/scrollreveal.min.js") ?>"></script>
<script src="<?php echo base_url("assets/landing/js/waypoints.min.js") ?>"></script>
<script src="<?php echo base_url("assets/landing/js/jquery.counterup.min.js") ?>"></script>
<script src="<?php echo base_url("assets/landing/js/imgfix.min.js") ?>"></script>

<!-- Global Init -->
<script src="<?php echo base_url("assets/vendors/highchart/highcharts.js") ?>"></script>
<script src="<?php echo base_url("assets/vendors/highchart/highcharts-3d.js") ?>"></script>
<script src="<?php echo base_url("assets/landing/js/custom.js") ?>"></script>
<script src="<?php echo base_url("assets/landing/js/home.js") ?>"></script>

</body>
</html>