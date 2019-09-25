<?php /** @var \App\Entity\Course\Course $course */ ?>

@extends('layout/layout')

@section('title', 'My Courses')

<section class="bc-lightgray pos-rel">
    <div class="container">
        <div class="flex-1em space-between items-center pt-2em pb-2em">
            <div class="size-1_3em title-lines-left">My courses</div>
            <div>
                <a href="" class="button button-green">
                    <i class="fa fa-plus-square-o pr-0_5em" aria-hidden="true"></i>Create course
                </a>
            </div>
        </div>
    </div>
</section>
<section class="pt-4em pb-4em">
    <div class="container">
        <div class="flex-1em child-mb-2em size-0_8em-sm size-1em-md">
            <?php foreach ($courses as $course) { ?>
            <div class="col-sm-6">
                <div class="br-2 br-gray p-2em">
                    <div class="flex-1em">
                        <div class="col-xs-12 col-sm-4 flex center-xs">
                            <div class="mb-1em-xs">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-8">
                            <div class="pb-1_5em">
                                <div class="size-1_3em">
                                    <a href="">
                                        <?php echo $course->getName(); ?>
                                    </a>
                                </div>
                            </div>
                            <div class="flex items-center space-between">
                                <div class="br-2 br-gray pt-0_2em pb-0_2em pr-1em pl-1em">
                                    <div class="size-1em up">Draft</div>
                                </div>
                                <div>
                                    <div class="flex items-center">
                                        <div class="pr-0_5em lh-0_8em">
                                        </div>
                                        <div class="pr-2em">
                                            <div class="size-1em c-black">0</div>
                                        </div>
                                        <div class="pr-0_5em lh-0_8em">
                                        </div>
                                        <div>
                                            <div class="size-1em c-black">0</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</section>
