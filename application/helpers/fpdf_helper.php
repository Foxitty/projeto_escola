<?php
class MyPDF extends FPDF
{
    public function Header()
    {
        $this->SetY(10);

        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 5, utf8_decode('Escola primária Mágico de OZ'), 0, 1, 'C');


        $this->SetFont('Arial', 'I', 10);
        date_default_timezone_set('America/Sao_Paulo');
        $currentDateTime = date('d/m/Y H:i');

        $this->Cell(0, 5, $currentDateTime, 0, 1, 'R');


        $this->SetLineWidth(0.5);
        $this->Line(10, 20, 200, 20);

        $this->Ln(3);
    }

    public function Footer()
    {
        $this->SetY(-15);

        $this->SetDrawColor(128, 128, 128);
        $this->Line(10, $this->GetY(), 200, $this->GetY());

        $this->Image('public/images/IDPI - Azul.png', 10, $this->GetY() - 8, 20);

        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(128, 128, 128);

        $this->SetX(30);
        $this->Cell(0, 10, utf8_decode('Relatório emitido por IDPI - Instituto de Desenvolvimento, Pesquisa e Inovação'), 0, 0, 'C');

        $this->SetX(200);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo(), 0, 0, 'R');
    }
}