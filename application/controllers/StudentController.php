<?php
defined('BASEPATH') or exit('Ação não permitida.');

class StudentController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('StudentModel');
        $this->load->model('EnrollmentModel');
    }

    public function list()
    {
        $data['title'] = 'Alunos';
        $data['students'] = $this->StudentModel->list();
        foreach ($data['students'] as $index => $student) {
            $className = $this->EnrollmentModel->classByStudent($student['id']);
            if ($className) {
                $data['students'][$index]['class'] = $className;
            } else {
                $data['students'][$index]['class'] = 'Sem turma no momento.';
            }

        }

        $this->load->helper('general_helper');
        $this->load->view('includes/header', $data);
        $this->load->view('student/index', $data);
        $this->load->view('includes/modal_student');
        $this->load->view('includes/footer');

    }

    public function create()
    {
        $student = $this->input->post();
        $student['name'] = ucwords(strtolower($student['name']));
        $student['father_name'] = ucwords(strtolower($student['father_name']));
        $student['mother_name'] = ucwords(strtolower($student['mother_name']));

        $last_student = $this->StudentModel->showLastId();
        $new_student_id = $last_student ? $last_student + 1 : 1;
        $current_month = date('m');
        $current_year = date('Y');
        $registration_number = sprintf("%d%s%s", $new_student_id, $current_month, $current_year);

        $student['registration_number'] = $registration_number;
        $this->StudentModel->create($student);

        $this->session->set_flashdata('message', 'Aluno criado com sucesso!');
        redirect('alunos');

    }

    public function show($id)
    {
        $student = $this->StudentModel->show($id);

        if ($student) {
            $this->output->set_content_type('application/json')->set_output(json_encode($student));
        } else {
            show_404();
        }
    }

    public function edit($id)
    {
        $student = $this->input->post();
        $student['name'] = ucwords(strtolower($student['name']));
        $student['father_name'] = ucwords(strtolower($student['father_name']));
        $student['mother_name'] = ucwords(strtolower($student['mother_name']));

        $this->StudentModel->edit($id, $student);

        $this->session->set_flashdata('message', 'Aluno editado com sucesso!');
        redirect('alunos');

    }

    public function delete($id)
    {
        $student = $this->input->post();
        $this->StudentModel->delete($id, $student);

        $this->session->set_flashdata('message', 'Aluno deletado com sucesso!');
        redirect('alunos');
    }
}