<link rel="stylesheet" href="/resources/demos/style.css"><link rel="stylesheet" href="/resources/demos/style.css">
  <script src="asset/js/jquery-1.12.4.js"></script>
  <script src="asset/js/jquery-ui.js"></script> 
  <script>
  $( function() {
        $( "#datepicker" ).datepicker({dateFormat:'yy-mm-dd'});
        $( "#datepicker2" ).datepicker({dateFormat:'yy-mm-dd'});
  } );
  </script>
<?php

    $sql ="SELECT max(id_ph) as id_ph from pengajuan_hasil_seminar_skripsi";
    $hasil = mysqli_query($config,$sql);
    $data = mysqli_fetch_array($hasil); 
    $lastID = $data['id_ph'];
    $lastNoUrut = substr($lastID, 2, 4);
    $nextNoUrut = $lastNoUrut + 1;
    $id_ph = "PS".sprintf("%03s",$nextNoUrut); 
                      
    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else {

        if($_SESSION['admin'] != 1 AND $_SESSION['admin'] != 4){
            echo '<script language="javascript">
                    window.alert("ERROR! Anda tidak memiliki hak akses untuk menambahkan data");
                    window.location.href="./admin.php?page=pengajuan_hasil_seminar";
                  </script>';
        } else {
            if(isset($_REQUEST['submit'])){
                //validasi form kosong
                if($_REQUEST['id_ph'] == "" || $_REQUEST['mahasiswa'] == "" || $_REQUEST['judul_proposal'] == ""){
                    $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
                    echo '<script language="javascript">window.history.back();</script>';
                } else {

                    $id_ph = $_REQUEST['id_ph'];
                    $mahasiswa = $_REQUEST['mahasiswa']; 
                    $no_hp = $_REQUEST['no_hp']; 
                    $dosen1 = $_REQUEST['dosen1']; 
                    $dosen2 = $_REQUEST['dosen2']; 
                    $judul_proposal = $_REQUEST['judul_proposal'];  
                    $id_user = $_SESSION['admin'];

                    //validasi input data 
                        if(!preg_match("/^[a-zA-Z0-9.,\/ -]*$/", $mahasiswa)){
                            $_SESSION['namaref'] = 'Form Nama hanya boleh mengandung karakter huruf, spasi, titik(.), koma(,) dan minus(-)';
                            echo '<script language="javascript">window.history.back();</script>';
                        } else {
 

                                $cek = mysqli_query($config, "SELECT * FROM pengajuan_hasil_seminar_skripsi WHERE id_ph='$id'");
                                $result = mysqli_num_rows($cek);

                                if($result > 0){
                                    $_SESSION['duplikasi'] = 'id sudah ada, pilih yang lainnya!';
                                    echo '<script language="javascript">window.history.back();</script>';
                                } else { 
                                    $query = mysqli_query($config, "INSERT INTO pengajuan_hasil_seminar_skripsi(id_ph,nim,no_hp,id_pembimbing1,id_pembimbing2,judul_proposal,status) VALUES('$id_ph','$mahasiswa','$no_hp','$dosen1','$dosen2','$judul_proposal','0')");

                                    if($query != false){
                                         $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                                        header("Location: lembar_pernyataan_seminar_hasil.php?id_ph=$lastID");
                                        die();
                                    } else {
                                       $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                       echo '<script language="javascript">window.history.back();</script>';
                                    }
                                } 
                        } 
                }
            } else {?>
                <!-- Row Start -->
                <div class="row">
                    <!-- Secondary Nav START -->
                    <div class="col s12">
                        <nav class="secondary-nav">
                            <div class="nav-wrapper blue-grey darken-1">
                                <ul class="left">
                                    <li class="waves-effect waves-light"><a href="?page=pengajuan_hasil_seminar_skripsi&act=add" class="judul"><i class="material-icons">bookmark</i> Tambah Pengajuan Seminar Hasil Skripsi</a></li>
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
                    if(isset($_SESSION['errEmpty'])){
                        $errEmpty = $_SESSION['errEmpty'];
                        echo '<div id="alert-message" class="row">
                                <div class="col m12">
                                    <div class="card red lighten-5">
                                        <div class="card-content notif">
                                            <span class="card-title red-text"><i class="material-icons md-36">clear</i> '.$errEmpty.'</span>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                        unset($_SESSION['errEmpty']);
                    }
                    
                ?>

                <!-- Row form Start -->
                <div class="">
                
                    <!-- Form START -->
                    <form class=" " method="post" action="?page=pengajuan_hasil_seminar&act=add">
                        <table style="width: 100%;">
                            <tr>
                                <td style="width: 20%;">ID </td>
                                <td> <input id="kd" type="text" class="validate" maxlength="30" name="id_ph" value="<?php echo $id_ph; ?>" readonly="" required></td>
                            </tr>
                            <tr>
                                <td style="width: 20%;">Mahasiswa  </td>
                                <td> <input type="text" value="<?php $mhs=mysqli_fetch_array(mysqli_query($config,"SELECT nama FROM mahasiswa WHERE nim='".$_REQUEST['nim']."'")); echo $mhs['nama'];?>">
                                    <input id="mahasiswa" type="hidden" class="validate" maxlength="30" name="mahasiswa" value="<?php echo $_REQUEST['nim']; ?>" readonly="" required></td>
                            </tr>   
							<tr>
								<td style="width: 20%;">No HP</td>
								<td><input type="Text" name="no_hp" maxlength="12"></td>
							</tr>
                            <tr>
                                <td style="width: 20%;">Dosen Pembimbing 1</td>
                                <td>
                                    <select name="dosen1">
                                        <option>-Pilih-</option> 
                                            <?php 
                                                $hit="";
                                                $pb1="";
                                                $cek1=mysqli_query($config,"SELECT COUNT(*)as hit,id_pembimbing1 FROM pengajuan_hasil_seminar_skripsi GROUP BY id_pembimbing1");
                                                $jum=mysqli_num_rows($cek1); 
                                                
                                                if($jum>0){ 
                                                    while($dt = mysqli_fetch_array($cek1))
                                                    {  
                                                        $hit=$dt['hit'];
                                                        $pb1=$dt['id_pembimbing1']; 
                                                      
                                                        if ($hit>='15'){
                                                          $sql =mysqli_query($config,"SELECT * FROM dosen WHERE jabatan_fungsional IN('Lektor','Lektor Kepala') AND id_dosen<>'$pb1'");  
                                                                while($row = mysqli_fetch_array($sql))
                                                                   {
                                                                    echo "<option value='".$row['id_dosen']."'>$row[nama]</option>";  
                                                                   }     
                                                        }else{ 
                                                          $sql =mysqli_query($config,"SELECT * FROM dosen WHERE jabatan_fungsional IN('Lektor','Lektor Kepala') GROUP BY id_dosen");  
                                                            while($row = mysqli_fetch_array($sql))
                                                               {
                                                                 echo "<option value='".$row['id_dosen']."'>$row[nama]</option>";  
                                                               }  
                                                        } 
                                                    } 
                                                }else{ 
                                                      $sql =mysqli_query($config,"SELECT * FROM dosen WHERE jabatan_fungsional IN('Lektor','Lektor Kepala') GROUP BY id_dosen");  
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
                                        <option>-Pilih-</option> 
                                            <?php 
                                                $hit2="";
                                                $pb2="";
                                                $cek2=mysqli_query($config,"SELECT COUNT(*)as hit,id_pembimbing2 FROM pengajuan_hasil_seminar_skripsi GROUP BY id_pembimbing2");
                                                $jum=mysqli_num_rows($cek2); 
                                                
                                                if($jum>0){ 
                                                    while($dt = mysqli_fetch_array($cek2))
                                                    {  
                                                        $hit2=$dt['hit'];
                                                        $pb2=$dt['id_pembimbing1']; 
                                                      
                                                        if ($hit2>'3'){
                                                          $sql =mysqli_query($config,"SELECT * FROM dosen WHERE jabatan_fungsional IN('Tenaga Pendidik','Asisten Ahli') AND id_dosen<>'$pb2'");  
                                                                while($row = mysqli_fetch_array($sql))
                                                                   {
                                                                    echo "<option value='".$row['id_dosen']."'>$row[nama]</option>";  
                                                                   }     
                                                        }else{ 
                                                          $sql =mysqli_query($config,"SELECT * FROM dosen WHERE jabatan_fungsional IN('Tenaga Pendidik','Asisten Ahli') GROUP BY id_dosen");  
                                                            while($row = mysqli_fetch_array($sql))
                                                               {
                                                                 echo "<option value='".$row['id_dosen']."'>$row[nama]</option>";  
                                                               }  
                                                        } 
                                                    } 
                                                }else{ 
                                                      $sql =mysqli_query($config,"SELECT * FROM dosen WHERE jabatan_fungsional IN('Tenaga Pendidik','Asisten Ahli') GROUP BY id_dosen");  
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
                                <td style="width: 20%;">Judul Tugas Akhir</td>
                                <td><textarea name="judul_proposal" required="" class="validate" ></textarea></td>
                            </tr>
                             
                            <tr>
                                <td colspan="2"><center>
                                    <div class="row">
                                        <div class="col 6">
                                            <button type="submit" name="submit" class="btn-large blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                                        </div>
                                        <div class="col 6">
                                            <a href="?page=pengajuan_hasil_seminar" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
                                        </div>
                                    </div></center></td>
                            </tr>
                        </table>
                         
                        <!-- Row in form END -->

                    </form>
                    <!-- Form END -->

                </div>
                <!-- Row form END -->

<?php
            }
        }
    }
?>
