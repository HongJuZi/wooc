                                <ul class="nav nav-tabs" id="myTab">
                                  <li class="active"><a data-toggle="tab" href="#base-box"><i class="pink icon-leaf bigger-110"></i> 基本信息</a></li>
                                  <?php if($popo->getFieldCfg('album_hash')) { ?>
                                  <li><a data-toggle="tab" href="#album-box"><i class="green icon-camera bigger-110"></i> 相册</a></li>
                                  <?php } ?>
                                  <?php if($popo->getFieldCfg('seo_keywords')) { ?>
                                  <li><a data-toggle="tab" href="#seo-box"><i class="blue icon-barcode bigger-110"></i> SEO优化</a></li>
                                  <?php } ?>
                                  <li><a data-toggle="tab" href="#manage-box"><span class="badge badge-success badge-icon"><i class="icon-cog"></i></span> 管理维护</a></li>
                                </ul>
