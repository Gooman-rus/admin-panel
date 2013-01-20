<? 
   include("inc/settings.php");
   
   foreach ($_GET as $key=>$val ) { if (($key!="id") && ($key!="ln"))  header("Location: 404.html");} 
   foreach ($_POST as $key=>$val ) { if ($key!="id") header("Location: 404.html");} 
   if (!isset($id)) header("Location: 404.html");
   if (!is_numeric($id)) header("Location: 404.html");
                 
   $thisnewsquery="select object_date,object_name$lng,object_embed$lng,object_text$lng,page_code 
                  from {$PREFFIX}_objects
                  where object_code=$id and object_active=1";
   $thisnewslres=mysql_query($thisnewsquery);
   $thisnews_num=mysql_num_rows($thisnewslres);
   // if($thisnews_num==0) header("Location: 404.html");

   list($thisobject_date,$thisobject_name,$thisobject_short,$thisobject_text,$thisobject_page)=mysql_fetch_array($thisnewslres);
  
   $page_metakeys="";
   $page_metadesc=$thisobject_short;
   $page_metatitle=$con[11][$lng]." - ".$thisobject_name;    
        
   $tod=$thisobject_date;
   $thisobject_date=ConvertDate($thisobject_date,".");

   include("inc/head.php"); 

   $thismenufolio="class=current";

?>     


<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        
        var itemWidth = 123;
        var itemPlaceWidth = 482;
        var _allItemsT = $('.photo_slider .preview ul li').size();
        $('.photo_slider .preview ul').css('width', (_allItemsT*itemWidth)+'px');
        if (_allItemsT > 4) $('.photo_slider .arrow_r').css('display', 'block');    
        
        function getSliderPosition() {
            var _sliderLeft = $('.photo_slider .preview ul').css('left');
            _sliderLeft = _sliderLeft.slice(0, _sliderLeft.search('px'));
            return Number(_sliderLeft);
        }
        
        function dirrentT(arrow) {
            checkButtonNav(arrow);    
            var _sliderLeft = getSliderPosition();
            if (arrow == 'left') {
                var leftP = Number(_sliderLeft)+itemWidth;
                if (leftP>0) leftP = 0;
                $('.photo_slider .preview ul').animate({left: leftP+'px'});    
            } else if (arrow == 'right') {
                var leftP = Number(_sliderLeft)-itemWidth;
                if (leftP*-1+itemPlaceWidth > (_allItemsT*itemWidth)) leftP=((_allItemsT*itemWidth)-itemPlaceWidth-15)*-1;
                $('.photo_slider .preview ul').animate({left: leftP+'px'});    
            }    
        }
        
        $('.photo_slider .arrow_l').click(function(e) {
            dirrentT('left');
            return false;
        });
        
        $('.photo_slider .arrow_r').click(function(e) {
            dirrentT('right');
            return false;
        });
        
              
        $('.photo_slider .preview ul li a').click(function(e) {
            $('.photo_slider .preview ul li').removeClass('current');
            $(this).parent().addClass('current');
            $('.photo_slider .big_img img').attr('src', $(this).find('img').attr('src'));
            $('.photo_slider .title p').html($(this).find('img').attr('title'));
            return false;
        });              
           
        $('.photo_slider .preview ul li a').click(function(e) {
            $('.photo_slider .preview ul li').removeClass('current');
            $(this).parent().addClass('current');
            $('.photo_slider .title p').html($(this).find('img').attr('title'));
        }); 
        
        function checkButtonNav(arrow) {
            var _sliderLeft = getSliderPosition();
            if (arrow == 'left') {
                $('.photo_slider .arrow_l').css('display', (_sliderLeft+itemWidth >= 0) ? 'none' : 'block');
                $('.photo_slider .arrow_r').css('display', 'block');
            } else if (arrow == 'right') {
                $('.photo_slider .arrow_l').css('display', 'block');
                $('.photo_slider .arrow_r').css('display', ((Number(_sliderLeft)-itemWidth*2)*-1+itemPlaceWidth > (_allItemsT*itemWidth)) ? 'none' : 'block');
            }            
        };
        
    });
</script>




