<?php
namespace App\Models;

use CodeIgniter\Model;

class MasterModel extends Model
{

    /** m unit kerja */
    function getMUnit($data =null){
        $builder = $this->db->table('m_unit');
        $builder->select('m_unit.*, mid(md5(m_unit.id_unit),9,6) as id_unit_hash');
        if(isset($data['kategori_unit']) && !empty($data['kategori_unit'])) $builder->where('m_unit.kategori_unit', $data['kategori_unit']);

        if(isset($data['is_aktif']) && !empty($data['is_aktif'])) $builder->where('m_unit.is_aktif', $data['is_aktif']);
        if(isset($data['kode_unit']) && !empty($data['kode_unit'])) $builder->where('m_unit.kode_unit', $data['kode_unit']);

        if(isset($data['id_unit']) && !empty($data['id_unit'])){
            $builder->where('id_unit', $data['id_unit']);
        }

        if(isset($data['id_unit_hash']) && !empty($data['id_unit_hash'])){
            $where = " (mid(md5(id_unit),9,6)='".$data['id_unit_hash']."')";
            $builder->where($where);
        }

        return  $builder->get()->getRow();
    }

    function findMUnit($data =null){
        $builder = $this->db->table('m_unit');
        $builder->select('m_unit.*, mid(md5(m_unit.id_unit),9,6) as id_unit_hash');
        $builder->where('m_unit.is_aktif <> 3');
        if(isset($data['id_unit']) && !empty($data['id_unit'])){
            $builder->where('id_unit', $data['id_unit']);
        }

        if(isset($data['id_unit_hash']) && !empty($data['id_unit_hash'])){
            $where = " (mid(md5(id_unit),9,6)='".$data['id_unit_hash']."')";
            $builder->where($where);
        }

        if(isset($data['id_parent']) && !empty($data['id_parent'])) $builder->where('m_unit.id_unit', $data['id_parent']);
        if(isset($data['is_aktif']) && !empty($data['is_aktif'])) $builder->where('m_unit.is_aktif', $data['is_aktif']);
        if(isset($data['kode_unit']) && !empty($data['kode_unit'])) $builder->where('m_unit.kode_unit', $data['kode_unit']);

        if(isset($data['kategori_unit']) && !empty($data['kategori_unit'])){
            if($data['kategori_unit'] == 'opd')
                $builder->where('m_unit.kategori_unit <>', 'kab');
            else
                $builder->where('m_unit.kategori_unit', $data['kategori_unit']);
        }

        if(isset($data['search']) && !empty($data['search'])){
            $builder->where("(m_unit.unit like '%".$data['search']."%')");
        }

        $builder->orderBy('kategori_unit');
        $builder->orderBy('unit');

        if(isset($data['limit']) && !empty($data['limit'])){
            if (isset($data['offset']) && !empty($data['offset'])) {
                $builder->offset($data['offset']);
            }
            $builder->limit($data['limit']);
        }

        $query   = $builder->get()->getResult();
        return $query;
    }


    function insertMUnit($data=null){
        $builder = $this->db->table('m_unit');
        $builder->replace($data);
        return $builder;
    }

    function updateMUnit($data=null,$where=null){
        $builder = $this->db->table('m_unit');
        return $builder->update($data, $where);
    }

    /** users */
    public function findMUsers($data =null)
    {
        $builder = $this->db->table('coms_user');
        $builder->select('coms_user.*,m_unit.unit, m_unit.kategori_unit as tag, coms_role.role');
        //$builder->join("coms_user_role", "coms_user.id_user = coms_user_role.id_user");
        $builder->join("coms_role", "coms_user.id_role = coms_role.id_role");
        $builder->join("m_unit", "coms_user.id_unit = m_unit.id_unit","left");
        if (isset($data['id_user']) && !empty($data['id_user'])) {
            $builder->where("coms_user.id_user='" . $data['id_user'] . "'");
        }
        if (isset($data['email']) && !empty($data['email'])) {
            $builder->where("coms_user.email='" . $data['email'] . "'");
        }
        if (isset($data['username']) && !empty($data['username'])) {
            $builder->where("coms_user.username='" . $data['username'] . "'");
        }
        if (isset($data['is_aktif']) && !empty($data['is_aktif'])) $builder->where('coms_user.is_aktif', $data['is_aktif']);

        $query = $builder->get()->getResult();
        return $query;
    }


