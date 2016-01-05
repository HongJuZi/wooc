<?php 

/**
 * @version $Id$
 * @create 2013-8-6 10:20:09 By xjiujiu
 * @description HongJuZi Framework
 * @copyRight Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');
HClass::import('config.popo.articlepopo, app.public.action.publicaction, model.articlemodel');

/**
 * 关于我们信息类 
 * 
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @package app.site.action
 * @since 1.0.0
 */
class ArticleAction extends PublicAction
{
    /**
     * 构造函数 
     * 
     * 初始化类里的变量 
     * 
     * @access public
     */
    public function __construct() 
    {
        $this->_popo    = new ArticlePopo();
        $this->_model   = new ArticleModel($this->_popo);
    }

    /**
     * 转载博客文章分享接口
     * @return [type] [description]
     */
    public function post()
    {
        $source     = HRequest::getParameter('source');
        $footerContent = '【转帖来自于】<a href="' . $source . '">' . $source . '</a>';
        $recommendFilesContent  = $this->_getRecommendFilesList();
        $content    =  HString::encodeHtml($this->_filterContent() . $recommendFilesContent . $footerContent); 
        $content    = urldecode($content);
        $description = HString::cleanHtmlTag(urldecode($this->_filterContent()));
        $title      = urldecode(HRequest::getParameter('title'));
        HVerify::isEmpty($title, '博客标题');
        HVerify::isEmpty($content, '博客内容');
        $identifier     = md5($source);
        if($this->_model->getRecordByWhere('`identifier` = \'' . $identifier . '\'')) {
            echo json_decode(array('rs' => false, 'data' => '转载失败,不能重复转载'));
        }else{
            $data = array(
                'name'          => $title,
                'parent_id'     => ',447,470,',
                'description'   =>  HString::cutString($description, 150),
                'content'       => $content,
                'identifier'    => $identifier,
                'author'        => 25
            );
            $id     = $this->_model->add($data);
            if(1 > $id) {
                throw new HRequestException('转载博客文章失败');
            }
            $this->_addTagsLinkeddata($id);

            echo json_encode(array('rs' => true, 'data' => '转载成功'));
        }
    }

    /**
     * 过滤文本内容
     * @return [type] [description]
     */
    private function _filterContent()
    {
        $content    = HString::decodeHtml(HRequest::getParameter('content'));
        
        return preg_replace('/(<script.*?<\/script>)/is', ' ', $content);
    }

    /**
     * 得到推荐文件数据
     * @return [type] [description]
     */
    private function _getRecommendFilesList()
    {
        $tags   = HRequest::getParameter('tags');
        $tagsArr    = array('java', 'php', 'html', 'css', 'javascript', '互联网', '产品', '设计', '前端', 'android', '计算机', '编程');
        if(empty($tags)) {
            $tagsList   = $tagsArr;
        }else{
            $tagsList   = explode(',', $tags);
        }
        $tempKeyword        = array();
        $recommendFilesContent  = '<a href="http://www.xiaomengku.com">【小萌库】</a>相关精品书籍推荐<br/>';
        $recommendFiles     = '';
        do{
            if($recommendFiles) {
                break;
            }
            if(empty($tagsList)) {
                $keyword    = $tagsArr[rand(0, count($tagsArr) -1)];
            }else{
                $keywordIndex   = rand(0, count($tagsList) -1);
                $keyword        = $tagsList[$keywordIndex];
            }
            $page           = in_array($keyword, $tagsArr) ? rand(1,5) : 1;
            $syncDataUrl    = 'http://www.xiaomengku.com/api/search/getsynclist';
            $data   = array(
                'key'       => 'RwwD8Rc@*@@KFDSFSF',
                'is_ajax'   => true,
                'cat_id'    => 1,
                'id'        => '1623',
                'keyword'   => '"' . $keyword . '"',
                'page'      => $page,
                'ext'       => 'pdf'
            );
            $response   = HRequest::post($syncDataUrl, $data);
            $rs         = json_decode($response, true);
            if(false === $rs['rs']) {
                throw new HRequestException('推荐数据失败') ;
            }
            $index  = 0;
            unset($tagsList[$keywordIndex]);
            foreach($rs['data']['list'] as $key => $value) {
                if($index > 5 || $value['site_id'] != 1) {
                    continue;
                }
                $recommendFiles .= '<a href="http://www.xiaomengku.com/files?id=' . $value['id'] . '">' . $value['name'] . '</a><br/>';
                $index ++;
            }
        }while (true);
       
        return $recommendFilesContent . $recommendFiles;
    }

    /**
     * 追加标签关联
     * @param [type] $id 追加文件的标签关联
     */
    private function _addTagsLinkeddata($id)
    {
        $tags   = HRequest::getParameter('tags');
        if(empty($tags)) {
            return ;
        }
        $tagsModel  = HClass::quickLoadModel('tags');
        $linkeddata = HClass::quickLoadModel('linkeddata');
        $linkeddata->setRelItemModel('article', 'tags');
        $tagsList   = explode(',', $tags);
        $articleTags        = ',';
        $articleTagsName    = ',';
        foreach($tagsList as $key => $value) {
            $record     = $tagsModel->getRecordByWhere('`name` = \'' . $value . '\'');
            $itemId     = $record['id'];
            if(empty($record)) {
                $tagsId     = $tagsModel->add(array('name' => $value, 'hots' => 1, 'author' => 22));
                if(1 > $tagsId) {
                    throw new HRequestException('标签ID添加失败');
                }
                $itemId     = $tagsId;
            }
            $linkeddataRecord   = $linkeddata->getRecordByWhere('`rel_id` = ' . $id . ' AND `item_id` = ' . $itemId);
            if($linkeddataRecord) {
                return;
            }
            if(1 > $linkeddata->add(array('rel_id' => $id, 'item_id' => $itemId))) {
                throw new HRequestException('标签关联建立失败');
            }
            $articleTags        .= $itemId . ',';
            $articleTagsName    .= $value . ',';
        }
        if($articleTags == ',') {
            return ;
        }
        if(1 > $this->_model->edit(array('id' => $id, 'tags' => $articleTags, 'tags_name' => $articleTagsName))) {
            throw new HRequestException('更新内容失败');
        }
    }
}