<head>
<link rel="stylesheet" href="css.css" type="text/css" />
 <?
 if(isset($_POST['storedCookie'])){
$importedData=explode(':', base64_decode($_POST['storedCookie']), -1);
for($i=0; $i<sizeOf($importedData); $i=$i+2){
setcookie($importedData[$i], $importedData[$i+1]);
echo "imported data $i<br>";
}
echo "done.";
}else{
?>
<form name="input" action="importcookies.php" method="post">
Data: <input type="text" name="storedCookie" />
<input type="submit" value="Import Cookies" />
</form>
<?
}
?>
<br><br><font size="+1"><a href=index.php>< back</a></font>
