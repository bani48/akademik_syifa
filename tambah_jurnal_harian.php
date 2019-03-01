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

        if($_SESSION['admin'] != 1 AND $_SESSION['admin'] != 4){
            echo '<script language="javascript">
                    window.alert("ERROR! Anda tidak memiliki hak akses untuk menambahkan data");
                    window.location.href="./admin.php?page=jurnal_harian";
                  </script>';
        } else {

            if(isset($_REQUEST['submit'])){

                //validasi form kosong
                if($_REQUEST['id_jurnal_harian'] == "" || $_REQUEST['id_perusahaan'] == "" || $_REQUEST['id_mahasiswa'] == ""){
                    $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
                    echo '<script language="javascript">window.history.back();</script>';
                } else {

                    $id_jurnal_harian = $_REQUEST['id_jurnal_harian'];
                    $id_perusahaan = $_REQUEST['id_perusahaan']; 
                    $id_mahasiswa= $_REQUEST['id_mahasiswa']; 
                    $kegiatan = $_REQUEST['kegiatan']; 
                    $waktu = $_REQUEST['waktu']; 
                    $keterangan = $_REQUEST['keterangan'];  
                    $id_user = $_SESSION['admin']; 

                                $cek = mysqli_query($config, "SELECT * FROM jurnal_harian WHERE id_jurnal_harian='$id_jurnal_harian'");
                                $result = mysqli_num_rows($cek);

                                if($result > 0){
                                    $_SESSION['duplikasi'] = 'id_jurnal_harian sudah ada, pilih yang lainnya!';
                                    echo '<script language="javascript">window.history.back();</script>';
                                } else {

                                    $query = mysqli_query($config, "INSERT INTO jurnal_harian(id_jurnal_harian,id_perusahaan,id_mahasiswa,kegiatan,waktu,keterangan) VALUES('$id_jurnal_harian','$id_perusahaan','$id_mahasiswa','$kegiatan','$waktu','$keterangan')");

                                    if($query != false){
                                         $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                                        header("Location: ./admin.php?page=jurnal_harian");
                                        die();
                                    } else {
                                       $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                       echo '<script language="javascript">window.history.back();</script>';
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
                                    <li class="waves-effect waves-light"><a href="?page=jurnal_harian&act=add" class="judul"><i class="material-icons">bookmark</i> Tambah jurnal_harian</a></li>
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
                    
                      $sql ="SELECT max(id_jurnal_harian) as id_jurnal_harian from jurnal_harian";
                      $hasil = mysqli_query($config,$sql);
                      $data = mysqli_fetch_array($hasil); 
                      $lastID = $data['id_jurnal_harian'];
                      $lastNoUrut = substr($lastID, 1, 4);
                      $nextNoUrut = $lastNoUrut + 1;
                      $id_jurnal_harian = "J".sprintf("%04s",$nextNoUrut);
                ?>

                <!-- Row form Start -->
                <div class="row jarak-form">

                    <!-- Form START -->
                    <form class="col s12" method="post" action="?page=jurnal_harian&act=add">
                    
                      <table style="width: 100%;">
                            <tr>
                                <td style="width: 20%;">ID Jurnal Harian</td>
                                <td> <input id="kd" type="text" class="validate" maxlength="30" name="id_jurnal_harian" value="<?php echo $id_jurnal_harian; ?>" readonly="" required></td>
                            </tr>
                            <tr>
                                <td style="width: 20%;">Perusahaan</td>
                                <td>
                                     <select name="id_perusahaan">
                                        <option></option>
                                        <?php
                                            $sql =mysqli_query($config,"SELECT * FROM perusahaan");  
                                                    while($row = mysqli_fetch_array($sql))
                                                       {
                                                         echo "<option value='".$row['id_perusahaan']."'>$row[nama_perusahaan]</option>"; 
                                                        }  
                                                     ?>
                                     </select> </td>
                            </tr> 
                            <tr>
                                <td style="width: 20%;">Mahasiswa</td>
                                <td>
                                    <?php
                                        if($_SESSION['admin']=='1'){
                                            echo' <select name="id_mahasiswa">
                                                    <option></option>';
                                                    
                                                        $sql =mysqli_query($config,"SELECT * FROM mahasiswa");  
                                                                while($row = mysqli_fetch_array($sql))
                                                                   {
                                                                     echo "<option value='".$row['id_mahasiswa']."'>$row[nama]</option>"; 
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
                                <input id="kegiatan" type="text" class="validate" name="kegiatan" placeholder="" required> </td>
                            </tr>
                            <tr>
                                <td style="width: 20%;">Waktu</td>
                                <td>
                                <input id="datepicker" type="text" class="validate" name="waktu" placeholder="" required> </td>
                            </tr>
                            
                            <tr>
                                <td style="width: 20%;">Keterangan</td>
                                <td>
                                <input id="keterangan" type="text" class="validate" name="keterangan" placeholder="" required> </td>
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
?>
