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
                        include "tambah_praktek_industri.php";
                        break;
                    case 'edit':
                        include "edit_praktek_industri.php";
                        break; 
                    case 'print':
                        include "cetak_praktek_industri.php";
                        break;
                    case 'del':
                        include "hapus_praktek_industri.php";
                        break;
                    case 'upload_lampiran':
                        include "upload_lampiran_pi.php";
                        break;
                }
            } else {

                $query = mysqli_query($config, "SELECT id_pi FROM praktek_industri");
                list($praktek_industri) = mysqli_fetch_array($query);

                //pagging
               // $limit = $praktek_industri;
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
                                            <li class="waves-effect waves-light hide-on-small-only"><a href="?page=praktek_industri" class="judul">Praktek Industri</a></li>
                                            <li class="waves-effect waves-light">
                                                <!--<a href="?page=praktek_industri&act=add"><i class="material-icons md-24">add_circle</i> Tambah Data</a>-->
                                                  <a href="?page=pi&act=upload_lampiran"><i class="material-icons md-24">add_circle</i> Upload Lampiran</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col m5 hide-on-med-and-down">
                                        <form method="post" action="?page=praktek_industri">
                                            <div class="input-field round-in-box">
                                                <input id="search" type="search" name="cari" placeholder="Ketik dan tekan enter mencari data..." required>
                                                <label for="search"><i class="material-icons">search</i></label>
                                                <input type="submit" name="submit" class="hidden">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </nav>
                        </div>
                    </div>
                    <!-- Secondary Nav END -->
                    <div>
                        <b>&nbsp;&nbsp;&nbsp;Syarat untuk pengajuan praktek industri harus upload Dokumen persyaratan</b>
                    </div>
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
                                <p class="description">Hasil pencarian untuk kata kunci <strong>"'.stripslashes($cari).'"</strong><span class="right"><a href="?page=praktek_industri"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col m12" id="colres">
                        <table class="bordered" id="tbl">
                            <thead class="blue lighten-4" id="head">
                                <tr>
                                    <th width="8%">ID PI</th>
                                    <th width="10%">NIM</th>
                                    <th width="15%">Nama Mahasiswa</th>
                                    <th width="10%">NIP</th>
                                    <th width="15%">Dosen Pembimbing</th>
                                    <th width="15%">Judul</th> 
                                    <th width="10%">Tanggal Pengajuan PI</th>
                                    <th width="10%">Tanggal Pelaksanaan</th>
                                    <th width="15%">Perusahaan</th>
                                    <th width="8%">Tindakan </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>';

                            //script untuk mencari data
                              $query = mysqli_query($config, "SELECT * FROM praktek_industri WHERE nama LIKE '%$cari%' ORDER by id_pi DESC LIMIT $curr, 5");
                            if(mysqli_num_rows($query) > 0){
                                $no = 1;
                                while($row = mysqli_fetch_array($query)){
                                     if ($row['status']=='1'){
                                            $st='OPEN';
                                        }else{
                                            $st='CLOSE';
                                        }
                                      echo '
                                        <td>'.$row['id_pi'].'</td>
                                        <td>'.$row['nim'].'</td>  
                                        <td>'.$row['nama_mahasiswa'].'</td>
                                        <td>'.$row['nip'].'</td>  
                                        <td>'.$row['nama_dosen'].'</td> 
                                        <td>'.$row['judul_laporan'].'</td>  
                                        <td>'.$row['tgl_pengajuan_pi'].'</td>  
                                        <td>'.$row['tgl_pelaksanaan'].'</td>  
                                        <td>'.$row['nama_perusahaan'].'</td>  
                                        <td>'.$st.'</td>   
                                        <td>
                                            <a class="btn small yellow darken-3 waves-effect waves-light" href="surat_pi.php?id_pi='.$row['id_pi'].'" target="_blank">
                                                <i class="material-icons">print</i> PRINT</a>
                                                <a class="btn small blue waves-effect waves-light" href="?page=praktek_industri&act=edit&id_pi='.$row['id_pi'].'">
                                                   <i class="material-icons">edit</i> EDIT</a> 
                                                <a class="btn small deep-orange waves-effect waves-light" href="?page=praktek_industri&act=del&id_pi='.$row['id_pi'].'">
                                                    <i class="material-icons">delete</i> DEL</a>
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
                    <!-- Row form END -->';

                    $query = mysqli_query($config, "SELECT * FROM praktek_industri");
                    $cdata = mysqli_num_rows($query);
                    $cpg = ceil($cdata/$limit);

                    echo '<!-- Pagination START -->
                          <ul class="pagination">';

                    if($cdata > $limit ){

                        //first and previous pagging
                        if($pg > 1){
                            $prev = $pg - 1;
                            echo '<li><a href="?page=praktek_industri&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                                  <li><a href="?page=praktek_industri&pg='.$prev.'"><i class="material-icons md-48">chevron_left</i></a></li>';
                        } else {
                            echo '<li class="disabled"><a href=""><i class="material-icons md-48">first_page</i></a></li>
                                  <li class="disabled"><a href=""><i class="material-icons md-48">chevron_left</i></a></li>';
                        }

                        //perulangan pagging
                        for($i=1; $i <= $cpg; $i++)
                            if($i != $pg){
                                echo '<li class="waves-effect waves-dark"><a href="?page=praktek_industri&pg='.$i.'"> '.$i.' </a></li>';
                            } else {
                                echo '<li class="active waves-effect waves-dark"><a href="?page=praktek_industri&pg='.$i.'"> '.$i.' </a></li>';
                            }

                        //last and next pagging
                        if($pg < $cpg){
                            $next = $pg + 1;
                            echo '<li><a href="?page=praktek_industri&pg='.$next.'"><i class="material-icons md-48">chevron_right</i></a></li>
                                  <li><a href="?page=praktek_industri&pg='.$cpg.'"><i class="material-icons md-48">last_page</i></a></li>';
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
                        <div class="col m12" id="colres">
                            <table class="bordered" id="tbl">
                                <thead class="blue lighten-4" id="head">
                                    <tr>
                                          <th width="8%">ID PI</th>
                                    <th width="10%">NIM</th>
                                    <th width="15%">Nama Mahasiswa</th>
                                    <th width="10%">NIP</th>
                                    <th width="15%">Dosen Pembimbing</th>
                                    <th width="15%">Judul</th> 
                                    <th width="10%">Tanggal Pengajuan PI</th>
                                    <th width="10%">Tanggal Pelaksanaan</th>
                                    <th width="15%">Perusahaan</th>
                                    <th width="7%">Status</th>
                                    <th width="8%">Tindakan </th>
                              
                                            
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>'; 
                                if ($_SESSION['admin']=='4'){
                                    $wh='WHERE mahasiswa.nim="'.$_SESSION['username'].'"';
                                }else{
                                    $wh='';
                                }
                                //script untuk menampilkan data 
                                $query = mysqli_query($config, "SELECT
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
                                                                        INNER JOIN mahasiswa ON mahasiswa.nim = praktek_industri.nim
                                                                        INNER JOIN dosen ON dosen.id_dosen = praktek_industri.nip
                                                                        INNER JOIN perusahaan ON perusahaan.id_perusahaan = praktek_industri.id_perusahaan
                                                                         $wh
                                                                         ORDER by praktek_industri.id_pi DESC LIMIT $curr, 5");
                                     $no = 1;
                                    while($row = mysqli_fetch_array($query)){
                                        if ($row['status']=='1'){
                                            $st='OPEN';
                                        }else{
                                            $st='CLOSE';
                                        }
                                      echo '
                                        <td>'.$row['id_pi'].'</td>
                                        <td>'.$row['nim'].'</td>  
                                        <td>'.$row['nama_mahasiswa'].'</td>
                                        <td>'.$row['nip'].'</td>  
                                        <td>'.$row['nama_dosen'].'</td> 
                                        <td>'.$row['judul_laporan'].'</td>  
                                        <td>'.$row['tgl_pengajuan_pi'].'</td>  
                                        <td>'.$row['tgl_pelaksanaan'].'</td>  
                                        <td>'.$row['nama_perusahaan'].'</td>  
                                        <td>'.$st.'</td>   
                                        <td>
                                            <a class="btn small yellow darken-3 waves-effect waves-light" href="surat_pi.php?id_pi='.$row['id_pi'].'" target="_blank">
                                                <i class="material-icons">print</i> PRINT</a>
                                                <a class="btn small blue waves-effect waves-light" href="?page=praktek_industri&act=edit&id_pi='.$row['id_pi'].'">
                                                   <i class="material-icons">edit</i> EDIT</a> 
                                                <a class="btn small deep-orange waves-effect waves-light" href="?page=praktek_industri&act=del&id_pi='.$row['id_pi'].'">
                                                    <i class="material-icons">delete</i> DEL</a>
                                        </td>
                                    </tr>
                                </tbody>';
                                }
                          echo '</table>
                        </div>
                    </div>
                    <!-- Row form END -->';
                    $query = mysqli_query($config, "SELECT * FROM praktek_industri");
                    $cdata = mysqli_num_rows($query);
                 //   $cpg = ceil($cdata/$limit);
                    $cpg = ceil($cdata/5);
                    echo '<br/><!-- Pagination START -->
                          <ul class="pagination">';
                    if($cdata > $limit ){

                        //first and previous pagging
                        if($pg > 1){
                            $prev = $pg - 1;
                            echo '<li><a href="?page=praktek_industri&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                                  <li><a href="?page=praktek_industri&pg='.$prev.'"><i class="material-icons md-48">chevron_left</i></a></li>';
                        } else {
                            echo '<li class="disabled"><a href=""><i class="material-icons md-48">first_page</i></a></li>
                                  <li class="disabled"><a href=""><i class="material-icons md-48">chevron_left</i></a></li>';
                        }
                        //perulangan pagging
                        for($i=1; $i <= $cpg; $i++)
                            if($i != $pg){
                                echo '<li class="waves-effect waves-dark"><a href="?page=praktek_industri&pg='.$i.'"> '.$i.' </a></li>';
                            } else {
                                echo '<li class="active waves-effect waves-dark"><a href="?page=praktek_industri&pg='.$i.'"> '.$i.' </a></li>';
                            }
                        //last and next pagging
                        if($pg < $cpg){
                            $next = $pg + 1;
                            echo '<li><a href="?page=praktek_industri&pg='.$next.'"><i class="material-icons md-48">chevron_right</i></a></li>
                                  <li><a href="?page=praktek_industri&pg='.$cpg.'"><i class="material-icons md-48">last_page</i></a></li>';
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
