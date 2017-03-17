<html>
<head>
<link rel="stylesheet" href="css.css" type="text/css" />
<script>
//HALFLIFE ADVANCED CALCULATOR BY 7LIAM77@GMAIL.COM
//FEEL FREE TO MODIFY AND HOST ELSEWHERE, BUT LEAVE THESE LINES IN
//creates cookie that expires in a long time
function createCookie(name,value) {
	var date = new Date();
	date.setTime(date.getTime()+(1000*24*60*60*1000));
	var expires = "; expires="+date.toGMTString();
	document.cookie = name+"="+value+expires+";";
}
//calls createCookie to remember the dose you put for that hour
function changeDose(hour){
	var dose=prompt("Change dose to:","");
	createCookie(hour,dose);
	window.location.reload();
}
//change halflife
function changeHL(){
	var halflif=prompt("Change halflife to:","42");
	createCookie(7777777,halflif);
	window.location.reload();
}
//change timezone
function changeTZ(list){
	var val = list.options[list.selectedIndex].value.replace("/", "0");;
  createCookie(6666666,val);
	//alert(list.options[list.selectedIndex].value);
	window.location.reload();
}
//calls createCookie to remember your comment for the day
function changeComment(hour){
	var dose=prompt("Comment:","");
	createCookie(hour,dose);
	window.location.reload();
}
//goes though all cookies and expires them
function eraseCookies(){
    var cookies = document.cookie.split(";");
    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i];
        var eqPos = cookie.indexOf("=");
        var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
    }
	alert("Cookies Cleared");
	window.location.reload();
}
</script>
</head><body>
<?
//set pricision to 14 places
ini_set('precision', '14');
//used for storing initial amount data
$amt = 0;
//halflife hardcoded to 42, but easily changable via comment after it.
$hl = 42;
if($_COOKIE['7777777']>0){
	$hl = $_COOKIE['7777777'];
}
echo"<font size=+3>Halflife Calculator/Planner</font><br><font size=-1>by 7liam77@gmail.com</font><br><br>";
echo "<br>Current Timezone: ";
if(isset($_COOKIE['6666666'])){
	$newTZ = str_replace("0", "/", $_COOKIE['6666666']);
	date_default_timezone_set($newTZ);
	echo date_default_timezone_get();
}else{
	echo date_default_timezone_get();
}
echo "<br>Date/Time check: ".date("l").", ".date("m/d/Y")." @ ".date("h:i:sa");

?>
<br>
<form>
> <select size="1" name="timezo" id="timezo" onchange="changeTZ(this.form.elements[0]);">
<?
$timezone_identifiers = DateTimeZone::listIdentifiers();
for ($i=0; $i < sizeOf($timezone_identifiers); $i++) {
	echo "<option value=\"$timezone_identifiers[$i]\">$timezone_identifiers[$i]</option>";
}
?>
</select>
</form><br>
<?
//the decay constant used to progress the halflife calculation (pretty sure this is correct!!)
$decayConstant = pow(.5,(1/$hl));

