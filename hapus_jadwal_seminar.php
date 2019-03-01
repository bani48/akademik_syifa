<?php
    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else {

         
        		$id_jadwal = $_REQUEST['id_jadwal'];

                $query = mysqli_query($config, "DELETE FROM jadwal_seminar_proposal WHERE id_jadwal='$id_jadwal'");

            	if($query == true){
                    $_SESSION['succDel'] = 'SUKSES! Data berhasil dihapus<br/>';
                    header("Location: ./admin.php?page=jadwal_seminar_proposal");
                    die();
            	} else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                    echo '<script language="javascript">
                            window.location.href="./admin.php?page=jadwal_seminar_proposal&act=del&id_jadwal='.$id_jadwal.'";
                          </script>';
            	} 
}

?>
