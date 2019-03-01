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
    $sql=mysql_query("SELECT
                                                                            praktek_industri.id_pi,
                                                                            mahasiswa.nama AS nama_mahasiswa,
                                                                            dosen.nama AS nama_dosen,
                                                                            praktek_industri.judul_laporan,
                                                                            praktek_industri.tgl_pengajuan_pi,
                                                                            praktek_industri.tgl_pelaksanaan,
                                                                            perusahaan.nama_perusahaan,
                                                                            praktek_industri.`status`,
                                                                            praktek_industri.nim,
                                                                            praktek_industri.nip
                                                                            FROM
                                                                            praktek_industri
                                                                            LEFT JOIN mahasiswa ON mahasiswa.nim = praktek_industri.nim
                                                                            LEFT JOIN dosen ON dosen.id_dosen = praktek_industri.nip
                                                                            LEFT JOIN perusahaan ON perusahaan.id_perusahaan = praktek_industri.id_perusahaan
                                                                            WHERE praktek_industri.id_pi='".$_REQUEST['id']."'"); 
    $dt=mysql_fetch_array($sql);
 //------------------------------------------------------------
 $id=$_REQUEST['id'];
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
                    <td style="width:90%;" align="center"><h4>
                            KEMENTERIAN RISET, TEKNOLOGI DAN PENDIDIKAN TINGGI
                            FAKULTAS KEGURUAN DAN ILMU PENDIDIKAN
                            UNIVERSITAS SULTAN AGENG TIRTAYASA BANTEN 
                        </h4>
                        Jl. Raya Ciwaru No. 25 Telp. (0264) 7910005/7910008, Serang - Banten
                 <hr>
                    </td>
                 </tr>   
            </table> 
            <table border="0" style="width:100%;"> 
                 <tr>
                    <td>Nomor :</td>
                 </tr>
                 <tr>
                    <td>Lamp. 	: 2 exp.</td>
                 </tr>  
                 <tr>
                    <td>Hal 	: Pengantar Permohonan Surat Ijin Praktik Industri<br/></td>
                 </tr>  
                 <tr>
                    <td>Kepada: Dekan FKIP Universitas Sultan Ageng Tirtayasa di Serang, Banten<br/></td>
                 </tr>  
                 <tr>
                    <td  >Dengan hormat,<p>Dengan ini kami beritahukan/usulkan bahwa mahasiswa tersebut di bawah ini telah
                            memenuhi syarat dan terdaftar akan mengambil program Praktik Industri dengan dosen
                            pembimbing dan pengujinya sebagaimana dalam daftar berikut:<br/>
                            </p></td> 
                 </tr>
                 <tr>
                    <td>
                        <table border="1" class="tabel">
                            <tr>
                                <th width="5%" align="center">No.</th>
                                <th width="28%" align="center">Nama Mahasiswa</th>
                                <th width="15%" align="center">NIM</th>
                                <th align="center">Pembimbing</th>
                                <th align="center">Rencana Waktu PI</th>
                                <th align="center" width="20%">Tempat PI</th>
                            </tr>
                            <tr>
                                <td width="5%" align="center">1</td>
                                <td>'.$dt['nama_mahasiswa'].'</td>
                                <td width="15%" align="center">'.$dt['nim'].'</td>
                                <td>'.$dt['nama_dosen'].'</td>
                                <td align="center">'.date('d-m-Y',strtotime($dt['tgl_pengajuan_pi'])).'</td>
                                <td width="20%">'.$dt['nama_perusahaan'].'</td>
                            </tr>
                        </table>
                    </td><br/>
                 </tr> 
                 <tr><td>
                    <table>
                        <tr>
                            <td colspan="2">Demikian semoga segera dapat diproses dan segera terlaksana program Praktik Industrinya. Terima kasih.</td>
                        </tr>
                        <tr><td width="60%"></td>
                            <td>Serang, </td>
                        </tr>
                        <tr><td></td>
                            <td>Ketua Jurusan Pendidikan Teknik Elektro<br/><br/></td>
                        </tr>
                        <tr><td></td>
                            <td> <u>Endi Permata, S.T., M.T.</u></td>
                        </tr>
                        <tr><td></td>
                            <td> NIP.</td>
                        </tr> 
                    </table>
                 <p>  
Tembusan:<br/>
1.	Subbag. Akademik untuk diproses<br/>
2.	Koordinator Praktik Industri Jurusan Pendidikan Teknik Elektro<br/>
3.	Dosen Pembimbing Praktik Industri<br/>
NB: <br/>
- Blangko ini bisa didapatkan di jurusan Pendidikan Teknik Elektro atau diketik sendiri dengan mengacu format di atas.<br/>
- Lampiran yang diperlukan adalah: Kartu Hasil Studi atau transkip dan Proposal Praktik Industri(lihat Lampiran 16)

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