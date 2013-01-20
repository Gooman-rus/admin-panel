<? 
   include("inc/settings.php");
   
   foreach ($_GET as $key=>$val ) { if (($key!="id") && ($key!="ln"))   header("Location: 404.html");} 
   foreach ($_POST as $key=>$val ) { if ($key!="id") header("Location: 404.html");} 
   if (!isset($id)) header("Location: 404.html");
   if (!is_numeric($id)) header("Location: 404.html");
                 
   $thisnewsquery="select news_date,news_name$lng,news_short$lng,news_text$lng,page_code 
                  from {$PREFFIX}_news
                  where news_code=$id and news_active=1";
   $thisnewslres=mysql_query($thisnewsquery);
   $thisnews_num=mysql_num_rows($thisnewslres);
   if($thisnews_num==0) header("Location: 404.html");

   list($thisnews_date,$thisnews_name,$thisnews_short,$thisnews_text,$thisnewspage_code)=mysql_fetch_array($thisnewslres);
  
   $page_metakeys="";
   $page_metadesc=$thisnews_short;
   $page_metatitle=$con[11][$lng]." - ".$thisnews_name;    

   include("inc/head.php"); 

   $thismenuabout="class=current";

?>


<body>

   <? include("inc/top.php"); ?>

    <div class="inner_content_position content_column">
        
        <ul class="breadcrumbs">
            <li class="first"><a href=<?=$mainurl;?>><?echo"{$con[2][$lng]}";?></a></li>
            <li><a href="about.php"><?echo"{$con[3][$lng]}";?></a></li>
            <li><a href="allnews.php"><?echo"{$con[8][$lng]}";?></a></li>
            <li><a ><?=$thisnews_name;?></a></li>
        </ul>       
        
        <h1><?=$thisnews_name;?></h1>
        <?=$thisnews_text;?>
   
    </div>
    
    <? 
       include("inc/endlinks.php"); 
       include("inc/end.php"); 
    ?> 
    
</body>
</html>
