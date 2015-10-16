<?php

namespace Ltbl\Parser;

/**
 * 解析器
 *
 * 此类库用策略模式调用不同的解析器
 */

class Parser {

    public static function instance($parser) {

        $class = 'Ltbl\Parser\\' . ucfirst($parser) . 'Parser';

        if(!class_exists($class))
            throw new ParserException($parser . " 解析器不存在");

        return new $class;
    }
}