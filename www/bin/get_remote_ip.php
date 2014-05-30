<?php
 $URIfile='/var/www/sys/updateURI';
 $URI=file_exists($URIfile)?file_get_contents($URIfile):'http://blog.sabaitechnology.com/sabai';
 $lastip=file_get_contents($URI ."/donde.php?plz=kthx");
 file_put_contents("/var/www/stat/ip",$lastip);
 echo $lastip;
?>
