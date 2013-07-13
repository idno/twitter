<div class="row">

    <div class="span10 offset1">
        <h3>Twitter</h3>
        <?=$this->draw('account/menu')?>
    </div>

</div>
<div class="row">
    <div class="span10 offset1">
        <form action="/account/twitter/" class="form-horizontal" method="post">
            <?php
              if (empty(\Idno\Core\site()->session()->currentUser()->twitter)) {
            ?>
            <div class="control-group">
                <div class="controls">
                    <p>
                        If you have a Twitter account, you may connect it here. Public content that you
                        post to this site will be automatically cross-posted to your Twitter account.
                    </p>
                    <p>
                        <a href="<?=$vars['oauth_url']?>" class="btn btn-large btn-success">Click here to connect Twitter to your account</a>
                    </p>
                </div>
            </div>
            <?php

              } else {

            ?>
                  <div class="control-group">
                      <div class="controls">
                          <p>
                              Your account is currently connected to Twitter. Public content that you post here
                              will be shared with your Twitter account.
                          </p>
                          <p>
                              <input type="hidden" name="remove" value="1" />
                              <button type="submit" class="btn-primary">Click here to remove Twitter from your account.</button>
                          </p>
                      </div>
                  </div>

            <?php

              }
            ?>
            <?= \Idno\Core\site()->actions()->signForm('/account/twitter/')?>
        </form>
    </div>
</div>