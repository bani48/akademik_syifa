<?php
    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else {
 
            if(isset($_REQUEST['submit'])){ 
    
                                    $query = mysqli_query($config, "INSERT karya_ilmiah_dosen SET id_dosen='".$_POST['id_dosen']."',judul='".$_POST['judul']."',
                                                                                                  tanggal_publikasi='".$_POST['tanggal_publikasi']."',
                                                                                                  publikasi='".$_POST['publikasi']."'");

                                    if($query != false){
                                         $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                                        header("Location: ./admin.php?page=dosen&act=karya_ilmiah&id_dosen=".$_REQUEST['id_dosen']."");
                                        die();
                                    } else {
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
                                    <li class="waves-effect waves-light"><i class="material-icons">bookmark</i> Tambah Karya Ilmiah Dosen</li>
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
                    
                    $namadosen=mysqli_fetch_array(mysqli_query($config,"SELECT nama FROM dosen WHERE id_dosen='".$_REQUEST['id_dosen']."'"));
                ?>

                <!-- Row form Start -->
                <div class="row jarak-form">

                    <!-- Form START -->
                    <form class="col s12" method="post" action="?page=dosen&act=karya_ilmiah&act=add_karya">
                    
                        <!-- Row in form START -->
                        <div class="row">
                            <div class="input-field col s3 tooltipped" data-position="top">
                              
                                <input id="id_dosen" type="text" class="validate" name="id_dosen" readonly="" value="<?php echo $_REQUEST['id_dosen']; ?>" placeholder="" required>
                               
                                <label for="kd">ID dosen</label>
                            </div>
                            <div class="input-field col s9"> 
                                <input id="nama" type="text" class="validate" name="nama"  readonly="" value="<?php echo $namadosen['nama']; ?>" placeholder="" required> 
                                <label for="nama">Nama</label>
                            </div>
                            <div class="input-field col s9">   
                                <input id="judul" type="text" class="validate" name="judul" required> 
                                <label for="nama">Judul</label>
                            </div>                            
                            <div class="input-field col s9">  
                                <input id="tanggal_publikasi" type="text" class="validate" name="tanggal_publikasi" required> 
                                <label for="nama">Tanggal Publikasi</label>
                            </div>
                            
                            <div class="input-field col s9"> 
                                <input id="publikasi" type="text" class="validate" name="publikasi" required> 
                                <label for="publikasi">Publikasi</label>
                            </div> 
                            
                        </div>
                        <!-- Row in form END -->
                        <div class="row">
                            <div class="col 6">
                                <button type="submit" name="submit" class="btn-large blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                            </div>
                            <div class="col 6">
                                <a href="?page=dosen" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
                            </div>
                        </div>

                    </form>
                    <!-- Form END -->

                </div>
                <!-- Row form END -->

<?php
            } 
    }
?>
