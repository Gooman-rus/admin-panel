<? 
   include("inc/settings.php");
          
   foreach ($_GET as $key=>$val ) { if (($key!="page") && ($key!="ln")) header("Location: 404.html");} 
   foreach ($_POST as $key=>$val ) { if ($key!="page") header("Location: 404.html");} 
          
   $page_metakeys="";
   $page_metadesc="";
   $page_metatitle=$con[11][$lng]." - ".$con[8][$lng];    

   include("inc/head.php"); 

   $thismenuabout="class=current";

?>

<body>

    <? include("inc/top.php"); ?>

    <div class="inner_content_position content_column">
        <ul class="breadcrumbs">
            <li class="first"><a href=<?=$mainurl;?>><?echo"{$con[2][$lng]}";?></a></li>
            <li><a href="about.php"><?echo"{$con[3][$lng]}";?></a></li>
            <li><a><?echo"{$con[8][$lng]}";?></a></li>
        </ul>
        <h1><?echo"{$con[8][$lng]}";?></h1>
                           
                           
<?

$per_page=10;  
if (isset($page)) $curr_page=$page-1;                             

$r=mysql_query("select count(news_code) from {$PREFFIX}_news where news_active=1");

list($cnt)=mysql_fetch_array($r);
$page_count=ceil($cnt/$per_page); //всего страниц
$start_pos=$curr_page*$per_page;
if ($start_pos+$per_page<$cnt) $end_pos=$start_pos+$per_page;
   else $end_pos=$cnt;

$newsquery="select news_code,news_date,news_name$lng,news_short$lng from {$PREFFIX}_news
            where news_active=1 
            order by news_date DESC limit $start_pos,$per_page";
$newsres=mysql_query($newsquery);
$news_r=mysql_num_rows($newsres);
if($news_r)
{
        echo"<ul class=news>";
        while(list($news_code, $news_date, $news_name, $news_short)=mysql_fetch_array($newsres))
          {
            $news_date=ConvertDate($news_date,".");
            echo"<li><span class=date>$news_date</span><a href='news.php?id=$news_code'>$news_name</a><br />$news_short</li>";
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
