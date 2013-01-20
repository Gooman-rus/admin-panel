<? 
   include("inc/settings.php");
   
   $page_metakeys="";
   $page_metadesc="";
   $page_metatitle="Дока-Ремонт";    

   include("inc/head.php"); 
   
   $thismenumain="class=current";

?>

<body>

    
   <? 
       include("inc/top.php");
       include("inc/topservice.php");
   ?> 
    
    
    

    
    <div class="index_content_position">

       
        <?
            $id=4;
            $pageinfo=getStatic($id,$lng);
                         
            $this_text=$pageinfo[text];
            $this_name=$pageinfo[name];
        ?>

        <div class="content_column">
            <h1><?=$this_name;?></h1> 
            <?=$this_text;?>
        </div>
        
        
        
   <? include("inc/topnews.php"); ?> 
        
        

    </div>
    
    <? 
       include("inc/endlinks.php"); 
       include("inc/end.php"); 
    ?> 
    
</body>
</html>
