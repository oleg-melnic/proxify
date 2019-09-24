<?php
namespace App\Entity\Course\Item;

use App\Entity\Course\Item\Quiz\QuizVO;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Quiz extends ItemAbstract
{
    /**
     * @var QuizVO
     *
     * @ORM\Embedded(class="\App\Entity\Course\Item\Quiz\QuizVO", columnPrefix = false)
     */
    protected $quiz;

    /**
     * @return QuizVO
     */
    public function getQuiz()
    {
        return $this->quiz;
    }

    /**
     * @param QuizVO $quiz
     */
    public function setQuiz(QuizVO $quiz)
    {
        $this->quiz = $quiz;
    }
}
