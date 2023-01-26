<?php 
print "Hello \"World\"\n";
$x=1;
print "Hello \"World\" \$$x\n";
//this is here doc
echo <<<EOT
<html>
<head>
</head>
<body>
$x;
\n
</body>
</html>
EOT;

//concatenation  operator
print "Hello \"World\" \$$x"."$x\n";

$v="ASD";

$y="ASD";

strcasecmp($v,$y)==0?print "equal":print "not equal";
($v=='ASDD')?print "equal":print "not equal";

print "\n";

$r='ucwords example';
print ucwords($r); 
print "\n";

print substr($r,0,5);print "\n";
print substr($r,-3,4);print "\n";

//example string to a var
$var = "Hello World Hello World Hello World";
print str_replace("Hello","Hi",$var);print "\n";
$w=5;
print "Weight is {$w}Kg\n";

$x=10;
$y="x";
print $$y;//double scan
?>