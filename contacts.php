<? 
   include("inc/settings.php");
                      
   foreach ($_GET as $key=>$val ) { if (($key!="ln"))  header("Location: 404.html");} 
   foreach ($_POST as $key=>$val ) { header("Location: 404.html");} 
   
   $id=3;
   $pageinfo=getStatic($id,$lng);
                         
   $this_text=$pageinfo[text];
   $this_name=$pageinfo[name];                      

   $page_metakeys="";
   $page_metadesc="";
   $page_metatitle=$con[11][$lng]." - ".$this_name;     

   include("inc/head.php"); 

   $thismenucontacts="class=current";

?>


<body>

   <? include("inc/top.php"); ?>

    <div class="inner_content_position content_column">
        
        <ul class="breadcrumbs">
            <li class="first"><a href=<?=$mainurl;?>><?echo"{$con[2][$lng]}";?></a></li>
            <li><a ><?echo"$this_name";?></a></li>
        </ul>       

        <h1><?=$this_name;?></h1>
        
        <a href=http://maps.yandex.ru/?text=%D0%A0%D0%BE%D1%81%D1%81%D0%B8%D1%8F%2C%20%D0%9C%D0%BE%D1%81%D0%BA%D0%B2%D0%B0%2C%20%D0%98%D0%B7%D0%BC%D0%B0%D0%B9%D0%BB%D0%BE%D0%B2%D1%81%D0%BA%D0%B8%D0%B9%20%D0%B1%D1%83%D0%BB%D1%8C%D0%B2%D0%B0%D1%80%2C%2046&sll=37.806021%2C55.796309&ll=37.807051%2C55.795608&spn=0.040340%2C0.014095&z=15&l=map target=_blank><img src="img/img_7.jpg" alt="" class="align_left border_img" width=472 height=314/></a>

        <?=$this_text;?>
   
    </div>
    
    <? 
       include("inc/endlinks.php"); 
       include("inc/end.php"); 
    ?> 
    
</body>
</html>
