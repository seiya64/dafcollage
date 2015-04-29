<?php
//============================================================+
// File name   : example_062.php
// Begin       : 2010-08-25
// Last Update : 2013-05-14
//
// Description : Example 062 for TCPDF class
//               XObject Template
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: XObject Template
 * @author Nicola Asuni
 * @since 2010-08-25
 */
// Include the main TCPDF library (search for installation path).
require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once($CFG->libdir.'/tcpdf/tcpdf.php');
require_once($CFG->libdir.'/tcpdf/config/lang/eng.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

$pdf->SetFont('helvetica', '', 9);
$pdf->AddPage();
$html = '<html>
<head></head>
<body><table border="1">
<tr><th>name</th>
<th>company</th></tr>
<tr>
<td>hello</td>
<td>xx technologies</td>
</tr>
</table>
</body>
</html>';
$pdf->writeHTML($html, true, 0, true, 0);
$pdf->lastPage();
$pdf->Output('htmlout.pdf', 'D');
?>
