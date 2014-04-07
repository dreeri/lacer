<?php
	$fileEgl = 'egl.txt';
	$filename2 = 'lacem.txt';
	$backlog = 'backlog.txt';
	$egl = file_get_contents('http://egl-comm-sales.livejournal.com/');
	$laceM = file_get_contents('http://lacemarket.net/');

	$title = "Lacer";
	$changes = "No changes :l Sad";
	$finders = "egl_comm_sales23";	

	if (is_writable($fileEgl)) 
	{
		if (!$handle = fopen($fileEgl, 'r')) 
		{
       			echo "Cannot open file ($fileEgl)";
       			exit;
   		}
		$back = fopen($backlog, 'r');
		
		$oldData = fread($handle, filesize($fileEgl)); 
		$parsedStr = substr($egl, strpos($egl, $finders), strpos($egl, ' ', 1769));

		if($oldData != $parsedStr)
		{
			$title = "(1) Lacer";
			$changes = "Wohoo finally!";		

			//fseek() in future? whence SEEK_END	
			fclose($back);
			$back = fopen($backlog, 'a+');
			fwrite($back, "</br></br>");
			fwrite($back, $parsedStr);
			$back = fopen($backlog, 'r');

			fclose($handle);
			$handle = fopen($fileEgl, 'w');
			if (fwrite($handle, $parsedStr) === FALSE) 
			{
       				echo "Cannot write to file ($fileEgl)";
       				exit;
   			}
		}
		$content = fread($back, filesize($backlog));
		fclose($back);
		fclose($handle);
	}
 
	else 
	{
   		echo "The file $fileEgl is not writable";
	}
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
			document.title = 'Changes!';
	}

</script>
</head>
<body>
<?php echo $changes; ?>
<div id="cont1" style="width: 50%;">	
	<p>History:</p>
	<?php echo $content; ?>
</div>
<div id="cont2" style="">
	<p>asd</p>
</div>
</body>
</html>
