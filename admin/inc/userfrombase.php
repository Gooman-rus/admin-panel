<?php
  $query="select * from {$PREFFIX}_admin
            where binary admin_login='".htmlspecialchars($_POST['login'],ENT_QUOTES)."' and binary admin_pass=MD5('".$_POST['password']."') and admin_active=1";
  $res=@mysql_query($query) or die("Cannot Extract User:$query<br>".mysql_error());
//echo"$query<br>";
  if (mysql_num_rows($res)!=0)
  {
   $REGUSER["code"]=mysql_result($res,0,"admin_code");
   $REGUSER["name"]=mysql_result($res,0,"admin_name");
   $REGUSER["login"]=mysql_result($res,0,"admin_login");
   $REGUSER["pass"]=mysql_result($res,0,"admin_pass");
   $REGUSER["email"]=mysql_result($res,0,"admin_email");

// --------------- права -------------------------------------------------------
   $REGUSER["radmin"]=mysql_result($res,0,"admin_radmin");
   //$REGUSER["rbanner"]=mysql_result($res,0,"admin_rbanner");

   $REGUSER["rnews"]=mysql_result($res,0,"admin_rnews");
   $REGUSER["rstation"]=mysql_result($res,0,"admin_rtext");
   $REGUSER["rstation"]=mysql_result($res,0,"admin_requipment");
   $REGUSER["rstation"]=mysql_result($res,0,"admin_rpartner");
 /*  $REGUSER["rstation"]=mysql_result($res,0,"admin_rstation");
   $REGUSER["rperson"]=mysql_result($res,0,"admin_rperson");
   $REGUSER["rreport"]=mysql_result($res,0,"admin_rreport");
   $REGUSER["rread"]=mysql_result($res,0,"admin_rread");
   $REGUSER["rlisten"]=mysql_result($res,0,"admin_rlisten");
   $REGUSER["rwork"]=mysql_result($res,0,"admin_rwork");
   $REGUSER["rpremium"]=mysql_result($res,0,"admin_rpremium");
   $REGUSER["rtns"]=mysql_result($res,0,"admin_rtns");
   $REGUSER["rgb"]=mysql_result($res,0,"admin_rgb");
   $REGUSER["rdirectory"]=mysql_result($res,0,"admin_rdirectory");*/


// -----------------------------------------------------------------------------

   unset($_SESSION["REGUSER"]);
   $_SESSION["REGUSER"]=$REGUSER;

  } else unset($REGUSER);
?>
