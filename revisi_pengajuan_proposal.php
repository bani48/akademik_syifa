<?php
    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else { 
                if(isset($_REQUEST['submit'])){

                    $id = $_REQUEST['id'];
                    $admin = $_REQUEST['admin'];
   
                            $query = mysqli_query($config, "UPDATE pengajuan_proposal_skripsi SET nim='".$_POST['mahasiswa']."', id_pembimbing1='".$_POST['dosen1']."', id_pembimbing2='".$_POST['dosen2']."', pilih_judul='".$_POST['pilih_judul']."', status=1 WHERE id='".$_POST['id']."'");

                            if($query == true){
                                $_SESSION['succEdit'] = "Data Sudah direvisi";
                                header("Location: ./admin.php?page=pengajuan_proposal&sub=usr");
                                die();
                            } else {
                                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                echo '<script language="javascript">
                                        window.location.href="./admin.php?page=pengajuan_proposal&act=tolak&id='.$id.'";
                                      </script>';
                            }  
                } else {

                    $id = mysqli_real_escape_string($config, $_REQUEST['id']);
                    $query = mysqli_query($config, "SELECT * FROM pengajuan_proposal_skripsi WHERE id='$id'");
                    if(mysqli_num_rows($query) > 0){
                        $no = 1;
                        while($u = mysqli_fetch_array($query)){?>

                        <!-- Row Start -->
                        <div class="row"> 
                            <!-- Secondary Nav START -->
                            <div class="col s12">
                                <nav class="secondary-nav">
                                    <div class="nav-wrapper blue-grey darken-1">
                                        <ul class="left">
                                            <li class="waves-effect waves-light  tooltipped" data-position="right" data-tooltip="Menu ini hanya untuk mengedit  pengajuan_proposal."><a href="#" class="judul"><i class="material-icons">mode_edit</i> ACC Pengajuan Proposal Skripsi</a></li>
                                        </ul>
                                    </div>
                                </nav>
                            </div>
                            <!-- Secondary Nav END -->
                        </div>
                        <!-- Row END -->

                        <?php
                            if(isset($_SESSION['errQ'])){
                                $errQ = $_SESSION['errQ'];
                                echo '<div id="alert-message" class="row">
                                        <div class="col m12">
                                            <div class="card red lighten-5">
                                                <div class="card-content notif">
                                                    <span class="card-title red-text"><i class="material-icons md-36">clear</i> '.$errQ.'</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                                unset($_SESSION['errQ']);
                            }
                        ?>

                        <!-- Row form Start -->
                        <div class="row jarak-form"> 
                            <!-- Form START -->
                            <form class="col s12" method="post" action="?page=pengajuan_proposal&sub=usr&act=tolak"> 
                                 <table style="width: 100%;">
                                    <tr>
                                        <td style="width: 20%;">ID <input type="radio" button/>aa</td>
                                        <td> <input id="kd" type="text" class="validate" maxlength="30" name="id" value="<?php echo $id; ?>" readonly="" required></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 20%;">Mahasiswa</td>
                                        <td>
                                             <select name="mahasiswa"> 
                                                <?php
                                                    $sql =mysqli_query($config,"SELECT * FROM mahasiswa ORDER BY nim='".$u['nim']."' DESC");  
                                                            while($row = mysqli_fetch_array($sql))
                                                               {
                                                                 echo "<option value='".$row['nim']."'>$row[nama]</option>"; 
                                                                }  
                                                             ?>
                                             </select> </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 20%;">Dosen Pembimbing 1 </td>
                                        <td>
                                            <select name="dosen1"> 
                                                    <?php 
                                                        $hit="";
                                                        $pb1="";
                                                        $cek1=mysqli_query($config,"SELECT COUNT(*)as hit,id_pembimbing1 FROM pengajuan_proposal_skripsi GROUP BY id_pembimbing1");
                                                        $jum=mysqli_num_rows($cek1); 
                                                        
                                                        if($jum>0){ 
                                                            while($dt = mysqli_fetch_array($cek1))
                                                            {  
                                                                $hit=$dt['hit'];
                                                                $pb1=$dt['id_pembimbing1']; 
                                                              
                                                                if ($hit>='15'){
                                                                  $sql =mysqli_query($config,"SELECT * FROM dosen WHERE jabatan_fungsional IN('Lektor','Lektor Kepala') AND id_dosen<>'$pb1' ORDER BY id_dosen='".$u['id_pembimbing1']."' DESC");  
                                                                        while($row = mysqli_fetch_array($sql))
                                                                           {
                                                                            echo "<option value='".$row['id_dosen']."'>$row[nama]</option>";  
                                                                           }     
                                                                }else{ 
                                                                  $sql =mysqli_query($config,"SELECT * FROM dosen WHERE jabatan_fungsional IN('Lektor','Lektor Kepala') GROUP BY id_dosen ORDER BY id_dosen='".$u['id_pembimbing1']."' DESC");  
                                                                    while($row = mysqli_fetch_array($sql))
                                                                       {
                                                                         echo "<option value='".$row['id_dosen']."'>$row[nama]</option>";  
                                                                       }  
                                                                } 
                                                            } 
                                                        }else{ 
                                                              $sql =mysqli_query($config,"SELECT * FROM dosen WHERE jabatan_fungsional IN('Lektor','Lektor Kepala') GROUP BY id_dosen ORDER BY id_dosen='".$u['id_pembimbing1']."' DESC");  
                                                                    while($row = mysqli_fetch_array($sql))
                                                                       {
                                                                         echo "<option value='".$row['id_dosen']."'>$row[nama]</option>";  
                                                                       }  
                                                        }
                                                                                                
                                                    ?> 
                                            </select> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 20%;">Dosen Pembimbing 2</td>
                                        <td>  <select name="dosen2"> 
                                                    <?php 
                                                        $hit2="";
                                                        $pb2="";
                                                        $cek2=mysqli_query($config,"SELECT COUNT(*)as hit,id_pembimbing2 FROM pengajuan_proposal_skripsi GROUP BY id_pembimbing2");
                                                        $jum=mysqli_num_rows($cek2); 
                                                        
                                                        if($jum>0){ 
                                                            while($dt = mysqli_fetch_array($cek2))
                                                            {  
                                                                $hit2=$dt['hit'];
                                                                $pb2=$dt['id_pembimbing1']; 
                                                              
                                                                if ($hit2>'3'){
                                                                  $sql =mysqli_query($config,"SELECT * FROM dosen WHERE jabatan_fungsional IN('Tenaga Pendidik','Asisten Ahli') AND id_dosen<>'$pb2' ORDER BY id_dosen='".$u['id_pembimbing2']."' DESC");  
                                                                        while($row = mysqli_fetch_array($sql))
                                                                           {
                                                                            echo "<option value='".$row['id_dosen']."'>$row[nama]</option>";  
                                                                           }     
                                                                }else{ 
                                                                  $sql =mysqli_query($config,"SELECT * FROM dosen WHERE jabatan_fungsional IN('Tenaga Pendidik','Asisten Ahli') GROUP BY id_dosen ORDER BY id_dosen='".$u['id_pembimbing2']."' DESC");  
                                                                    while($row = mysqli_fetch_array($sql))
                                                                       {
                                                                         echo "<option value='".$row['id_dosen']."'>$row[nama]</option>";  
                                                                       }  
                                                                } 
                                                            } 
                                                        }else{ 
                                                              $sql =mysqli_query($config,"SELECT * FROM dosen WHERE jabatan_fungsional IN('Tenaga Pendidik','Asisten Ahli') GROUP BY id_dosen ORDER BY id_dosen='".$u['id_pembimbing2']."' DESC");  
                                                                    while($row = mysqli_fetch_array($sql))
                                                                       {
                                                                         echo "<option value='".$row['id_dosen']."'>$row[nama]</option>";  
                                                                       }  
                                                        }                                     
                                                    ?> 
                                            </select>     
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Pilih Judul</td>
                                        <td><select name="pilih_judul">
                                                <?php
                                                    $jd=mysqli_fetch_array(mysqli_query($config,"SELECT * FROM pengajuan_proposal_skripsi WHERE id='$id'"));
                                                    echo "<option value='".$jd['judul_1']."'>".$jd['judul_1']."</option>
                                                          <option value='".$jd[judul_2]."'>$jd[judul_2]</option>
                                                          <option value='".$jd[judul_3]."'>$jd[judul_3]</option>";  
                                                  
                                                ?>
                                            </select></td>
                                    </tr>
                                     
                                    <tr>
                                        <td colspan="2"><center>
                                            <div class="row">
                                                <div class="col 6">
                                                    <button type="submit" name="submit" class="btn-large blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                                                </div>
                                                <div class="col 6">
                                                    <a href="?page=pengajuan_proposal" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
                                                </div>
                                            </div></center></td>
                                    </tr>
                                </table>
                                </form>
                            <!-- Form END -->

                        </div>
                        <!-- Row form END --> 
                        <?php
                        }
                    }
                }  
    }
?> 