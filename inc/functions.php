<?php
function  DevideFile($filename,&$name,&$ext)
{
  $p=strrpos($filename,".");
  $name=substr($filename,0,$p);
  $ext=substr($filename,$p+1,strlen($filename)-$p);
}

function ConvertDate($dateval,$delim="-",$is_full=false)
{
  if (!$is_full) $a=10;else $a=16;
  if (strlen($dateval)>$a) $dateval=substr($dateval,0,$a);
  $chunks=explode("-",$dateval);
  $tim=explode(" ",$chunks[2]);
  $res=$tim[0].$delim.$chunks[1].$delim.$chunks[0];
  if ($is_full) $res.=" ".$tim[1];
  return $res;
}


function Show($val)
{
  if (trim($val)=="") return "&nbsp"; else return $val;
}
                      
                      
//замена абзацев на дивы
function rewritep($st)
{
  $st=str_replace("<p","<br/><span",$st);
  $st=str_replace("</p>","</span>",$st);
  if (strpos($st,"br/>")==1) $st=substr($st,5);
  return $st;
}                      

//предвыводная обработка псевдостатики
function prepare($st)
{
  global $path;
  $st=str_replace("../im","im",$st);
  $st=str_replace("../files","files",$st);
  return $st;
}

function getStatic($code,$lng="")
{
    global $PREFFIX;
    $res=mysql_query("select static_code,static_name$lng,static_text$lng,spage_code from {$PREFFIX}_static where static_code=$code");
    list($s_c,$s_n,$s_t,$s_p)=mysql_fetch_array($res);
    $s_t=str_replace("../im","im",$s_t);
    $a=array("code"=>$s_c,
             "name"=>$s_n,        
             "pic"=>$s_p,
             "text"=>prepare($s_t)
             );
    return $a;
}



function mime_type($fname)
{
  DevideFile($fname,$name,$ext);
  $f=fopen("inc/types.mime","r");
  while($st=fgets($f))
  {
    $s=substr($st,0,strlen($st)-2);
      $a=explode(" ",$s);
      if (in_array($ext,$a)) {fclose($f);return $a[0];}
  }
  fclose($f);
  return "application/octet-stream";
}

function fullBack($url="/")
{
    header("Location: $url");
    die();
}

//отправляет письмо с указанным текстом и темой на указанный адрес
//отправляет письмо с указанным текстом и темой на указанный адрес
function mailSend($email,$subj,$text,$from="",$replyto="",$bcc="")
{
global $adminemail,$adminname;
if(!$from) $from="$adminname <$adminemail>";
if(!$replyto) $replyto=$adminemail;
    $boundary = strtoupper(md5(uniqid(time())));
    $headers = "From: $from\nReply-To: $replyto\r\n";
if($bcc) $headers.="Bcc: $bcc\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=$boundary\r\n";

    $data= "This is a multi-part message in MIME format.\r\n\r\n";
    $data .= "--$boundary\n";
    $data .= "Content-Type: text/html; charset=windows-1251\n";
    $data .= "Content-Transfer-Encoding:base64\r\n\r\n";

    $ttext="<html><body>".stripslashes($text)."</body></html>";
    $ttext = chunk_split(base64_encode($ttext));

    $data .= "$ttext\r\n\r\n";
    mail($email,$subj,$data,$headers);
}

function GetCurrent($thisID,&$arr)
{
  global $PREFFIX;
  if($thisID==0) return;
  list($category_code,$category_name,$parent_id)=mysql_fetch_array(mysql_query("select category_code,category_name,category_parent from {$PREFFIX}_category where category_code=$thisID"));
  $arr[]=Array("code"=>$category_code,"name"=>$category_name,"parent"=>$parent_id);
  if($parent_id==0) return;
  GetCurrent($parent_id,$arr);
}

function GetDescendants($thisID,&$arr)
{
  global $PREFFIX;
              if(!$thisID) return;
            $query="select category_code,category_name,category_parent from {$PREFFIX}_category where category_parent=$thisID order by category_pos" or die("!!!");
            $res=mysql_query($query);
            $n_r=mysql_num_rows($res);
            if (!$n_r) return;
            while (list($category_c,$category_n,$category_p)=mysql_fetch_array($res))
            {
                $arr[]=Array("code"=>$category_c,"name"=>$category_n,"parent"=>$category_p);
              GetDescendants($category_c,$arr);
            }

return 0;
}

