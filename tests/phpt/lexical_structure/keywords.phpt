--TEST--
PHP Spec test generated from ./lexical_structure/keywords.php
--FILE--
<?php

/*
   +-------------------------------------------------------------+
   | Copyright (c) 2014 Facebook, Inc. (http://www.facebook.com) |
   +-------------------------------------------------------------+
*/

error_reporting(-1);

$colors = array("red", "white", "blue");

foreach ($colors as $a)
{
	echo $a.' ';
}
echo "\n";

// try various case combinations of keywords

fOREacH ($colors As $a)
{
	eChO $a.' ';
}
ECHO "\n";
--EXPECT--
red white blue 
red white blue