<body>

   <? include("inc/top.php"); ?>

    <div class="inner_content_position content_column">
        
        <ul class="breadcrumbs">
            <li class="first"><a href=<?=$mainurl;?>><?echo"{$con[2][$lng]}";?></a></li>
            <li><a href="portfolio.php"><?echo"{$con[6][$lng]}";?></a></li>
            <li><a ><?=$thisobject_name;?></a></li>
        </ul>       
        
        <h1><?=$thisobject_name;?></h1>       
        
        
        <p><span class="date"><?echo"$thisobject_date";?></span></p>   

        
              
              
        <?
        
           
  $picquery="select picsmall,picbig,piccomment from {$PREFFIX}_picture where page_code=$thisobject_page order by picpos";
  $picres=mysql_query ($picquery) or die ("Не могу выбрать изображения. Ошибка в запросе.");
  $num_rows=mysql_num_rows($picres); 
  if($num_rows)
  {
      echo"<div class=photo_slider>";   
      $piccount=1;
      while(list($picsmall,$picbig,$piccomment)=mysql_fetch_array($picres))
      {
        
        if (strlen($piccomment)==0) $piccomment=$thisobject_name;

        if ($piccount==1)
        {
          echo"
            <div class=big_imgarea id=big_imgarea><center><a href='images/$picbig' rel='lightbox[obj]' title='$piccomment'><img src='images/$picbig' alt='$piccomment' /></center></div>
            <div class=controll>
                <div class=arrow_l><a href='#'><img src='img/photo_l.jpg'  /></a></div>
                <div class=title><p>$piccomment</p></div>
                <div class=arrow_r><a href='#'><img src='img/photo_r.jpg'  /></a></div>
            </div>  
            
            <div class=preview>
                <ul>
                    <li ><a onclick='showlb(\"$picbig\",\"$piccomment\")'><img src='images/$picbig' title='$piccomment' /></a></li>


          ";
        }       
        
        
        else
        {
           echo"
              <li><a onclick='showlb(\"$picbig\",\"$piccomment\")'><img src='images/$picbig' title='$piccomment' /></a><div style='display:none;'><a href='images/$picbig' rel='lightbox[obj]' title='$piccomment'><img src='images/$picbig' alt='$piccomment' /></a></div></li>
           "; 
        }
       

        
        
        $piccount++;
        

      }    
      echo"
                </ul>
            </div>
        ";
      echo"</div>";

   } 
           

        
        ?>      
              
        

        <?=$thisobject_text;?>        
        
        <ul class="page_nav">
            
        <?
           
            $nextquery="select object_code from {$PREFFIX}_objects where object_active=1 and object_date>'$tod'  order by object_date limit 1";
            $nextres=mysql_query($nextquery);
            $next_num=mysql_num_rows($nextres);
            if($next_num>0) 
            {
                list($next_code)=mysql_fetch_array($nextres);
                $nextlink="<a href='object.php?id=$next_code'>";
            }  
            else $nextlink="<a>";

            
            $prevquery="select object_code from {$PREFFIX}_objects where object_active=1 and object_date<'$tod' order by object_date DESC limit 1 ";
            $prevres=mysql_query($prevquery);
            $prev_num=mysql_num_rows($prevres);
            if($prev_num>0) 
            {
                list($prev_code)=mysql_fetch_array($prevres);
                $prevlink="<a href='object.php?id=$prev_code'>";
            }            
            else $prevlink="<a>";
        
        ?>    

            <li><?=$nextlink;?>&larr; Предыдущая работа</a></li>
            <li class="last"><?=$prevlink;?>Следующая работа &rarr;</a></li>
            

        </ul>        

   
    </div>
    
    <? 
       include("inc/endlinks.php"); 
       include("inc/end.php"); 
    ?> 
       
<script src="js/lightbox.js"></script>  
<script language="JavaScript"><!--
  
function  showlb(picurl,piccoment){  
  response="<center><a href='images/"+picurl+"' rel='lightbox[obj]' title='"+piccoment+"'><img src='images/"+picurl+"' alt='"+piccoment+"' /></center>";      
  document.getElementById("big_imgarea").innerHTML  =  response;  
}   

--></script>
     

</body>
</html>
