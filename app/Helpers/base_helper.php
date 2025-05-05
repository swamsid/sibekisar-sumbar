<?php

function currency_rupiah($jumlah)
{
    return 'Rp. ' . number_format($jumlah, 0, '', '.') . ',-';
}

function penyebut_rupiah($nilai) {
    $nilai = abs($nilai);
    $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($nilai == 0) {
        $temp = $huruf[$nilai];
    } else if ($nilai < 12) {
        $temp = " ". $huruf[$nilai];
    } else if ($nilai <20) {
        $temp = penyebut_rupiah($nilai - 10). " belas";
    } else if ($nilai < 100) {
        $temp = penyebut_rupiah($nilai/10)." puluh". penyebut_rupiah($nilai % 10);
    } else if ($nilai < 200) {
        $temp = " seratus" . penyebut_rupiah($nilai - 100);
    } else if ($nilai < 1000) {
        $temp = penyebut_rupiah($nilai/100) . " ratus" . penyebut_rupiah($nilai % 100);
    } else if ($nilai < 2000) {
        $temp = " seribu" . penyebut_rupiah($nilai - 1000);
    } else if ($nilai < 1000000) {
        $temp = penyebut_rupiah($nilai/1000) . " ribu" . penyebut_rupiah($nilai % 1000);
    } else if ($nilai < 1000000000) {
        $temp = penyebut_rupiah($nilai/1000000) . " juta" . penyebut_rupiah($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
        $temp = penyebut_rupiah($nilai/1000000000) . " milyar" . penyebut_rupiah(fmod($nilai,1000000000));
    } else if ($nilai < 1000000000000000) {
        $temp = penyebut_rupiah($nilai/1000000000000) . " trilyun" . penyebut_rupiah(fmod($nilai,1000000000000));
    }
    return $temp;
}

function terbilang_rupiah($nilai) {
    if($nilai<0) {
        $hasil = "minus ". trim(penyebut_rupiah($nilai));
    } else {
        $hasil = trim(penyebut_rupiah($nilai));
    }
    return ucwords($hasil . " " . "rupiah");
}

function formatBytes($size, $precision = 2)
{
    if($size > 0) {
        $base = log($size, 1024);
        $suffixes = array('', 'Kb', 'Mb', 'Gb', 'Tb');

        return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
    }
    return "-";
}

function format_hari($mysql_date){
    $nama_hari = ["Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu", "Minggu"];
    return $nama_hari[date("N", strtotime($mysql_date)) -1];
}

function format_hari_antara($mysql_date_start, $mysql_date_end, $penghubung = " s/d "){
    $timeStart = strtotime($mysql_date_start);
    $timeEnd = strtotime($mysql_date_end);
    if (date("Ymd",$timeStart) === date("Ymd", $timeEnd)){
        return format_hari($timeStart);
    }else{
        return format_hari($mysql_date_start) . $penghubung . format_hari($mysql_date_end);
    }
}

function format_tgl($mysql_date, $formatBulan="M", $showTime = false, $timeDivider = " "){
    $nama_bulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
    $nama_bulan_singkat = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agus", "Sep", "Okt", "Nov", "Des"];
    $time = strtotime($mysql_date);
    $string_date = "";
    if($formatBulan === "M")
        $string_date = date("d", $time). ' ' . $nama_bulan[(intval(date("m", $time))-1)]. ' '. date('Y', $time);
    else if($formatBulan === "Ms")
        $string_date = date("d", $time). '/' . $nama_bulan_singkat[(intval(date("m", $time))-1)]. '/'. date('Y', $time);
    else
        $string_date = date("d/m/Y", $time);
    if($showTime){
        $string_date = $string_date . $timeDivider . date("H:i", $time) ;
    }
    return $string_date;
}

function format_tgl_antara($mysql_date_start, $mysql_date_end, $formatBulan = "M", $penghubung = " s/d "){
    $nama_bulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
    $timeStart = strtotime($mysql_date_start);
    $timeEnd = strtotime($mysql_date_end);
    if (date("Ymd",$timeStart) === date("Ymd", $timeEnd)){
        return format_tgl($mysql_date_start, $formatBulan);
    }
    else if (date("Ym",$timeStart) === date("Ym", $timeEnd) && $formatBulan === "M"){
        return date("d",$timeStart) . $penghubung . date("d",$timeEnd) . ' ' . $nama_bulan[(intval(date("m",$timeStart))-1)]. ' '. date('Y', $timeStart);
    }else{
        if($formatBulan === "M"){
            return date("d",$timeStart) . ' ' . $nama_bulan[(intval(date("m",$timeStart))-1)]. ' '. date('Y', $timeStart) . $penghubung .
                date("d",$timeEnd) . ' ' . $nama_bulan[(intval(date("m",$timeEnd))-1)]. ' '. date('Y', $timeEnd);
        }else {
            return date("d/m/Y", $timeStart) . $penghubung . date("d/m/Y", $timeEnd);
        }
    }
}

function format_time_antara($mysql_time_start_start, $mysql_time_end, $penghubung = " s/d "){
    if($mysql_time_start_start == $mysql_time_end){
        return substr($mysql_time_start_start,0,5);
    }else {
        return substr($mysql_time_start_start,0,5) . $penghubung . substr($mysql_time_end,0,5);
    }
}

function get_client_ip()
{
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if (isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function curl_uploaded_file($filedata, $upload_dir, $filename){
    $requestData = array("filedata" => new CURLFile($filedata), "filename" => $filename, "filedir"=>$upload_dir);
    $now = date("Y-m-d H:i:s");
    $appConfig = new \Config\App();
    $requestHeader = array(
        "Content-Type:multipart/form-data",
        'Authhash:' . base64_encode(sha1( date("YmdHis", strtotime($now)) . "~" . $appConfig->internalToken)),
        'Date:' . $now
    );
    $ch = curl_init($appConfig->uploadTargetUrl);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $requestHeader);

    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//    curl_setopt($ch, CURLINFO_HEADER_OUT, false);

    $result = curl_exec($ch);
    $responseHeaderInfo = curl_getinfo($ch,CURLINFO_HEADER_OUT);
    $responseHeaderSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $responseHeader = substr($result, 0, $responseHeaderSize);
    $responseBody = substr($result, $responseHeaderSize);
    curl_close($ch);
    return json_decode($responseBody);
}

function do_uploaded_file($folder, $var = "file", $preffix = "", $replace_name = null, $allowed = null, $max_size=null)
{
    // return 'okee';

    if ($allowed == null)
        $allowed = 'png,jpg,jpeg,gif,pdf'; //,doc,docx,xls,xlsx,ppt,pptx
    if ($max_size == null)
        $max_size = 6291456; //6 MB
    $mode = 755;
    $extension_allowed = explode(',', $allowed);

    if (isset($_FILES[$var])) {
        $result = array();
        if (is_array($_FILES[$var]['name'])) {
            foreach ($_FILES[$var]['name'] as $key => $value) {
                if ($_FILES[$var]['error'][$key] !== UPLOAD_ERR_OK) {
                    array_push($result,array("status" => false, "reason"=>upload_error_code($_FILES[$var]['error'][$key])));
                    return $result;
                }
                if (empty($value)) {
                    array_push($result,array("status" => false, "reason"=>"Tidak ada file yang di upload"));
                    continue;
                }
                $file_name = $value;

                $array_file_name = explode('.', $value);
                $extension = strtolower(end($array_file_name));

                $new_file_name = $preffix . $file_name;
                if ($replace_name != null)
                    $new_file_name = $preffix . $replace_name . "." . $extension;
                $file_directory_saved = "".$folder;
                if (!file_exists("uploads/". $file_directory_saved)) {
                    mkdir("uploads/". $file_directory_saved, $mode, true);
                }

                if (in_array($extension, $extension_allowed)) {
                    if($max_size >= $_FILES[$var]['size'][$key]) {
                        $resultCurl = move_uploaded_file($_FILES[$var]['tmp_name'][$key], "uploads/".trim($file_directory_saved, "/")."/".$new_file_name);
                        if($resultCurl) {
                            array_unshift($result, array(
                                "file_loc" => $folder . "/" . $new_file_name,
                                "file_size" => $_FILES[$var]['size'][$key],
                                "file_name" => $new_file_name,
                                "file_name_ori" => $_FILES[$var]['name'][$key],
                                "file_type" => $_FILES[$var]['type'][$key],
                                "id_in_array" => $key
                            ));
                        }else{
                            array_push($result, array("status" => false, "reason" => $resultCurl->reason));
                        }
                    }else{
                        array_push($result, array("status" => false, "reason"=>"Ukuran file terlalu besar, ukuran maksimal 6 Mb"));
                    }
                } else {
                    array_push($result, array("status" => false, "reason"=>"Tipe file tidak di perbolehkan"));
                }
            }
        }
        else {
            if ($_FILES[$var]['error'] !== UPLOAD_ERR_OK) {
                $result = array("status" => false, "reason"=>upload_error_code($_FILES[$var]['error']));
                return $result;
            }
            if (empty($_FILES[$var]['name'])) {
                $result = array("status" => false, "reason"=>"Tidak ada file yang di upload");
                return $result;
            }

            $file_name = $_FILES[$var]['name'];
            $array_file_name = explode('.', $file_name);
            $extension = strtolower(end($array_file_name));

            $new_file_name = $preffix . $file_name;
            if ($replace_name != null)
                $new_file_name = $preffix . $replace_name . "." . $extension;
            $file_directory_saved = "".$folder;
            if (!file_exists("uploads/". $file_directory_saved)) {
                mkdir("uploads/". $file_directory_saved, $mode, true);
            }

            if (in_array($extension, $extension_allowed)) {
                if($max_size >= $_FILES[$var]['size']) {
                    $resultCurl = move_uploaded_file($_FILES[$var]['tmp_name'], "uploads/".trim($file_directory_saved, "/")."/".$new_file_name);
                    if($resultCurl) {
                        $result = array(
                            "file_loc" => $folder . "/" . $new_file_name,
                            "file_size" => $_FILES[$var]['size'],
                            "file_name" => $new_file_name,
                            "file_name_ori" => $_FILES[$var]['name'],
                            "file_type" => $_FILES[$var]['type'],
                            "status" => true
                        );
                    }else{
                        $result = array("status" => false, "reason" => $resultCurl->reason);
                    }
                }else{
                    $result = array("status" => false, "reason"=>"Ukuran file terlalu besar");
                }
            } else {
                $result = array("status" => false, "reason"=>"Tipe file tidak di perbolehkan");
            }
        }
        return $result;
    }

    return array("status" => false, "reason"=>"Tidak ada file yang di upload");
}

function upload_error_code ($code) {
    switch ($code) {
        case UPLOAD_ERR_INI_SIZE:
            $message = "File yang diunggah melebihi aturan upload_max_filesize Server";
            break;
        case UPLOAD_ERR_FORM_SIZE:
            $message = "File yang diunggah melebihi aturan MAX_FILE_SIZE yang ditentukan dalam form HTML";
            break;
        case UPLOAD_ERR_PARTIAL:
            $message = "File yang diunggah tidak lengkap.";
            break;
        case UPLOAD_ERR_NO_FILE:
            $message = "Tidak ada file yang di upload";
            break;
        case UPLOAD_ERR_NO_TMP_DIR:
            $message = "Folder temporary tidak ada di directory server";
            break;
        case UPLOAD_ERR_CANT_WRITE:
            $message = "Gagal menulis file ke disk";
            break;
        case UPLOAD_ERR_EXTENSION:
            $message = "Unggahan file dihentikan oleh ekstensi";
            break;
        default:
            $message = "Kesalahan unggahan tidak dikenal";
            break;
    }
    return $message;
}

function base_url_assets ($renderMinAssets){
    $array = explode('.', $renderMinAssets);
    $extension = end($array);
    if (ENVIRONMENT === 'production' && in_array($extension, array('js','css'))) {
        $newName = rtrim($renderMinAssets, $extension) . "min.".$extension;
        if (is_readable($newName)) {
            return base_url($newName);
        }
        return base_url($renderMinAssets);
    }
    return base_url($renderMinAssets);
}

function host_url(){
    $appConfig = new \Config\App();
    return $appConfig->getHostUrl();
}

function internal_url($uri = '')
{
    $appConfig = new \Config\App();
    return rtrim($appConfig->internalURL . $uri, "/");
}

function file_url($uri = '') {
    $appConfig = new \Config\App();
    return rtrim(base_url("uploads/".$uri), "/");
}
