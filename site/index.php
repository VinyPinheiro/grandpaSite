<?php
require_once('class/html/page.php');
try{
Page::header("");
}catch(Exception $msg)
{echo $msg;}
echo "Grandpa site's";
Page::closeBody();

?>
