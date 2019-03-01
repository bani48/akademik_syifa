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
                                 	$fileName 	= $_FILES['transkip']['name'];
                                	$tmpName 	= $_FILES['transkip']['tmp_name']; 
                                	$fileSize 	= $_FILES['transkip']['size']; 
                                	$fileType 	= $_FILES['transkip']['type'];
                                    $filePath = $path.$fileName;
                                    
                                    
                                 	$fileName2 	= $_FILES['krs']['name'];
                                	$tmpName2 	= $_FILES['krs']['tmp_name']; 
                                	$fileSize2 	= $_FILES['krs']['size']; 
                                	$fileTyp2e 	= $_FILES['krs']['type'];
                                    $filePath2 = $path.$fileName2;
                                    
                                    
                                 	$fileName3 	= $_FILES['proposal_pi']['name'];
                                	$tmpName3 	= $_FILES['proposal_pi']['tmp_name']; 
                                	$fileSize3 	= $_FILES['proposal_pi']['size']; 
                                	$fileType3 	= $_FILES['proposal_pi']['type'];
                                    $filePath3 = $path.$fileName3;
                                    
                                    
                                 	$fileName4 	= $_FILES['khs1']['name'];
                                	$tmpName4 	= $_FILES['khs1']['tmp_name']; 
                                	$fileSize4 	= $_FILES['khs1']['size']; 
                                	$fileType4 	= $_FILES['khs1']['type'];
                                    $filePath4 = $path.$fileName4;
                                    
                                 	$fileName5 	= $_FILES['khs2']['name'];
                                	$tmpName5 	= $_FILES['khs2']['tmp_name']; 
                                	$fileSize5 	= $_FILES['khs2']['size']; 
                                	$fileType5 	= $_FILES['khs2']['type'];
                                    $filePath5 = $path.$fileName5;
                                    
                                 	$fileName6 	= $_FILES['khs3']['name'];
                                	$tmpName6 	= $_FILES['khs3']['tmp_name']; 
                                	$fileSize6 	= $_FILES['khs3']['size']; 
                                	$fileType6 	= $_FILES['khs3']['type'];
                                    $filePath6 = $path.$fileName6;
                                    
                                 	$fileName7 	= $_FILES['khs4']['name'];
                                	$tmpName7 	= $_FILES['khs4']['tmp_name']; 
                                	$fileSize7 	= $_FILES['khs4']['size']; 
                                	$fileType7 	= $_FILES['khs4']['type'];
                                    $filePath7 = $path.$fileName7;
                                    
                                    $result = move_uploaded_file($tmpName, $filePath); 
                                    
                                    $result2 = move_uploaded_file($tmpName2, $filePath2); 
                                    
                                    $result3 = move_uploaded_file($tmpName3, $filePath3); 
                                    
                                    $result4 = move_uploaded_file($tmpName4, $filePath4); 
                                    $result5 = move_uploaded_file($tmpName5, $filePath5); 
                                    $result6 = move_uploaded_file($tmpName6, $filePath6); 
                                    $result7 = move_uploaded_file($tmpName7, $filePath7); 
                                    

                                    $query = mysqli_query($config, "INSERT lampiran_pi SET transkip='".$fileName."',
                                                                    krs='".$fileName2."',
                                                                    proposal_pi='".$fileName3."',
                                                                    khs1='".$fileName4."',
                                                                    khs2='".$fileName5."',
                                                                    khs3='".$fileName6."',
                                                                    khs4='".$fileName7."',
                                                                    create_date='".date('Y-m-d H:i:S')."',
                                                                    create_user='".$_POST['create_user']."',
                                                                    nim='".$_POST['mahasiswa']."',
                                                                    status='0'");
                                    if($query != false){
                                         $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                                        header("Location: ./admin.php?page=pi");
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
                                    <li class="waves-effect waves-light"><a href="?page=pi&act=add" class="judul"><i class="material-icons">bookmark</i>Tambah Lampiran Proposal</a></li>
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
                    <form class="col s12" method="post" action="?page=pi&act=upload_lampiran" enctype="multipart/form-data">
                        <table>
                           
                            <tr>
                                <td>Transkip</td>
                                <td> <input id="transkip" type="file" class="validate" name="transkip" placeholder="" required></td>
                            </tr>
                            <tr>
                                <td>KRS</td>
                                <td> <input id="krs" type="file" class="validate" name="krs" placeholder="" required></td>
                            </tr>
                            <tr>
                                <td>Proposal praktek industri</td>
                                <td> <input id="proposal_pi" type="file" class="validate" name="proposal_pi" placeholder="" required></td>
                            </tr>
                            <tr>
                                <td>KHS 1</td>
                                <td> <input id="khs1" type="file" class="validate" name="khs1" placeholder="" required></td>
                            </tr>
                            <tr>
                                <td>KHS 2</td>
                                <td> <input id="khs2" type="file" class="validate" name="khs2" placeholder="" required></td>
                            </tr>
                            <tr>
                                <td>KHS 3</td>
                                <td> <input id="khs3" type="file" class="validate" name="khs3" placeholder="" required></td>
                            </tr>
                            <tr>
                                <td>KHS 4</td>
                                <td> <input id="khs4" type="file" class="validate" name="khs4" placeholder="" required></td>
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
                                            
                                            $sql =mysqli_query($config,"SELECT a.*, b.nama FROM praktek_industri as a 
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
                                       
                                        echo'<input type="hidden" name="mahasiswa" value="'.$_SESSION['nip'].'"/>
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
                                <a href="?page=pi" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a></td>
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
