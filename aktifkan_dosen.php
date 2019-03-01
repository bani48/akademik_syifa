<?php
    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else {

         
        		$id_dosen = $_REQUEST['id_dosen'];
                $dt=mysqli_fetch_array(mysqli_query($config, "SELECT * FROM dosen WHERE id_dosen='$id_dosen'"));
                
                $nip=$dt['nip'];
                $pass=md5($nip); 
                $query=mysqli_query($config, "INSERT tbl_user SET username='$nip', password='$pass', nama='".$dt['nama']."',
                                              nip='$nip',admin='3'");
                $qr2=mysqli_query($config, "UPDATE dosen SET stat=1 WHERE id_dosen='".$id_dosen."'");
                	if($query == true){
                    $_SESSION['succDel'] = 'SUKSES! Berhasil di daftarkan username & password adalah nip<br/>';
                    header("Location: ./admin.php?page=dosen");
                    die();
            	} else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                    echo '<script language="javascript">
                            window.location.href="./admin.php?page=dosen&act=del&id_dosen='.$id_dosen.'";
                          </script>';
            	}  
    }
?>
