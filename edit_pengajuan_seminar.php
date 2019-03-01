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
    $id=$_REQUEST['id'];

    $data=mysqli_fetch_array(mysqli_query($config,"SELECT a.judul_proposal, b.nim, b.nama, 
                                					(SELECT dosen.nama FROM dosen WHERE dosen.id_dosen=a.id_pembimbing1) as dosen1,
                                					(SELECT dosen.nip FROM dosen WHERE dosen.id_dosen=a.id_pembimbing1) as nip1,
                                					(SELECT dosen.nip FROM dosen WHERE dosen.id_dosen=a.id_pembimbing2) as nip2,
                                					(SELECT dosen.nama FROM dosen WHERE dosen.id_dosen=a.id_pembimbing2) as dosen2,
                                                     a.no_hp                    
                                					 FROM pengajuan_seminar_skripsi as a
                                  					 LEFT JOIN mahasiswa as b ON a.nim=b.nim
                                					 WHERE a.id='".$id."'"));                     
    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else {

        if($_SESSION['admin'] != 1 AND $_SESSION['admin'] != 4){
            echo '<script language="javascript">
                    window.alert("ERROR! Anda tidak memiliki hak akses untuk menambahkan data");
                    window.location.href="./admin.php?page=pengajuan_seminar";
                  </script>';
        } else {
            if(isset($_REQUEST['submit'])){ 

                    $id = $_REQUEST['id']; 
                    $judul_proposal = $_REQUEST['judul_proposal'];  
                    $id_user = $_SESSION['admin'];   
                                    $query = mysqli_query($config, "UPDATE pengajuan_seminar_skripsi SET  judul_proposal='$judul_proposal' 
                                                                    WHERE id='".$id."'");
                                        if($query != false){
                                         $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                                        header("Location: ./admin.php?page=pengajuan_seminar");
                                         die();
                                    } else {    echo "UPDATE pengajuan_seminar_skripsi SET  judul_proposal='$judul_proposal' 
                                                                    WHERE id='".$id."'";
                                
                                       $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                       echo '<script language="javascript">window.history.back();</script>';
                                    } 
            } else {?>
                <!-- Row Start -->
                <div class="row">
                    <!-- Secondary Nav START -->
                    <div class="col s12">
                        <nav class="secondary-nav">
                            <div class="nav-wrapper blue-grey darken-1">
                                <ul class="left">
                                    <li class="waves-effect waves-light"><a href="?page=pengajuan_seminar&act=edit_seminar" class="judul"><i class="material-icons">bookmark</i> Edit Pengajuan Seminar Skripsi</a></li>
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
                    <form class=" " method="post" action="?page=pengajuan_seminar&act=edit_seminar">
                        <table style="width: 100%;">
                            <tr>
                                <td style="width: 20%;">ID </td>
                                <td> <input id="kd" type="text" class="validate" maxlength="30" name="id" value="<?php echo $id; ?>" readonly="" required></td>
                            </tr>
                            <tr>
                                <td style="width: 20%;">Mahasiswa  </td>
                                <td> <input type="text" value="<?php echo $data['nama']; ?>">
                                    <input id="mahasiswa" type="hidden" class="validate" maxlength="30" name="mahasiswa" value="<?php echo $_REQUEST['nim']; ?>" readonly="" required></td>
                            </tr>   
							<tr>
								<td style="width: 20%;">No HP</td>
								<td><input type="Text" name="no_hp" maxlength="12" readonly="" value="<?php echo $data['no_hp']; ?>"></td>
							</tr>
                            <tr>
                                <td style="width: 20%;">Dosen Pembimbing 1</td>
                                <td><input id="dosen1" type="text" class="validate" maxlength="30" name="dosen1" value="<?php echo $data['dosen1']; ?>" readonly="" required></td>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 20%;">Dosen Pembimbing 2</td>
                                <td><input id="dosen2" type="text" class="validate" maxlength="30" name="dosen2" value="<?php echo $data['dosen2']; ?>" readonly="" required></td>
                                </td> 
                            </tr>
                            <tr>
                                <td style="width: 20%;">Judul Tugas Akhir</td>
                                <td><textarea name="judul_proposal" required="" class="validate" ><?php echo $data['judul_proposal']; ?></textarea></td>
                            </tr>
                             
                            <tr>
                                <td colspan="2"><center>
                                    <div class="row">
                                        <div class="col 6">
                                            <button type="submit" name="submit" class="btn-large blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                                        </div>
                                        <div class="col 6">
                                            <a href="?page=pengajuan_seminar" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
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
