<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Verifikasi </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Verifikasi Penilaian Perangkat Daerah</a></li>
                <li class="breadcrumb-item active" aria-current="page">Data</li>
            </ol>
        </nav>
    </div>
    <div class="card" id="divDataEvaluasi">
        <div class="card-body" >
            <h4 class="card-title">Verifikasi Penilaian <?php echo $label ?></h4>
            <input type="hidden" id="tmp-indikator" value="<?php echo (isset($id_indikator)?$id_indikator:'') ?>">
            <div class="row">
                <div class="col-12">
                    <blockquote class="blockquote blockquote-primary">
                        <form id="frmsearch" class="forms-sample form-horizontal">
                            <div class="form-group"><label>Filter pencarian</label></div>
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label>Tahun</label>
                                    <input type="hidden" id="tag" value="<?php echo (isset($tag)?$tag:'opd') ?>">
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
                                <div class="col col-md-4">
                                    <label>Aspek Penilaian</label>
                                    <div>
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
                                        <select name="id_aspek" class="form-control select2">
                                            <option value=""> - Semua Aspek -</option>
                                            <?php
                                            if(isset($aspek)) {
                                                foreach ($aspek as $row):
                                                    echo '<option value="'.$row['id_aspek'].'">'.$row['aspek'].'</option>';
                                                endforeach;
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col col-md-4">
                                    <label>Indikator</label>
                                    <div>
                                        <select name="id_indikator" class="form-control select2" id="layout-select">
                                            <option value=""> - Semua Indikator -</option>
                                            <?php
                                            if(isset($indikator)) {
                                                foreach ($indikator as $row):
                                                    echo '<option data-aspek="'.$row->id_aspek.'" value="'.$row->id_indikator.'" ';
                                                    if(isset($id_indikator) && $row->id_indikator==$id_indikator) echo ' selected';
                                                    echo ' >'.$row->indikator.'</option>';
                                                endforeach;
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group row">
                                <div class="col-md-10">
                                    <label><?php echo $label ?></label>
                                    <?php
                                    if($_SESSION['user']->id_role==1) {
                                        ?>
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
                                    <?php
                                    }
                                    else {
                                       ?>
                                        <select name="id_unit" class="form-control"  width="100%">
                                            <?php
                                            if(isset($unit)) {
                                                foreach ($unit as $key) {
                                                    echo '<option value="' . $key->id_unit . '">' . $key->unit . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                        <?php
                                    }
                                    ?>

                                </div>
                            </div>
                        </form>
                    </blockquote>
                    <div class="table-responsive">
                        <table class="table table-hover table-responsive display" id="tableEvaluasi">
                            <thead>
                            <tr>
                                <th width="10%"><?php echo $label ?></th>
                                <th width="2%">Periode</th>
                                <th width="10%">Aspek</th>
                                <th width="10%">Indikator</th>
                                <th width="5%">Nilai Awal</th>
                                <th width="5%">Nilai Konversi</th>
                                <th width="5%">Nilai Akhir</th>
                                <th width="5%">Status</th>
                                <th width="5%">Last update</th>
                                <th width="1%">Act</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card" id="divFormEvaluasi">
        <div class="card-body" >
            <h4 class="card-title">Form Penilaian</h4>
            <div class="row">
                <div class="col-md-12 example-wrap">
                    <!--<h4 class="example-title">Form Evaluasi SKPD</h4>-->
                    <div class="example">
                        <form id="formEvaluasi" enctype="multipart/form-data" method="post" class="forms-sample form-horizontal">
                            <input type="hidden" name="id_evaluasi">
                            <div class="form-group row unittmp">

                                <label><?php echo $label ?> akan dinilai</label>
                                <div class="col-md-12">
                                    <select name="id_unit" id="id_unit" class="form-control select2"  width="100%" required>
                                        <?php
                                        if(isset($unit)) {
                                            foreach ($unit as $key) {
                                                if ($key->id_parent != '0' && substr($key->id_parent, 0, 4) == 'F11.') {
                                                    echo '<option value="' . $key->id_unit . '">Wilayah ' . $key->wilayah . '</option>';
                                                } else {
                                                    echo '<option value="' . $key->id_unit . '">' . $key->unit . '</option>';
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">

                                <div class="col">
                                    <label>Tahun</label>
                                    <select name="tahun" class="form-control" disabled>
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
                                <div class="col">
                                    <label>Bulan <small>*mulai</small></label>
                                    <div class="col-md-12">
                                        <select name="bulan_mulai" class="form-control select2" disabled>
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
                                <div class="col">
                                    <label>Bulan <small>*selesai</small></label>
                                    <div class="col-md-12">
                                        <select name="bulan_selesai" class="form-control select2" disabled>
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
                                        <th width="15%">Verify?</th>
                                        <th>Catatan</th>
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
                                        $verify=false;
                                        foreach ($indikator as $key) {
                                            if ($key->id_aspek == $row['id_aspek']) {
                                                    ?>
                                                    <td valign="top">
                                                        <input type="hidden"
                                                               name="id_evaluasi<?php echo $key->id_indikator ?>"
                                                               id="id_evaluasi<?php echo $key->id_indikator ?>"
                                                               value="<?php //echo $key->periode ?>">

                                                        <input type="hidden"
                                                               name="periode<?php echo $key->id_indikator ?>"
                                                               id="periode<?php echo $key->id_indikator ?>"
                                                               value="<?php //echo $key->periode ?>">
                                                        <input type="hidden"
                                                               name="bobot<?php echo $key->id_indikator ?>"
                                                               id="bobot<?php echo $key->id_indikator ?>"
                                                               value="<?php echo number_format($key->bobot / 100, 2) ?>">
                                                        <input type="hidden"
                                                               name="nilai_maks<?php echo $key->id_indikator ?>"
                                                               id="nilai_maks<?php echo $key->id_indikator ?>"
                                                               value="<?php echo $key->nilai_maks ?>">
                                                        <input type="hidden"
                                                               name="user_verifikasi<?php echo $key->id_indikator ?>"
                                                               id="user_verifikasi<?php echo $key->id_indikator ?>"
                                                               value="<?php //echo $key->user_verifikasi ?>">

                                                        <input type="hidden"
                                                               name="waktu_verifikasi<?php echo $key->id_indikator ?>"
                                                               id="waktu_verifikasi<?php echo $key->id_indikator ?>"
                                                               value="<?php //echo $key->waktu_verifikasi ?>">

                                                        <input type="hidden" name="id_indikator[]"
                                                               id="<?php echo $key->id_indikator ?>"
                                                               value="<?php echo $key->id_indikator ?>">
                                                        <?php echo $key->indikator ?><br><span class="badge badge-primary"><?php echo number_format($key->bobot / 100, 2) ?></span>
                                                    </td>
                                                    <td><input type="text" step="any"
                                                               name="nilai_awal<?php echo $key->id_indikator ?>"
                                                               id="nilai_awal<?php echo $key->id_indikator ?>"
                                                               class="form-control" disabled></td>
                                                    <td><input type="number" step="any"
                                                               name="nilai_konversi<?php echo $key->id_indikator ?>"
                                                               id="nilai_konversi<?php echo $key->id_indikator ?>"
                                                               class="form-control" disabled></td>
                                                    <td><input type="checkbox" name="is_verify<?php echo $key->id_indikator ?>"
                                                                  id="is_verify<?php echo $key->id_indikator ?>"
                                                                  class="checkbox" value="1"> Ya</td>
                                                    <td><textarea name="catatan_verifikasi<?php echo $key->id_indikator ?>"
                                                                      id="catatan_verifikasi<?php echo $key->id_indikator ?>"
                                                                      class="form-control"></textarea></td>
                                                    </tr>
                                                    <?php
                                            }
                                        }
                                    }
                                    ?>
                                </table>
                            </div>

                            <!--<div class="form-group">
                                <label class="form-label">Dokumen pendukung</label>
                                <input id="dokumen" name="dokumen" type="file" class="form-control">
                                <small><i class="fa fa-info-circle" style="color:#004678;"></i> &nbsp;
                                    Tipe File atau Ekstensi Untuk dokumen bukti pendukung: pdf, jpeg atau jpg dan Ukuran File Maksimal 5Mb
                                </small>
                            </div>-->

                            <div class="form-group"><?php
                                if ($_SESSION['user']->id_role==1 or ($_SESSION['user']->id_role==2 && !empty($_SESSION['user']->id_unit))){
                                    echo '<button type="submit" class="btn btn-primary">Simpan</button>';
                                }
                                ?>
                                <button type="button" class="btn btn-default btn-cancel">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>