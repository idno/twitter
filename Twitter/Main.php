<?php

    namespace IdnoPlugins\Twitter {

        class Main extends \Idno\Common\Plugin {

            function registerPages() {
                // Register the callback URL
                    \Idno\Core\site()->addPageHandler('twitter/callback','\IdnoPlugins\Twitter\Pages\Callback');
                // Register admin settings
                    \Idno\Core\site()->addPageHandler('admin/twitter','\IdnoPlugins\Twitter\Pages\Admin');
                // Register settings page
                    \Idno\Core\site()->addPageHandler('account/twitter','\IdnoPlugins\Twitter\Pages\Account');

                /** Template extensions */
                // Add menu items to account & administration screens
                    \Idno\Core\site()->template()->extendTemplate('admin/menu/items','admin/twitter/menu');
                    \Idno\Core\site()->template()->extendTemplate('account/menu/items','account/twitter/menu');
            }

            function registerEventHooks() {
                // Push "notes" to Twitter
                \Idno\Core\site()->addEventHook('post/note',function(\Idno\Core\Event $event) {
                    if ($this->hasTwitter()) {
                        $object = $event->data()['object'];
                        $twitterAPI = $this->connect();
                        $status_full =  $object->getDescription();
                        $status =       strip_tags($status_full);
                        $params = array(
                            'status' => $status
                        );

                        // Find any Twitter status IDs in case we need to mark this as a reply to them
                        if (preg_match_all('/((ht|f)tps?:\/\/[^\s\r\n\t<>"\'\(\)]+)/i',$status_full,$matches)) {
                            foreach($matches as $match) {
                                if (parse_url($match[0], PHP_URL_HOST) == 'twitter.com') {
                                    preg_match('/[0-9]+/', $match[0], $status_matches);
                                    $params['in_reply_to_status_id'] = $status_matches[0];
                                }
                            }
                        }

                        $twitterAPI->request('POST', $twitterAPI->url('1.1/statuses/update'), $params);
                    }
                });

                // Push "articles" to Twitter
                \Idno\Core\site()->addEventHook('post/article',function(\Idno\Core\Event $event) {
                    if ($this->hasTwitter()) {
                        $object = $event->data()['object'];
                        $twitterAPI = $this->connect();
                        $status = $object->getTitle();
                        if (strlen($status) > 110) {                // Trim status down if required
                            $status = substr($status, 0, 106) . ' ...';
                        }
                        $status .= ' ' . $object->getURL();
                        $params = array(
                            'status' => $status
                        );

                        $twitterAPI->request('POST', $twitterAPI->url('1.1/statuses/update'), $params);
                    }
                });
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
                    $params = [
                        'consumer_key'    => \Idno\Core\site()->config()->twitter['consumer_key'],
                        'consumer_secret' => \Idno\Core\site()->config()->twitter['consumer_secret'],
                    ];
                    if (!empty(\Idno\Core\site()->session()->currentUser()->twitter)) {
                        $params = array_merge($params, \Idno\Core\site()->session()->currentUser()->twitter);
                    }
                    return new \tmhOAuth($params);
                }
                return false;
            }

            /**
             * Can the current user use Twitter?
             * @return bool
             */
            function hasTwitter() {
                if (\Idno\Core\site()->session()->currentUser()->twitter) {
                    return true;
                }
                return false;
            }

        }

    }