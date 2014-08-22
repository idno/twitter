<?php

    /**
     * Plugin administration
     */

    namespace IdnoPlugins\Twitter\Pages {

        /**
         * Default class to serve the homepage
         */
        class Auth extends \Idno\Common\Page
        {

            function getContent()
            {
                $this->gatekeeper(); // Logged-in users only
                if ($twitter = \Idno\Core\site()->plugins()->get('Twitter')) {
                    $login_url = $twitter->getAuthURL();
                    if (!empty($login_url)) {
                        $this->forward($login_url); exit;
                    }
                }
                $this->forward($_SERVER['HTTP_REFERER']);
            }

            function postContent() {
                $this->getContent();
            }

        }

    }