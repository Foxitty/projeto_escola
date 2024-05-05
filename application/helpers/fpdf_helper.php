<?php
class MyPDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 12);

        $this->Cell(0, 10, utf8_decode('Escola primária Mágico de OZ'), 0, 1, 'C');


        $this->SetLineWidth(0.5);
        $this->Line(10, 20, 200, 20);

        $this->Ln(3);
    }

    function Footer()
    {

        $this->SetY(-15);

        $this->SetLineWidth(0.5);
        $this->Line(10, $this->GetY(), 200, $this->GetY());

        $this->SetFont('Arial', 'I', 8);

        $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo()), 0, 0, 'C');
    }
}