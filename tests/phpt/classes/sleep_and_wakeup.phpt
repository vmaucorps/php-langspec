--TEST--
PHP Spec test generated from ./classes/sleep_and_wakeup.php
--FILE--
<?php

/*
   +-------------------------------------------------------------+
   | Copyright (c) 2014 Facebook, Inc. (http://www.facebook.com) |
   +-------------------------------------------------------------+
*/

error_reporting(-1);

class Point 
{
	private static $pointCount = 0;
	private static $nextId = 1;

	private $x;
	private $y;
	private $id;

//	protected $proti;
//	public $pubi = FALSE;
//	const CON = 10;				// excluded from serialization
//	protected static $prots;	// excluded from serialization

	public static function getPointCount() 
	{
		return self::$pointCount;
	}

	public function __construct($x = 0, $y = 0) 
	{
		$this->x = $x;
		$this->y = $y;
		++self::$pointCount;
		$this->id = self::$nextId++;

		echo "\nInside " . __METHOD__ . ", $this, point count = " . self::$pointCount . "\n\n";
	}

	public function move($x, $y) 
	{
		$this->x = $x;
		$this->y = $y;
	}	

	public function translate($x, $y) 
	{
		$this->x += $x;
		$this->y += $y;
	}

	public function __destruct() 
	{
		--self::$pointCount;

		echo "\nInside " . __METHOD__ . ", $this, point count = " . self::$pointCount . "\n\n";
	}

	public function __toString() 
	{
		return 'ID:' . $this->id . '(' . $this->x . ',' . $this->y . ')';
	}	
///*
	public function __sleep() 
	{
		echo "\nInside " . __METHOD__ . ", $this, point count = " . self::$pointCount . "\n\n";
		
//		return array('y', 'x', 'proti', 'pubi');
		return array('y', 'x');	// get serialized in array insertion order
//		return array('y');
//		return array();
//		return;
//		return NULL by having no return statement
	}
//*/
///*
	public function __wakeup() 
	{
		echo "\nInside " . __METHOD__ . ", $this, \$nextId, = " . self::$nextId . "\n\n";
		
		++self::$pointCount;
		$this->id = self::$nextId++;
	}
//*/
}

echo "---------------- create and destroy a Point to boost id -------------------\n";

$a = new Point(1, 1);
unset($a);

echo "---------------- create, serialize, and unserialize a Point -------------------\n";

$p = new Point(-1, 0);
echo "Point \$p = $p\n";

$s = serialize($p);		// all instance properties get serialized
var_dump($s);

echo "------\n";

$v = unserialize($s);	// without a __wakeup method, any instance property present 
						// in the string takes on its default value.
var_dump($v);

echo "---------------- Serialize and unserialize NULL -------------------\n";

$s = serialize(NULL);	// simulate __sleep not having a return statement or returning nothing
var_dump($s);

$v = unserialize($s);
var_dump($v);

///*
echo "---------------- Add a dynamic property and serialize -------------------\n";

$p->newProp = "abc";
$s = serialize($p);		// dynamic property gets serialized if there is NO __sleep method;
						// otherwise, __sleep has to take care of that.
var_dump($s);
//*/

///*
class ColoredPoint extends Point
{
	const RED = 1;
	const BLUE = 2;

	private $color;

	public function __construct($x = 0, $y = 0, $color = RED) 
	{
		parent::__construct($x, $y);
		$this->color = $color;

		echo "\nInside " . __METHOD__ . ", $this\n\n";
	}

	public function __toString() 
	{
		return parent::__toString() . $this->color;
	}	

// while this method returns an array containing the names of the two inherited, private 
// properties and adds to that the one private property from the current class,
// serialize runs in the context o fthe type of the object given it. If that type is
// ColoredPoint, serialize doesn;t knopw what to do when it comes across the names of the 
// inherited, private	properties.

/*
	public function __sleep() 
	{
		echo "\nInside " . __METHOD__ . ", $this\n\n";
		
		$a = parent::__sleep();
		var_dump($a);
		$a[] = 'color';
		var_dump($a);
		return $a;
	}
*/
}
//*/

///*
echo "---------------- Serialize ColoredPoint -------------------\n";

$cp = new ColoredPoint(9, 8, ColoredPoint::BLUE);
echo "ColoredPoint \$cp = $cp\n";

$s = serialize($cp);
var_dump($s);

$v = unserialize($s);
var_dump($v);
//*/

echo "---------------- end -------------------\n";
--EXPECTF--
---------------- create and destroy a Point to boost id -------------------

Inside Point::__construct, ID:1(1,1), point count = 1


Inside Point::__destruct, ID:1(1,1), point count = 0

---------------- create, serialize, and unserialize a Point -------------------

Inside Point::__construct, ID:2(-1,0), point count = 1

Point $p = ID:2(-1,0)

Inside Point::__sleep, ID:2(-1,0), point count = 1

string(55) "O:5:"Point":2:{s:8:" Point y";i:0;s:8:" Point x";i:-1;}"
------

Inside Point::__wakeup, ID:(-1,0), $nextId, = 3

object(Point)#2 (3) {
  ["x":"Point":private]=>
  int(-1)
  ["y":"Point":private]=>
  int(0)
  ["id":"Point":private]=>
  int(3)
}
---------------- Serialize and unserialize NULL -------------------
string(2) "N;"

Inside Point::__destruct, ID:3(-1,0), point count = 1

NULL
---------------- Add a dynamic property and serialize -------------------

Inside Point::__sleep, ID:2(-1,0), point count = 1

string(55) "O:5:"Point":2:{s:8:" Point y";i:0;s:8:" Point x";i:-1;}"
---------------- Serialize ColoredPoint -------------------

Inside Point::__construct, ID:4(9,8), point count = 2


Inside ColoredPoint::__construct, ID:4(9,8)2

ColoredPoint $cp = ID:4(9,8)2

Inside Point::__sleep, ID:4(9,8)2, point count = 2


Notice: serialize(): "y" returned as member variable from __sleep() but does not exist in %s/classes/sleep_and_wakeup.php on line 171

Notice: serialize(): "x" returned as member variable from __sleep() but does not exist in %s/classes/sleep_and_wakeup.php on line 171
string(44) "O:12:"ColoredPoint":2:{s:1:"y";N;s:1:"x";N;}"

Inside Point::__wakeup, ID:(,), $nextId, = 5

object(ColoredPoint)#3 (6) {
  ["color":"ColoredPoint":private]=>
  NULL
  ["x":"Point":private]=>
  NULL
  ["y":"Point":private]=>
  NULL
  ["id":"Point":private]=>
  int(5)
  ["y"]=>
  NULL
  ["x"]=>
  NULL
}
---------------- end -------------------

Inside Point::__destruct, ID:4(9,8)2, point count = 2


Inside Point::__destruct, ID:5(,), point count = 1


Inside Point::__destruct, ID:2(-1,0), point count = 0
