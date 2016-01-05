<?php

/**
 * @version			$Id$
 * @create 			2012-4-12 22:14:11 By xjiujiu
 * @package 		hongjuzi
 * @subpackage 		html
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('HJZ_DIR') or die();

/**
 * HTML代码显示工具类 
 * 
 * @desc
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		hongjuzi.html
 * @since 			1.0.0
 */
class HHtml extends HObject
{

    /**
     * 表单显示控件 
     * 
     * 输出表单的HTML代码 
     * 
     * @access public static
     * @param  String $formHtml 表单里面的代码
     * @param  String $action 提交到的地址
     * @param  String $name 表单的名称 
     * @param  String $method 提交的方式
     * @param  boolean $hasFileUpload 是否有上传，默认为：false
     * @param  String $attributes 需要组合的属性, 默认为：''
     * @return void
     */
    public static function form($formHtml, $action, $method = 'get', $hasFileUpload = false, $attributes = '')
    {
        static $formHtml= '<form action="%s" method="%s" name="%s" %s>%s</form>';
        $enctype    = '';
        if(true === $hasFileUpload) {
            $enctype    = 'enctype="multipart/form-data"';
        }

        echo sprintf( $formHtml, $action, $method, self::_getAttr('name', $name), $attributes, $enctype, $formHtml);
    }

    /**
     * 显示select表单元素数据是来自列表形式 
     * 
     * 根据用户给定的参数显示出对应的Select表单代码 
     * 注意：$lists的格式为，array(0 => array(), 1 => array()); 
     * @access public static
     * @param  String $name select的名称
     * @param  array $list 可以选择的项 
     * @param  String $curOption 当前的选项，用来做自动选择已经存在的选项，默认为：''
     * @param  String $attributes 需要组合的属性, 默认为：''
     * @return void 
     */
    public static function selectFromList($name, $list, $fields, $curOption = '', $attributes = '')
    {
        static $selectHtml  = '<select name="%s" %s>%s</select>';
        $optionHtml         = '<option value="">--请选择类型--</option>';
        if(!empty($list)) {
            foreach($list as $record) {
                $optionHtml .= '<option value="' . $record[$fields[0]] . '" ';
                if($curOption === $record[$fields[0]]) {
                    $optionHtml .= 'selected="selected" ';
                }
                $optionHtml .= '>' . $record[$fields[1]] . '</option>';   
            }
        }

        echo sprintf($selectHtml, $name, $attributes, $optionHtml);
    }

    /**
     * 显示select表单元素 
     * 
     * 根据用户给定的参数显示出对应的Select表单代码 
     * 注意：$options的格式为，array('value' => 'text'); 
     * @access public static
     * @param  String $name select的名称
     * @param  array $options 可以选择的项 
     * @param  String $curOption 当前的选项，用来做自动选择已经存在的选项，默认为：''
     * @param  Boolean $isTextValue 是否option的value跟text相同
     * @param  String $attributes 需要组合的属性, 默认为：''
     * @return String 
     */
    public static function select($name, $options, $curOption = '', $isTextValue = false, $attributes = '')
    {
        static $selectHtml  = '<select name="%s" %s>%s</select>';
        $optionHtml         = '<option value="">--请选择--</option>';
        foreach($options as $value => $text) {
            $value      = $isTextValue === true ? $text : $value;
            $optionHtml .= '<option value="' . $value . '" ';
            if($curOption === $value) {
                $optionHtml .= 'selected="selected" ';
            }
            $optionHtml .= '>' . $text . '</option>';   
        }
        
        echo sprintf($selectHtml, $name, $optionHtml, $attributes);
    }

    /**
     * 得到input文本类型的表单控件 
     * 
     * 根据用户给定的参数，得到对应的password类型的input控件 
     * 
     * @access public static
     * @param  String $name 控件的名称 
     * @param  String $value password的值，默认为：''
     * @param  String $attributes 需要组合的属性, 默认为：''
     * @return void 
     */
    public static function password($name, $value = '', $attributes = '')
    {
        static $passwordHtml    = '<input type="password" name="%s" value="%s" %s />';

        echo sprintf($passwordHtml, $name, $value, $attributes);
    }

    /**
     * 得到input隐藏类型的表单控件 
     * 
     * 根据用户给定的参数，得到对应的hidden类型的input控件 
     * 
     * @access public static
     * @param  String $name 控件的名称 
     * @param  String $value text的值，默认为：''
     * @param  array<String, String> | String $attributes 需要组合的属性, 默认为：''
     * @return void 
     */
    public static function hidden($name, $value = '', $attributes = '')
    {
        static $textHtml    = '<input type="hidden" name="%s" value="%s" %s />';

        echo sprintf($textHtml, $name, $value, self::_combineAttributes($attributes));
    }

