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

                    $id_jadwal = $_REQUEST['id_jadwal'];
                    $admin = $_REQUEST['admin'];
   
                            $query = mysqli_query($config, "UPDATE jadwal_seminar_proposal SET nim='".$_POST['nim']."', tanggal='".date('Y-m-d',strtotime($_POST['tanggal']))."' WHERE id_jadwal='".$_POST['id_jadwal']."'");

                            if($query == true){
                                $_SESSION['succEdit'] = "Data Sudah Terupdate";
                                header("Location: ./admin.php?page=jadwal_seminar_proposal&sub=usr");
                                die();
                            } else {
                                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                echo '<script language="javascript">
                                        window.location.href="./admin.php?page=jadwal_seminar_proposal&sub=usr&act=edit&id_jadwal='.$id_jadwal.'";
                                      </script>';
                            }  
                } else {

                    $id_jadwal = mysqli_real_escape_string($config, $_REQUEST['id_jadwal']);
                    $query = mysqli_query($config, "SELECT * FROM jadwal_seminar_proposal WHERE id_jadwal='".$id_jadwal."'");
                    if(mysqli_num_rows($query) > 0){
                        $no = 1;
                        while($row = mysqli_fetch_array($query)){?>

                        <!-- Row Start -->
                        <div class="row">
                            <!-- Secondary Nav START -->
                            <div class="col s12">
                                <nav class="secondary-nav">
                                    <div class="nav-wrapper blue-grey darken-1">
                                        <ul class="left">
                                            <li class="waves-effect waves-light  tooltipped" data-position="right" data-tooltip="Menu ini hanya untuk mengedit  jadwal_seminar_proposal. jadwal_seminar_proposalname dan password bisa diganti lewat menu profil"><a href="#" class="judul"><i class="material-icons">mode_edit</i> Edit Jadwal Seminar</a></li>
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
                        ?>

                        <!-- Row form Start -->
                        <div class="row jarak-form">

                            <!-- Form START -->
                            <form class="col s12" method="post" action="?page=jadwal_seminar_proposal&sub=usr&act=edit">
                                <table style="width: 100%;">
                                    <tr>
                                        <td style="width: 20%;">ID Jadwal</td>
                                        <td> <input id="kd" type="text" class="validate" maxlength="30" name="id_jadwal" value="<?php echo $id_jadwal; ?>" readonly="" required></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 20%;">Mahasiswa</td>
                                        <td> 
                                             <select name="nim"> 
                                              <?php
                                            $sql =mysqli_query($config,"SELECT a.*,b.nim FROM mahasiswa as a
                                                                        INNER JOIN pengajuan_seminar_skripsi as b
                                                                        ON a.nim=b.nim
                                                                        ORDER BY b.nim='$row[nim]' DESC
                                                                        ");  
                                                    while($ro = mysqli_fetch_array($sql))
                                                       {
                                                         echo "<option value='".$ro['nim']."'>$ro[nama]</option>"; 
                                                        }  
                                                     ?>
                                             </select>
                                             </td>
                                    </tr> 
                                    <tr>
                                        <td style="width: 20%;">Tanggal </td>
                                        <td><input id="tanggal" type="text" class="validate" name="tanggal" value="<?php echo $row['tanggal']; ?>"> </td>
                                    </tr> 
                                    <tr> 
                                    
                                    <tr>
                                        <td colspan="2"><center>
                                            <div class="row">
                                                <div class="col 6">
                                                    <button type="submit" name="submit" class="btn-large blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                                                </div>
                                                <div class="col 6">
                                                    <a href="?page=jadwal" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
                                                </div>
                                            </div></center></td>
                                    </tr>
                                </table>
                            </form>
                            <!-- Form END -->

                        </div>
                        <!-- Row form END --> 
                        <?php
                        }
                    }
                }  
    }
?>
