<?php

    namespace IdnoPlugins\Twitter {

        class Main extends \Idno\Common\Plugin
        {

            function registerPages()
            {
                // Register the callback URL
                \Idno\Core\site()->addPageHandler('twitter/callback', '\IdnoPlugins\Twitter\Pages\Callback');
                // Register admin settings
                \Idno\Core\site()->addPageHandler('admin/twitter', '\IdnoPlugins\Twitter\Pages\Admin');
                // Register settings page
                \Idno\Core\site()->addPageHandler('account/twitter', '\IdnoPlugins\Twitter\Pages\Account');

                /** Template extensions */
                // Add menu items to account & administration screens
                \Idno\Core\site()->template()->extendTemplate('admin/menu/items', 'admin/twitter/menu');
                \Idno\Core\site()->template()->extendTemplate('account/menu/items', 'account/twitter/menu');
                \Idno\Core\site()->template()->extendTemplate('onboarding/connect/networks','onboarding/connect/twitter');
            }

            function registerEventHooks()
            {

                \Idno\Core\site()->syndication()->registerService('twitter', function() {
                    return $this->hasTwitter();
                }, ['note','article','image','media']);

                // Push "notes" to Twitter
                \Idno\Core\site()->addEventHook('post/note/twitter', function (\Idno\Core\Event $event) {
                    if ($this->hasTwitter()) {
                        $object      = $event->data()['object'];
                        $twitterAPI  = $this->connect();
                        $status_full = $object->getDescription();
                        $status      = preg_replace('/<[^\>]*>/', '', $status_full); //strip_tags($status_full);

                        // Add link to original post, if IndieWeb references have been requested
                        if (!substr_count($status, \Idno\Core\site()->config()->host) && \Idno\Core\site()->config()->indieweb_reference) {
                            $status .= ' ' . $object->getShortURL();
                        }

                        // Get links at this stage
                        preg_match_all('/((ht|f)tps?:\/\/[^\s\r\n\t<>"\'\(\)]+)/i', $status_full, $matches);

                        global $url_matches; // ugh
                        preg_match_all('/((ht|f)tps?:\/\/[^\s\r\n\t<>"\'\(\)]+)/i', $status, $url_matches);

                        $count_status = preg_replace('/((ht|f)tps?:\/\/[^\s\r\n\t<>"\'\(\)]+)/i', '12345678901234567890123', $status);

                        if (strlen($count_status) > 140) {
                            $count_status = substr($count_status, 0, 115);
                            if ($count_status[strlen($count_status) - 1] != ' ') {
                                $count_status = substr($count_status, 0, strrpos($count_status, ' '));
                            }
                            $count_status = preg_replace_callback('/12345678901234567890123/', function ($callback) {
                                global $status_update_url_num; // Ugh
                                global $url_matches; // Ugh ugh
                                if (empty($status_update_url_num)) {
                                    $status_update_url_num = 0;
                                }
                                if (!empty($url_matches[0][$status_update_url_num])) {
                                    return $url_matches[0][$status_update_url_num];
                                }
                                $status_update_url_num++;

                                return '';
                            }, $count_status);
                            $count_status .= ' .. ' . $object->getURL();
                            $status = $count_status;
                        }

                        $status = preg_replace('/[ ]{2,}/',' ',$status);

                        $params = array(
                            'status' => $status
                        );

                        // Find any Twitter status IDs in case we need to mark this as a reply to them
                        if (!empty($matches[0])) {
                            foreach ($matches[0] as $match) {
                                if (parse_url($match, PHP_URL_HOST) == 'twitter.com') {
                                    preg_match('/[0-9]+/', $match, $status_matches);
                                    $params['in_reply_to_status_id'] = $status_matches[0];
                                }
                            }
                        }

                        $response = $twitterAPI->request('POST', $twitterAPI->url('1.1/statuses/update'), $params);
                        error_log(var_export($response, true));
                        if (!empty($twitterAPI->response['response'])) {
                            if ($json = json_decode($twitterAPI->response['response'])) {
                                if (!empty($json->id_str)) {
                                    $object->setPosseLink('twitter', 'https://twitter.com/' . $json->user->screen_name . '/status/' . $json->id_str);
                                    $object->save();
                                }
                            }
                        }
                    }
                });

                // Push "articles" to Twitter
                \Idno\Core\site()->addEventHook('post/article/twitter', function (\Idno\Core\Event $event) {
                    if ($this->hasTwitter()) {
                        $object     = $event->data()['object'];
                        $twitterAPI = $this->connect();
                        $status     = $object->getTitle();
                        if (strlen($status) > 110) { // Trim status down if required
                            $status = substr($status, 0, 106) . ' ...';
                        }
                        $status .= ' ' . $object->getURL();
                        $params = array(
                            'status' => $status
                        );

                        $response = $twitterAPI->request('POST', $twitterAPI->url('1.1/statuses/update'), $params);

                        if (!empty($twitterAPI->response['response'])) {
                            if ($json = json_decode($twitterAPI->response['response'])) {
                                if (!empty($json->id_str)) {
                                    $object->setPosseLink('twitter', 'https://twitter.com/' . $json->user->screen_name . '/status/' . $json->id_str);
                                    $object->save();
                                }
                            }
                        }

                    }
                });

                // Push "media" to Twitter
                \Idno\Core\site()->addEventHook('post/media/twitter', function (\Idno\Core\Event $event) {
                    if ($this->hasTwitter()) {
                        $object     = $event->data()['object'];
                        $twitterAPI = $this->connect();
                        $status     = $object->getTitle();
                        if (strlen($status) > 110) { // Trim status down if required
                            $status = substr($status, 0, 106) . ' ...';
                        }
                        $status .= ' ' . $object->getURL();
                        $params = array(
                            'status' => $status
                        );

                        $response = $twitterAPI->request('POST', $twitterAPI->url('1.1/statuses/update'), $params);

                        if (!empty($twitterAPI->response['response'])) {
                            if ($json = json_decode($twitterAPI->response['response'])) {
                                if (!empty($json->id_str)) {
                                    $object->setPosseLink('twitter', 'https://twitter.com/' . $json->user->screen_name . '/status/' . $json->id_str);
                                    $object->save();
                                }
                            }
                        }

                    }
                });

                // Push "images" to Twitter
                \Idno\Core\site()->addEventHook('post/image/twitter', function (\Idno\Core\Event $event) {
                    if ($this->hasTwitter()) {
                        $object     = $event->data()['object'];
                        $twitterAPI = $this->connect();
                        $status     = $object->getTitle();
                        if (strlen($status) > 110) { // Trim status down if required
                            $status = substr($status, 0, 106) . ' ...';
                        }

                        // Let's first try getting the thumbnail
                        if (!empty($object->thumbnail_id)) {
                            if ($thumb = (array)\Idno\Entities\File::getByID($object->thumbnail_id)) {
                                $attachments = array($thumb['file']);
                            }
                        }

                        // No? Then we'll use the main event
                        if (empty($attachments)) {
                            $attachments = $object->getAttachments();
                        }

                        if (!empty($attachments)) {
                            foreach ($attachments as $attachment) {
                                if ($bytes = \Idno\Entities\File::getFileDataFromAttachment($attachment)) {
                                    $media    = '';
                                    $filename = tempnam(sys_get_temp_dir(), 'idnotwitter');
                                    file_put_contents($filename, $bytes);
                                    $media .= "@{$filename};type=" . $attachment['mime_type'] . ';filename=' . $attachment['filename'];
                                }
                            }
                        }

                        $params = array(
                            'status'  => $status,
                            'media[]' => $media
                        );

                        $response = $twitterAPI->request('POST', $twitterAPI->url('1.1/statuses/update_with_media'), $params, true, true);
                        /*$code = $twitterAPI->request( 'POST','https://upload.twitter.com/1.1/statuses/update_with_media',
                            $params,
                            true, // use auth
                            true  // multipart
                        );*/

                        @unlink($filename);

                        error_log(var_export($twitterAPI->response['response'], true));
                        if (!empty($twitterAPI->response['response'])) {
                            if ($json = json_decode($twitterAPI->response['response'])) {
                                if (!empty($json->id_str)) {
                                    $object->setPosseLink('twitter', 'https://twitter.com/' . $json->user->screen_name . '/status/' . $json->id_str);
                                    $object->save();
                                }
                            }
                        }

                    }
                });
            }

            /**
             * Retrieve the OAuth authentication URL for the API
             * @return string
             */
            function getAuthURL() {
                $twitter = $this;
                $twitterAPI = $twitter->connect();
                $code = $twitterAPI->request('POST', $twitterAPI->url('oauth/request_token', ''), array('oauth_callback' => \Idno\Core\site()->config()->url . 'twitter/callback','x_auth_access_type' => 'write'));
                if ($code == 200) {
                    $oauth = $twitterAPI->extract_params($twitterAPI->response['response']);
                    \Idno\Core\site()->session()->set('oauth',$oauth); // Save OAuth to the session
                    $oauth_url = $twitterAPI->url("oauth/authorize", '') .  "?oauth_token={$oauth['oauth_token']}";
                } else {
                    $oauth_url = '';
                }
                return $oauth_url;
            }

            /**
             * Returns a new Twitter OAuth connection object, if credentials have been added through administration
             * and it's possible to connect
             *
             * @return bool|\tmhOAuth
             */
            function connect()
            {
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
            function hasTwitter()
            {
                if (\Idno\Core\site()->session()->currentUser()->twitter) {
                    return true;
                }

                return false;
            }

        }

    }
