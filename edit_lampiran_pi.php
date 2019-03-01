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
    $isi=mysqli_fetch_array(mysqli_query($config,"SELECT lampiran_pi.*, 
                                                                (SELECT mahasiswa.nama FROM mahasiswa WHERE mahasiswa.nim=lampiran_pi.nim) AS nama
                                                                 FROM lampiran_pi WHERE lampiran_pi.id='".$_REQUEST['id_pi']."'"));
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
                                    
                                    if ($fileName==''){
                                       $fileName=$isi['transkip']; 
                                    }else{ 
                                       $fileName=$fileName;
                                    }
                                    if ($fileName2==''){
                                       $fileName2=$isi['krs']; 
                                    }else{ 
                                       $fileName2=$fileName2;
                                    }
                                    if ($fileName3==''){
                                       $fileName3=$isi['proposal_pi']; 
                                    }else{ 
                                       $fileName3=$fileName3;
                                    }
                                    if ($fileName4==''){
                                       $fileName4=$isi['khs1']; 
                                    }else{ 
                                       $fileName4=$fileName4;
                                    }
                                    if ($fileName5==''){
                                       $fileName5=$isi['khs2']; 
                                    }else{ 
                                       $fileName5=$fileName5;
                                    }
                                    if ($fileName6==''){
                                       $fileName6=$isi['khs3']; 
                                    }else{ 
                                       $fileName6=$fileName6;
                                    }
                                    if ($fileName7==''){
                                       $fileName7=$isi['khs4']; 
                                    }else{ 
                                       $fileName7=$fileName7;
                                    } 


                                    $query = mysqli_query($config, "UPDATE lampiran_pi SET transkip='".$fileName."',
                                                                    krs='".$fileName2."',
                                                                    proposal_pi='".$fileName3."',
                                                                    khs1='".$fileName4."',
                                                                    khs2='".$fileName5."',
                                                                    khs3='".$fileName6."',
                                                                    khs4='".$fileName7."', 
                                                                    nim='".$_REQUEST['mahasiswa']."'
                                                                    WHERE id='".$_POST['id']."'");
                                    if($query != false){
                                         $_SESSION['succAdd'] = 'SUKSES! Data berhasil diupdate';
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
                                    <li class="waves-effect waves-light"><a href="?page=pi&act=add" class="judul"><i class="material-icons">bookmark</i>Edit Lampiran Proposal</a></li>
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
                    <form class="col s12" method="post" action="?page=pi&act=edit_lampiran" enctype="multipart/form-data">
                        <table>
                           
                            <tr>
                                <td>Transkip</td>
                                <td><input type="hidden" name="id" id="id" value="<?php echo $_REQUEST['id_pi']; ?>"/>
                                     <input id="transkip" type="file" class="validate" name="transkip" value="<?php echo $isi['transkip']; ?>" placeholder="" ><?php echo $isi['transkip']; ?></td>
                            </tr>
                            <tr>
                                <td>KRS</td>
                                <td> <input id="krs" type="file" class="validate" name="krs" value="<?php echo $isi['krs']; ?>" placeholder="" ><?php echo $isi['krs']; ?></td>
                            </tr>
                            <tr>
                                <td>Proposal praktek industri</td>
                                <td> <input id="proposal_pi" type="file" class="validate" name="proposal_pi" value="<?php echo $isi['proposal_pi']; ?>" placeholder="" ><?php echo $isi['proposal_pi']; ?></td>
                            </tr>
                            <tr>
                                <td>KHS 1</td>
                                <td> <input id="khs1" type="file" class="validate" name="khs1" value="<?php echo $isi['khs1']; ?>" placeholder="" ><?php echo $isi['khs1']; ?></td>
                            </tr>
                            <tr>
                                <td>KHS 2</td>
                                <td> <input id="khs2" type="file" class="validate" value="<?php echo $isi['khs2']; ?>" name="khs2" placeholder="" ><?php echo $isi['khs2']; ?></td>
                            </tr>
                            <tr>
                                <td>KHS 3</td>
                                <td> <input id="khs3" type="file" class="validate" value="<?php echo $isi['khs3']; ?>" name="khs3" placeholder="" ><?php echo $isi['khs3']; ?></td>
                            </tr>
                            <tr>
                                <td>KHS 4</td>
                                <td> <input id="khs4" type="file" class="validate" value="<?php echo $isi['khs4']; ?>" name="khs4" placeholder="" ><?php echo $isi['khs4']; ?></td>
                            </tr>
                            <tr>
                                <td>Mahasiswa</td>
                                <td>
                                    <?php 
                                    
                                    if($_SESSION['admin']=='1'){
                                    ?>
                                    <select name="mahasiswa"> 
                                        <?php
                                            
                                            $sql =mysqli_query($config,"SELECT a.*, b.nama FROM praktek_industri as a 
                                                                         INNER JOIN mahasiswa as b ON b.nim = a.nim
                                                                      GROUP BY nim ORDER BY a.nim='".$isi['nim']."'");  
                                                    while($row = mysqli_fetch_array($sql))
                                                       {
                                                         echo "<option value='".$row['id']."'>$row[nim] - $row[nama]</option>"; 
                                                        } 
                                        ?>
                                    </select>
                                    <?php    
                                    }else{ 
                                       
                                        echo'<input type="hidden" name="mahasiswa" value="'.$isi['nim'].'"/>
                                            <input type="text" name="nama" value="'.$isi['nama'].'" readonly=""/>';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <!--td>Tanggal Upload</td>
                                <td>  <input id="tanggal" type="text" class="validate" name="tanggal_upload" >-->
                                    <input type="hidden" class="validate" name="create_user" value="<?php echo $_SESSION['username']; ?>" >
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
