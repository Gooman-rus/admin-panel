<? 
   include("inc/settings.php");
          
   foreach ($_GET as $key=>$val ) { if (($key!="page") && ($key!="ln"))  header("Location: 404.html");} 
   foreach ($_POST as $key=>$val ) { if ($key!="page") header("Location: 404.html");} 
          
   $page_metakeys="";
   $page_metadesc="";
   $page_metatitle=$con[11][$lng]." - ".$con[6][$lng];    

   include("inc/head.php"); 

   $thismenufolio="class=current";

?>

<body>

    <? include("inc/top.php"); ?>

    <div class="inner_content_position content_column">
        <ul class="breadcrumbs">
            <li class="first"><a href=<?=$mainurl;?>><?echo"{$con[2][$lng]}";?></a></li>
            <li><a><?echo"{$con[6][$lng]}";?></a></li>
        </ul>
        <h1><?echo"{$con[6][$lng]}";?></h1>
                           
                           
<?

$per_page=10;  
if (isset($page)) $curr_page=$page-1;                             

$r=mysql_query("select count(object_code) from {$PREFFIX}_objects where object_active=1");

list($cnt)=mysql_fetch_array($r);
$page_count=ceil($cnt/$per_page); //всего страниц
$start_pos=$curr_page*$per_page;
if ($start_pos+$per_page<$cnt) $end_pos=$start_pos+$per_page;
   else $end_pos=$cnt;

$newsquery="select object_code,object_date,object_name$lng,object_embed$lng,page_code from {$PREFFIX}_objects
            where object_active=1 
            order by object_date DESC limit $start_pos,$per_page";
$newsres=mysql_query($newsquery);
$object_r=mysql_num_rows($newsres);
if($object_r)
{
        echo"<ul class=portfolio>";
        while(list($object_code, $object_date, $object_name, $object_short, $object_page)=mysql_fetch_array($newsres))
          {
            
            $objest_icon=GetFirstpic($object_page);
            if (strlen($objest_icon)>0) $objest_icon_str="<a href='object.php?id=$object_code'><img src='$objest_icon' alt='$object_name' /></a>";
            else $objest_icon_str="<div class=noimage></div>";

            $object_date=ConvertDate($object_date,".");
            
            echo"<li>$objest_icon_str<span class='date'>$object_date</span><br /><a href='object.php?id=$object_code'>$object_name</a><br />$object_short</li>";
            
          }                   
        echo"</ul><br/>";
}          
          
include("inc/pageline.php");


?>                                  

    </div>
    
    <? 
       include("inc/endlinks.php"); 
       include("inc/end.php"); 
    ?> 
    
</body>
</html>
