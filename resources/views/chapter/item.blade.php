@extends('layout/layout')

@section('title', 'Chapter')

<section class="flex">

    <div class="col-xs-12 col-sm-8 col-md-10 center p-1em flex">
        <div class="col-xs-12 col-sm-10 col-md-8 center pb-3em">
            <div class="size-1_6em size-1_3em-xs pt-2em pb-0_5em text-left c-grey flex items-center">
                <em class="fa fa-bookmark-o fa-2x c-green" aria-hidden="true"></em>
            </div>
            <div class="size-1_5em text-left mt-1_5em f-bold">
                <?= $chapter->getName() ?>
            </div>
            <div class="c-grey pt-2em pb-2em text-left">
                <?= $chapter->getDescription() ?>
            </div>
            <div class="flex w100 pt-1em pb-2em items-center">
                <div class="col-xs-12 flex col-sm-4 col-md-3 pt-0_4em pr-0_5em nowrap">
                    <div class="progress">
                        <div class="determinate" style="width: 50%"></div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 text-left pl-2em">
                    50% &nbsp;&nbsp; ( 4/8 issues completed )
                </div>
            </div>

            <div class="course-block text-left">
                <?php if ($issues || $quizes) { ?>
                    <?php $i = 1; ?>
                    <?php foreach ($issues as $item) { ?>
                        <?php $typeName = "Issue ".$i++; ?>
                        {{'chapter/single-item', ['item' => $item, 'typeName' => $typeName]}}
                    <?php } ?>
                    <?php $i = 1; ?>
                    <?php foreach ($quizes as $item) { ?>
                        <?php $typeName = count($quizes) > 1 ? "Quiz ".$i++ :"Final Quiz"; ?>
                        {{'chapter/single-item', ['item' => $item, 'typeName' => $typeName]}}
                    <?php } ?>
                <?php } else { ?>
                    <div class="flex items-center space-between p-3em br-bottom-1 br-gray">
                        <div class="flex items-center">
                            <div class="size-1_2em">There are no items</div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
