--TEST--
Dump request
--SKIPIF--
<?php
if (!extension_loaded("snuffleupagus")) {
    print "skip";
} 

foreach (glob("/tmp/dump_result/sp_dump.*") as $dump) {
    @unlink($dump);
}
@rmdir("/tmp/dump_result/");
?>
--POST--
post_a=data_post_a&post_b=data_post_b
--GET--
get_a=data_get_a&get_b=data_get_b
--COOKIE--
cookie_a=data_cookie_a&cookie_b=data_cookie_b
--INI--
sp.configuration_file={PWD}/config/dump_request.ini
--FILE--
<?php
@mkdir("/tmp/dump_result/");
echo "1\n";
echo system("echo 1337;");
$filename = glob('/tmp/dump_result/sp_dump.*')[0];
$res = file($filename);
if ($res[1] != "GET:get_a=data_get_a&get_b=data_get_b\n") {
    echo "1\n";
} elseif ($res[2] != "POST:post_a=data_post_a&post_b=data_post_b\n") {
    echo "2\n";
} elseif ($res[3] != "COOKIE:cookie_a=data_cookie_a&cookie_b=data_cookie_b\n") {
    echo "3\n";
}
?>
--EXPECTF--
1
[snuffleupagus][0.0.0.0][disabled_function][drop] The call to the function 'system' in %a/dump_request.php:%d has been disabled.
