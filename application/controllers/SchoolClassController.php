<?php
defined('BASEPATH') or exit('Ação não permitida.');

class SchoolClassController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('SchoolClassModel');
    }
    public function list()
    {
        $data['school_classes'] = $this->SchoolClassModel->list();
        $data['title'] = 'Turmas';

        $this->load->helper('gender_helper');
        $this->load->view('includes/header', $data);
        $this->load->view('school-class/index', $data);
        $this->load->view('includes/modal_school_class');
        $this->load->view('includes/modal_enrollment ');
        $this->load->view('includes/footer');

    }
    public function create()
    {
        $school_class = $this->input->post();
        $this->load->model('SchoolClassModel');
        $school_class['class_name'] = ucwords(strtolower($school_class['class_name']));

        $this->SchoolClassModel->create($school_class);

        $this->session->set_flashdata('message', 'Turma criada com sucesso!');
        redirect('turmas');

    }
    public function show($id)
    {
        $this->load->model('SchoolClassModel');
        $school_class = $this->SchoolClassModel->show($id);

        if ($school_class) {
            $this->output->set_content_type('application/json')->set_output(json_encode($school_class));
        } else {
            show_404();
        }
    }
    public function edit($id)
    {
        $school_class = $this->input->post();
        $this->load->model('SchoolClassModel');
        $this->SchoolClassModel->edit($id, $school_class);

        $this->session->set_flashdata('message', 'Turma editada com sucesso!');
        redirect('turmas');

    }
    public function delete($id)
    {
        $school_class = $this->input->post();
        $this->load->model('SchoolClassModel');
        $this->SchoolClassModel->delete($id, $school_class);

        $this->session->set_flashdata('message', 'Turma deletada com sucesso!');
        redirect('turmas');
    }
}
