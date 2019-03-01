<?php

    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else { 
                if(isset($_REQUEST['submit'])){

                    $id_mahasiswa = $_REQUEST['id_mahasiswa'];
                    $admin = $_REQUEST['admin'];
   
                            $query = mysqli_query($config, "UPDATE mahasiswa SET nama='".$_POST['nama']."', nim='".$_POST['nim']."', email='".$_POST['email']."', no_hp='".$_POST['no_hp']."' WHERE id_mahasiswa='".$_POST['id_mahasiswa']."'");

                            if($query == true){
                                $_SESSION['succEdit'] = "Data Sudah Terupdate";
                                header("Location: ./admin.php?page=mahasiswa&sub=usr");
                                die();
                            } else {
                                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                echo '<script language="javascript">
                                        window.location.href="./admin.php?page=mahasiswa&sub=usr&act=edit&id_mahasiswa='.$id_mahasiswa.'";
                                      </script>';
                            }  
                } else {

                    $id_mahasiswa = mysqli_real_escape_string($config, $_REQUEST['id_mahasiswa']);
                    $query = mysqli_query($config, "SELECT * FROM mahasiswa WHERE id_mahasiswa='$id_mahasiswa'");
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
                                            <li class="waves-effect waves-light  tooltipped" data-position="right" data-tooltip="Menu ini hanya untuk mengedit  mahasiswa. mahasiswaname dan password bisa diganti lewat menu profil"><a href="#" class="judul"><i class="material-icons">mode_edit</i> Edit  mahasiswa</a></li>
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
                            <form class="col s12" method="post" action="?page=mahasiswa&sub=usr&act=edit">

                    <div class="row">
                            <div class="input-field col s3 tooltipped" data-position="top">
                              
                                <input id="kd" type="text" class="validate" maxlength="30" name="id_mahasiswa" value="<?php echo $_REQUEST['id_mahasiswa']; ?>" readonly="" required>
                                
                                <label for="kd">ID Mahasiswa</label>
                            </div>
                            <div class="input-field col s9"> 
                                <input id="nama" type="text" class="validate" value="<?php echo $row['nama'] ;?>" name="nama" placeholder="" required>
                                 
                                <label for="nama">Nama</label>
                            </div>
                            <div class="input-field col s9"> 
                                <input id="nim" type="text" class="validate" name="nim" value="<?php echo $row['nim'] ;?>" required>
                                 
                                <label for="nama">NIM</label>
                            </div>
                            
                            <div class="input-field col s9"> 
                                <input id="email" type="text" class="validate" name="email" value="<?php echo $row['email'] ;?>" required>
                                 
                                <label for="nama">Email</label>
                            </div>
                            <div class="input-field col s9"> 
                                <input id="no_hp" type="text" maxlength="12" class="validate" value="<?php echo $row['no_hp'] ;?>" name="no_hp" required>
                                 
                                <label for="nama">No HP</label>
                            </div> 
                        </div> 
                                <br/>
                                <div class="row">
                                    <div class="col 6">
                                        <button type="submit" name="submit" class="btn-large blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                                    </div>
                                    <div class="col 6">
                                        <a href="?page=mahasiswa&sub=usr" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
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
