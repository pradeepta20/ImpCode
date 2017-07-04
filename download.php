<?php
set_time_limit(0);
include("includes/config.php");

if(isset($_GET['file']) && $_GET['file']) {
	$filename = urldecode($_GET['file']);
	$type = urldecode($_GET['type']);
}
if (!isset($filename) || empty($filename)) {
	include("404.php");
	exit;
}

if (strpos($filename, "\0") !== FALSE) die('');
$name = basename($filename);

/*if($type == "project") {
	$file_path = DIR_PROJECT.$name;
}
elseif($type == "pmb") {
	$file_path = DIR_PMB.$name;
}*/
if($type == "job") {
	$file_path = DIR_JOB.$name;
}
else{
	$file_path=DIR_RESUME.$name;
}

if(!file_exists($file_path)) {
	include("404.php");
	exit;
}
$fsize = filesize($file_path); 

$fext = strtolower(substr(strrchr($name,"."),1));

if (!isset($_GET['fc']) || empty($_GET['fc'])) {
  $asname = $name;
}
else {
  $asname = str_replace(array('"',"'",'\\','/'), '', $_GET['fc']);
  if ($asname === '') $asname = 'NoName';
}

header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: public");
header("Content-Description: File Transfer");
header("Content-Type: ");
header("Content-Disposition: attachment; filename=\"$asname\"");
header("Content-Transfer-Encoding: binary");
header("Content-Length: ".$fsize);

$file = @fopen($file_path,"rb");
if ($file) {
  while(!feof($file)) {
	print(fread($file, 1024*8));
	flush();
	if (connection_status()!=0) {
	  @fclose($file);
	  die();
	}
  }
  @fclose($file);
}
?>