    /**
     * 得到input文本类型的表单控件 
     * 
     * 根据用户给定的参数，得到对应的text类型的input控件 
     * 
     * @access public static
     * @param  String $name 控件的名称 
     * @param  String $value text的值，默认为：''
     * @param  array<String, String> | String $attributes 需要组合的属性, 默认为：''
     * @return void 
     */
    public static function text($name, $value = '', $attributes = '')
    {
        static $textHtml    = '<input type="text" name="%s" value="%s" %s />';

        echo sprintf($textHtml, $name, $value, self::_combineAttributes($attributes));
    }
    
    /**
     * Textarea显示控件 
     * 
     * 根据用户的设定，输出适合的textarea HTML代码
     * 
     * @access public static
     * @param  String $name textarea对应的名称
     * @param  String $value textarea里的值, 默认为：''
     * @param  array<String, String> | String $attributes 需要组合的属性, 默认为：''
     * @return void
     */
    public static function textarea($name, $value = '', $attributes = '')
    {
        static $textHtml    = '<textarea name="%s" %s>%s</textarea>';

        echo sprintf($textHtml, $name, $attributes, $value);
    }

    /**
     * 上传文件的显示控件 
     * 
     * 根据用户给定的设置来得到文件表单的HTML代码 
     * 
     * @access public static
     * @param  String $name 控件对应的名称
     * @param  String $value 上传按钮显示的文字 
     * @param  array<String, String> | String $attributes 需要组合的属性, 默认为：''
     * @return void 
     */
    public static function file($name, $value = '', $attributes = '')
    {
        static $fileHtml    = '<input type="file" name="%s" value="%s" %s />';

        echo sprintf($fileHtml, $name, $value, $attributes);
    }

    /**
     * CheckBox显示控件 
     * 
     * 根据用户的设置来得到对应的CheckBox显示HTMl代码 
     * 
     * @access public static
     * @param  String $name 对应的CheckBox的名称
     * @param  String $value 对应于CheckBox的值
     * @param  String $curValue 当前的CheckBox的值，默认为：''
     * @param  array<String, String> | String $attributes 需要组合的属性, 默认为：''
     * @return void 
     */
    public static function checkbox($name, $value, $curValue = '', $attributes = '')
    {
        echo self::_box('checkbox', $name, $value, $curValue, $attributes);
    }
 
    /**
     * RadioBox显示控件 
     * 
     * 根据用户的设置来得到对应的RadioBox显示HTMl代码 
     * 
     * @access public static
     * @param  String $name 对应的RadioBox的名称
     * @param  String $value 对应于RadioBox的值
     * @param  String $curValues 当前的RadioBox的值，默认为：''
     * @param  array<String, String> | String $attributes 需要组合的属性, 默认为：''
     * @return void 
     */   
    public static function radiobox($name, $value, $curValues = '', $attributes)
    {
        echo self::_box('radiobox', $name, $value, $curValue, $attributes);
    }
 
    /**
     * XXXBox显示控件 
     * 
     * 根据用户的设置来得到对应的XXXBox显示HTMl代码 
     * 
     * @access public static
     * @param  String $name 对应的XXXBox的名称
     * @param  String $value 对应于XXXBox的值
     * @param  String $curValues 当前的XXXBox的值，默认为：''
     * @param  array<String, String> | String $attributes 需要组合的属性, 默认为：''
     * @return void 
     */   
    protected static function _box($type, $name, $value, $curValue, $attributes)
    {
        static $inputHtml    = '<input type="%s" name="%s" value="%s" %s />';
        if($curValue === $value) {
            $attributes .= ' checked="checked"';
        }

        echo sprintf($inputHtml, $type, $name, $value, $attributes);
    }

    /**
     * Image显示控件 
     * 
     * 根据用户设置的相关属性来显示对应的图片 
     * 
     * @access public static
     * @param  String $src 图片的显示链接
     * @param  array<String, String> | String $attributes 需要组合的属性, 默认为：''
     * @return void
     */
    public static function image($src, $attributes = '')
    {
        static $imageHtml   = '<img src="%s" />';
        if(empty($src)) {
            echo '';
        }

        echo sprintf($imageHtml, $src, $attributes);
    }

    /**
     * 输出A的HTML换件 
     * 
     * 根据用户给定的参数生成对应的文件访问连接 
     * 
     * @access public static
     * @param  String $href 给定的链接
     * @param  String $name 对应的显示名, 默认为：''
     * @param  String $attributes 需要组合的属性, 默认为：''
     * @return void
     */
    public static function a($href, $name, $attributes = '')
    {
        self::_a($href, $name, $attributes);
    }

    /**
     * 输出A的EMAIL类的HTML换件 
     * 
     * 根据用户给定的参数生成对应的文件访问连接 
     * 
     * @access public static
     * @param  String $email 给定的邮箱地址
     * @param  String $value 对应的显示名, 默认为：''
     * @param  String $attributes 需要组合的属性, 默认为：''
     * @return void
     */
    public static function email($email, $name = '', $attributes = '')
    {
        $emailHref  = 'mailto:' . $email;

        self::_a($emailHref, $name, $attributes);
    }
    
