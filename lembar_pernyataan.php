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
    $pdf->SetTitle('Lembar Pernyataan'); 
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
	 $id=$_REQUEST['id'];
    $sql=mysql_query("SELECT a.pilih_judul, b.nim, b.nama, 
					(SELECT dosen.nama FROM dosen WHERE dosen.id_dosen=a.id_pembimbing1) as dosen1,
					(SELECT dosen.nip FROM dosen WHERE dosen.id_dosen=a.id_pembimbing1) as nip1,
					(SELECT dosen.nip FROM dosen WHERE dosen.id_dosen=a.id_pembimbing2) as nip2,
					(SELECT dosen.nama FROM dosen WHERE dosen.id_dosen=a.id_pembimbing2) as dosen2
					 FROM pengajuan_proposal_skripsi as a
					LEFT JOIN mahasiswa as b ON a.nim=b.nim
					WHERE a.id='".$id."'
"); 
    $dt=mysql_fetch_array($sql);
 //------------------------------------------------------------

    $judul="";
    $pdf->AddPage('P', 'A4'); 
         $tbl2 ='<style>
                    th{
                        align:center;
                        font-weight:bold;
                        background-color:#d9d6d6;
                    } 
                    table
                    { 
                        line-height: 190%;
                    }
                </style> 
            <table border="0" style="width:100%;"> 
                  <tr>   
                    <td   align="center">
                        <h4>
                            LEMBAR PERNYATAAN JUDUL SKRIPSI 
                        </h4>  <br/> <br/> <br/> <br/><br/> 
                    </td>
                 </tr>   
                 <tr>
                    <td>Dengan melalui beberapa bimbingan terhadap judul proposal skripsi yang diajukan oleh saudara
                    </td>
                 </tr>
            </table> 
            <table border="0" style="width:100%;"> 
                <tr>
                    <td style="width:10%;">Nama</td>
                    <td>: '.$dt['nama'].'</td>
                </tr>  
                <tr>
                    <td>NIM</td>
                    <td>: '.$dt['nim'].'</td>
                </tr>  
                <tr>
                    <td colspan="2"  style="width:100%;">kami menyetujui judul proposal skripsi yang diajukan oleh mahasiswa tersebut dengan judul yaitu: </td> 
                </tr>    
                <tr>
                    <td  colspan="2" ><b>"'.$dt['pilih_judul'].'"</b></td>
                </tr>   
                <tr>
                    <td colspan="2"  style="width:100%;">Demikian pernyataan ini dibuat untuk dapat dipergunakan sebagaimana mestinya. <br/> </td>
                </tr>
                <tr>
                    <td></td>
                    <td align="center">Serang, '.date('d-m-Y').' </td>
                 </tr> 
                 <tr>
                    <td align="center"> Dosen Pembimbing 1  </td>
                    <td align="center">Dosen Pembimbing 2 </td>
                 </tr><br/> <br/><br/>  
                 <tr>
                    <td align="center">('.$dt['dosen1'].') </td>
                    <td align="center">('.$dt['dosen2'].') </td>
                 </tr> 
                 <tr>
                    <td align="center">NIP. '.$dt['nip1'].'</td>
                    <td align="center">NIP. '.$dt['nip2'].'</td> 
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