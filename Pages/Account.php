<?php

    /**
     * Plugin administration
     */

    namespace IdnoPlugins\Twitter\Pages {

        /**
         * Default class to serve the homepage
         */
        class Account extends \Idno\Common\Page
        {

            function getContent()
            {
                $this->gatekeeper(); // Logged-in users only
                if ($twitter = \Idno\Core\site()->plugins()->get('Twitter')) {
                    $oauth_url = $twitter->getAuthURL();
                }
                $t = \Idno\Core\site()->template();
                $body = $t->__(['oauth_url' => $oauth_url])->draw('account/twitter');
                $t->__(['title' => 'Twitter', 'body' => $body])->drawPage();
            }

            function postContent() {
                $this->gatekeeper(); // Logged-in users only
                if (($this->getInput('remove'))) {
                    $user = \Idno\Core\site()->session()->currentUser();
                    $user->twitter = [];
                    $user->save();
                    \Idno\Core\site()->session()->addMessage('Your Twitter settings have been removed from your account.');
                }
                $this->forward('/account/twitter/');
            }

        }

    }