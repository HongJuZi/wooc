<?php 

/**
 * @version $Id$
 * @create 2013/10/12 15:35:33 By xjiujiu
 * @description HongJuZi Framework
 * @copyRight Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('app.admin.action.AdministratorAction');
HClass::import('vendor.excel.PHPExcel', false);

/**
 * Excel数据导入工具
 * 
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @package app.admin.action
 * @since 1.0.0
 */
class ExcelAction extends AdministratorAction
{

    /**
     * @var private $_excel Excel导入实例
     */
    private $_excel;

    /**
     * 构造函数
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function __construct()
    {
        $this->_excel   = null;
    }

    /**
     * 生成对应的模块导入Excel模板 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function template()
    {
        $this->_initModelPopo();
        $this->_excel  = new PHPExcel();
        $this->_initExcelProps('导入模板');
        $this->_fillDataToExcelFile();
        $this->_outputExcelFile($this->_popo->modelZhName . '数据导入模板.xls');
    }

    /**
     * 导入Excel数据
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function import()
    {
        $this->_initModelPopo();
        $filePath   = $this->_uploadExcelFile();
        $data       = $this->_extractExcelData($filePath);
        $this->_importExcelData($data);
        HResponse::succeed(
            $this->_popo->modelZhName . '模块Excel文件导入成功！',
            HRequest::getParameter('referer')
        );
    }

    /**
     * 导出Excel文件
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function export()
    {
        HVerify::isEmpty(HRequest::getParameter('page'), '当前页数');
        $perpage    = intval(HRequest::getParameter('perpage'));
        $perpage    = 0 >  $perpage ? 10 : $perpage;
        $page       = $this->_getPageNumber();
        $this->_initModelPopo();
        $model      = HClass::loadModelClass(HRequest::getParameter('m'));
        $model->set('popo', $this->_popo);
        $list       = $model->getListByFields('*', $page, $perpage);
        if(empty($list)) {
            throw new HVerifyException($this->_popo->modelZhName . '数据为空，还不能导出Excel文件！');
        }
        $this->_excel  = new PHPExcel();
        $this->_initExcelProps('导出数据');
        $this->_fillDataToExcelFile($list);
        $this->_outputExcelFile($this->_popo->modelZhName . '第' . ($page + 1) . '页数据.xls');
    }

    /**
     * 初始化模块配置文件
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     */
    private function _initModelPopo()
    {
        HVerify::isEmpty(HRequest::getParameter('m'), '模块名称');
        try {
            $this->_popo   = HClass::loadPopoClass(HRequest::getParameter('m'));
        } catch(HIOException $ex) {
            throw new HVerifyException('模块不存在，请确认！');
        }
    }

    /**
     * 导入Excel数据
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param  Array $data 需要导入的数据
     */
    private function _importExcelData($data)
    {
        if(empty($data)) { 
            throw new HVerifyException('Excel文件里为空，请确认！'); 
        }
        $model      = HClass::loadModelClass(HRequest::getParameter('m'));
        $model->set('popo', $this->_popo);
        $fields     = array_keys($this->_popo->get('fields'));
        $list       = array();
        $count      = count($data) - 1;
        foreach($data as $key => $row) {
            $list[] = $row;
            unset($data[$key]);
            if($key % 50 === 0 || $key == $count) {
                try {
                    $model->add($list, $fields);
                    $list   = array();
                    continue;
                } catch(HSqlParseException $ex) {
                    throw new HRequestException('服务器繁忙，请您稍后再试～导入失败！' . $ex->getMessage());
                }
            }
        }
    }
    
    /**
     * 提取Excel数据
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param  String $filePath 
     * @return Array 数组
     */
    private function _extractExcelData($filePath)
    {
        $data           = array(); 
        $reader         = PHPExcel_IOFactory::createReader('Excel5');
        $reader->setReadDataOnly(true); 
        $this->_excel   = $reader->load(ROOT_DIR . DS . $filePath); 
        $workSheet      = $this->_excel->getActiveSheet(); 
        $maxRow         = $workSheet->getHighestRow(); 
        $maxColumn      = $workSheet->getHighestColumn(); 
        $maxColIndex    = $maxColumnIndex = PHPExcel_Cell::columnIndexFromString($maxColumn); 
        $fields         = $this->_popo->get('fields');
        if(count($fields) != $maxColIndex) {
            throw new HVerifyException('Excel文件的列数不对，请仔细对比当前的模块的导入模板！');
        }
        for ($row = 2; $row <= $maxRow; $row++) {
            $col  = 0;
            foreach($fields as $field => $cfg) {
                if(true === $cfg['not_null'] && HVerify::isEmptyNotZero()) {
                    throw new HVerifyException('错误：' . $cfg['name'] . '的值必须填写！在' . ($row + 1) . '行，' . ($col + 1) . '列。导入终止！');
                }
                $data[$row - 2][$field]     = HString::encodeHtml((string)$workSheet->getCellByColumnAndRow($col, $row)->getValue());
                $col ++;
            }
        }
        unset($fieldCfg);

        return $data; 
    }

