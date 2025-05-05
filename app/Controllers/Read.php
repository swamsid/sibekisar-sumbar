<?php

namespace App\Controllers;
use App\Controllers\Module\Master;
use App\Models\EvaluasiModel;
use App\Models\MasterModel;
use Mpdf\Mpdf;
use Dompdf\Dompdf;
use App\Libraries\PDF;

class Read extends BaseController
{
    public function __construct()
    {
       // $this->evaluasimodel = new EvaluasiModel();
        $this->mastermodel = new MasterModel();
        $this->evaluasimodel = new EvaluasiModel();
    }

    function tentang(){
        return view('tentang');
    }

    function opd($param=null){ 

        $data['kategori_unit'] = 'opd';
        $data['label']         = 'Perangkat Daerah/UOBK';
        $data['tag']           = 'opd';
        $data['dataPeriode']   = $this->mastermodel->getPeriode();

       if(isset($param) &&!empty($param)) {
           $data['id_unit_hash'] = $param;
           $data['unit']         = $this->mastermodel->getMUnit($data);
;
           return view('opd_detail', $data);
       }else {
           $data['unit'] = $this->mastermodel->findMUnit($data);
           
           return view('opd', $data);
       }
    }

    function cetakLHE($param=null){ 

        $data['id_unit']    = $_POST['id_unit'];
        $data['tahun']      = $_POST['tahun'];
        $data['tag']        = $_POST['tag'];

        $id     = $_POST['id_unit'];
        $tahun  = $_POST['tahun'];
        $tag    = $_POST['tag'];
        
        $dataId = $this->mastermodel->cekKodeAkses([ 'id_unit' => $id ]);

        if(!$dataId || $dataId->kode_akses != $_POST['kode-akses']){
            $html = '
                <table style="width: 100%;">
                    <tr><td></td></tr>
                    <tr>
                        <td style="text-align: center; padding: 200px;">
                            Kode akses yang anda masukkan salah. <br> Data LHE gagal diunduh
                        </td>
                    </tr>
                </table>
            ';
        }else{
            $dataTahunTable = $this->mastermodel->findPeriode([ 'id_periode' => $tahun ]);

            $indikator = $this->evaluasimodel->findDetailNilaiBaru($data);
            $unitGet   = $this->mastermodel->findMUnit([ 'id_unit' => $data['id_unit'] ]);

            $html = '';
            $aspek = array();
            $unit = array();

            foreach ($indikator as $key):
                $temp = array(
                    "id_aspek" => $key->id_aspek,
                    "nilai_maks" => $key->bobot,
                    "total_nilai" => $key->total_nilai,
                    "aspek" => $key->aspek
                );
                if (!in_array($temp, $aspek)) array_push($aspek, $temp);

                $tempunit = array(
                    "unit" => $key->unit,
                    "skor_total" => $key->nilai,
                    "nilai_huruf" => $key->nilai_huruf,
                    "predikat" => $key->predikat
                );
                if (!in_array($tempunit, $unit)) array_push($unit, $tempunit);
            endforeach;

            $rowspan = array_count_values(array_column($indikator, 'id_aspek'));
            
            foreach ($unit as $runit) {
                $html .= '
                    <table width="100%" style="border-collapse: collapse;">
                        <tbody>
                            <tr>
                                <td style="height: 20pt;"></td>
                                <td rowspan="3" align="right">
                                    <table><tr><td style="height: 40pt;"></td></tr></table>
                                    <span style="font-weight: bold; font-size: 14pt;">sibekisar.jatimprov.go.id &nbsp;&nbsp;&nbsp;</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span style="font-weight: bold; font-size: 24pt;">Raport Budaya Kerja CETTAR</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span style="line-height: 46pt; font-size: 14pt;">'.$unitGet[0]->unit.'</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span style="font-size: 12pt; font-weight: normal; color: #555;">Tahun ' . $dataTahunTable->tahun_periode.'</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table>
                        <tr><td style="height: 20pt;">&nbsp;</td></tr>
                    </table>
                    
                    <table cellpadding="5" width="100%" class="table"  style="border: 1px solid #000; margin-top: 5px; font-size: 12pt;">
                        <thead>
                            <tr>
                                <th width="10%" style="background-color: #eee; font-weight: bold; text-align: center; border: 1px solid #000;" rowspan="2">
                                    Spirit Budaya Kerja
                                </th>
                                <th width="5%" style="background-color: #eee; font-weight: bold; text-align: center; border: 1px solid #000;" rowspan="2">Bobot</th>
                                <th width="5%" style="background-color: #eee; font-weight: bold; text-align: center; border: 1px solid #000;" rowspan="2">Total Nilai</th>
                                <th width="9%" style="background-color: #eee; font-weight: bold; text-align: center; border: 1px solid #000;" rowspan="2">Indikator Penilaian</th>
                                <th width="5%" style="background-color: #eee; font-weight: bold; text-align: center; border: 1px solid #000;" rowspan="2">Bobot</th>

                                <th width="16%" style="background-color: #eee; font-weight: bold; text-align: center; border: 1px solid #000;" colspan="3">Nilai Indikator</th>
                                
                                <th width="9%" style="background-color: #eee; font-weight: bold; text-align: center; border: 1px solid #000;" rowspan="2">Pengampu</th>
                                <th width="20%" style="background-color: #eee; font-weight: bold; text-align: center; border: 1px solid #000;" rowspan="2">Catatan</th>
                                <th width="20%" style="background-color: #eee; font-weight: bold; text-align: center; border: 1px solid #000;" rowspan="2">Rekomendasi</th>
                            </tr>

                            <tr>
                                <th width="5%" style="background-color: #eee; font-weight: bold; text-align: center; border: 1px solid #000;">Awal</th>
                                <th width="6%" style="background-color: #eee; font-weight: bold; text-align: center; border: 1px solid #000;">Konversi</th>                                        
                                <th width="5%" style="background-color: #eee; font-weight: bold; text-align: center; border: 1px solid #000;">Akhir</th>
                            </tr>
                        </thead>

                        <tbody>';

                foreach ($aspek as $row) {
                    $i = 0;
                    $html .= '
                            <tr>
                                <td width="10%" rowspan="'. ($rowspan[$row['id_aspek']] + 0) .'" style="border: 1px solid #000;">'.strtoupper($row['aspek']).'</td>
                                <td width="5%" rowspan="'. ($rowspan[$row['id_aspek']] + 0) .'" style="text-align: center; border: 1px solid #000;">'.$row['nilai_maks'].'</td>
                                <td width="5%" rowspan="'. ($rowspan[$row['id_aspek']] + 0) .'" style="text-align:center; border: 1px solid #000;">'.$this->is_decimal($row['total_nilai']).'</td>';

                    foreach ($indikator as $key) {
                        if ($key->id_aspek == $row['id_aspek']) {
                            $i++;
                            $print = (!$key->keterangan) ? $key->opd_pengampu : $key->keterangan;
                            
                            if ($i == 1) $html .= " ";
                            else $html .= "<tr valign='top'>";

                            $printCatatan = ($key->catatan_indikator) ? str_replace('14px;', '12px;', htmlentities($key->catatan_indikator)) : '';
                            $printRekomendasi = ($key->rekomendasi_indikator) ? str_replace('14px;', '12px;', htmlentities($key->rekomendasi_indikator)) : '';
                            
                            $html .= '
                                <td width="9%" style="height: 20px; border: 1px solid #000;">'.$key->indikator.'</td>
                                <td width="5%" align="center" style="height: 40px; border: 1px solid #000;">'.$this->is_decimal($key->bobot_aspek).'</td>
                                <td width="5%" align="center" style="height: 40px; border: 1px solid #000;"><b>
                                '.$this->is_decimal((float)str_replace(',', '.', $key->nilai_awal)).'
                                </b></td>
                                <td width="6%" align="center" style="height: 40px; border: 1px solid #000;"><b>'.$this->is_decimal($key->nilai_konversi).'</b></td>
                                <td width="5%" align="center" style="height: 40px; border: 1px solid #000;"><b>'.$this->is_decimal($key->nilai_aspek).'</b></td>
                                <td width="9%" style="height: 40px; border: 1px solid #000;">'.$print.'</td>
                                <td width="20%" class="listed" style="height: 40px; border: 1px solid #000;">'.strip_tags($key->catatan_indikator).'</td>
                                <td width="20%" style="height: 40px; border: 1px solid #000;">'.strip_tags($key->rekomendasi_indikator).'</td>
                            </tr>';
                        }
                    }
                }

                // return json_encode($runit);
            
                $html .= '
                            </tbody>
                            <tfoot>
                                <tr style="font-size: 14pt; font-weight: bold;">
                                    <th colspan="2" style="border: 1px solid #000;">Skor Total</th>
                                    <th colspan="9" style="border: 1px solid #000;">' . $runit['skor_total'] . '</th>
                                </tr>
                                <tr style="font-size: 14pt; font-weight: bold;">
                                    <th colspan="2" style="border: 1px solid #000;">Nilai</th>
                                    <th colspan="9" style="border: 1px solid #000;">' . $runit['nilai_huruf'] . '</th>
                                </tr>
                                <tr style="font-size: 14pt; font-weight: bold;">
                                    <th colspan="2" style="border: 1px solid #000;">Predikat</th>
                                    <th colspan="9" style="border: 1px solid #000;">' . $runit['predikat'] . '</th>
                                </tr>
                            </tfoot>
                        </table>';
            }
        }

        $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setOpenCell(false);
        $pdf->AddPage('L',"A3");
        $pdf->setListIndentWidth(8);

        $pdf->setHtmlVSpace(array(
            'li' => array(
                'h' => 1, // margin in mm
            ) 
        ));

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('Raport_sibekisar_'.$tahun.'.pdf', 'I');

        exit(0);
    }

