<? 
   include("inc/settings.php");
          
   foreach ($_GET as $key=>$val ) { if (($key!="page") && ($key!="ln"))  header("Location: 404.html");} 
   foreach ($_POST as $key=>$val ) { if ($key!="page") header("Location: 404.html");} 
          
   $page_metakeys="";
   $page_metadesc="";
   $page_metatitle=$con[11][$lng]." - ".$con[5][$lng];    

   include("inc/head.php"); 

   $thismenuprice="class=current";

?>

<body>

    <? include("inc/top.php"); ?>

    <div class="inner_content_position content_column">
        <ul class="breadcrumbs">
            <li class="first"><a href=<?=$mainurl;?>><?echo"{$con[2][$lng]}";?></a></li>
            <li><a><?echo"{$con[5][$lng]}";?></a></li>
        </ul>
        <h1><?echo"{$con[5][$lng]}";?></h1>
                           
            
                           
                           

<?

$per_page=500;  
if (isset($page)) $curr_page=$page-1;                             

$r=mysql_query("select count(object_code) from {$PREFFIX}_price where object_active=1");

list($cnt)=mysql_fetch_array($r);
$page_count=ceil($cnt/$per_page); //всего страниц
$start_pos=$curr_page*$per_page;
if ($start_pos+$per_page<$cnt) $end_pos=$start_pos+$per_page;
   else $end_pos=$cnt;

   
echo"
        <table>
            <tr align=center>
                <th>№</th>
                <th>Название услуги</th>
                <th>Ед. измерения</th>
                <th>Цена за ед.измерения</th>
            </tr>
        ";      
   
   
$typequery="select type_code,type_name$lng from {$PREFFIX}_pricetype  order by type_pos";
$typeres=mysql_query ($typequery) or die ("Не могу выбрать разделы. Ошибка в запросе.");
while(list($type_code,$type_name)=mysql_fetch_array($typeres))
{
   echo"<tr><td bgcolor=#f0f0f0 colspan=4 align=center><b>$type_name</b></td></tr>";

   $newsquery="select object_code,object_name$lng,object_text$lng,object_unit$lng,object_price$lng 
               from {$PREFFIX}_price where object_active=1 and type_code=$type_code
               order by object_date limit $start_pos,$per_page";
   $newsres=mysql_query($newsquery);
   $object_r=mysql_num_rows($newsres);
   if($object_r)
   {
        $ocount=1;
        while(list($object_code,$object_name,$object_text,$object_unit,$object_price)=mysql_fetch_array($newsres))
          {
            
            if (strlen($object_text)>0) {$obj_link="<a href='priceservice.php?id=$object_code'>"; $obj_elink="</a>";}
            else {$obj_link=""; $obj_elink="";}

            echo"
            <tr align=center>
                <td>$ocount</td>
                <td align=left>$obj_link$object_name$obj_elink</td>
                <td>$object_unit</td>
                <td>$object_price {$con[14][$lng]} </td>
            </tr>
            ";
            
            $ocount++;

          }                   
        
   }       

}
   

echo"</table>";   
          
include("inc/pageline.php");


?>                             

     
     


    </div>
    
    <? 
       include("inc/endlinks.php"); 
       include("inc/end.php"); 
    ?> 
    
</body>
</html>
