<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Penilaian </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Penilaian <?php echo $label ?></a></li>
                <li class="breadcrumb-item active" aria-current="page">Data</li>
            </ol>
        </nav>
    </div>
    <div class="card" id="divDataEvaluasi">
        <div class="card-body" >
            <h4 class="card-title">Penilaian <?php echo $label ?></h4>
            <input type="hidden" id="tmp-indikator" value="<?php echo (isset($id_indikator)?$id_indikator:'') ?>">
            <input type="hidden" id="tag" value="<?php echo (isset($tag)?$tag:'opd') ?>">
            <div class="row">
                <div class="col-12">
                    <blockquote class="blockquote blockquote-primary">
                    <form id="frmsearch" class="forms-sample form-horizontal">
                        <div class="form-group"><label>Filter pencarian</label></div>
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label>Tahun</label>
                                    <select name="tahun" class="form-control">
                                        <?php
                                        $year = date('Y');
                                        $min = $year - 10;
                                        $max = $year;
                                        for( $i=$max; $i>=$min; $i-- ){
                                            echo '<option value="'.$i.'">'.$i.'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                    <?php
                                    if(isset($indikator)) {
                                        $aspek = array();
                                        foreach ($indikator as $key):
                                            $temp = array(
                                                "id_aspek" => $key->id_aspek,
                                                "aspek" => $key->aspek,
                                                'icon' => $key->icon
                                            );
                                            if (!in_array($temp, $aspek)) array_push($aspek, $temp);
                                        endforeach;
                                    }

                                            ?>


                        </div>
                        <div class="form-group row">
                            <div class="col-md-8">
                                <label><?php echo $label ?></label>
                                <select name="id_unit" class="form-control select2"  width="100%">
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
                            <div class="col-md-4">
                                <?php
                                if($_SESSION['user']->id_role==1 or ($_SESSION['user']->id_role==2 && $_SESSION['user']->id_unit==6))
                                {
                                    echo '<br><button type="button" id="sync-serapan" class="btn btn-danger">Sinkronisasi Serapan Anggaran</button>';
                                }
                                ?>
                            </div>
                        </div>
                    </form>
                    </blockquote>
                    <div class="row" id="divFormEvaluasi">
                        <div class="col-md-12 example-wrap">

                            <blockquote class="blockquote blockquote-primary">
                                <h4>Form Penilaian</h4>
                                <form id="formEvaluasi" enctype="multipart/form-data" method="post" class="forms-sample form-horizontal">
                                    <input type="hidden" name="id_evaluasi" id="id_evaluasi">
                                    <input type="hidden" name="id_unit" id="id_unit">
                                    <input type="hidden" name="tahun" id="tahun">
                                    <input type="hidden" name="id_role" id="id_role" value="<?php echo $_SESSION['user']->id_role ?>">
                                    <input type="hidden" name="id_opd" id="id_opd" value="<?php  echo $_SESSION['user']->id_unit ?>">

                                    <div class="form-group row">
                                        <div class="col" style="display: none">
                                            <label>Bulan <small>*mulai</small></label>
                                            <div class="col-md-12">
                                                <select name="bulan_mulai" class="form-control select2" id="bulan_mulai">
                                                    <?php
                                                    $namaBulan = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");

                                                    $noBulan = 1;
                                                    for($index=0; $index<12; $index++){
                                                        echo '<option value="'.$noBulan.'">'.$namaBulan[$index].'</option>';
                                                        $noBulan++;
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col" style="display:none">
                                            <label>Bulan <small>*selesai</small></label>
                                            <div class="col-md-12">
                                                <select name="bulan_selesai" class="form-control select2" id="bulan_selesai">
                                                    <?php
                                                    $namaBulan = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");

                                                    $noBulan = 1;
                                                    for($index=0; $index<12; $index++){
                                                        echo '<option value="'.$noBulan.'">'.$namaBulan[$index].'</option>';
                                                        $noBulan++;
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <span class="lbl-unit"></span>
                                        <table class="table table-hover table-responsive" width="100%">
                                            <tr>
                                                <th width="10%">Aspek</th>
                                                <th width="10%">Indikator</th>
                                                <th>Nilai Awal</th>
                                                <th width="15%">Nilai Konversi</th>
                                            </tr>
                                            <?php
                                            $aspek=array();
                                            foreach ($indikator as $key):
                                                if(isset($id_indikator) && $key->id_indikator==$id_indikator) {
                                                    $temp = array(
                                                        "id_aspek" => $key->id_aspek,
                                                        "aspek" => $key->aspek
                                                    );
                                                    if (!in_array($temp, $aspek)) array_push($aspek, $temp);
                                                }
                                                if(empty($id_indikator)){
                                                    $temp = array(
                                                        "id_aspek" => $key->id_aspek,
                                                        "aspek" => $key->aspek
                                                    );
                                                    if (!in_array($temp, $aspek)) array_push($aspek, $temp);
                                                }
                                            endforeach;

                                            $rowspan = array_count_values(array_column($indikator, 'id_aspek'));
                                            foreach($aspek as $row) {
                                                ?>
                                                <tr valign="top">
                                                <td rowspan="<?php echo $rowspan[$row['id_aspek']] ?>" valign="top" style="vertical-align : top!important;text-align:left;">
                                                    <b><?php echo strtoupper($row['aspek']); ?></b>
                                                </td>
                                                <?php
                                                $enable=false;
                                                foreach ($indikator as $key) {
                                                    if ($key->id_aspek == $row['id_aspek']) {
                                                        //if ($key->waktu_verifikasi) $enable=true;
                                                        if(!empty($_SESSION['user']->id_unit)) {
                                                            if (($key->id_opd == $_SESSION['user']->id_unit) && $_SESSION['user']->id_role != 1 && !empty($_SESSION['user']->id_unit)) $enable = true;
                                                            else $enable = false;
                                                        }else $enable = true;
                                                        //if($_SESSION['user']->id_role!=1 && !empty($_SESSION['user']->id_unit) && $key->id_opd!=$_SESSION['user']->id_unit) $enable=true;

                                                        if(isset($id_indikator) && $key->id_indikator==$id_indikator) {
                                                            ?>
                                                            <td valign="top">
                                                                <input type="hidden"
                                                                       name="periode<?php echo $key->id_indikator ?>"
                                                                       id="periode<?php echo $key->id_indikator ?>"
                                                                       value="<?php echo $key->periode ?>">
                                                                <input type="hidden"
                                                                       name="bobot<?php echo $key->id_indikator ?>"
                                                                       id="bobot<?php echo $key->id_indikator ?>"
                                                                       value="<?php echo number_format($key->bobot / 100, 2) ?>">
                                                                <input type="hidden"
                                                                       name="nilai_maks<?php echo $key->id_indikator ?>"
                                                                       id="nilai_maks<?php echo $key->id_indikator ?>"
                                                                       value="<?php echo $key->nilai_maks ?>">
                                                                <input type="hidden"
                                                                       name="is_verify<?php echo $key->id_indikator ?>"
                                                                       id="is_verify<?php echo $key->id_indikator ?>"
                                                                       value="<?php echo $key->is_verify ?>">
                                                                <input type="hidden"
                                                                       name="user_verifikasi<?php echo $key->id_indikator ?>"
                                                                       id="user_verifikasi<?php echo $key->id_indikator ?>"
                                                                       value="<?php echo $key->user_verifikasi ?>">
                                                                <input type="hidden"
                                                                       name="catatan_verifikasi<?php echo $key->id_indikator ?>"
                                                                       id="catatan_verifikasi<?php echo $key->id_indikator ?>"
                                                                       value="<?php echo $key->catatan_verifikasi ?>">
                                                                <input type="hidden"
                                                                       name="waktu_verifikasi<?php echo $key->id_indikator ?>"
                                                                       id="waktu_verifikasi<?php echo $key->id_indikator ?>"
                                                                       value="<?php echo $key->waktu_verifikasi ?>">
                                                                <input type="hidden" name="id_indikator[]"
                                                                       id="<?php echo $key->id_indikator ?>"
                                                                       value="<?php echo $key->id_indikator ?>">
                                                                <?php echo $key->indikator ?><br><span class="badge badge-primary"><?php echo number_format($key->bobot / 100, 2) ?></span>
                                                            </td>
                                                            <td><input type="text" step="any"
                                                                       name="nilai_awal<?php echo $key->id_indikator ?>"
                                                                       id="nilai_awal<?php echo $key->id_indikator ?>"
                                                                       class="form-control" <?php echo ($enable?'':'readonly') ?>></td>
                                                            <td><input type="number" step="any"
                                                                       name="nilai_konversi<?php echo $key->id_indikator ?>"
                                                                       id="nilai_konversi<?php echo $key->id_indikator ?>"
                                                                       class="form-control" <?php echo ($enable?'':'readonly') ?>></td>

                                                            </tr>
                                                            <?php
                                                            break;
                                                        }

                                                        if(empty($id_indikator)){
                                                            ?>
                                                            <td valign="top">

                                                                <input type="hidden"
                                                                       name="periode<?php echo $key->id_indikator ?>"
                                                                       id="periode<?php echo $key->id_indikator ?>"
                                                                       value="<?php echo $key->periode ?>">
                                                                <input type="hidden"
                                                                       name="bobot<?php echo $key->id_indikator ?>"
                                                                       id="bobot<?php echo $key->id_indikator ?>"
                                                                       value="<?php echo number_format($key->bobot / 100, 2) ?>">
                                                                <input type="hidden"
                                                                       name="nilai_maks<?php echo $key->id_indikator ?>"
                                                                       id="nilai_maks<?php echo $key->id_indikator ?>"
                                                                       value="<?php echo $key->nilai_maks ?>">
                                                                <input type="hidden"
                                                                       name="is_verify<?php echo $key->id_indikator ?>"
                                                                       id="is_verify<?php echo $key->id_indikator ?>"
                                                                       value="<?php echo $key->is_verify ?>">
                                                                <input type="hidden"
                                                                       name="user_verifikasi<?php echo $key->id_indikator ?>"
                                                                       id="user_verifikasi<?php echo $key->id_indikator ?>"
                                                                       value="<?php echo $key->user_verifikasi ?>">
                                                                <input type="hidden"
                                                                       name="catatan_verifikasi<?php echo $key->id_indikator ?>"
                                                                       id="catatan_verifikasi<?php echo $key->id_indikator ?>"
                                                                       value="<?php echo $key->catatan_verifikasi ?>">
                                                                <input type="hidden"
                                                                       name="waktu_verifikasi<?php echo $key->id_indikator ?>"
                                                                       id="waktu_verifikasi<?php echo $key->id_indikator ?>"
                                                                       value="<?php echo $key->waktu_verifikasi ?>">
                                                                <input type="hidden" name="id_indikator[]"
                                                                       id="<?php echo $key->id_indikator ?>"
                                                                       value="<?php echo $key->id_indikator ?>">
                                                                <?php echo $key->indikator ?><br><span class="badge badge-primary"><?php echo number_format($key->bobot / 100, 2) ?></span>
                                                            </td>
                                                            <td><input type="text"
                                                                       name="nilai_awal<?php echo $key->id_indikator ?>"
                                                                       id="nilai_awal<?php echo $key->id_indikator ?>"
                                                                       class="form-control" <?php echo ($enable?'':'readonly') ?>></td>
                                                            <td><input type="number" step="any"
                                                                       name="nilai_konversi<?php echo $key->id_indikator ?>"
                                                                       id="nilai_konversi<?php echo $key->id_indikator ?>"
                                                                       class="form-control" <?php echo ($enable?'':'readonly') ?>></td>

                                                            </tr>
                                                            <?php
                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                        </table>
                                    </div>
                                    <div class="form-group"><?php
                                    if ($_SESSION['user']->id_role==1 or ($_SESSION['user']->id_role==2 && !empty($_SESSION['user']->id_unit))){
                                        echo '<button type="submit" class="btn btn-primary">Simpan</button>';
                                    }
                                    ?>
                                        <button type="button" class="btn btn-default btn-cancel">Cancel</button>
                                    </div>
                                </form>
                            </blockquote>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--<div class="card" >
        <div class="card-body" >
            <h4 class="card-title">Form Penilaian</h4>

        </div>
    </div>-->
</div>