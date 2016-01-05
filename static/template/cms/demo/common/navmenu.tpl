	<div class="container">
		<div class="row">
			<div class="col-md-5">
                <a href="<?php echo HResponse::url();?>">
                    <img src="<?php echo HResponse::uri();?>images/logo.png">
                </a>
			</div>
			<div class="col-md-7 header-topic">
                <?php $phoneInfo    = HResponse::getAttribute('phone');?>
				<div class="col-md-7 txt-right">
					<label>联系电话</label><span>:<?php echo $phoneInfo['content'];?></span>
				</div>
				<div class="col-md-5 txt-right">
					<form class="form-inline">
					    <div class="form-group">
						      <div class="input-group">
						      <input type="text" class="form-control" id="exampleInputAmount" placeholder="搜索">
						      <div class="input-group-addon"><span class="glyphicon serbtn glyphicon-search" aria-hidden="true"></span></div>
						    </div>
					    </div>
					</form>
				</div>	
			</div>		
		</div>
	</div>
	<nav class="navbar navbar-default menu">
	  	<div class="container menu-con pd-0">
	    <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header ">
		      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		    </div>
		    <div class="collapse navbar-collapse pd-0" id="bs-example-navbar-collapse-1">
		        <ul class="nav navbar-nav">
                    <?php foreach(HResponse::getAttribute('navmenuList') as $item) { ?>
                    <li><a href="<?php echo HResponse::url($item['url']); ?>"> <?php echo $item['name'];?></a></li>
                    <?php }?>
		        </ul>
		    </div>
        </div>
    </nav>
