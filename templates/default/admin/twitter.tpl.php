<div class="row">

    <div class="span10 offset1">
        <h1>Twitter</h1>
        <?=$this->draw('admin/menu')?>
    </div>

</div>
<div class="row">
    <div class="span10 offset1">
        <form action="<?=\Idno\Core\site()->config()->getURL()?>admin/twitter/" class="form-horizontal" method="post">
            <div class="control-group">
                <div class="controls">
                    <p>
                        To begin using Twitter, <a href="https://dev.twitter.com/apps" target="_blank">create a new application in
                            the Twitter developer portal</a>.</p>
                    <p>
                        The callback URL should be set to:
                    </p>
                    <p>
                        <input type="text" name="ignore" class="span4" value="<?=\Idno\Core\site()->config()->url . 'twitter/callback'?>" />
                    </p>
                    <p>
                        Once you've finished, fill in the details below. You can then <a href="<?=\Idno\Core\site()->config()->getURL()?>account/twitter/">connect your Twitter account</a>.
                    </p>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="name">API key</label>
                <div class="controls">
                    <input type="text" id="name" placeholder="Consumer key" class="span4" name="consumer_key" value="<?=htmlspecialchars(\Idno\Core\site()->config()->twitter['consumer_key'])?>" >
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="name">API secret</label>
                <div class="controls">
                    <input type="text" id="name" placeholder="Consumer secret" class="span4" name="consumer_secret" value="<?=htmlspecialchars(\Idno\Core\site()->config()->twitter['consumer_secret'])?>" >
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
            <?= \Idno\Core\site()->actions()->signForm('/admin/twitter/')?>
        </form>
    </div>
</div>