function GetCart($siterate,$sitediscount)
 {
   global $MULTIPOLUSER,$PREFFIX,$LIMIT_SUM;
   if (is_array($_SESSION['cart']))
   {
//     if ($TOYUSER["totalsum"]>=$LIMIT_SUM) $f="unit_regprice";else $f="unit_price";
//     if ($MULTIPOLUSER["code"]) $f="unit_regprice";else $f="unit_price";
     $codes="0";
     foreach ($_SESSION['cart'] as $key=>$val) $codes.=",".$key;
     $r=mysql_query("select unit_code,unit_price from {$PREFFIX}_shopunit where unit_code in ($codes)") or die()  ;
     while(list($unit_code,$price)=mysql_fetch_array($r))
         { $price=getcost($price,$siterate,$sitediscount); $cnt+=$_SESSION['cart'][$unit_code]; $tot+=$_SESSION['cart'][$unit_code]*$price;  }
     return "В Вашей корзине: <b>".intval($cnt)." товаров</b><br>На сумму: <b>".sprintf("%01.2f",floatval($tot))." грн</b>.";
   }
   else return "В Вашей корзине: <b>0 товаров</b><br>На сумму: <b>0.00 грн</b>.";
 }
    
    
    

function addhighslide($instr)
{
  $rez_text=$instr;
  $pic_text=$instr;
  while ($pic_text)
  {
     $pic_text=strstr($pic_text, "<img");
     if ($pic_text)
     {
        $picnamestr=strstr($pic_text, "static");
        $picnamestr=strtok($picnamestr, '"');
        $picnamestr=str_replace("small","",$picnamestr);

        $piccomment=strstr($pic_text, "alt");
        $piccomment=substr($piccomment,5);
        $piccomment=strtok($piccomment, '"');

        $picurl=strtok($pic_text, ">").">";
//        $pic_link="<table><tr><td><a href='images/".$picnamestr."' class='highslide'  onclick='return hs.expand(this)'>".$picurl."</a><div class='highslide-caption'>".$piccomment."</div></td></tr></table>";
        $pic_link="<table><tr><td><a href='images/".$picnamestr."' target=_blank class='highslide'  onclick='return hs.expand(this)'>".$picurl."</a></td></tr></table>";

        $rez_text=str_replace($picurl,$pic_link,$rez_text);
        $pic_text=substr($pic_text,4);
     }
  }
  return($rez_text);
}
  
         
function GetFirstpic($pcode)
{
  global $PREFFIX;

            $picquery="select picsmall from {$PREFFIX}_picture where page_code=$pcode order by picpos limit 1";
            $picres=mysql_query ($picquery) or die ("Не могу выбрать изображения. Ошибка в запросе. ");
            $num_pics=mysql_num_rows($picres);
            $picsmall="";
            if ($num_pics) 
            {
              list($picsmall)=mysql_fetch_array($picres);
              $picsmall="images/".$picsmall;
            }
  return($picsmall);
}     


