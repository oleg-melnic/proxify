<?php
namespace App\Entity\Course\Item\Quiz;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use S0mWeb\WTL\Entity\Exception\InvalidArgument;
use S0mWeb\WTL\Filter\From\FromArray\FactoryInterface;

/**
 * @ORM\Embeddable
 */
class QuizVO implements FactoryInterface
{
    /**
     * @var Collection
     *
     * @ORM\Column(name="quiz_data", type="array", nullable=false)
     */
    protected $quizData;

    /**
     * @var Question[]
     */
    protected $questions;

    /**
     * QuizVO constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        if (!isset($data['questions'])) {
            throw new InvalidArgument('Provide data: questions');
        }

        $this->quizData = new ArrayCollection($data);
        $this->initQuestions();
    }

    /**
     * @return Collection
     */
    public function getQuizData()
    {
        return $this->quizData;
    }

    /**
     * Создаем фильтр из массива
     *
     * @param array $data
     *
     * @return QuizVO
     */
    public static function createFromArray(array $data)
    {
        $object = new self($data);

        return $object;
    }

    /**
     * @return Question[]
     */
    public function getQuestions()
    {
        if (is_null($this->questions)) {
            $this->initQuestions();
        }
        return $this->questions;
    }

    /**
     * Init question objects
     *
     * @return void
     */
    protected function initQuestions()
    {
        foreach ($this->getQuizData()->toArray()['questions'] as $questionData) {
            $this->questions[] = new Question($questionData);
        }
    }
}
