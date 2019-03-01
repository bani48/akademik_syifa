<?php 
    mysql_connect('localhost','root','');
    mysql_select_db('akademik_syifa');
    // Include the main TCPDF library (search for installation path).
    require_once('asset/tcpdf/tcpdf_include.php'); 
    require_once('asset/tcpdf/tcpdf.php');
    // create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    // set document information
    $pdf->SetCreator(PDF_CREATOR); 
    $pdf->SetTitle('Kartu Bimbingan'); 
    $pdf->SetKeywords('TCPDF, PDF, Report, Surat');
    // set margins 
    //$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 
    // set some language-dependent strings (optional)  
    if (@file_exists(dirname(__FILE__).'/lang/eng.php'))
    {
    	require_once(dirname(__FILE__).'/lang/eng.php');
    	$pdf->setLanguageArray($l);
    }  
 //   $sql=mysql_query(""); 
   // $dt=mysql_fetch_array($sql);
 //------------------------------------------------------------
// $id=$_REQUEST['id_pi'];
    $pdf->AddPage('P', 'A4'); 
         $tbl2 ='<style>
                    th{
                        align:center;
                        font-weight:bold;
                        background-color:#d9d6d6;
                    } 
                </style> 
            <table border="0" style="width:100%;"> 
                  <tr>   
                    <td   align="center"><h4>
                            KARTU BIMBINGAN PROPOSAL SKRIPSI JURUSAN PENDIDIKAN TEKNIK ELEKTRO  	FKIP UNTIRTA 2018 
                        </h4>   
                    </td>
                 </tr>   
            </table> 
            <table border="0" style="width:100%;"> 
                 <tr>
                    <td style="width:17%;">Nama </td>
                    <td>:</td>
                    <td>&nbsp;</td>
                    <td style="width:23%;">Dosen Pembimbing 1 </td>
                    <td style="width:28%;">:</td>
                 </tr>
                 <tr>
                    <td>NIM </td>
                    <td>:</td>
                    <td>&nbsp;</td>
                    <td>Dosen Pembimbing 2 </td>
                    <td>:</td>
                 </tr>
                 <tr>
                    <td>Judul Proposal </td>
                    <td colspan="3">:</td> 
                 </tr><br/>
                 
                 <tr>
                    <td colspan="5">
                        <table border="1">
                            <tr>
                                <th width="5%">No.</th>
                                <th width="20%">Hari/Tanggal</th>
                                <th  width="40%">Catatan Bimbingan</th>
                                <th>Tanda Tangan Dosen Pembimbing</th> 
                            </tr>';
                            $i=1;
                            for($i=1;$i<=5;$i++)
                            {
                              $tbl2 .='<tr>
                                            <td height="130px;">'.$i.'</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                       </tr>';  
                            }
                        $tbl2 .='    
                        </table>
                    </td><br/>
                    
                 </tr> 
                 <tr><td colspan="3" align="right"></td>
                    <td align="center">Mengetahui</td>
                 </tr>
                 <tr><td colspan="3" align="right"></td>
                    <td align="center">Ketua Jurusan  <br/><br/><br/></td>
                 </tr>
                 <tr><td colspan="3" align="right"></td>
                    <td align="center">( ............................... )</td>
                 </tr>
                 
            </table> 
            ';           
        $pdf->writeHTML($tbl2, true, false, true, false, '');
        // reset pointer to the last page
        $pdf->lastPage();
        //Close and output PDF document
        $pdf->Output('surat_praktek_industri.pdf', 'I');
//=================================================================+
// END OF FILE
//=================================================================+