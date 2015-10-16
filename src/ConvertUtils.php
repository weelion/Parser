<?php

namespace Ltbl\Parser;

/**
 * 转换方法工具
 */

class ConvertUtils {

    /**
     * 字符串转数组
     *
     */
    public function stringToArray($delimiter, $string)
    {
        return explode($delimiter, $string);
    }

}