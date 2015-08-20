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
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" placeholder="Give your review a title" value="<?= htmlspecialchars($title) ?>" class="form-control"/>                    
                    
                    <label for="productCategory" id="productCategory">Category</label>
                    <select name="productCategory" class="form-control">
                        <option value="Book">Book <i class="fa fa-book"></i></option>
                        <option value="Movie">Movie <i class="fa fa-film"></i></option>
                        <option value="Restaurant">Restaurant <i class="fa fa-coffee"></i></option>
                        <option value="Other">Other <i class="fa fa-asterisk"></i></option>
                    </select>
                     
                    <label for="productName">Product Name</label>
                    <input type="text" name="productName" id="productName" placeholder="What are you reviewing?" value="<?= htmlspecialchars($productName) ?>" class="form-control"/>                    
                    
                    <label for="productLink">Product Link</label>
                    <input type="text" name="productLink" id="productLink" placeholder="Does the product have a URL? Consider an affiliate link!" value="<?= htmlspecialchars($productLink) ?>" class="form-control"/>                    
                    
                    <label for="rating">Rating</label>
                    <select name="rating" id="rating" class="form-control">
                        <option value="1" class="fa">&#xf005;&#xf006;&#xf006;&#xf006;&#xf006;</option>
                        <option value="2" class="fa">&#xf005;&#xf006;&#xf006;&#xf006;&#xf006;</option>
                        <option value="3" class="fa">&#xf005;&#xf006;&#xf006;&#xf006;&#xf006;</option>
                        <option value="4" class="fa">&#xf005;&#xf006;&#xf006;&#xf006;&#xf006;</option>
                        <option value="5" class="fa">&#xf005;&#xf006;&#xf006;&#xf006;&#xf006;</option>
                    </select>
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