    public function findMUsersRole($data =null){
        $builder = $this->db->table('coms_user_role');
        $builder->select('coms_user_role.*, coms_role.role');
        $builder->join("coms_role", "coms_user_role.id_role = coms_role.id_role");
        if (isset($data['id_user']) && !empty($data['id_user'])) {
            $builder->where("id_user='" . $data['id_user'] . "'");
        }

        $query = $builder->get()->getResult();
        return $query;
    }

    public function findMUsersUnit($data =null){
        $builder = $this->db->table('coms_user_unit');
        $builder->select('coms_user_unit.*, m_unit.*');
        $builder->join("m_unit", "m_unit.id_unit = coms_user_unit.id_unit");
        if (isset($data['id_user']) && !empty($data['id_user'])) {
            $builder->where("id_user='" . $data['id_user'] . "'");
        }

        $query = $builder->get()->getResult();
        return $query;
    }

    function insertMUsers($data=null){
        $builder = $this->db->table('coms_user');
        $builder->replace($data);
        return $builder;
    }

    function updateMUsers($data=null,$where=null){
        $builder = $this->db->table('coms_user');
        return $builder->update($data, $where);
    }

    function insertMRole($data=null){
        $builder = $this->db->table('coms_user_role');
        $builder->replace($data);
        return $builder;
    }

    function insertMUserUnit($data=null){
        $builder = $this->db->table('coms_user_unit');
        $builder->replace($data);
        return $builder;
    }

    /** m aspek */
    function getMAspek($data =null){
        $builder = $this->db->table('m_aspek');
        $builder->select('m_aspek.*, mid(md5(m_aspek.id_aspek),9,6) as id_aspek_hash');

        if(isset($data['is_aktif']) && !empty($data['is_aktif'])) $builder->where('m_aspek.is_aktif', $data['is_aktif']);

        if(isset($data['id_aspek']) && !empty($data['id_aspek'])){
            $where = " (m_aspek.id_aspek='".$data['id_aspek']."' OR mid(md5(m_aspek.id_aspek),9,6)='".$data['id_aspek']."')";
            $builder->where($where);
        }

        return  $builder->get()->getRow();
    }

    function findMAspek($data =null){
        $builder = $this->db->table('m_aspek');
        $builder->select('m_aspek.*, mid(md5(m_aspek.id_aspek),9,6) as id_aspek_hash');
        $builder->where('m_aspek.is_aktif <> 3');
        if(isset($data['id_aspek']) && !empty($data['id_aspek'])){
            $where = " (m_aspek.id_aspek='".$data['id_aspek']."' OR mid(md5(m_aspek.id_aspek),9,6)='".$data['id_aspek']."')";
            $builder->where($where);
        }

        if(isset($data['is_aktif']) && !empty($data['is_aktif'])) $builder->where('m_aspek.is_aktif', $data['is_aktif']);

        if(isset($data['limit']) && !empty($data['limit'])){
            if (isset($data['offset']) && !empty($data['offset'])) {
                $builder->offset($data['offset']);
            }
            $builder->limit($data['limit']);
        }
        if(isset($data['search']) && !empty($data['search'])){
            $builder->where("(m_aspek.aspek like '%".$data['search']."%')");
        }

        $query   = $builder->get()->getResult();
        return $query;
    }

    /** m indikator */
    function getMIndikator($data =null){
        $builder = $this->db->table('m_indikator');
        $builder->select('m.aspek.aspek, m_aspek.nilai_maks, m_indikator.*, mid(md5(m_indikator.id_indikator),9,6) as id_indikator_hash');
        $builder->join('m_aspek', 'm_aspek.id_aspek = m_indikator.id_aspek');

        if(isset($data['is_aktif']) && !empty($data['is_aktif'])) $builder->where('m_indikator.is_aktif', $data['is_aktif']);

        if(isset($data['id_indikator']) && !empty($data['id_indikator'])){
            // $builder->where('m_unit.id_unit', $data['id_unit']);
            $where = " (m_indikator.id_indikator='".$data['id_indikator']."' OR mid(md5(m_indikator.id_indikator),9,6)='".$data['id_indikator']."')";
            $builder->where($where);
        }

        return  $builder->get()->getRow();
    }

