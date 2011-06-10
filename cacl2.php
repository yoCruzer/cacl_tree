<?php 
$start_time = microtime(true);
$start_mem = memory_get_usage();

$padding = '&nbsp;&nbsp;&nbsp;&nbsp;';

function cacl($file, &$data, $length)
{
	global $padding;

	$f_pad = $file;
	if(($pos = strrpos($file, '/')) !== false)
	{
		$f_pad = substr($file, $pos+1);
	}
	$f_pad = str_repeat($padding, $length).$f_pad;

	if(is_file($file))
	{
		$size = filesize($file);
		$data[$f_pad] = $size;
	}
	else
	{
		$data[$f_pad] = 0;
		$size = 0;
		foreach(glob($file.'/*') as $filename)
		{
			$size += cacl($filename, $data, 1 + $length);
		}
		$data[$f_pad] = $size.'_';
	}
	return $size;
}

$dir = dirname(__FILE__).'/data';
chdir($dir);

ob_start();
foreach(glob('*') as $file)
{
	$data = array();
	cacl($file, $data, 0);
	foreach($data as $filename => $size)
	{
		$f_size = sprintf(" <span style='color:#999;font-size:12px'>(%.3fK)</span>", (int)$size / 1024);
		if(substr($size, -1, 1) != '_')
		{
			echo $filename.$f_size.'<br />';
		}
		else
		{
			echo '<span style="color:red">'.$filename.'</span>'.$f_size.'<br />';
		}
	}
}

$content = ob_get_clean();
ob_flush();

echo 'time: '.(microtime(true) - $start_time).'<br />';
echo 'memory: '.(memory_get_usage() - $start_mem).'<br /><br />';
echo '--------------------------------------------------<br /><br />';
echo $content;
