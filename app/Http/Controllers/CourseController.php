<?php

namespace App\Http\Controllers;

use App\Service\Course\Chapter as ChapterService;
use App\Service\Course\Course as CourseService;

class CourseController extends AbstractActionController
{
    /**
     * @var CourseService
     */
    private $service;

    /**
     * @var ChapterService
     */
    private $chapterService;

    public function __construct(CourseService $service, ChapterService $chapterService)
    {
        $this->service = $service;
        $this->chapterService = $chapterService;
    }

    public function index()
    {
        return view('course/index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function myCourses()
    {
        return view('course/my-courses', [
            'courses' => $this->service->getAllCoursesByParam(['author' => auth()->id()])
        ]);
    }

    /**
     * item action
     * page for viewing one course
     *
     */
    public function item()
    {
        $alias = request()->get('alias');
        $course = $this->service->getOne(array('alias' => $alias));

        if (is_null($course)) {
            response()->setStatusCode(404);
            return;
        }

        return view('course/item', [
            'course' => $course,
            'chapters' => $this->chapterService->getAllChaptersByCourse($course->getIdentity()),
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function courseCreate()
    {
        if ($this->getRequest()->isMethod('POST')) {
            $data = $this->getRequest()->get();
            $data['teacher'] = auth()->id();
            $data['author'] = auth()->id();
            $entity = $this->service->firstSave($data);

            return redirect()->route(
                'course',
                ['alias' => $entity->getAlias()]
            );
        }
    }
}
