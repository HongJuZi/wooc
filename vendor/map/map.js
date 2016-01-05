
/**
 * @version $Id$
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @description HongJuZi Framework
 * @copyright Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
var myGeo,
    map     = new BMap.Map("allmap");            // 创建Map实例

/**
 * 百度地图地址选择器
 * 
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @package None
 * @since 1.0.0
 */
var HJZBMapSelector     = {
    opt: {
        'dom': '#area',
        'postion': '#area',
        'drag': '#drag',
        'full': null,
        'field': 'area'
    },
    init: function(opt) {
        this.initOpt(opt);
        this.bindMapBox();
        this.bindBtnShowMap();
        this.bindBtnHideMap();
        this.bindBtnSaveLoc();
        this.initAreaMap();
    },
    initOpt: function(opt) {
        for(var ele in opt) {
            this.opt[ele]   = opt[ele];
        }
    },
    bindBtnShowMap: function() {
        var self    = this;
        $(self.opt.dom).click(function() {
            var myCity = new BMap.LocalCity();
            myCity.get(function(result) {
                var cityName = '怀化市洪江市';//result.name;
                map.centerAndZoom(cityName,12);                   // 初始化地图,设置城市和地图级别。
                $(self.opt.drag).show();
                myGeo   = new BMap.Geocoder();  
            });
        });
    },
    bindMapBox: function() {
        var marker;
        var self    = this;
        // 百度地图API功能
        map.enableScrollWheelZoom(true);
        map.addControl(new BMap.ScaleControl({anchor: BMAP_ANCHOR_BOTTOM_RIGHT}));    // 右下比例尺
        map.setDefaultCursor("Crosshair");//鼠标样式
        map.addControl(new BMap.NavigationControl({anchor: BMAP_ANCHOR_TOP_RIGHT}));  //右上角，仅包含平移和缩放按钮
        var cityList = new BMapLib.CityList({
            container: 'container',
            map: map
        });
        map.addEventListener("click", function(e) {
            map.clearOverlays();
            var lng     = e.point.lng + 0.00015;
            var lat     = e.point.lat - 0.00005;
            marker      = new BMap.Marker(new BMap.Point(lng, lat));  // 创建标注
            map.addOverlay(marker);
            //获取经纬度
            $(self.opt.position).val(lng + "," + lat);
            self.setAddress(lng, lat);
        });
    },
    setAddress: function(lng, lat) {
        var self    = this;
        myGeo.getLocation(new BMap.Point(lng, lat), function(rs){    
            if (!rs){
                return HHJsLib.warn('地址信息获取失败，请重新选择！');
            }
            var addComp = rs.addressComponents;
            $('#province').val(addComp.province);
            $('#city').val(addComp.city);
            $('#district').val(addComp.district);
            $('#street').val(addComp.street);
            $('#street_number').val(addComp.streetNumber);
            if(null != self.opt.full) {
                $(self.opt.full).val(
                    addComp.province
                    + addComp.city
                    + addComp.district
                    + addComp.street
                    + addComp.streetNumber
                );
            }
        }); 
    },
    bindBtnHideMap: function () {
        var self    = this;
        $('#btn-hide-map').click(function() {
            map.clearOverlays();
            $('#drag').hide();
            $('#area').val('');
            $('#province').val('');
            $('#city').val('');
            $('#district').val('');
            $('#street').val('');
            $('#street_number').val('');
            if(null != self.opt.full) {
                $(self.opt.full).val('');
            }
        });
    },
    bindBtnSaveLoc: function () {
        var self    = this;
        $('#btn-save-loc').click(function() {
            $(self.opt.drag).hide();
            self.initAreaMap();
        });
    },
    initAreaMap: function() {
        if(!$(this.opt.position).val()) {
            $("#show-" + this.opt.field + "-map-box").addClass('text-center').html('请选择您的地址信息');
            return;
        }
        if(1 > $("#show-" + this.opt.field + "-map-box").length) {
            return;
        }
        $("#show-" + this.opt.field + "-map-box").html('');
        var map1    = new BMap.Map("show-" + this.opt.field + "-map-box");
        var loc     = $(this.opt.position).val().split(',');
        var zoom    = map.getZoom();
        map1.centerAndZoom(new BMap.Point(loc[0], loc[1]), 12 > zoom || !zoom ? 13 : zoom);
        var marker1 = new BMap.Marker(new BMap.Point(loc[0], loc[1]));  // 创建标注
        map1.addOverlay(marker1);              // 将标注添加到地图中
    }
};
