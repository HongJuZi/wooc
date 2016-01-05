<?php 

/**
 * @version $Id$
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @description HongJuZi Framework
 * @copyright Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('HJZ_DIR') or die();

/**
 * 缓存实例化工厂
 * 
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @package hongjuzi.cache
 * @since 1.0.0
 */
class HCacheFactory extends HObject
{

    /**
     * 得到缓存实例
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @param $cfg 缓存配置对象
     * @return $cache 实例
     */
    public static function getInstance($cfg)
    {
        switch($cfg['type']) {
            case 'redis': 
                HClass::import('hongjuzi.cache.hredis');
                return HRedis::getInstance($cfg);
            case 'memcached':
                HClass::import('hongjuzi.cache.hmemcahced');
                return HMemcahced::getInstance($cfg);
            default: throw new HVerifyException($cfg['type'] . '还不支持，请确认！');
        }
    }

}

?>
