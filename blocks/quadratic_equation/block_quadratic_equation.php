<?php

declare(strict_types=1);



//$host = 'localhost';  // Хост, у нас все локально
//$user = 'root';    // Имя созданного вами пользователя
//$pass = ''; // Установленный вами пароль пользователю
//$db_name = 'moodlebase';   // Имя базы данных
//$link = mysqli_connect($host, $user, $pass, $db_name); // Соединяемся с базой
//
//// Ругаемся, если соединение установить не удалось
//if (!$link) {
//    echo 'Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
//    exit;
//}
//
//$sql = mysqli_query($link, 'SELECT * FROM `quadratic_equation_history`');
//while ($result = mysqli_fetch_array($sql)) {
//    echo "{$result['a']}: {$result['b']}<br>";
//}

class block_quadratic_equation extends block_base {
    function init() {
        $this->title = get_string('pluginname', 'block_quadratic_equation');
    }

    function get_content() {
        global $DB;

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass;

        $this->content->text .= '<form method="post">';
        $this->content->text .= '<input type="number" step=any name="a" placeholder="Значение a" required>';
        $this->content->text .= '<input type="number" step=any name="b" placeholder="Значение b" required>';
        $this->content->text .= '<input type="number" step=any name="c" placeholder="Значение c" required>';
        $this->content->text .= '<input type="submit" value="Решить" >';
        $this->content->text .= '</form>';

        $a = optional_param('a', 0, PARAM_FLOAT);
        $b = optional_param('b', 0, PARAM_FLOAT);
        $c = optional_param('c', 0, PARAM_FLOAT);

        if ($a == 0) {
            $this->content->text .= 'Значение a не может быть равно 0';
        }
        else {
            $discriminant = $b * $b - 4 * $a * $c;

            if ($discriminant > 0) {
                $x1 = (-$b + sqrt($discriminant)) / (2 * $a);
                $x2 = (-$b - sqrt($discriminant)) / (2 * $a);
                $this->content->text .= 'x1 = ' . $x1 . '<br>';
                $this->content->text .= 'x2 = ' . $x2;
            } elseif ($discriminant == 0) {
                $x1 = $x2 = (-$b + sqrt($discriminant)) / (2 * $a);
                $this->content->text .= "Оба корня равны $x1";
            } else {
                $this->content->text .= 'Нет корней!';
            }
        }

        $record = new stdClass();
        $record->a = $a;
        $record->b = $b;
        $record->c = $c;
        $record->x1 = $x1;
        $record->x2 = $x2;
        //$record->username = $username;
        $record->timestamp = time();

        $DB->insert_record('quadratic_equation_history', $record);


        return $this->content;
    }

    // многократный вызов экземпляров на странице
    public function instance_allow_multiple(){
        return true;
    }

}