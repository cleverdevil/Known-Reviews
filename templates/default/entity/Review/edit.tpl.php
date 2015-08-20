<?= $this->draw('entity/edit/header'); ?>
<?php

    $autosave = new \Idno\Core\Autosave();
    if (!empty($vars['object']->body)) {
        $body = $vars['object']->body;
    } else {
        $body = $autosave->getValue('review', 'bodyautosave');
    }
    if (!empty($vars['object']->title)) {
        $title = $vars['object']->title;
    } else {
        $title = $autosave->getValue('review', 'title');
    }
    if (!empty($vars['object']->rating)) {
        $rating = $vars['object']->rating;
    } else {
        $rating = $autosave->getValue('review', 'rating');
    }
    if (!empty($vars['object']->productName)) {
        $productName = $vars['object']->productName;
    } else {
        $productName = $autosave->getValue('review', 'productName');
    }
    if (!empty($vars['object']->productCategory)) {
        $productCategory = $vars['object']->productCategory;
    } else {
        $productCategory = $autosave->getValue('review', 'productCategory');
    }
    if (!empty($vars['object']->productLink)) {
        $productLink = $vars['object']->productLink;
    } else {
        $productLink = $autosave->getValue('review', 'productLink');
    }
    if (!empty($vars['object'])) {
        $object = $vars['object'];
    } else {
        $object = false;
    }

    /* @var \Idno\Core\Template $this */

