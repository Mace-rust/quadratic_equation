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
        //$DB->d

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass;

        //$this->content->text = '';
        $this->content->text .= '<form method="post">';
        $this->content->text .= '<input type="number" step=any name="a" placeholder="Значение a" required>';
        $this->content->text .= '<input type="number" step=any name="b" placeholder="Значение b" required>';
        $this->content->text .= '<input type="number" step=any name="c" placeholder="Значение c" required>';
        $this->content->text .= '<input type="submit" value="Решить" >';
        $this->content->text .= '</form>';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $a = (float)$_POST['a'];
            //optional_param()
            $b = (float)$_POST['b'];
            $c = (float)$_POST['c'];

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
// Вывод сообщения об ошибке, если введены нули
//            else {
//                $this->content->text .= 'Без нулей!';
//            }
        }

        return $this->content;
    }

    // многократный вызов экземпляров на странице
    public function instance_allow_multiple(){
        return true;
    }

}

////если переменная 'а' передана, то...
//if (isset($_POST["a"])) {
//    //Вставляем данные, подставляя их в запрос
//    $sql = mysqli_query($link, "INSERT INTO `quadratic_equation_history` (`a`, `b`, `c`, `x1`, `x2`) VALUES ('{$_POST['a']}', '{$_POST['b']}', '{$_POST['c']}', '{$_POST['x1']}', '{$_POST['x2']}')");
//    //Если вставка прошла успешно
//    if ($sql) {
//        echo '<p>Данные успешно добавлены в таблицу.</p>';
//    } else {
//        echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
//    }
//}