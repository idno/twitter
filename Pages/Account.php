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
                    $twitterAPI = $twitter->connect();
                    $code = $twitterAPI->request('POST', $twitterAPI->url('oauth/request_token', ''), array('oauth_callback' => \Idno\Core\site()->config()->url . 'twitter/callback','x_auth_access_type' => 'write'));
                    if ($code == 200) {
                        $oauth = $twitterAPI->extract_params($twitterAPI->response['response']);
                        \Idno\Core\site()->session()->set('oauth',$oauth); // Save OAuth to the session
                        $oauth_url = $twitterAPI->url("oauth/authorize", '') .  "?oauth_token={$oauth['oauth_token']}";
                    } else {
                        $oauth_url = '';
                    }
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