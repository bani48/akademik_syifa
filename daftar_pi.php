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
                        include "tambah_seminar_praktek_industri.php";
                        break; 
                    case 'tambah_seminar_praktek_industri':
                        include "tambah_seminar_praktek_industri.php";
                        break; 
                    case 'edit':
                        include "edit_seminar_praktek_industri.php";
                        break;   
                    case 'delete':
                        include "hapus_daftar_pi.php";
                        break; 
                    case 'print':
                        include "surat_pi.php";
                        break;
                    case 'setuju':
                        include "setuju_upload_seminar_praktek_industri.php";
                        break;
                }
            } else {

                $query = mysqli_query($config, "SELECT id FROM seminar_praktek_industri");
                list($pi) = mysqli_fetch_array($query);

                //pagging
               // $limit = $pi;
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
                                            <li class="waves-effect waves-light hide-on-small-only"><a href="?page=daftar_pi" class="judul">Pengajuan Seminar Praktek Industri</a></li>
                                            <li class="waves-effect waves-light">
                                                 <a href="?page=daftar_pi&act=add"><i class="material-icons md-24">add_circle</i>Tambah</a>
                                            </li>
                                        </ul>
                                    </div> 
                                    <div class="col m5 hide-on-med-and-down">
                                    <?php  if ($_SESSION['admin']!='4'){ ?>
                                        <form method="post" action="?page=daftar_pi">
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
                                <p class="description">Hasil pencarian untuk kata kunci <strong>"'.stripslashes($cari).'"</strong><span class="right"><a href="?page=daftar_pi"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                                </div>
                            </div>
                        </div>
                        
                       <div class="tambah_scroll"> 
                        <div class="col m12" id="colres">
                        <table class="bordered" id="tbl">
                            <thead class="blue lighten-4" id="head">
                                <tr>
                                    <th width="8%">No</th>
                                    <th width="auto">NIM</th>
                                    <th width="auto">Nama Mahasiswa</th>
                                    <th width="auto">Laporan Praktek Industri</th> 
                                    <th width="auto">Jurnal Praktek Industri</th> 
                                    <th width="auto">Kartu Bimbingan PI</th>  
                                    <th width="10%"> </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>';

                            //script untuk mencari data 
                              $query = mysqli_query($config, "SELECT seminar_praktek_industri.*,  
                                                                (SELECT mahasiswa.nama FROM mahasiswa WHERE mahasiswa.nim=seminar_praktek_industri.nim) AS nama
                                                                 FROM seminar_praktek_industri  
                                                                WHERE
                                                                	seminar_praktek_industri.transkip LIKE '%$cari%' OR 
                                                                	seminar_praktek_industri.krs LIKE '%$cari%' OR
                                                                	seminar_praktek_industri.proposal_pi LIKE '%$cari%'
                                                                 ORDER by seminar_praktek_industri.id DESC LIMIT $curr, 5");
                            if(mysqli_num_rows($query) > 0){
                                $no = 1;
                                while($row = mysqli_fetch_array($query)){ 
                                   $st=$row['status']; 
                                   echo'
                                       <td>'.$no.' </td>
                                        <td>'.$row['nim'].' </td>  
                                        <td>'.$row['nama'].' </td>  
                                        <td><a href="upload/'.$row['laporan_pi'].'">'.$row['laporan_pi'].'</a></td> 
                                        <td><a href="upload/'.$row['jurnal_pi'].'">'.$row['jurnal_pi'].'</a></td>  
                                        <td><a href="upload/'.$row['kartu_bimbingan'].'">'.$row['kartu_bimbingan'].'</a></td> 
                                        <td>';
                                            if($st=='0'){
                                                echo'  &nbsp;
                                                <a class="btn small yellow waves-effect waves-light" href="?page=daftar_pi&act=edit&id_pi='.$row['id'].'">
                                                   <i class="material-icons">edit</i></a> 
                                                      <a class="btn small deep-green waves-effect waves-light" href="?page=daftar_pi&act=delete&id='.$row['id'].'">
        											 <i class="material-icons">delete</i></a>';
                                            }else if ($hit==0){
                                                echo'<a class="btn small deep-BLUE waves-effect waves-light" href="?page=daftar_pi&act=add&nim='.$row['nim'].'" title="Pengajuan Seminar Praktek Industri">
                                               Pengajuan Seminar Praktek Industri</a> ';
                                            }
                                            
                                            if($hit!=0){
                                                echo'&nbsp; <a class="btn small deep-green waves-effect waves-light" href="surat_pi.php?id='.$cekisi['id_pi'].'">
        											 <i class="material-icons">print</i></a> 
                                                <a class="btn small blue waves-effect waves-light" href="?page=daftar_pi&act=edit&id_pi='.$cekisi['id_pi'].'">
                                                   <i class="material-icons">edit</i> EDIT</a>';
                                            } 
                                            $no++;
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

                    $query = mysqli_query($config, "SELECT * FROM seminar_praktek_industri");
                    $cdata = mysqli_num_rows($query);
                    $cpg = ceil($cdata/$limit);

                    echo '<!-- Pagination START -->
                          <ul class="pagination">';

                    if($cdata > $limit ){

                        //first and previous pagging
                        if($pg > 1){
                            $prev = $pg - 1;
                            echo '<li><a href="?page=daftar_pi&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                                  <li><a href="?page=daftar_pi&pg='.$prev.'"><i class="material-icons md-48">chevron_left</i></a></li>';
                        } else {
                            echo '<li class="disabled"><a href=""><i class="material-icons md-48">first_page</i></a></li>
                                  <li class="disabled"><a href=""><i class="material-icons md-48">chevron_left</i></a></li>';
                        }

                        //perulangan pagging
                        for($i=1; $i <= $cpg; $i++)
                            if($i != $pg){
                                echo '<li class="waves-effect waves-dark"><a href="?page=daftar_pi&pg='.$i.'"> '.$i.' </a></li>';
                            } else {
                                echo '<li class="active waves-effect waves-dark"><a href="?page=daftar_pi&pg='.$i.'"> '.$i.' </a></li>';
                            }

                        //last and next pagging
                        if($pg < $cpg){
                            $next = $pg + 1;
                            echo '<li><a href="?page=daftar_pi&pg='.$next.'"><i class="material-icons md-48">chevron_right</i></a></li>
                                  <li><a href="?page=daftar_pi&pg='.$cpg.'"><i class="material-icons md-48">last_page</i></a></li>';
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
                                    <th width="auto">NIM</th>
                                    <th width="auto">Nama Mahasiswa</th>
                                    <th width="auto">Laporan Praktek Industri</th> 
                                    <th width="auto">Jurnal Praktek Industri</th> 
                                    <th width="auto">Kartu Bimbingan PI</th>  
                                    <th width="10%"> </th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>'; 
                                $grup=$_SESSION['admin'];
                                if ($grup=='4'){
                                    $grp="WHERE seminar_praktek_industri.nim='".$_SESSION['username']."'";
                                }else{
                                    $grp='';  
                                }
                                //script untuk menampilkan data 
                                $query = mysqli_query($config, "
                                                                SELECT seminar_praktek_industri.*, 
                                                                (SELECT mahasiswa.nim FROM mahasiswa WHERE mahasiswa.nim=praktek_industri.nim) AS nim,
                                                                (SELECT mahasiswa.nama FROM mahasiswa WHERE mahasiswa.nim=praktek_industri.nim) AS nama
                                                                 FROM seminar_praktek_industri 
                                                                 INNER JOIN praktek_industri ON praktek_industri.id_pi=seminar_praktek_industri.id_pi 
                                                                 $grp
                                                                ORDER by seminar_praktek_industri.id DESC LIMIT $curr, 5"); 
                                    $no = 1;
                                    while($row = mysqli_fetch_array($query)){   
                                            $st=$row['status']; 
                                            $cekisi=mysqli_fetch_array(mysqli_query($config, "SELECT * FROM seminar_praktek_industri WHERE nim='".$row['nim']."'"));
                                            $hit=count($cekisi['nim']);
                                      echo '
                                        <td>'.$no.' </td>
                                        <td>'.$row['nim'].' </td>  
                                        <td>'.$row['nama'].' </td>  
                                        <td><a href="upload/'.$row['laporan_pi'].'">'.$row['laporan_pi'].'</a></td> 
                                        <td><a href="upload/'.$row['jurnal_pi'].'">'.$row['jurnal_pi'].'</a></td>  
                                        <td><a href="upload/'.$row['kartu_bimbingan'].'">'.$row['kartu_bimbingan'].'</a></td> 
                                        <td>';
                                            if($st=='0'){
                                                echo'  &nbsp;
                                                <a class="btn small yellow waves-effect waves-light" href="?page=daftar_pi&act=edit&id_pi='.$row['id'].'">
                                                   <i class="material-icons">edit</i></a> 
                                                      <a class="btn small deep-green waves-effect waves-light" href="?page=daftar_pi&act=delete&id='.$row['id'].'">
        											 <i class="material-icons">delete</i></a>';
                                            }else if ($hit==0){
                                                echo'<a class="btn small deep-BLUE waves-effect waves-light" href="?page=daftar_pi&act=add&nim='.$row['nim'].'" title="Pengajuan Seminar Praktek Industri">
                                               Pengajuan Seminar Praktek Industri</a> ';
                                            }
                                            
                                            if($hit!=0){
                                                echo'&nbsp; <a class="btn small deep-green waves-effect waves-light" href="surat_pi.php?id='.$cekisi['id_pi'].'">
        											 <i class="material-icons">print</i></a> 
                                                <a class="btn small blue waves-effect waves-light" href="?page=daftar_pi&act=edit&id_pi='.$cekisi['id_pi'].'">
                                                   <i class="material-icons">edit</i> EDIT</a>';
                                            } 
                                            $no++;
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
                    $query = mysqli_query($config, "SELECT * FROM seminar_praktek_industri");
                    $cdata = mysqli_num_rows($query);
                 //   $cpg = ceil($cdata/$limit);
                    $cpg = ceil($cdata/5);
                    echo '<br/><!-- Pagination START -->
                          <ul class="pagination">';
                    if($cdata > $limit ){

                        //first and previous pagging
                        if($pg > 1){
                            $prev = $pg - 1;
                            echo '<li><a href="?page=daftar_pi&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                                  <li><a href="?page=daftar_pi&pg='.$prev.'"><i class="material-icons md-48">chevron_left</i></a></li>';
                        } else {
                            echo '<li class="disabled"><a href=""><i class="material-icons md-48">first_page</i></a></li>
                                  <li class="disabled"><a href=""><i class="material-icons md-48">chevron_left</i></a></li>';
                        }
                        //perulangan pagging
                        for($i=1; $i <= $cpg; $i++)
                            if($i != $pg){
                                echo '<li class="waves-effect waves-dark"><a href="?page=daftar_pi&pg='.$i.'"> '.$i.' </a></li>';
                            } else {
                                echo '<li class="active waves-effect waves-dark"><a href="?page=daftar_pi&pg='.$i.'"> '.$i.' </a></li>';
                            }
                        //last and next pagging
                        if($pg < $cpg){
                            $next = $pg + 1;
                            echo '<li><a href="?page=daftar_pi&pg='.$next.'"><i class="material-icons md-48">chevron_right</i></a></li>
                                  <li><a href="?page=daftar_pi&pg='.$cpg.'"><i class="material-icons md-48">last_page</i></a></li>';
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
