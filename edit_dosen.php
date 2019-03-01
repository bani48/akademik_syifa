<?php

    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else { 
                if(isset($_REQUEST['submit'])){

                    $id_dosen = $_REQUEST['id_dosen'];
                    $admin = $_REQUEST['admin'];
   
                            $query = mysqli_query($config, "UPDATE dosen SET nama='".$_POST['nama']."', nip='".$_POST['nip']."',
                                                                             jabatan_fungsional='".$_POST['jabatan_fungsional']."',
                                                                             jabatan_struktural='".$_POST['jabatan_struktural']."',
                                                                             bidang_keahlian='".$_POST['bidang_keahlian']."',
                                                                              email='".$_POST['email']."'
                                                                             WHERE id_dosen='".$_POST['id_dosen']."'");

                            if($query == true){
                                $_SESSION['succEdit'] = "Data Sudah Terupdate";
                                header("Location: ./admin.php?page=dosen&sub=usr");
                                die();
                            } else {
                                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                echo '<script language="javascript">
                                        window.location.href="./admin.php?page=dosen&sub=usr&act=edit&id_dosen='.$id_dosen.'";
                                      </script>';
                            }  
                } else {

                    $id_dosen = mysqli_real_escape_string($config, $_REQUEST['id_dosen']);
                    $query = mysqli_query($config, "SELECT * FROM dosen WHERE id_dosen='$id_dosen'");
                    if(mysqli_num_rows($query) > 0){
                        $no = 1;
                        while($row = mysqli_fetch_array($query)){?>

                        <!-- Row Start -->
                        <div class="row">
                            <!-- Secondary Nav START -->
                            <div class="col s12">
                                <nav class="secondary-nav">
                                    <div class="nav-wrapper blue-grey darken-1">
                                        <ul class="left">
                                            <li class="waves-effect waves-light  tooltipped" data-position="right" data-tooltip="Menu ini hanya untuk mengedit  dosen. dosenname dan password bisa diganti lewat menu profil"><a href="#" class="judul"><i class="material-icons">mode_edit</i> Edit  dosen</a></li>
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
                            <form class="col s12" method="post" action="?page=dosen&sub=usr&act=edit">

                    <div class="row">
                            <div class="input-field col s3 tooltipped" data-position="top">
                              
                                <input id="kd" type="text" class="validate" maxlength="30" name="id_dosen" value="<?php echo $_REQUEST['id_dosen']; ?>" readonly="" required>
                                
                                <label for="kd">ID Dosen</label>
                            </div>
                            <div class="input-field col s9"> 
                                <input id="nama" type="text" class="validate" value="<?php echo $row['nama'] ;?>" name="nama" placeholder="" required>
                                 
                                <label for="nama">Nama Dosen</label>
                            </div>
                            <div class="input-field col s9"> 
                                <input id="nip" type="text" class="validate" name="nip" value="<?php echo $row['nip'] ;?>" required>
                                 
                                <label for="nama">NIP/NIDN</label>
                            </div> 
                            <div class="input-field col s9"><br/>   
								<select name="jabatan_fungsional" class="validate" value="">
									<?php
										if($row['jabatan_fungsional']=='Tenaga Pendidik'){
											echo'<option value="Tenaga Pendidik">Tenaga Pendidik</option>
												<option value="Asisten Ahli">Asisten Ahli</option>
												<option value="Lektor">Lektor</option>
												<option value="Lektor Kepala">Lektor Kepala</option>';
										}else if($row['jabatan_fungsional']=='Asisten Ahli'){
											echo'
												<option value="Asisten Ahli">Asisten Ahli</option>
												<option value="Tenaga Pendidik">Tenaga Pendidik</option>
												<option value="Lektor">Lektor</option>
												<option value="Lektor Kepala">Lektor Kepala</option>';
										}else if($row['jabatan_fungsional']=='Lektor'){
											echo'
												<option value="Lektor">Lektor</option>
												<option value="Lektor Kepala">Lektor Kepala</option>
												<option value="Tenaga Pendidik">Tenaga Pendidik</option>
												<option value="Asisten Ahli">Asisten Ahli</option>';
										}else if($row['jabatan_fungsional']=='Lektor Kepala'){
											echo'<option value="Lektor Kepala">Lektor Kepala</option>
												<option value="Lektor">Lektor</option>
												<option value="Tenaga Pendidik">Tenaga Pendidik</option>
												<option value="Asisten Ahli">Asisten Ahli</option>';
										}else{
											echo'<option></option>
												<option value="Tenaga Pendidik">Tenaga Pendidik</option>
												<option value="Asisten Ahli">Asisten Ahli</option>
												<option value="Lektor">Lektor</option>
												<option value="Lektor Kepala">Lektor Kepala</option>';
										}	
									?>
								</select><br/>
                                <label for="nama">Jabatan Fungsional<br/></label>
                            </div> 
                            
                            <div class="input-field col s9"> 
                                <input id="jabatan_struktural" type="text" value="<?php echo $row['jabatan_struktural'] ;?>" class="validate" name="jabatan_struktural" required> 
                                <label for="jabatan_struktural">Jabatan Struktural</label>
                            </div>
                            
                            <div class="input-field col s9"> 
                                <input id="bidang_keahlian" type="text"  value="<?php echo $row['bidang_keahlian'] ;?>" class="validate" name="bidang_keahlian" required> 
                                <label for="bidang_keahlian">Bidang Keahlian</label>
                            </div>
                            
                            <div class="input-field col s9"> 
                                <input id="email" type="text" class="validate" value="<?php echo $row['email'] ;?>" name="email" required> 
                                <label for="email">Email</label>
                            </div> 
                        </div> 
                                <br/>
                                <div class="row">
                                    <div class="col 6">
                                        <button type="submit" name="submit" class="btn-large blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                                    </div>
                                    <div class="col 6">
                                        <a href="?page=dosen&sub=usr" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
                                    </div>
                                </div>

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
