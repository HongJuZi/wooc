<?php

/**
 * @version			$Id$
 * @create 			2012-8-15 21:22:05 By xjiujiu
 * @package 	 	hongjuzi.filesystem
 * @subpackage 	 	export
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('vendor.excel.PHPExcel');

/**
 * 管理主页的动作类 
 * 
 * 主要处理后台管理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		hongjuzi.filesystem.export
 * @since 			1.0.0
 */
class HExcel extends HObject 
{

    /**
     * @var private $_excel excel操作实例
     */
    private $_excel;

    /**
     * @var private $_execlWriter 写入对象
     */
    private $_execlWriter;

    /**
     * @var array $_fileds 需要加入的字段
     */
    private $_fileds;

    /**
     * @var array $_data Excel数据
     */
    private $_data;

    /**
     * @var array $_colTitle 行标题
     */
    private $_colTitle;

    /**
     * @var String $_version 当前的软件版本
     */
    private $_version; 

    /**
     * 构造函数 
     * 
     * 初始化类方法 
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @return void
     * @throws none
     */
    public function __construct()
    {
        $this->_colTitle    = null;
        $this->_fields      = null; 
        $this->_data        = null;
        $this->_excelWriter = null;
        $this->_version     = '2003';
        $this->_excel       = new PHPExcel();
    }

    /**
     * 设置当前的软件版本 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String $version 当前的软件版本信息
     * @return void
     * @throws none
     */
    public function setVersion($version)
    {
        $this->_version     = $version; 
    }
 
    /**
     * 设置属性 
     * 
     * 格式：
     * <code>
     * $props   = array(
     *  'author' => 'example',
     *  'title' => 'example',
     *  'subject' => 'example',
     *  'keywords' => 'example'
     * );
     * </code> 
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  array $props 当前的文档属性
     * @return void
     * @throws none
     */
    public function setProperties($props)
    {
        $this->_props   = $props;
    }

    /**
     * 设置当前Excel的列字段 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  array $fields 当前的字段数组
     * @return void
     * @throws none
     */
    public function setFields($fields)
    {
        $this->_fields  = $fields; 
    }

    /**
     * 设置数据 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  array $data 当前的文档内容
     * @return void
     * @throws none
     */
    public function setData($data)
    {
        $this->_data    = is_array($data) ? $data : array();
    }

    /**
     * 设置当前的列宽 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String $colName 当前的列名
     * @param  bool | int $width 是否自动宽 | 指定宽度值 
     * @return void
     * @throws none
     */
    public function setColumnWidth($colName, $width = true)
    {
        if(is_bool($width)) {
            $this->_excel->getActiveSheet()
                ->getColumnDimension($colName)
                ->setAutoSize($width); 
        } else {
            $this->_excel->getActiveSheet()
                ->getColumnDimension($colName)
                ->setWidth($width); 
        }
    }

    /**
     * 导出到浏览器 
     * 
     * 弹出提示下载 
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String $fileName 文件名称 
     * @return void
     * @throws none
     */
    public function export()
    {
        $this->_importExcelProps();
        $this->_initExcelWriter();
        $this->_excel->setActiveSheetIndex(0);
        $this->_importTitleAndFirstColumn();
        $this->_importData();

        return $this;
    }

    /**
     * 导出成Excel文档 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected 
     * @return void
     * @throws none
     */
    protected function _initExcelWriter()
    {
        switch($this->_version) {
            case '2007':
                himport('app.render.excel.PHPExcel.Writer.Excel2007');
                $this->_excelWriter     = new PHPExcel_Writer_Excel2007($this->_excel);
                break;
            case '2003':
            default:
                himport('app.render.excel.PHPExcel.Writer.Excel5');
                $this->_excelWriter     = new PHPExcel_Writer_Excel5($this->_excel);
                break; 
        }
    }

    /**
     * 初始化Excel文档属性 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @return void
     * @throws none
     */
    protected function _importExcelProps()
    {
        $properties     = $this->_excel->getProperties();
        $properties->setCreator($this->_props['author']);
        $properties->setLastModifiedBy($this->_props['author']);
        $properties->setTitle($this->_props['title']);
        $properties->setSubject($this->_props['subject']);
        $properties->setDescription($this->_props['description']);
        $properties->setKeywords($this->_props['keywords']);
    }

    /**
     * 设置活动表的标题及第一行各列名
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @return void
     * @throws none
     */
    protected function _importTitleAndFirstColumn()
    {
        $col            = 0;
        $activeSheet    = $this->_excel->getActiveSheet();
        foreach($this->_fields as $field) {
            $activeSheet->setCellValueByColumnAndRow($col, 1, $field['name']);
            $col ++;
        }
    }

    /**
     * 设置Excel文档内容 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @return void
     * @throws none
     */
    protected function _importData()
    {
        $rowId          = 2;
        $activeSheet    = $this->_excel->getActiveSheet();
        foreach($this->_data as $row) {
            $colId      = 0;
            foreach($this->_fields as $key => $field) {
                $activeSheet->setCellValueByColumnAndRow($colId, $rowId, $row[$key]);
                $colId ++;
            }
            $rowId ++;
        }
    }

    /**
     * 浏览器下载 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String $fileName 下载的文件名
     * @param  String $charset 当前的页面编码默认为utf-8 
     * @return void
     * @throws none
     */
    public function download($fileName, $charset = 'utf-8')
    {
        header("Content-type: text/csv");
        HResponse::outputFile($fileName);
        $this->_excelWriter->save('php://output');
    }

    /**
     * 存成文件 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String $filePath 当前的文件路径
     * @return void
     * @throws none
     */
    public function saveAs($filePath)
    {
        $this->_excelWriter->save($filePath);
    }
  
}

?>
