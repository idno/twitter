<div class="row">

    <div class="span10 offset1">
        <?=$this->draw('admin/menu')?>
        <h1>Twitter configuration</h1>

    </div>

</div>
<div class="row">
    <div class="span10 offset1">
        <form action="<?=\Idno\Core\site()->config()->getDisplayURL()?>admin/twitter/" class="form-horizontal" method="post">
            <div class="control-group">
                <div class="controls-config">
                    <p>
                        To begin using Twitter, <a href="https://dev.twitter.com/apps" target="_blank">create a new application in
                            the Twitter developer portal</a>.</p>
                    <p>
                        The callback URL should be set to:
                    </p>
                    <p>
                        <input type="text" name="ignore" class="span4" value="<?=\Idno\Core\site()->config()->url . 'twitter/callback'?>" />
                    </p>

                </div>
            </div>
                        
            <div class="control-group">
	                <p>
                        Once you've finished, fill in the details below:
                    </p>
                <label class="control-label" for="name">API key</label>
                <div class="controls">
                    <input type="text" id="name" placeholder="Consumer key" class="span6" name="consumer_key" value="<?=htmlspecialchars(\Idno\Core\site()->config()->twitter['consumer_key'])?>" >
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="name">API secret</label>
                <div class="controls">
                    <input type="text" id="name" placeholder="Consumer secret" class="span6" name="consumer_secret" value="<?=htmlspecialchars(\Idno\Core\site()->config()->twitter['consumer_secret'])?>" >
                </div>
                	            </div>
          <div class="control-group">
	          <p>
                        After the Twitter application is configured, you must connect under account Settings.
                    </p>

          </div>  
            
            <div class="control-group">
                <div class="controls-save">
                    <button type="submit" class="btn btn-primary">Save settings</button>
                </div>
            </div>
            <?= \Idno\Core\site()->actions()->signForm('/admin/twitter/')?>
        </form>
    </div>
</div>
