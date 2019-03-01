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
                    window.location.href="./admin.php?page=dosen";
                  </script>';
        } else {

            if(isset($_REQUEST['submit'])){

                //validasi form kosong
                if($_REQUEST['kode'] == "" || $_REQUEST['nama'] == "" || $_REQUEST['nip'] == ""){
                    $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
                    echo '<script language="javascript">window.history.back();</script>';
                } else {

                    $kode = $_REQUEST['kode'];
                    $nama = $_REQUEST['nama']; 
                    $nip = $_REQUEST['nip']; 
                    $jabatan_fungsional = $_REQUEST['jabatan_fungsional']; 
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

                                $cek = mysqli_query($config, "SELECT * FROM dosen WHERE id_dosen='$kode'");
                                $result = mysqli_num_rows($cek);

                                if($result > 0){
                                    $_SESSION['duplikasi'] = 'Kode sudah ada, pilih yang lainnya!';
                                    echo '<script language="javascript">window.history.back();</script>';
                                } else {

                                    $query = mysqli_query($config, "INSERT INTO dosen(id_dosen,nama,nip,jabatan_fungsional,jabatan_struktural,bidang_keahlian,email) VALUES('$kode','$nama','$nip','$jabatan_fungsional','$_POST[jabatan_struktural]','$_POST[bidang_keahlian]','$_POST[email]')");

                                    if($query != false){
                                         $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                                        header("Location: ./admin.php?page=dosen");
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
                                    <li class="waves-effect waves-light"><a href="?page=dosen&act=add" class="judul"><i class="material-icons">bookmark</i> Tambah dosen</a></li>
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
                    
                      $sql ="SELECT max(id_dosen) as id_dosen from dosen";
                      $hasil = mysqli_query($config,$sql);
                      $data = mysqli_fetch_array($hasil); 
                      $lastID = $data['id_dosen'];
                      $lastNoUrut = substr($lastID, 1, 4);
                      $nextNoUrut = $lastNoUrut + 1;
                      $kode = "D".sprintf("%04s",$nextNoUrut);
                ?>

                <!-- Row form Start -->
                <div class="row jarak-form">

                    <!-- Form START -->
                    <form class="col s12" method="post" action="?page=dosen&act=add">
                    
                        <!-- Row in form START -->
                        <div class="row">
                            <div class="input-field col s3 tooltipped" data-position="top">
                              
                                <input id="kd" type="text" class="validate" maxlength="30" name="kode" value="<?php echo $kode; ?>" readonly="" required>
                                
                                <label for="kd">ID dosen</label>
                            </div>
                            <div class="input-field col s9"> 
                                <input id="nama" type="text" class="validate" name="nama" placeholder="" required>
                                 
                                <label for="nama">Nama</label>
                            </div>
                            <div class="input-field col s9"> 
                                <input id="nip" type="text" class="validate" name="nip" required> 
                                <label for="nama">NIP/NIDN</label>
                            </div>                            
                            <div class="input-field col s9">   
								<select name="jabatan_fungsional" class="validate" value="">
										<option></option>
										<option value="Tenaga Pendidik">Tenaga Pendidik</option>
										<option value="Asisten Ahli">Asisten Ahli</option>
										<option value="Lektor">Lektor</option>
										<option value="Lektor Kepala">Lektor Kepala</option>';
									 
								</select>
                                <label for="nama">Jabatan Fungsional</label>
                            </div>
                            
                            <div class="input-field col s9"> 
                                <input id="jabatan_struktural" type="text" class="validate" name="jabatan_struktural" required> 
                                <label for="jabatan_struktural">Jabatan Struktural</label>
                            </div>
                            
                            <div class="input-field col s9"> 
                                <input id="bidang_keahlian" type="text" class="validate" name="bidang_keahlian" required> 
                                <label for="bidang_keahlian">Bidang Keahlian</label>
                            </div>
                            
                            <div class="input-field col s9"> 
                                <input id="email" type="text" class="validate" name="email" required> 
                                <label for="email">Email</label>
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
    }
?>
