<div class="content-wrapper">
    <div class="card" id="divDataEvaluasi">
        <div class="card-body" >
            <div class="row">
                <div class="col-md-8">
                    <h4 class="card-title">Rapor <?php echo $label ?></h4>
                </div>
                <div class="col-md-4">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb" style="text-align: right; border: 0px !important; margin-top: -10px;">
                            <li class="breadcrumb-item"><a href="#">Rapor <?php echo $label ?></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Data</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <input type="hidden" id="tmp-indikator" value="<?php echo (isset($id_indikator)?$id_indikator:'') ?>">
            <input type="hidden" id="tag" value="<?php echo (isset($tag) ? $tag : 'opd') ?>" readonly>
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
                                        foreach($periode as $key => $p ){
                                            $selected = ($key == (count($periode) - 1)) ? 'selected' : '';
                                            echo '<option value="'.$p->id_periode.'" '.$selected.'>'.$p->tahun_periode.'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
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
                            <div class="table-responsive" id="div-spirit" style="margin-top: 20px;">
                                <div style="text-align: center; padding-bottom: 10px; font-size: 10pt;">- Pilih Perangkat Daerah / Kab / Kota Terlebih Dahulu -</div>
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