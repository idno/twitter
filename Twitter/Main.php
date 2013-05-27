<?php

    namespace IdnoPlugins\Twitter {

        class Main extends \Idno\Common\Plugin {

            function registerPages() {
                // Register the callback URL
                    \Idno\Core\site()->addPageHandler('twitter/callback','\IdnoPlugins\Twitter\Pages\Callback');
                // Register admin settings
                    \Idno\Core\site()->addPageHandler('admin/twitter','\IdnoPlugins\Twitter\Pages\Admin');

                /** Template extensions */
                // Add menu items to account & administration screens
                    \Idno\Core\site()->template()->extendTemplate('admin/menu/items','admin/twitter/menu');
                    \Idno\Core\site()->template()->extendTemplate('account/menu/items','account/twitter/menu');
            }

            /**
             * Returns a new Twitter OAuth connection object, if credentials have been added through administration
             * and it's possible to connect
             *
             * @return bool|\tmhOAuth
             */
            function connect() {
                require_once(dirname(__FILE__) . '/external/tmhOAuth/tmhOAuth.php');
                require_once(dirname(__FILE__) . '/external/tmhOAuth/tmhUtilities.php');
                if (!empty(\Idno\Core\site()->config()->twitter)) {
                    return new \tmhOAuth([
                        'consumer_key'    => \Idno\Core\site()->config()->twitter['consumer_key'],
                        'consumer_secret' => \Idno\Core\site()->config()->twitter['consumer_secret'],
                    ]);
                }
                return false;
            }

        }

    }