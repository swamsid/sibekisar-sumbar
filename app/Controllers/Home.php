<?php

namespace App\Controllers;
use App\Models\EvaluasiModel;
use App\Models\MasterModel;

class Home extends BaseController
{
    public function __construct()
    {
        $this->evaluasimodel = new EvaluasiModel();
        $this->mastermodel   = new MasterModel();
    }

	public function index()
	{
        $dataPeriode = $this->mastermodel->getPeriode();
        $periode = (count($dataPeriode)) ? $dataPeriode[count($dataPeriode) - 1]->id_periode : 0;
        // $periode = 1;
        
        $data_['limit']=4;
        $data_['tahun']= $periode;
        $data_['tag']='opd';
        $data['cettar'] = $this->evaluasimodel->findCettar($data_);
        
        $aspek  = $this->evaluasimodel->findAspek([ 'periode' => $periode, 'tag' => 'opd']);
        $aspekK = $this->evaluasimodel->findAspek([ 'periode' => $periode, 'tag' => 'kab']);

        $data['dataPeriode']    = $this->mastermodel->getPeriode();

        foreach($aspek as $key => $dataAspek){
            $data1['limit']=1;
            $data1['tahun']= $periode;
            $data1['id_aspek'] = $dataAspek->id_aspek;
            $data1['tag']= 'opd';

            $data['aspek'][strtolower($dataAspek->aspek)] = $this->evaluasimodel->findCettarAspek($data1);
        }

        $data['aspek']      = $aspek;
        $data['aspekKab']   = $aspekK;

        // return json_encode($data['aspekKab']);

        return view('home', $data);
	}

    public function kab()
    {
        $dataPeriode = $this->mastermodel->getPeriode();
        $periode = (count($dataPeriode)) ? $dataPeriode[count($dataPeriode) - 1]->id_periode : 0;
        $periode = 1;
        
        $data_['limit']=4;
        $data_['tahun']= $periode;
        $data_['tag']='kab';
        $data['cettar'] = $this->evaluasimodel->findCettar($data_);

        $aspek = $this->evaluasimodel->findAspek([ 'periode' => $periode, 'tag' => 'kab']);
        $data['dataPeriode']    = $this->mastermodel->getPeriode();

        foreach($aspek as $key => $dataAspek){
            $data1['limit']=1;
            $data1['tahun']= $periode;
            $data1['id_aspek'] = $dataAspek->id_aspek;
            $data1['tag']= 'kab';

            $data['aspek'][strtolower($dataAspek->aspek)] = $this->evaluasimodel->findCettarAspek($data1);
        }


        return view('home_kab',$data);
    }
}
