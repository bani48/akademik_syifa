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
                        include "tambah_pengajuan_seminar.php";
                        break;
                    case 'edit':
                        include "edit_pengajuan_seminar.php";
                        break;  
                    case 'del':
                        include "hapus_pengajuan_seminar.php";
                        break; 
                    case 'print':
                        include "lembar_pernyataan_seminar_seminar.php";
                        break;
                }
            } else {

                $query = mysqli_query($config, "SELECT id FROM pengajuan_Seminar_skripsi");
                list($pengajuan_Seminar) = mysqli_fetch_array($query);

                //pagging
               // $limit = $pengajuan_Seminar;
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
                                            <li class="waves-effect waves-light hide-on-small-only"><a href="?page=pengajuan_Seminar" class="judul">Pengajuan Seminar Skripsi</a></li>
                                            <li class="waves-effect waves-light">
                                                <a href="?page=pengajuan_seminar&act=add"><i class="material-icons md-24">add_circle</i> Tambah Data</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col m5 hide-on-med-and-down">
                                        <form method="post" action="?page=pengajuan_Seminar">
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
                                <p class="description">Hasil pencarian untuk kata kunci <strong>"'.stripslashes($cari).'"</strong><span class="right"><a href="?page=pengajuan_seminar"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col m12" id="colres">
                        <table class="bordered" id="tbl">
                            <thead class="blue lighten-4" id="head">
                                <tr>
                                    <th width="8%">NO</th>
                                    <th width="10%">NIM</th>
                                    <th width="15%">Nama Mahasiswa</th> 
                                    <th width="15%">No Hp</th> 
                                    <th width="16%">Dosen Pembimbing 1</th>
                                    <th width="16%">Dosen Pembimbing 2</th>
                                    <th width="30%">Judul Proposal</th>  
                                    <th width="10%"> </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>';

                            //script untuk mencari data
                              $query = mysqli_query($config, "SELECT
                                                                pengajuan_Seminar_skripsi.id,
                                                                pengajuan_Seminar_skripsi.no_hp,
                                                                (SELECT mahasiswa.nim FROM mahasiswa WHERE mahasiswa.nim=pengajuan_Seminar_skripsi.nim) AS nim,
                                                                (SELECT mahasiswa.nama FROM mahasiswa WHERE mahasiswa.nim=pengajuan_Seminar_skripsi.nim) AS nama_mahasiswa,
                                                                (SELECT dosen.nama FROM dosen WHERE dosen.id_dosen=pengajuan_Seminar_skripsi.id_pembimbing1) AS dosen1,
                                                                (SELECT dosen.nama FROM dosen WHERE dosen.id_dosen=pengajuan_Seminar_skripsi.id_pembimbing2) AS dosen2,
                                                                pengajuan_Seminar_skripsi.judul_proposal,
                                                                pengajuan_Seminar_skripsi.`status`
                                                                FROM
                                                                pengajuan_Seminar_skripsi
                                                                LEFT JOIN mahasiswa ON pengajuan_Seminar_skripsi.nim=mahasiswa.id_mahasiswa
                                                                WHERE
                                                                	mahasiswa.nama LIKE '%$cari%'
                                                                 ORDER by pengajuan_Seminar_skripsi.id DESC LIMIT $curr, 5");
                            if(mysqli_num_rows($query) > 0){
                                $no = 1;
                                while($row = mysqli_fetch_array($query)){ 
                                  echo '
                                        <td>'.$row['id'].'</td>
                                        <td>'.$row['nim'].'</td> 
                                        <td>'.$row['nama_mahasiswa'].'</td>  
                                        <td>'.$row['no_hp'].'</td> 
                                        <td>'.$row['dosen1'].'</td>  
                                        <td>'.$row['dosen2'].'</td>  
                                        <td>'.$row['judul_proposal'].'</td>    
                                        <td><a class="btn small deep-BLUE waves-effect waves-light" href="lembar_pernyataan_seminar.php?id='.$row['id'].'">
                                             <i class="material-icons">print</i> PRINT</a> 
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

                    $query = mysqli_query($config, "SELECT * FROM pengajuan_Seminar_skripsi");
                    $cdata = mysqli_num_rows($query);
                    $cpg = ceil($cdata/$limit);

                    echo '<!-- Pagination START -->
                          <ul class="pagination">';

                    if($cdata > $limit ){

                        //first and previous pagging
                        if($pg > 1){
                            $prev = $pg - 1;
                            echo '<li><a href="?page=pengajuan_Seminar&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                                  <li><a href="?page=pengajuan_Seminar&pg='.$prev.'"><i class="material-icons md-48">chevron_left</i></a></li>';
                        } else {
                            echo '<li class="disabled"><a href=""><i class="material-icons md-48">first_page</i></a></li>
                                  <li class="disabled"><a href=""><i class="material-icons md-48">chevron_left</i></a></li>';
                        }

                        //perulangan pagging
                        for($i=1; $i <= $cpg; $i++)
                            if($i != $pg){
                                echo '<li class="waves-effect waves-dark"><a href="?page=pengajuan_Seminar&pg='.$i.'"> '.$i.' </a></li>';
                            } else {
                                echo '<li class="active waves-effect waves-dark"><a href="?page=pengajuan_Seminar&pg='.$i.'"> '.$i.' </a></li>';
                            }

                        //last and next pagging
                        if($pg < $cpg){
                            $next = $pg + 1;
                            echo '<li><a href="?page=pengajuan_Seminar&pg='.$next.'"><i class="material-icons md-48">chevron_right</i></a></li>
                                  <li><a href="?page=pengajuan_Seminar&pg='.$cpg.'"><i class="material-icons md-48">last_page</i></a></li>';
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
                                    <th width="8%">NO</th>
                                    <th width="10%">NIM</th>
                                    <th width="15%">Nama Mahasiswa</th> 
                                    <th width="15%">No Hp</th> 
                                    <th width="16%">Dosen Pembimbing 1</th>
                                    <th width="16%">Dosen Pembimbing 2</th>
                                    <th width="30%">Judul Proposal</th>   
                                    <th width="10%"> </th>
                              
                                            
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>'; 

                                //script untuk menampilkan data 
                                $query = mysqli_query($config, "SELECT
                                                                pengajuan_Seminar_skripsi.id,
                                                                pengajuan_Seminar_skripsi.no_hp,
                                                                (SELECT mahasiswa.nim FROM mahasiswa WHERE mahasiswa.nim=pengajuan_Seminar_skripsi.nim) AS nim,
                                                                (SELECT mahasiswa.nama FROM mahasiswa WHERE mahasiswa.nim=pengajuan_Seminar_skripsi.nim) AS nama_mahasiswa,
                                                                (SELECT dosen.nama FROM dosen WHERE dosen.id_dosen=pengajuan_Seminar_skripsi.id_pembimbing1) AS dosen1,
                                                                (SELECT dosen.nama FROM dosen WHERE dosen.id_dosen=pengajuan_Seminar_skripsi.id_pembimbing2) AS dosen2,
                                                                pengajuan_Seminar_skripsi.judul_proposal,
                                                                pengajuan_Seminar_skripsi.`status`
                                                                FROM
                                                                pengajuan_Seminar_skripsi 
                                                                ORDER by id DESC LIMIT $curr, 5");
                                     $no = 1;
                                    while($row = mysqli_fetch_array($query)){
                                        if ($row['status']=='0'){
                                            $st='New';
                                        }else if($row['status']=='1'){
                                            $st='ACC';
                                        }else{
                                            $st='Ditolak';
                                        }
                                      echo '
                                        <td>'.$row['id'].'</td>
                                        <td>'.$row['nim'].'</td> 
                                        <td>'.$row['nama_mahasiswa'].'</td>  
                                        <td>'.$row['no_hp'].'</td> 
                                        <td>'.$row['dosen1'].'</td>  
                                        <td>'.$row['dosen2'].'</td>  
                                        <td>'.$row['judul_proposal'].'</td>     
                                        <td><a class="btn small deep-BLUE waves-effect waves-light" href="lembar_pernyataan_seminar.php?id='.$row['id'].'">
                                             <i class="material-icons">print</i> PRINT</a> 
                                        </td>
                                    </tr>
                                </tbody>';
                                }
                          echo '</table>
                        </div>
                    </div>
                    <!-- Row form END -->';
                    $query = mysqli_query($config, "SELECT * FROM pengajuan_Seminar_skripsi");
                    $cdata = mysqli_num_rows($query);
                 //   $cpg = ceil($cdata/$limit);
                    $cpg = ceil($cdata/5);
                    echo '<br/><!-- Pagination START -->
                          <ul class="pagination">';
                    if($cdata > $limit ){

                        //first and previous pagging
                        if($pg > 1){
                            $prev = $pg - 1;
                            echo '<li><a href="?page=pengajuan_Seminar&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                                  <li><a href="?page=pengajuan_Seminar&pg='.$prev.'"><i class="material-icons md-48">chevron_left</i></a></li>';
                        } else {
                            echo '<li class="disabled"><a href=""><i class="material-icons md-48">first_page</i></a></li>
                                  <li class="disabled"><a href=""><i class="material-icons md-48">chevron_left</i></a></li>';
                        }
                        //perulangan pagging
                        for($i=1; $i <= $cpg; $i++)
                            if($i != $pg){
                                echo '<li class="waves-effect waves-dark"><a href="?page=pengajuan_seminar&pg='.$i.'"> '.$i.' </a></li>';
                            } else {
                                echo '<li class="active waves-effect waves-dark"><a href="?page=pengajuan_seminar&pg='.$i.'"> '.$i.' </a></li>';
                            }
                        //last and next pagging
                        if($pg < $cpg){
                            $next = $pg + 1;
                            echo '<li><a href="?page=pengajuan_Seminar&pg='.$next.'"><i class="material-icons md-48">chevron_right</i></a></li>
                                  <li><a href="?page=pengajuan_Seminar&pg='.$cpg.'"><i class="material-icons md-48">last_page</i></a></li>';
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
