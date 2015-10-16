<?php

use Ltbl\Parser\ConvertUtils;


class ConvertUtilsTest extends \PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->convert = new ConvertUtils();
    }

    public function testStringToArray()
    {
        $data1 = $this->convert->stringToArray(',', '1,2');
        $this->assertEquals($data1, [1,2]);


        $data2 = $this->convert->stringToArray(';', '1,2');
        $this->assertNotEquals($data2, [1,2]);
    }
}