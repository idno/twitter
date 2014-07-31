<?php

    if ($twitter = \Idno\Core\site()->plugins()->get('Twitter')) {
        $login_url = $twitter->getAuthURL();
    }

?>
<div class="social">
    <a href="<?= $login_url ?>" class="connect tw <?php

        if (!empty(\Idno\Core\site()->session()->currentUser()->twitter)) {
            echo 'connected';
        }

    ?>">Twitter<?php

            if (!empty(\Idno\Core\site()->session()->currentUser()->twitter)) {
                echo ' - connected!';
            }

        ?></a>
    <label class="control-label">Share pictures, updates, and posts to Twitter.</label>
</div>