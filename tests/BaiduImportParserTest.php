<?php

use Ltbl\Parser\BaiduImportParser;


class BaiduImportParserTest extends \PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->parser = new BaiduImportParser();
        $this->parser->originKeys = [
            'aa', 'bb', 'cc'
        ];

        $this->parser->convertRules = [
            'aa' => 'a',
            'bb' => 'b',
            'cc' => 'c|stringToArray:;'
        ];
    }

    public function tearDown()
    {
        unset($this->parser);
    }

    /**
     * 测试构造函数
     */
    public function testConstruct()
    {
        $this->assertInstanceOf('\Ltbl\Libraries\Parser\BaiduImportParser', $this->parser);
    }

    /**
     * 测试解析内容为空
     * @expectedException        \Ltbl\Libraries\Parser\ParserException
     * @expectedExceptionMessage 解析内容不能为空
     */
    public function testEmptyContent()
    {
        $this->parser->parse('');
    }

    /**
     * 测试解析内容不是 JSON 格式
     * @expectedException        \Ltbl\Libraries\Parser\ParserException
     * @expectedExceptionMessage 解析内容必须是 JSON 格式
     */
    public function testNotJsonContent()
    {
        $this->parser->parse('some not valid content');
    }

    /**
     * 测试解析内容不合法 JSON 格式
     * @expectedException        \Ltbl\Libraries\Parser\ParserException
     * @expectedExceptionMessage 解析内容不是预定内容
     */
    public function testNotValidContent()
    {
        $notValidJson = '{"aaa":"bb"}';
        $this->parser->parse($notValidJson);
    }

    /**
     * 测试转换函数不存在异常
     * @expectedException        \Ltbl\Libraries\Parser\ParserException
     * @expectedExceptionMessage 解析器转换函数不存在：notExistsConvertFunction
     */
    public function testNotExistsConvertFunction()
    {
        $item = [
            'aa' => 11,
            'bb' => 22,
            'cc' => '11;22'
        ];

        $this->parser->convertRules = [
            'bb' => 'originId|notExistsConvertFunction:xxx',
        ];

        $this->parser->execute($item);
    }


    /**
     * 测试正确解析
     */
    public function testRightExecute()
    {

        $item = [
            'aa' => 11,
            'bb' => 22,
            'cc' => '11;22',
            'dd' => 33
        ];

        $data = $this->parser->execute($item);
        $this->assertEquals($data, ['a' => 11, 'b' => 22, 'c' => [11,22]]);
    }

}