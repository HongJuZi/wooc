                                                    <div class="hidden-phone visible-desktop btn-group"> 
                                                        <div class="btn-group">
                                                            <button data-toggle="dropdown" class="btn btn-info btn-mini dropdown-toggle">
                                                                <i class="icon-edit"></i>
                                                                <span class="icon-caret-down"></span>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-info pull-right">
                                                                <li>
                                                                    <a href="<?php echo HResponse::url($modelEnName . '/editview', 'id=' . $record['id']); ?>">
                                                                        <?php echo $langMap[$record['lang_id']]['name']; ?>
                                                                    </a>
                                                                </li>
                                                                <?php foreach($record['lang_map'] as $key => $item){ ?>
                                                                <li>
                                                                    <a href="<?php echo HResponse::url($modelEnName . '/editview', 'id=' . $item['extend']); ?>">
                                                                        <?php echo $langMap[$item['item_id']]['name']; ?>
                                                                    </a>
                                                                </li>
                                                                <?php }?>
                                                            </ul>
                                                        </div>
                                                        <div class="btn-group">
                                                            <button data-toggle="dropdown" class="btn btn-danger btn-mini dropdown-toggle">
                                                                <i class="icon-trash"></i>
                                                                <span class="icon-caret-down"></span>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-info pull-right">
                                                                <li>
                                                                    <a href="<?php echo HResponse::url($modelEnName . '/delete', 'id=' . $record['id']); ?>">
                                                                        <?php echo $langMap[$record['lang_id']]['name']; ?>
                                                                    </a>
                                                                </li>
                                                                <?php foreach($record['lang_map'] as $item){ ?>
                                                                <li>
                                                                    <a href="<?php echo HResponse::url($modelEnName . '/delete', 'id=' . $item['extend']); ?>" class="delete">
                                                                        <?php echo $langMap[$item['item_id']]['name']; ?>
                                                                    </a>
                                                                </li>
                                                                <?php }?>
                                                            </ul>
                                                        </div>
                                                        <div class="btn-group">
                                                            <?php if((1 + count($record['lang_map'])) != count($langList)) { ?>
                                                            <button data-toggle="dropdown" class="btn btn-info btn-mini dropdown-toggle">
                                                                <i class="icon-plus"></i>
                                                                <span class="icon-caret-down"></span>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-info pull-right">
                                                                <?php 
                                                                    foreach($langList as $lang){ 
                                                                        if(isset($record['lang_map'][$lang['id']]) || $record['lang_id'] == $lang['id']) {
                                                                            continue;
                                                                        }
                                                                ?>
                                                                <li>
                                                                    <a href="<?php echo HResponse::url($modelEnName . '/addview', 'fid=' . $record['id'] . '&lang=' . $lang['id']); ?>">
                                                                        <?php echo $lang['name']; ?>
                                                                    </a>
                                                                </li>
                                                                <?php }?>
                                                            </ul>
                                                            <?php } else { ?>
                                                            <button data-toggle="dropdown" class="btn btn-grey btn-mini dropdown-toggle" disabled>
                                                                <i class="icon-plus"></i>
                                                                <span class="icon-caret-down"></span>
                                                            </button>
                                                            <?php }?>
                                                        </div>
                                                    </div>
