<?php

namespace App\Service;

use Dompdf\Dompdf;
use Dompdf\Options;

class PdfService
{
    private Dompdf $dompdf;
    public function __construct()
    {
        $this->dompdf = new Dompdf();
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $this->dompdf->setOptions($pdfOptions);
    }

    public function showPdfFile(string $html): void
    {
        $this->initPdf($html);
        $this->dompdf->render();
        $this->dompdf->stream('details-person.pdf', [
            "Attachment" => false
        ]);
    }

    public function generatePdf(string $html): void
    {
        $this->initPdf($html);
        $this->dompdf->output();
    }

    private function initPdf(string $html): void
    {
        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper(size: 'A4');
    }
}