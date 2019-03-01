<?php
    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else {

         
        		$id_mahasiswa = $_REQUEST['id_mahasiswa'];

                $query = mysqli_query($config, "DELETE FROM mahasiswa WHERE id_mahasiswa='$id_mahasiswa'");

            	if($query == true){
                    $_SESSION['succDel'] = 'SUKSES! Data berhasil dihapus<br/>';
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
