<?php
//
declare(strict_types=1);
//
require_once(__DIR__ . '/../../config.php');
echo '123';
//
//global $DB;
//
//echo '<h1>История:</h1>';
//
$entries = $DB->get_records('quadratic_equation_history');
//
//if (!empty($entries)) {
//    foreach ($entries as $entry) {
//        echo 'a = ' . $entry->a . ', b = ' . $entry->b . ', c = ' . $entry->c . '<br>';
//        echo 'x1 = ' . $entry->x1 . ', x2 = ' . $entry->x2 . '<br><br>';
//    }
//} else {
//    echo 'Нет истории!';
//}
