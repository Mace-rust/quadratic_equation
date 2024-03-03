<?php

declare(strict_types=1);

class block_quadratic_equation extends block_base {
    function init() {
        $this->title = get_string('pluginname', 'block_quadratic_equation');
    }

    function get_content() {
        global $DB, $record;

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

        if ($x1 !== NULL) {
            $record->x1 = number_format((float)$x1, 5, '.', '');
            $record->x2 = number_format((float)$x2, 5, '.', '');
        }
        else{
            $record->x1 = 'NULL';
            $record->x2 = 'NULL';
        }

        $record->timestamp = time();

        $DB->insert_record('quadratic_equation_history', $record);


        return $this->content;
    }

    // многократный вызов экземпляров на странице
    public function instance_allow_multiple(){
        return true;
    }

}