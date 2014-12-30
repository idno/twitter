<div class="row">

    <div class="span10 offset1">
        <?=$this->draw('account/menu')?>
        <h1>Twitter</h1>

    </div>

</div>
<div class="row">
    <div class="span10 offset1">
        <form action="/account/twitter/" class="form-horizontal" method="post">
            <?php
              if (empty(\Idno\Core\site()->session()->currentUser()->twitter)) {
            ?>
            <div class="control-group">
                <div class="controls-config">
	                <div class="row">
	                <div class="span6">
                    <p>
                        Easily share updates, posts, and pictures to Twitter. </p>
                        <p>
	                        With Twitter connected, you can cross-post content that you publish publicly on your site. 
                    </p>
	                </div>
	                </div>
                    
                    <div class="social span4">
				     <p>
                     <a href="<?= $vars['oauth_url'] ?>" class="connect tw">Connect Twitter</a>
                     </p>
					</div>
					

                </div>
            </div>
            <?php

              } else {

            ?>
                  <div class="control-group">
                      <div class="controls-config">
	                    <div class="row">
						<div class="span6">
                          <p>
                              Your account is currently connected to Twitter. Public content that you publish here
                              can be cross-posted to your Twitter account.
                          </p>
						</div>
						</div>
						<div class="social">
                          <p>
                              <input type="hidden" name="remove" value="1" />
                              <button type="submit" class="connect tw connected">Disconnect Twitter</button>
                          </p>
						</div>
                          
                      </div>
                  </div>

            <?php

              }
            ?>
            <?= \Idno\Core\site()->actions()->signForm('/account/twitter/')?>
        </form>
    </div>
</div>
