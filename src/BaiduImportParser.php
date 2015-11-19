<?php

namespace Ltbl\Parser;

/**
 * 百度API解析器
 */

class BaiduImportParser extends ImportParser {

    public $originKeys = [
        "apk_id", "product_id", "channel", "title", "package_name", "versioncode", 
        "version", "minsdkversion", "smallmaplink", "packagelink", "packagesize", 
        "packageformat", "packagemd5", "summary", "description", "bigmaplink", "category", 
        "categoryname", "subcate", "sourcelink", "platform", "releasedate", "language", 
        "dpi", "fee", "keyword", "hotlevel", "downloadnumber", "browsenumber", 
        "developer_id", "developername", "source", "sourcesite", "status", "changelog", 
        "supportpad", "ios_sourcelink", "aladdinflag", "appid", "oappid", "server_name", 
        "server_time", "server_start_test", "server_end_test", "server_test_type"
    ];

    public $convertRules = [
        'appid'            => 'originId',
        'title'            => 'name',
        'category'         => 'catId',
        'package_name'     => 'packageName',
        'smallmaplink'     => 'iconUrl',
        'bigmaplink'       => 'screenshoots|stringToArray:;',  // 这里支持调用 convertUtils 类里面的转换函数， 暂时只支持调用一个函数转换
        'description'      => 'description',
        'changelog'        => 'changelog',
        'packagelink'      => 'downloadlink',
        'minsdkversion'    => 'minSdkVersion',
        'packagemd5'       => 'packageMd5',
        'packagesize'      => 'packageSize',
        'version'          => 'versionName',
        'versioncode'      => 'versionCode',
        'status'           => 'operation',
        'server_test_type' => 'testType',
    ];

    public function parse($content) {

        if(empty($content))
            throw new ParserException("解析内容不能为空");

        $data = json_decode($content, true);

        if(!(json_last_error() == JSON_ERROR_NONE))
            throw new ParserException("解析内容必须是 JSON 格式");

        $keys = array_keys($data);
        if(!count(array_intersect($keys, $this->originKeys)) == count($keys))
            throw new ParserException("解析内容不是预定内容");

        return $this->execute($data);
    }

    /**
     * 根据转换规则转换
     */
    public function execute($items)
    {
        $converKeys = array_keys($this->convertRules);

        $data = [];
        foreach ($items as $key => $value) {

            if (! in_array($key, $converKeys)) continue;

            $rule  = $this->convertRules[$key];
            $field = $this->field($rule);
            $data[$field] = $this->value($rule, $value);
        }

        return $data;
    }

}