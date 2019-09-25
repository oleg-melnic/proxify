@extends('layout/layout')

@section('title', 'Courses')

<section class="flex">

    <div class="col-xs-12 col-sm-8 col-md-10 center flex">
        <div class="bc-green center flex">
            <div class="col-xs-12 col-sm-10 col-md-8 center pb-3em">
                <div class="size-1_6em size-1_3em-xs pt-2em pb-0 f-bold">
                    <?= $course->getName() ?>
                </div>
                <?php $institution = $course->getInstitution(); ?>
                <?php if($institution){ ?>
                    <div class="size-1_1em c-green">
                        by <?= $institution ?>
                    </div>
                <?php } ?>
                <div class="size-1_1em c-grey pt-2em text-left">
                    <?= $course->getDescription() ?>
                <div id="show-toggle" class="">
                    <div class="col-xs-12 col-sm-12">
                        <div class="height-9em avatar mt-2em">
                        </div>
                        <div class="pb-4em">
                            <div>
                                <div class="size-1_3em pt-1_5em f-bold"><?= $course->getAuthor()->getFullName() ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="flex-1em ">
                        <div class="col-xs-12 col-sm-6">
                            <div class="p-3em bc-white block-shadow">
                                <div class="pb-2em">
                                    <div class="flex-1em space-between items-center">
                                        <div>
                                            <div class="size-1_2em c-black f-bold">Dificulty:</div>
                                        </div>
                                        <div>
                                            <div class="flex-0_5em items-end">
                                                <div class="c-grey"><?php echo ucfirst($course->getDifficulty()->getValue()) ?></div>
                                                <div class="p_0 flex items-end skill-bar space-between skill-2">
                                                    <span></span>
                                                    <span></span>
                                                    <span></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pb-2em">
                                    <div class="flex-1em space-between">
                                        <div>
                                            <div class="size-1_2em c-black f-bold">Student rating:</div>
                                        </div>
                                        <div>
                                            <div class="flex-0_5em">
                                                <div class="c-grey">4.8</div>
                                                <div class="star"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class=" p-3em bc-white block-shadow">
                                <div class="text-left pb-2_5em">
                                    <div>
                                        <div class="size-1_2em c-black f-bold">This course contains</div>
                                    </div>
                                    <div>
                                        <div class="c-grey pb-0_3em">
                                            <?php $nrChapters = count($chapters); ?>
                                            <?php $nrIssues = $this->course($course)->countIssuesByCourse(); ?>
                                            <?php $nrQuizes = $this->course($course)->countQuizesByCourse(); ?>

                                            <?= $nrChapters ?> <?= $nrChapters==1 ? 'chapter' : 'chapters'?>,
                                            <?= $nrIssues ?> <?= $nrChapters==1 ? 'issue' : 'issues'?> ,
                                            <?= $nrQuizes ?> <?= $nrChapters==1 ? 'quize' : 'quizes'?>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-left">
                                    <div>
                                        <div class="size-1_2em c-black f-bold">How to pass</div>
                                    </div>
                                    <div>
                                        <div class="c-grey"><?= $course->getHowPass() ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="pb-1em  pt-2em flex items-center">
                    <div class="c-grey up"><div id="click-me" class="c-grey up f-bold size-1_1em"></div></div>
                </div>
            </div>
        </div>
        <div class="bc-smooth-green w100 flex center">
            <div class="col-xs-12 col-sm-10 col-md-8 flex center">
                <div class="w100 pt-2em pb-1em text-left flex space-between">
                    <div class="flex items-center">
                        <div class="pr-2em">
                        </div>
                        <div>
                            <div class="c-grey size-1_1em">Your latest activity:</div>
                            <div class="size-1_1em">CHAPTER 2 > Issue 4 - Here goes the latest o issue title</div>
                        </div>
                    </div>
                    <div>
                        <a href="#" class="button button-green-out size-1_2em display-block">Resume Learning</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="w100 bc-white pt-3em pb-3em center flex">
            <div class="chapters-section col-xs-12 col-sm-10 col-md-8 center pb-6em">
                <?php if ($chapters) { ?>
                <?php $i = 1; ?>
                <?php foreach ($chapters as $chapter) { ?>
                    <div class="pos-rel pl-2em-xs pl-7em-sm chapters-courses mb-2em">
                        <div class="bc-white text-left">
                            <div class="p-2em">
                                <div class="c-green f-bold size-1_2em ">CHAPTER <?= $i++ ?></div>
                                <div class="size-2em"><?= $chapter->getName() ?></div>
                                <div class="c-grey pt-2em">
                                    <?= $chapter->getDescription() ?>
                                </div>
                            </div>
                            <div class="flex w100 p-1em space-between items-center">
                                <div class="col-xs-12 flex col-sm-4 col-md-3 pt-0_4em pr-0_5em nowrap">
                                    <div class="progress">
                                        <div class="determinate" style="width: 100%"></div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4 text-left c-grey">
                                    <span class="c-green">50%</span> &nbsp;&nbsp; (5/10 issues completed)
                                </div>
                                <div class="col-sm-4 text-right">
                                    <a href="" class="button button-green-out size-1em waves-effect waves-light display-inline-block">
                                        Continue this chapter
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php } else { ?>
                    <div class="pos-rel pl-2em-xs pl-7em-sm chapters-courses mb-2em">
                        <div class="bc-white text-left">
                            <div class="p-2em">
                                <div class="c-green f-bold size-1_2em ">There are no chapters</div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