?>
    <form action="<?= $vars['object']->getURL() ?>" method="post" enctype="multipart/form-data">

        <div class="row">

            <div class="col-md-8 col-md-offset-2 edit-pane">


                <?php

                    if (empty($vars['object']->_id)) {

                        ?>
                        <h4>New Review</h4>
                    <?php

                    } else {

                        ?>
                        <h4>Edit Review</h4>
                    <?php

                    }

                ?>

                <?php

                    if (empty($vars['object']->_id)) {

                        ?>
                        <div id="photo-preview"></div>
                        <p>
                                <span class="btn btn-primary btn-file">
                                        <i class="fa fa-camera"></i> <span
                                        id="photo-filename">Select a photo</span> <input type="file" name="photo"
                                                                                         id="photo"
                                                                                         class="col-md-9 form-control"
                                                                                         accept="image/*;capture=camera"
                                                                                         onchange="photoPreview(this)"/>

                                    </span>
                        </p>

                    <?php

                    }

                ?>
                <div class="content-form">

                    <style>
                        .productCategory-block, .rating-block {
                            margin-bottom: 1em;
                        }
                    </style>
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" placeholder="Give your review a title" value="<?= htmlspecialchars($title) ?>" class="form-control"/>                    
                    
                    <!-- styled category -->
                    <label for="productCategory">Category</label>
                    <div class="productCategory-block">
                        <input type="hidden" name="productCategory" id="productCategory-id" value="<?= $productCategory ?>">
                        <div id="productCategory" class="productCategory">
                            <div class="btn-group">
                                <a class="btn dropdown-toggle productCategory" data-toggle="dropdown" href="#" id="productCategory-button" aria-expanded="false">
                                    <i class="fa fa-book"></i> Book <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="#" data-productCategory="Book" class="productCategory-option"><i class="fa fa-book"></i> Book</a></li>
                                    <li><a href="#" data-productCategory="Movie" class="productCategory-option"><i class="fa fa-film"></i> Movie</a></li>
                                    <li><a href="#" data-productCategory="Restaurant" class="productCategory-option"><i class="fa fa-coffee"></i> Restaurant</a></li>
                                    <li><a href="#" data-productCategory="Other" class="productCategory-option"><i class="fa fa-asterisk"></i> Other</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <style>
                        a.productCategory {
                            background-color: #fff;
                            background-image: none;
                            border: 1px solid #cccccc;
                            box-shadow: none;
                            text-shadow: none;
                            color: #555555;
                        }

                        .productCategory .caret {
                                border-top: 4px solid #555;
                        }
                    </style>
                    <script>
                        $(document).ready(function () {
                            $('.productCategory-option').each(function () {
                                if ($(this).data('productcategory') == $('#productCategory-id').val()) {
                                    $('#productCategory-button').html($(this).html() + ' <span class="caret"></span>');
                                }
                            })
                        });
                        $('.productCategory-option').on('click', function () {
                            $('#productCategory-id').val($(this).data('productcategory'));
                            $('#productCategory-button').html($(this).html() + ' <span class="caret"></span>');
                            $('#productCategory-button').click();
                            return false;
                        });
                       
                        $('#productCategory-id').on('change', function () {
                        });
                    </script>
                    <!-- end styled category -->
                     
                    <label for="productName">Product Name</label>
                    <input type="text" name="productName" id="productName" placeholder="What are you reviewing?" value="<?= htmlspecialchars($productName) ?>" class="form-control"/>                    
                    
                    <label for="productLink">Product Link</label>
                    <input type="text" name="productLink" id="productLink" placeholder="Does the product have a URL? Consider an affiliate link!" value="<?= htmlspecialchars($productLink) ?>" class="form-control"/>                    
                    
                    <!-- styled rating -->
                    <label for="rating">Rating</label>
                    <div class="rating-block">
                        <input type="hidden" name="rating" id="rating-id" value="<?= $rating ?>">
                        <div id="rating" class="rating">
                            <div class="btn-group">
                                <a class="btn dropdown-toggle rating" data-toggle="dropdown" href="#" id="rating-button" aria-expanded="false">
                                    <i class="fa">&#xf005;</i> <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="#" data-rating="1" class="rating-option"><i class="fa">&#xf005;&#xf006;&#xf006;&#xf006;&#xf006;</i></a></li>
                                    <li><a href="#" data-rating="2" class="rating-option"><i class="fa">&#xf005;&#xf005;&#xf006;&#xf006;&#xf006;</i></a></li>
                                    <li><a href="#" data-rating="3" class="rating-option"><i class="fa">&#xf005;&#xf005;&#xf005;&#xf006;&#xf006;</i></a></li>
                                    <li><a href="#" data-rating="4" class="rating-option"><i class="fa">&#xf005;&#xf005;&#xf005;&#xf005;&#xf006;</i></a></li>
                                    <li><a href="#" data-rating="5" class="rating-option"><i class="fa">&#xf005;&#xf005;&#xf005;&#xf005;&#xf005;</i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <style>
                        a.rating {
                            background-color: #fff;
                            background-image: none;
                            border: 1px solid #cccccc;
                            box-shadow: none;
                            text-shadow: none;
                            color: #555555;
                        }

                        .rating .caret {
                                border-top: 4px solid #555;
                        }
                    </style>
                    <script>
                        $(document).ready(function () {
                            $('.rating-option').each(function () {
                                if ($(this).data('rating') == $('#rating-id').val()) {
                                    $('#rating-button').html($(this).html() + ' <span class="caret"></span>');
                                }
                            })
                        });
                        $('.rating-option').on('click', function () {
                            $('#rating-id').val($(this).data('rating'));
                            $('#rating-button').html($(this).html() + ' <span class="caret"></span>');
                            $('#rating-button').click();
                            return false;
                        });
                       
                        $('#rating-id').on('change', function () {
                        });
                    </script>
                    <!-- end styled rating -->
                    
                </div>
                
                <label for="body">Review</label>
                <?= $this->__([
                    'name' => 'body',
                    'value' => $body,
                    'object' => $object,
                    'wordcount' => true
                ])->draw('forms/input/richtext')?>
                <?= $this->draw('entity/tags/input'); ?>

                <?php if (empty($vars['object']->_id)) echo $this->drawSyndication('article'); ?>
                <?php if (empty($vars['object']->_id)) { ?><input type="hidden" name="forward-to" value="<?= \Idno\Core\site()->config()->getDisplayURL() . 'content/all/'; ?>" /><?php } ?>
                
                <?= $this->draw('content/access'); ?>

                <p class="button-bar ">
	                
                    <?= \Idno\Core\site()->actions()->signForm('/review/edit') ?>
                    <input type="button" class="btn btn-cancel" value="Cancel" onclick="tinymce.EditorManager.execCommand('mceRemoveEditor',true, 'body'); hideContentCreateForm();"/>
                    <input type="submit" class="btn btn-primary" value="Publish"/>

                </p>

            </div>

        </div>
    </form>

    <script>
        //if (typeof photoPreview !== function) {
        function photoPreview(input) {

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#photo-preview').html('<img src="" id="photopreview" style="display:none; width: 400px">');
                    $('#photo-filename').html('Choose different photo');
                    $('#photopreview').attr('src', e.target.result);
                    $('#photopreview').show();
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
        //}
    </script>

    <div id="bodyautosave" style="display:none"></div>
<?= $this->draw('entity/edit/footer'); ?>
