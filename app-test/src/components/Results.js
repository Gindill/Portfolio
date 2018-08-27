import React from 'react';
import "bootstrap/dist/css/bootstrap.css";

function Results(props) {
  const results = props.results.map(
    (item, index) => (
      <div key={index}>
        <p>Вопрос {index + 1}: <i>{item.question}</i></p>
        <p>Ваш ответ: <i>{item.selectedAnswer}</i> - {
          (item.selectedAnswer == item.rightAnswer) ? 
          <span className="badge badge-success">правильно</span> : 
          <React.Fragment><span className="badge badge-danger">неправильно</span><span>, правильный ответ: <i>{item.rightAnswer}</i></span></React.Fragment>
        }</p>
      </div>
    )
  );

  return (
    <React.Fragment>
      {results}
    </React.Fragment>
  )
}

export default Results;
