<?php

namespace LimeTrail\Bundle\Exporter;

use APY\DataGridBundle\Grid\Export\Export;

class CsvExporter extends Export
{
    /*
     * Export::__construct parameters
     * title string
     * fileName string
     * params array
     * charset string
     */
    
    public function computeData($grid)
    {
        $data = $this->getFlatGridData($grid);
        
        $outstream = fopen("php://temp", 'r+');
        
        foreach($data AS $row) {
            fputcsv($outstream, $row, ',', '"');
        }
        
        rewind($outstream);
        $content = '';
        while (($buffer = fgets($outstream)) !== false) {
            $content .= $buffer;
        }
        
        fclose($outstream);
        
        $this->content = $content;
    }
    
    protected $fileExtension = 'csv';
    
    protected $mimeType = 'text/comma-separated-values';
}
