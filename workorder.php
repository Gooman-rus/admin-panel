<? 
   include("inc/settings.php");
                      
   foreach ($_GET as $key=>$val ) { if (($key!="ln"))  header("Location: 404.html");} 
   foreach ($_POST as $key=>$val ) { header("Location: 404.html");} 
   
   $id=2;
   $pageinfo=getStatic($id,$lng);
                         
   $this_text=$pageinfo[text];
   $this_name=$pageinfo[name];                      

   $page_metakeys="";
   $page_metadesc="";
   $page_metatitle=$con[11][$lng]." - ".$this_name;     

   include("inc/head.php"); 

   $thismenuabout="class=current";

?>


<body>

   <? include("inc/top.php"); ?>

    <div class="inner_content_position content_column">
        
        <ul class="breadcrumbs">
            <li class="first"><a href=<?=$mainurl;?>><?echo"{$con[2][$lng]}";?></a></li>
            <li><a href="about.php"><?echo"{$con[3][$lng]}";?></a></li>
            <li><a><?echo"$this_name";?></a></li>
        </ul>       

        <h1><?=$this_name;?></h1>
        <?=$this_text;?>
   
    </div>
    
    <? 
       include("inc/endlinks.php"); 
       include("inc/end.php"); 
    ?> 
    
</body>
</html>
