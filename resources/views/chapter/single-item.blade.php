<div class="flex items-center space-between p-3em br-bottom-1 br-gray">
    <div class="flex items-center">
        <div class="flex items-center pr-1em ">
            <span class="display-block icon c-green <?= $item->getItemTypeInfo()['iconClassChapter']; ?>"></span>
            <span class="c-black pl-3_5em size-1_2em"><?= $typeName ?> -</span>
        </div>
        <div class="size-1_2em">
            <?= $item->getName() ?>
        </div>
    </div>
    <div>
        <a href="<?php echo $this->url(
            'personal-office/item',
            ['alias' => $item->getAlias()]) ?>" class="button button-green size-1em waves-effect waves-light display-inline-block">
            Resume learning
        </a>
    </div>
</div>
