<?php

    namespace IdnoPlugins\Review {

        use Idno\Core\Autosave;

        class Review extends \Idno\Common\Entity
        {

            function getTitle()
            {
                if (empty($this->title)) return 'Untitled';

                return $this->title;
            }

            function getDescription()
            {
                if (!empty($this->body)) return $this->body;

                return '';
            }

            function getRating()
            {
                if (!empty($this->rating)) return $this->rating;

                return '';
            }

            function getProductCategory()
            {
                if (!empty($this->productCategory)) return $this->productCategory;

                return '';
            }
            
            function getProductName()
            {
                if (!empty($this->productName)) return $this->productName;

                return '';
            }
 
            function getProductLink()
            {
                if (!empty($this->productLink)) return $this->productLink;

                return '';
            }

            function getURL()
            {

                // If we have a URL override, use it
                if (!empty($this->url)) {
                    return $this->url;
                }

                if (!empty($this->canonical)) {
                    return $this->canonical;
                }

                if (!$this->getSlug() && ($this->getID())) {
                    return \Idno\Core\site()->config()->url . 'review/' . $this->getID() . '/' . $this->getPrettyURLTitle();
                } else {
                    return parent::getURL();
                }

            }

            /**
             * Review objects have type 'article'
             * @return 'article'
             */
            function getActivityStreamsObjectType()
            {
                return 'article';
            }

            
            /**
             * Review objects show up as h-review in a Microformats stream
             * @return string
             */
            function getMicroformats2ObjectType() {
                return 'h-review';
            }

            /**
             * Retrieve icon
             * @return mixed|string
             */
            function getIcon()
            {
                $xpath = new \DOMXPath(@\DOMDocument::loadHTML($this->getDescription()));
                $src   = $xpath->evaluate("string(//img/@src)");
                if (!empty($src)) {
                    return $src;
                }

                return parent::getIcon();
            }
            
            function getMetadataForFeed()
            {
                return array(
                    'type' => 'review',
                    'rating' => $this->getRating() . '/5',
                    'product-name' => $this->getProductName(),
                    'product-category' => $this->getProductCategory(),
                    'product-link' => $this->getProductLink()
                );
            }

            function saveDataFromInput()
            {

                if (empty($this->_id)) {
                    $new = true;
                } else {
                    $new = false;
                }
                $body = \Idno\Core\site()->currentPage()->getInput('body');
                if (!empty($body)) {

                    $this->body            = $body;
                    $this->title           = \Idno\Core\site()->currentPage()->getInput('title');
                    $this->rating          = \Idno\Core\site()->currentPage()->getInput('rating');
                    $this->productName     = \Idno\Core\site()->currentPage()->getInput('productName');
                    $this->productCategory = \Idno\Core\site()->currentPage()->getInput('productCategory');
                    $this->productLink     = \Idno\Core\site()->currentPage()->getInput('productLink');
                    $access                = \Idno\Core\site()->currentPage()->getInput('access');
                    $this->setAccess($access);

                    if ($time = \Idno\Core\site()->currentPage()->getInput('created')) {
                        if ($time = strtotime($time)) {
                            $this->created = $time;
                        }
                    }
    
                    if ($new) {
                        if (!empty($_FILES['photo']['tmp_name'])) {
                            if (\Idno\Entities\File::isImage($_FILES['photo']['tmp_name'])) {
                                
                                // Extract exif data so we can rotate
                                if (is_callable('exif_read_data') && $_FILES['photo']['type'] == 'image/jpeg') {
                                    try {
                                        if (function_exists('exif_read_data')) {
                                            if ($exif = exif_read_data($_FILES['photo']['tmp_name'])) {
                                                $this->exif = base64_encode(serialize($exif)); // Yes, this is rough, but exif contains binary data that can not be saved in mongo
                                            }
                                        }
                                    } catch (\Exception $e) {
                                        $exif = false;
                                    }
                                } else {
                                    $exif = false;
                                }
                                
                                if ($photo = \Idno\Entities\File::createFromFile($_FILES['photo']['tmp_name'], $_FILES['photo']['name'], $_FILES['photo']['type'], true, true)) {
                                    $this->attachFile($photo);

                                    // Now get some smaller thumbnails, with the option to override sizes
                                    $sizes = \Idno\Core\site()->events()->dispatch('photo/thumbnail/getsizes', new \Idno\Core\Event(array('sizes' => array('large' => 800, 'medium' => 400, 'small' => 200))));
                                    $eventdata = $sizes->data();
                                    foreach ($eventdata['sizes'] as $label => $size) {

                                        $filename = $_FILES['photo']['name'];

                                        if ($thumbnail = \Idno\Entities\File::createThumbnailFromFile($_FILES['photo']['tmp_name'], "{$filename}_{$label}", $size, false)) {
                                            $varname        = "thumbnail_{$label}";
                                            $this->$varname = \Idno\Core\site()->config()->url . 'file/' . $thumbnail;

                                            $varname        = "thumbnail_{$label}_id";
                                            $this->$varname = substr($thumbnail, 0, strpos($thumbnail, '/'));
                                        }
                                    }
                                }
                            } else {
                                \Idno\Core\site()->session()->addErrorMessage('This doesn\'t seem to be an image ..');
                            }
                        }
                    }

                    if ($this->save($new)) {

                        $autosave = new Autosave();
                        $autosave->clearContext('review');

                        \Idno\Core\Webmention::pingMentions($this->getURL(), \Idno\Core\site()->template()->parseURLs($this->getTitle() . ' ' . $this->getDescription()));

                        return true;
                    }
                } else {
                    \Idno\Core\site()->session()->addErrorMessage('You can\'t save an empty entry.');
                }

                return false;
            }

            function deleteData()
            {
                \Idno\Core\Webmention::pingMentions($this->getURL(), \Idno\Core\site()->template()->parseURLs($this->getTitle() . ' ' . $this->getDescription()));
            }

        }

    }
