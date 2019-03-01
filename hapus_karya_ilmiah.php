<?php
   
    $id_karya=$_REQUEST['id_karya']; 
    	$row = mysqli_fetch_array(mysqli_query($config, "SELECT * FROM karya_ilmiah_dosen WHERE id_karya='".$_REQUEST['id_karya']."'"));
 
                		$query = mysqli_query($config, "DELETE FROM karya_ilmiah_dosen WHERE id_karya='$id_karya'");

                		if($query == true){
                            $_SESSION['succDel'] = 'SUKSES! Data berhasil dihapus ';
                             echo '<script language="javascript">
                                    window.location.href="./admin.php?page=dosen&act=karya_ilmiah&id_dosen='.$row['id_dosen'].'";
                                  </script>'; 
                		} else {
                            $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                           echo '<script language="javascript">
                                    window.location.href="./admin.php?page=dosen&act=karya_ilmiah&id_dosen='.$row['id_dosen'].'&sub=del&id_karya='.$row['id_karya'].'";
                                  </script>'; 
                		}
?>
