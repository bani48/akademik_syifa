<?php
    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else {

        if($_SESSION['admin'] ==''){
            echo '<script language="javascript">
                    window.alert("ERROR! Anda tidak memiliki hak akses untuk membuka halaman ini");
                    window.location.href="./logout.php";
                  </script>';
        } else {

            if(isset($_REQUEST['act'])){
                $act = $_REQUEST['act'];
                switch ($act) {
                    case 'add':
                        include "tambah_pengajuan_hasil_seminar.php";
                        break;
                    case 'upload_lampiran_hasil':
                        include "upload_lampiran_hasil.php";
                        break;
                    case 'edit':
                        include "edit_pengajuan_hasil_seminar.php";
                        break;  
                    case 'delete':
                        include "hapus_pengajuan_hasil_seminar.php";
                        break; 
                    case 'print':
                        include "lembar_pernyataan_seminar_hasil.php";
                        break;
                    case 'setuju':
                        include "setuju_upload_lampiran_hasil.php";
                        break;
                }
            } else {

                $query = mysqli_query($config, "SELECT id_ph FROM lampiran_seminar_hasil");
                list($pengajuan_hasil_seminar) = mysqli_fetch_array($query);

                //pagging
               // $limit = $pengajuan_hasil_seminar;
                $limit='5';
                $pg = @$_GET['pg'];
                if(empty($pg)){
                    $curr = 0;
                    $pg = 1;
                } else {
                    $curr = ($pg - 1) * $limit;
                } 
                ?>

                <!-- Row Start -->
                <div class="row">
                    <!-- Secondary Nav START -->
                    <div class="col s12">
                        <div class="z-depth-1">
                            <nav class="secondary-nav">
                                <div class="nav-wrapper blue-grey darken-1">
                                    <div class="col m7">
                                        <ul class="left">
                                            <li class="waves-effect waves-light hide-on-small-only"><a href="?page=pengajuan_hasil_seminar" class="judul">Pengajuan Seminar Hasil Skripsi</a></li>
                                            <li class="waves-effect waves-light">
                                                <!--a href="?page=pengajuan_hasil_seminar&act=add"><i class="material-icons md-24">add_circle</i> Tambah Data</a-->
                                                <a href="?page=pengajuan_hasil_seminar&act=upload_lampiran_hasil"><i class="material-icons md-24">add_circle</i> Upload Lampiran</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col m5 hide-on-med-and-down"> 
                                    <?php  if ($_SESSION['admin']!='4'){ ?>
                                        <form method="post" action="?page=pengajuan_hasil_seminar">
                                            <div class="input-field round-in-box">
                                                <input id="search" type="search" name="cari" placeholder="Ketik dan tekan enter mencari data..." required>
                                                <label for="search"><i class="material-icons">search</i></label>
                                                <input type="submit" name="submit" class="hidden">
                                            </div>
                                        </form>
                                    <?php    
                                    }?> 
                                    </div>
                                </div>
                            </nav>
                        </div>
                    </div>
                    <div>
                        <b>&nbsp;&nbsp;&nbsp;Syarat untuk pengajuan seminar harus upload Dokumen persyaratan</b>
                    </div>
                    <!-- Secondary Nav END -->
                </div>
                <!-- Row END -->

                <?php
                    if(isset($_SESSION['succAdd'])){
                        $succAdd = $_SESSION['succAdd'];
                        echo '<div id="alert-message" class="row">
                                <div class="col m12">
                                    <div class="card green lighten-5">
                                        <div class="card-content notif">
                                            <span class="card-title green-text"><i class="material-icons md-36">done</i> '.$succAdd.'</span>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                        unset($_SESSION['succAdd']);
                    }
                    if(isset($_SESSION['succEdit'])){
                        $succEdit = $_SESSION['succEdit'];
                        echo '<div id="alert-message" class="row">
                                <div class="col m12">
                                    <div class="card green lighten-5">
                                        <div class="card-content notif">
                                            <span class="card-title green-text"><i class="material-icons md-36">done</i> '.$succEdit.'</span>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                        unset($_SESSION['succEdit']);
                    }
                    if(isset($_SESSION['succDel'])){
                        $succDel = $_SESSION['succDel'];
                        echo '<div id="alert-message" class="row">
                                <div class="col m12">
                                    <div class="card green lighten-5">
                                        <div class="card-content notif">
                                            <span class="card-title green-text"><i class="material-icons md-36">done</i> '.$succDel.'</span>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                        unset($_SESSION['succDel']);
                    }
                ?>

                <!-- Row form Start -->
                <div class="row jarak-form">

                <?php
                    if(isset($_REQUEST['submit'])){
                    $cari = mysqli_real_escape_string($config, $_REQUEST['cari']);
                        echo '
                        <div class="col s12" style="margin-top: -18px;">
                            <div class="card blue lighten-5">
                                <div class="card-content">
                                <p class="description">Hasil pencarian untuk kata kunci <strong>"'.stripslashes($cari).'"</strong><span class="right"><a href="?page=pengajuan_hasil_seminar"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                                </div>
                            </div>
                        </div>

                      <div class="tambah_scroll"> 
                        <div class="col m12" id="colres">
                            <table class="bordered" id="tbl">
                                <thead class="blue lighten-4" id="head">
                                    <tr>
                                        <th width="8%">No</th>
                                        <th width="auto">Mahasiswa</th>
                                        <th width="auto">Form Pendaftaran Seminar Proposal</th>
                                        <th width="auto">Form bukti serah terima laporan Praktik Industri</th> 
                                        <th width="auto">Kartu bimbingan proposal skripsi</th> 
                                        <th width="auto">Lembar pernyataan judul skripsi</th> 
                                        <th width="auto">Surat pernyataan koreksi </th> 
                                        <th width="auto">KRS semester </th> 
                                        <th width="auto">Transkrip nilai </th> 
                                        <th width="auto">Berita Acara</th> 
                                        <th width="auto">Nilai Seminar</th> 
                                        <th width="auto">Naskah proposal skripsi </th> 
                                        <th width="auto">Status</th>
                                        <th width="10%"> </th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>'; 
                            //script untuk mencari data 
                                    $grup=$_SESSION['admin'];
                                    if ($grup=='4'){
                                        $grp="WHERE pengajuan_proposal_skripsi.nim='".$_SESSION['username']."' AND ";
                                    }else{
                                        $grp='WHERE ';  
                                    }
                              $query = mysqli_query($config, "SELECT
                                                                    lampiran_seminar_hasil.id_ph,
                                                                    lampiran_seminar_hasil.pendaftaran_seminar,
                                                                    lampiran_seminar_hasil.bukti_serah_terima,
                                                                    lampiran_seminar_hasil.kartu_bimbingan,
                                                                    lampiran_seminar_hasil.lembar_pernyataan,
                                                                    lampiran_seminar_hasil.surat_pernyataan,
                                                                    lampiran_seminar_hasil.krs,
                                                                    lampiran_seminar_hasil.transkip_nilai,
                                                                    lampiran_seminar_hasil.form_ba,
                                                                    lampiran_seminar_hasil.form_nilai,
                                                                    lampiran_seminar_hasil.naskah_proposal,
                                                                    lampiran_seminar_hasil.`status`,
                                                                    lampiran_seminar_hasil.id_proposal,
                                                                    pengajuan_proposal_skripsi.nim,
                                                                    (
                                                                    		SELECT
                                                                    			mahasiswa.nama
                                                                    		FROM
                                                                    			mahasiswa
                                                                    		WHERE
                                                                    			mahasiswa.nim = pengajuan_proposal_skripsi.nim
                                                                    	) AS nama
                                                                    FROM
                                                                    	lampiran_seminar_hasil
                                                                    INNER JOIN pengajuan_proposal_skripsi ON pengajuan_proposal_skripsi.id = lampiran_seminar_hasil.id_proposal
                                                                        $grp
                                                                    	lampiran_seminar_hasil.pendaftaran_seminar LIKE '%$cari%'
                                                                     ORDER by lampiran_seminar_hasil.id_ph DESC LIMIT $curr, 5");
                            if(mysqli_num_rows($query) > 0){
                                $no = 1;
                                while($row = mysqli_fetch_array($query)){ 
                                     $st=$row['status']; 
                                     $cekisi=mysqli_fetch_array(mysqli_query($config, "SELECT * FROM pengajuan_hasil_seminar_skripsi WHERE nim='".$row['nim']."'"));
                                     $hit=count($cekisi['nim']);
                                          echo '
                                            <td>'.$row['id_ph'].' </td>
                                            <td>'.$row['nama'].' </td>  
                                            <td><a href="upload/'.$row['pendaftaran_seminar'].'">'.$row['pendaftaran_seminar'].'</a></td> 
                                            <td><a href="upload/'.$row['bukti_serah_terima'].'">'.$row['bukti_serah_terima'].'</a></td>  
                                            <td><a href="upload/'.$row['kartu_bimbingan'].'">'.$row['kartu_bimbingan'].'</a></td> 
                                            <td><a href="upload/'.$row['lembar_pernyataan'].'">'.$row['lembar_pernyataan'].'</a></td>  
                                            <td><a href="upload/'.$row['surat_pernyataan'].'">'.$row['surat_pernyataan'].'</a></td> 
                                            <td><a href="upload/'.$row['krs'].'">'.$row['krs'].'</a></td> 
                                            <td><a href="upload/'.$row['transkip_nilai'].'">'.$row['transkip_nilai'].'</a></td> 
                                            <td><a href="upload/'.$row['form_ba'].'">'.$row['form_ba'].'</a></td> 
                                            <td><a href="upload/'.$row['form_nilai'].'">'.$row['form_nilai'].'</a></td> 
                                            <td><a href="upload/'.$row['naskah_proposal'].'">'.$row['naskah_proposal'].'</a></td> 
                                            <td>';
                                                if($st=='0'){
                                                    echo'NEW';
                                                }else{
                                                    echo'ACC';
                                                } 
                                            echo'</td>     
                                            <td>';
                                                if($st=='0'){
                                                    echo' <a class="btn small deep-green waves-effect waves-light" href="?page=pengajuan_hasil_seminar&act=setuju&id_ph='.$row['id_ph'].'">
            											 <i class="material-icons">check</i></a> &nbsp;
                                                          <a class="btn small deep-green waves-effect waves-light" href="?page=pengajuan_hasil_seminar&act=delete&id_ph='.$row['id_ph'].'">
            											 <i class="material-icons">delete</i></a>';
                                                }else if ($hit==0){
                                                    echo'<a class="btn small deep-BLUE waves-effect waves-light" href="?page=pengajuan_hasil_seminar&act=add&nim='.$row['nim'].'" title="Pengajuan Seminar">
                                                   Pengajuan Seminar</a> ';
                                                }
                                                
                                                if($hit!=0){
                                                    echo'&nbsp; <a class="btn small deep-green waves-effect waves-light" href="lembar_pernyataan_seminar_hasil.php?id_ph='.$cekisi['id_ph'].'">
            											 <i class="material-icons">print</i></a> ';
                                                } 
                                               echo' 
                                            </td>
                                    </tr>
                                </tbody>';
                                }
                            } else {
                                echo '<tr><td colspan="5"><center><p class="add">Tidak ada data yang ditemukan</p></center></td></tr>';
                            }
                             echo '</table><br/><br/>
                        </div>
                    </div>
                </div>
                    <!-- Row form END -->';

                    $query = mysqli_query($config, "SELECT * FROM pengajuan_hasil_seminar_skripsi");
                    $cdata = mysqli_num_rows($query);
                    $cpg = ceil($cdata/$limit);

                    echo '<!-- Pagination START -->
                          <ul class="pagination">';

                    if($cdata > $limit ){

                        //first and previous pagging
                        if($pg > 1){
                            $prev = $pg - 1;
                            echo '<li><a href="?page=pengajuan_hasil_seminar&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                                  <li><a href="?page=pengajuan_hasil_seminar&pg='.$prev.'"><i class="material-icons md-48">chevron_left</i></a></li>';
                        } else {
                            echo '<li class="disabled"><a href=""><i class="material-icons md-48">first_page</i></a></li>
                                  <li class="disabled"><a href=""><i class="material-icons md-48">chevron_left</i></a></li>';
                        }

                        //perulangan pagging
                        for($i=1; $i <= $cpg; $i++)
                            if($i != $pg){
                                echo '<li class="waves-effect waves-dark"><a href="?page=pengajuan_hasil_seminar&pg='.$i.'"> '.$i.' </a></li>';
                            } else {
                                echo '<li class="active waves-effect waves-dark"><a href="?page=pengajuan_hasil_seminar&pg='.$i.'"> '.$i.' </a></li>';
                            }

                        //last and next pagging
                        if($pg < $cpg){
                            $next = $pg + 1;
                            echo '<li><a href="?page=pengajuan_hasil_seminar&pg='.$next.'"><i class="material-icons md-48">chevron_right</i></a></li>
                                  <li><a href="?page=pengajuan_hasil_seminar&pg='.$cpg.'"><i class="material-icons md-48">last_page</i></a></li>';
                        } else {
                            echo '<li class="disabled"><a href=""><i class="material-icons md-48">chevron_right</i></a></li>
                                  <li class="disabled"><a href=""><i class="material-icons md-48">last_page</i></a></li>';
                        }
                        echo '
                        </ul>
                        <!-- Pagination END -->';
                    } else {
                        echo '';
                    }

                    } else {

                        echo '
                       <div class="tambah_scroll"> 
                        <div class="col m12" id="colres">
                            <table class="bordered" id="tbl">
                                <thead class="blue lighten-4" id="head">
                                    <th width="8%">NO</th>
                                    <th width="auto">Mahasiswa</th>
                                    <th width="auto">Form Pendaftaran Seminar Proposal</th>
                                    <th width="auto">Form bukti serah terima laporan Praktik Industri</th> 
                                    <th width="auto">Kartu bimbingan proposal skripsi</th> 
                                    <th width="auto">Lembar pernyataan judul skripsi</th> 
                                    <th width="auto">Surat pernyataan koreksi </th> 
                                    <th width="auto">KRS semester </th> 
                                    <th width="auto">Transkrip nilai </th> 
                                    <th width="auto">Berita Acara</th> 
                                    <th width="auto">Nilai Seminar</th> 
                                    <th width="auto">Naskah proposal skripsi </th> 
                                    <th width="auto">Status</th>
                                    <th width="10%"> </th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>'; 
                                    $grup=$_SESSION['admin'];
                                    if ($grup=='4'){
                                        $grp="WHERE pengajuan_proposal_skripsi.nim='".$_SESSION['username']."'";
                                    }else{
                                        $grp='';  
                                    }
                                //script untuk menampilkan data 
                                $query = mysqli_query($config, "SELECT
                                                                    lampiran_seminar_hasil.id_ph,
                                                                    lampiran_seminar_hasil.pendaftaran_seminar,
                                                                    lampiran_seminar_hasil.bukti_serah_terima,
                                                                    lampiran_seminar_hasil.kartu_bimbingan,
                                                                    lampiran_seminar_hasil.lembar_pernyataan,
                                                                    lampiran_seminar_hasil.surat_pernyataan,
                                                                    lampiran_seminar_hasil.krs,
                                                                    lampiran_seminar_hasil.transkip_nilai,
                                                                    lampiran_seminar_hasil.form_ba,
                                                                    lampiran_seminar_hasil.form_nilai,
                                                                    lampiran_seminar_hasil.naskah_proposal,
                                                                    lampiran_seminar_hasil.`status`,
                                                                    lampiran_seminar_hasil.id_proposal,
                                                                    pengajuan_proposal_skripsi.nim,
                                                                    (
                                                                    		SELECT
                                                                    			mahasiswa.nama
                                                                    		FROM
                                                                    			mahasiswa
                                                                    		WHERE
                                                                    			mahasiswa.nim = pengajuan_proposal_skripsi.nim
                                                                    	) AS nama
                                                                    FROM
                                                                    	lampiran_seminar_hasil
                                                                    INNER JOIN pengajuan_proposal_skripsi ON pengajuan_proposal_skripsi.id = lampiran_seminar_hasil.id_proposal
                                                                      $grp
                                                                ORDER by lampiran_seminar_hasil.id_ph DESC LIMIT $curr, 5");
                                     $no = 1;
                                    while($row = mysqli_fetch_array($query)){   
                                            $st=$row['status']; 
                                            $cekisi=mysqli_fetch_array(mysqli_query($config, "SELECT * FROM pengajuan_hasil_seminar_skripsi WHERE nim='".$row['nim']."'"));
                                            $hit=count($cekisi['nim']);
                                          echo '
                                            <td>'.$row['id_ph'].' </td>
                                            <td>'.$row['nama'].' </td>  
                                            <td><a href="upload/'.$row['pendaftaran_seminar'].'">'.$row['pendaftaran_seminar'].'</a></td> 
                                            <td><a href="upload/'.$row['bukti_serah_terima'].'">'.$row['bukti_serah_terima'].'</a></td>  
                                            <td><a href="upload/'.$row['kartu_bimbingan'].'">'.$row['kartu_bimbingan'].'</a></td> 
                                            <td><a href="upload/'.$row['lembar_pernyataan'].'">'.$row['lembar_pernyataan'].'</a></td>  
                                            <td><a href="upload/'.$row['surat_pernyataan'].'">'.$row['surat_pernyataan'].'</a></td> 
                                            <td><a href="upload/'.$row['krs'].'">'.$row['krs'].'</a></td> 
                                            <td><a href="upload/'.$row['transkip_nilai'].'">'.$row['transkip_nilai'].'</a></td> 
                                            <td><a href="upload/'.$row['form_ba'].'">'.$row['form_ba'].'</a></td> 
                                            <td><a href="upload/'.$row['form_nilai'].'">'.$row['form_nilai'].'</a></td> 
                                            <td><a href="upload/'.$row['naskah_proposal'].'">'.$row['naskah_proposal'].'</a></td> 
                                            <td>';
                                                if($st=='0'){
                                                    echo'NEW';
                                                }else{
                                                    echo'ACC';
                                                } 
                                            echo'</td>     
                                            <td>';
                                                if($st=='0'){
                                                    echo' <a class="btn small deep-green waves-effect waves-light" href="?page=pengajuan_hasil_seminar&act=setuju&id_ph='.$row['id_ph'].'">
            											 <i class="material-icons">check</i></a> &nbsp;
                                                          <a class="btn small deep-green waves-effect waves-light" href="?page=pengajuan_hasil_seminar&act=delete&id_ph='.$row['id_ph'].'">
            											 <i class="material-icons">delete</i></a>';
                                                }else if ($hit==0){
                                                    echo'<a class="btn small deep-BLUE waves-effect waves-light" href="?page=pengajuan_hasil_seminar&act=add&nim='.$row['nim'].'" title="Pengajuan Seminar">
                                                   Pengajuan Seminar</a> ';
                                                }
                                                
                                                if($hit!=0){
                                                    echo'&nbsp; <a class="btn small deep-green waves-effect waves-light" href="lembar_pernyataan_seminar_hasil.php?id_ph='.$cekisi['id_ph'].'">
            											 <i class="material-icons">print</i></a> ';
                                                } 
                                               echo' 
                                            </td>
                                    </tr>
                                </tbody>';
                                }
                          echo '</table>
                        </div>
                       </div>
                    </div>
                    <!-- Row form END -->';
                    $query = mysqli_query($config, "SELECT * FROM pengajuan_hasil_seminar_skripsi");
                    $cdata = mysqli_num_rows($query);
                 //   $cpg = ceil($cdata/$limit);
                    $cpg = ceil($cdata/5);
                    echo '<br/><!-- Pagination START -->
                          <ul class="pagination">';
                    if($cdata > $limit ){

                        //first and previous pagging
                        if($pg > 1){
                            $prev = $pg - 1;
                            echo '<li><a href="?page=pengajuan_hasil_seminar&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                                  <li><a href="?page=pengajuan_hasil_seminar&pg='.$prev.'"><i class="material-icons md-48">chevron_left</i></a></li>';
                        } else {
                            echo '<li class="disabled"><a href=""><i class="material-icons md-48">first_page</i></a></li>
                                  <li class="disabled"><a href=""><i class="material-icons md-48">chevron_left</i></a></li>';
                        }
                        //perulangan pagging
                        for($i=1; $i <= $cpg; $i++)
                            if($i != $pg){
                                echo '<li class="waves-effect waves-dark"><a href="?page=pengajuan_hasil_seminar&pg='.$i.'"> '.$i.' </a></li>';
                            } else {
                                echo '<li class="active waves-effect waves-dark"><a href="?page=pengajuan_hasil_seminar&pg='.$i.'"> '.$i.' </a></li>';
                            }
                        //last and next pagging
                        if($pg < $cpg){
                            $next = $pg + 1;
                            echo '<li><a href="?page=pengajuan_hasil_seminar&pg='.$next.'"><i class="material-icons md-48">chevron_right</i></a></li>
                                  <li><a href="?page=pengajuan_hasil_seminar&pg='.$cpg.'"><i class="material-icons md-48">last_page</i></a></li>';
                        } else {
                            echo '<li class="disabled"><a href=""><i class="material-icons md-48">chevron_right</i></a></li>
                                  <li class="disabled"><a href=""><i class="material-icons md-48">last_page</i></a></li>';
                        }
                        echo '
                        </ul>
                        <!-- Pagination END -->';
                    } else {
                        echo '';
                    }
                }
            }
        }
    }
?>
<style>
    .tambah_scroll {
        width: 99%;
        overflow-x: auto;
        white-space: nowrap;
    }
</style>
