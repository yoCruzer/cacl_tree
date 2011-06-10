<?php 
$start_time = microtime(true);
$start_mem = memory_get_usage();

function get_size($file_or_dir)
{
	$filesize = 0;

	if(is_file($file_or_dir))
	{
		$filesize = filesize($file_or_dir);
	}
	else
	{
		$filesize = 0;
		foreach(glob($file_or_dir.'/*') as $file)
		{
			$filesize += get_size($file);
		}
	}

	return $filesize;
}

function tree($prefix, $file_or_dir, $length)
{
	$filename = $prefix.'/'.$file_or_dir;
	if(is_file($filename))
	{
		pad_output($file_or_dir, get_size($filename), $length);
	}
	else
	{
		if($handle = opendir($filename))
		{
			pad_output($file_or_dir, get_size($filename), $length, 1);
			while(($file = readdir($handle)) !== false)
			{
				if($file !== '.' && $file !== '..')
				{
					tree($filename, $file, 1 + $length);
				}
			}
		}
	}
}

function pad_output($str, $size, $length, $is_dir = 0)
{
	$size = sprintf(" <span style='color:#999;font-size:12px'>(%.3fK)</span>", $size / 1024);
	echo str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;", $length);
	if($is_dir)
		echo '<span style="color:red">'.$str.'</span>'.$size.'<br />';
	else
		echo $str.$size.'<br />';
}

chdir(dirname(__FILE__).'/data');
ob_start();
foreach(glob('*') as $file)
{
	tree('.', $file, 0);
}
$content = ob_get_clean();
ob_flush();

echo 'time: '.(microtime(true) - $start_time).'<br />';
echo 'memory: '.(memory_get_usage() - $start_mem).'<br /><br />';
echo '--------------------------------------------------<br /><br />';
echo $content;
