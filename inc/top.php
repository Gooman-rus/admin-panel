    <div class="header_bg">
        <div class="header">
            <a href='<?=$mainurl;?>' class="logo"><img src="img/logo.png" alt="" /></a>
            <!--
            <ul class="lang_menu">
                
                
            <? 
                $st=$_SERVER['REQUEST_URI']; 
                if(strpos($st,"?")==false) 
                {
                   $rulink=$st."?ln=ru";
                   $enlink=$st."?ln=en";
                }
                else
                {
                   $rulink=$st."&ln=ru";
                   $enlink=$st."&ln=en";
                } 
                
                if (strlen($lng)>0) { $enactive="class='first current'"; $ruactive=""; }
                else { $ruactive="class='first current'"; $enactive=""; }

            ?>
                

                <li <?=$ruactive;?> ><a href='<?=$rulink;?>'>рус</a></li>
                <li <?=$enactive;?> ><a href='<?=$enlink;?>'>eng</a></li>
                

            </ul>
            -->
            <ul class="site_menu">
                <li><a href='<?=$mainurl;?>'><img src="img/ico_home.gif" alt="" /></a></li>
                <li><a href=""><img src="img/ico_sitemap.gif" alt="" /></a></li>
                <li><a href="contacts.php"><img src="img/ico_mail.gif" alt="" /></a></li>
            </ul>
            <div class="advice">
                <p><strong><?echo"{$con[1][$lng]}";?></strong> 
                  
                  <?
                     $advicequery="select type_name$lng from {$PREFFIX}_doctypes where type_active=1 order by rand()";
                     $adviceres=mysql_query ($advicequery) or die ("Error 1");
                     list($advicetext)=mysql_fetch_array($adviceres);                  
                     echo"$advicetext";
                  ?>
                
                </p>
            </div>
            <p class="tell"><img src="img/tell.png" alt="" /></p>
            <div class="decor_1"></div>
            <div class="decor_2"></div>
        </div>
    </div>
    
    <div class="main_menu">
        <ul>
            <li <?echo"$thismenumain";?> ><a href='<?=$mainurl;?>'><span><?echo"{$con[2][$lng]}";?></span></a></li>
            <li <?echo"$thismenuabout";?> ><a href="about.php"><span><?echo"{$con[3][$lng]}";?></span></a></li>
            <li <?echo"$thismenuservice";?> ><a href="services.php"><span><?echo"{$con[4][$lng]}";?></span></a></li>
            <li <?echo"$thismenuprice";?> ><a href="price.php"><span><?echo"{$con[5][$lng]}";?></span></a></li>
            <li <?echo"$thismenufolio";?> ><a href="portfolio.php"><span><?echo"{$con[6][$lng]}";?></span></a></li>
            <li <?echo"$thismenucontact";?> class="last"><a href="contacts.php"><span><?echo"{$con[7][$lng]}";?></span></a></li>
        </ul>
    </div>     
