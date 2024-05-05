<?php

require_once ('./application/enum/Enum.php');

class StudentModel extends CI_Model
{
    public function list()
    {
        $condition = array('status' => Status::Active);
        $query = $this->db->get_where('students', $condition);
        return $query->result_array();

    }
    public function create($student)
    {
        $this->db->insert('students', $student);

    }
    public function show($id)
    {
        $condition = array('id' => $id);
        return $this->db->get_where('students', $condition)->row_array();

    }
    public function showLastId()
    {
        $query = $this->db->select('id')
            ->from('students')
            ->order_by('id', 'desc')
            ->limit(1)
            ->get();

        if ($query->num_rows() > 0) {
            return $query->row()->id;
        } else {
            return 0;
        }
    }
    public function edit($id, $student)
    {
        date_default_timezone_set('America/Sao_Paulo');
        $current_datetime = date('Y-m-d H:i:s');
        $student['updated_at'] = $current_datetime;
        $this->db->where('id', $id);
        return $this->db->update('students', $student);

    }
    public function delete($id, $student)
    {
        date_default_timezone_set('America/Sao_Paulo');
        $current_datetime = date('Y-m-d H:i:s');

        $student['updated_at'] = $current_datetime;
        $this->db->where('id', $id);
        $this->db->update('students', ['status' => Status::Inactive]);

        $this->db->where('student_id', $id);
        $this->db->update('enrollment', [
            'status' => Status::Inactive,
            'updated_at' => $current_datetime
        ]);

        return $this->db->affected_rows();

    }
}