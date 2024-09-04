<?php
/**
 * PHPExcel
 *
 * Copyright (c) 2006 - 2015 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2015 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    ##VERSION##, ##DATE##
 */

    require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';
    $objPHPExcel = new PHPExcel();

	$styleArray = array(
    'borders' => array(
        'outline' => array(
		    'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => 'DDDDDD'),
				'size'  => 10
            )
        )
    ),
	'font'  => array(
        'bold'  => true,
        'color' => array('rgb' => '000000'),
        'size'  => 11,
        'name'  => 'Calibri'
    )
	);

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Sr. No.');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'Name')
		->setCellValue('C1', 'Aadhar No.')
		->setCellValue('D1', 'Mobile No.')
		->setCellValue('E1', 'Father/Husband  name')
		->setCellValue('F1', 'Village')
		->setCellValue('G1', 'P.O.')
		->setCellValue('H1', 'Block')
		->setCellValue('I1', 'District')
		->setCellValue('J1', 'Scheme Name')
		->setCellValue('K1', 'Scheme Sub-Category (Mirco/Large/Medium/Small)')
		->setCellValue('L1', 'Project Name')
		->setCellValue('M1', 'Date of Disbursment')
		->setCellValue('N1', 'Balance as on 31-03-2019')
	    ->setCellValue('S1', 'Balance as on 31-03-2019')
        ->setCellValue('X1', 'Balance as on 31-03-2019')
	
	    ->setCellValue('N2', 'Term Loan')
        ->setCellValue('S2', 'M.M.Loan')
		->setCellValue('X2', 'Hp Shops loan Without Int')
		
		->setCellValue('N3', 'Principal')
		->setCellValue('O3', 'Intt')
		->setCellValue('P3', 'P.Intt')
		->setCellValue('Q3', 'Notice')
		->setCellValue('R3', 'Total')
		->setCellValue('S3', 'Principal')
		->setCellValue('T3', 'Intt')
		->setCellValue('U3', 'P.Intt')
		->setCellValue('V3', 'Notice')
		->setCellValue('W3', 'Total')
		->setCellValue('X3', 'Principal')
		->setCellValue('Y3', 'Notice')
		->setCellValue('Z3', 'Total')
		
		->setCellValue('A4', '1')
		->setCellValue('B4', '2')
		->setCellValue('C4', '3')
		->setCellValue('D4', '4')
		->setCellValue('E4', '5')
		->setCellValue('F4', '6')
		->setCellValue('G4', '7')
		->setCellValue('H4', '8')
		->setCellValue('I4', '9')
		->setCellValue('J4', '10')
		->setCellValue('K4', '11')
		->setCellValue('L4', '12')
		->setCellValue('M4', '13')
		->setCellValue('N4', '14')
		->setCellValue('O4', '15')
		->setCellValue('P4', '16')
		->setCellValue('Q4', '17')
		->setCellValue('R4', '18')
		->setCellValue('S4', '19')
		->setCellValue('T4', '20')
		->setCellValue('U4', '21')
		->setCellValue('V4', '22')
		->setCellValue('W4', '23')
		->setCellValue('X4', '24')
		->setCellValue('Y4', '25')
		->setCellValue('Z4', '26');
        
		$objPHPExcel->getActiveSheet()->mergeCells('A1:A3');
		$objPHPExcel->getActiveSheet()->mergeCells('B1:B3');
		$objPHPExcel->getActiveSheet()->mergeCells('C1:C3');
		$objPHPExcel->getActiveSheet()->mergeCells('D1:D3');
		$objPHPExcel->getActiveSheet()->mergeCells('E1:E3');
		$objPHPExcel->getActiveSheet()->mergeCells('F1:F3');
		$objPHPExcel->getActiveSheet()->mergeCells('G1:G3');
		$objPHPExcel->getActiveSheet()->mergeCells('H1:H3');
		$objPHPExcel->getActiveSheet()->mergeCells('I1:I3');
		$objPHPExcel->getActiveSheet()->mergeCells('J1:J3');
		$objPHPExcel->getActiveSheet()->mergeCells('K1:K3');
		$objPHPExcel->getActiveSheet()->mergeCells('L1:L3');
		$objPHPExcel->getActiveSheet()->mergeCells('M1:M3');
		$objPHPExcel->getActiveSheet()->mergeCells('N1:R1');
		$objPHPExcel->getActiveSheet()->mergeCells('S1:W1');
		$objPHPExcel->getActiveSheet()->mergeCells('X1:Z1');
		$objPHPExcel->getActiveSheet()->mergeCells('N2:R2');
		$objPHPExcel->getActiveSheet()->mergeCells('S2:W2');
		$objPHPExcel->getActiveSheet()->mergeCells('X2:Z2');
		
		$objPHPExcel->getActiveSheet()->getStyle('A1:Z4')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('N1:R1')->getAlignment()->setHorizontal('center');
		$objPHPExcel->getActiveSheet()->getStyle('N1:R1')->getAlignment()->setVertical('center');
		$objPHPExcel->getActiveSheet()->getStyle('S1:W1')->getAlignment()->setHorizontal('center');
		$objPHPExcel->getActiveSheet()->getStyle('S1:W1')->getAlignment()->setVertical('center');
		$objPHPExcel->getActiveSheet()->getStyle('X1:Z1')->getAlignment()->setHorizontal('center');
		$objPHPExcel->getActiveSheet()->getStyle('X1:Z1')->getAlignment()->setVertical('center');
		$objPHPExcel->getActiveSheet()->getStyle('N2:R2')->getAlignment()->setHorizontal('center');
		$objPHPExcel->getActiveSheet()->getStyle('N2:R2')->getAlignment()->setVertical('center');
		$objPHPExcel->getActiveSheet()->getStyle('S2:W2')->getAlignment()->setHorizontal('center');
		$objPHPExcel->getActiveSheet()->getStyle('S2:W2')->getAlignment()->setVertical('center');
		$objPHPExcel->getActiveSheet()->getStyle('X2:Z2')->getAlignment()->setHorizontal('center');
		$objPHPExcel->getActiveSheet()->getStyle('X2:Z2')->getAlignment()->setVertical('center');
		$objPHPExcel->getActiveSheet()->getStyle('A4:Z4')->getAlignment()->setHorizontal('center');
        $objPHPExcel->getActiveSheet()->getStyle('N3:Z3')->getAlignment()->setHorizontal('center');
        $objPHPExcel->getActiveSheet()->getStyle('A1:M1')->getAlignment()->setHorizontal('center');
		$objPHPExcel->getActiveSheet()->getStyle('A1:M1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
		

		$objPHPExcel->getActiveSheet()->getStyle("A1:Z4")->applyFromArray(
        array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => '000000')
            )
        )
        )
        );



// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client's web browser (Xlsx)

$filename=date('d-m-Y',time());
$filename = "past_loan_details_".$filename.".xlsx";	
$objPHPExcel->getActiveSheet()->setTitle('Past Loan details');
header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=\"$filename\"");
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0

$callStartTime = microtime(true);
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>