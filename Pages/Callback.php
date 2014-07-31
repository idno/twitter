<?php

    /**
     * Plugin administration
     */

    namespace IdnoPlugins\Twitter\Pages {

        /**
         * Default class to serve the homepage
         */
        class Callback extends \Idno\Common\Page
        {

            function getContent()
            {
                $this->gatekeeper(); // Logged-in users only
                if ($token = $this->getInput('oauth_token')) {
                    if ($twitter = \Idno\Core\site()->plugins()->get('Twitter')) {
                        $twitterAPI = $twitter->connect();
                        $twitterAPI->config['user_token'] = \idno\Core\site()->session()->get('oauth')['oauth_token'];
                        $twitterAPI->config['user_secret'] = \idno\Core\site()->session()->get('oauth')['oauth_token_secret'];
                        $code = $twitterAPI->request('POST', $twitterAPI->url('oauth/access_token', ''), array(
                            'oauth_verifier' => $this->getInput('oauth_verifier')
                        ));
                        if ($code == 200) {
                            $access_token = $twitterAPI->extract_params($twitterAPI->response['response']);
                            \Idno\Core\site()->session()->remove('oauth');
                            $user = \Idno\Core\site()->session()->currentUser();
                            $user->twitter = ['user_token' => $access_token['oauth_token'], 'user_secret' => $access_token['oauth_token_secret'], 'screen_name' => $access_token['screen_name']];
                            $user->save();
                            \Idno\Core\site()->session()->addMessage('Your Twitter credentials were saved.');
                        }
                        else {
                            \Idno\Core\site()->session()->addMessage('Your Twitter credentials could not be saved.');
                        }
                        if (!empty($_SESSION['onboarding_passthrough'])) {
                            unset($_SESSION['onboarding_passthrough']);
                            $this->forward(\Idno\Core\site()->config()->getURL() . 'begin/connect');
                        }
                        $this->forward('/account/twitter');
                    }
                }
            }

        }

    }