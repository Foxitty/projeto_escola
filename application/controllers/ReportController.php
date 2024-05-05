<?php
defined('BASEPATH') or exit('Ação não permitida.');

class ReportController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('SchoolClassModel');
        $this->load->model('EnrollmentModel');
    }
    public function turma($school_class_id)
    {
        $this->load->helper('gender_helper');
        $this->load->helper('fpdf_helper');

        $students = $this->EnrollmentModel->studentsByClass($school_class_id);
        $school_class = $this->SchoolClassModel->show($school_class_id);


        $this->load->library('MyPDF');

        $pdf = new MyPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 12);

        $pdf->Cell(0, 10, utf8_decode('Relatório da Turma -' . $school_class['class_name'] . ''), 0, 1, 'C');
        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 10);

        $cellWidth = 190 / 3;

        $pdf->Cell($cellWidth, 10, utf8_decode('Nome da Turma: ' . $school_class['class_name']), 0, 0, 'L');
        $pdf->Cell($cellWidth, 10, utf8_decode('Sala: ' . $school_class['living_room']), 0, 0, 'L');
        $pdf->Cell($cellWidth, 10, utf8_decode('Capacidade: ' . $school_class['capacity']), 0, 1, 'L');

        $pdf->Cell($cellWidth, 10, utf8_decode('Ano letivo: ' . $school_class['school_year']), 0, 0, 'L');
        $pdf->Cell($cellWidth, 10, utf8_decode('Data de Criação: ' . date('d/m/Y', strtotime($school_class['created_at']))), 0, 0, 'L');
        $pdf->Cell($cellWidth, 10, '', 0, 1, 'L');


        $pdf->Ln(10);

        $pdf->Cell(40, 10, utf8_decode('Matrícula'), 1);
        $pdf->Cell(80, 10, utf8_decode('Nome'), 1);
        $pdf->Cell(40, 10, utf8_decode('Idade'), 1);
        $pdf->Cell(30, 10, utf8_decode('Gênero'), 1);
        $pdf->Ln();

        foreach ($students as $student) {
            $age = $this->calculateAge($student['birthday']);

            $pdf->Cell(40, 10, utf8_decode($student['registration_number']), 1);
            $pdf->Cell(80, 10, utf8_decode($student['name']), 1);
            $pdf->Cell(40, 10, utf8_decode((string) $age), 1);
            $pdf->Cell(30, 10, utf8_decode(getGenderDescription($student['gender'])), 1);
            $pdf->Ln();
        }

        $pdf->Output('I', 'relatorio_turma_' . $school_class_id . '.pdf');
    }

    private function calculateAge($birthday)
    {
        $birthDate = new DateTime($birthday);
        $today = new DateTime();
        $age = $today->diff($birthDate)->y;
        return $age;
    }
}