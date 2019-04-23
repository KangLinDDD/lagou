<?php
//$json = "{jobName:'java'}";
$json = '{"jobName":"java"}';
//$json = '{"a":1,"b":2,"c":3,"d":4,"e":5}';
//var_dump(json_decode($json));
var_dump(json_decode($json, true));
//print_r(json_decode($json));