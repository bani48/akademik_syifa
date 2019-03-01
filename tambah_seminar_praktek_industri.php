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
                    $id_user = $_SESSION['admin'];  
                                    
                                    $path = "upload/"; 
                                 	$fileName 	= $_FILES['laporan_pi']['name'];
                                	$tmpName 	= $_FILES['laporan_pi']['tmp_name']; 
                                	$fileSize 	= $_FILES['laporan_pi']['size']; 
                                	$fileType 	= $_FILES['laporan_pi']['type'];
                                    $filePath = $path.$fileName;
                                    
                                    
                                 	$fileName2 	= $_FILES['jurnal_pi']['name'];
                                	$tmpName2 	= $_FILES['jurnal_pi']['tmp_name']; 
                                	$fileSize2 	= $_FILES['jurnal_pi']['size']; 
                                	$fileTyp2e 	= $_FILES['jurnal_pi']['type'];
                                    $filePath2 = $path.$fileName2;
                                    
                                    
                                 	$fileName3 	= $_FILES['kartu_bimbingan']['name'];
                                	$tmpName3 	= $_FILES['kartu_bimbingan']['tmp_name']; 
                                	$fileSize3 	= $_FILES['kartu_bimbingan']['size']; 
                                	$fileType3 	= $_FILES['kartu_bimbingan']['type'];
                                    $filePath3 = $path.$fileName3;
                                     
                                    
                                    $result = move_uploaded_file($tmpName, $filePath); 
                                    
                                    $result2 = move_uploaded_file($tmpName2, $filePath2); 
                                    
                                    $result3 = move_uploaded_file($tmpName3, $filePath3);  
                                        
                                    $query = mysqli_query($config, "INSERT seminar_praktek_industri SET id_pi='".$_POST['mahasiswa']."',
                                                                    laporan_pi='".$fileName."',
                                                                    jurnal_pi='".$fileName2."',
                                                                    kartu_bimbingan='".$fileName3."',
                                                                    status='0'");
                                                                     
                                    if($query != false){
                                         $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                                        header("Location: ./admin.php?page=daftar_pi");
                                        die();
                                    } else {
                                       $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                     //  echo '<script language="javascript">window.history.back();</script>';
                                    }  
            } else {?>
                <!-- Row Start -->
                <div class="row">
                    <!-- Secondary Nav START -->
                    <div class="col s12">
                        <nav class="secondary-nav">
                            <div class="nav-wrapper blue-grey darken-1">
                                <ul class="left">
                                    <li class="waves-effect waves-light"><a href="?page=daftar_pi&act=add" class="judul"><i class="material-icons">bookmark</i>Tambah Seminar PI</a></li>
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
                <div class="row jarak-form">

                    <!-- Form START -->
                    <form class="col s12" method="post" action="?page=daftar_pi&act=tambah_seminar_praktek_industri" enctype="multipart/form-data">
                        <table>
                           
                            <tr>
                                <td>Nama Mahasiswa</td>
                                <td> 
                                     <?php 
                                    if($_SESSION['admin']=='1'){
                                    ?>
                                    <select name="mahasiswa">
                                        <option>-pilih-</option>
                                        <?php
                                            
                                            $sql =mysqli_query($config,"SELECT a.*, b.nama FROM praktek_industri as a 
                                                                         INNER JOIN mahasiswa as b ON b.nim = a.nim
                                                                      GROUP BY nim");  
                                                    while($row = mysqli_fetch_array($sql))
                                                       {
                                                         echo "<option value='".$row['id_pi']."'>$row[nim] - $row[nama]</option>"; 
                                                        } 
                                        ?>
                                    </select>
                                    <?php    
                                    }else{
                                        $sql =mysqli_fetch_array(mysqli_query($config,"SELECT a.*, b.nama FROM praktek_industri as a 
                                                                             INNER JOIN mahasiswa as b ON b.nim = a.nim
                                                                          WHERE b.nim='".$_SESSION['username']."'")); 
                                       
                                        echo'<input type="hidden" name="mahasiswa" value="'.$sql['id'].'"/>
                                            <input type="text" name="nama" value="'.$_SESSION['nama'].'" readonly=""/>';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Laporan Praktek Industri</td>
                                <td> <input id="laporan_pi" type="file" class="validate" name="laporan_pi" placeholder="" required></td>
                            </tr>
                            <tr>
                                <td>Jurnal Praktek Industri</td>
                                <td> <input id="jurnal_pi" type="file" class="validate" name="jurnal_pi" placeholder="" required></td>
                            </tr>
                            <tr>
                                <td>Kartu Bimbingan</td>
                                <td> <input id="kartu_bimbingan" type="file" class="validate" name="kartu_bimbingan" placeholder="" required></td>
                            </tr> 
                            <tr>
                                <td>
                                    <input type="hidden" class="validate" name="create_user" value="<?php echo $_SESSION['username']; ?>" required>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center"><button type="submit" name="submit" class="btn-large blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>&nbsp;
                                <a href="?page=daftar_pi" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a></td>
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
