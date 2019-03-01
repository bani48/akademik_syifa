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
    $pdf->SetTitle('Surat Pengantar Praktek Industri'); 
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
    $id=$_REQUEST['nim']; 
     $sql=mysql_query("SELECT
                            jurnal_harian.id_jurnal_harian,
                            perusahaan.nama_perusahaan,
                            perusahaan.alamat,
                            mahasiswa.id_mahasiswa,
                            mahasiswa.nama,
                            jurnal_harian.kegiatan,
                            jurnal_harian.waktu,
                            jurnal_harian.keterangan,
                            mahasiswa.nim
                        FROM
                            jurnal_harian
                            INNER JOIN perusahaan ON perusahaan.id_perusahaan = jurnal_harian.id_perusahaan
                            INNER JOIN mahasiswa ON mahasiswa.nim = jurnal_harian.id_mahasiswa WHERE mahasiswa.nim='".$id."'"); 
    $dt=mysql_fetch_array($sql); 
    
    $sql2=mysql_query("SELECT");
 //------------------------------------------------------------
    $pdf->AddPage('P', 'A4'); 
         $tbl2 ='<style>
                    th{
                        align:center;
                        font-weight:bold;
                        background-color:#d9d6d6;
                    } 
                    
                    .tabel
                    {
                    
                         padding: 4px 3px 2px;
                    }
                </style> 
            <table border="0" style="width:100%;"> 
                  <tr>  
                    <td style="width:10%;" align="center">
                    
                        <img src="asset/img/logo.png" style="width:120px;">
                    </td>
                    <td style="width:90%;" align="center"><h4>'.$id.'
                            KEMENTERIAN RISET, TEKNOLOGI DAN PENDIDIKAN TINGGI
                            FAKULTAS KEGURUAN DAN ILMU PENDIDIKAN
                            UNIVERSITAS SULTAN AGENG TIRTAYASA BANTEN 
                        </h4>
                        Jl. Raya Ciwaru No. 25 Telp. (0264) 7910005/7910008, Serang - Banten
                 <hr>
                    </td>
                 </tr>   
            </table> 
            <table border=0 style="width:100%;"> 
                 <tr>
                    <td align="center" colspan="2"><h4><center>CATATAN KEGIATAN HARIAN PRAKTIK INDUSTRI</center></h4></td>
                 </tr>
                 <tr>
                    <td  width="25%">Perusahaan </td><td>: '.$dt['nama_perusahaan'].'</td>
                 </tr>
                 <tr>
                    <td>Alamat</td><td>: '.$dt['alamat'].'</td>
                 </tr>  
                 <tr>
                    <td>Nama Mahasiswa</td><td>: '.$dt['nama'].'</td>
                 </tr> 
                 <tr>
                    <td>NIM</td><td>: '.$dt['nim'].'</td>
                 </tr>  <br/>
                 <tr>
                    <td colspan="2" width="100%">
                        <table border="1" class="tabel">
                            <tr>
                                <th width="5%">No.</th>
                                <th width="40%">Kegiatan</th>
                                <th  width="15%">Waktu</th>
                                <th width="30%">Keterangan</th> 
                            </tr>';
                            $isi=mysql_query("select jurnal_harian.kegiatan, jurnal_harian.waktu, jurnal_harian.keterangan FROM jurnal_harian  
                                                        INNER JOIN mahasiswa ON mahasiswa.nim = jurnal_harian.id_mahasiswa
                                                         WHERE mahasiswa.nim='".$id."'");
                                $i=1;
                                while($si=mysql_fetch_array($isi)){
                                    $tbl2 .='<tr>
                                                <td>'.$i.'</td>
                                                <td>'.$si['kegiatan'].'</td>
                                                <td>'.date('d-m-Y',strtotime($si['waktu'])).'</td>
                                                <td>'.$si['keterangan'].'</td> 
                                            </tr>'; 
                                    $i++;  
                                }
                            $tbl2 .='
                        </table>
                    </td><br/>
                 </tr> 
                 <tr>
                    <td colspan="2" ><br/><br/>
                        <table width="100%">
                            <tr>
                                <td></td>
                                <td colspan="2" align="right">Serang, '.date('d-m-Y').'</td>
                            </tr>
                             
                            <tr>
                                <td width="65%"></td>
                                <td>Pembimbing Industri,</td> 
                            </tr>
                            <tr> 
                                <td width="65%"></td>
                                <td><u></u></td>
                            </tr>
                        </table>
                    </td>
                 </tr>
                 <tr><td colspan="2"  width="100%">
                     
                 <p>  
Catatan:<br/> 
1.	Kuantitas ditulis jumlah yang dikerjakan<br/>
2.	Hasil ditulis kualitas pekerjaanya bagaimana (baik, baik sekali, cukup atau kurang) <br/> 
3.	Jumlah jam setiap kegiatan dimasukkan pada kolom tanggal pada matriks kegiatan Praktik Industri  

                 </p></td></tr>
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