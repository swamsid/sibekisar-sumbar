<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="SIBEKISAR, CETTAR">
    <meta name="author" content="TemplateMo">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <title>Sibekisar - Sistem Integrasi Bersama Kinerja Implementasi Budaya CETTAR</title>

    <!-- Additional CSS Files -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/landing/css/bootstraps.min.css") ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/landing/css/font-awesome.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/vendors/datatables/dataTables.bootstrap4.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/vendors/datatables/responsive.dataTables.min.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/vendors/datatables/rowGroup.dataTables.min.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/vendors/datatables/buttons.bootstrap4.min.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/vendors/select2/select2.min.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/landing/css/main.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/landing/css/owl-carousel.css") ?>">
    <link rel="shortcut icon" href="<?php echo base_url("assets/images/favicon.ico") ?>">
    
    <script>
        base_url = "<?php echo base_url(); ?>";
    </script>

    <style>        
        .select2-container .select2-selection--single {
            height: 37px !important;
            font-size: 12pt !important;
            padding-top: 5px !important;
            padding-left: 10px !important; 
        }
    </style>

    <style>
        #layout{
            position: fixed;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.8);
            z-index: 999;
            text-align: center;;
            /* display: none; */
            margin-top: -20vh;
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
<div class="left-image-decor"></div>
<section class="section" style="margin-top:10%!important;">
        <div class="container">
            <div class="row" style="display: block;">
                <div class="card" id="divDataRekap">
                    <div class="card-body" >
                        <h4 class="card-title">Rangking <?php echo $label ?></h4>
                        <div class="row">
                            <div class="col-12">
                                <blockquote class="blockquote blockquote-primary">
                                    <form id="frmsearch" class="forms-sample form-horizontal">
                                        <?php
                                            $link = strtok($_SERVER['REQUEST_URI'], '?');
                                            $link_array = explode('/',$link);
                                            $page = end($link_array);
                                        ?>

                                        <?php print($page) ?>

                                        <?php if($page == 'kab') { ?>
                                            <input type="hidden" id="tag" value="kab">
                                        <?php } ?>

                                        <input type="hidden" id="lblunit" value="<?php echo $label ?>">

                                        <div class="form-group"><label>Filter pencarian</label>
                                            <div class="form-group row">
                                                <div class="col-md-2">
                                                    <label>Tahun</label>
                                                    <select name="tahun" class="form-control" id="tahun">
                                                        <?php 
                                                            foreach($dataPeriode as $key => $dPeriode){
                                                                $selected = ($dPeriode->id_periode == $_GET['t']) ? 'selected' : '';

                                                                echo '<option value="'.$dPeriode->id_periode.'" '.$selected.'>'.$dPeriode->tahun_periode.'</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                </div>

                                                <?php if($page != 'kab') { ?>
                                                    <div class="col-md-2">
                                                        <label>Jenis</label>
                                                        
                                                        <?php 
                                                            $opd = isset($_GET['tags']) && $_GET['tags'] == 'opd' ? 'selected' : '';
                                                            $uobk = isset($_GET['tags']) && $_GET['tags'] == 'uobk' ? 'selected' : '';
                                                        ?>

                                                        <select name="tag" class="form-control" id="tag">
                                                            <option value="opd" <?= $opd ?>>OPD</option>
                                                            <option value="uobk" <?= $uobk ?>>UOBK</option>
                                                        </select>
                                                    </div>
                                                <?php } ?>

                                                <div class="col-md-5">
                                                    <label><?php echo $label ?></label><br>
                                                    <select name="id_unit" id="id_unit" class="form-control select2" width="100%">
                                                        <option value="">- Semua <?php echo $label ?> -</option>
                                                        <?php
                                                        if(isset($unit)) {
                                                            foreach ($unit as $key) {
                                                                echo '<option value="' . $key->id_unit . '">' .  ($key->nama_unit?ucwords(strtolower($key->nama_unit)):$key->unit)  . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-3 filter-cettar" style="display:none">
                                                    <label>Predikat</label>
                                                    <div>
                                                        <select name="predikat" id="predikat" class="form-control" width="100%">
                                                            <?php
                                                            $kategori = array(
                                                                'SANGAT CETTAR' => 'SANGAT CETTAR','CETTAR'=>'CETTAR',
                                                                'CUKUP CETTAR' => 'CUKUP CETTAR',
                                                                'KURANG CETTAR' => 'KURANG CETTAR',
                                                                'TIDAK CETTAR' => 'TIDAK CETTAR'
                                                            );

                                                            echo '<option value="">- Semua Predikat -</option>';
                                                            foreach ($kategori as $key => $value){
                                                                $selected = '';
                                                                echo '<option value="'.$key.'" '. $selected.' >'. $value.'</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 filter-aspek" style="display:none">
                                                    <label>Aspek</label>
                                                    <div>

                                                        <select name="id_aspek" id="id_aspek" class="form-control" width="100%">
                                                            <?php
                                                            // echo '<option value="">- Semua Aspek -</option>';
                                                            if(isset($indikator)){
                                                                $aspek=array();
                                                                
                                                                foreach ($indikator as $key):
                                                                    $temp = array(
                                                                        "id_aspek" => $key->id_aspek,
                                                                        "aspek" => $key->aspek
                                                                    );
                                                                    if (!in_array($temp, $aspek)) array_push($aspek, $temp);
                                                                endforeach;

                                                                foreach($aspek as $row):
                                                                    if(isset($idaspek) && $idaspek == $row['id_aspek']) $selected = ' selected';
                                                                    else $selected='';
                                                                    echo '<option value="'.$row['id_aspek'].'" '. $selected.' >'. $row['aspek'] .'</option>';
                                                                endforeach;
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                    </form>
                                </blockquote>
                            </div>
                            <div class="col-md-12" style="margin-top: 30px;">
                                <div id="chart"></div>

                                <!-- <div class="table-responsive" id="div-rekap">
                                    <table class="table table-hover table-striped display" id="tableRekap">
                                        <thead>
                                        <tr>
                                            <th>Periode</th>
                                            <th><?php echo $label ?></th>
                                            <th>Nilai</th>
                                            <th>Hasil</th>
                                            <th>Predikat</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<!-- ***** Welcome Area End ***** -->

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

<!-- Global Init -->
<script src="<?php echo base_url("assets/landing/js/owl-carousel.js") ?>"></script>
<script src="<?php echo base_url("assets/landing/js/scrollreveal.min.js") ?>"></script>
<script src="<?php echo base_url("assets/landing/js/waypoints.min.js") ?>"></script>
<script src="<?php echo base_url("assets/landing/js/jquery.counterup.min.js") ?>"></script>
<script src="<?php echo base_url("assets/landing/js/imgfix.min.js") ?>"></script>
<script src="<?php echo base_url("assets/landing/js/custom.js") ?>"></script>

<script src="<?php echo base_url("assets/vendors/select2/select2.min.js") ?>"></script>

<script src="<?php echo base_url("assets/vendors/datatables/jquery.dataTables.min.js") ?>"></script>
<script src="<?php echo base_url("assets/vendors/datatables/dataTables.responsive.min.js") ?>"></script>
<script src="<?php echo base_url("assets/vendors/datatables/dataTables.bootstrap4.js") ?>"></script>
<script src="<?php echo base_url("assets/vendors/datatables/dataTables.rowGroup.min.js") ?>"></script>
<script src="<?php echo base_url("assets/vendors/highchart/highcharts.js") ?>"></script>
<script src="<?php echo base_url("assets/vendors/highchart/highcharts-3d.js") ?>"></script>

<?php
if(isset($param) && $param=='spirit'){
    ?>
    <script src="<?php echo base_url("assets/landing/js/detail.js") ?>"></script>
    <?php
}else{
    ?>
    <script src="<?php echo base_url("assets/landing/js/detail_aspek.js") ?>"></script>
    <?php
}
?>

</body>
</html>