<?php

namespace App\Controllers\Module;
use App\Controllers\BaseController;
use App\Models\MasterModel;

class Users extends BaseController
{

    public function __construct()
    {
        $this->session = \Config\Services::session();
        if(!isset($_SESSION['user']) || empty($_SESSION['user'])) {
            header('Location: '.base_url('auth'));
            exit();
        }
        $this->mastermodel = new MasterModel();

        $this->success = array('message' => 'Proses simpan berhasil', 'type' => 'success', 'status' => 'ok');
        $this->delete = array('message' => 'Hapus data berhasil', 'type' => 'success', 'status' => 'ok');
        $this->failed = array('message' => 'Proses simpan gagal', 'type' => 'error', 'status' => false);
    }

    function index(){
        $data['user'] = $_SESSION['user'];
        $this->addScript("assets/js/apps/users.js");
        /*if (!$indikator = cache('indikator')){
            $indikator = $this->mastermodel->findMIndikator();
            cache()->save('indikator', $indikator, 24000);
        }
        $data['indikator'] = $this->cache->get('indikator');*/
        $data['unit'] = $this->mastermodel->findMUnit();
        $this->show('module/users/index', $data);
    }

    public function gridusers()
    {
        $data = $this->mastermodel->findMUsers();
        $count = count($data);
        return $this->response->setJSON(json_encode(array(
            "iTotalRecords" => $count,
            "aaData" => $data
        )));
    }

    function simpan_users(){
        $data = $_REQUEST;

        //if(empty($_REQUEST['id_unit'])) $data['id_unit'] = $this->microtime();

        //$data['id_user'] = $this->getLogin()->id;
        $data['is_aktif'] = (isset($_REQUEST['is_aktif'])?$_REQUEST['is_aktif']:0);
        $data['nama'] = str_replace("'", "`",$data['nama']);
        $data["password"] = $this->generateHash($_REQUEST["password"]);
        $result = $this->mastermodel->insertMUsers($data);

        if ($result) echo json_encode($this->success);
        else echo json_encode($this->failed);
    }

    function update_users(){
        $data = $_REQUEST;
        $data["password"] = $this->generateHash($_REQUEST["password"]);
        $where = array('id_user'=>$data['id_user']);
        $datau = array('password'=>$data['password'], 'username'=>$data['username']);
        $result = $this->mastermodel->updateMUsers($datau,$where);

        if ($result) echo json_encode($this->success);
        else echo json_encode($this->failed);
    }

    private function generateHash($password)
    {
        if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) {
            $salt = '$2y$11$' . substr(md5(uniqid(rand(), true)), 0, 22);
            return crypt($password, $salt);
        }
    }

}