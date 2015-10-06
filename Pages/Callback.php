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

            function get($params = array())
            {
                $this->gatekeeper(); // Logged-in users only
                if ($token = $this->getInput('oauth_token')) {
                    if ($twitter = \Idno\Core\site()->plugins()->get('Twitter')) {
                        $twitterAPI = $twitter->connect();
                        $twitterAPI->config['user_token'] = \idno\Core\site()->session()->get('oauth')['oauth_token'];
                        $twitterAPI->config['user_secret'] = \idno\Core\site()->session()->get('oauth')['oauth_token_secret'];

                        $decoded = urldecode($this->getInput('oauth_verifier'));

                        if (!mb_check_encoding($decoded, 'UTF-8')) {
                            $decoded = utf8_encode($decoded);
                        }

                        $code = $twitterAPI->request('POST', $twitterAPI->url('oauth/access_token', ''), array(
                            'oauth_verifier' => urldecode($decoded)
                        ));
                        if ($code == 200) {
                            $access_token = $twitterAPI->extract_params($twitterAPI->response['response']);
                            \Idno\Core\site()->session()->remove('oauth');
                            $user = \Idno\Core\site()->session()->currentUser();
                            \Idno\Core\site()->syndication()->registerServiceAccount('twitter', $access_token['screen_name'], '@' . $access_token['screen_name']);
                            $user->twitter[$access_token['screen_name']] = array('user_token' => $access_token['oauth_token'], 'user_secret' => $access_token['oauth_token_secret'], 'screen_name' => $access_token['screen_name']);
                            $user->save();
                            \Idno\Core\site()->session()->addMessage('Your Twitter credentials were saved.');
                        }
                        else {
                            \Idno\Core\site()->session()->addErrorMessage('Your Twitter credentials could not be saved.');
                        }

                        if (!empty($_SESSION['onboarding_passthrough'])) {
                            unset($_SESSION['onboarding_passthrough']);
                            $this->forward(\Idno\Core\site()->config()->getDisplayURL() . 'begin/connect-forwarder');
                        }
                        $this->forward(\Idno\Core\site()->config()->getDisplayURL() . 'account/twitter');
                    }
                }
            }

        }

    }
