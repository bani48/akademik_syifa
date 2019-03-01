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
                        include "tambah_mahasiswa.php";
                        break;
                    case 'edit':
                        include "edit_mahasiswa.php";
                        break; 
                    case 'print':
                        include "cetak_mahasiswa.php";
                        break;
                    case 'del':
                        include "hapus_mahasiswa.php";
                        break;
                    case 'aktifkan':
                        include "aktifkan_mahasiswa.php";
                        break;
                }
            } else {

                $query = mysqli_query($config, "SELECT id_mahasiswa FROM mahasiswa");
                list($mahasiswa) = mysqli_fetch_array($query);

                //pagging
              //  $limit = $mahasiswa;
                $limit='8';
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
                                            <li class="waves-effect waves-light hide-on-small-only"><a href="?page=mahasiswa" class="judul"> Mahasiswa</a></li>
                                            <?php 
                                            if ($_SESSION['admin']=='1'){ 
                                            ?>
                                            <li class="waves-effect waves-light">
                                                <a href="?page=mahasiswa&act=add"><i class="material-icons md-24">add_circle</i> Tambah Data</a>
                                            </li>
                                            <?php 
                                            }else{
                                                echo'';
                                            }   
                                            ?>
                                        </ul>
                                    </div>
                                    <div class="col m5 hide-on-med-and-down">
                                        <form method="post" action="?page=mahasiswa">
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
                                <p class="description">Hasil pencarian untuk kata kunci <strong>"'.stripslashes($cari).'"</strong><span class="right"><a href="?page=mahasiswa"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col m12" id="colres">
                        <table class="bordered" id="tbl">
                            <thead class="blue lighten-4" id="head">
                                <tr>
                                    <th width="5%">No Mahasiswa</th>
                                    <th width="30%">Nama Mahasiswa</th>
                                    <th width="24%">NIM</th> 
                                    <th width="24%">Email</th> 
                                    <th width="25%">No Hp</th> 
                                    <th width="18%">Tindakan </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>';

                            //script untuk mencari data
                         //   $query = mysqli_query($config, "SELECT * FROM mahasiswa WHERE nama LIKE '%$cari%' ORDER by id_mahasiswa DESC LIMIT $curr, $limit");
                            $query = mysqli_query($config, "SELECT * FROM mahasiswa WHERE nama LIKE '%$cari%' OR nim LIKE '%$cari%'  ORDER by id_mahasiswa DESC LIMIT $curr, 8");
                            if(mysqli_num_rows($query) > 0){
                                $no = 1;
                                while($row = mysqli_fetch_array($query)){
                                  echo '
                                        <td>'.$row['id_mahasiswa'].'</td>
                                        <td>'.$row['nama'].'</td>
                                        <td>'.$row['nim'].'</td> 
                                        <td>'.$row['email'].'</td> 
                                        <td>'.$row['no_hp'].'</td> 
                                        <td>';  
                                        
                                        if ($_SESSION['admin']=='1'){ 
                                            if($row['stat']=='1'){
                                                echo'  
                                                    <a class="btn small green waves-effect waves-light" href="">
                                                            <i class="material-icons">people</i>Sudah Aktif</a> 
                                                    <a class="btn small blue waves-effect waves-light" href="?page=mahasiswa&act=edit&id_mahasiswa='.$row['id_mahasiswa'].'">
                                                            <i class="material-icons">edit</i> EDIT</a> 
                                                    <a class="btn small deep-orange waves-effect waves-light" href="?page=mahasiswa&act=del&id_mahasiswa='.$row['id_mahasiswa'].'">
                                                        <i class="material-icons">delete</i> DEL</a>';
                                            }else{ 
                                                echo'  
                                                    <a class="btn small green waves-effect waves-light" href="?page=mahasiswa&act=aktifkan&id_mahasiswa='.$row['id_mahasiswa'].'">
                                                            <i class="material-icons">people</i> Aktif</a> 
                                                    <a class="btn small blue waves-effect waves-light" href="?page=mahasiswa&act=edit&id_mahasiswa='.$row['id_mahasiswa'].'">
                                                            <i class="material-icons">edit</i> EDIT</a> 
                                                    <a class="btn small deep-orange waves-effect waves-light" href="?page=mahasiswa&act=del&id_mahasiswa='.$row['id_mahasiswa'].'">
                                                        <i class="material-icons">delete</i> DEL</a>';
                                            }
                                       
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

                    $query = mysqli_query($config, "SELECT * FROM mahasiswa");
                    $cdata = mysqli_num_rows($query);
                    $cpg = ceil($cdata/$limit);
                    
                    echo '<!-- Pagination START -->
                          <ul class="pagination">';

                    if($cdata > $limit ){

                        //first and previous pagging
                        if($pg > 1){
                            $prev = $pg - 1;
                            echo '<li><a href="?page=mahasiswa&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                                  <li><a href="?page=mahasiswa&pg='.$prev.'"><i class="material-icons md-48">chevron_left</i></a></li>';
                        } else {
                            echo '<li class="disabled"><a href=""><i class="material-icons md-48">first_page</i></a></li>
                                  <li class="disabled"><a href=""><i class="material-icons md-48">chevron_left</i></a></li>';
                        }

                        //perulangan pagging
                        for($i=1; $i <= $cpg; $i++)
                            if($i != $pg){
                                echo '<li class="waves-effect waves-dark"><a href="?page=mahasiswa&pg='.$i.'"> '.$i.' </a></li>';
                            } else {
                                echo '<li class="active waves-effect waves-dark"><a href="?page=mahasiswa&pg='.$i.'"> '.$i.' </a></li>';
                            }

                        //last and next pagging
                        if($pg < $cpg){
                            $next = $pg + 1;
                            echo '<li><a href="?page=mahasiswa&pg='.$next.'"><i class="material-icons md-48">chevron_right</i></a></li>
                                  <li><a href="?page=mahasiswa&pg='.$cpg.'"><i class="material-icons md-48">last_page</i></a></li>';
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
                                    <th width="5%">No Mahasiswa</th>
                                    <th width="30%">Nama Mahasiswa</th>
                                    <th width="24%">NIM</th> 
                                    <th width="24%">Email</th> 
                                    <th width="25%">No Hp</th> 
                                    <th width="18%">Tindakan </th> 

                                            <div id="modal" class="modal">
                                                <div class="modal-content white">
                                                    <h5>Jumlah data yang ditampilkan per halaman</h5>';
                                                    $query = mysqli_query($config, "SELECT * FROM mahasiswa");
                                                    list($id_sett,$mahasiswa) = mysqli_fetch_array($query);
                                                    echo '
                                                    <div class="row">
                                                        <form method="post" action="">
                                                            <div class="input-field col s12">
                                                                <input type="hidden" value="'.$id_sett.'" name="id_sett">
                                                                <div class="input-field col s1" style="float: left;">
                                                                    <i class="material-icons prefix md-prefix">looks_one</i>
                                                                </div>
                                                                <div class="input-field col s11 right" style="margin: -5px 0 20px;">
                                                                    <select class="browser-default validate" name="mahasiswa" required>
                                                                        <option value="'.$mahasiswa.'">'.$mahasiswa.'</option>
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
                                                                        $mahasiswa = $_REQUEST['mahasiswa'];
                                                                        $id_user = $_SESSION['id_user'];

                                                                        $query = mysqli_query($config, "UPDATE tbl_sett SET mahasiswa='$mahasiswa',id_user='$id_user' WHERE id_sett='$id_sett'");
                                                                        if($query == true){
                                                                            header("Location: ./admin.php?page=mahasiswa");
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

                                //script untuk menampilkan data
                             //   $query = mysqli_query($config, "SELECT * FROM mahasiswa ORDER by id_mahasiswa DESC LIMIT $curr, $limit");
                             $iddosen=mysqli_fetch_array(mysqli_query($config,"SELECT id_dosen FROM dosen WHERE nip='".$_SESSION['username']."'"));
                             $id_dosen=$iddosen['id_dosen'];
                             if ($_SESSION['admin']=='3'){
                                $query = mysqli_query($config, "SELECT
                                                                    mahasiswa.id_mahasiswa,
                                                                    mahasiswa.nama,
                                                                    mahasiswa.nim,
                                                                    mahasiswa.email,
                                                                    mahasiswa.no_hp,
                                                                    mahasiswa.stat,
                                                                    pengajuan_proposal_skripsi.id_pembimbing1,
                                                                    pengajuan_proposal_skripsi.id_pembimbing2
                                                                FROM
                                                                    mahasiswa
                                                                    INNER JOIN pengajuan_proposal_skripsi ON pengajuan_proposal_skripsi.nim = mahasiswa.nim
                                                                    WHERE pengajuan_proposal_skripsi.id_pembimbing1='$id_dosen' OR
                                                                    pengajuan_proposal_skripsi.id_pembimbing2='$id_dosen'
                                                                     ORDER by mahasiswa.id_mahasiswa DESC LIMIT $curr, 8");
                             }else{
                                $query = mysqli_query($config, "SELECT * FROM mahasiswa ORDER by id_mahasiswa DESC LIMIT $curr, 8");
                             }
                                   $no = 1;
                                    while($row = mysqli_fetch_array($query)){
                                      echo '
                                        <td>'.$row['id_mahasiswa'].'</td>
                                        <td>'.$row['nama'].'</td>
                                        <td>'.$row['nim'].'</td>  
                                        <td>'.$row['email'].'</td>  
                                        <td>'.$row['no_hp'].'</td>  
                                        <td>';  
                                        if ($_SESSION['admin']=='1'){ 
                                            if($row['stat']=='1'){
                                                echo'  
                                                    <a class="btn small green waves-effect waves-light" href="">
                                                            <i class="material-icons">people</i>Sudah Aktif</a> 
                                                    <a class="btn small blue waves-effect waves-light" href="?page=mahasiswa&act=edit&id_mahasiswa='.$row['id_mahasiswa'].'">
                                                            <i class="material-icons">edit</i> EDIT</a> 
                                                    <a class="btn small deep-orange waves-effect waves-light" href="?page=mahasiswa&act=del&id_mahasiswa='.$row['id_mahasiswa'].'">
                                                        <i class="material-icons">delete</i> DEL</a>';
                                            }else{ 
                                                echo'  
                                                    <a class="btn small green waves-effect waves-light" href="?page=mahasiswa&act=aktifkan&id_mahasiswa='.$row['id_mahasiswa'].'">
                                                            <i class="material-icons">people</i> Aktif</a> 
                                                    <a class="btn small blue waves-effect waves-light" href="?page=mahasiswa&act=edit&id_mahasiswa='.$row['id_mahasiswa'].'">
                                                            <i class="material-icons">edit</i> EDIT</a> 
                                                    <a class="btn small deep-orange waves-effect waves-light" href="?page=mahasiswa&act=del&id_mahasiswa='.$row['id_mahasiswa'].'">
                                                        <i class="material-icons">delete</i> DEL</a>';
                                            }
                                       
                                        }else{
                                            echo'';
                                        }
                                  echo'</td>
                                    </tr>
                                </tbody>';
                                }

                          echo '</table>
                        </div>
                    </div>
                    <!-- Row form END -->';
                    if ($_SESSION['admin']==3){
                        $query = mysqli_query($config, "SELECT
                                                                    mahasiswa.id_mahasiswa,
                                                                    mahasiswa.nama,
                                                                    mahasiswa.nim,
                                                                    mahasiswa.email,
                                                                    mahasiswa.no_hp,
                                                                    mahasiswa.stat,
                                                                    pengajuan_proposal_skripsi.id_pembimbing1,
                                                                    pengajuan_proposal_skripsi.id_pembimbing2
                                                                FROM
                                                                    mahasiswa
                                                                    INNER JOIN pengajuan_proposal_skripsi ON pengajuan_proposal_skripsi.nim = mahasiswa.nim
                                                                    WHERE pengajuan_proposal_skripsi.id_pembimbing1='$id_dosen' OR
                                                                    pengajuan_proposal_skripsi.id_pembimbing2='$id_dosen'");
                        
                    }else{ 
                        $query = mysqli_query($config, "SELECT * FROM mahasiswa");    
                    }
                    $cdata = mysqli_num_rows($query);
                   $cpg = ceil($cdata/$limit);
                   //echo $cdata.'=';
                   //echo $limit;
                   //$cpg = ceil($cdata/10);

                    echo '<br/><!-- Pagination START -->
                          <ul class="pagination">';

                    if($cdata > $limit ){

                        //first and previous pagging
                        if($pg > 1){
                            $prev = $pg - 1;
                            echo '<li><a href="?page=mahasiswa&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                                  <li><a href="?page=mahasiswa&pg='.$prev.'"><i class="material-icons md-48">chevron_left</i></a></li>';
                        } else {
                            echo '<li class="disabled"><a href=""><i class="material-icons md-48">first_page</i></a></li>
                                  <li class="disabled"><a href=""><i class="material-icons md-48">chevron_left</i></a></li>';
                        }

                        //perulangan pagging
                        for($i=1; $i <= $cpg; $i++)
                            if($i != $pg){
                                echo '<li class="waves-effect waves-dark"><a href="?page=mahasiswa&pg='.$i.'"> '.$i.' </a></li>';
                            } else {
                                echo '<li class="active waves-effect waves-dark"><a href="?page=mahasiswa&pg='.$i.'"> '.$i.' </a></li>';
                            }

                        //last and next pagging
                        if($pg < $cpg){
                            $next = $pg + 1;
                            echo '<li><a href="?page=mahasiswa&pg='.$next.'"><i class="material-icons md-48">chevron_right</i></a></li>
                                  <li><a href="?page=mahasiswa&pg='.$cpg.'"><i class="material-icons md-48">last_page</i></a></li>';
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
