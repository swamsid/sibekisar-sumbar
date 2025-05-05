<?php

namespace App\Models;

use CodeIgniter\Model;

class EvaluasiModel extends Model
{

    function call_sp_aspek()
    {
        $query = $this->db->query("CALL generate_rekap_by_aspek()");
        return true;
    }

    function call_sp_spirit()
    {
        $query = $this->db->query("CALL generate_rekap_by_spirit()");
        return true;
    }

    function insertData($data = null)
    {
        $builder = $this->db->table('evaluasi');
        return $builder->replace($data);
    }

    function updateData($data = null, $where = null)
    {
        $builder = $this->db->table('evaluasi');
        return $builder->ignore(true)->update($data, $where);
    }

    function insertDataSerapan($data = null)
    {
        $params = [
            'id_tmp'    => $data['id_unit']
        ];

        $cekIndikator = $this->db->table('m_unit');
        $cekIndikator->where($params);
        $cekIndikator->select('m_unit.*');

        $result = $cekIndikator->get()->getRow();

        if($result){
            $builder = $this->db->table('_sync_serapan');
            $builder->replace($data);
        }
    }

    function evaluasibulk($data)
    {
        $query = "SELECT
                        _sync_serapan.nama_unit,
                        _sync_serapan.agr,
                        _sync_serapan.`real`,
                        _sync_serapan.persen,
                        _sync_serapan.grup,
                        _sync_serapan.id_indikator,
                       year(_sync_serapan.tanggal) as tahun,
                        m_unit.id_unit,
                        m_unit.unit,
                        m_indikator.bobot,
                        m_aspek.nilai_maks
                        FROM
                        _sync_serapan
                        INNER JOIN m_unit ON _sync_serapan.id_unit = m_unit.id_tmp
                        INNER JOIN m_indikator ON _sync_serapan.id_indikator = m_indikator.id_indikator
                        INNER JOIN m_aspek ON m_indikator.id_aspek = m_aspek.id_aspek
                         WHERE year(_sync_serapan.tanggal)='" . $data['tanggal'] . "'
                        ";
        return $this->db->query($query)->getResult();
    }

    function reportJumlahDinilai($data = null)
    {
        $query = "SELECT
                    m_indikator.id_indikator,
                    m_indikator.indikator,
                    tmp.tahun,
                    m_unit.id_unit,
                    m_unit.unit,
                    m_unit.kode_unit,
                    tmp.jml 
                FROM
                    m_indikator
                    INNER JOIN m_unit ON m_indikator.id_opd = m_unit.id_unit
                    INNER JOIN m_aspek ON m_indikator.id_aspek = m_aspek.id_aspek
                    LEFT JOIN (
                    SELECT
                        evaluasi.tahun,
                        Count( evaluasi.id_unit ) AS jml,
                        evaluasi.id_indikator 
                    FROM
                        evaluasi 
                    WHERE
                        evaluasi.nilai_akhir > 0  AND evaluasi.tahun='" . $data['tahun'] . "' 
                    GROUP BY
                        evaluasi.id_indikator,
                        evaluasi.tahun
                    ) AS tmp ON tmp.id_indikator = m_indikator.id_indikator WHERE m_aspek.tag='" . $data['tag'] . "' ORDER BY tmp.jml DESC, m_indikator.id_indikator ASC";
        return $this->db->query($query)->getResult();
    }

    function findMAspek($data = null)
    {
        $builder = $this->db->table('m_aspek');
        $builder->select('m_aspek.*, mid(md5(m_aspek.id_aspek),9,6) as id_aspek_hash');
        $builder->where('m_aspek.is_aktif <> 3');

        if (isset($data['tag']) && !empty($data['tag'])) $builder->where('m_aspek.tag', $data['tag']);

        $query = $builder->get()->getResult();
        return $query;
    }

