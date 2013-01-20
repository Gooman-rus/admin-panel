<? 
   include("inc/settings.php");
          
   foreach ($_GET as $key=>$val ) { if (($key!="page") && ($key!="ln"))  header("Location: 404.html");} 
   foreach ($_POST as $key=>$val ) { if ($key!="page") header("Location: 404.html");} 
          
   $page_metakeys="";
   $page_metadesc="";
   $page_metatitle=$con[11][$lng]." - ".$con[13][$lng];    

   include("inc/head.php"); 

   $thismenuabout="class=current";

?>

<body>

    <? include("inc/top.php"); ?>

    <div class="inner_content_position content_column">
        <ul class="breadcrumbs">
            <li class="first"><a href=<?=$mainurl;?>><?echo"{$con[2][$lng]}";?></a></li>
            <li><a href="about.php"><?echo"{$con[3][$lng]}";?></a></li>
            <li><a><?echo"{$con[13][$lng]}";?></a></li>
        </ul>
        <h1><?echo"{$con[13][$lng]}";?></h1>
                           
                           
<?

$per_page=10;  
if (isset($page)) $curr_page=$page-1;                             

$r=mysql_query("select count(picture_code) from {$PREFFIX}_banners where pic_active=1");

list($cnt)=mysql_fetch_array($r);
$page_count=ceil($cnt/$per_page); //всего страниц
$start_pos=$curr_page*$per_page;
if ($start_pos+$per_page<$cnt) $end_pos=$start_pos+$per_page;
   else $end_pos=$cnt;

$newsquery="select picsmall,picbig,pic_flashcode$lng,pic_link from {$PREFFIX}_banners
            where pic_active=1 
            order by picpos limit $start_pos,$per_page";
$newsres=mysql_query($newsquery);
$news_r=mysql_num_rows($newsres);
if($news_r)
{
        echo"<ul class=portfolio>";
        while(list($banner_name, $banner_pic, $banner_desc, $banner_link)=mysql_fetch_array($newsres))
          {
            if (strlen($banner_link)>0) $thislink="<a target=_blank href='$banner_link'>"; else  $thislink="<a>";
            echo"<li>$thislink<img src='banners/$banner_pic' alt='$banner_name' /></a>$thislink$banner_name</a><br />$banner_desc</li>";
          
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
