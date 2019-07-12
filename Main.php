<?php

    namespace IdnoPlugins\Review {

        class Main extends \Idno\Common\Plugin {

            function registerPages() {
                \Idno\Core\site()->routes()->addRoute('/review/edit/?', '\IdnoPlugins\Review\Pages\Edit');
                \Idno\Core\site()->routes()->addRoute('/review/edit/([A-Za-z0-9]+)/?', '\IdnoPlugins\Review\Pages\Edit');
                \Idno\Core\site()->routes()->addRoute('/review/delete/([A-Za-z0-9]+)/?', '\IdnoPlugins\Review\Pages\Delete');
                \Idno\Core\site()->routes()->addRoute('/review/([A-Za-z0-9]+)/.*', '\Idno\Pages\Entity\View');
            }

            /**
             * Get the total file usage
             * @param bool $user
             * @return int
             */
            function getFileUsage($user = false) {

                $total = 0;

                if (!empty($user)) {
                    $search = ['user' => $user];
                } else {
                    $search = [];
                }

                if ($reviews = review::get($search,[],9999,0)) {
                    foreach($reviews as $review) {
                        /* @var review $review */
                        if ($review instanceof review) {
                            if ($attachments = $review->getAttachments()) {
                                foreach($attachments as $attachment) {
                                    $total += $attachment['length'];
                                }
                            }
                        }
                    }
                }

                return $total;
            }

        }

    }
