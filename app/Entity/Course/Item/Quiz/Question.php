<?php
namespace App\Entity\Course\Item\Quiz;

use App\Entity\Exception\InvalidArgument;

class Question
{
    /**
     * @var array
     */
    private $questionData;

    /**
     * Question constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        if (!isset($data['question']) || !isset($data['answers']) || !isset($data['correctAnswer'])) {
            throw new InvalidArgument('Provide data: question, answers, correctAnswer');
        }

        if (!is_array($data['answers']) || empty($data['answers'])) {
            throw new InvalidArgument('Provide an array of answers');
        }

        if (!in_array($data['correctAnswer'], array_keys($data['answers']))) {
            throw new InvalidArgument('Provide a valid correct answer');
        }

        $this->setQuestionData($data);
    }

    /**
     * @return array
     */
    protected function getQuestionData()
    {
        return $this->questionData;
    }

    /**
     * @param array $questionData
     */
    protected function setQuestionData(array $questionData)
    {
        $this->questionData = $questionData;
    }

    /**
     * @return string
     */
    public function getQuestion()
    {
        return $this->getQuestionData()['question'];
    }

    /**
     * @return array
     */
    public function getAnswers()
    {
        return $this->getQuestionData()['answers'];
    }

    /**
     * @return mixed
     */
    public function getCorrectAnswerId()
    {
        return $this->getQuestionData()['correctAnswer'];
    }

    /**
     * @return string
     */
    public function getCorrectAnswer()
    {
        return $this->getAnswers()[$this->getCorrectAnswerId()];
    }
}
