<?php

if (!function_exists('readXlsx')) {
    function readXlsx($path)
    {
        $zip = new ZipArchive;
        if ($zip->open($path) === true) {
            $xml = $zip->getFromName('xl/sharedStrings.xml');
            $sharedStrings = [];

            if ($xml !== false) {
                $dom = new DOMDocument();
                $dom->loadXML($xml);
                foreach ($dom->getElementsByTagName('t') as $t) {
                    $sharedStrings[] = $t->nodeValue;
                }
            }

            $sheet = $zip->getFromName('xl/worksheets/sheet1.xml');
            if ($sheet !== false) {
                $dom = new DOMDocument();
                $dom->loadXML($sheet);
                $rows = $dom->getElementsByTagName('row');
                $data = [];

                foreach ($rows as $row) {
                    $rowData = [];
                    foreach ($row->getElementsByTagName('c') as $c) {
                        $v = $c->getElementsByTagName('v')->item(0)->nodeValue ?? '';
                        $type = $c->getAttribute('t');
                        if ($type === 's') {
                            $v = $sharedStrings[(int)$v] ?? $v;
                        }
                        $rowData[] = $v;
                    }
                    $data[] = $rowData;
                }
                return $data;
            }
        }
        return [];
    }
}

?>