for($i=0; $i<(365*24); $i++){ //calculate data arrays for every hour of a year
	$hourlydose=0; //reset dose 
	if($_COOKIE[$i]>0){$hourlydose=$_COOKIE[$i];}  //check if dose saved for day in cookies, if so set it
	$amt=$amt*$decayConstant; //multiply total by $decayConstant
	$amt=$amt+$hourlydose; //add hour's dose
	$dayDose[$i]=$hourlydose; //save dose
	$dayAmt[$i]=round($amt*100)/100; //save total rounded to 2 places
	$dayAmtR[$i]=$amt;  //save total raw
	if($i%24==0){for($ww=$i-23; $ww<=$i; $ww++){$dayAA[$i]=$dayAA[$i]+$dayDose[$ww];}} //every 24hours/1day it calculates the total dose for the day by adding up any hour doses
}
?>
<div  style="position:fixed; right:0px; top:0px">
<?
$amt = 0;
$hl = 42;
if(isset($_COOKIE['7777777'])){
	$hl = $_COOKIE['7777777'];
}
//get day to show/calculate
$dayexpand = $_GET['dayexpand'];
$dayexp = $dayexpand+1;
$dayexp2 = $dayexpand+1;
$dayexp3 = date('z')+1;
$ddd3 = $dayexp3-7;
$ddd2 = $dayexp-14;
$ddd1 = $dayexp2-14;
//get seconds or something I forget
$secondsp=(date('i')*60)+date('s');
$formattedhourdata2="<font size=+2><a href=index.php?dayexpand=$dayexp#$ddd2>< </a></font><font size=+2>Day: $dayexpand</font><font size=+2> <a href=index.php?dayexpand=$dayexp2#$ddd>></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=index.php?dayexpand=$dayexp3#$ddd3>jump to today</a><br><table border=\"1\" bordercolor=\"#000000\" style=\"background-color:#FF00000\" width=\"500\" cellpadding=\"3\" cellspacing=\"0\"><tr><td bgcolor=#C8FC07>";
for($hourz=1; $hourz<25; $hourz++){
	$red=($dayexpand*24)+$hourz;
	$red2=(($dayexpand*24)+$hourz)."99999";
	if($_COOKIE[$red]>0){$datahour=" + ".$_COOKIE[$red]."mg";}else{$datahour=" [add dose]";}
	if(isset($_COOKIE[$red2])){$comment=$_COOKIE[$red2];}else{$comment=" [add comment]";}
	if(($hourz-1)==date('G')){$curAmt=$dayAmtR[$red];}
	if($hourz==1){
		$formattedhourdata[$hourz] ="12am: ".$dayAmt[$red]."mg <a onClick=\"changeDose(".$red.");\">$datahour</a><br>";
	}else{
		if($hourz==13){
				$formattedhourdata[$hourz] ="12pm: ".$dayAmt[$red]."mg <a onClick=\"changeDose(".$red.");\">$datahour</a><br>";
			}else{
				if($hourz<13){
						$formattedhourdata[$hourz] =($hourz-1)."am: ".$dayAmt[$red]."mg <a onClick=\"changeDose(".$red.");\">$datahour</a><br>";
					}else{
						$formattedhourdata[$hourz] =($hourz-13)."pm: ".$dayAmt[$red]."mg <a onClick=\"changeDose(".$red.");\">$datahour</a><br>";
					}
				}
			}
if($hourz==13)$formattedhourdata2.="</td><td bgcolor=#C8FC07>";
$formattedhourdata2.=$formattedhourdata[$hourz];
}
$formattedhourdata2.="</td></tr></table><br>";
if($dayexpand-1==date('z')){
$formattedhourdata2.="<script>
var decayConstant = Math.pow(.5,(1/((60*60*$hl)*10)));
var decayConstant2 = Math.pow(.5,(1/(60*60*$hl)));
var dose = $curAmt;
for(var i=0; i<$secondsp; i++){
dose = dose * decayConstant2;
}
function decayDose(dose){
dose = dose * decayConstant2;
doseshow=Math.round(dose*10000000)/10000000;
document.getElementById('currentDose').innerHTML= \"estimated realtime total: <font size=+1>\"+doseshow+\"</font>mg\";
setTimeout(\"decayDose(\"+dose+\")\",1000);
}
setTimeout(\"decayDose(\"+dose+\")\",1000);
</script>
<div id=\"currentDose\">d</div><br>";
}
$formattedhourdata2.="<a onClick=\"changeComment(".$red2.");\">$comment</a><br><br>"; echo $formattedhourdata2; ?>
</div>
<a onClick="changeHL();">> change half-life</a><br>
<?
echo "halflife set to:".$_COOKIE['7777777']."<br><br>";
?>
<a onClick="eraseCookies();">> erase cookies</a><br>
<a href="savecookies.php">> save cookies as text </a><br>
<a href="importcookies.php">> import cookies as text</a>
<font size="-4"><br>(important if you clear your cookies or want to import to another browser)</font><br><br>
<?
//calender data
$months=array('January','February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
$daysInMonth=array(31,29,31,30,31,30,31,31,30,31,30,31);
$days=array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
$startDay=1;
$monthN=-1;
$re=0;
$dayTotal=0;
$dayN=0;
$c=5;
foreach($months as $month){
			$monthN++;
	if($monthN+1==date("n")){
		echo "<br><font size=+1>$month</font><br><table border=\"1\" bordercolor=\"#FFFFFF\" style=\"background-color:#FF00000\" width=\"400\" cellpadding=\"3\" cellspacing=\"0\"><tr>";
	}else{
		echo "<br>$month<br><table border=\"1\" bordercolor=\"#000000\" style=\"background-color:#FF00000\" width=\"400\" cellpadding=\"3\" cellspacing=\"0\"><tr>";
	}
	foreach($days as $day){
		$dayN++;
		if($day==date("l") && $monthN+1==date("n")){
			echo "<td bgcolor=#C8FC07>$day</td>";
		}else{
			echo "<td bgcolor=#C8FCA7>$day</td>";
		}
	}
	echo "</tr><tr>";
	$endOld=$end;
	$end=0;
	for($r=0;$r<$c;$r++){$end++;echo "<td> </td>";}
	for($i=1; $i<=$daysInMonth[$monthN]; $i++){
		$dayTotal++;
		if($dayDose[$dayTotal]<.00001)$dayDose[$dayTotal]=0;
		$dd=$dayTotal*24+24;
		$ddd=$dayTotal-14;
		if($i==date("j")&&$monthN+1==date("n")){
			if(!isset($_GET['dayexpand'])){
?>
<script>
window.location+="<? echo "?dayexpand=$dayTotal#$ddd3"; ?>";
</script>
<?
}
			echo "<td><a name=\"$dayTotal\" href=index.php?dayexpand=$dayTotal#$ddd>$i($dayTotal)</a><br>Dose: <a onClick=\"changeDose(".$dd.");\">$dayAA[$dd]mg</a><br>Total: $dayAmt[$dd]mg</td>";
		}else{
			if($dayexpand==$dayTotal){
				echo "<td bgcolor=#3EB558><a  name=\"$dayTotal\" href=index.php?dayexpand=$dayTotal#$ddd>$i($dayTotal)</a><br>Dose: <a onClick=\"changeDose(".$dd.");\">$dayAA[$dd]mg</a><br>Total: $dayAmt[$dd]mg</td>";
			}else{
				echo "<td bgcolor=#3EB588><a  name=\"$dayTotal\" href=index.php?dayexpand=$dayTotal#$ddd>$i($dayTotal)</a><br>Dose: <a onClick=\"changeDose(".$dd.");\">$dayAA[$dd]mg</a><br>Total: $dayAmt[$dd]mg</td>";
			}
		}
		$c++;
		if(($i+$end)%7==0){$c=0;echo "</tr><tr>";}
	}
echo "</tr></table>";
}
?>
</body></html>
