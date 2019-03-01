<?php
    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else {

         
        		$id = $_REQUEST['id'];

                $query = mysqli_query($config, "UPDATE pengajuan_proposal_skripsi SET status='2' WHERE id='$id'");

            	if($query == true){
                    $_SESSION['succDel'] = 'Maaf! Proposal skripsi ditolak<br/>';
                    header("Location: ./admin.php?page=pengajuan_proposal");
                    die();
            	} else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                    echo '<script language="javascript">
                            window.location.href="./admin.php?page=pengajuan_proposal&act=del&id='.$id.'";
                          </script>';
            	} 
}

?>
