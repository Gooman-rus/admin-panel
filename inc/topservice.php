    <div class="main_links">
        <div>
            <ul>     
            
<?            
                $servicequery="select object_code, object_name$lng, object_embed$lng from {$PREFFIX}_service  where object_active=1 order by object_date limit 4";
                $serviceres=mysql_query ($servicequery) or die ("Error 2");
                $last=mysql_num_rows($serviceres); $sc=1;
                while(list($serv_code, $serv_name, $serv_desc)=mysql_fetch_array($serviceres))
                {
                   if ($sc==$last) $cl="class=last"; else $cl="";
                   echo"<li $cl><a href='service.php?id=$serv_code'><strong>$serv_name</strong>$serv_desc</a></li>";
                   $sc++;
                }
?>

                

            </ul>
        </div>
    </div>    
