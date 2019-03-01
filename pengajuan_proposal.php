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
                        include "tambah_pengajuan_proposal.php";
                        break;
                    case 'edit':
                        include "edit_pengajuan_proposal.php";
                        break;  
                    case 'del':
                        include "hapus_pengajuan_proposal.php";
                        break;
                    case 'setuju':
                        include "setuju_proposal.php";
                        break;
                    case 'tolak':
                        include "revisi_pengajuan_proposal.php";
                        break;
                    case 'print':
                        include "lembar_pernyataan.php";
                        break;
                }
            } else {

                $query = mysqli_query($config, "SELECT id FROM pengajuan_proposal_skripsi");
                list($pengajuan_proposal) = mysqli_fetch_array($query);

                //pagging
               // $limit = $pengajuan_proposal;
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
                                            <li class="waves-effect waves-light hide-on-small-only"><a href="?page=pengajuan_proposal" class="judul">Pengajuan Judul Proposal Skripsi</a></li>
                                            <li class="waves-effect waves-light">
                                                <a href="?page=pengajuan_proposal&act=add"><i class="material-icons md-24">add_circle</i> Tambah Data</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col m5 hide-on-med-and-down">
                                    <?php  if ($_SESSION['admin']!='4'){ ?>
                                        <form method="post" action="?page=pengajuan_proposal">
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
                                <p class="description">Hasil pencarian untuk kata kunci <strong>"'.stripslashes($cari).'"</strong><span class="right"><a href="?page=pengajuan_proposal"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col m12" id="colres">
                        <table class="bordered" id="tbl">
                            <thead class="blue lighten-4" id="head">
                                <tr>
                                    <th width="5%">NO</th>
                                    <th width="8%">NIM</th>
                                    <th width="13%">Nama Mahasiswa</th> 
                                    <th width="15%">Dosen Pembimbing 1</th>
                                    <th width="15%">Dosen Pembimbing 2</th>
                                    <th width="20%">Judul 1</th> 
                                    <th width="20%">Judul 2</th> 
                                    <th width="20%">Judul 3</th> 
                                    <th width="6%">Status</th>
                                    <th width="10%"> </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>';

                            //script untuk mencari data
                              $query = mysqli_query($config, "SELECT
                                                                pengajuan_proposal_skripsi.id,
                                                                (SELECT mahasiswa.nim FROM mahasiswa WHERE mahasiswa.nim=pengajuan_proposal_skripsi.nim) AS nim,
                                                                (SELECT mahasiswa.nama FROM mahasiswa WHERE mahasiswa.nim=pengajuan_proposal_skripsi.nim) AS nama_mahasiswa,
                                                                (SELECT dosen.nama FROM dosen WHERE dosen.id_dosen=pengajuan_proposal_skripsi.id_pembimbing1) AS dosen1,
                                                                (SELECT dosen.nama FROM dosen WHERE dosen.id_dosen=pengajuan_proposal_skripsi.id_pembimbing2) AS dosen2,
                                                                pengajuan_proposal_skripsi.judul_1,
                                                                pengajuan_proposal_skripsi.judul_2,
                                                                pengajuan_proposal_skripsi.judul_3,
                                                                pengajuan_proposal_skripsi.pilih_judul,
                                                                pengajuan_proposal_skripsi.`status`
                                                                FROM
                                                                pengajuan_proposal_skripsi
                                                                LEFT JOIN mahasiswa ON pengajuan_proposal_skripsi.nim=mahasiswa.id_mahasiswa
                                                                WHERE
                                                                	mahasiswa.nama LIKE '%$cari%' OR pengajuan_proposal_skripsi.judul_1 LIKE '%$cari%'
                                                                     OR pengajuan_proposal_skripsi.judul_2 LIKE '%$cari%'  OR pengajuan_proposal_skripsi.judul_2 LIKE '%$cari%'
                                                                 ORDER by pengajuan_proposal_skripsi.id DESC LIMIT $curr, 5");
                            if(mysqli_num_rows($query) > 0){
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
                                        <td>'.$row['dosen1'].'</td>  
                                        <td>'.$row['dosen2'].'</td>';
                                        if($row['judul_1']==$row['pilih_judul']){
                                           echo'<td><b>'.$row['judul_1'].'</b></td>    
                                                <td>'.$row['judul_2'].'</td>    
                                                <td>'.$row['judul_3'].'</td>';  
                                        }else if($row['judul_2']==$row['pilih_judul']){
                                           echo'<td>'.$row['judul_1'].'</td>    
                                                <td><b>'.$row['judul_2'].'</b></td>    
                                                <td>'.$row['judul_3'].'</td>';  
                                        }else if($row['judul_3']==$row['pilih_judul']){
                                           echo'<td>'.$row['judul_1'].'</td>    
                                                <td>'.$row['judul_2'].'</td>    
                                                <td><b>'.$row['judul_3'].'</b></td>';  
                                        }else{
                                           echo'<td>'.$row['judul_1'].'</td>    
                                                <td>'.$row['judul_2'].'</td>    
                                                <td>'.$row['judul_3'].'</td>';    
                                        }
                                   echo'   
                                        <td>'.$st.'</td>   
                                        <td>';
                                            if ($_SESSION['admin']=='1'){ 
												if ($row['status']=='1'){
													echo'<a class="btn small deep-BLUE waves-effect waves-light" href="lembar_pernyataan.php?id='.$row['id'].'">
													 <i class="material-icons">PRINT</i> PRINT</a>';	
												}else{
                                                echo'<a class="btn small deep-orange waves-effect waves-light" href="?page=pengajuan_proposal&act=tolak&id='.$row['id'].'" target="_blank">
                                                 <i class="material-icons">close</i>check</a>';
												}
                                            }else{
												if ($row['status']=='1'){
													echo'<a class="btn small deep-BLUE waves-effect waves-light" href="lembar_pernyataan.php?id='.$row['id'].'">
													 <i class="material-icons">print</i> PRINT</a>';	
												}else{
													echo'<a class="btn small deep-orange waves-effect waves-light" href="?page=pengajuan_proposal&act=del&id='.$row['id'].'">
													 <i class="material-icons">delete</i> DEL</a>';	
												}
                                                
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

                    $query = mysqli_query($config, "SELECT * FROM pengajuan_proposal_skripsi");
                    $cdata = mysqli_num_rows($query);
                    $cpg = ceil($cdata/$limit);

                    echo '<!-- Pagination START -->
                          <ul class="pagination">';

                    if($cdata > $limit ){

                        //first and previous pagging
                        if($pg > 1){
                            $prev = $pg - 1;
                            echo '<li><a href="?page=pengajuan_proposal&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                                  <li><a href="?page=pengajuan_proposal&pg='.$prev.'"><i class="material-icons md-48">chevron_left</i></a></li>';
                        } else {
                            echo '<li class="disabled"><a href=""><i class="material-icons md-48">first_page</i></a></li>
                                  <li class="disabled"><a href=""><i class="material-icons md-48">chevron_left</i></a></li>';
                        }

                        //perulangan pagging
                        for($i=1; $i <= $cpg; $i++)
                            if($i != $pg){
                                echo '<li class="waves-effect waves-dark"><a href="?page=pengajuan_proposal&pg='.$i.'"> '.$i.' </a></li>';
                            } else {
                                echo '<li class="active waves-effect waves-dark"><a href="?page=pengajuan_proposal&pg='.$i.'"> '.$i.' </a></li>';
                            }

                        //last and next pagging
                        if($pg < $cpg){
                            $next = $pg + 1;
                            echo '<li><a href="?page=pengajuan_proposal&pg='.$next.'"><i class="material-icons md-48">chevron_right</i></a></li>
                                  <li><a href="?page=pengajuan_proposal&pg='.$cpg.'"><i class="material-icons md-48">last_page</i></a></li>';
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
                                    <th width="5%">NO</th>
                                    <th width="8%">NIM</th>
                                    <th width="13%">Nama Mahasiswa</th> 
                                    <th width="15%">Dosen Pembimbing 1</th>
                                    <th width="15%">Dosen Pembimbing 2</th>
                                    <th width="20%">Judul 1</th> 
                                    <th width="20%">Judul 2</th> 
                                    <th width="20%">Judul 3</th> 
                                    <th width="6%">Status</th>
                                    <th width="10%"></th>
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
                                                                pengajuan_proposal_skripsi.id,
                                                                (SELECT mahasiswa.nim FROM mahasiswa WHERE mahasiswa.nim=pengajuan_proposal_skripsi.nim) AS nim,
                                                                (SELECT mahasiswa.nama FROM mahasiswa WHERE mahasiswa.nim=pengajuan_proposal_skripsi.nim) AS nama_mahasiswa,
                                                                (SELECT dosen.nama FROM dosen WHERE dosen.id_dosen=pengajuan_proposal_skripsi.id_pembimbing1) AS dosen1,
                                                                (SELECT dosen.nama FROM dosen WHERE dosen.id_dosen=pengajuan_proposal_skripsi.id_pembimbing2) AS dosen2,
                                                                pengajuan_proposal_skripsi.judul_1,
                                                                pengajuan_proposal_skripsi.judul_2,
                                                                pengajuan_proposal_skripsi.judul_3,
                                                                pengajuan_proposal_skripsi.pilih_judul,
                                                                pengajuan_proposal_skripsi.`status`
                                                                FROM
                                                                pengajuan_proposal_skripsi
                                                                $grp 
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
                                        <td>'.$row['dosen1'].'</td>  
                                        <td>'.$row['dosen2'].'</td>';
                                        if($row['judul_1']==$row['pilih_judul']){
                                           echo'<td><b>'.$row['judul_1'].'</b></td>    
                                                <td>'.$row['judul_2'].'</td>    
                                                <td>'.$row['judul_3'].'</td>';  
                                        }else if($row['judul_2']==$row['pilih_judul']){
                                           echo'<td>'.$row['judul_1'].'</td>    
                                                <td><b>'.$row['judul_2'].'</b></td>    
                                                <td>'.$row['judul_3'].'</td>';  
                                        }else if($row['judul_3']==$row['pilih_judul']){
                                           echo'<td>'.$row['judul_1'].'</td>    
                                                <td>'.$row['judul_2'].'</td>    
                                                <td><b>'.$row['judul_3'].'</b></td>';  
                                        }else{
                                           echo'<td>'.$row['judul_1'].'</td>    
                                                <td>'.$row['judul_2'].'</td>    
                                                <td>'.$row['judul_3'].'</td>';    
                                        }
                                   echo'      
                                        <td>'.$st.'</td>   
                                        <td>';
                                            if ($_SESSION['admin']=='1'){ 
												if ($row['status']=='1'){
													echo'<a class="btn small deep-BLUE waves-effect waves-light" href="lembar_pernyataan.php?id='.$row['id'].'">
													 <i class="material-icons">print</i> PRINT</a>';	
												}else{
													echo'<a class="btn small deep-green waves-effect waves-light" href="?page=pengajuan_proposal&act=tolak&id='.$row['id'].'">
													 <i class="material-icons">check</i>Setuju</a>&nbsp;';
                                                      
												} 
                                            }else{
												if ($row['status']=='1'){
													echo'<a class="btn small deep-BLUE waves-effect waves-light" href="lembar_pernyataan.php?id='.$row['id'].'"  target="_blank">
													 <i class="material-icons">print</i> PRINT</a>';	
												}else{
													echo'<a class="btn small deep-orange waves-effect waves-light" href="?page=pengajuan_proposal&act=del&id='.$row['id'].'">
													 <i class="material-icons">delete</i> DEL</a>';	
												}
                                                
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
                    if ($_SESSION['admin']!=4){
                        $query = mysqli_query($config, "SELECT * FROM pengajuan_proposal_skripsi");
                    }else{
                        $query = mysqli_query($config, "SELECT * FROM pengajuan_proposal_skripsi WHERE nim='".$_SESSION['username']."'");
                    }
                    $cdata = mysqli_num_rows($query);
                 //   $cpg = ceil($cdata/$limit);
                    $cpg = ceil($cdata/5);
                    echo '<br/><!-- Pagination START -->
                          <ul class="pagination">';
                    if($cdata > $limit ){

                        //first and previous pagging
                        if($pg > 1){
                            $prev = $pg - 1;
                            echo '<li><a href="?page=pengajuan_proposal&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                                  <li><a href="?page=pengajuan_proposal&pg='.$prev.'"><i class="material-icons md-48">chevron_left</i></a></li>';
                        } else {
                            echo '<li class="disabled"><a href=""><i class="material-icons md-48">first_page</i></a></li>
                                  <li class="disabled"><a href=""><i class="material-icons md-48">chevron_left</i></a></li>';
                        }
                        //perulangan pagging
                        for($i=1; $i <= $cpg; $i++)
                            if($i != $pg){
                                echo '<li class="waves-effect waves-dark"><a href="?page=pengajuan_proposal&pg='.$i.'"> '.$i.' </a></li>';
                            } else {
                                echo '<li class="active waves-effect waves-dark"><a href="?page=pengajuan_proposal&pg='.$i.'"> '.$i.' </a></li>';
                            }
                        //last and next pagging
                        if($pg < $cpg){
                            $next = $pg + 1;
                            echo '<li><a href="?page=pengajuan_proposal&pg='.$next.'"><i class="material-icons md-48">chevron_right</i></a></li>
                                  <li><a href="?page=pengajuan_proposal&pg='.$cpg.'"><i class="material-icons md-48">last_page</i></a></li>';
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
