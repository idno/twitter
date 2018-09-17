<div class="row">

    <div class="col-md-10 col-md-offset-1">
        <?=$this->draw('account/menu')?>
        <h1>Twitter</h1>

    </div>

</div>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
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
	                <div class="col-md-7">
                    <p>
                        <?= \Idno\Core\Idno::site()->language()->_('Easily share updates, posts, and pictures to Twitter.'); ?> </p>
                    <p>
	                        <?= \Idno\Core\Idno::site()->language()->_('With Twitter connected, you can cross-post content that you publish publicly on your site.'); ?>
                    </p>

                    
                    <div class="social">
				     <p>
                     <a href="<?= $vars['oauth_url'] ?>" class="tw connect"><i class="fab fa-twitter"></i>
 <?= \Idno\Core\Idno::site()->language()->_('Connect Twitter'); ?></a>
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
						<div class="col-md-7">
                          <p>
                              <?= \Idno\Core\Idno::site()->language()->_('Your account is currently connected to Twitter. Public content that you publish here can be cross-posted to your Twitter account.'); ?>
                          </p>


						<div class="social">
                          <p>
                              <input type="hidden" name="remove" value="1" class="form-control" />
                              <button type="submit" class="tw connect connected"><i class="fab fa-twitter"></i>
 <?= \Idno\Core\Idno::site()->language()->_('Disconnect Twitter'); ?></button>
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
						<div class="col-md-7">
                          <p>
			    <?= \Idno\Core\Idno::site()->language()->_('You have connected the below accounts to Twitter. Public content that you publish here can be cross-posted to your Twitter account.'); ?>
                          </p>

						<?php

                                        if ($accounts = \Idno\Core\site()->syndication()->getServiceAccounts('twitter')) {

                                            foreach ($accounts as $account) {

                                                ?>

                                                <div class="social">
                                                <p>
                                                    <input type="hidden" name="remove" class="form-control" value="<?= $account['username'] ?>"/>
                                                    <button type="submit"
                                                            class="tw connect connected"><i class="fab fa-twitter"></i>
 @<?= $account['username'] ?> (<?= \Idno\Core\Idno::site()->language()->_('Disconnect'); ?>)</button>
                                                </p>
                                                </div>
                                            <?php

                                            }

                                        }

                                    ?>
                                                
                          <p>
                                        <a href="<?= $vars['oauth_url'] ?>" class=""><i class="fa fa-plus"></i> <?= \Idno\Core\Idno::site()->language()->_('Add another Twitter account'); ?></a>
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
						<div class="col-md-7">
                    <p>
                        <?= \Idno\Core\Idno::site()->language()->_('Before you can begin connecting to Twitter, you need to set it up.'); ?>
                    </p>
                    <p>
                        <a href="<?= \Idno\Core\site()->config()->getDisplayURL() ?>admin/twitter/"><?= \Idno\Core\Idno::site()->language()->_('Click here to begin Twitter configuration.'); ?></a>
                    </p>
                <?php

                } else {

                    ?>
                    <p>
                        <?= \Idno\Core\Idno::site()->language()->_('The administrator has not finished setting up Twitter on this site. Please come back later.'); ?>
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
