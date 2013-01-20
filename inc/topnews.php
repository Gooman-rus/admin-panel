        <div class="right_column">
            <h2><?echo"{$con[8][$lng]}";?></h2>
            <ul class="news"> 

<?

                $newsquery="select news_code, news_name$lng, news_date from {$PREFFIX}_news  where news_active=1 order by news_date DESC limit 4";
                $newsres=mysql_query ($newsquery) or die ("Error 3");
                while(list($news_code, $news_name, $news_date)=mysql_fetch_array($newsres))
                {
                    $news_date=ConvertDate($news_date,".");
                    echo"<li><span>$news_date</span> <a href='news.php?id=$news_code'>$news_name</a></li>";

                }

?>            
            

                
                

            </ul>
        </div>  