    function findMIndikator($data =null){
        $builder = $this->db->table('m_indikator');
        $builder->select('m_aspek.aspek, m_aspek.tag, m_aspek.icon,
        m_aspek.nilai_maks,m_aspek.icon, m_indikator.*, mid(md5(m_indikator.id_indikator),9,6) as id_indikator_hash');
        $builder->join('m_aspek', 'm_aspek.id_aspek = m_indikator.id_aspek');
        $builder->where('m_indikator.is_aktif <> 3');
        $builder->where('m_indikator.periode = '.$data['periode']);

        if(isset($data['tag']) && !empty($data['tag'])) $builder->where('m_aspek.tag',$data['tag']);
        if(isset($data['id_unit']) && !empty($data['id_unit'])) $builder->where('m_indikator.id_opd',$data['id_unit']);
        if(isset($data['id_indikator']) && !empty($data['id_indikator'])){
            $where = " (m_indikator.id_indikator='".$data['id_indikator']."' OR mid(md5(m_indikator.id_indikator),9,6)='".$data['id_indikator']."')";
            $builder->where($where);
        }

        if(isset($data['is_aktif']) && !empty($data['is_aktif'])) $builder->where('m_indikator.is_aktif', $data['is_aktif']);

        if(isset($data['limit']) && !empty($data['limit'])){
            if (isset($data['offset']) && !empty($data['offset'])) {
                $builder->offset($data['offset']);
            }
            $builder->limit($data['limit']);
        }
        if(isset($data['search']) && !empty($data['search'])){
            $builder->where("(m_indikator.indikator like '%".$data['search']."%')");
        }

        $query   = $builder->get()->getResult();
        return $query;
    }

    function insertMIndikator($data=null){
        $builder = $this->db->table('m_indikator');
        return $builder->replace($data);
    }

    function updateMAspek($data=null,$where=null){
        $builder = $this->db->table('m_aspek');
        return $builder->ignore(true)->update($data, $where);
    }

    function generateid($id_aspek=null){
        $sql = "select concat('".$id_aspek."',RIGHT(concat( '00' , CAST(IFNULL(MAX(CAST(right(`id_indikator`,2) AS 
			unsigned)), 0) + 1 AS unsigned)),2)) as `last_mr` from m_indikator WHERE id_aspek='".$id_aspek."'";

        return $this->db->query($sql)->getRow();
    }

    /* m_periode */

    function getPeriode(){
        $builder = $this->db->table('m_periode');
        $builder->select('m_periode.*, count(evaluasi.id_evaluasi) as evaluasi');
        $builder->groupBy('id_periode');
        $builder->orderBy('tahun_periode', 'asc');
        $builder->join('evaluasi', 'evaluasi.tahun = m_periode.tahun_periode', 'left');

        return $builder->get()->getResult();
    }

    function getIdPeriode(){
        $query = '
            select max(id_periode) as id_periode from m_periode
        ';

        return $this->db->query($query)->getRow();
    }

    public function bobotTerakhir(){
        $query = "
        SELECT * FROM m_aspek 
        WHERE periode = (SELECT id_periode FROM m_periode WHERE tahun_periode = (SELECT MAX(tahun_periode) FROM m_periode))
        ";
        
        return $this->db->query($query)->getResult();
    }

    function findPeriode($where){
        $builder = $this->db->table('m_periode');
        $builder->select('m_periode.*');
        $builder->where($where);

        return $builder->get()->getRow();
    }

    function cekKodeAkses($where){
        $builder = $this->db->table('m_unit');
        $builder->select('id_unit, unit, kode_akses');
        $builder->where($where);

        return $builder->get()->getRow();
    }

    function insertPeriode($data = null){
        $builder = $this->db->table('m_periode');
        $builder->replace($data);
        
        return $builder;
    }

    function insertAspek($data = null){
        $builder = $this->db->table('m_aspek');
        $builder->insertBatch($data);
        
        return $builder;
    }

    function deletePeriode($data = null){
        $builder = $this->db->table('m_periode');
        $builder->delete($data);

        $builder2 = $this->db->table('m_indikator');
        $builder2->delete(['periode' => $data['tahun_periode']]);

        $builder3 = $this->db->table('m_aspek');
        $builder3->delete(['periode' => $data['tahun_periode']]);
        
        return $builder;
    }

    function updatePeriode($data = null, $where = null){
        $builder = $this->db->table('m_periode');
        $builder->update($data, $where);
        
        return $builder;
    }

    /** Aspek */
    function getAspek($data){
        $builder = $this->db->table('m_aspek');
        $builder->where('tag', $data['tag']);
        $builder->orderBy('id_aspek', 'asc');

        if(isset($data['periode']))
            $builder->where('periode', $data['periode']);

        return $builder->get()->getResult();
    }
}