<?php

    namespace IdnoPlugins\Review {

        class ContentType extends \Idno\Common\ContentType {

            public $title = 'Review';
            public $category_title = 'Reviews';
            public $entity_class = 'IdnoPlugins\\Review\\Review';
            public $logo = '<i class="icon-align-left"></i>';
            public $indieWebContentType = array('article','review');

        }

    }
