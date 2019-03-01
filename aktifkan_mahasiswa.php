<?php
    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else {

         
        		$id_mahasiswa = $_REQUEST['id_mahasiswa'];
                $dt=mysqli_fetch_array(mysqli_query($config, "SELECT * FROM mahasiswa WHERE id_mahasiswa='$id_mahasiswa'"));
                
                $nim=$dt['nim'];
                $pass=md5($nim); 
                $query=mysqli_query($config, "INSERT tbl_user SET username='$nim', password='$pass', nama='".$dt['nama']."',
                                              nip='$nim',admin='4'");
                $qr2=mysqli_query($config, "UPDATE mahasiswa SET stat=1 WHERE id_mahasiswa='".$id_mahasiswa."'");
                	if($query == true){
                    $_SESSION['succDel'] = 'SUKSES! Berhasil di daftarkan username & password adalah NIM<br/>';
                    header("Location: ./admin.php?page=mahasiswa");
                    die();
            	} else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                    echo '<script language="javascript">
                            window.location.href="./admin.php?page=mahasiswa&act=del&id_mahasiswa='.$id_mahasiswa.'";
                          </script>';
            	}  
    }
?>
