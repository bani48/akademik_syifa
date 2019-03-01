<?php
    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else {

        if($_SESSION['admin'] != 1 AND $_SESSION['admin'] != 4){
            echo '<script language="javascript">
                    window.alert("ERROR! Anda tidak memiliki hak akses untuk membuka halaman ini");
                    window.location.href="./logout.php";
                  </script>';
        } else {

            if(isset($_REQUEST['act'])){
                $act = $_REQUEST['act'];
                switch ($act) {
                    case 'add':
                        include "tambah_jadwal_seminar.php";
                        break;
                    case 'edit':
                        include "edit_jadwal_seminar_proposal.php";
                        break;  
                    case 'del':
                        include "hapus_jadwal_seminar.php";
                        break;
                }
            } else {

                $query = mysqli_query($config, "SELECT id_jadwal FROM jadwal_seminar_proposal");
                list($jadwal_seminar) = mysqli_fetch_array($query);

                //pagging
               // $limit = $jadwal_seminar;
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
                                            <li class="waves-effect waves-light hide-on-small-only"><a href="?page=jadwal_seminar" class="judul"> Jadwal Seminar Proposal</a></li>
                                            <li class="waves-effect waves-light">
                                                <a href="?page=jadwal_seminar_proposal&act=add"><i class="material-icons md-24">add_circle</i> Tambah Data</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col m5 hide-on-med-and-down">
                                        <form method="post" action="?page=jadwal_seminar">
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
                                <p class="description">Hasil pencarian untuk kata kunci <strong>"'.stripslashes($cari).'"</strong><span class="right"><a href="?page=jadwal_seminar"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col m12" id="colres">
                        <table class="bordered" id="tbl">
                            <thead class="blue lighten-4" id="head">
                                <tr>
                                    <th width="10%">No Jadwal Seminar</th>   
                                    <th width="24%">Nama Mahasiswa</th> 
                                    <th width="24%">Tanggal</th> 
                                    <th width="18%">Tindakan </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>';

                            //script untuk mencari data
                            $query = mysqli_query($config, "ELECT a.*, b.nama FROM jadwal_seminar_proposal as a
                                                                INNER JOIN mahasiswa as b ON a.nim=b.nim
                                                                WHERE b.nama '%$cari%' ORDER by a.id_jadwal DESC  LIMIT $curr, 5");
                            if(mysqli_num_rows($query) > 0){
                                $no = 1;
                                while($row = mysqli_fetch_array($query)){
                                  echo '<td>'.$row['id_jadwal'].'</td>
                                        <td>'.$row['nama'].'</td>
                                        <td>'.$row['nip'].'</td> 
                                        <td><a class="btn small blue waves-effect waves-light" href="?page=jadwal_seminar_proposal&act=edit&id_jadwal='.$row['id_jadwal'].'">
                                            <i class="material-icons">edit</i> EDIT</a> 
                                            <a class="btn small deep-orange waves-effect waves-light" href="?page=jadwal_seminar_proposal&act=del&id_jadwal='.$row['id_jadwal'].'">
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

                    $query = mysqli_query($config, "SELECT * FROM jadwal_seminar_proposal");
                    $cdata = mysqli_num_rows($query);
                    $cpg = ceil($cdata/$limit);

                    echo '<!-- Pagination START -->
                          <ul class="pagination">'; 
                        if($cdata > $limit ){    
                            //first and previous pagging
                            if($pg > 1){
                                $prev = $pg - 1;
                                echo '<li><a href="?page=jadwal_seminar&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                                      <li><a href="?page=jadwal_seminar&pg='.$prev.'"><i class="material-icons md-48">chevron_left</i></a></li>';
                            } else {
                                echo '<li class="disabled"><a href=""><i class="material-icons md-48">first_page</i></a></li>
                                      <li class="disabled"><a href=""><i class="material-icons md-48">chevron_left</i></a></li>';
                            }
                            //perulangan pagging
                            for($i=1; $i <= $cpg; $i++)
                                if($i != $pg){
                                    echo '<li class="waves-effect waves-dark"><a href="?page=jadwal_seminar_proposal&pg='.$i.'"> '.$i.' </a></li>';
                                } else {
                                    echo '<li class="active waves-effect waves-dark"><a href="?page=jadwal_seminar_proposal&pg='.$i.'"> '.$i.' </a></li>';
                                }
    
                            //last and next pagging
                            if($pg < $cpg){
                                $next = $pg + 1;
                                echo '<li><a href="?page=jadwal_seminar_proposal&pg='.$next.'"><i class="material-icons md-48">chevron_right</i></a></li>
                                      <li><a href="?page=jadwal_seminar_proposal&pg='.$cpg.'"><i class="material-icons md-48">last_page</i></a></li>';
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
                                    <th width="10%">No Jadwal Seminar</th>   
                                    <th width="24%">Nama Mahasiswa</th> 
                                    <th width="24%">Tanggal</th> 
                                        <th width="18%">Opt </th>

                                            <div id="modal" class="modal">
                                                <div class="modal-content white">
                                                    <h5>Jumlah data yang ditampilkan per halaman</h5>';
                                                    $query = mysqli_query($config, "SELECT * FROM jadwal_seminar_proposal");
                                                    list($id_sett,$jadwal_seminar) = mysqli_fetch_array($query);
                                                    echo '
                                                    <div class="row">
                                                        <form method="post" action="">
                                                            <div class="input-field col s12">
                                                                <input type="hidden" value="'.$id_sett.'" name="id_sett">
                                                                <div class="input-field col s1" style="float: left;">
                                                                    <i class="material-icons prefix md-prefix">looks_one</i>
                                                                </div>
                                                                <div class="input-field col s11 right" style="margin: -5px 0 20px;">
                                                                    <select class="browser-default validate" name="jadwal_seminar" required>
                                                                        <option value="'.$jadwal_seminar.'">'.$jadwal_seminar.'</option>
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
                                                                        $jadwal_seminar = $_REQUEST['jadwal_seminar'];
                                                                        $id_user = $_SESSION['id_user'];

                                                                        $query = mysqli_query($config, "UPDATE tbl_sett SET jadwal_seminar='$jadwal_seminar',id_user='$id_user' WHERE id_sett='$id_sett'");
                                                                        if($query == true){
                                                                            header("Location: ./admin.php?page=jadwal_seminar_proposal");
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
                             //   $query = mysqli_query($config, "SELECT * FROM jadwal_seminar_proposal ORDER by id_jadwal DESC LIMIT $curr, $limit");
                                $query = mysqli_query($config, "SELECT a.*, b.nama FROM jadwal_seminar_proposal as a
                                                                INNER JOIN mahasiswa as b ON a.nim=b.nim
                                                                 ORDER by a.id_jadwal DESC LIMIT $curr, 5");
                                     $no = 1;
                                    while($row = mysqli_fetch_array($query)){
                                      echo '
                                        <td>'.$row['id_jadwal'].'</td>
                                        <td>'.$row['nama'].'</td>
                                        <td>'.$row['tanggal'].'</td>  
                                        <td><a class="btn small blue waves-effect waves-light" href="?page=jadwal_seminar_proposal&act=edit&id_jadwal='.$row['id_jadwal'].'">
                                                    <i class="material-icons">edit</i> EDIT</a> 
                                                <a class="btn small deep-orange waves-effect waves-light" href="?page=jadwal_seminar_proposal&act=del&id_jadwal='.$row['id_jadwal'].'">
                                                    <i class="material-icons">delete</i> DEL</a>
                                        </td>
                                    </tr>
                                </tbody>';
                                }

                          echo '</table>
                        </div>
                    </div>
                    <!-- Row form END -->';

                    $query = mysqli_query($config, "SELECT * FROM jadwal_seminar_proposal");
                    $cdata = mysqli_num_rows($query);
                 //   $cpg = ceil($cdata/$limit);
                    $cpg = ceil($cdata/5);

                    echo '<br/><!-- Pagination START -->
                          <ul class="pagination">';

                    if($cdata > $limit ){

                        //first and previous pagging
                        if($pg > 1){
                            $prev = $pg - 1;
                            echo '<li><a href="?page=jadwal_seminar&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                                  <li><a href="?page=jadwal_seminar&pg='.$prev.'"><i class="material-icons md-48">chevron_left</i></a></li>';
                        } else {
                            echo '<li class="disabled"><a href=""><i class="material-icons md-48">first_page</i></a></li>
                                  <li class="disabled"><a href=""><i class="material-icons md-48">chevron_left</i></a></li>';
                        }

                        //perulangan pagging
                        for($i=1; $i <= $cpg; $i++)
                            if($i != $pg){
                                echo '<li class="waves-effect waves-dark"><a href="?page=jadwal_seminar&pg='.$i.'"> '.$i.' </a></li>';
                            } else {
                                echo '<li class="active waves-effect waves-dark"><a href="?page=jadwal_seminar&pg='.$i.'"> '.$i.' </a></li>';
                            }

                        //last and next pagging
                        if($pg < $cpg){
                            $next = $pg + 1;
                            echo '<li><a href="?page=jadwal_seminar&pg='.$next.'"><i class="material-icons md-48">chevron_right</i></a></li>
                                  <li><a href="?page=jadwal_seminar&pg='.$cpg.'"><i class="material-icons md-48">last_page</i></a></li>';
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
