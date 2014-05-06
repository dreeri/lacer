<?php
	$fileEgl = 'egl.txt';
	$fileLaceM = 'lacem.txt';
	$backlogEgl = 'backlog.txt';
	$backlogLace = 'backlogL.txt';
	$egl = file_get_contents('http://egl-comm-sales.livejournal.com/');
	$laceM = file_get_contents('http://lacemarket.net/');

	$title = "Lacer";
	$changes = "No changes :l Sad";
	$findersEgl = "egl_comm_sales2";	
	$keepersEgl = "<!-- entryHolder -->";

	$findersLaceM = "post_id_";
	$keepersLaceM = "<!-- end data box";


	//Egl-Comm-Sales
	if (is_writable($fileEgl)) 
	{
		if (!$handle = fopen($fileEgl, 'r')) 
		{
       			echo "Cannot open file ($fileEgl)";
       			exit;
   		}
	
		$back = fopen($backlogEgl, 'a+');
		
		//Parse string
		$findersEglSkip = strpos($egl, $findersEgl);
		$keepersEglSkip = strpos($egl, $keepersEgl);
		//Skip first post
		$findersEglVal = strpos($egl, $findersEgl, $findersEglSkip + strlen($findersEgl));
		$keepersEglVal = strpos($egl, $keepersEgl, $keepersEglSkip + strlen($keepersEgl));
		$strEndLen = $keepersEglVal - $findersEglVal;
		$parsedStr = substr($egl, $findersEglVal, $strEndLen);

		$oldData = fread($handle, filesize($fileEgl));

		if($oldData != $parsedStr)
		{
			$title = "(1) Lacer";
			$changes = "Wohoo finally!";		

			//fseek() in future? whence SEEK_END	
			fclose($back);
			$back = fopen($backlogEgl, 'a+');
			fwrite($back, $parsedStr);
			fclose($back);
			$back = fopen($backlogEgl, 'r');

			fclose($handle);
			$handle = fopen($fileEgl, 'w');
			if (fwrite($handle, $parsedStr) === FALSE) 
			{
       				echo "Cannot write to file ($fileEgl)";
       				exit;
   			}
		}
		$content = fread($back, filesize($backlogEgl));
		fclose($back);
		fclose($handle);
	}
 
	else 
	{
   		echo "The file $fileEgl is not writable";
	}

	//LaceMarket
	$handleLaceM = fopen($fileLaceM, 'r');
	$backLaceM = fopen($backlogLace, 'a+');
	$oldDataLaceM = fread($handleLaceM, filesize($fileLaceM));
	$findersLaceMVal = strpos($laceM, $findersLaceM);
	$keepersLaceMVal = strpos($laceM, $keepersLaceM);
	$strEndLenLaceM = $keepersLaceMVal - $findersLaceMVal;
	$parsedStrLaceM = substr($laceM, $findersLaceMVal, $strEndLenLaceM);

	if($oldDataLaceM != $parsedStrLaceM)
	{
		$title = "(1) Lacer";
                $changes = "Wohoo finally!";

		fclose($backLaceM);
                $backLaceM = fopen($backlogLace, 'a+');
                fwrite($backLaceM, $parsedStrLaceM);
                fclose($backLaceM);
		$backLaceM = fopen($backlogLace, 'r');

                fclose($handleLaceM);
                $handleLaceM = fopen($fileLaceM, 'w');
                fwrite($handleLaceM, $parsedStrLaceM);
	}
	$content2 = fread($backLaceM, filesize($backlogLace));
	fclose($backLaceM);
	fclose($handleLaceM);
?>

<!DOCTYPE html>
<html>
<head>
<title><?php echo $title; ?></title>
<meta charset="UTF-8">
<meta http-equiv="refresh" content="60">
<script>
	var counter = 0;
	var title = document.getElementsByTagName("title")[0].innerHTML;
	
	if(title == "Lacer (1)")
		var counterMain = 1;

	if(counterMain == 1)	
	{
		var i = setInterval(changeTitle, 5000);
	}

	function changeTitle()
	{
		counter++;
		
		if(counter%2)
			document.title = '(1) Lacer';

		else
			document.title = '(1) Lacer';
	}

</script>
</head>
<body>
<?php echo $changes; ?>
<div id="cont1" style="width: 50%; float: left; background-color: pink;">	
	<p>History:</p>
	<?php echo $content; ?>
</div>
<div id="cont2" style="width: 50%; float: right; background-color: #9c98c2;">
	<p>asd</p>
	<?php echo $content2; ?>
</div>
</body>
</html>
