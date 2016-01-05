            <div class="row-fluid classfy-news contact">
                <?php 
                    $phone  = HResponse::getAttribute('phone');
                    $email  = HResponse::getAttribute('email');
                    $manager  = HResponse::getAttribute('manager');
                    $address  = HResponse::getAttribute('address');
                ?>
                <h3>
                    <strong>联系我们</strong>
                    <span>Contact</span>
                </h3>
               <p>
                   <label>地址：</label><span><?php echo $address['content'];?></span>
               </p>
               <p>
                   <label>电话：</label><span><?php echo $phone['content'];?></span>
               </p>
               <p>
                   <label>联系人：</label><span><?php echo $manager['content'];?></span>
               </p>
               <p>
                   <label>邮箱：</label><span><?php echo $email['content'];?></span>
               </p>
            </div>
