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
                                 	$fileName 	= $_FILES['form_pendaftaran_seminar']['name'];
                                	$tmpName 	= $_FILES['form_pendaftaran_seminar']['tmp_name']; 
                                	$fileSize 	= $_FILES['form_pendaftaran_seminar']['size']; 
                                	$fileType 	= $_FILES['form_pendaftaran_seminar']['type'];
                                    $filePath = $path.$fileName;
                                    
                                    
                                 	$fileName2 	= $_FILES['bukti_serah_terima']['name'];
                                	$tmpName2 	= $_FILES['bukti_serah_terima']['tmp_name']; 
                                	$fileSize2 	= $_FILES['bukti_serah_terima']['size']; 
                                	$fileTyp2e 	= $_FILES['bukti_serah_terima']['type'];
                                    $filePath2 = $path.$fileName2;
                                    
                                    
                                 	$fileName3 	= $_FILES['bimbingan_skripsi']['name'];
                                	$tmpName3 	= $_FILES['bimbingan_skripsi']['tmp_name']; 
                                	$fileSize3 	= $_FILES['bimbingan_skripsi']['size']; 
                                	$fileType3 	= $_FILES['bimbingan_skripsi']['type'];
                                    $filePath3 = $path.$fileName3;
                                    
                                    
                                 	$fileName4 	= $_FILES['laporan_proposal']['name'];
                                	$tmpName4 	= $_FILES['laporan_proposal']['tmp_name']; 
                                	$fileSize4 	= $_FILES['laporan_proposal']['size']; 
                                	$fileType4 	= $_FILES['laporan_proposal']['type'];
                                    $filePath4 = $path.$fileName4;
                                    
                                    $result = move_uploaded_file($tmpName, $filePath); 
                                    
                                    $result2 = move_uploaded_file($tmpName2, $filePath2); 
                                    
                                    $result3 = move_uploaded_file($tmpName3, $filePath3); 
                                    
                                    $result4 = move_uploaded_file($tmpName4, $filePath4); 
                                    

                                    $query = mysqli_query($config, "INSERT lampiran_seminar SET pendaftaran_seminar='".$fileName."',
                                                                    bukti_serah_terima='".$fileName2."',
                                                                    kartu_bimbingan='".$fileName3."',
                                                                    laporan_pengajuan='".$fileName4."',
                                                                    create_date='".date('Y-m-d H:i:S')."',
                                                                    create_user='".$_REQUEST['create_user']."',
                                                                    id_proposal='".$_REQUEST['mahasiswa']."',
                                                                    status='0'");
                                    if($query != false){
                                         $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                                        header("Location: ./admin.php?page=pengajuan_seminar");
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
                                    <li class="waves-effect waves-light"><a href="?page=pengajuan_seminar&act=add" class="judul"><i class="material-icons">bookmark</i>Tambah Lampiran Proposal</a></li>
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
                    <form class="col s12" method="post" action="?page=pengajuan_seminar&act=upload_lampiran" enctype="multipart/form-data">
                        <table>
                           
                            <tr>
                                <td>Form Pendaftaran Seminar</td>
                                <td> <input id="form_pendaftaran_seminar" type="file" class="validate" name="form_pendaftaran_seminar" placeholder="" required></td>
                            </tr>
                            <tr>
                                <td>Form Bukti Serah Terima Laporan PI</td>
                                <td> <input id="bukti_serah_terima" type="file" class="validate" name="bukti_serah_terima" placeholder="" required></td>
                            </tr>
                            <tr>
                                <td>Kartu Bimbingan Proposal</td>
                                <td> <input id="bimbingan_skripsi" type="file" class="validate" name="bimbingan_skripsi" placeholder="" required></td>
                            </tr>
                            <tr>
                                <td>Laporan Pengajuan Proposal Skripsi</td>
                                <td> <input id="laporan_proposal" type="file" class="validate" name="laporan_proposal" placeholder="" required></td>
                            </tr>
                            <tr>
                                <td>Mahasiswa</td>
                                <td>
                                    <?php 
                                    if($_SESSION['admin']=='1'){
                                    ?>
                                    <select name="mahasiswa">
                                        <option>-pilih-</option>
                                        <?php
                                            
                                            $sql =mysqli_query($config,"SELECT a.*, b.nama FROM pengajuan_proposal_skripsi as a 
                                                                         INNER JOIN mahasiswa as b ON b.nim = a.nim
                                                                      GROUP BY nim");  
                                                    while($row = mysqli_fetch_array($sql))
                                                       {
                                                         echo "<option value='".$row['id']."'>$row[nim] - $row[nama]</option>"; 
                                                        } 
                                        ?>
                                    </select>
                                    <?php    
                                    }else{
                                        $sql =mysqli_fetch_array(mysqli_query($config,"SELECT a.*, b.nama FROM pengajuan_proposal_skripsi as a 
                                                                             INNER JOIN mahasiswa as b ON b.nim = a.nim
                                                                          WHERE b.nim='".$_SESSION['username']."'")); 
                                       
                                        echo'<input type="hidden" name="mahasiswa" value="'.$sql['id'].'"/>
                                            <input type="text" name="nama" value="'.$_SESSION['nama'].'" readonly=""/>';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <!--td>Tanggal Upload</td>
                                <td>  <input id="tanggal" type="text" class="validate" name="tanggal_upload" required>-->
                                    <input type="hidden" class="validate" name="create_user" value="<?php echo $_SESSION['username']; ?>" required>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center"><button type="submit" name="submit" class="btn-large blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>&nbsp;
                                <a href="?page=pengajuan_seminar" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a></td>
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
