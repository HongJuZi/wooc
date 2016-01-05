<?php

/**
 * @version			$Id: ihdatabase.php 1964 2012-07-05 10:28:02Z admin $
 * @create			2012-2-24 10:22:10
 * @package 	    hongjuzi	
 * @subpackage 	    database
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.
 *                  All right reserved
 * HongJuZi Framework
 */
defined('HJZ_DIR') or die();

/**
 * 定义数据操作的基本接口 
 * 
 * 数据库操作的基本操作接口，需要实现数据库操作的类，
 * 得先实现这个接口 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 	    hongjuzi.database
 * @since 			1.0.0
 */
interface IHDatabase
{

    /**
     * 连接数据库 
     * 
     * 有引擎支持的，则连接数据库引擎，文件形式的则打开相关的文件 
     * 
     * @access public
     * @return void
     * @exception none
     */
    function connect();

    /**
     * 选择数据库 
     * 
     * 指定要操作的数据库 
     * 
     * @access public
     * @return boolean 
     * @exception none
     */
    function selectDb();

    /**
     * 查询数据 
     * 
     * 查询数据库里的内容 
     *
     * @param string $sql 查询语句 默认为空
     * @access public
     * @return void
     * @exception none
     */
    function select($sql = '');

    /**
     * 添加数据记录 
     * 
     * 向数据库中添加记录 
     *
     * @param string $sql 查询语句 默认为空
     * @access public
     * @return void
     * @exception none
     */
    function add($sql = '');

    /**
     * 更新数据记录 
     * 
     * 修改数据库中的记录信息 
     *
     * @param string $sql 查询语句 默认为空
     * @access public
     * @return void
     * @exception none
     */
    function update($sql = '');

    /**
     * 删除数据记录 
     * 
     * 根据指定的ID来删除对应的数据记录 
     *
     * @param string $sql 查询语句 默认为空 
     * @access public
     * @return void
     * @exception none
     */
    function delete($sql = '');

    /**
     * 关闭数据库连接 
     * 
     * 断开数据库的连接，并释放相关的资源 
     * 
     * @access public
     * @return void
     * @exception none
     */
    function close();
}

?>
