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
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/landing/css/bootstrap.min.css") ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/landing/css/font-awesome.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/landing/css/main.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/landing/css/owl-carousel.css") ?>">
    <link rel="shortcut icon" href="<?php echo base_url("assets/images/favicon.ico") ?>">
    <script>
        base_url = "<?php echo base_url(); ?>";
    </script>

    <style>
        #layout{
            position: fixed;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.8);
            z-index: 9999;
            text-align: center;
            padding-top: 50%;
            margin-top: -10vw;
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
<div class="left-image-decor"></div>
<section class="section" style="margin-top:10%!important;">
    <div class="container">
        <div class="center-heading">
            <div class="row">
                <div class="col-md-9">
                    <h2> Top 10 Kabupaten/Kota <em>Tercettar</em></h2>
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

        <div class="row  mobile-bottom-fix-big"  data-scroll-reveal="enter left move 30px over 0.6s after 0.1s">
            <div class="col-lg-12 col-md-12 col-sm-12" style="top:0px!important">
                <div id="chart"></div>
            </div>

            <div class="col-md-12">
                <form class="text-right" method="GET" action="<?php echo base_url("read/detail/spirit/kab") ?>" style="margin-top: 50px;">
                    <input type="hidden" class="input-periode" name="p" value="<?= $dataPeriode[count($dataPeriode) - 1]->tahun_periode ?>" readonly>
                    <input type="hidden" class="input-tahun" name="t" value="<?= $dataPeriode[count($dataPeriode) - 1]->id_periode ?>" readonly>
                    <button type="submit" class="btn second-button btn-sm">
                        Selengkapnya &nbsp;
                        <i class="fa fa-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>

        <div class="row mobile-bottom-fix" style="padding-top:20px!important">
            <?php 
                $keys = 0;
                foreach($aspek as $key => $dataView) { 
            ?>

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" data-scroll-reveal="enter right move 30px over 0.6s after 0.1s">
                    <div class="features-item row">
                        <div class="col-md-4">
                            <div class="features-icon">
                                <img src="<?php echo base_url("assets/landing/images/fast-time1.png") ?>" alt="">
                                    <div class="text">
                                        <h4>ter <b><?= ucfirst($key) ?></b></h4>
                                        <h3>
                                            <span class="text-danger text-bold lbl-tercepat aspek-info" id="aspek_<?= ($dataView) ? $keys : '' ?>">
                                            </span>
                                        </h3>
                                    </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div id="chart-<?= $keys ?>"></div>
                        </div>
                        <div class="col-md-12">
                            <form class="text-right" method="GET" action="<?php echo base_url("read/detail/".str_replace(' ', '-', $key))?>/kab" style="margin-top: 50px;">
                                <input type="hidden" class="input-periode" name="p" value="<?= $dataPeriode[count($dataPeriode) - 1]->tahun_periode ?>" readonly>
                                <input type="hidden" class="input-tahun" name="t" value="<?= $dataPeriode[count($dataPeriode) - 1]->id_periode ?>" readonly>
                                <input type="hidden" name="ids" value="<?= ($dataView) ? $dataView->id_aspek : null ?>" readonly>
                                <button type="submit" class="btn second-button btn-sm">
                                    Selengkapnya &nbsp;
                                    <i class="fa fa-arrow-right"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php $keys++; } ?>
        </div>

    </div>
</section>
<!-- ***** Features Big Item End ***** -->

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
<script src="<?php echo base_url("assets/landing/js/home_kab.js") ?>"></script>

</body>
</html>