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
                    case 'upload_lampiran':
                        include "upload_lampiran_pi.php";
                        break;
                    case 'edit_lampiran':
                        include "edit_lampiran_pi.php";
                        break; 
                    case 'edit':
                        include "edit_praktek_industri.php";
                        break;   
                    case 'delete':
                        include "hapus_pi_lampiran.php";
                        break; 
                    case 'print':
                        include "surat_pi.php";
                        break;
                    case 'setuju':
                        include "setuju_upload_lampiran_pi.php";
                        break;
                }
            } else {

                $query = mysqli_query($config, "SELECT id FROM lampiran_pi");
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
                                            <li class="waves-effect waves-light hide-on-small-only"><a href="?page=pi" class="judul">Pengajuan Praktek Industri</a></li>
                                            <li class="waves-effect waves-light">
                                                <!--a href="?page=pi&act=add"><i class="material-icons md-24">add_circle</i> Tambah Data</a-->
                                                <a href="?page=pi&act=upload_lampiran"><i class="material-icons md-24">add_circle</i> Upload Lampiran</a>
                                            </li>
                                        </ul>
                                    </div> 
                                    <div class="col m5 hide-on-med-and-down">
                                    <?php  if ($_SESSION['admin']!='4'){ ?>
                                        <form method="post" action="?page=pi">
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
                        <b>&nbsp;&nbsp;&nbsp;Syarat untuk pengajuan praktek industri harus upload Dokumen persyaratan</b>
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
                                <p class="description">Hasil pencarian untuk kata kunci <strong>"'.stripslashes($cari).'"</strong><span class="right"><a href="?page=pi"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
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
                                    <th width="auto">Transkip</th>
                                    <th width="auto">KRS</th> 
                                    <th width="auto">Proposal PI</th> 
                                    <th width="auto">KHS 1</th> 
                                    <th width="auto">KHS 2</th> 
                                    <th width="auto">KHS 3</th> 
                                    <th width="auto">KHS 4</th> 
                                    <th width="auto">Status</th> 
                                    <th width="10%"> </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>';

                            //script untuk mencari data 
                              $query = mysqli_query($config, "SELECT lampiran_pi.*,  
                                                                (SELECT mahasiswa.nama FROM mahasiswa WHERE mahasiswa.nim=lampiran_pi.nim) AS nama
                                                                 FROM lampiran_pi  
                                                                WHERE
                                                                	lampiran_pi.transkip LIKE '%$cari%' OR 
                                                                	lampiran_pi.krs LIKE '%$cari%' OR
                                                                	lampiran_pi.proposal_pi LIKE '%$cari%'
                                                                 ORDER by lampiran_pi.id DESC LIMIT $curr, 5");
                            if(mysqli_num_rows($query) > 0){
                                $no = 1;
                                while($row = mysqli_fetch_array($query)){ 
                                   $st=$row['status']; 
                                   echo'
                                        <td>'.$row['id'].'</td>
                                        <td>'.$row['nama'].'</td>  
                                        <td><a href="upload/'.$row['transkip'].'">'.$row['transkip'].'</a></td> 
                                        <td><a href="upload/'.$row['krs'].'">'.$row['krs'].'</a></td>  
                                        <td><a href="upload/'.$row['proposal_pi'].'">'.$row['proposal_pi'].'</a></td> 
                                        <td><a href="upload/'.$row['khs1'].'">'.$row['khs1'].'</a></td>  
                                        <td><a href="upload/'.$row['khs2'].'">'.$row['khs2'].'</a></td>  
                                        <td><a href="upload/'.$row['khs3'].'">'.$row['khs3'].'</a></td>  
                                        <td><a href="upload/'.$row['khs4'].'">'.$row['khs4'].'</a></td>  
                                        <td>';
                                            if($st=='0'){
                                                echo'NEW';
                                            }else{
                                                echo'ACC';
                                            } 
                                        echo'</td>     
                                        <td>';
                                            if($st=='0'){
                                                echo' <a class="btn small deep-green waves-effect waves-light" href="?page=pi&act=setuju&id='.$row['id'].'">
        											 <i class="material-icons">check</i></a> &nbsp;
                                                      <a class="btn small deep-green waves-effect waves-light" href="?page=pi&act=delete&id='.$row['id'].'">
        											 <i class="material-icons">delete</i></a>';
                                            }else{
                                                echo'<a class="btn small deep-BLUE waves-effect waves-light" href="?page=pi&act=add&nim='.$row['nim'].'" title="Pengajuan Praktek Industri">
                                               Pengajuan praktek industri</a>
                                                <a class="btn small blue waves-effect waves-light" href="?page=praktek_industri&act=edit&id_pi='.$cekisi['id_pi'].'">
                                                   <i class="material-icons">edit</i> edit</a> ';
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

                    $query = mysqli_query($config, "SELECT * FROM praktek_industri");
                    $cdata = mysqli_num_rows($query);
                    $cpg = ceil($cdata/$limit);

                    echo '<!-- Pagination START -->
                          <ul class="pagination">';

                    if($cdata > $limit ){

                        //first and previous pagging
                        if($pg > 1){
                            $prev = $pg - 1;
                            echo '<li><a href="?page=pi&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                                  <li><a href="?page=pi&pg='.$prev.'"><i class="material-icons md-48">chevron_left</i></a></li>';
                        } else {
                            echo '<li class="disabled"><a href=""><i class="material-icons md-48">first_page</i></a></li>
                                  <li class="disabled"><a href=""><i class="material-icons md-48">chevron_left</i></a></li>';
                        }

                        //perulangan pagging
                        for($i=1; $i <= $cpg; $i++)
                            if($i != $pg){
                                echo '<li class="waves-effect waves-dark"><a href="?page=pi&pg='.$i.'"> '.$i.' </a></li>';
                            } else {
                                echo '<li class="active waves-effect waves-dark"><a href="?page=pi&pg='.$i.'"> '.$i.' </a></li>';
                            }

                        //last and next pagging
                        if($pg < $cpg){
                            $next = $pg + 1;
                            echo '<li><a href="?page=pi&pg='.$next.'"><i class="material-icons md-48">chevron_right</i></a></li>
                                  <li><a href="?page=pi&pg='.$cpg.'"><i class="material-icons md-48">last_page</i></a></li>';
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
                                    <th width="auto">Transkip</th>
                                    <th width="auto">KRS</th> 
                                    <th width="auto">Proposal PI	</th> 
                                    <th width="auto">KHS 1	</th> 
                                    <th width="auto">KHS 2	</th> 
                                    <th width="auto">KHS 3	</th>                                    
                                    <th width="auto">KHS 4	</th>  
                                    <th width="auto">Status</th>
                                    <th width="10%"> </th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>'; 
                                $grup=$_SESSION['admin'];
                                if ($grup=='4'){
                                    $grp="WHERE lampiran_pi.nim='".$_SESSION['username']."'";
                                }else{
                                    $grp='';  
                                }
                                //script untuk menampilkan data 
                                $query = mysqli_query($config, "
                                                                SELECT lampiran_pi.*, 
                                                                (SELECT mahasiswa.nama FROM mahasiswa WHERE mahasiswa.nim=lampiran_pi.nim) AS nama
                                                                 FROM lampiran_pi  
                                                                 $grp
                                                                ORDER by lampiran_pi.id DESC LIMIT $curr, 5"); 
                                    $no = 1;
                                    while($row = mysqli_fetch_array($query)){   
                                            $st=$row['status']; 
                                            $cekisi=mysqli_fetch_array(mysqli_query($config, "SELECT * FROM praktek_industri WHERE nim='".$row['nim']."'"));
                                            $hit=count($cekisi['nim']);
                                      echo '
                                        <td>'.$row['id'].' </td>
                                        <td>'.$row['nama'].' </td>  
                                        <td><a href="upload/'.$row['transkip'].'">'.$row['transkip'].'</a></td> 
                                        <td><a href="upload/'.$row['krs'].'">'.$row['krs'].'</a></td>  
                                        <td><a href="upload/'.$row['proposal_pi'].'">'.$row['proposal_pi'].'</a></td> 
                                        <td><a href="upload/'.$row['khs1'].'">'.$row['khs1'].'</a></td>  
                                        <td><a href="upload/'.$row['khs2'].'">'.$row['khs2'].'</a></td>  
                                        <td><a href="upload/'.$row['khs3'].'">'.$row['khs3'].'</a></td>  
                                        <td><a href="upload/'.$row['khs4'].'">'.$row['khs4'].'</a></td>  
                                        <td>';
                                            if($st=='0'){
                                                echo'NEW';
                                            }else{
                                                echo'ACC';
                                            } 
                                        echo'</td>     
                                        <td>';
                                            if($st=='0'){
                                                echo' <a class="btn small deep-green waves-effect waves-light" href="?page=pi&act=setuju&id='.$row['id'].'">
        											 <i class="material-icons">check</i></a> &nbsp;
                                                <a class="btn small yellow waves-effect waves-light" href="?page=praktek_industri&act=edit_lampiran&id_pi='.$row['id'].'">
                                                   <i class="material-icons">edit</i></a> 
                                                      <a class="btn small deep-green waves-effect waves-light" href="?page=pi&act=delete&id='.$row['id'].'">
        											 <i class="material-icons">delete</i></a>';
                                            }else if ($hit==0){
                                                echo'<a class="btn small deep-BLUE waves-effect waves-light" href="?page=pi&act=add&nim='.$row['nim'].'" title="Pengajuan Praktek Industri">
                                               Pengajuan Praktek Industri</a> ';
                                            }
                                            
                                            if($hit!=0){
                                                echo'&nbsp; <a class="btn small deep-green waves-effect waves-light" href="surat_pi.php?id='.$cekisi['id_pi'].'">
        											 <i class="material-icons">print</i></a> 
                                                <a class="btn small blue waves-effect waves-light" href="?page=praktek_industri&act=edit&id_pi='.$cekisi['id_pi'].'">
                                                   <i class="material-icons">edit</i> EDIT</a>';
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
                    if ($_SESSION['admin']!=4){
                        $query = mysqli_query($config, "SELECT * FROM lampiran_pi");
                    }else{
                        $query = mysqli_query($config, "SELECT * FROM lampiran_pi WHERE nim='".$_SESSION['username']."'");
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
                            echo '<li><a href="?page=pi&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                                  <li><a href="?page=pi&pg='.$prev.'"><i class="material-icons md-48">chevron_left</i></a></li>';
                        } else {
                            echo '<li class="disabled"><a href=""><i class="material-icons md-48">first_page</i></a></li>
                                  <li class="disabled"><a href=""><i class="material-icons md-48">chevron_left</i></a></li>';
                        }
                        //perulangan pagging
                        for($i=1; $i <= $cpg; $i++)
                            if($i != $pg){
                                echo '<li class="waves-effect waves-dark"><a href="?page=pi&pg='.$i.'"> '.$i.' </a></li>';
                            } else {
                                echo '<li class="active waves-effect waves-dark"><a href="?page=pi&pg='.$i.'"> '.$i.' </a></li>';
                            }
                        //last and next pagging
                        if($pg < $cpg){
                            $next = $pg + 1;
                            echo '<li><a href="?page=pi&pg='.$next.'"><i class="material-icons md-48">chevron_right</i></a></li>
                                  <li><a href="?page=pi&pg='.$cpg.'"><i class="material-icons md-48">last_page</i></a></li>';
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
