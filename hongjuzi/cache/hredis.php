<?php 

/**
 * @version $Id$
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @description HongJuZi Framework
 * @copyright Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('HJZ_DIR') or die();

/**
 * Redis操作接口
 * 
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @package hongjuzi.database.nosql
 * @since 1.0.0
 */
class HRedis extends HObject
{

    /**
     * @var private static $_intance  当前单一对象缓存
     */
    private static $_intance    = null;

    /**
     * @var private $_cfg Redis服务器配置容器
     */
    private $_cfg;

    /**
     * @var private $_redis Redis 操作对象
     */
    private $_redis;

    /**
     * 构造函数
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param $cfg 配置信息
     */
    private function __construct(array $cfg)
    {
        $this->_cfg     = $cfg;
        $this->_open();
    }

    /**
     * 得到唯一实例
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param array $cfg
     * @return 当前对象
     */
    public static function getInstance(array $cfg)
    {
        if(null === self::$_intance) {
            self::$_intance     = new self($cfg);
        }

        return self::$_intance;
    }

    /**
     * 打开缓存连接
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     */
    private function _open()
    {
        $this->_redis   = new Redis();
        if(true !== $this->_redis->pconnect($this->_cfg['host'], $this->_cfg['port'], $this->_cfg['timeout'])) {
            throw new HRequestException('Redis服务器连接失败，请确认！');
        }
        $this->_redis->select($this->_cfg['db_index']);
    }

    /**
     * 切换需要操作的Redis数据库
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param $dbIndex 数据库索引，默认按：6381001起
     * @return 当前操作对象
     */
    public function select($dbIndex)
    {
        if(false === $this->_redis->select(intval($dbIndex))) {
            throw new HVerifyException('Redis数据库不存在，请确认！');
        }

        return $this;
    }

    /**
     * 关闭连接
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     */
    private function _close()
    {
        $this->_redis->close();
    }

    /**
     * 设置Redis模式
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  $attr 需要设置的模式内容
     * @param  $val 需要加入的值
     * @return $this 当前操作对象
     */
    public function setOption($attr, $val)
    {
        $this->_redis->setOption($attr, $val);

        return $this;
    }

    /**
     * 获得需要的设置值
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  $attr 需要获得的选项名称
     * @return $mix 模式值
     */
    public function getOption($attr)
    {
        return $this->_redis->getOption($attr);
    }

    /**
     * 测试服务器是否网络正常
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @return $this 当前Redis操作对象
     */
    public function ping()
    {
        if('pong' === strtolower($this->_redis->ping())) {
            throw new HVerifyException('Redis服务器网络连接失败，请确认！');
        }

        return $this;
    }
    
    /**
     * 得到当前缓存对象
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @return 当前缓存对象
     */
    public function getCacheObject()
    {
        return $this->_redis;
    }

    /**
     * 得到当前的缓存域
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @return String 域值
     */
    public function getDomain()
    {
        return $this->_cfg['domain'];
    }

    /**
     * 得到哈希表
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param $domain 域
     * @param  $attr 属性值
     * @param  $isUnSerialize = false 是否需要格式化
     * @return mix 返回值
     */
    public function hGet($domain, $attr, $isUnSerialize = false)
    {
        if(false === $this->_redis->hExists($domain, $attr)){
            return false;
        }
        $val    = $this->_redis->hGet($domain, $attr);

        return false === $isUnSerialize ? $val : igbinary_unserialize($val);
    }

    /**
     * 设置对应的哈希缓存值
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  $domain 域
     * @param  $attr 属性
     * @param  $val 值
     * @param  $isSerialize = false 是否需要序列化
     * @return $this 当前对象
     */
    public function hSet($domain, $attr, $val, $isSerialize = false)
    {
        $this->_redis->hSet($domain, $attr, false === $isSerialize ? $val : igbinary_serialize($val));

        return $this;
    }

    /**
     * 删除对应的哈希属性
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  $domain 域
     * @param  $attr 属性
     * @return $this 当前缓存操作对象
     */
    public function hDelete($domain, $attr)
    {
        if($this->_redis->hExists($domain, $attr)) {
            $this->_redis->hDel($domain, $attr);
        }

        return $this;
    }

}

?>
