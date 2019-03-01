<?php
    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else { 
        		$id_dosen = $_REQUEST['id_dosen'];

                $query = mysqli_query($config, "DELETE FROM dosen WHERE id_dosen='$id_dosen'");

            	if($query == true){
                    $_SESSION[' '] = 'SUKSES! Data berhasil dihapus<br/>';
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
