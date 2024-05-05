<?php

require_once ('./application/enum/Enum.php');

class SchoolClassModel extends CI_Model
{
    public function list()
    {
        $condition = array('status' => Status::Active);
        $query = $this->db->get_where('school_class', $condition);
        return $query->result_array();

    }
    public function create($data)
    {
        $this->db->insert('school_class', $data);

    }
    public function show($id)
    {
        $condition = array('id' => $id);
        return $this->db->get_where('school_class', $condition)->row_array();

    }
    public function edit($id, $data)
    {
        date_default_timezone_set('America/Sao_Paulo');
        $current_datetime = date('Y-m-d H:i:s');
        $data['updated_at'] = $current_datetime;
        $this->db->where('id', $id);
        return $this->db->update('school_class', $data);

    }
    public function delete($id, $data)
    {
        date_default_timezone_set('America/Sao_Paulo');
        $current_datetime = date('Y-m-d H:i:s');
        $data['updated_at'] = $current_datetime;
        $this->db->where('id', $id);
        return $this->db->update('school_class', ['status' => Status::Inactive]);

    }
}
