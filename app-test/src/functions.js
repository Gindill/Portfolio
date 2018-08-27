// формирование вопроса с 4 вариантами ответа, включая правильный
function buildQuestion(item) {  
  var answers = [];
  item.variantAnswers.forEach((answer) => answers.push(answer));

  answers.sort(compareRandom);    // перемешивание массива со всеми ответами
  answers.splice(3);              // выбор из него трех ответов
  answers.push(item.rightAnswer); // добавление правильного ответа
  answers.sort(compareRandom);    // повторное перемешивание

  return {
    question: item.question,
    answers: answers
  }
}

// вспомогательная функция для выбора случайного числа из пары
function compareRandom(a, b) {
  return Math.random() - 0.5;
}

export {buildQuestion}