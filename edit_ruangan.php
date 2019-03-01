<?php

    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else { 
                if(isset($_REQUEST['submit'])){

                    $ruangan = $_REQUEST['ruangan'];
                    $admin = $_REQUEST['admin'];
   
                            $query = mysqli_query($config, "UPDATE ruangan SET nama_ruangan='".$_POST['nama_ruangan']."' WHERE ruangan='".$_POST['ruangan']."'");

                            if($query == true){
                                $_SESSION['succEdit'] = "Data Sudah Terupdate";
                                header("Location: ./admin.php?page=ruangan&sub=usr");
                                die();
                            } else {
                                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                echo '<script language="javascript">
                                        window.location.href="./admin.php?page=ruangan&sub=usr&act=edit&ruangan='.$ruangan.'";
                                      </script>';
                            }  
                } else {

                    $ruangan = mysqli_real_escape_string($config, $_REQUEST['ruangan']);
                    $query = mysqli_query($config, "SELECT * FROM ruangan WHERE ruangan='$ruangan'");
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
                                            <li class="waves-effect waves-light  tooltipped" data-position="right" data-tooltip="Menu ini hanya untuk mengedit  ruangan. ruanganname dan password bisa diganti lewat menu profil"><a href="#" class="judul"><i class="material-icons">mode_edit</i> Edit  ruangan</a></li>
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
                            <form class="col s12" method="post" action="?page=ruangan&sub=usr&act=edit">
                                <div class="row">
                                    <div class="input-field col s3 tooltipped" data-position="top">
                                      
                                        <input id="kd" type="text" class="validate" maxlength="30" name="ruangan" value="<?php echo $ruangan; ?>" readonly="" required>
                                        
                                        <label for="kd">ID ruangan</label>
                                    </div>
                                    <div class="input-field col s9"> 
                                        <input id="nama_ruangan" type="text" class="validate" value="<?php echo $row['nama_ruangan']; ?>" name="nama_ruangan" placeholder="" required>
                                         
                                        <label for="ruangan">Ruangan</label>
                                    </div> 
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col 6">
                                        <button type="submit" name="submit" class="btn-large blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                                    </div>
                                    <div class="col 6">
                                        <a href="?page=ruangan&sub=usr" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
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
