<td class=leftpanel>

<table CellSpacing=0 CellPadding=0>
<tr><td class=bluehead><h4>Навигация</h4><td></tr>
<tr><td class=blueblock>
<div style="margin-left:20px">

<?php

if( (isAllowed("radmin")) || (isAllowed("rbanner")) )
{
echo"<p><div class=lmenupart><b>Администрирование</b></div>";
    if (isAllowed("radmin")) echo"<div class=lmenupart>&#187;&nbsp; <b><a href=\"admin.php\">Управление доступом</a></b></div>";
    if (isAllowed("radmin")) echo"<div class=lmenupart>&#187;&nbsp; <b><a href=\"lang.php\">Словарь</a></b></div>";
    if (isAllowed("radmin")) echo"<div class=lmenupart>&#187;&nbsp; <b><a href=\"statlist.php\">Текстовые страницы</a></b></div>";
//    if (isAllowed("radmin")) echo"<div class=lmenupart>&#187;&nbsp; <b><a href=\"mappoints.php\">Карта</a></b></div>";
}

        
if(isAllowed(("rlisten")) || (isAllowed("rread")))
{
    echo"<br><p><div class=lmenupart><b>Деятельность</b></div>";
    if (isAllowed("rlisten")) echo"<div class=lmenupart>&#187;&nbsp; <b><a href=\"services.php\">Услуги</a></b></div>";
    if (isAllowed("rread")) echo"<div class=lmenupart>&#187;&nbsp; <b><a href=\"objects.php\">Портфолио</a></b></div>";
} 

if (isAllowed("rdirectory"))
{
    echo"<br><p><div class=lmenupart><b>Прайс-лист</b></div>";
    echo"<div class=lmenupart>&#187;&nbsp; <b><a href=\"pricetype.php\">Редактирование</a></b></div>";
    echo"<div class=lmenupart>&#187;&nbsp; <b><a href=\"import.php\">Импорт</a></b></div>";
} 
         
         
if((isAllowed("rnews")) || (isAllowed("rperson")) || (isAllowed("rbanner")) || (isAllowed("rpremium"))  )
{
    echo"<br><p><div class=lmenupart><b>Информация</b></div>";
    if (isAllowed("rnews")) echo"<div class=lmenupart>&#187;&nbsp; <b><a href=\"news.php\">Новости</a></b></div>";
    if (isAllowed("rpremium")) echo"<div class=lmenupart>&#187;&nbsp; <b><a href=\"advices.php\">Советы</a></b></div>";
    if (isAllowed("rbanner")) echo"<div class=lmenupart>&#187;&nbsp; <b><a href=\"banners.php\">Партнеры</a></b></div>";

//    if (isAllowed("rperson")) echo"<div class=lmenupart>&#187;&nbsp; <b><a href=\"blog.php\">Блог</a></b></div>";
//    if (isAllowed("rreport")) echo"<div class=lmenupart>&#187;&nbsp; <b><a href=\"faqtypes.php\">Частые вопросы</a></b></div>";
}     


/*
        
if ((isAllowed("rgb")) || (isAllowed("rwork")))
{
    echo"<br><p><div class=lmenupart><b>Общение</b></div>";
    if (isAllowed("rgb")) echo"<div class=lmenupart>&#187;&nbsp; <b><a href=\"quest.php\">Опросы</a></b></div>";
    if (isAllowed("rwork")) echo"<div class=lmenupart>&#187;&nbsp; <b><a href=\"game.php\">Игра</a></b></div>";
} 


if( (isAllowed("radmin")) || (isAllowed("rbanner")) )
{
echo"<br><p><div class=lmenupart><b>Баннеры</b></div>";
    echo"<div class=lmenupart>&#187;&nbsp; <b><a href=\"banners.php?page_code=1\">На главной</a></b></div>";
    echo"<div class=lmenupart>&#187;&nbsp; <b><a href=\"banners.php?page_code=2\">На страницах</a></b></div>";
}

*/


?>



</div>
<br>






<td></tr>
</table>
&nbsp;


  <td>

