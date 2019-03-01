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

        if($_SESSION['admin'] != 1 AND $_SESSION['admin'] != 2){
            echo '<script language="javascript">
                    window.alert("ERROR! Anda tidak memiliki hak akses untuk menambahkan data");
                    window.location.href="./admin.php?page=jadwal";
                  </script>';
        } else {

            if(isset($_REQUEST['submit'])){
  
                    $id_jadwal = $_REQUEST['id_jadwal'];
                    $nim = $_REQUEST['nim'];
                    $tanggal = $_REQUEST['tanggal']; 
                    $status = '1'; 
                    $id_user = $_SESSION['admin'];
  
                                $cek = mysqli_query($config, "SELECT * FROM jadwal_seminar_proposal WHERE id_jadwal='$id_jadwal'");
                                $result = mysqli_num_rows($cek);

                                if($result > 0){
                                    $_SESSION['duplikasi'] = 'id_jadwal sudah ada, pilih yang lainnya!';
                                    echo '<script language="javascript">window.history.back();</script>';
                                } else {

                                    $query = mysqli_query($config, "INSERT INTO jadwal_seminar_proposal(id_jadwal,nim,tanggal) VALUES('$id_jadwal','$nim','$tanggal')");

                                    if($query != false){
                                         $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                                        header("Location: ./admin.php?page=jadwal_seminar_proposal");
                                      //  die();
                                    } else {
                                       $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                        
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
                                    <li class="waves-effect waves-light"><a href="?page=jadwal&act=add" class="judul"><i class="material-icons">bookmark</i> Tambah Jadwal Seminar Skripsi</a></li>
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
                      $sql ="SELECT max(id_jadwal) as id_jadwal from jadwal_seminar_proposal";
                      $hasil = mysqli_query($config,$sql);
                      $data = mysqli_fetch_array($hasil); 
                      $lastID = $data['id_jadwal'];
                      $lastNoUrut = substr($lastID, 1, 4);
                      $nextNoUrut = $lastNoUrut + 1;
                      $kode = "J".sprintf("%04s",$nextNoUrut);
                ?>

                <!-- Row form Start -->
                <div class="">
                
                    <!-- Form START -->
                    <form class=" " method="post" action="?page=jadwal_seminar_proposal&act=add">
                        <table style="width: 100%;">
                            <tr>
                                <td style="width: 20%;">ID Jadwal</td>
                                <td> <input id="kd" type="text" class="validate" maxlength="30" name="id_jadwal" value="<?php echo $kode; ?>" readonly="" required></td>
                            </tr>
                            <tr>
                                <td style="width: 20%;">Mahasiswa</td>
                                <td>
                                     <select name="nim">
                                        <option></option>
                                        <?php
                                            $sql =mysqli_query($config,"SELECT a.*,b.nim FROM mahasiswa as a
                                                                        INNER JOIN pengajuan_seminar_skripsi as b
                                                                        ON a.nim=b.nim
                                                                        ");  
                                                    while($row = mysqli_fetch_array($sql))
                                                       {
                                                         echo "<option value='".$row['nim']."'>$row[nama]</option>"; 
                                                        }  
                                                     ?>
                                     </select> </td>
                            </tr> 
                            <tr>
                                <td style="width: 20%;">Tanggal</td>
                                <td> <input type="text" id="tanggal" class="validate" name="tanggal" placeholder="" required></td>
                            </tr>  
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
                         
                        <!-- Row in form END -->

                    </form>
                    <!-- Form END -->

                </div>
                <!-- Row form END -->

<?php
            }
        }
    }
?>
