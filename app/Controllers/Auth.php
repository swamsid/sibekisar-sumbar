<?php

namespace App\Controllers;
use App\Models\AuthModel;

class Auth extends BaseController
{

    protected $format    = 'json';
    protected $session;
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->session->start();
        $this->auth = new AuthModel();
    }

    public function index()
    {

        return view('auth');
    }

    public function dologin()
    {
        $data=$_REQUEST;
        if(empty($_REQUEST['username']) || empty($_REQUEST['password'])){
            $output = [
                'status' => false,
                'message' => 'Form tidak lengkap, Mohon ulangi kembali'
            ];
            return $this->response->setJSON($output, 400);
        }

        $user = $this->auth->find($data);
        $passwordhash = $this->verify($_REQUEST['password'], $user->password);

        if(empty($user)){
            $output = [
                'status' => false,
                'message' => 'Email tidak ditemukan',
            ];
        }
        if(trim($user->password)!=trim($passwordhash)){
            $output = [
                'status' => false,
                'message' => 'Password tidak sesuai',
            ];

        }
        if($user->password==$passwordhash) {
            $this->session->set("user",$user);
            $output = [
                'status' => 'ok',
                'message' => 'Selamat datang, ' . $user->nama
            ];
        }
        return $this->response->setJSON($output);
    }

    private function verify($password, $hashedPassword)
    {
        return crypt($password, $hashedPassword);
    }


    public function logout()
    {
        $this->session->destroy();
        return redirect()->to(base_url());
    }

    private function generateHash($password)
    {
        if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) {
            $salt = '$2y$11$' . substr(md5(uniqid(rand(), true)), 0, 22);
            return crypt($password, $salt);
        }
    }
}
