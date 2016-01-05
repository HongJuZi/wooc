<?php

/**
 * @version			$Id$
 * @create 			2015-04-06 20:04:02 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('config.popo.markpopo, app.admin.action.AdminAction, model.markmodel');

/**
 * 语言标识的动作类 
 * 
 * 主要处理后台管理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.admin.action
 * @since 			1.0.0
 */
class MarkAction extends AdminAction
{

    /**
     * 构造函数 
     * 
     * 初始化类变量 
     * 
     * @access public
     */
    public function __construct() 
    {
        parent::__construct();
        $this->_popo        = new MarkPopo();
        $this->_model       = new MarkModel($this->_popo);
    }

    /**
     * 视图加载以后需要执行的动作
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _otherJobsAfterEditView()
    {
        $this->_assignTanslateList();
        $this->_assignLangList();
    }

    /**
     * 加载翻译列表
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     */
    private function _assignTanslateList()
    {
        $record     = HResponse::getAttribute('record');
        if(!$record) {
            return;
        }
        $translate  = HClass::quickLoadModel('translate');

        HResponse::setAttribute(
            'translateMap', 
            HArray::turnItemValueAsKey($translate->getAllRowsByFields(
                    '`id`, `content`, `parent_id`, `mark_id`', 
                    '`mark_id` = ' . $record['id']
                ),
                'parent_id'
            )
        );
    }

    /**
     * 添加
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function add()
    {
        $id     = $this->_add();
        $this->_updateTranslate($id);

        HResponse::succeed(HTranslate::__('添加翻译成功'));
    }

    /**
     * 编辑功能
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function edit()
    {
        $record     = $this->_edit();
        $this->_updateTranslate($record['id']);

        HResponse::succeed(HTranslate::__('编辑成功'));
    }
    
    /**
     * 更新当前的翻译内容
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     */
    private function _updateTranslate($markId)
    {
        $langList   = $this->_getLangList();
        $translate  = HClass::quickLoadModel('translate');
        foreach($langList as $lang) {
            $content   = HRequest::getParameter('lang_' . $lang['id']);
            $id        = HRequest::getParameter('translate_' . $lang['id']);
            if(empty($content) && !$id) {
                continue;
            }
            $data   = array(
                'content' => $content,
                'parent_id' => $lang['id'],
                'mark_id' => $markId,
                'author' => HSession::getAttribute('id', 'user')
            );
            if($id) {
                $translate->editByWhere($data, '`id` = ' . $id);
                continue;
            }
            if(1 > $translate->add($data)) {
                throw new HRequestException('添加翻译失败！');
            }
        }
    }
    
    /**
     * @var private static $_api    翻译API
     */
    private static $_api    = 'http://fanyi.baidu.com/v2transapi';
    
    /**
     * 支持的语种
     * @var ArrayAccess
     */
    private static $_langMap = Array (
        'auto' => '自动检测',
        'ara' => '阿拉伯语',
        'de' => '德语',
        'ru' => '俄语',
        'fra' => '法语',
        'kor' => '韩语',
        'nl' => '荷兰语',
        'pt' => '葡萄牙语',
        'jp' => '日语',
        'th' => '泰语',
        'wyw' => '文言文',
        'spa' => '西班牙语',
        'el' => '希腊语',
        'it' => '意大利语',
        'en' => '英语',
        'yue' => '粤语',
        'zh' => '中文' 
    );

    /**
     * 自动翻译服务
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function aautotranslate()
    {
        HVerify::isAjax();
        HVerify::isEmpty(HRequest::getParameter('to'), '目标');
        HVerify::isEmpty(HRequest::getParameter('content'), '内容');
        $text   = TranslateHelper::exec(
            HRequest::getParameter('content'), 
            'zh', 
            strtolower(HRequest::getParameter('to'))
        );
        HResponse::json(array('rs' => true, 'data' => $text));
    }

}


// +----------------------------------------------------------------------
// | PHP MVC FrameWork v1.0 在线翻译类 使用百度翻译接口 无需申请Api Key
// +----------------------------------------------------------------------
// | Copyright (c) 2014-2099 http://qiling.org All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: qiling <70419470@qq.com> 2015年4月13日 下午2:22:15
// +----------------------------------------------------------------------
/**
 * 在线翻译类
 * @author qiling <70419470@qq.com>
 */
class TranslateHelper {
    /**
     * 支持的语种
     * @var ArrayAccess
     */
    static $Lang = Array (
        'auto' => '自动检测',
        'ara' => '阿拉伯语',
        'de' => '德语',
        'ru' => '俄语',
        'fra' => '法语',
        'kor' => '韩语',
        'nl' => '荷兰语',
        'pt' => '葡萄牙语',
        'jp' => '日语',
        'th' => '泰语',
        'wyw' => '文言文',
        'spa' => '西班牙语',
        'el' => '希腊语',
        'it' => '意大利语',
        'en' => '英语',
        'yue' => '粤语',
        'zh' => '中文' 
    );
    /**
     * 获取支持的语种
     * @return array 返回支持的语种
     */
    static function getLang() {
        return self::$Lang;
    }
    /**
     * 执行文本翻译
     * @param string $text 要翻译的文本
     * @param string $from 原语言语种 默认:中文
     * @param string $to 目标语种 默认:英文
     * @return boolean string 翻译失败:false 翻译成功:翻译结果
     */
    static function exec($text, $from = 'zh', $to = 'en') {
        // http://fanyi.baidu.com/v2transapi?from=zh&query=%E7%94%A8%E8%BD%A6%E8%B5%84%E8%AE%AF&to=fra
        $url = "http://fanyi.baidu.com/v2transapi";
        $data = array (
            'from' => $from,
            'to' => $to,
            'query' => $text 
        );
        $data = http_build_query ( $data );
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_REFERER, "http://fanyi.baidu.com" );
        curl_setopt ( $ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; rv:37.0) Gecko/20100101 Firefox/37.0' );
        curl_setopt ( $ch, CURLOPT_HEADER, 0 );
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_TIMEOUT, 10 );
        $result = curl_exec ( $ch );
        curl_close ( $ch );

        $result = json_decode ( $result, true );

        if (!isset($result ['trans_result'] ['data'] ['0'] ['dst'])){
            return false; 
        }
        return $result ['trans_result'] ['data'] ['0'] ['dst'];
    }
}