function GetFirstSpic($pcode)
{
  global $PREFFIX;

            $picquery="select spicsmall from {$PREFFIX}_spicture where spage_code=$pcode order by spicpos limit 1";
            $picres=mysql_query ($picquery) or die ("Не могу выбрать изображения. Ошибка в запросе. ");
            $num_pics=mysql_num_rows($picres);
            $picsmall="";
            if ($num_pics) 
            {
              list($picsmall)=mysql_fetch_array($picres);
              $picsmall="images/".$picsmall;
            }
  return($picsmall);
}
  
  
function printpageline($pq,$this,$id='')              
{
  if ($pq>1)
  {
    echo"<div class=pageline>Страницы: "; 
    for ($i=1;$i<$pq+1;$i++)
     {
       $y=$i-1;
       if ($this==$y) {$t1="<b>";$t2="</b>";} else {$t1="";$t2="";}
       if ($i!=1) echo" / ";
       if (strlen($id)>0) echo"$t1 <a href='$PHP_SELF?id=$id&page=$y'>$i</a> $t2 ";
       else echo"$t1 <a href='$PHP_SELF?page=$y'>$i</a> $t2 ";
     }
    echo"</div>";                                                                    
  }
}     
  
  
function getcost($p,$siterate,$sitediscount)              
{                  
  
  $thisprice=$p*$siterate; 
  $thisdiscount=$p*$sitediscount/100;
  $cost=$thisprice-$thisdiscount;
  $cost=round($cost,2);
  return($cost);
}  

              
function GetFirstpicstr($pcode)
{
  global $PREFFIX;

            $picquery="select picsmall,picbig,piccomment from {$PREFFIX}_picture where page_code=$pcode order by picpos limit 1";
            $picres=mysql_query ($picquery) or die ("Не могу выбрать изображения. Ошибка в запросе. ");
            $num_pics=mysql_num_rows($picres);
            $picsmall_str="";
            if ($num_pics) 
            {
              list($picsmall,$picbig,$piccoment)=mysql_fetch_array($picres);
              $picsmall_str="<a href='images/$picbig' traget=_blank class='highslide' onclick='return hs.expand(this)'><img src='images/$picsmall' border=0 alt='$piccoment'></a><div class='highslide-caption'>$piccomment</div>";
            }
  return($picsmall_str);
}               

  
        
function GetPicGallery($pcode)
{
  global $PREFFIX;                                     
      
  $gallery="";
  $picquery="select picsmall,picbig,piccomment from {$PREFFIX}_picture where page_code=$pcode order by picpos limit 1,1000";
  $picres=mysql_query ($picquery) or die ("Не могу выбрать изображения. Ошибка в запросе.");
  $num_rows=mysql_num_rows($picres);
  if($num_rows)
  {
      $gallery="<div class=pagetextarea><center>";
      while(list($picsmall,$picbig,$piccomment)=mysql_fetch_array($picres))
      {
        if (strlen($piccomment)==0) $piccomment=$thisobj_name;
        $gallery=$gallery."
                <div class=galleryitem>
                  <a class='highslide' onclick='return hs.expand(this)' href='images/$picbig' target=_blank><img src='images/$picsmall' border=0>
                     <div class=view>[+]</div>     
                  </a><div class='highslide-caption'>$piccomment</div>      
                </div>
        ";
      }
      $gallery=$gallery."</center></div>";

  } 
  
  return($gallery);
}     



        
function GetUnitGallery($pcode)
{
  global $PREFFIX;                                     
      
  $gallery="";
  $picquery="select picsmall,picbig,piccomment from {$PREFFIX}_picture where page_code=$pcode order by picpos limit 1,1000";
  $picres=mysql_query ($picquery) or die ("Не могу выбрать изображения. Ошибка в запросе.");
  $num_rows=mysql_num_rows($picres);
  if($num_rows)
  {
      $gallery="<div class=pagetextarea><center>";
      while(list($picsmall,$picbig,$piccomment)=mysql_fetch_array($picres))
      {
        if (strlen($piccomment)==0) $piccomment=$thisobj_name;
        $gallery=$gallery."
                <div class=unitgalleryitem>
                  <a class='highslide' onclick='return hs.expand(this)' href='images/$picbig' target=_blank><img src='images/$picsmall' border=0>
                     <div class=view>увеличить >></div>     
                  </a><div class='highslide-caption'>$piccomment</div>      
                </div>
        ";
      }
      $gallery=$gallery."</center></div>";

  } 
  
  return($gallery);
}


function getMenuParent($code)
{
    global $PREFFIX;
   
    $pres=mysql_query("select category_parent from {$PREFFIX}_shopcategory where category_code=$code");
    list($c_p)=mysql_fetch_array($pres);     
    
    if ($c_p==0) return $code;
    else getMenuParent($c_p); return $c_p;
}


