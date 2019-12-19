<?php
class Question {
    private $question;
    private $type;
    private $answers = array();
    private $rightAnswer;
    public function __construct($question, $type, $answers, $rightAnswer) {
        $this->question = $question;
        $this->type = $type;
        $this->answers = $answers;
        $this->rightAnswer = $rightAnswer;
    }
    public function getQuestion() {
        return $this->question;
    }
    public function getType() {
        return $this->type;
    }
    public function getAnswers() {
        if($this->type == 2) {
            return null;
        }
        return $this->answers;
    }
    public function addAnswer($answer) {
        array_push($this->answers, $answer);
    }
    public function getRightAnswer() {
        if($this->type == 2) {
            return null;
        }
        return $this->rightAnswer;
    }
}