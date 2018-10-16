<div class="row">

    <div class="col-md-10 col-md-offset-1">
        <?=$this->draw('admin/menu')?>
        <h1><?= \Idno\Core\Idno::site()->language()->_('Twitter configuration'); ?></h1>

    </div>

</div>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <form action="<?=\Idno\Core\site()->config()->getDisplayURL()?>admin/twitter/" class="form-horizontal" method="post">
            <div class="controls-group">
                <div class="controls-config">
                    <p>
                        <?= \Idno\Core\Idno::site()->language()->_('To begin using Twitter, <a href="https://dev.twitter.com/apps" target="_blank">create a new application in the Twitter developer portal</a>'); ?>.</p>
                    <p>
                        <?= \Idno\Core\Idno::site()->language()->_('The callback URL should be set to:'); ?>
                    </p>
                    <p>
                        <input type="text" name="ignore" class="form-control" value="<?=\Idno\Core\site()->config()->url . 'twitter/callback'?>" />
                    </p>

                </div>
            </div>
 
                        
            <div class="controls-group">
	                <p>
                        <?= \Idno\Core\Idno::site()->language()->_('Once you\'ve finished, fill in the details below:'); ?>
                    </p>
                <label class="control-label" for="api-key"><?= \Idno\Core\Idno::site()->language()->_('API key'); ?></label>

                    <input type="text" id="api-key" placeholder="Consumer key" class="form-control" name="consumer_key" value="<?=htmlspecialchars(\Idno\Core\site()->config()->twitter['consumer_key'])?>" >


            
                <label class="control-label" for="api-secret"><?= \Idno\Core\Idno::site()->language()->_('API secret'); ?></label>

                    <input type="text" id="api-secret" placeholder="Consumer secret" class="form-control" name="consumer_secret" value="<?=htmlspecialchars(\Idno\Core\site()->config()->twitter['consumer_secret'])?>" >
   
            </div>   
            
          <div class="controls-group">
	          <p>
                        <?= \Idno\Core\Idno::site()->language()->_('After the Twitter application is configured, site users must authenticate their Twitter account under Settings.'); ?>
                    </p>

          </div>  
            
            <div>
                <div class="controls-save">
                    <button type="submit" class="btn btn-primary"><?= \Idno\Core\Idno::site()->language()->_('Save settings'); ?></button>
                </div>
            </div>
            <?= \Idno\Core\site()->actions()->signForm('/admin/twitter/')?>
        </form>
    </div>
</div>