    function uobk($param=null){ 

        $data['kategori_unit'] = 'uobk';
        $data['label']         = 'Perangkat Daerah/UOBK';
        $data['tag']           = 'uobk';
        $data['dataPeriode']   = $this->mastermodel->getPeriode();

       if(isset($param) &&!empty($param)) {
           $data['id_unit_hash'] = $param;
           $data['unit']         = $this->mastermodel->getMUnit($data);
;
           return view('opd_detail', $data);
       }else {
           $data['unit'] = $this->mastermodel->findMUnit($data);
           
           return view('opd', $data);
       }
    }

    function kab($param=null){
        $data['kategori_unit']  ='kab';
        $data['label']          ='Kabupaten/Kota';
        $data['tag']            = 'kab';
        $data['dataPeriode']    = $this->mastermodel->getPeriode();

        if(isset($param) &&!empty($param)) {
            $data['id_unit_hash'] = $param;
            $data['unit'] = $this->mastermodel->getMUnit($data);
            return view('opd_detail', $data);
        }else {
            $data['unit'] = $this->mastermodel->findMUnit($data);
            return view('opd', $data);
        }
    }

    function detail($params=null, $tag=null){

        // return json_encode($params);
        
        $data['param']          = empty($params) ? 'spirit' : $params;
        
        $param['periode']       = ($_GET && $_GET['t']) ? $_GET['t'] : (date('Y') - 1) ;
        $param['tag']           = isset($tag) && $tag ? $tag : 'opd';
        $param['kategori_unit'] = $param['tag'];

        $data['indikator']      = $this->mastermodel->findMIndikator($param);

        $data['unit'] = $this->mastermodel->findMUnit($param);
        $data['label']=((isset($tag) && $tag=='kab')?'Kabupaten/Kota':'Perangkat Daerah/UOBK');
        $data['tag'] = $param['tag'];

        if($params != 'spirit'){
            $data['idaspek'] = $_GET['ids'];
        }
        
        $data['tahun']   = $_GET['t'];
        $data['periode'] = $_GET['p'];
        $data['dataPeriode'] = $this->mastermodel->getPeriode();
        return view('detail', $data);
    }

    function indikator($tag=null){

        // return json_encode($params);
        
        $param['periode']       = ($_GET && $_GET['t']) ? $_GET['t'] : (date('Y') - 1) ;
        $param['tag']           = isset($tag) && $tag ? $tag : 'opd';
        $param['kategori_unit'] = $param['tag'];

        $data['indikator']      = $this->mastermodel->findMIndikator($param);

        $data['unit'] = $this->mastermodel->findMUnit($param);
        $data['label']=((isset($tag) && $tag=='kab')?'Kabupaten/Kota':'Perangkat Daerah/UOBK');
        $data['tag'] = $param['tag'];
        
        $data['tahun']   = $_GET['t'];
        $data['periode'] = $_GET['p'];
        $data['idIndikator'] = $_GET['ids'];
        $data['dataPeriode'] = $this->mastermodel->getPeriode();

        // return json_encode($data['unit']);

        return view('detail/indikator', $data);
    }

    public function is_decimal( $val )
    {
        if(is_numeric( $val ) && floor( $val ) != $val)
            return number_format($val, 2);

        return number_format($val, 0);
    }

}
