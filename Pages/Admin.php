<?php

    /**
     * Plugin administration
     */

    namespace IdnoPlugins\Twitter\Pages {

        /**
         * Default class to serve the homepage
         */
        class Admin extends \Idno\Common\Page
        {

            function getContent()
            {
                $this->adminGatekeeper(); // Admins only
                $t = \Idno\Core\site()->template();
                $body = $t->draw('admin/twitter');
                $t->__(array('title' => 'Twitter', 'body' => $body))->drawPage();
            }

            function postContent() {
                $this->adminGatekeeper(); // Admins only
                $consumer_key = trim($this->getInput('consumer_key'));
                $consumer_secret = trim($this->getInput('consumer_secret'));
                \Idno\Core\site()->config->config['twitter'] = array(
                    'consumer_key' => $consumer_key,
                    'consumer_secret' => $consumer_secret
                );
                \Idno\Core\site()->config()->save();
                \Idno\Core\site()->session()->addMessage(\Idno\Core\Idno::site()->language()->_('Your Twitter application details were saved.'));
                $this->forward(\Idno\Core\site()->config()->getDisplayURL() . 'admin/twitter/');
            }

        }

    }