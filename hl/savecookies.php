<html>
  <head>
    <link rel="stylesheet" href="css.css" type="text/css" />
  </head>
  <body>
  <br>
<br>
  Save the text below to backup your cookies:
  <p class="code" id="code"><?
$output="";
		foreach ($_COOKIE as $name => $value) {
			$output.= "$name:$value:";
		}
    echo base64_encode($output);
?></p><br><br><font size="+1"><a href=index.php>< back</a></font>
  </body>
  </html>