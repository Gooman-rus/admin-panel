<?
  session_start();

  $thisurl=$_SERVER['REQUEST_URI']; 
  $_SESSION['LANG']=0;
    
    if (isset($_GET['ln']))
    {
        if ($_GET['ln']=="ru") 
            { 
              $_SESSION['lng']=""; 
              $_SESSION['LANG']=0;
              $thisurl=str_replace("&ln=ru","",$thisurl);
              $thisurl=str_replace("?ln=ru","",$thisurl);
              header("Location: $thisurl");
            }
        else 
            {
              $_SESSION['lng']="_en"; 
              $_SESSION['LANG']=1;
              $thisurl=str_replace("&ln=en","",$thisurl);
              $thisurl=str_replace("?ln=en","",$thisurl);
              header("Location: $thisurl");
            }
    }
  
  $lng=$_SESSION['lng'];
  $LANG=$_SESSION['LANG'];
  // echo"$lng++<br>"; 

?>
