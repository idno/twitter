<div class="row">

    <div class="span10 offset1">
        <?=$this->draw('account/menu')?>
        <h1>Twitter</h1>

    </div>

</div>
<div class="row">
    <div class="span10 offset1">
    <?php

            if (!empty(\Idno\Core\site()->config()->twitter['consumer_key']) && !empty(\Idno\Core\site()->config()->twitter['consumer_secret'])) {

                ?>
        <form action="<?= \Idno\Core\site()->config()->getDisplayURL() ?>account/twitter/" class="form-horizontal" method="post">
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

                    
                    <div class="social span6">
				     <p>
                     <a href="<?= $vars['oauth_url'] ?>" class="connect tw">Connect Twitter</a>
                     </p>
					</div>
					

                </div>
            </div>
                </div>
            </div>
            
            <?php

				} else if (!\Idno\Core\site()->config()->multipleSyndicationAccounts()) {

            ?>
                  <div class="control-group">
                      <div class="controls-config">
	                    <div class="row">
						<div class="span6">
                          <p>
                              Your account is currently connected to Twitter. Public content that you publish here
                              can be cross-posted to your Twitter account.
                          </p>


						<div class="social span6">
                          <p>
                              <input type="hidden" name="remove" value="1" />
                              <button type="submit" class="connect tw connected">Disconnect Twitter</button>
                          </p>
						</div>
                          
                      </div>
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
							You have connected the below accounts to Twitter. Public content that you publish here
                              can be cross-posted to your Twitter account.
                          </p>

						<?php

                                        if ($accounts = \Idno\Core\site()->syndication()->getServiceAccounts('twitter')) {

                                            foreach ($accounts as $account) {

                                                ?>

                                                <div class="social span6">
                                                <p>
                                                    <input type="hidden" name="remove" value="<?= $account['username'] ?>"/>
                                                    <button type="submit"
                                                            class="connect tw connected">@<?= $account['username'] ?> (Disconnect)</button>
                                                </p>
                                                </div>
                                            <?php

                                            }

                                        }

                                    ?>
                                                
                          <p>
                                        <a href="<?= $vars['oauth_url'] ?>" class=""><icon class="icon-plus"></icon> Add another Twitter account</a>
                                    </p>
                      </div>
                  </div>
                      </div>
              		</div>

              <?php
              
              }
              
            ?>
            
            <?= \Idno\Core\site()->actions()->signForm('/account/twitter/')?>
            
        </form>
                    <?php

            } else {

                if (\Idno\Core\site()->session()->currentUser()->isAdmin()) {

                    ?>
                                  		<div class="control-group">
                      <div class="controls-config">
	                    <div class="row">
						<div class="span6">
                    <p>
                        Before you can begin connecting to Twitter, you need to set it up.
                    </p>
                    <p>
                        <a href="<?= \Idno\Core\site()->config()->getDisplayURL() ?>admin/twitter/">Click here to begin
                            Twitter configuration.</a>
                    </p>
                <?php

                } else {

                    ?>
                    <p>
                        The administrator has not finished setting up Twitter on this site.
                        Please come back later.
                    </p>
                    </div>
                    </div>
                    </div>
                    </div>
                
                <?php

                }

            }

        ?>
    </div>
</div>
