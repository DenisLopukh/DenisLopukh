<?php
session_start();

$questions = [
    "Как называется площадка, на которой играют в хоккей?" => ["Ледовая арена", "Стадион", "Футбольное поле", "Площадка", "Ледовая арена"],
    "Сколько игроков в команде на льду во время игры (включая вратаря)?" => ["6", "5", "7", "4", "6"],
    "Как называется бросок, который приводит к заброшенной шайбе?" => ["Гол", "Пас", "Буллит", "Удаление", "Гол"],
    "Как называется штраф за грубую игру в хоккее?" => ["Удаление", "Буллит", "Офсайд", "Штрафной бросок", "Удаление"],
    "Сколько периодов в стандартном хоккейном матче?" => ["3", "2", "4", "5", "3"],
    "Как называется игровое время в случае ничьи в основное время?" => ["Овертайм", "Буллиты", "Дополнительное время", "Пенальти", "Овертайм"],
    "Как называется место, где вратарь защищает ворота?" => ["Краска", "Зона ворот", "Центральная зона", "Скамейка запасных", "Зона ворот"],
    "Как называется правило, при котором игрок пересекает синюю линию раньше шайбы?" => ["Офсайд", "Удаление", "Буллит", "Проброс", "Офсайд"],
    "Как называется ситуация, когда команда играет в меньшинстве?" => ["Пенальти киллинг", "Пауэрплей", "Буллит", "Удаление", "Пенальти киллинг"],
    "Как называется игрок, защищающий ворота?" => ["Вратарь", "Защитник", "Форвард", "Капитан", "Вратарь"],
    "Как называется игрок, атакующий ворота соперника?" => ["Форвард", "Вратарь", "Защитник", "Капитан", "Форвард"],
    "Как называется нарушение, когда игрок выбрасывает шайбу за пределы поля?" => ["Задержка игры", "Удаление", "Офсайд", "Проброс", "Задержка игры"],
    "Как называется бросок с центра площадки в начале игры?" => ["Вбрасывание", "Буллит", "Пас", "Штрафной бросок", "Вбрасывание"],
    "Какой размер штрафа за малое нарушение?" => ["2 минуты", "5 минут", "10 минут", "Без штрафа", "2 минуты"],
    "Как называется нарушение, при котором игрок препятствует движению соперника?" => ["Блокировка", "Проброс", "Офсайд", "Буллит", "Блокировка"],
    "Как называется ситуация, когда шайба пересекает синюю линию после удара из своей зоны?" => ["Проброс", "Офсайд", "Удаление", "Буллит", "Проброс"],
    "Как называется серия бросков, решающих исход матча в случае ничьи?" => ["Буллиты", "Овертайм", "Штрафной бросок", "Пенальти", "Буллиты"],
    "Как называется зона, в которой игроки проводят замены?" => ["Зона смены", "Скамейка запасных", "Зона ворот", "Центральная зона", "Зона смены"],
    "Как называется движение шайбы от своей зоны к зоне соперника?" => ["Выброс", "Пас", "Проброс", "Перевод", "Выброс"]
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['restart'])) {
        session_destroy();
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }

    $score = 0;
    $i = 0;
    foreach ($questions as $question => $answers) {
        $correct = array_pop($answers);
        $user_answer = $_POST['answer'][$i] ?? '';
        if ($user_answer === $correct) {
            $score++;
        }
        $i++;
    }
    echo "<h2 style='font-size: 24px; font-weight: bold;'>Вы ответили правильно на $score из " . count($questions) . " вопросов.</h2>";
    echo "<h3>Результаты:</h3>";
    $i = 0;
    foreach ($questions as $question => $answers) {
        $correct = array_pop($answers);
        $user_answer = $_POST['answer'][$i] ?? '';
        if ($user_answer === $correct) {
            echo "<p><strong>$question</strong> - ✅ Верно!</p>";
        } else {
            echo "<p><strong>$question</strong> - ❌ Неверно. Правильный ответ: <strong>$correct</strong></p>";
        }
        $i++;
    }
    echo "<form method='POST'><button type='submit' name='restart'>Перезапустить тест</button></form>";
} else {
    echo "<form method='POST' style='display: block;'>";
    $i = 0;
    foreach ($questions as $question => $answers) {
        $correct = array_pop($answers);
        shuffle($answers);
        echo "<p><strong>$question</strong></p>";
        foreach ($answers as $answer) {
            echo "<label style='display: block;'><input type='radio' name='answer[$i]' value='$answer' required> $answer</label>";
        }
        $i++;
    }
    echo "<button type='submit' style='margin-top: 10px;'>Завершить тест</button>";
    echo "</form>";
}
?>