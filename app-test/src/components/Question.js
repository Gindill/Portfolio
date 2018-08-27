import React from 'react';
import "bootstrap/dist/css/bootstrap.css";

function Question(props) {
  const variants = props.current.answers.map(
    (item, index) => (
      <div className="form-check">
        <label className="col-form-label form-check-label" key={index}>
          <input class="form-check-input" type="radio" name="answer" value={index} checked={props.selected == index} onClick={props.onSelectAnswer}/>
          {item}
        </label>
      </div>
    )
  );

  return (
    <div>
      <h3>{props.current.question}</h3>
      {variants}
    </div>
  )
}

export default Question;
