<?php

require_once ('./application/enum/Enum.php');

class EnrollmentModel extends CI_Model
{
    public function classByStudent($student_id)
    {
        $this->db->select('school_class.class_name');
        $this->db->from('enrollment');
        $this->db->join('school_class', 'enrollment.school_class_id = school_class.id');
        $this->db->where('enrollment.student_id', $student_id);
        $this->db->where('enrollment.status', Status::Active);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->row();

            return $result->class_name;
        } else {
            return null;
        }
    }
    public function create($data)
    {
        $this->db->where('student_id', $data['student_id']);
        $this->db->where('school_class_id', $data['school_class_id']);
        $this->db->where('status', Status::Active);

        $query = $this->db->get('enrollment');

        if ($query->num_rows() > 0) {
            return false;
        }

        return $this->db->insert('enrollment', $data);
    }
    public function studentsByClass($school_class_id)
    {
        $this->db->select('students.id, students.name, students.registration_number, students.birthday, students.gender, students.phone');
        $this->db->from('enrollment');
        $this->db->join('students', 'enrollment.student_id = students.id');
        $this->db->where('enrollment.school_class_id', $school_class_id);
        $this->db->where('enrollment.status', Status::Active);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return [];
        }
    }
    public function isStudentInAnotherClass($student_id, $school_class_id)
    {
        $this->db->select('school_class_id');
        $this->db->from('enrollment');
        $this->db->where('student_id', $student_id);
        $this->db->where('status', Status::Active);
        $this->db->where('school_class_id !=', $school_class_id);

        $query = $this->db->get();

        return $query->num_rows() > 0;
    }
    public function delete($student_id, $class_id)
    {
        date_default_timezone_set('America/Sao_Paulo');
        $current_datetime = date('Y-m-d H:i:s');

        $this->db->where('student_id', $student_id);
        $this->db->where('school_class_id', $class_id);

        return $this->db->update('enrollment', [
            'status' => Status::Inactive,
            'updated_at' => $current_datetime
        ]);
    }
}