function getShopParentList($code,$rezstr="")
{
    global $PREFFIX;
    
    $pres=mysql_query("select category_parent,category_name from {$PREFFIX}_shopcategory where category_code=$code");
    list($c_p,$c_n)=mysql_fetch_array($pres);
    if(strlen($c_n)>0) $rezstr=" » <a href='shop.php?id=$code'>$c_n</a>".$rezstr;

    if ($c_p!=0) $rezstr=getShopParentList($c_p,$rezstr);
    else $rezstr="<a href='$mainurl'>Строительные материалы и оборудование</a> ".$rezstr;

    return $rezstr;
}
  
  
function getpicunitlist($category_code,$resultlist,$brand)
{                                                                       
    global $PREFFIX, $siterate, $sitediscount;
    
    if ($brand!=0) $tail=" and {$PREFFIX}_shopunit.brand_code=$brand ";
    else $tail="";

    $topunutquery="select unit_code,unit_name,unit_price,page_code,{$PREFFIX}_brands.brand_name,{$PREFFIX}_brands.brand_code 
                   from {$PREFFIX}_shopunit 
                     left join {$PREFFIX}_brands on ({$PREFFIX}_brands.brand_code={$PREFFIX}_shopunit.brand_code) 
                   where unit_active=1 and category_code=$category_code $tail
                   order by unit_pos";
    $topunutres=mysql_query ($topunutquery) or die ("Не могу выбрать топ-предметы. Ошибка в запросе.");
    $num_topunuts=mysql_num_rows($topunutres);
    while(list($unit_code,$unit_name,$unit_price,$page_code,$brand_name,$brand_code)=mysql_fetch_array($topunutres))
    {
       $unit_link="unit.php?id=$unit_code";  
       $unit_cost=getcost($unit_price,$siterate,$sitediscount);  
       $unit_cost=sprintf("%01.2f", $unit_cost);
       
       $unit_pic=GetFirstPic($page_code);
       if (strlen($unit_pic)==0) $unit_pic="graph/nopic.gif";

       $resultlist=$resultlist."   

       <div class=unitblock>
          <div class=unitpic style='background: url($unit_pic) center center no-repeat;'><a href='$unit_link'><img src='graph/unit.gif' border=0 alt='Кирпич строительный (0,25*0,12*0,06) Балаклава'></a></div>
          <a href='$unit_link'><h2>$unit_name</h2></a>
          <span>$unit_cost грн.</span>
          <div class=unitaction>
          <a class=pointer onclick=\"ShowAdd('addunit.php?code=$unit_code')\"><img src='graph/order.gif' width=70 height=23 alt='добавить в корзину' border=0></a> 
          <a href='$unit_link'><img src='graph/info.gif' width=98 height=23 alt='подробная информация' border=0></a>
          </div>
       </div>
          
          

       ";
    }
    

   $catquery="select category_code from {$PREFFIX}_shopcategory where category_active=1 and category_parent=$category_code order by category_pos";
   $categoryres=mysql_query ($catquery) or die ("Не могу выбрать потомков. Ошибка в запросе.");
   while(list($c_code)=mysql_fetch_array($categoryres))
   {
     $resultlist=getpicunitlist($c_code,$resultlist,$brand);
   }                                          
   
   return $resultlist;
}   
   
                  
                     
function getmainunitlist()
{                                                                       
    global $PREFFIX, $siterate, $sitediscount;
    
    $topunutquery="select unit_code,unit_name,unit_price,page_code
                   from {$PREFFIX}_shopunit 
                   where unit_active=1 and unit_onmain=1
                   order by rand() limit 6";
    $topunutres=mysql_query ($topunutquery) or die ("Не могу выбрать топ-предметы. Ошибка в запросе.");
    $num_topunuts=mysql_num_rows($topunutres);
    while(list($unit_code,$unit_name,$unit_price,$page_code)=mysql_fetch_array($topunutres))
    {
       $unit_link="unit.php?id=$unit_code";  
       $unit_cost=getcost($unit_price,$siterate,$sitediscount);  
       $unit_cost=sprintf("%01.2f", $unit_cost);
       
       $unit_pic=GetFirstPic($page_code);
       if (strlen($unit_pic)==0) $unit_pic="graph/nopic.gif";

       $resultlist=$resultlist."   

       <div class=unitblock>
          <div class=unitpic style='background: url($unit_pic) center center no-repeat;'><a href='$unit_link'><img src='graph/unit.gif' border=0 alt='Кирпич строительный (0,25*0,12*0,06) Балаклава'></a></div>
          <a href='$unit_link'><h2>$unit_name</h2></a>
          <span>$unit_cost грн.</span>
          <div class=unitaction>
          <a class=pointer onclick=\"ShowAdd('addunit.php?code=$unit_code')\"><img src='graph/order.gif' widthp height# alt='добавить в корзину' border=0></a> 
          <a href='$unit_link'><img src='graph/info.gif' alt='подробная информация' border=0></a>
          </div>
       </div>
          
          

       ";
    }
    
   return $resultlist;
}   
                     
  
                     
