<td class=leftpanel>

<table CellSpacing=0 CellPadding=0>
<tr><td class=bluehead><h4>���������</h4><td></tr>
<tr><td class=blueblock>
<div style="margin-left:20px">

<?php

if( (isAllowed("radmin")) || (isAllowed("rbanner")) )
{
echo"<p><div class=lmenupart><b>�����������������</b></div>";
    if (isAllowed("radmin")) echo"<div class=lmenupart>&#187;&nbsp; <b><a href=\"admin.php\">���������� ��������</a></b></div>";
    if (isAllowed("radmin")) echo"<div class=lmenupart>&#187;&nbsp; <b><a href=\"lang.php\">�������</a></b></div>";
    if (isAllowed("radmin")) echo"<div class=lmenupart>&#187;&nbsp; <b><a href=\"statlist.php\">��������� ��������</a></b></div>";
//    if (isAllowed("radmin")) echo"<div class=lmenupart>&#187;&nbsp; <b><a href=\"mappoints.php\">�����</a></b></div>";
}

        
if(isAllowed(("rlisten")) || (isAllowed("rread")))
{
    echo"<br><p><div class=lmenupart><b>������������</b></div>";
    if (isAllowed("rlisten")) echo"<div class=lmenupart>&#187;&nbsp; <b><a href=\"services.php\">������</a></b></div>";
    if (isAllowed("rread")) echo"<div class=lmenupart>&#187;&nbsp; <b><a href=\"objects.php\">���������</a></b></div>";
} 

if (isAllowed("rdirectory"))
{
    echo"<br><p><div class=lmenupart><b>�����-����</b></div>";
    echo"<div class=lmenupart>&#187;&nbsp; <b><a href=\"pricetype.php\">��������������</a></b></div>";
    echo"<div class=lmenupart>&#187;&nbsp; <b><a href=\"import.php\">������</a></b></div>";
} 
         
         
if((isAllowed("rnews")) || (isAllowed("rperson")) || (isAllowed("rbanner")) || (isAllowed("rpremium"))  )
{
    echo"<br><p><div class=lmenupart><b>����������</b></div>";
    if (isAllowed("rnews")) echo"<div class=lmenupart>&#187;&nbsp; <b><a href=\"news.php\">�������</a></b></div>";
    if (isAllowed("rpremium")) echo"<div class=lmenupart>&#187;&nbsp; <b><a href=\"advices.php\">������</a></b></div>";
    if (isAllowed("rbanner")) echo"<div class=lmenupart>&#187;&nbsp; <b><a href=\"banners.php\">��������</a></b></div>";

//    if (isAllowed("rperson")) echo"<div class=lmenupart>&#187;&nbsp; <b><a href=\"blog.php\">����</a></b></div>";
//    if (isAllowed("rreport")) echo"<div class=lmenupart>&#187;&nbsp; <b><a href=\"faqtypes.php\">������ �������</a></b></div>";
}     


/*
        
if ((isAllowed("rgb")) || (isAllowed("rwork")))
{
    echo"<br><p><div class=lmenupart><b>�������</b></div>";
    if (isAllowed("rgb")) echo"<div class=lmenupart>&#187;&nbsp; <b><a href=\"quest.php\">������</a></b></div>";
    if (isAllowed("rwork")) echo"<div class=lmenupart>&#187;&nbsp; <b><a href=\"game.php\">����</a></b></div>";
} 


if( (isAllowed("radmin")) || (isAllowed("rbanner")) )
{
echo"<br><p><div class=lmenupart><b>�������</b></div>";
    echo"<div class=lmenupart>&#187;&nbsp; <b><a href=\"banners.php?page_code=1\">�� �������</a></b></div>";
    echo"<div class=lmenupart>&#187;&nbsp; <b><a href=\"banners.php?page_code=2\">�� ���������</a></b></div>";
}

*/


?>



</div>
<br>






<td></tr>
</table>
&nbsp;


  <td>

