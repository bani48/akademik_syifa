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
	 $id_ph=$_REQUEST['id_ph'];
    $sql=mysql_query("SELECT a.judul_proposal, b.nim, b.nama, 
					(SELECT dosen.nama FROM dosen WHERE dosen.id_dosen=a.id_pembimbing1) as dosen1,
					(SELECT dosen.nip FROM dosen WHERE dosen.id_dosen=a.id_pembimbing1) as nip1,
					(SELECT dosen.nip FROM dosen WHERE dosen.id_dosen=a.id_pembimbing2) as nip2,
					(SELECT dosen.nama FROM dosen WHERE dosen.id_dosen=a.id_pembimbing2) as dosen2,
                     a.no_hp                    
					 FROM pengajuan_hasil_seminar_skripsi as a
  					 LEFT JOIN mahasiswa as b ON a.nim=b.nim
					 WHERE a.id_ph='".$id_ph."'"); 
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
                            Bukti Verifikasi Persyaratan Seminar Skripsi Program Studi Pendidikan Teknik Elektro  
                        </h4>  
                    </td>
                 </tr>    
            </table> 
            <table border="0" style="width:100%;">  
                <tr>
                    <td style="width:25%;">Nama</td>
                    <td>: '.$dt['nama'].'</td>
                </tr> 
                <tr>
                    <td>NIM</td>
                    <td>: '.$dt['nim'].'</td>
                </tr>  
                <tr>
                    <td>No HP</td>
                    <td>: '.$dt['no_hp'].'</td>
                </tr> 
                <tr>
                    <td>Dosen Pembimbing I</td>
                    <td>: '.$dt['dosen1'].'</td>
                </tr> 
                <tr>
                    <td>Dosen Pembimbing II</td>
                    <td>: '.$dt['dosen2'].'</td>
                </tr>  
                <tr>
                    <td>Judul Seminar</td>
                    <td>: '.$dt['judul_proposal'].'</td>
                </tr>   
                 
            </table>
            <table border="1" width::100%>
                <thead>
                    <tr>
                        <th rowspan="2" width="5%">No</th>
                        <th rowspan="2" width="55%">Data</th>
                        <th colspan="2" width="20%">Berkas</th>
                        <th rowspan="2" width="20%">Ket</th> 
                    </tr> 
                    <tr>
                        <th>Ada</th>
                        <th>Tidak</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td width="5%">1</td>
                        <td width="55%">Form pendaftaran seminar seminar skripsi </td>
                        <td width="10%"></td>
                        <td width="10%"></td>
                        <td width="20%"></td>
                    </tr>
                    <tr>
                        <td width="5%">2</td>
                        <td width="55%">Form bukti serah terima laporan Praktik Industri </td>
                        <td width="10%"></td>
                        <td width="10%"></td>
                        <td width="20%"></td>
                    </tr>
                    <tr>
                        <td width="5%">3</td>
                        <td width="55%">Kartu bimbingan seminar skripsi </td>
                        <td width="10%"></td>
                        <td width="10%"></td>
                        <td width="20%"></td>
                    </tr>
                    <tr>
                        <td width="5%">4</td>
                        <td width="55%">Lembar pernyataan judul skripsi </td>
                        <td width="10%"></td>
                        <td width="10%"></td>
                        <td width="20%"></td>
                    </tr>
                    <tr>
                        <td width="5%">5</td>
                        <td width="55%">Surat pernyataan koreksi naskah  seminar  skripsi yang telah  dibaca minimal oleh 2 orang teman sejawat </td>
                        <td width="10%"></td>
                        <td width="10%"></td>
                        <td width="20%"></td>
                    </tr>
                    <tr>
                        <td width="5%">6</td>
                        <td width="55%">KRS semester yang sedang berjalan </td>
                        <td width="10%"></td>
                        <td width="10%"></td>
                        <td width="20%"></td>
                    </tr>
                    <tr>
                        <td width="5%">7</td>
                        <td width="55%">Transkrip nilai yang ditanda tangani dosen pembimbing akademik </td>
                        <td width="10%"></td>
                        <td width="10%"></td>
                        <td width="20%"></td>
                    </tr>
                    <tr>
                        <td width="5%">8</td>
                        <td width="55%">Form berita acara seminar seminar skripsi    </td>
                        <td width="10%"></td>
                        <td width="10%"></td>
                        <td width="20%"></td>
                    </tr>
                    <tr>
                        <td width="5%">9</td>
                        <td width="55%">Form nilai seminar seminar skripsi </td>
                        <td width="10%"></td>
                        <td width="10%"></td>
                        <td width="20%"></td>
                    </tr>
                    <tr>
                        <td width="5%">10</td>
                        <td width="55%">Naskah seminar skripsi yang sudah di acc dosen pembimbing (dijilid soft cover warna hijau muda dan digandakan sesuai dosen yang datang) </td>
                        <td width="10%"></td>
                        <td width="10%"></td>
                        <td width="20%"></td>
                    </tr>
                </tbody>
                
            </table>
            *Catatan: item no 1-9 dimasukan kedalam map snelhecter 
                        <div align="right">Serang, '.date('d-m-Y').'</div>  
                         <div align="right">Yang menerima </div><br/><br/><br/>  
                         <div align="right">( _____________________________) </div> 
 
            ';           
        $pdf->writeHTML($tbl2, true, false, true, false, '');
        // reset pointer to the last page
        $pdf->lastPage();
        //Close and output PDF document
        $pdf->Output('surat_praktek_industri.pdf', 'I');
//=================================================================+
// END OF FILE
//=================================================================+