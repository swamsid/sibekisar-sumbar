<?php

namespace App\Controllers\Module;
use App\Controllers\BaseController;
use App\Models\EvaluasiModel;
use App\Models\MasterModel;

class Evaluasi extends BaseController
{

    public function __construct()
    {
        $this->session = \Config\Services::session();
        if(!isset($_SESSION['user']) || empty($_SESSION['user'])) {
            header('Location: '.base_url('auth'));
            exit();
        }
        $this->evaluasimodel = new EvaluasiModel();
        $this->mastermodel = new MasterModel();

        $this->success = array('message' => 'Proses simpan berhasil', 'type' => 'success', 'status'=>'ok');
        $this->delete = array('message' => 'Hapus data berhasil', 'type' => 'success', 'status'=>'ok');
        $this->failed = array('message' => 'Proses simpan gagal', 'type' => 'error', 'status'=>false);
    }

    public function index()
    {
        $data['user'] = $_SESSION['user'];
        $this->addScript("assets/js/evaluasi.js");
        $this->addScript("assets/vendors/datatables/rg/dataTables.rowsGroup.js");
        $data['unit'] = $this->mastermodel->findMUnit();
        $data['indikator'] = $this->mastermodel->findMIndikator();
        $this->show('apps/evaluasi', $data);
    }

        public function rekap()
    {
        $data['user'] = $_SESSION['user'];
        return view('apps/main', $data);
    }

    public function gridevaluasi()
    {
        $data = $this->evaluasimodel->findData();
        $count = count($data);
        return $this->response->setJSON(json_encode(array(
                "iTotalRecords" => $count,
                "aaData" => $data
            )));
    }

    function simpan()
    {
        if (empty($_POST)) echo json_encode($this->failed);
        $fzeropadded = sprintf("%04d", $_POST['id_unit']);
        $mulai = sprintf("%02d", $_POST['bulan_mulai']);
        if (!empty($_POST['id_indikator'])) {
            $i = 0;
            foreach ($_POST['id_indikator'] as $key) {
                $id_indikator = $key;
                $id_evaluasi = $_POST['tahun'].$mulai.$fzeropadded.'_'.$id_indikator;
                $dataKomponen = array(
                    'id_indikator' => $id_indikator,
                    'id_evaluasi' => $id_evaluasi,
                    'nilai' => $_POST['nilai'.$id_indikator],
                    'bobot' => $_POST['bobot'.$id_indikator],
                    'bulan_mulai' => $_POST['bulan_mulai'],
                    'bulan_selesai' => $_POST['bulan_selesai'],
                    'tahun' => $_POST['tahun'],
                    'id_unit' => $_POST['id_unit'],
                    'periode' => $_POST['periode'.$id_indikator],
                    'catatan' => $_POST['catatan'.$id_indikator],
                    'timestamp' => date("Y-m-d H:i:s"),
                    'id_user' => $_SESSION['user']->id
                );
                $result = $this->evaluasimodel->insertData($dataKomponen);
                $i++;
            }
            if($result) echo json_encode($this->success);
        }
       
    }

}
