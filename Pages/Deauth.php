<?php

    /**
     * Plugin administration
     */

    namespace IdnoPlugins\Tumblr\Pages {

        /**
         * Default class to serve the homepage
         */
        class Deauth extends \Idno\Common\Page
        {

            function getContent()
            {
                $this->gatekeeper(); // Logged-in users only
                if ($tumblr = \Idno\Core\site()->plugins()->get('Tumblr')) {
                    if ($user = \Idno\Core\site()->session()->currentUser()) {
                        $user->tumblr = false;
                        $user->save();
                        \Idno\Core\site()->session()->refreshSessionUser($user);
                        if (!empty($user->link_callback)) {
                            error_log($user->link_callback);
                            $this->forward($user->link_callback); exit;
                        }
                    }
                }
                $this->forward($_SERVER['HTTP_REFERER']);
            }

            function postContent() {
                $this->getContent();
            }

        }

    }
