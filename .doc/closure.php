<?php

/**
 * Created by PhpStorm.
 * User: foxart
 * Date: 26/11/2016
 * Time: 01:03
 */
class A {

	private $x = 1;
}

$getXCB = function () {
	return $this->x;
};
$getX = $getXCB->bindTo(new A, 'A'); // промежуточное замыкание
echo $getX();
