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
                /*if ($twitter = \Idno\Core\site()->plugins()->get('Twitter')) {
                    $oauth_url = $twitter->getAuthURL();
                }*/
                $oauth_url = \Idno\Core\site()->config()->getDisplayURL() . 'twitter/auth';
                $t = \Idno\Core\site()->template();
                $body = $t->__(array('oauth_url' => $oauth_url))->draw('account/twitter');
                $t->__(array('title' => 'Twitter', 'body' => $body))->drawPage();
            }

            function postContent() {
                $this->gatekeeper(); // Logged-in users only
                if (($this->getInput('remove'))) {
                    $rm = $this->getInput('remove');
                    $user = \Idno\Core\site()->session()->currentUser();
                    if($rm === '1') {
                        $user->twitter = array();    // wipes all credentials
                    } else {
                        unset($user->twitter[$rm]);  // wipes specific credentials
                    }
                    $user->save();
                    \Idno\Core\site()->session()->addMessage(\Idno\Core\Idno::site()->language()->_('Your Twitter settings have been removed from your account.'));
                }
                $this->forward(\Idno\Core\site()->config()->getDisplayURL() . 'account/twitter/');
            }

        }

    }
