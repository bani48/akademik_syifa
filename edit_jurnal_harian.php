<link rel="stylesheet" href="/resources/demos/style.css">
  <script src="asset/js/jquery-1.12.4.js"></script>
  <script src="asset/js/jquery-ui.js"></script> 
  <script>
  $( function() {
        $( "#datepicker" ).datepicker({dateFormat:'yy-mm-dd'});
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

                    $id_jurnal_harian = $_REQUEST['id_jurnal_harian'];
                    $admin = $_REQUEST['admin'];
   
                            $query = mysqli_query($config, "UPDATE jurnal_harian SET id_perusahaan='".$_POST['id_perusahaan']."',
                                                             id_mahasiswa='".$_POST['id_mahasiswa']."', kegiatan='".$_POST['kegiatan']."', 
                                                             waktu='".$_POST['waktu']."', keterangan='".$_POST['keterangan']."' 
                                                             WHERE id_jurnal_harian='".$_POST['id_jurnal_harian']."'");

                            if($query == true){
                                $_SESSION['succEdit'] = "Data Sudah Terupdate";
                                header("Location: ./admin.php?page=jurnal_harian&sub=usr");
                                die();
                            } else {
                                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                echo '<script language="javascript">
                                        window.location.href="./admin.php?page=jurnal_harian&sub=usr&act=edit&id_jurnal_harian='.$id_jurnal_harian.'";
                                      </script>';
                            }  
                } else {

                    $id_jurnal_harian = mysqli_real_escape_string($config, $_REQUEST['id_jurnal_harian']);
                    $query = mysqli_query($config, "SELECT * FROM jurnal_harian WHERE id_jurnal_harian='$id_jurnal_harian'");
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
                                            <li class="waves-effect waves-light  tooltipped" data-position="right" data-tooltip="Menu ini hanya untuk mengedit  jurnal_harian. jurnal_harianname dan password bisa diganti lewat menu profil"><a href="#" class="judul"><i class="material-icons">mode_edit</i> Edit  jurnal_harian</a></li>
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
                    <form class="col s12" method="post" action="?page=jurnal_harian&act=edit">
                    
                      <table style="width: 100%;">
                            <tr>
                                <td style="width: 20%;">ID Jurnal Harian</td>
                                <td> <input id="kd" type="text" class="validate" maxlength="30" name="id_jurnal_harian" value="<?php echo $id_jurnal_harian; ?>" readonly="" required></td>
                            </tr>
                            <tr>
                                <td style="width: 20%;">Perusahaan <?php echo $row['id_mahasiswa']; ?></td>
                                <td>
                                     <select name="id_perusahaan"> 
                                        <?php
                                            $sql =mysqli_query($config,"SELECT * FROM perusahaan ORDER BY id_perusahaan='".$row['id_perusahaan']."' DESC");  
                                                    while($dt = mysqli_fetch_array($sql))
                                                       {
                                                         echo "<option value='".$dt['id_perusahaan']."'>$dt[nama_perusahaan]</option>"; 
                                                        }  
                                                     ?>
                                     </select> </td>
                            </tr> 
                            <tr>
                                <td style="width: 20%;">Mahasiswa</td>
                                <td>
                                    <?php 
                                        if($_SESSION['admin']=='1'){
                                            echo' <select name="id_mahasiswa"> ';
                                                    
                                                        $sql =mysqli_query($config,"SELECT * from mahasiswa ORDER BY nim='$row[id_mahasiswa]' DESC ");  
                                                                while($ss = mysqli_fetch_array($sql))
                                                                   {
                                                                     echo "<option value='".$ss['nim']."'>$ss[nim] - $ss[nama]</option>"; 
                                                                    }  
                                                                 
                                                 echo'</select>';
                                        }else{
                                            echo '<input  type="text" class="validate" value="'.$_SESSION['nama'].'"  readonly=""> ';
                                            echo '<input id="id_mahasiswa" type="hidden" class="validate" value="'.$_SESSION['username'].'" name="id_mahasiswa" readonly=""> ';  
                                        }
                                    ?> 
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 20%;">Kegiatan</td>
                                <td>
                                <input id="kegiatan" type="text" class="validate" name="kegiatan" value="<?php echo $row['kegiatan']; ?>" placeholder="" required> </td>
                            </tr>
                            <tr>
                                <td style="width: 20%;">Waktu</td>
                                <td>
                                <input id="datepicker" type="text" class="validate" name="waktu" value="<?php echo $row['waktu']; ?>" placeholder="" required> </td>
                            </tr>
                            
                            <tr>
                                <td style="width: 20%;">Keterangan</td>
                                <td>
                                <input id="keterangan" type="text" class="validate" name="keterangan" value="<?php echo $row['keterangan'];?>" placeholder="" required> </td>
                            </tr>
                            
                            
                            <tr>
                                <td colspan="2"><center>
                                    <div class="row">
                                        <div class="col 6">
                                            <button type="submit" name="submit" class="btn-large blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                                        </div>
                                        <div class="col 6">
                                            <a href="?page=jurnal_harian" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
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
