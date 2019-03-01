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
                                 	$fileName 	= $_FILES['pendaftaran_seminar']['name'];
                                	$tmpName 	= $_FILES['pendaftaran_seminar']['tmp_name']; 
                                	$fileSize 	= $_FILES['pendaftaran_seminar']['size']; 
                                	$fileType 	= $_FILES['pendaftaran_seminar']['type'];
                                    $filePath = $path.$fileName;
                                    
                                    
                                 	$fileName2 	= $_FILES['bukti_serah_terima']['name'];
                                	$tmpName2 	= $_FILES['bukti_serah_terima']['tmp_name']; 
                                	$fileSize2 	= $_FILES['bukti_serah_terima']['size']; 
                                	$fileTyp2e 	= $_FILES['bukti_serah_terima']['type'];
                                    $filePath2 = $path.$fileName2;
                                    
                                    
                                 	$fileName3 	= $_FILES['kartu_bimbingan']['name'];
                                	$tmpName3 	= $_FILES['kartu_bimbingan']['tmp_name']; 
                                	$fileSize3 	= $_FILES['kartu_bimbingan']['size']; 
                                	$fileType3 	= $_FILES['kartu_bimbingan']['type'];
                                    $filePath3 = $path.$fileName3;
                                    
                                    
                                 	$fileName4 	= $_FILES['lembar_pernyataan']['name'];
                                	$tmpName4 	= $_FILES['lembar_pernyataan']['tmp_name']; 
                                	$fileSize4 	= $_FILES['lembar_pernyataan']['size']; 
                                	$fileType4 	= $_FILES['lembar_pernyataan']['type'];
                                    $filePath4 = $path.$fileName4;
                                    
                                 	$fileName5 	= $_FILES['surat_pernyataan']['name'];
                                	$tmpName5 	= $_FILES['surat_pernyataan']['tmp_name']; 
                                	$fileSize5 	= $_FILES['surat_pernyataan']['size']; 
                                	$fileType5 	= $_FILES['surat_pernyataan']['type'];
                                    $filePath5 = $path.$fileName5;
                                    
                                 	$fileName6 	= $_FILES['krs']['name'];
                                	$tmpName6 	= $_FILES['krs']['tmp_name']; 
                                	$fileSize6 	= $_FILES['krs']['size']; 
                                	$fileType6 	= $_FILES['krs']['type'];
                                    $filePath6 = $path.$fileName6;
                                    
                                 	$fileName7 	= $_FILES['transkip_nilai']['name'];
                                	$tmpName7 	= $_FILES['transkip_nilai']['tmp_name']; 
                                	$fileSize7 	= $_FILES['transkip_nilai']['size']; 
                                	$fileType7 	= $_FILES['transkip_nilai']['type'];
                                    $filePath7 = $path.$fileName7;
                                    
                                 	$fileName8 	= $_FILES['form_ba']['name'];
                                	$tmpName8 	= $_FILES['form_ba']['tmp_name']; 
                                	$fileSize8 	= $_FILES['form_ba']['size']; 
                                	$fileType8 	= $_FILES['form_ba']['type'];
                                    $filePath8 = $path.$fileName8;
                                    
                                 	$fileName9 	= $_FILES['form_nilai']['name'];
                                	$tmpName9 	= $_FILES['form_nilai']['tmp_name']; 
                                	$fileSize9 	= $_FILES['form_nilai']['size']; 
                                	$fileType9 	= $_FILES['form_nilai']['type'];
                                    $filePath9 = $path.$fileName9;
                                    
                                 	$fileName10 	= $_FILES['naskah_proposal']['name'];
                                	$tmpName10 	= $_FILES['naskah_proposal']['tmp_name']; 
                                	$fileSize10 	= $_FILES['naskah_proposal']['size']; 
                                	$fileType10 	= $_FILES['naskah_proposal']['type'];
                                    $filePath10 = $path.$fileName10;
                                    
                                    $result = move_uploaded_file($tmpName, $filePath); 
                                    
                                    $result2 = move_uploaded_file($tmpName2, $filePath2); 
                                    
                                    $result3 = move_uploaded_file($tmpName3, $filePath3); 
                                    
                                    $result4 = move_uploaded_file($tmpName4, $filePath4); 
                                    
                                    $result5 = move_uploaded_file($tmpName5, $filePath5); 
                                    
                                    $result6 = move_uploaded_file($tmpName6, $filePath6); 
                                    
                                    $result7 = move_uploaded_file($tmpName7, $filePath7); 
                                    
                                    $result8 = move_uploaded_file($tmpName8, $filePath8); 
                                    
                                    $result9 = move_uploaded_file($tmpName9, $filePath9); 
                                    
                                    $result10 = move_uploaded_file($tmpName10, $filePath10); 
                                    

                                    $query = mysqli_query($config, "INSERT lampiran_seminar_hasil SET pendaftaran_seminar='".$fileName."',
                                                                    bukti_serah_terima='".$fileName2."',
                                                                    kartu_bimbingan='".$fileName3."',
                                                                    lembar_pernyataan='".$fileName4."',
                                                                    surat_pernyataan='".$fileName5."',
                                                                    krs='".$fileName6."',
                                                                    transkip_nilai='".$fileName7."',
                                                                    form_ba='".$fileName8."',
                                                                    form_nilai='".$fileName9."',
                                                                    naskah_proposal='".$fileName10."',
                                                                    create_date='".date('Y-m-d H:i:S')."',
                                                                    create_user='".$_REQUEST['create_user']."',
                                                                    id_proposal='".$_REQUEST['mahasiswa']."',
                                                                    status='0'");
                                    if($query != false){
                                         $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                                        header("Location: ./admin.php?page=pengajuan_hasil_seminar");
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
                                    <li class="waves-effect waves-light"><a href="?page=pengajuan_hasil_seminar&act=add" class="judul"><i class="material-icons">bookmark</i>Tambah Lampiran Seminar Hasil</a></li>
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
                    <form class="col s12" method="post" action="?page=pengajuan_hasil_seminar&act=upload_lampiran_hasil" enctype="multipart/form-data">
                        <table>
                           
                            <tr>
                                <td>Form Pendaftaran Seminar Hasil</td>
                                <td> <input id="pendaftaran_seminar" type="file" class="validate" name="pendaftaran_seminar" placeholder="" required></td>
                            </tr>
                            <tr>
                                <td>Form bukti serah terima laporan Praktik Industri</td>
                                <td> <input id="bukti_serah_terima" type="file" class="validate" name="bukti_serah_terima" placeholder="" required></td>
                            </tr>
                            <tr>
                                <td>Kartu bimbingan proposal skripsi</td>
                                <td> <input id="kartu_bimbingan" type="file" class="validate" name="kartu_bimbingan" placeholder="" required></td>
                            </tr>
                            <tr>
                                <td>Lembar pernyataan judul skripsi</td>
                                <td> <input id="lembar_pernyataan" type="file" class="validate" name="lembar_pernyataan" placeholder="" required></td>
                            </tr>
                            <tr>
                                <td>Surat pernyataan koreksi naskah  proposal  skripsi </td>
                                <td> <input id="surat_pernyataan" type="file" class="validate" name="surat_pernyataan" placeholder="" required></td>
                            </tr>
                            <tr>
                                <td>KRS semester yang sedang berjalan</td>
                                <td> <input id="krs" type="file" class="validate" name="krs" placeholder="" required></td>
                            </tr>
                            <tr>
                                <td>Transkrip nilai yang ditanda tangani dosen pembimbing akademik</td>
                                <td> <input id="transkip_nilai" type="file" class="validate" name="transkip_nilai" placeholder="" required></td>
                            </tr>
                            <tr>
                                <td>Form berita acara seminar proposal skripsi</td>
                                <td> <input id="form_ba" type="file" class="validate" name="form_ba" placeholder="" required></td>
                            </tr>
                            <tr>
                                <td>Form nilai seminar proposal skripsi</td>
                                <td> <input id="form_nilai" type="file" class="validate" name="form_nilai" placeholder="" required></td>
                            </tr>
                            <tr>
                                <td>Naskah proposal skripsi yang sudah di acc </td>
                                <td> <input id="naskah_proposal" type="file" class="validate" name="naskah_proposal" placeholder="" required></td>
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
                                <a href="?page=pengajuan_hasil_seminar" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a></td>
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
