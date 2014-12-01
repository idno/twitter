<div class="row">

    <div class="span10 offset1">
        <h1>Twitter</h1>
        <?= $this->draw('account/menu') ?>
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
                                <div class="controls">
                                    <p>
                                        If you have a Twitter account, you may connect it here. Public content that you
                                        post to this site will be automatically cross-posted to your Twitter account.
                                    </p>

                                    <p>
                                        <a href="<?= $vars['oauth_url'] ?>" class="btn btn-large btn-success">Click here
                                            to connect Twitter to your account</a>
                                    </p>
                                </div>
                            </div>
                        <?php

                        } else if (!\Idno\Core\site()->config()->multipleSyndicationAccounts()) {

                            ?>
                            <div class="control-group">
                                <div class="controls">
                                    <p>
                                        Your account is currently connected to Twitter. Public content that you post
                                        here
                                        will be shared with your Twitter account.
                                    </p>

                                    <p>
                                        <input type="hidden" name="remove" value="1"/>
                                        <button type="submit" class="btn btn-primary">Click here to remove Twitter from
                                            your account.
                                        </button>
                                    </p>
                                </div>
                            </div>

                        <?php

                        } else {

                            ?>
                            <div class="control-group">
                                <div class="controls">
                                    <p class="explanation">
                                        You have connected the following accounts to Twitter:
                                    </p>
                                    <?php

                                        if ($accounts = \Idno\Core\site()->syndication()->getServiceAccounts('twitter')) {

                                            foreach ($accounts as $account) {

                                                ?>
                                                <p>
                                                    <input type="hidden" name="remove" value="<?= $account['username'] ?>"/>
                                                    <button type="submit"
                                                            class="btn btn-primary">@<?= $account['username'] ?></button>
                                                </p>
                                            <?php

                                            }

                                        }

                                    ?>
                                    <p>
                                        <a href="<?= $vars['oauth_url'] ?>" class="">Click here
                                            to connect another Twitter account</a>
                                    </p>
                                </div>
                            </div>
                        <?php

                        }
                    ?>
                    <?= \Idno\Core\site()->actions()->signForm('/account/twitter/') ?>
                </form>
            <?php

            } else {

                if (\Idno\Core\site()->session()->currentUser()->isAdmin()) {

                    ?>
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
                <?php

                }

            }

        ?>
    </div>
</div>
