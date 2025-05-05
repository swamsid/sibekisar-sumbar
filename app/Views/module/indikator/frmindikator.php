<?php
/**
 * Created by PhpStorm.
 * User: tusti
 * Date: 9/28/2018
 * Time: 3:35 PM
 */
?>
<div class="col-md-12">
    <form id="formindikator" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12">
                <h6 class="card-subtitle">Silakan lengkapi informasi aspek indikator dibawah ini.</h6>
                <br>
            </div>
            <div class="col-md-12">
                <div class="form-group" style="margin-bottom: 50px;">
                    <label>Spirit</label>
                    <div class="controls">
                        <input type="hidden" name="tag" id="tag" value="<?php echo isset($tag)?$tag:'opd'; ?>">
                        <input type="hidden" id="periode-indikator-input" name="periode-indikator" readonly>
                        <input type="hidden" id="bobot-aspek" name="nilai_maks" readonly>

                        <select class="form-control" name="id_aspek" id="id_aspek">
                            
                        </select>
                    </div>
                </div>

                <!-- <div class="form-group">
                    <label>Bobot Spirit<small><em>Note: Isikan bobot spirit</em></small></label>
                    <div class="controls">
                        <input type="number" class="form-control" id="nilai_maks" name="nilai_maks" required>
                    </div>
                </div> -->

                <div style="border-top: 1px solid #ddd;">&nbsp;</div>

                <div class="form-group" style="margin-top: 15px;">
                    <label>Tim Penilai</label>
                    <div class="controls">
                        <input type="hidden" name="opd_pengampu" id="opd_pengampu">
                        <select name="id_opd" id="id_opd" class="form-control select2"  style="width:100%">
                            <option value="">- Pilih Tim Penilai -</option>
                            <?php
                            if(isset($unit)) {
                                foreach ($unit as $key) {
                                    echo '<option value="' . $key->id_unit . '">' . $key->unit . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Keterangan PD Pengampu <small></small></label>
                    <div class="controls">
                        <input type="text" class="form-control" id="keterangan" name="keterangan">
                    </div>
                </div>

                <div class="form-group">
                    <label>Nama <small><em>Note: Isikan nama indikator</em></small></label>
                    <div class="controls">
                        <input type="hidden" name="id_indikator" id="id_indikator">
                        <input type="text" class="form-control" id="indikator" name="indikator" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Bobot <small><em>Note: Isikan bobot indikator</em></small></label>
                    <div class="controls">
                        <input type="number" class="form-control" id="bobot" name="bobot" step="any" required>
                    </div>
                </div>

                <div class="form-group">

                    <div class="col-md-12">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="is_aktif" id="is_aktif" value="1">
                            <label class="custom-control-label" for="is_aktif">Aktif?</label>
                        </div>

                    </div>

                </div>

                <div class="pull-right">
                    <a href="#" class="btn btn-white btn-cons btn-cancel" style="padding: 8px 15px; font-size: 8pt;">Cancel</a>
                    <button type="submit" class="btn btn-primary btn-cons btn-biodata" style="padding: 8px 15px; font-size: 8pt;" id="btn-submit">
                        Simpan Indikator
                    </button>
                </div>

            </div>

        </div>
    </form>
</div>
<div id="tmp-indikator" style="display: none"></div>
