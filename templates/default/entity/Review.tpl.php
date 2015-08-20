<article class="h-review known-review">
    <?php

        if (\Idno\Core\site()->template()->getTemplateType() == 'default') {
            ?>
            <h2 class="p-name">
                <a class="u-url" href="<?= $vars['object']->getDisplayURL() ?>">
                    <span class="p-category"><?= $vars['object']->getProductCategory(); ?></span> 
                    Review: <?= htmlentities(strip_tags($vars['object']->getTitle()), ENT_QUOTES, 'UTF-8'); ?>
                </a>
            </h2>
            <?php
        }
    ?>
            
            <div class="p-item h-product">
                <h4 class="p-name">
                    <?= htmlentities(strip_tags($vars['object']->getProductName()), ENT_QUOTES, 'UTF-8'); ?> 
                </h4>
                
    <?php
        if ($attachments = $vars['object']->getAttachments()) {
            foreach ($attachments as $attachment) {
                $mainsrc = $attachment['url'];
                if (!empty($vars['object']->thumbnail_large)) {
                    $src = $vars['object']->thumbnail_large;
                } else if (!empty($vars['object']->thumbnail)) { // Backwards compatibility
                    $src = $vars['object']->thumbnail;
                } else {
                    $src = $mainsrc;
                }
                
                // Patch to correct certain broken URLs caused by https://github.com/idno/known/issues/526
                $src = preg_replace('/^(https?:\/\/\/)/', \Idno\Core\site()->config()->getDisplayURL(), $src);
                $mainsrc = preg_replace('/^(https?:\/\/\/)/', \Idno\Core\site()->config()->getDisplayURL(), $mainsrc);
                
                ?>
                <p style="text-align: center">
                    <a href="<?= $this->makeDisplayURL($mainsrc) ?>"><img src="<?= $this->makeDisplayURL($src) ?>" class="u-photo"/></a>
                </p>
            </div>
            <br>
            <?php
            }
        }
    ?>
            <div class="rating-container" style="font-weight: bold; margin: 1em 0;">
                <span class="p-rating"><?= $vars['object']->getRating(); ?></span> out of 5 stars.
            </div> 

            <div class="e-description">
                <?= $this->__(['value' => $vars['object']->body, 'object' => $vars['object'], 'rel' => $rel])->draw('forms/output/richtext'); ?>
            </div>
</article>
