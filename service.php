<? 
   include("inc/settings.php");
   
   foreach ($_GET as $key=>$val ) { if (($key!="id") && ($key!="ln"))  header("Location: 404.html");} 
   foreach ($_POST as $key=>$val ) { if ($key!="id") header("Location: 404.html");} 
   if (!isset($id)) header("Location: 404.html");
   if (!is_numeric($id)) header("Location: 404.html");
                 
   $thisnewsquery="select object_name$lng,object_embed$lng,object_text$lng 
                  from {$PREFFIX}_service
                  where object_code=$id and object_active=1";
   $thisnewslres=mysql_query($thisnewsquery);
   $thisnews_num=mysql_num_rows($thisnewslres);
   if($thisnews_num==0) header("Location: 404.html");

   list($thisservice_name,$thisservice_short,$thisservice_text)=mysql_fetch_array($thisnewslres);
  
   $page_metakeys="";
   $page_metadesc=$thisservice_short;
   $page_metatitle=$con[11][$lng]." - ".$thisservice_name;    

   include("inc/head.php"); 

   $thismenuservice="class=current";

?>


<body>

   <? include("inc/top.php"); ?>

    <div class="inner_content_position content_column">
        
        <ul class="breadcrumbs">
            <li class="first"><a href=<?=$mainurl;?>><?echo"{$con[2][$lng]}";?></a></li>
            <li><a href="services.php"><?echo"{$con[4][$lng]}";?></a></li>
            <li><a ><?=$thisservice_name;?></a></li>
        </ul>       
        
        <h1><?=$thisservice_name;?></h1>
        <?=$thisservice_text;?>
   
    </div>
    
    <? 
       include("inc/endlinks.php"); 
       include("inc/end.php"); 
    ?> 
    
</body>
</html>
