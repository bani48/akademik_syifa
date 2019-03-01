<?php
    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else {  
            if(isset($_REQUEST['act'])){
                $act = $_REQUEST['act'];
                switch ($act) {
                    case 'add':
                        include "tambah_jurnal_harian.php";
                        break;
                    case 'edit':
                        include "edit_jurnal_harian.php";
                        break; 
                    case 'print':
                        include "cetak_jurnal_harian.php";
                        break;
                    case 'del':
                        include "hapus_jurnal_harian.php";
                        break;
                }
            } else {

                $query = mysqli_query($config, "SELECT id_jurnal_harian FROM jurnal_harian");
                list($jurnal_harian) = mysqli_fetch_array($query);

                //pagging
               // $limit = $jurnal_harian;
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
                                            <li class="waves-effect waves-light hide-on-small-only"><a href="?page=jurnal_harian" class="judul"> Jurnal Harian</a></li>
                                            <?php 
                                                if ($_SESSION['admin']=='1' || $_SESSION['admin']=='4'){
                                            ?>
                                            <li class="waves-effect waves-light">
                                                <a href="?page=jurnal_harian&act=add"><i class="material-icons md-24">add_circle</i> Tambah Data</a>
                                            </li>
                                            
                                               <?php
                                            }else{
                                                echo'';
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                    <div class="col m5 hide-on-med-and-down">
                                        <form method="post" action="?page=jurnal_harian">
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
                                <p class="description">Hasil pencarian untuk kata kunci <strong>"'.stripslashes($cari).'"</strong><span class="right"><a href="?page=jurnal_harian"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col m12" id="colres">
                        <table class="bordered" id="tbl">
                            <thead class="blue lighten-4" id="head">
                                <tr>
                                    <th width="10%">No Jurnal</th>
                                    <th width="15%">Perusahaan</th>
                                    <th width="20%">Alamat</th> 
                                    <th width="15%">NIM</th>
                                    <th width="15%">Nama Mahasiswa</th>
                                    <th width="20%">Kegiatan</th>
                                    <th width="20%">Waktu</th>
                                    <th width="20%">Keterangan</th>
                                    <th width="8%">Tindakan </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>';
                                if ($_SESSION['admin']=='4'){
                                    $wh="mahasiswa.nim='".$_SESSION['username']."' AND nama_jurnal_harian LIKE '%$cari%'";
                                }else{
                                    $wh="nama_jurnal_harian LIKE '%$cari%'";
                                }
                            //script untuk mencari data
                             $query = mysqli_query($config, "SELECT * FROM jurnal_harian WHERE  $wh ORDER by id_jurnal_harian DESC LIMIT $curr, 5");
                            if(mysqli_num_rows($query) > 0){
                                $no = 1;
                                while($row = mysqli_fetch_array($query)){
                                  echo '
                                        <td>'.$row['id_jurnal_harian'].'</td>
                                        <td>'.$row['nama_jurnal_harian'].'</td>
                                        <td>'.$row['alamat'].'</td> 
                                        <td>'.$row['telepon'].'</td> 
                                        <td>'.$row['email'].'</td> 
                                        <td>'.$row['link'].'</td> 
                                        <td>';
                                        if ($_SESSION['admin']=='1' || $_SESSION['admin']=='4'){
                                           echo' 
                                             <a class="btn small blue waves-effect waves-light" href="?page=jurnal_harian&act=edit&id_jurnal_harian='.$row['id_jurnal_harian'].'">
                                                    <i class="material-icons">edit</i> EDIT</a> 
                                                <a class="btn small deep-orange waves-effect waves-light" href="?page=jurnal_harian&act=del&id_jurnal_harian='.$row['id_jurnal_harian'].'">
                                                    <i class="material-icons">delete</i> DEL</a>';
                                            }else{
                                                echo'';
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
                    <!-- Row form END -->';

                    $query = mysqli_query($config, "SELECT * FROM jurnal_harian");
                    $cdata = mysqli_num_rows($query);
                    $cpg = ceil($cdata/$limit);

                    echo '<!-- Pagination START -->
                          <ul class="pagination">';

                    if($cdata > $limit ){

                        //first and previous pagging
                        if($pg > 1){
                            $prev = $pg - 1;
                            echo '<li><a href="?page=jurnal_harian&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                                  <li><a href="?page=jurnal_harian&pg='.$prev.'"><i class="material-icons md-48">chevron_left</i></a></li>';
                        } else {
                            echo '<li class="disabled"><a href=""><i class="material-icons md-48">first_page</i></a></li>
                                  <li class="disabled"><a href=""><i class="material-icons md-48">chevron_left</i></a></li>';
                        }

                        //perulangan pagging
                        for($i=1; $i <= $cpg; $i++)
                            if($i != $pg){
                                echo '<li class="waves-effect waves-dark"><a href="?page=jurnal_harian&pg='.$i.'"> '.$i.' </a></li>';
                            } else {
                                echo '<li class="active waves-effect waves-dark"><a href="?page=jurnal_harian&pg='.$i.'"> '.$i.' </a></li>';
                            }

                        //last and next pagging
                        if($pg < $cpg){
                            $next = $pg + 1;
                            echo '<li><a href="?page=jurnal_harian&pg='.$next.'"><i class="material-icons md-48">chevron_right</i></a></li>
                                  <li><a href="?page=jurnal_harian&pg='.$cpg.'"><i class="material-icons md-48">last_page</i></a></li>';
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
                                        <th width="10%">No Jurnal</th>
                                        <th width="15%">Perusahaan</th>
                                        <th width="20%">Alamat</th> 
                                        <th width="15%">NIM</th>
                                        <th width="15%">Nama Mahasiswa</th>
                                        <th width="20%">Kegiatan</th>
                                        <th width="20%">Waktu</th>
                                        <th width="20%">Keterangan</th>
                                        <th width="8%">Opt </th>

                                            <div id="modal" class="modal">
                                                <div class="modal-content white">
                                                    <h5>Jumlah data yang ditampilkan per halaman</h5>';
                                                    $query = mysqli_query($config, "SELECT * FROM jurnal_harian");
                                                    list($id_sett,$jurnal_harian) = mysqli_fetch_array($query);
                                                    echo '
                                                    <div class="row">
                                                        <form method="post" action="">
                                                            <div class="input-field col s12">
                                                                <input type="hidden" value="'.$id_sett.'" name="id_sett">
                                                                <div class="input-field col s1" style="float: left;">
                                                                    <i class="material-icons prefix md-prefix">looks_one</i>
                                                                </div>
                                                                <div class="input-field col s11 right" style="margin: -5px 0 20px;">
                                                                    <select class="browser-default validate" name="jurnal_harian" required>
                                                                        <option value="'.$jurnal_harian.'">'.$jurnal_harian.'</option>
                                                                        <option value="5">5</option>
                                                                        <option value="10">10</option>
                                                                        <option value="20">20</option>
                                                                        <option value="50">50</option>
                                                                        <option value="100">100</option>
                                                                    </select>
                                                                </div>
                                                                <div class="modal-footer white">
                                                                    <button type="submit" class="modal-action waves-effect waves-green btn-flat" name="simpan">Simpan</button>';
                                                                    if(isset($_REQUEST['simpan'])){
                                                                        $id_sett = "1";
                                                                        $jurnal_harian = $_REQUEST['jurnal_harian'];
                                                                        $id_user = $_SESSION['id_user'];

                                                                        $query = mysqli_query($config, "UPDATE tbl_sett SET jurnal_harian='$jurnal_harian',id_user='$id_user' WHERE id_sett='$id_sett'");
                                                                        if($query == true){
                                                                            header("Location: ./admin.php?page=jurnal_harian");
                                                                            die();
                                                                        }
                                                                    } echo '
                                                                    <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Batal</a>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>'; 
                                    
                                    $mh=mysqli_fetch_array(mysqli_query($config,"SELECT praktek_industri.nim, dosen.nip FROM praktek_industri
                                                                                LEFT JOIN dosen ON praktek_industri.nip=dosen.id_dosen
                                                                                 WHERE dosen.nip='".$_SESSION['username']."'"));
                                if ($_SESSION['admin']=='4'){
                                    $wh='WHERE mahasiswa.nim="'.$_SESSION['username'].'"';
                                }else if($_SESSION['admin']=='3' ){
                                    $wh='WHERE mahasiswa.nim="'.$mh['nim'].'"';
                                   
                                }else{
                                    $wh='';
                                } 

                                //script untuk menampilkan data
                                $query = mysqli_query( $config, "SELECT
                                                                    jurnal_harian.id_jurnal_harian,
                                                                    perusahaan.nama_perusahaan,
                                                                    perusahaan.alamat,
                                                                    mahasiswa.nim,
                                                                    mahasiswa.nama,
                                                                    jurnal_harian.kegiatan,
                                                                    jurnal_harian.waktu,
                                                                    jurnal_harian.keterangan
                                                                FROM
                                                                    jurnal_harian
                                                                LEFT JOIN perusahaan ON perusahaan.id_perusahaan = jurnal_harian.id_perusahaan
                                                                LEFT JOIN mahasiswa ON mahasiswa.nim = jurnal_harian.id_mahasiswa
                                                                $wh
                                                                ORDER by jurnal_harian.id_jurnal_harian DESC LIMIT $curr, 5");
                                   
                                     $no = 1;
                                    while($row = mysqli_fetch_array($query)){
                                      echo '
                                         <td>'.$row['id_jurnal_harian'].'</td>
                                         <td>'.$row['nama_perusahaan'].'</td>
                                         <td>'.$row['alamat'].'</td>
                                         <td>'.$row['nim'].'</td>
                                         <td>'.$row['nama'].'</td>
                                         <td>'.$row['kegiatan'].'</td>
                                         <td>'.$row['waktu'].'</td> 
                                         <td>'.$row['keterangan'].'</td> 
                                        <td>';
                                        if ($_SESSION['admin']=='1' || $_SESSION['admin']=='4'){
                                           echo' 
                                             <a class="btn small green waves-effect waves-light" href="jurnal_print.php?nim='.$row['nim'].'">
                                                    <i class="material-icons">print</i> Print</a> 
                                             <a class="btn small blue waves-effect waves-light" href="?page=jurnal_harian&act=edit&id_jurnal_harian='.$row['id_jurnal_harian'].'">
                                                    <i class="material-icons">edit</i> EDIT</a> 
                                                <a class="btn small deep-orange waves-effect waves-light" href="?page=jurnal_harian&act=del&id_jurnal_harian='.$row['id_jurnal_harian'].'">
                                                    <i class="material-icons">delete</i> DEL</a>';
                                            }else{
                                                echo'';
                                            }
                                        echo'        
                                        </td>
                                    </tr>
                                </tbody>';
                                }

                          echo '</table>
                        </div>
                    </div>
                    <!-- Row form END -->';

                    $query = mysqli_query($config, "SELECT * FROM jurnal_harian");
                    $cdata = mysqli_num_rows($query);
                 //   $cpg = ceil($cdata/$limit);
                    $cpg = ceil($cdata/5);

                    echo '<br/><!-- Pagination START -->
                          <ul class="pagination">';

                    if($cdata > $limit ){

                        //first and previous pagging
                        if($pg > 1){
                            $prev = $pg - 1;
                            echo '<li><a href="?page=jurnal_harian&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                                  <li><a href="?page=jurnal_harian&pg='.$prev.'"><i class="material-icons md-48">chevron_left</i></a></li>';
                        } else {
                            echo '<li class="disabled"><a href=""><i class="material-icons md-48">first_page</i></a></li>
                                  <li class="disabled"><a href=""><i class="material-icons md-48">chevron_left</i></a></li>';
                        }

                        //perulangan pagging
                        for($i=1; $i <= $cpg; $i++)
                            if($i != $pg){
                                echo '<li class="waves-effect waves-dark"><a href="?page=jurnal_harian&pg='.$i.'"> '.$i.' </a></li>';
                            } else {
                                echo '<li class="active waves-effect waves-dark"><a href="?page=jurnal_harian&pg='.$i.'"> '.$i.' </a></li>';
                            }

                        //last and next pagging
                        if($pg < $cpg){
                            $next = $pg + 1;
                            echo '<li><a href="?page=jurnal_harian&pg='.$next.'"><i class="material-icons md-48">chevron_right</i></a></li>
                                  <li><a href="?page=jurnal_harian&pg='.$cpg.'"><i class="material-icons md-48">last_page</i></a></li>';
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
?>
