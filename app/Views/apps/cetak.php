<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Rapor </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Rapor <?php echo $label ?></a></li>
                <li class="breadcrumb-item active" aria-current="page">Data</li>
            </ol>
        </nav>
    </div>
    <div class="card" id="divDataEvaluasi">
        <div class="card-body" >
            <h4 class="card-title">Rapor <?php echo $label ?></h4>
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
                                    <select name="tahun" class="form-control" id="tahun">
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
                            </div>
                            <div class="form-group row">
                                <div class="col-md-10">
                                    <label><?php echo $label ?></label>
                                    <select name="id_unit" class="form-control select2"  width="100%" id="id_unit">
                                        <option value="">- Pilih <?php echo $label ?> -</option>
                                        <?php
                                        if(isset($unit)) {
                                            foreach ($unit as $key) {
                                                echo '<option value="' . $key->id_unit . '">' .  ($key->nama_unit?ucwords(strtolower($key->nama_unit)):$key->unit)  . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </blockquote>
                    <div class="row" id="divFormEvaluasi">
                        <div class="col-md-12">
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
                            <div class="table-responsive" id="div-spirits">
                                <table class="table table-hover table-condensed" width="100%" id="tb-raport">
                                    <thead>
                                    <tr>
                                        <th>Spirit Budaya Kerja</th>
                                        <th>Bobot</th>
                                        <th>Nilai</th>
                                        <th>Indikator Penilaian</th>
                                        <th>Bobot</th>
                                        <th>Nilai</th>
                                        <th>PD Pengampu</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $aspek=array();
                                    foreach ($indikator as $key):
                                        if(isset($id_indikator) && $key->id_indikator==$id_indikator) {
                                            $temp = array(
                                                "id_aspek" => $key->id_aspek,
                                                "nilai_maks" => $key->nilai_maks,
                                                "aspek" => $key->aspek
                                            );
                                            if (!in_array($temp, $aspek)) array_push($aspek, $temp);
                                        }
                                        if(empty($id_indikator)){
                                            $temp = array(
                                                "id_aspek" => $key->id_aspek,
                                                "nilai_maks" => $key->nilai_maks,
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
                                        <td rowspan="<?php echo $rowspan[$row['id_aspek']] ?>" valign="top" style="vertical-align : top!important;text-align:left;">
                                            <?php echo $row['nilai_maks']; ?>
                                        </td>
                                        <td rowspan="<?php echo $rowspan[$row['id_aspek']] ?>" valign="top" style="vertical-align : top!important;text-align:left;">
                                            <span class="lbl-nilai_spirit<?php echo $row['id_aspek']; ?>">
                                        </td>
                                        <?php
                                        foreach ($indikator as $key) {
                                            if ($key->id_aspek == $row['id_aspek']) {

                                                if(empty($id_indikator)){
                                                    ?>
                                                    <td valign="top">
                                                        <?php echo $key->indikator ?>
                                                    </td>
                                                    <td valign="top">
                                                        <?php echo $key->bobot ?>
                                                    </td>
                                                    <td><span class="lbl-nilai_aspek<?php echo $key->id_indikator ?>"></span></td>
                                                    <td valign="top">
                                                        <?php echo $key->opd_pengampu ?>
                                                    </td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                        }
                                    }
                                    ?></tbody>
                                    <tfoot><tr><th colspan="2">Skor Total</th>
                                        <th colspan="5"><span class="lbl-skor_total"></span></th> </tr>
                                    <tr><th colspan="2">Nilai</th><th colspan="5"><span class="lbl-nilai_huruf"></span></th></tr>
                                    <tr><th colspan="2">Hasil Penilaian</th><th colspan="5"><span class="lbl-predikat"></span></th></tr>
                                    </tfoot>
                                </table>

                            </div>
                            <hr>
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