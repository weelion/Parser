<?php

use Ltbl\Parser\Parser;


class ParserTest extends \PHPUnit_Framework_TestCase {

    /**
     * 测试不存在解析器
     * @expectedException        \Ltbl\Parser\ParserException
     * @expectedExceptionMessage 解析器不存在
     */
    public function testNotExistsParser()
    {
        Parser::instance('notExistParser');
    }

    /**
     * 测试正常解析器
     */
    public function testRightParser()
    {
        $parser = Parser::instance('BaiduGameImport');

        $this->assertInstanceOf('\Ltbl\Parser\BaiduGameImportParser', $parser);
    }
}