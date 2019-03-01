<?php
    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else {

         
        		$id_perusahaan = $_REQUEST['id_perusahaan'];

                $query = mysqli_query($config, "DELETE FROM perusahaan WHERE id_perusahaan='$id_perusahaan'");

            	if($query == true){
                    $_SESSION['succDel'] = 'SUKSES! Data berhasil dihapus<br/>';
                    header("Location: ./admin.php?page=perusahaan");
                    die();
            	} else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                    echo '<script language="javascript">
                            window.location.href="./admin.php?page=perusahaan&act=del&id_perusahaan='.$id_perusahaan.'";
                          </script>';
            	} 
}

?>
