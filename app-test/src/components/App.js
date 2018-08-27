import React, { Component } from 'react';
import 'bootstrap/dist/css/bootstrap.css';
import Question from './Question';
import Results from './Results';
import questions from '../data/questions';
import {buildQuestion} from '../functions'

class App extends Component {
  constructor() {
    super();

    this.state = {
      currentQuestionIndex: 0,
      currentQuestion: buildQuestion(questions[0]),
      selectedAnswerIndex: 0,
      selectedAnswers: [],
      countRights: 0
    }

    this.selectAnswer = this.selectAnswer.bind(this);
    this.btnNextClick = this.btnNextClick.bind(this);
    this.btnRetakeClick = this.btnRetakeClick.bind(this);
  }

  selectAnswer(event) {
    this.setState({selectedAnswerIndex: event.target.value});
  };

  btnNextClick(event) {
    const selectedAnswer = this.state.currentQuestion.answers[this.state.selectedAnswerIndex];
    if (selectedAnswer == questions[this.state.currentQuestionIndex].rightAnswer) {
      this.setState({countRights: ++this.state.countRights})  // подсчет числа правильных ответов
    }

    var answers = this.state.selectedAnswers; // формирование массива ответов
    answers.push(selectedAnswer);  
    this.setState({selectedAnswers: answers});

    this.setState({currentQuestionIndex: ++this.state.currentQuestionIndex});    
    if (this.state.currentQuestionIndex < questions.length) {
      this.setState({currentQuestion: buildQuestion(questions[this.state.currentQuestionIndex])});
      this.setState({selectedAnswerIndex: 0});
    } 

    event.preventDefault();
  }

  btnRetakeClick(event) {
      this.setState({currentQuestionIndex: '0'});    
      this.setState({currentQuestion: buildQuestion(questions[0])});    
      this.setState({selectedAnswerIndex: 0});    
      this.setState({selectedAnswers: []});    
      this.setState({countRights: 0});    
  }

  render() {
    if (this.state.currentQuestionIndex < questions.length) {
      return (
        <div className="container">
          <Question current={this.state.currentQuestion} selected={this.state.selectedAnswerIndex} onSelectAnswer={this.selectAnswer}/>
          <button className="btn btn-primary" onClick={this.btnNextClick}>Далее</button>
        </div>
      );
    } else {
      var results = [];
      questions.forEach((item, index) => {
        results[index] = {
          question: item.question,
          rightAnswer: item.rightAnswer,
          selectedAnswer: this.state.selectedAnswers[index]
        };
      });
      const percent = this.state.countRights / questions.length * 100;
      
      return (
        <div className="container">
          <h3>Результаты теста</h3>
          <Results results={results}/>
          <p><b>Итого:</b> правильных ответов {this.state.countRights} из {questions.length} ({percent}%)</p>
          <button className="btn btn-primary" onClick={this.btnRetakeClick}>Пересдать</button>
        </div>
      );
    }
  }
}

export default App;
