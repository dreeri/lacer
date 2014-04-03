<?php
	$filename = 'savings.txt';
	$backlog = 'backlog.txt';
	$homepage = file_get_contents('http://egl-comm-sales.livejournal.com/');
	$title = "Nope";
	$changes = "No changes :l Sad";
	$finders = "egl_comm_sales23";	

	if (is_writable($filename)) 
	{
		if (!$handle = fopen($filename, 'r')) 
		{
       			echo "Cannot open file ($filename)";
       			exit;
   		}
		$back = fopen($backlog, 'r');
		
		$oldData = fread($handle, filesize($filename)); 
		$parsedStr = substr($homepage, strpos($homepage, $finders), strpos($homepage, ' ', 1769));

		if($oldData != $parsedStr)
		{
			$title = "(1)";
			$changes = "Wohoo finally!";		

			//fseek() in future? whence SEEK_END	
			fclose($back);
			$back = fopen($backlog, 'a+');
			fwrite($back, $parsedStr);		
			fclose($back);
			$back = fopen($backlog, 'r');

			fclose($handle);
			$handle = fopen($filename, 'w');
			if (fwrite($handle, $parsedStr) === FALSE) 
			{
       				echo "Cannot write to file ($filename)";
       				exit;
   			}
		}
		$content = fread($back, filesize($backlog));
		fclose($back);
		fclose($handle);
	}
 
	else 
	{
   		echo "The file $filename is not writable";
	}
?>

<!DOCTYPE html>
<html>
<head>
<title>Lacer <?php echo $title; ?></title>
<meta http-equiv="refresh" content="60">
</head>
<body>
<?php echo $changes; ?>
<p>History:</p>
<?php echo $content; ?>
</body>
</html>
