<?php  
                $iddosen=$_GET['id_dosen'];
                $query = mysqli_query($config, "SELECT id_karya FROM karya_ilmiah_dosen WHERE id_dosen='".$iddosen."'");
                list($dosen) = mysqli_fetch_array($query);

                //pagging
               // $limit = $dosen;
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
                                            <li class="waves-effect waves-light hide-on-small-only"><a href="?page=karya_ilmiah" class="judul"> Data Karya Ilmiah Dosen </a></li>
                                            <li class="waves-effect waves-light">
                                            <?php if ($_SESSION['admin']!=4) { ?>
                                                <a href="?page=dosen&act=karya_ilmiah&act=add_karya&id_dosen=<?php echo $iddosen; ?>"><i class="material-icons md-24">add_circle</i> Tambah Data</a>
                                                &nbsp; 
                                            <?php } ?>
                                                <a href="?page=dosen&act=karya_ilmiah&act=print_karya&id_dosen=<?php echo $iddosen; ?>"><i class="material-icons md-24">print</i> Print</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col m5 hide-on-med-and-down">
                                        <form method="post" action="?page=dosen">
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
                
                   //script untuk mencari data dosen
                    if(isset($_REQUEST['submit'])){
                    $cari = mysqli_real_escape_string($config, $_REQUEST['cari']);
                        echo '
                        <div class="col s12" style="margin-top: -18px;">
                            <div class="card blue lighten-5">
                                <div class="card-content">
                                <p class="ription">Hasil pencarian untuk kata kunci <strong>"'.stripslashes($cari).'"</strong><span class="right"><a href="?page=dosen"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col m12" id="colres">
                        <table class="bordered" id="tbl">
                            <thead class="blue lighten-4" id="head">
                                <tr>
                                    <th width="8%">No</th>
                                    <th width="20%">Nama Dosen</th>
                                    <th width="15%">NIP/NIDN</th> 
                                    <th width="15%">Judul</th> 
                                    <th width="15%">Tanggal Publikasi</th> 
                                    <th width="30%">Publikasi</th>  
                                    <th width="15%">Tindakan </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>';

                            //script untuk mencari data dosen
                             $query = mysqli_query($config, "SELECT a.*, b.nama FROM karya_ilmiah_dosen as a
                                                             LEFT JOIN dosen AS b ON a.id_dosen=b.id_dosen
                                                             WHERE a.judul LIKE '%$cari%' AND a.id_dosen='".$iddosen."' or a.publikasi LIKE '%$cari%' AND a.id_dosen='".$iddosen."' ORDER by id_karya  LIMIT $curr, 5");
                            if(mysqli_num_rows($query) > 0){
                                $no = 1;
                                while($row = mysqli_fetch_array($query)){
                                  echo ' 
                                        <td>'.$no.'</td>
                                        <td>'.$row['nama'].'</td>
                                        <td>'.$row['nip'].'</td> 
										<td>'.$row['judul'].'</td> 
                                        <td>'.$row['tanggal_publikasi'].'</td>  
                                        <td>'.$row['publikasi'].'</td>   
                                        <td>';
                                        if ($_SESSION['admin']!=4) {
                                            echo'
                                            <a class="btn small blue waves-effect waves-light" href="?page=dosen&act=edit&id_dosen='.$row['id_dosen'].'">
                                                   <i class="material-icons">edit</i> EDIT</a> 
                                               <a class="btn small deep-orange waves-effect waves-light" href="?page=dosen&act=del&id_dosen='.$row['id_dosen'].'">
                                                   <i class="material-icons">delete</i> DEL</a>'; 
                                        }
                                        echo'
                                        </td>
                                    </tr>
                                </tbody>';
                                    $no++;
                                }
                            } else {
                                echo '<tr><td colspan="5"><center><p class="add">Tidak ada data yang ditemukan</p></center></td></tr>';
                            }
                             echo '</table><br/><br/>
                        </div>
                    </div>
                    <!-- Row form END -->';

                    $query = mysqli_query($config, "SELECT * FROM dosen");
                    $cdata = mysqli_num_rows($query);
                    $cpg = ceil($cdata/$limit);

                    echo '<!-- Pagination START -->
                          <ul class="pagination">';

                    if($cdata > $limit ){

                        //first and previous pagging
                        if($pg > 1){
                            $prev = $pg - 1;
                            echo '<li><a href="?page=dosen&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                                  <li><a href="?page=dosen&pg='.$prev.'"><i class="material-icons md-48">chevron_left</i></a></li>';
                        } else {
                            echo '<li class="disabled"><a href=""><i class="material-icons md-48">first_page</i></a></li>
                                  <li class="disabled"><a href=""><i class="material-icons md-48">chevron_left</i></a></li>';
                        }

                        //perulangan pagging
                        for($i=1; $i <= $cpg; $i++)
                            if($i != $pg){
                                echo '<li class="waves-effect waves-dark"><a href="?page=dosen&pg='.$i.'"> '.$i.' </a></li>';
                            } else {
                                echo '<li class="active waves-effect waves-dark"><a href="?page=dosen&pg='.$i.'"> '.$i.' </a></li>';
                            }

                        //last and next pagging
                        if($pg < $cpg){
                            $next = $pg + 1;
                            echo '<li><a href="?page=dosen&pg='.$next.'"><i class="material-icons md-48">chevron_right</i></a></li>
                                  <li><a href="?page=dosen&pg='.$cpg.'"><i class="material-icons md-48">last_page</i></a></li>';
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
                        /*-------------------tampil data dosen-----------*/
                        echo '
                        <div class="col m12" id="colres">
                            <table class="bordered" id="tbl">
                                <thead class="blue lighten-4" id="head">
                                    <tr> 
                                        <th width="8%">No</th>
                                        <th width="20%">Nama Dosen</th>
                                        <th width="15%">NIP/NIDN</th> 
                                        <th width="15%">Judul</th> 
                                        <th width="15%">Tanggal Publikasi</th> 
                                        <th width="30%">Publikasi</th>  
                                        <th width="15%">Tindakan </th>
                                    </tr>
                                </thead>
                                <tbody>';  
                                
                                   $query = mysqli_query($config, "SELECT a.*,b.* FROM karya_ilmiah_dosen as a
                                                                 LEFT JOIN dosen as b ON a.id_dosen=b.id_dosen 
                                                                 WHERE  a.id_dosen='".$iddosen."'  
                                                                 ORDER by id_karya  LIMIT 0,5");
                                    $no = 1;
                                        while($row = mysqli_fetch_array($query)){
                                          echo ' 
                                            <tr>
                                                <td>'.$no.'</td>
                                                <td>'.$row['nama'].'</td>
                                                <td>'.$row['nip'].'</td> 
        										<td>'.$row['judul'].'</td> 
                                                <td>'.$row['tanggal_publikasi'].'</td>  
                                                <td>'.$row['publikasi'].'</td>   
                                                <td> ';
                                                    if ($_SESSION['admin']!=4) {
                                                        echo'
                                                        <a class="btn small blue waves-effect waves-light" href="?page=dosen&act=edit&id_dosen='.$row['id_dosen'].'">
                                                            <i class="material-icons">edit</i> EDIT</a> 
                                                        <a class="btn small deep-orange waves-effect waves-light" href="?page=dosen&act=del&id_dosen='.$row['id_dosen'].'">
                                                            <i class="material-icons">delete</i> DEL</a>'; 
                                                    }
                                                    echo'
                                                </td>
                                        </tr>';
                                    $no++;
                                    }

                          echo '</tbody></table>
                        </div>
                    </div>
                    <!-- Row form END -->';

                    $query = mysqli_query($config, "SELECT * FROM karya_ilmiah_dosen WHERE id_dosen='".$iddosen."'");
                    $cdata = mysqli_num_rows($query);
                 //   $cpg = ceil($cdata/$limit);
                    $cpg = ceil($cdata/5);

                    echo '<br/><!-- Pagination START -->
                          <ul class="pagination">';

                    if($cdata > $limit ){

                        //first and previous pagging
                        if($pg > 1){
                            $prev = $pg - 1;
                            echo '<li><a href="?page=dosen&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                                  <li><a href="?page=dosen&pg='.$prev.'"><i class="material-icons md-48">chevron_left</i></a></li>';
                        } else {
                            echo '<li class="disabled"><a href=""><i class="material-icons md-48">first_page</i></a></li>
                                  <li class="disabled"><a href=""><i class="material-icons md-48">chevron_left</i></a></li>';
                        }

                        //perulangan pagging
                        for($i=1; $i <= $cpg; $i++)
                            if($i != $pg){
                                echo '<li class="waves-effect waves-dark"><a href="?page=dosen&pg='.$i.'"> '.$i.' </a></li>';
                            } else {
                                echo '<li class="active waves-effect waves-dark"><a href="?page=dosen&pg='.$i.'"> '.$i.' </a></li>';
                            }

                        //last and next pagging
                        if($pg < $cpg){
                            $next = $pg + 1;
                            echo '<li><a href="?page=dosen&pg='.$next.'"><i class="material-icons md-48">chevron_right</i></a></li>
                                  <li><a href="?page=dosen&pg='.$cpg.'"><i class="material-icons md-48">last_page</i></a></li>';
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
?>
