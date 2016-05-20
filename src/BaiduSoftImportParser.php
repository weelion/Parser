<?php

namespace Ltbl\Parser;

/**
 * 百度API解析器
 */

class BaiduSoftImportParser extends ImportParser {

    public $originKeys = [
        "sname", "docid", "catename", "cateid", "size", "buildtime", 
        "download_url", "icon", "versioncode", "package", "iconhdpi", 
        "brief", "versionname", "score", "all_download", "updatetime", "oappid", 
        "packageid", "iconlow", "iconhigh", "iconalading", "price", "all_download_pid", 
        "manual_brief", "manual_short_brief", "screenshot", "md5", "icon_source",
        "developername", "lang", "adv_item", "dev_display", "changelog"
    ];

    public $convertRules = [
        'docid'            => 'originId',
        'sname'            => 'name',
        'cateid'         => 'categoryId',
        'package'     => 'packageName',
        'iconhdpi'     => 'iconUrl',
        'screenshot'       => 'screenshoots|stringToArray:;',  // 这里支持调用 convertUtils 类里面的转换函数， 暂时只支持调用一个函数转换
        'brief'      => 'description',
        'changelog'        => 'changelog',
        'download_url'      => 'downloadlink',
        // 'minsdkversion'    => 'minSdkVersion',
        'md5'       => 'packageMd5',
        'size'      => 'packageSize',
        'versionname'          => 'versionName',
        'versioncode'      => 'versionCode',
        'type'           => 'type',
        // 'server_test_type' => 'testType',
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