    /**
     * 输出A的EMAIL类的HTML换件 
     * 
     * 根据用户给定的参数生成对应的文件访问连接 
     * 
     * @access public static
     * @param  String $qq 给定的QQ号
     * @param  String $SITE_URL 所属的网站地址
     * @param  String $name 对应的显示名, 默认为：''
     * @param  array<String, String> | String $attributes 需要组合的属性, 默认为：''
     * @return void 
     */
    public static function qq($qq, $siteUrl = '', $attributes = '')
    {
        if(!is_array($qq)) {
            $qqs        = explode(',', $qq); 
        }
        foreach($qqs as $qq) {
            echo '<a ' . $attributes . ' target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=' . $qq . '&site=' . $siteUrl . '&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:' . $qq . ':51" alt="点击这里给我发消息" title="点击这里给我发消息"/></a>';
        }
    }

    /**
     * 输出A的MSN类的HTML换件 
     * 
     * 根据用户给定的参数生成对应的文件访问连接 
     * 
     * @access public static
     * @param  String $MSN 给定的MSN号
     * @param  String $name 对应的显示名, 默认为：''
     * @param  String $attributes 需要组合的属性, 默认为：''
     * @return void
     */
    public static function msn($msn, $name = '', $attributes = '')
    {
        $msnHref    = 'msnim:chat?contact=' . $msn;

        self::_a($msnHref, $name, $attributes);
    }

    /**
     * 输出A的HTML换件 
     * 
     * 根据用户给定的参数生成对应的文件访问连接 
     * 
     * @access public static
     * @param  String $href 给定的链接
     * @param  String $name 对应的显示名, 默认为：''
     * @param  String $attributes 需要组合的属性, 默认为：''
     * @return void
     */
    protected static function _a($href, $name, $attributes)
    {
        static $aHtml   = '<a href="%s" %s>%s</a>';
        if(empty($name)) {
            $name  = HFile::getFileBaseName($href);
        }

        echo sprintf($aHtml, $href, $attributes, $name);
    }

    /**
     * 得到HTML编辑器代码 
     * 
     * 根据用户的设定，输出适合的textarea HTML代码
     * 
     * @access public static
     * @param  String $name 编辑器的名称
     * @param  String $value 初始化内容
     * @param  String $default 初始化默认值
     * @param  String $attributes 需要组合的属性, 默认为：''
     * @return void
     */
    public static function editor($name, $value = '', $attributes = '')
    {
        $value  = HString::decodeHtml($value);
        echo <<<EDITOR_HTML
<div class="clearfix"></div>
        <div class="label">详细内容:</div>
        <div class="editor">
            <script type="text/plain" name="{$name}" id="{$name}-id" {$attributes}>{$value}</script>
            <script type="text/javascript">$(function() { HHJsLib.bindEditor("{$name}-id", siteUrl + "/rendor/editor", "ueditor"); });</script>
        </div>
        <div class="clearfix"></div>
EDITOR_HTML;
    }

    /**
     * 得到上一条记录的访问链接 
     * 
     * 根据是否有preRecord来得到上一条记录访问的链接 
     * 
     * @access public static
     * @return String 
     * @throws none
     */
    public static function aPreRecord()
    {
        $preRecord      = HResponse::getAttribute('preRecord');
        echo empty($preRecord) ? '' : HHtml::a(
            HResponse::url(
                HResponse::getAttribute('HONGJUZI_MODEL'),
                'id=' . $preRecord['id']
            ),
            '上一条：' . $preRecord['name'],
            'title="' . $preRecord['name'] . '" class="fleft pre-record"'
        );
    }

    /**
     * 得到下条记录的访问链接 
     * 
     * 通过当前的nextRecord是否存在来生成下一条记录的访问链接 
     * 
     * @access public static
     * @return String 
     */
    public static function aNextRecord()
    {
        $nextRecord     = HResponse::getAttribute('nextRecord');
        echo empty($nextRecord) ? '': HHtml::a(
            HResponse::url(
                HResponse::getAttribute('HONGJUZI_MODEL'),
                'id=' . $nextRecord['id']
            ),
            '下一条：' . $nextRecord['name'],
            'title="' . $nextRecord['name'] . '" class="fright next-record"'
        );
    }
    
    /**
     * 组合html标签的属性 
     * 
     * Example:
     *  HHtml::_combineAttributes(
         *  array(
             *  'id="dom-id"',
             *  'class="style-1 style-2"'
         *  )
     *  );
     * 
     * @access public static
     * @param  array<String, String> $attributes 需要组合的属性
     * @return String 
     */
    protected static function _combineAttributes($attributes)
    {
        if(!is_array($attributes)) {
            return $attributes;
        }

        return implode(' ', $attributes);
    }

}

?>