    function getData($data = null)
    {
        $builder = $this->db->table('evaluasi');
        $builder->select('evaluasi.*, m_aspek.aspek, m_aspek.nilai_maks, 
        m_indikator.indikator,m_indikator.bobot, mid(md5(m_indikator.id_indikator),9,6) as id_indikator_hash, 
        mid(md5(evaluasi.id_evaluasi),9,6) as id_evaluasi_hash, m_unit.unit');
        $builder->join('m_indikator', 'm_indikator.id_indikator = evaluasi.id_indikator');
        $builder->join('m_aspek', 'm_aspek.id_aspek = m_indikator.id_aspek');
        $builder->join('m_unit', 'm_unit.id_unit = evaluasi.id_unit');
        $builder->where('m_indikator.is_aktif', 1);

        if (isset($data['tag']) && !empty($data['tag'])) $builder->where('m_aspek.tag', $data['tag']);
        if (isset($data['is_aktif']) && !empty($data['is_aktif'])) $builder->where('evaluasi.is_aktif', $data['is_aktif']);
        if (isset($data['tahun']) && !empty($data['tahun'])) $builder->where('evaluasi.tahun', $data['tahun']);
        if (isset($data['is_verify'])) $builder->where('evaluasi.is_verify', $data['is_verify']);
        if (isset($data['id_unit']) && !empty($data['id_unit'])) {
            $where = "evaluasi.id_unit IN (" . $data['id_unit'] . ")";
            $builder->where($where);
        }
        if (isset($data['id_indikator']) && !empty($data['id_indikator'])) {
            $where = "(m_indikator.id_indikator='" . $data['id_indikator'] . "' OR mid(md5(m_indikator.id_indikator),9,6)='" . $data['id_indikator'] . "')";
            $builder->where($where);
        }
        if (isset($data['id_aspek']) && !empty($data['id_aspek'])) {
            $where = "(m_aspek.id_aspek='" . $data['id_aspek'] . "' OR mid(md5(m_aspek.id_aspek),9,6)='" . $data['id_aspek'] . "')";
            $builder->where($where);
        }

        if (isset($data['id_evaluasi']) && !empty($data['id_evaluasi'])) {
            $where = " (evaluasi.id_evaluasi='" . $data['id_evaluasi'] . "' OR mid(md5(evaluasi.id_evaluasi),9,6)='" . $data['id_evaluasi'] . "')";
            $builder->where($where);
        }

        return $builder->get()->getRow();
    }

    function findData($data = null)
    {
        $builder = $this->db->table('evaluasi');
        $builder->select('evaluasi.*, m_aspek.aspek, m_aspek.nilai_maks, 
        m_indikator.indikator, m_indikator.id_opd, m_indikator.bobot,mid(md5(m_indikator.id_indikator),9,6) as id_indikator_hash, 
        mid(md5(evaluasi.id_evaluasi),9,6) as id_evaluasi_hash, m_unit.unit');
        $builder->join('m_indikator', 'm_indikator.id_indikator = evaluasi.id_indikator');
        $builder->join('m_aspek', 'm_aspek.id_aspek = m_indikator.id_aspek');
        $builder->join('m_unit', 'm_unit.id_unit = evaluasi.id_unit');
        $builder->where('m_indikator.is_aktif', 1);

        if (isset($data['tag']) && !empty($data['tag'])) $builder->where('m_aspek.tag', $data['tag']);
        if (isset($data['is_aktif']) && !empty($data['is_aktif'])) $builder->where('evaluasi.is_aktif', $data['is_aktif']);
        if (isset($data['id_unit']) && !empty($data['id_unit'])) {
            $where = "evaluasi.id_unit IN (" . $data['id_unit'] . ")";
            $builder->where($where);
        }

        if (isset($data['tahun']) && !empty($data['tahun'])) $builder->where('evaluasi.tahun', $data['tahun']);
        if (isset($data['is_verify'])) $builder->where('evaluasi.is_verify', $data['is_verify']);
        if (isset($data['bulan_mulai']) && !empty($data['bulan_mulai'])) $builder->where('evaluasi.bulan_mulai', $data['bulan_mulai']);
        if (isset($data['bulan_selesai']) && !empty($data['bulan_selesai'])) $builder->where('evaluasi.bulan_selesai', $data['bulan_selesai']);

        if (isset($data['id_indikator']) && !empty($data['id_indikator'])) {
            $where = "(m_indikator.id_indikator='" . $data['id_indikator'] . "' OR mid(md5(m_indikator.id_indikator),9,6)='" . $data['id_indikator'] . "')";
            $builder->where($where);
        }

        if (isset($data['id_aspek']) && !empty($data['id_aspek'])) {
            $where = "(m_aspek.id_aspek='" . $data['id_aspek'] . "' OR mid(md5(m_aspek.id_aspek),9,6)='" . $data['id_aspek'] . "')";
            $builder->where($where);
        }

        if (isset($data['id_evaluasi']) && !empty($data['id_evaluasi'])) {
            $where = " (evaluasi.id_evaluasi='" . $data['id_evaluasi'] . "' OR mid(md5(evaluasi.id_evaluasi),9,6)='" . $data['id_evaluasi'] . "')";
            $builder->where($where);
        }
        $builder->orderBy('m_unit.kode_unit ASC');
        // $sql = $builder->getCompiledSelect();
        // echo $sql;exit;

        return $builder->get()->getResult();
    }

    function findDataByIndikator($data = null)
    {
        $builder = $this->db->table('m_unit');
        $builder->select('evaluasi.*, m_aspek.aspek, m_aspek.nilai_maks, 
        m_indikator.indikator, m_indikator.id_opd, m_indikator.bobot,mid(md5(m_indikator.id_indikator),9,6) as id_indikator_hash, 
        mid(md5(evaluasi.id_evaluasi),9,6) as id_evaluasi_hash, m_unit.unit');
        $builder->join('evaluasi', 'm_unit.id_unit = evaluasi.id_unit', 'left');
        $builder->join('m_indikator', 'm_indikator.id_indikator = evaluasi.id_indikator', 'left');
        $builder->join('m_aspek', 'm_aspek.id_aspek = m_indikator.id_aspek', 'left');
        $builder->where('m_indikator.is_aktif', 1);

        if (isset($data['tag']) && !empty($data['tag'])) $builder->where('m_aspek.tag', $data['tag']);
        if (isset($data['is_aktif']) && !empty($data['is_aktif'])) $builder->where('evaluasi.is_aktif', $data['is_aktif']);
        if (isset($data['id_unit']) && !empty($data['id_unit'])) {
            $where = "evaluasi.id_unit IN (" . $data['id_unit'] . ")";
            $builder->where($where);
        }

        if (isset($data['tahun']) && !empty($data['tahun'])) $builder->where('evaluasi.tahun', $data['tahun']);
        if (isset($data['is_verify'])) $builder->where('evaluasi.is_verify', $data['is_verify']);
        if (isset($data['bulan_mulai']) && !empty($data['bulan_mulai'])) $builder->where('evaluasi.bulan_mulai', $data['bulan_mulai']);
        if (isset($data['bulan_selesai']) && !empty($data['bulan_selesai'])) $builder->where('evaluasi.bulan_selesai', $data['bulan_selesai']);

        if (isset($data['id_indikator']) && !empty($data['id_indikator'])) {
            $where = "(m_indikator.id_indikator='" . $data['id_indikator'] . "' OR mid(md5(m_indikator.id_indikator),9,6)='" . $data['id_indikator'] . "')";
            $builder->where($where);
        }

        if (isset($data['id_aspek']) && !empty($data['id_aspek'])) {
            $where = "(m_aspek.id_aspek='" . $data['id_aspek'] . "' OR mid(md5(m_aspek.id_aspek),9,6)='" . $data['id_aspek'] . "')";
            $builder->where($where);
        }

        if (isset($data['id_evaluasi']) && !empty($data['id_evaluasi'])) {
            $where = " (evaluasi.id_evaluasi='" . $data['id_evaluasi'] . "' OR mid(md5(evaluasi.id_evaluasi),9,6)='" . $data['id_evaluasi'] . "')";
            $builder->where($where);
        }

        $builder->orderBy('m_unit.kode_unit ASC');

        return $builder->get()->getResult();
    }

    function findPenilaian($data){
        $builder = $this->db->table('m_unit');
        $builder->join(
            'evaluasi', 
            'm_unit.id_unit = evaluasi.id_unit AND evaluasi.tahun = '.$data['tahun'].' AND evaluasi.id_indikator = "'.$data['id_indikator'].'"', 
            'left'
        );
        
        if($data['tag'] == 'opd'){
            $builder->where('kategori_unit <>', 'kab');
        }else{
            $builder->where('kategori_unit', $data['tag']);
        }
        

        $builder->select('m_unit.unit, ,m_unit.id_unit as unit_id, evaluasi.*', 'mid(md5(evaluasi.id_evaluasi),9,6) as id_evaluasi_hash');
        
        $builder->orderBy('m_unit.kategori_unit');
        $builder->orderBy('m_unit.unit');
        
        return $builder->get()->getResult();
    }

    // Dirga

    function findAspek($data = null)
    {
        $builder = $this->db->table('m_aspek');
        $builder->select('m_aspek.*');
        $builder->where($data);

        $query = $builder->get()->getResult();
        
        return $query;
    }

    function findCettar($data = null)
    {
        $builder = $this->db->table('vw_rekap_by_spirit');
        $builder->select('vw_rekap_by_spirit.*, mid(md5(vw_rekap_by_spirit.id_unit),9,6) as id_unit_hash');

        $builder->join('m_unit', 'vw_rekap_by_spirit.id_unit = m_unit.id_unit');

        if (isset($data['tahun']) && !empty($data['tahun'])) $builder->where('tahun', $data['tahun']);
        
        if (isset($data['tag']) && !empty($data['tag'])) $builder->where('m_unit.kategori_unit', $data['tag']);

        if (isset($data['id_unit']) && !empty($data['id_unit'])) $builder->where('m_unit.id_unit', $data['id_unit']);

        if (isset($data['id_unit_hash']) && !empty($data['id_unit_hash'])) {
            // $builder->where('id_unit',$data['id_unit']);
            $where = " (mid(md5(m_unit.id_unit),9,6)='" . $data['id_unit'] . "')";
            $builder->where($where);
        }

        if (isset($data['predikat']) && !empty($data['predikat'])) $builder->where('predikat', $data['predikat']);
        
        if (isset($data['limit']) && !empty($data['limit'])) {
            $builder->orderBy('nilai', 'DESC');
            $builder->limit($data['limit']);

        } else  $builder->orderBy('nilai', 'DESC');
        
        if (isset($data['limit']) && $data['limit'] == 1) return $builder->get()->getRow();
        else return $builder->get()->getResult();
    }

    function findCettarAspek($data = null)
    {
        // return 'okee';
        $builder = $this->db->table('vw_rekap_by_aspek');

        $builder->select('vw_rekap_by_aspek.*, mid(md5(vw_rekap_by_aspek.id_unit),9,6) as id_unit_hash');

        $builder->join('vw_rekap_by_spirit', 'vw_rekap_by_spirit.tahun = vw_rekap_by_aspek.tahun AND vw_rekap_by_spirit.id_unit = vw_rekap_by_aspek.id_unit');

        $builder->join('m_unit', 'vw_rekap_by_spirit.id_unit = m_unit.id_unit');

        if (isset($data['tahun']) && !empty($data['tahun'])) $builder->where('vw_rekap_by_aspek.tahun', $data['tahun']);
        if (isset($data['tag']) && !empty($data['tag'])) $builder->where('m_unit.kategori_unit', $data['tag']);
        if (isset($data['id_unit_hash']) && !empty($data['id_unit_hash'])) {
            $where = " (mid(md5(vw_rekap_by_aspek.id_unit),9,6)='" . $data['id_unit'] . "')";
            $builder->where($where);
            $builder->orderBy('vw_rekap_by_aspek.id_aspek', 'ASC');
        }
        if (isset($data['id_unit']) && !empty($data['id_unit'])) {
            $builder->where('vw_rekap_by_aspek.id_unit', $data['id_unit']);
            $builder->orderBy('vw_rekap_by_aspek.id_aspek', 'ASC');
        }
        if (isset($data['id_aspek']) && !empty($data['id_aspek'])) $builder->where('id_aspek', $data['id_aspek']);

        //  $builder->orderBy('id_aspek', 'ASC');

        $builder->orderBy('vw_rekap_by_aspek.total_nilai', 'DESC');
        $builder->orderBy('vw_rekap_by_spirit.nilai', 'DESC');
        $builder->orderBy('vw_rekap_by_aspek.nilai_akhir', 'DESC');
        
        if (isset($data['limit']) && !empty($data['limit'])) {
            $builder->limit($data['limit']);
        }
        if (isset($data['limit']) && $data['limit'] == 1) return $builder->get()->getRow();
        else return $builder->get()->getResult();
    }

    function findDetailNilai($data = null)
    {
        $builder = $this->db->table('vw_rekap_by_spirit');
        $builder->select('vw_rekap_by_spirit.tahun,
            vw_rekap_by_spirit.id_unit,
            vw_rekap_by_spirit.unit,
            vw_rekap_by_spirit.nilai,
            vw_rekap_by_spirit.nilai_huruf,
            vw_rekap_by_spirit.predikat,
            vw_rekap_by_aspek.aspek,
            vw_rekap_by_aspek.nilai_akhir,
            vw_rekap_by_aspek.nilai_maks,
            vw_rekap_by_aspek.total_nilai,
            m_indikator.id_aspek,
            m_indikator.id_indikator,
            m_aspek.nilai_maks as bobot,
            m_indikator.opd_pengampu,
            m_indikator.indikator,
            evaluasi.nilai_akhir as nilai_aspek,
            evaluasi.bobot as bobot_aspek,
            evaluasi.nilai_awal,
            evaluasi.nilai_konversi');
        $builder->join('vw_rekap_by_aspek', 'vw_rekap_by_spirit.tahun = vw_rekap_by_aspek.tahun AND vw_rekap_by_spirit.id_unit = vw_rekap_by_aspek.id_unit');
        $builder->join('evaluasi', 'vw_rekap_by_aspek.id_unit = evaluasi.id_unit AND vw_rekap_by_aspek.tahun = evaluasi.tahun');
        $builder->join('m_indikator', 'evaluasi.id_indikator = m_indikator.id_indikator AND vw_rekap_by_aspek.id_aspek = m_indikator.id_aspek');
        $builder->join('m_aspek', 'm_indikator.id_aspek = m_aspek.id_aspek');
        $builder->where('m_indikator.is_aktif', 1);
        if (isset($data['tahun']) && !empty($data['tahun'])) $builder->where('vw_rekap_by_spirit.tahun', $data['tahun']);
        if (isset($data['tag']) && !empty($data['tag'])) $builder->where('vw_rekap_by_spirit.tag', $data['tag']);
        if (isset($data['id_unit']) && !empty($data['id_unit'])) {
            $where = " (vw_rekap_by_spirit.id_unit='" . $data['id_unit'] . "' OR mid(md5(vw_rekap_by_spirit.id_unit),9,6)='" . $data['id_unit'] . "')";
            $builder->where($where);
            //$builder->where('vw_rekap_by_spirit.id_unit',$data['id_unit']);
        }
        if (isset($data['id_aspek']) && !empty($data['id_aspek'])) $builder->where('vw_rekap_by_aspek.id_aspek', $data['id_aspek']);

        $builder->orderBy('m_indikator.id_aspek', 'ASC');
        $builder->orderBy('m_indikator.id_indikator', 'ASC');

        if (isset($data['limit']) && !empty($data['limit'])) {
            $builder->limit($data['limit']);
        }
        if (isset($data['limit']) && $data['limit'] == 1) return $builder->get()->getRow();
        else return $builder->get()->getResult();
    }

    function findDetailNilaiBaru($data = null)
    {
        $tags = ($data['tag'] != 'kab') ? 'opd' : 'kab';

        $builder = $this->db->table('m_indikator');
        $builder->where('m_indikator.periode', $data['tahun']);
        $builder->where('m_indikator.tag', $tags);
        $builder->where('m_indikator.is_aktif', '1');
        $builder->join('m_aspek', 'm_aspek.id_aspek = m_indikator.id_aspek');
        $builder->join('vw_rekap_by_aspek', 'm_aspek.id_aspek = vw_rekap_by_aspek.id_aspek and vw_rekap_by_aspek.tahun = "'.$data['tahun'].'" and vw_rekap_by_aspek.id_unit = '.$data['id_unit'], 'left');
        $builder->join('vw_rekap_by_spirit', 'vw_rekap_by_spirit.tahun = "'.$data['tahun'].'" and vw_rekap_by_spirit.id_unit = '.$data['id_unit'], 'left');
        $builder->join('evaluasi', 'evaluasi.id_indikator = m_indikator.id_indikator and evaluasi.tahun = "'.$data['tahun'].'" and evaluasi.id_unit = '.$data['id_unit'], 'left');
        $builder->select('
            m_aspek.aspek,
            coalesce(vw_rekap_by_aspek.nilai_akhir, 0) as nilai_akhir,
            coalesce(vw_rekap_by_aspek.nilai_maks, 0) as nilai_maks,
            coalesce(vw_rekap_by_aspek.total_nilai, 0) as total_nilai,
            vw_rekap_by_spirit.id_unit,
            vw_rekap_by_spirit.unit,
            vw_rekap_by_spirit.nilai,
            vw_rekap_by_spirit.nilai_huruf,
            vw_rekap_by_spirit.predikat,
            m_indikator.id_aspek,
            m_indikator.id_indikator,
            m_aspek.nilai_maks as bobot,
            m_indikator.opd_pengampu,
            m_indikator.indikator,
            m_indikator.keterangan,
            m_indikator.bobot as bobot_aspek,
            coalesce(evaluasi.nilai_akhir, 0)  as nilai_aspek,
            coalesce(evaluasi.nilai_awal, 0) as nilai_awal,
            coalesce(evaluasi.nilai_konversi, 0) as nilai_konversi,
            evaluasi.catatan_indikator,
            evaluasi.rekomendasi_indikator
        ');
        
        $builder->groupBy('m_indikator.id_indikator');
        $builder->orderBy('m_aspek.id_aspek', 'asc');
        return $builder->get()->getResult();
    }
}