<?php
include('v.php');
include('application/config/database.php');

echo "My version is " . VERSION;
$version = file_get_contents ('http://command.cmdcentral.co.za/checkversion.php');
echo "<br />Latest version is " . $version;

if (version_compare(VERSION, $version, '<')) {
set_time_limit(0);
ini_set('display_errors',true);
$wav_file = get_file1('http://command.cmdcentral.co.za/latest.zip', '/latest.zip', 'latest.zip');
if (file_exists('latest.zip'))
{
echo "File exists, updating";
$file = "latest.zip";
echo "Unzipping " . $file . "<br/><br/>";
system('unzip -o ' . $file);
echo '<br/><br/>Archive extracted to directory';
unlink($_SERVER['DOCUMENT_ROOT'] . 'latest.zip');
// update database
echo "<br/><br/>Updating Database</br>";

$user =	$db['default']['username'];
$password = $db['default']['password'];
$file =	"update.sql";
$database = $db['default']['database'];
$host =	$db['default']['hostname'];
$cmd = "mysql -h $host -u $user -p$password $database < $file -f";
system( $cmd );
unlink("update.sql");
}
} else
{
echo "<br/><br/><b>Already at the latest version</b>";
}

function get_file1($file, $local_path, $newfilename)
{
    $err_msg = '';
    echo "<br>Downloading latest version from file:  $file<br>";
    $out = fopen($newfilename, 'wb');
    if ($out == FALSE){
      print "File not opened<br>";
      exit;
    }

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_FILE, $out);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_URL, $file);

    curl_exec($ch);
    if (curl_error ( $ch) != "") 
	echo "<br>Error is : ".curl_error ( $ch);

    curl_close($ch);
    //fclose($handle);

}//end function
?>
