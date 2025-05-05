<?php
/**
 * Created by PhpStorm.
 * User: tusti
 * Date: 9/28/2018
 * Time: 3:35 PM
 */
?>
<div class="col-md-12">
    <form id="formunit" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12">
                <h6 class="card-subtitle">Silakan lengkapi informasi unit dibawah ini.</h6>
                <br>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Kategori</label>
                    <div class="controls">
                        <input type="hidden" name="tag" id="tag" value="<?php echo isset($tag)?$tag:'opd'; ?>">
                        <select class="form-control" name="kategori_unit" id="kategori_unit">
                            <?php
                            $kategori = array(
                                'opd' => 'PD',
                                'kab' => 'Kabupaten/Kota',
                                'uobk' => 'UOBK'
                            );
                            foreach ($kategori as $key => $value){
                                $selected = (isset($tag)&&$tag==$key?'selected':'');
                                echo '<option value="'.$key.'" '. $selected.' >'. $value.'</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label>Kode <small><em>Note: Isikan kode unit</em></small></label>
                    <div class="controls">
                        <input type="text" class="form-control" id="kode_unit" name="kode_unit">
                    </div>
                </div>
                <div class="form-group">
                    <label>Nama <small><em>Note: Isikan nama unit</em></small></label>
                    <div class="controls">
                        <input type="hidden" name="id_unit" id="id_unit">
                        <input type="hidden" name="foto" id="foto">
                        <input type="text" class="form-control" id="unit" name="unit" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label>Email <small><em>Note: Isikan email unit</em></small></label>
                        <div class="controls">
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label>Website <small><em>Note: Isikan website unit</em></small></label>
                        <div class="controls">
                            <input type="text" class="form-control" id="website" name="website">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label>Telp <small><em>Note: Isikan telp unit</em></small></label>
                        <div class="controls">
                            <input type="text" class="form-control" id="telp" name="telp">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label>Fax <small><em>Note: Isikan fax unit</em></small></label>
                        <div class="controls">
                            <input type="text" class="form-control" id="fax" name="fax">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <label>Nama KD <small><em>Note: Isikan nama KD</em></small></label>
                        <div class="controls">
                            <input type="text" class="form-control" id="pejabat" name="pejabat">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label>Jumlah PD <small><em>Note: Isikan jumlah PD</em></small></label>
                        <div class="controls">
                            <input type="number" class="form-control" id="jumlah_pd" name="jumlah_pd">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label>Jumlah APBD <small><em>Note: Isikan jumlah APBD</em></small></label>
                        <div class="controls">
                            <input type="number" class="form-control" id="jumlah_apbd" name="jumlah_apbd">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Alamat <small><em>Note: Isikan alamat unit</em></small></label>
                    <div class="controls">
                        <textarea name="alamat" class="form-control"></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-4">
                        <label>Facebook <small><em>Note: Isikan nama akun FB</em></small></label>
                        <div class="controls">
                            <input type="text" class="form-control" id="medsos_fb" name="medsos_fb">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label>Instagram <small><em>Note: Isikan nama akun IG</em></small></label>
                        <div class="controls">
                            <input type="text" class="form-control" id="medsos_ig" name="medsos_ig">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label>Twitter <small><em>Note: Isikan nama akun Twitter</em></small></label>
                        <div class="controls">
                            <input type="text" class="form-control" id="medsos_twitter" name="medsos_twitter">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Jumlah Bidang <small><em>Note: Isikan bidang</em></small></label>
                    <div class="controls">
                        <textarea name="jumlah_bidang" class="form-control"></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <label>Jumlah Anggaran <small><em>Note: Isikan jumlah anggaran</em></small></label>
                    <div class="controls">
                        <input type="text" class="form-control" id="jumlah_anggaran" name="jumlah_anggaran">
                    </div>
                </div>
                <div class="col-md-6">
                    <label>Jumlah SDM <small><em>Note: Isikan jumlah sdm</em></small></label>
                    <div class="controls">
                        <input type="text" class="form-control" id="jumlah_sdm" name="jumlah_sdm">
                    </div>
                </div>
                <div class="form-group">
                    <label>Jumlah UPT <small><em>Note: Isikan jumlah UPT</em></small></label>
                    <div class="controls">
                        <textarea name="jumlah_upt" class="form-control"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Foto pejabat <small><em>Note: Format foto hanya boleh format Jpeg</em></small></label>
                        <div class="controls">
                            <input type="file" id="file-image" name="file" class="form-control" accept="image/jpeg" />
                        </div>
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
                    <a href="<?php echo base_url('module/master/unit') ?>" class="btn btn-white btn-cons btn-cancel">Cancel</a>
                    <button type="submit" class="btn btn-primary btn-cons btn-biodata">Simpan</button>
                </div>

            </div>

        </div>
    </form>
</div>
<div id="tmp-unit" style="display: none"></div>
