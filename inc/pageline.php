<?php
if ($page_count>1)
{
    $st=$_SERVER['REQUEST_URI'];
    $st=preg_replace("/\?.*$/","",$st);

    $q=$_SERVER['QUERY_STRING'];
    $q=preg_replace("/page=\d/","",$q);
    $q=preg_replace("/&&/","&",$q);
    $q=preg_replace("/&$/","",$q);
    $q=preg_replace("/^&/","",$q);
    if(trim($q)) {$mod="?";$mod1="&";}else {$mod="";$mod1="?";}
    $URL=$st.$mod.$q;

echo"{$con[12][$lng]}: ";
for ($i=1;$i<$page_count+1;$i++)
 {
   $y=$i-1;
   if($i!=1) {$lin="{$mod1}page=$i";$t=" &#149; ";}else {$lin="";$t="";}
   if ($curr_page==$y) {echo"<a class=\"selected\">$i</a> ";}
   else {echo"<a href=\"{$URL}{$lin}\">$i</a> ";}
 }
}
?>