function toplinkunittable($w)
{                                                                       
    global $PREFFIX, $siterate, $sitediscount;
    
    $topunutquery="select unit_code,unit_name,unit_articul,unit_availability,unit_price,unit_text,page_code,{$PREFFIX}_brands.brand_name,{$PREFFIX}_brands.brand_code,{$PREFFIX}_shopcategory.category_name,{$PREFFIX}_shopcategory.category_code 
                   from {$PREFFIX}_shopunit 
                     left join {$PREFFIX}_shopcategory  on ({$PREFFIX}_shopcategory.category_code={$PREFFIX}_shopunit.category_code) 
                     left join {$PREFFIX}_brands on ({$PREFFIX}_brands.brand_code={$PREFFIX}_shopunit.brand_code) 
                   where unit_active=1 and unit_toplink=$w 
                   order by {$PREFFIX}_shopcategory.category_name,unit_pos";
    $topunutres=mysql_query ($topunutquery) or die ("Не могу выбрать предметы. Ошибка в запросе");
    $num_topunuts=mysql_num_rows($topunutres);    
    
    
    // if ($num_topunuts>0) echo"<div style='padding:10px;'><h5>По запросу <a>$wor</a> найдено $num_topunuts товаров</h5></div>";
    // else echo"<div style='padding:10px;'><h6>По запросу <a>$wor</a> товаров не найдено<br>Попробуйте уточнить запрос</h6></div>";

    
    if($num_topunuts>0)
    {

       $count=0;                                 
       $oldcat_code=0; 
       while(list($unit_code,$unit_name,$unit_articul,$unit_availability,$unit_price,$unit_text,$page_code,$brand_name,$brand_code,$cat_name,$cat_code)=mysql_fetch_array($topunutres))
       {
     
          if ($oldcat_code!=$cat_code) 
          {
               if ($oldcat_code!=0) $resultlist=$resultlist."</table>";
               $resultlist=$resultlist."
                    <!-- <h2>$cat_name</h2> -->
                    <table Border=0 CellSpacing=1 CellPadding=0 Width=98% bgcolor=#dddddd>
          
                    <tr bgcolor=#e9e9e9 alignОnter height4>
                       <td>Наименование</td>            
                       <td>Единица<br>изменения</td>            
                       <td>Цена<br>(грн.)</td>            
                       <td>На складе</td>            
                       <td>Купить</td>            
                   </tr>
              ";   
              $oldcat_code=$cat_code;
           }

       
         $unit_link="unit.php?id=$unit_code";  
         $unit_cost=getcost($unit_price,$siterate,$sitediscount);
         $unit_cost_str = sprintf("%01.2f", $unit_cost);
    
         if ($count==0) {$bg="#ffffff"; $count=1;}
         else {$bg="#f9f9f9"; $count=0;}
                                                                     
         if ($unit_availability==1) $unit_availability_str="есть";
         else $unit_availability_str="нет";
                              
         if (strlen($unit_text)>0) $ulink="<a href='$unit_link'>";
         else $ulink="";                
       
         $resultlist=$resultlist."   
          <tr bgcolor=$bg alignОnter onmouseover=\"this.style.background='#ebfaea'\" onmouseout=\"this.style.background='$bg'\">
           
             <td class=nametd>$ulink$unit_name</a></td>
             <td>$unit_articul </td>
             <td>$unit_cost_str</td>
             <td>$unit_availability_str</td>
             <td><a class=pointer onclick=\"ShowAdd('addunit.php?code=$unit_code')\"><img src='graph/ordersmall.gif' border=0 alt='купить'></a></td>

          </tr>
         ";
       }
     $resultlist=$resultlist."</table>";  

    }
   return $resultlist;
}   
                     
                     

                     

                     
function searchunittable($wor)
{                                                                       
    global $PREFFIX, $siterate, $sitediscount;
    
    $topunutquery="select unit_code,unit_name,unit_articul,unit_availability,unit_price,unit_text,page_code,{$PREFFIX}_brands.brand_name,{$PREFFIX}_brands.brand_code,{$PREFFIX}_shopcategory.category_name,{$PREFFIX}_shopcategory.category_code 
                   from {$PREFFIX}_shopunit 
                     left join {$PREFFIX}_shopcategory  on ({$PREFFIX}_shopcategory.category_code={$PREFFIX}_shopunit.category_code) 
                     left join {$PREFFIX}_brands on ({$PREFFIX}_brands.brand_code={$PREFFIX}_shopunit.brand_code) 
                   where unit_active=1 and ( (lower(unit_name) like \"%$wor%\") or (lower(unit_text) like \"%$wor%\") or (lower({$PREFFIX}_shopcategory.category_name) like \"%$wor%\")) 
                   order by {$PREFFIX}_shopcategory.category_name,unit_pos";
    $topunutres=mysql_query ($topunutquery) or die ("Не могу выбрать предметы. Ошибка в запросе");
    $num_topunuts=mysql_num_rows($topunutres);    
    
    
    if ($num_topunuts>0) echo"<div style='padding:10px;'><h5>По запросу <a>$wor</a> найдено $num_topunuts товаров</h5></div>";
    else echo"<div style='padding:10px;'><h6>По запросу <a>$wor</a> товаров не найдено<br>Попробуйте уточнить запрос</h6></div>";

    
    if($num_topunuts>0)
    {

       $count=0;                                 
       $oldcat_code=0; 
       while(list($unit_code,$unit_name,$unit_articul,$unit_availability,$unit_price,$unit_text,$page_code,$brand_name,$brand_code,$cat_name,$cat_code)=mysql_fetch_array($topunutres))
       {
     
          if ($oldcat_code!=$cat_code) 
          {
               if ($oldcat_code!=0) $resultlist=$resultlist."</table>";
               $resultlist=$resultlist."
                    <h2>$cat_name</h2>
                    <table Border=0 CellSpacing=1 CellPadding=0 Width=98% bgcolor=#dddddd>
          
                    <tr bgcolor=#e9e9e9 align=center height=34>
                       <td>Наименование</td>            
                       <td>Единица<br>изменения</td>            
                       <td>Цена<br>(грн.)</td>            
                       <td>На складе</td>            
                       <td>Купить</td>            
                   </tr>
              ";   
              $oldcat_code=$cat_code;
           }

       
         $unit_link="unit.php?id=$unit_code";  
         $unit_cost=getcost($unit_price,$siterate,$sitediscount);
         $unit_cost_str = sprintf("%01.2f", $unit_cost);
    
         if ($count==0) {$bg="#ffffff"; $count=1;}
         else {$bg="#f9f9f9"; $count=0;}
                                                                     
         if ($unit_availability==1) $unit_availability_str="есть";
         else $unit_availability_str="нет";
                              
         if (strlen($unit_text)>0) $ulink="<a href='$unit_link'>";
         else $ulink="";                
       
         $resultlist=$resultlist."   
          <tr bgcolor=$bg align=center onmouseover=\"this.style.background='#ebfaea'\" onmouseout=\"this.style.background='$bg'\">
           
             <td class=nametd>$ulink$unit_name</a></td>
             <td>$unit_articul </td>
             <td>$unit_cost_str</td>
             <td>$unit_availability_str</td>
             <td><a class=pointer onclick=\"ShowAdd('addunit.php?code=$unit_code')\"><img src='graph/ordersmall.gif' border=0 alt='купить'></a></td>

          </tr>
         ";
       }
     $resultlist=$resultlist."</table>";  

    }
   return $resultlist;
}   
                     
                     

   
   
function getunittable($category_code,$resultlist,$brand)
{                                                                       
    global $PREFFIX, $siterate, $sitediscount;
    
    if ($brand!=0) $tail=" and {$PREFFIX}_shopunit.brand_code=$brand ";
    else $tail="";

    $topunutquery="select unit_code,unit_name,unit_articul,unit_availability,unit_price,unit_text,page_code,{$PREFFIX}_brands.brand_name,{$PREFFIX}_brands.brand_code 
                   from {$PREFFIX}_shopunit 
                     left join {$PREFFIX}_brands on ({$PREFFIX}_brands.brand_code={$PREFFIX}_shopunit.brand_code) 
                   where unit_active=1 and category_code=$category_code $tail
                   order by unit_pos";
    $topunutres=mysql_query ($topunutquery) or die ("Не могу выбрать топ-предметы. Ошибка в запросе.");
    $num_topunuts=mysql_num_rows($topunutres);
    $count=0;
    while(list($unit_code,$unit_name,$unit_articul,$unit_availability,$unit_price,$unit_text,$page_code,$brand_name,$brand_code)=mysql_fetch_array($topunutres))
    {
       $unit_link="unit.php?id=$unit_code";  
       $unit_cost=getcost($unit_price,$siterate,$sitediscount);
       $unit_cost_str = sprintf("%01.2f", $unit_cost);
    
       if ($count==0) {$bg="#ffffff"; $count=1;}
       else {$bg="#f9f9f9"; $count=0;}
                                                                     
       if ($unit_availability==1) $unit_availability_str="есть";
       else $unit_availability_str="нет";
                              
       if (strlen($unit_text)>0) $ulink="<a href='$unit_link'>";
       else $ulink="";                

       $resultlist=$resultlist."   
          <tr bgcolor=$bg align=center onmouseover=\"this.style.background='#ebfaea'\" onmouseout=\"this.style.background='$bg'\">
           
             <td class=nametd>$ulink$unit_name</a></td>
             <td>$unit_articul </td>
             <td>$unit_cost_str</td>
             <td>$unit_availability_str</td>
             <td><a class=pointer onclick=\"ShowAdd('addunit.php?code=$unit_code')\"><img src='graph/ordersmall.gif' border=0 alt='купить'></a></td>

          </tr>
          
       ";
    }
    

   $catquery="select category_code from {$PREFFIX}_shopcategory where category_active=1 and category_parent=$category_code order by category_pos";
   $categoryres=mysql_query ($catquery) or die ("Не могу выбрать потомков. Ошибка в запросе.");
   while(list($c_code)=mysql_fetch_array($categoryres))
   {
     $resultlist=getunittable($c_code,$resultlist,$brand);
   }                                          
   
   return $resultlist;
}   
   
   
   

function getCatBrandList($category_code,$resultlist,$cat_code)
{
    global $PREFFIX,$brand,$barr;                                     
    
    $topunutquery="select brand_name,{$PREFFIX}_brands.brand_code 
                   from {$PREFFIX}_shopunit 
                     left join {$PREFFIX}_brands on ({$PREFFIX}_brands.brand_code={$PREFFIX}_shopunit.brand_code) 
                   where unit_active=1 and category_code=$category_code 
                   group by {$PREFFIX}_brands.brand_code";
    $topunutres=mysql_query ($topunutquery) or die ("Не могу выбрать топ-предметы. Ошибка в запросе.");
    $num_topunuts=mysql_num_rows($topunutres);
    while(list($brand_name,$brand_code)=mysql_fetch_array($topunutres))
    {
       $brandinarray=1; $bcount=0;
       foreach($barr as $index => $val) {if ($val==$brand_code) $brandinarray=0; $bcount++;}
       
       if($brandinarray==1)
       {
         $barr[$bcount]=$brand_code;
         
         if ($brand_code==$brand) $bclass="class=abrandbutton";
         else  $bclass="class=brandbutton";

         $resultlist=$resultlist."   
            <div ".$bclass."><a href='catalog.php?id=$cat_code&brand=$brand_code'>$brand_name</a></div>
         ";
       }
    }
    
   $catquery="select category_code from {$PREFFIX}_shopcategory where category_active=1 and category_parent=$category_code order by category_pos";
   $categoryres=mysql_query ($catquery) or die ("Не могу выбрать потомков. Ошибка в запросе.");
   while(list($c_code)=mysql_fetch_array($categoryres))
   {
     $resultlist=getCatBrandList($c_code,$resultlist,$cat_code);
   }                                          
   
  return $resultlist;
  
  

}   


?>
