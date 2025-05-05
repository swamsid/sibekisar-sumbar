<?php
namespace App\Models;

use CodeIgniter\Model;

class ApiModel extends Model
{

    function getPd($where){
        $builder = $this->db->table('m_unit');
        $builder->where($where);

        return  $builder->get()->getRow();
    }
}