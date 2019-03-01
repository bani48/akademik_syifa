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
                    window.location.href="./admin.php?page=mahasiswa";
                  </script>';
        } else {

            if(isset($_REQUEST['submit'])){

                //validasi form kosong
                if($_REQUEST['kode'] == "" || $_REQUEST['nama'] == "" || $_REQUEST['nim'] == ""){
                    $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
                    echo '<script language="javascript">window.history.back();</script>';
                } else {

                    $kode = $_REQUEST['kode'];
                    $nama = $_REQUEST['nama']; 
                    $nim = $_REQUEST['nim']; 
                    $email = $_REQUEST['email']; 
                    $no_hp = $_REQUEST['no_hp']; 
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

                                $cek = mysqli_query($config, "SELECT * FROM mahasiswa WHERE id_mahasiswa='$kode'");
                                $result = mysqli_num_rows($cek);

                                if($result > 0){
                                    $_SESSION['duplikasi'] = 'Kode sudah ada, pilih yang lainnya!';
                                    echo '<script language="javascript">window.history.back();</script>';
                                } else {

                                    $query = mysqli_query($config, "INSERT INTO mahasiswa(id_mahasiswa,nama,nim,email,no_hp) VALUES('$kode','$nama','$nim','$email','$no_hp')");

                                    if($query != false){
                                         $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                                        header("Location: ./admin.php?page=mahasiswa");
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
                                    <li class="waves-effect waves-light"><a href="?page=mahasiswa&act=add" class="judul"><i class="material-icons">bookmark</i> Tambah Mahasiswa</a></li>
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
                    
                      $sql ="SELECT max(id_mahasiswa) as id_mahasiswa from mahasiswa";
                      $hasil = mysqli_query($config,$sql);
                      $data = mysqli_fetch_array($hasil); 
                      $lastID = $data['id_mahasiswa'];
                      $lastNoUrut = substr($lastID, 1, 4);
                      $nextNoUrut = $lastNoUrut + 1;
                      $kode = "M".sprintf("%04s",$nextNoUrut);
                ?>

                <!-- Row form Start -->
                <div class="row jarak-form">

                    <!-- Form START -->
                    <form class="col s12" method="post" action="?page=mahasiswa&act=add">
                    
                        <!-- Row in form START -->
                        <div class="row">
                            <div class="input-field col s3 tooltipped" data-position="top">
                              
                                <input id="kd" type="text" class="validate" maxlength="30" name="kode" value="<?php echo $kode; ?>" readonly="" required>
                                
                                <label for="kd">ID Mahasiswa</label>
                            </div>
                            <div class="input-field col s9"> 
                                <input id="nama" type="text" class="validate" name="nama" placeholder="" required>
                                 
                                <label for="nama">Nama</label>
                            </div>
                            <div class="input-field col s9"> 
                                <input id="nim" type="text" class="validate" name="nim" required>
                                 
                                <label for="nama">NIM</label>
                            </div>
                            <div class="input-field col s9"> 
                                <input id="email" type="text" class="validate" name="email" required>
                                 
                                <label for="nama">Email</label>
                            </div>
                            <div class="input-field col s9"> 
                                <input id="no_hp" type="text" maxlength="12" class="validate" name="no_hp" required>
                                 
                                <label for="nama">No HP</label>
                            </div>
                            
                        </div>
                        <!-- Row in form END -->
                        <div class="row">
                            <div class="col 6">
                                <button type="submit" name="submit" class="btn-large blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                            </div>
                            <div class="col 6">
                                <a href="?page=mahasiswa" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
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
