<?php

namespace App\Http\Controllers;

use App\Service\Course\Chapter as ChapterService;
use App\Service\Course\Course as CourseService;
use App\Service\Course\Item\Item;

class ChapterController extends AbstractActionController
{
    /**
     * @var ChapterService
     */
    private $chapterService;

    /**
     * @var CourseService
     */
    private $courseService;

    /**
     * @var Item
     */
    private $itemService;

    /**
     * ChapterController constructor.
     * @param ChapterService $service
     * @param CourseService $courseService
     */
    public function __construct(ChapterService $service, CourseService $courseService, Item $itemService)
    {
        $this->chapterService = $service;
        $this->courseService = $courseService;
        $this->itemService = $itemService;
    }

    public function item()
    {
        $alias = request()->get('alias');
        $chapter = $this->chapterService->getOne(array('alias' => $alias));

        if (is_null($chapter)) {
            response()->setStatusCode(404);
            return;
        }

        return view('chapter/item', [
            'chapter' => $chapter,
            'issues' => $this->itemService->getAllIssuesByChapter($chapter->getIdentity()),
            'quizes' => $this->itemService->getAllQuizesByChapter($chapter->getIdentity()),
        ]);
    }

    public function createAction()
    {
        /** @var Course $courseService */
        $courseService = $this->getServiceLocator()->get(Course::class);

        // Getting course id
        $courseId = $this->params()->fromRoute('id', -1);

        /**
         * @var \App\Entity\Course\Course $chapter
         */
        $course = $courseService->find($courseId);

        if (!$course) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $this->personalOfficeMenu('professorTopMenu', ['course' => $course]);
        $this->personalOfficeLeftMenu('professorLeftMenu', ['course' => $course]);


        /** @var ChapterCreateForm $form */
        $form = $this->getServiceLocator()->get(ChapterCreateForm::class);

        /** @var Chapter $chapterService */
        $chapterService = $this->getServiceLocator()->get(Chapter::class);

        // Check if user has submitted the form
        if ($this->getRequest()->isPost()) {
            // Fill in the form with POST data
            $data = $this->params()->fromPost();
            $data['course'] = $course;
            $form->setData($data);

            if ($form->isValid()) {
                // Get filtered and validated data
                $data = $form->getData();

                /** @var \App\Entity\Course\Chapter $chapterEntity */
                $chapterEntity = $chapterService->create($data);

                return $this->redirect()->toRoute(
                    'personal-office/course/info',
                    [
                        'id' => $course->getIdentity(),
                    ]
                );
            }
        }

        $view = new ViewModel([
            'form' => $form,
            'courseId' => $courseId,
        ]);

        return $view;
    }

    public function updateAction()
    {
        /** @var ChapterCreateForm $form */
        $form = $this->getServiceLocator()->get(ChapterCreateForm::class);

        /** @var Chapter $service */
        $service = $this->getServiceLocator()->get(Chapter::class);
        $chapterId = $this->params()->fromRoute('id', -1);

        /** @var \App\Entity\Course\Chapter $chapter */
        $chapter = $service->find($chapterId);

        $this->personalOfficeMenu('professorTopMenu', ['course' => $chapter->getCourse()]);
        $this->personalOfficeLeftMenu('professorLeftMenu', ['course' => $chapter->getCourse()]);

        // Check if user has submitted the form
        if ($this->getRequest()->isPost()) {
            // Fill in the form with POST data
            $data = $this->params()->fromPost();
            $data['course'] = $chapter->getCourse()->getIdentity();
            $form->setData($data);

            if ($form->isValid()) {
                // Get filtered and validated data
                $data = $form->getData();
                $chapter = $service->update($chapterId, $data);

                return $this->redirect()->toRoute(
                    'personal-office/chapter/update',
                    [
                        'id' => $chapter->getCourse()->getIdentity(),
                        'chapterId' => $chapter->getIdentity(),
                    ]
                );
            }
        } else {
            $data = [
                'name' => $chapter->getName(),
                'description' => $chapter->getDescription(),
                'state' => $chapter->getState(),
            ];

            $form->setData($data);
        }

        $view = new ViewModel([
            'form' => $form,
            'chapterId' => $chapter->getIdentity(),
        ]);

        return $view;
    }

    public function deleteAction()
    {
        if ($this->getRequest()->isPost()) {
            $postId = $this->params()->fromRoute('id', -1);

            /** @var SubscriptionPackage $service */
            $service = $this->getServiceLocator()->get(Chapter::class);
//            $service->delete($postId);

            return new JsonModel([
                'status' => 'SUCCESS',
            ]);
        } else {
            throw new \Exception('Not post data.');
        }
    }

    public function sortAction()
    {
        $courseId = $this->params()->fromRoute('id', -1);
        $service = $this->getServiceLocator()->get(Course::class);

        /** @var \App\Entity\Course\Course $chapter */
        $course = $service->find($courseId);

        $this->personalOfficeMenu('professorTopMenu', ['course' => $course]);

        $chapterService = $this->getServiceLocator()->get(Chapter::class);
        /** @var Chapter $service */
        $allChapters = $chapterService->getAllChaptersByCourse($courseId);

        if ($this->getRequest()->isPost()) {
            $post = $this->params()->fromPost();
            try {
                $chapterService->update($post['id'], ['position' => $post['position']]);
            } catch (\Exception $e) {
                vred($e->getMessage());
            }
            die();
        }

        $view = new ViewModel([
            'allChapters' => $allChapters,
            'courseId' => $courseId,
        ]);

        return $view;
    }
}
