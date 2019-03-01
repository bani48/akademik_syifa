<link rel="stylesheet" href="/resources/demos/style.css">
  <script src="asset/js/jquery-1.12.4.js"></script>
  <script src="asset/js/jquery-ui.js"></script>
  <script>
  $( function() {
        $( "#tanggal" ).datepicker({dateFormat:'yy-mm-dd'});
        $( "#datepicker2" ).datepicker({dateFormat:'yy-mm-dd'});
  } );
  </script>
<?php
    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else { 
            if(isset($_REQUEST['submit'])){

                //validasi form kosong
                if($_REQUEST['id_dokumen'] == "" || $_REQUEST['tanggal_upload'] == ""){
                    $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
                    echo '<script language="javascript">window.history.back();</script>';
                } else {

                    $id_dokumen = $_REQUEST['id_dokumen'];
                    $nama_dokumen = $_REQUEST['nama_dokumen']; 
                    $tanggal_upload = $_REQUEST['tanggal_upload']; 
                    $id_user = $_SESSION['admin'];

                    //validasi input data 
                        if(!preg_match("/^[a-zA-Z0-9.,\/ -]*$/", $nama_dokumen)){
                            $_SESSION['nama_dokumenref'] = 'Form nama_dokumen hanya boleh mengandung karakter huruf, spasi, titik(.), koma(,) dan minus(-)';
                            echo '<script language="javascript">window.history.back();</script>';
                        } else {

                            if(!preg_match("/^[a-zA-Z0-9.,()\/\r\n -]*$/", $uraian)){
                                $_SESSION['uraian'] = 'Form Uraian hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), dan kurung()';
                                echo '<script language="javascript">window.history.back();</script>';
                            } else {

                                $cek = mysqli_query($config, "SELECT * FROM dokumen WHERE id_dokumen='$id_dokumen'");
                                $result = mysqli_num_rows($cek);

                                if($result > 0){
                                    $_SESSION['duplikasi'] = 'id_dokumen sudah ada, pilih yang lainnya!';
                                    echo '<script language="javascript">window.history.back();</script>';
                                } else {
                                    
                                    $path = "upload/"; 
                                 	$fileName 	= $_FILES['nama_dokumen']['name'];
                                	$tmpName 	= $_FILES['nama_dokumen']['tmp_name']; 
                                	$fileSize 	= $_FILES['nama_dokumen']['size']; 
                                	$fileType 	= $_FILES['nama_dokumen']['type'];
                                    $filePath = $path.$fileName;
                                    
                                    $result = move_uploaded_file($tmpName, $filePath); 

                                    $query = mysqli_query($config, "INSERT INTO dokumen(id_dokumen,nama_dokumen,tanggal_upload,create_user) VALUES('$id_dokumen','$fileName','$tanggal_upload','$id_user')");
                                    if($query != false){
                                         $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                                        header("Location: ./admin.php?page=dokumen");
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
                                    <li class="waves-effect waves-light"><a href="?page=dokumen&act=add" class="judul"><i class="material-icons">bookmark</i> Tambah dokumen</a></li>
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
                    
                      $sql ="SELECT max(id_dokumen) as id_dokumen from dokumen";
                      $hasil = mysqli_query($config,$sql);
                      $data = mysqli_fetch_array($hasil); 
                      $lastID = $data['id_dokumen'];
                      $lastNoUrut = substr($lastID, 2, 4);
                      $nextNoUrut = $lastNoUrut + 1;
                      $id_dokumen = "DK".sprintf("%03s",$nextNoUrut);
                ?>

                <!-- Row form Start -->
                <div class="row jarak-form">

                    <!-- Form START -->
                    <form class="col s12" method="post" action="?page=dokumen&act=add" enctype="multipart/form-data">
                        <table>
                            <tr>
                                <td style="width: 20%;">ID dokumen</td>
                                <td>   <input id="kd" type="text" class="validate" maxlength="30" name="id_dokumen" value="<?php echo $id_dokumen; ?>" readonly="" required></td>
                            </tr>
                            <tr>
                                <td>Nama Dokumen</td>
                                <td> <input id="nama_dokumen" type="file" class="validate" name="nama_dokumen" placeholder="" required></td>
                            </tr>
                            <tr>
                                <td>Tanggal Upload</td>
                                <td>  <input id="tanggal" type="text" class="validate" name="tanggal_upload" required>
                                    <input type="hidden" class="validate" name="create_user" value="<?php echo $_SESSION['username']; ?>" required>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center"><button type="submit" name="submit" class="btn-large blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>&nbsp;
                                <a href="?page=dokumen" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a></td>
                            </tr>
                        </table>  
                    </form>
                    <!-- Form END -->

                </div>
                <!-- Row form END -->

<?php
            }
        } 
?>
