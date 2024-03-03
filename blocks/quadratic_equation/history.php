<?php
declare(strict_types=1);

global $DB, $CFG;

require_once(__DIR__ . '/../../config.php');

// Выводим историю решений
echo '<h2>История решений квадратного уравнения:</h2>';
$history = $DB->get_records('quadratic_equation_history', array(), 'timestamp DESC');
if ($history) {
    echo '<ul>';
    foreach ($history as $entry) {
        echo '<li>a='.$entry->a.', b='.$entry->b.', c='.$entry->c.', x1='.$entry->x1.', x2='.$entry->x2.'</li>';
    }
    echo '</ul>';
} else {
    echo 'История пуста';
}