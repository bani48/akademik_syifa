<?php

    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else { 
                if(isset($_REQUEST['submit'])){

                    $id_perusahaan = $_REQUEST['id_perusahaan'];
                    $admin = $_REQUEST['admin'];
   
                            $query = mysqli_query($config, "UPDATE perusahaan SET nama_perusahaan='".$_POST['nama_perusahaan']."', alamat='".$_POST['alamat']."',
                                                            telepon='".$_POST['telepon']."', email='".$_POST['email']."', link='".$_POST['link']."'
                                                             WHERE id_perusahaan='".$_POST['id_perusahaan']."'");

                            if($query == true){
                                $_SESSION['succEdit'] = "Data Sudah Terupdate";
                                header("Location: ./admin.php?page=perusahaan&sub=usr");
                                die();
                            } else {
                                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                echo '<script language="javascript">
                                        window.location.href="./admin.php?page=perusahaan&sub=usr&act=edit&id_perusahaan='.$id_perusahaan.'";
                                      </script>';
                            }  
                } else {

                    $id_perusahaan = mysqli_real_escape_string($config, $_REQUEST['id_perusahaan']);
                    $query = mysqli_query($config, "SELECT * FROM perusahaan WHERE id_perusahaan='$id_perusahaan'");
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
                                            <li class="waves-effect waves-light  tooltipped" data-position="right" data-tooltip="Menu ini hanya untuk mengedit  perusahaan. perusahaanname dan password bisa diganti lewat menu profil"><a href="#" class="judul"><i class="material-icons">mode_edit</i> Edit  perusahaan</a></li>
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
                            <form class="col s12" method="post" action="?page=perusahaan&sub=usr&act=edit"> 
                                  <div class="row">
                                    <div class="input-field col s3 tooltipped" data-position="top">
                                      
                                        <input id="kd" type="text" class="validate" maxlength="30" name="id_perusahaan" value="<?php echo $id_perusahaan; ?>" readonly="" required>
                                        
                                        <label for="kd">ID Perusahaan</label>
                                    </div>
                                    <div class="input-field col s9"> 
                                        <input id="nama" type="text" class="validate" name="nama_perusahaan" value="<?php echo $row['nama_perusahaan']; ?>" placeholder="" required>
                                         
                                        <label for="nama">Nama Perusahaan</label>
                                    </div>
                                    <div class="input-field col s9"> 
                                        <textarea name="alamat" class="validate"><?php echo $row['alamat']; ?></textarea>
                                         
                                        <label for="nama">Alamat</label>
                                    </div>
                                    <div class="input-field col s9"> 
                                        <input type="text" id="telepon" class="validate" value="<?php echo $row['telepon']; ?>" name="telepon" placeholder="" required>
                                         
                                        <label for="nama">Telepon</label>
                                    </div>
                                    <div class="input-field col s9"> 
                                        <input id="email" type="text" class="validate" name="email" value="<?php echo $row['email']; ?>" placeholder="" required>
                                         
                                        <label for="nama">Email</label>
                                    </div>
                                    <div class="input-field col s9"> 
                                        <input id="link" type="text" class="validate" name="link" placeholder=""  value="<?php echo $row['link']; ?>" required> 
                                        <label for="nama">Link</label>
                                    </div> 
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col 6">
                                        <button type="submit" name="submit" class="btn-large blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                                    </div>
                                    <div class="col 6">
                                        <a href="?page=perusahaan&sub=usr" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
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
