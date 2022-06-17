<?php

declare(strict_types=1);

use GAState\Tools\D2L\API\UsersAPI;

global $d2l;

require 'Bootstrap.php';

$usersAPI = new UsersAPI($d2l);

/*
$questionObjects = [];
do {
    $params = ['bookmark' => $questions->Next ?? null];

    list($questions) = $d2l->callAPI('le', 'GET', '/2486806/quizzes/4199830/questions/', $params);
    parse_str(parse_url($questions->Next ?? '')['query'] ?? '', $urlParams);
    $questions->Next = $urlParams['bookmark'] ?? null;
    foreach ($questions->Objects as $qobj) {
        $questionObjects[] = [$qobj->QuestionId, $qobj->QuestionText->Text, $qobj->Feedback->Text];
    }
} while ($questions->Next !== null);


$out = fopen('questions.csv', 'w');
fwrite($out, chr(239) . chr(187) . chr(191));
fputcsv($out, ['QuestionId', 'QuestionText', 'FeedbackText']);
foreach ($questionObjects as $q) {
    fputcsv($out, $q);
}
fclose($out);
file_put_contents('questions.json', json_encode($questionObjects, JSON_PRETTY_PRINT) . "\n");

echo "Done\n";
*/