<?php
defined('BASEPATH') or exit('Ação não permitida.');

class EnrollmentController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('EnrollmentModel');
    }

    public function list($school_class_id)
    {
        $students = $this->EnrollmentModel->studentsByClass($school_class_id);
        echo json_encode($students);

    }
    public function create()
    {
        $students_json = $this->input->post('students');
        $students = json_decode($students_json, true);

        $removed_students_json = $this->input->post('removed_students');
        $removed_students = json_decode($removed_students_json, true);

        $school_class_id = $this->input->post('school_class_id');

        $duplicate_students = [];

        if ($students && is_array($students)) {
            foreach ($students as $student) {
                if ($this->EnrollmentModel->isStudentInAnotherClass($student['id'], $school_class_id)) {
                    $duplicate_students[] = $student['registration_number'];
                }
            }
        }

        if (count($duplicate_students) > 0) {
            $message = 'Os seguintes alunos já estão matriculados em outra turma: ' . implode(', ', $duplicate_students);
            $this->session->set_flashdata('message', $message);
            redirect('turmas');
            return;
        }

        if ($removed_students && is_array($removed_students)) {
            foreach ($removed_students as $student) {
                $student_id = $student['id'];
                $this->EnrollmentModel->delete($student_id, $school_class_id);
            }
            $this->session->set_flashdata('message', 'Turma atualizada com sucesso!');
        } else {
            if ($students && is_array($students)) {
                foreach ($students as $student) {
                    $dataEnrollment = [
                        'school_class_id' => $school_class_id,
                        'student_id' => $student['id']
                    ];
                    $this->EnrollmentModel->create($dataEnrollment);
                }
            }
            $this->session->set_flashdata('message', 'Aluno incluído na turma com sucesso!');
        }

        redirect('turmas');
    }
    public function showByRegistration($id)
    {
        $enrollment = $this->EnrollmentModel->showByRegistration($id);

        if ($enrollment) {
            $this->output->set_content_type('application/json')->set_output(json_encode($enrollment));
        } else {
            show_404();
        }
    }
}
