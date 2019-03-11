<?php
$t1= $_REQUEST['var1']."";
$t2= $_REQUEST['var2']."";
$file= $_REQUEST['var3']."";
?>

<video src="../videos/<?php echo $file; ?>#t=<?php echo $t1;?>,<?php echo $t2;?>" autoplay controls></video>