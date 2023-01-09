<?php

declare(strict_types=1);

use GAState\Tools\D2L\API\DiscussionsAPI;
use GAState\Tools\D2L\Exception\D2LResponseException;

global $d2l;

require 'Bootstrap.php';

main: {
    $discussionsAPI = new DiscussionsAPI($d2l);

    try {

       //var_dump($discussionsAPI->getDisscusionForums(2273803));

       //var_dump($discussionsAPI->getDisscusionForum(2273803,747006));

       //var_dump($discussionsAPI->getDisscusionForumTopics(2273803,747006));

       //var_dump($discussionsAPI->getDisscusionForumTopic(2273803,747006, 2309070));

       //var_dump($discussionsAPI->getDisscusionForumTopicPosts(2273803,747006, 2309070));

       var_dump($discussionsAPI->getDisscusionForumTopicPost(2273803,747006, 2309070, 32292835));
    
    } catch (D2LResponseException $ex) {
        var_dump($ex->getMessage(), $ex->response->statusCode, $ex->response->data);
    }
}