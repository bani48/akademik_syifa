<?php
    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else {

        if($_SESSION['admin'] != 1 AND $_SESSION['admin'] != 2){
            echo '<script language="javascript">
                    window.alert("ERROR! Anda tidak memiliki hak akses untuk menambahkan data");
                    window.location.href="./admin.php?page=perusahaan";
                  </script>';
        } else {

            if(isset($_REQUEST['submit'])){

                //validasi form kosong
                if($_REQUEST['id_perusahaan'] == "" || $_REQUEST['nama_perusahaan'] == "" || $_REQUEST['alamat'] == ""){
                    $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
                    echo '<script language="javascript">window.history.back();</script>';
                } else {

                    $id_perusahaan = $_REQUEST['id_perusahaan'];
                    $nama = $_REQUEST['nama_perusahaan']; 
                    $alamat = $_REQUEST['alamat']; 
                    $telepon = $_REQUEST['telepon']; 
                    $email = $_REQUEST['email']; 
                    $link = $_REQUEST['link']; 
                    $id_user = $_SESSION['admin'];

                    //validasi input data 
                        if(!preg_match("/^[a-zA-Z0-9.,\/ -]*$/", $nama)){
                            $_SESSION['namaref'] = 'Form Nama hanya boleh mengandung karakter huruf, spasi, titik(.), koma(,) dan minus(-)';
                            echo '<script language="javascript">window.history.back();</script>';
                        } else {

                            if(!preg_match("/^[a-zA-Z0-9.,()\/\r\n -]*$/", $uraian)){
                                $_SESSION['uraian'] = 'Form Uraian hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), dan kurung()';
                                echo '<script language="javascript">window.history.back();</script>';
                            } else {

                                $cek = mysqli_query($config, "SELECT * FROM perusahaan WHERE id_perusahaan='$id_perusahaan'");
                                $result = mysqli_num_rows($cek);

                                if($result > 0){
                                    $_SESSION['duplikasi'] = 'id_perusahaan sudah ada, pilih yang lainnya!';
                                    echo '<script language="javascript">window.history.back();</script>';
                                } else {

                                    $query = mysqli_query($config, "INSERT INTO perusahaan(id_perusahaan,nama_perusahaan,alamat,telepon,email,link) VALUES('$id_perusahaan','$nama','$alamat','$telepon','$email','$link')");

                                    if($query != false){
                                         $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                                        header("Location: ./admin.php?page=perusahaan");
                                        die();
                                    } else {
                                       $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                       echo '<script language="javascript">window.history.back();</script>';
                                    }
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
                                    <li class="waves-effect waves-light"><a href="?page=perusahaan&act=add" class="judul"><i class="material-icons">bookmark</i> Tambah perusahaan</a></li>
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
                    
                      $sql ="SELECT max(id_perusahaan) as id_perusahaan from perusahaan";
                      $hasil = mysqli_query($config,$sql);
                      $data = mysqli_fetch_array($hasil); 
                      $lastID = $data['id_perusahaan'];
                      $lastNoUrut = substr($lastID, 1, 4);
                      $nextNoUrut = $lastNoUrut + 1;
                      $id_perusahaan = "P".sprintf("%04s",$nextNoUrut);
                ?>

                <!-- Row form Start -->
                <div class="row jarak-form">

                    <!-- Form START -->
                    <form class="col s12" method="post" action="?page=perusahaan&act=add">
                    
                        <!-- Row in form START -->
                        <div class="row">
                            <div class="input-field col s3 tooltipped" data-position="top">
                              
                                <input id="kd" type="text" class="validate" maxlength="30" name="id_perusahaan" value="<?php echo $id_perusahaan; ?>" readonly="" required>
                                
                                <label for="kd">ID Perusahaan</label>
                            </div>
                            <div class="input-field col s9"> 
                                <input id="nama" type="text" class="validate" name="nama_perusahaan" placeholder="" required>
                                 
                                <label for="nama">Nama Perusahaan</label>
                            </div>
                            <div class="input-field col s9"> 
                                <textarea name="alamat" class="validate"></textarea>
                                 
                                <label for="nama">Alamat</label>
                            </div>
                            <div class="input-field col s9"> 
                                <input type="text" id="telepon" class="validate" name="telepon" placeholder="" required>
                                 
                                <label for="nama">Telepon</label>
                            </div>
                            <div class="input-field col s9"> 
                                <input id="email" type="text" class="validate" name="email" placeholder="" required>
                                 
                                <label for="nama">Email</label>
                            </div>
                            <div class="input-field col s9"> 
                                <input id="link" type="text" class="validate" name="link" placeholder="" required> 
                                <label for="nama">Link</label>
                            </div> 
                        </div>
                        <!-- Row in form END -->
                        <div class="row">
                            <div class="col 6">
                                <button type="submit" name="submit" class="btn-large blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                            </div>
                            <div class="col 6">
                                <a href="?page=perusahaan" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
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
?>
