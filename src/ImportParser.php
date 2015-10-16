<?php

namespace Ltbl\Parser;

/**
 * 导入解析器超类
 *
 * 接口和子类的公用函数都写这里了。
 *
 */

abstract class ImportParser implements IParser {

    /**
     * 获取字段名
     */
    public function field($rule)
    {
        $data = explode('|', $rule);
        if(!isset($data[0]))
            throw new ParserException("解析字段不存在");

        return $data[0];
    }

    /**
     * 获取值
     */
    public function value($rule, $value)
    {
        $data = explode('|', $rule);
        if(isset($data[1])) {
            list($method, $arg) = explode(':', $data[1]);

            $converter = new ConvertUtils;
            if(!method_exists($converter, $method)) 
                throw new ParserException("解析器转换函数不存在：" . $method);

            return $converter->$method($arg, $value);
        }

        return $value;
    }



}