<?

  $langquery="select lang_code, lang_ru, lang_en from unifence_lang  order by lang_code";
  $langres=mysql_query($langquery) or die($langquery);
  while (list($lang_code,$lang_ru,$lang_en)=mysql_fetch_array($langres))
  {
     $con[$lang_code]=array("" => $lang_ru, "_en"=> $lang_en);
  }



?>
