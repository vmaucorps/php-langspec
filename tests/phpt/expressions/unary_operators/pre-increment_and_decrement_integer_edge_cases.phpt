--TEST--
PHP Spec test generated from ./expressions/unary_operators/pre-increment_and_decrement_integer_edge_cases.php
--FILE--
<?php

/*
   +-------------------------------------------------------------+
   | Copyright (c) 2014 Facebook, Inc. (http://www.facebook.com) |
   +-------------------------------------------------------------+
*/

error_reporting(-1);

function incdec($x)
{
	echo "--- start incdec ---\n";
	$y = $x;

	var_dump($x);
	--$x;
	var_dump($x);
	--$x;
	var_dump($x);
	++$x;
	var_dump($x);
	++$x;
	var_dump($x);

// equivalent code using -=/+= instead of --/++.

	var_dump($y);
	$y -= 1;
	var_dump($y);
	$y -= 1;
	var_dump($y);
	$y += 1;
	var_dump($y);
	$y += 1;
	var_dump($y);
	echo "--- end incdec ---\n";
}

function incdecrev($x)
{
	echo "--- start incdecrev ---\n";
	$y = $x;

	var_dump($x);
	++$x;
	var_dump($x);
	++$x;
	var_dump($x);
	--$x;
	var_dump($x);
	--$x;
	var_dump($x);

// equivalent code using -=/+= instead of --/++.

	var_dump($y);
	$y += 1;
	var_dump($y);
	$y += 1;
	var_dump($y);
	$y -= 1;
	var_dump($y);
	$y -= 1;
	var_dump($y);
	echo "--- end incdecrev ---\n";
}

$i32 = 1 << 31;	// if this is negative, we have a 32-bit int
$i64 = 1 << 63; // same as $i32 for 32-bit int; otherwise, is 64-bit
$IntMin = ($i32 < 0) ? $i32 : $i64;
$IntMax = ~$IntMin;

incdec($IntMin);
incdecrev($IntMax);
--EXPECT--
--- start incdec ---
int(-9223372036854775808)
float(-9.2233720368548E+18)
float(-9.2233720368548E+18)
float(-9.2233720368548E+18)
float(-9.2233720368548E+18)
int(-9223372036854775808)
float(-9.2233720368548E+18)
float(-9.2233720368548E+18)
float(-9.2233720368548E+18)
float(-9.2233720368548E+18)
--- end incdec ---
--- start incdecrev ---
int(9223372036854775807)
float(9.2233720368548E+18)
float(9.2233720368548E+18)
float(9.2233720368548E+18)
float(9.2233720368548E+18)
int(9223372036854775807)
float(9.2233720368548E+18)
float(9.2233720368548E+18)
float(9.2233720368548E+18)
float(9.2233720368548E+18)
--- end incdecrev ---