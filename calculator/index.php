<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Калькулятор</title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/UniversalToolTipFull.css">
    </head>
    <body>
        <form>
            <div class="header">
                <h2>Расчет примерной стоимости работ</h2>
            </div>

            <div class="field">
                <label>1. Где будет ремонт?</label>
                <select name="flat">
                    <option value="0">Студия</option>
                    <option value="1">1-но комнатная квартира</option>
                    <option value="2">2-х комнатная квартира</option>
                    <option value="3">3-х комнатная квартира</option>
                    <option value="4">4-х комнатная квартира</option>
                    <option value="5">Таунхаус</option>
                    <option value="6">Коттедж</option>
                </select>
            </div>

            <div class="field">
                <label>2. Площадь пола, м<sup>2</sup></label>
                <div name="scale">
                    <table name="scale-label">
                        <tr>
                            <td>25<br>|</td>
                            <td></td>
                            <td>57<br>|</td>
                            <td></td>
                            <td>89<br>|</td>
                            <td></td>
                            <td>121<br>|</td>
                            <td></td>
                            <td>154<br>|</td>
                            <td></td>
                            <td>186<br>|</td>
                            <td></td>
                            <td>218<br>|</td>
                            <td></td>
                            <td>250<br>|</td>
                        </tr>
                    </table>
                    <input type="range" name="floor-range" min="25" max="250" step="1">
                </div>
                <div name="floor"></div>
            </div>

            <div class="field">
                <label>3. Тип ремонта</label>
                <img src="img/question.png" class="hovertip" alt="?">
                <span class='tipbubble'>Описание разных категорий ремонта</span>
                <select  name="repair">
                    <option value="0">Косметический</option>
                    <option value="1">Комплексный</option>
                    <option value="2">Капитальный</option>
                    <option value="3">Евроремонт</option>
                </select>
            </div>

            <div class="field">
                <label>4. Потолок</label>
                <img src="img/question.png" class="hovertip" alt="?">
                <span class='tipbubble'>Описание разных категорий потолка</span>
                <select name="ceiling">
                    <option value="0">Покраска</option>
                    <option value="1">Натяжной</option>
                    <option value="2">Гипсокартон</option>
                </select>
            </div>

            <div class="field">
                <label>5. Стены</label>
                <img src="img/question.png" class="hovertip" alt="?">
                <span class='tipbubble'>Описание разных технологий отделки стен</span>
                <select name="walls">
                    <option value="0">Покраска</option>
                    <option value="1">Обои</option>
                </select>
            </div>

            <div class="field">
                <label>6. Пол</label>
                <img src="img/question.png" class="hovertip" alt="?">
                <span class='tipbubble'>Описание напольных покрытий</span>
                <select name="flooring">
                    <option value="0">Линолеум</option>
                    <option value="1">Ламинат</option>
                    <option value="2">Паркетная доска</option>
                    <option value="3">Штучный паркет</option>
                    <option value="4">Плитка</option>
                </select>
            </div>

            <div class="field">
                <label>7. Дополнительно</label>
                <img src="img/question.png" class="hovertip" alt="?">
                <span class='tipbubble'>Описание дополнительных опций</span>
                <fieldset>
                    <input type="checkbox" id="plumbing" name="plumbing">
                    <label for="plumbing">Сантехника</label>
                    <input type="checkbox" id="electric" name="electric">
                    <label for="electric">Электрика</label>
                    <br>
                    <input type="checkbox" id="ventilation" name="ventilation">
                    <label for="ventilation">Вентиляция</label>
                    <input type="checkbox" id="heating" name="heating">
                    <label for="heating">Отопление</label>
                </fieldset>
            </div>

            <div class="field">
                <label>7. Ваше имя</label>
                <input type="text" name="name">
            </div>

            <div class="field">
                <label>8. Телефон</label>
                <input type="text" name="phone" placeholder="+7(___) ___-__-__">
            </div>

            <button type="button"><b>Заказать расчет</b></button>
        </form>
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery.maskedinput.min.js"></script>
        <script type="text/javascript" src="js/UToolTip.js"></script>
        <script type="text/javascript">

            function floorValue() {
                $('[name="floor"]').html($('[name="floor-range"]').val() + " м<sup>2</sup>");
            }

            $(function(){
                $('[name="floor-range"]').val(25);
                floorValue();
            });

            $('[name="floor-range"]').change(function(){
                floorValue();
            });

            $('[name="floor-range"]').mousemove(function(){
                floorValue();
            });

            $('[name="scale-label"] td').click(function() {
                var square = $(this).html().match(/\d*/);
                if (square > 0) {
                    $('[name="floor-range"]').val(square);
                    floorValue();
                }
            });

            $(function(){
                $('[name="phone"]').mask("+7(999) 999-99-99");
            });

            $('[type="text"]').focus(function() {
                $(this).css("border-color", "");
                $('span.error').remove();
            });

            $('button').click(function() {
                var error = false;
                $('span.success').remove();
                $('span.error').remove();
                if(!($('[name="name"]').val())) {
                    $('[name="name"]').css("border-color", "red");
                    error = true;
                };
                if(!($('[name="phone"]').val())) {
                    $('[name="phone"]').css("border-color", "red");
                    error = true;
                };
                if(error) {
                    $('button').after('<span class="error">Пожалуйста, заполните обязательные поля</span>');
                }
                else {
                    $.ajax({
                        method: "POST",
                        url: "calculator.php",
                        data: $('form').serializeArray(),
                        success: function(result) {
                            $('button').after('<span class="success">Ваша заявка отправлена. В ближайшее время с вами свяжется наш оператор. ' + result + '</span>')
                        },
                        error: function(result) {
                            $('button').after('<span class="error">Во время отправки заявки произошла ошибка. ' + result + '</span>');
                        }
                    });
                }
            });

        </script>
    </body>
</html>
