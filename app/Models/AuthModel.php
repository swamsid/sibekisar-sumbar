<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends Model{

    function insertData($data=null){
        $builder = $this->db->table('coms_user');
        return $builder->ignore(true)->insert($data);
    }

    function updateData($data=null, $where=null){
        $builder = $this->db->table('coms_user');
        return $builder->ignore(true)->update($data, $where);
    }

    public function find($data =null)
    {
        $builder = $this->db->table('coms_user');
        $builder->select('coms_user.*');
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

        $query = $builder->get()->getRow();
        return $query;
    }
}