    /**
     * 上传Excel文件
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @throws HRequestException 请求异常 | HVerifyException 验证异常
     * @return String 上传后的服务器地址
     */
    private function _uploadExcelFile()
    {;
        $uploadFile      = HRequest::getFiles('excel_file');
        HVerify::isEmpty($uploadFile['name'], '需要导入的Excel文件');
        if($uploadFile['error']) {
            throw new HVerifyException('上传出错，请确认是否磁盘空间不足，或上传的文件已经不存在！');
        }
        HClass::import('hongjuzi.net.huploader');
        $hUploader          = new HUploader(
            HObject::GC('TEMP_DIR'), 
            5,  //5m
            array('.xlsx', '.xls'),
            ROOT_DIR . DS
        );
        $uploadedInfo       = $hUploader->uploader($uploadFile);
        if(isset($uploadedInfo['error'])) {
            if(!empty($uploadedInfo['error'])) {
                throw new HRequestException(($uploadedInfo['error']));
            }
        }

        return $uploadedInfo['path'];
    }

    /**
     * 初始化Excel属性
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param  String $type 导出文件类型
     */
    private function _initExcelProps($type)
    {
        $title  = $this->_popo->modelZhName . 'Excel' . $type;
        $this->_props  = $this->_excel->getProperties();
        $this->_props->setCreator('红橘子');
        $this->_props->setLastModifiedBy('红橘子');
        $this->_props->setTitle($title);
        $this->_props->setSubject($title);  
        $this->_props->setDescription($title);  
        $this->_props->setKeywords($type);
        $this->_props->setCategory($this->_popo->modelZhName . '模块Excel' . $type);
    }

    /**
     * 初始化Excel表头
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param  Array $data 需要导入的数据
     * @param  int $sheet 需要操作的表
     */
    private function _fillDataToExcelFile($data = null, $sheet = 0, $title = 'sheet1')
    {
        $this->_excel->setActiveSheetIndex($sheet);
        $objActSheet = $this->_excel->getActiveSheet();  
        //设置当前活动sheet的名称  
        $objActSheet->setTitle($title);
        //设置单元格内容
        $col    = 0;
        //设置Excel表头
        foreach($this->_popo->get('fields') as $field => $cfg) {
            $value  = isset($cfg['not_null']) && true === $cfg['not_null'] ? '*必须填写！' : '';
            $value  .= empty($cfg['comment']) ? '' : $cfg['comment'];
            $value  = empty($value) ? $cfg['name'] : $cfg['name'] . '（' . $value . '）';
            $objActSheet->setCellValueByColumnAndRow($col, '1', $value);
            $col ++;
        }
        if(empty($data)) {
            return;
        }
        //填充数据
        $row    = 2;
        foreach($data as $key => $item) {
            $col    = 0;
            foreach($this->_popo->get('fields') as $field => $cfg) {
                $objActSheet->setCellValueByColumnAndRow($col, $row, HString::decodeHtml($item[$field]));
                $col ++;
            }
            $row ++;
        }
    }

    /**
     * 生成对应的模块Excel模板
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     */
    private function _outputExcelFile($fileName)
    {
        HClass::import('vendor.excel.PHPExcel.Writer.Excel5');
        $writer     = new PHPExcel_Writer_Excel5($this->_excel);
        header('Content-Type: application/force-download');  
        header('Content-Type: application/octet-stream');  
        header('Content-Type: application/download');
        header('Content-Disposition:inline;filename=' . $fileName);
        header('Content-Transfer-Encoding: binary');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');  
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');  
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: no-cache');
        $writer->save('php://output');  
    }

}

?>
