<?php

use AirSlate\ApiClient\Client;
use AirSlate\ApiClient\Entities\EventBus\Event;
use AirSlate\ApiClient\Entities\EventBus\Webhook;

require_once 'vendor/autoload.php';

/**
 * An array of options to set on Client.
 * Option `token` is required.
 */
$config = [
    // Client oauth token.
    'token' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjJmY2Y4Y2M2NDU1YzJmNTMwMmM3M2JhN2UwNzRiNTIxYjE0NDgzN2NjZGUzZTZiM2YyYjU3N2JmZDM3NTc0YmM5Y2Y3ZmUyNTdhYzgzM2RkIn0.eyJhdWQiOiIxIiwianRpIjoiMmZjZjhjYzY0NTVjMmY1MzAyYzczYmE3ZTA3NGI1MjFiMTQ0ODM3Y2NkZTNlNmIzZjJiNTc3YmZkMzc1NzRiYzljZjdmZTI1N2FjODMzZGQiLCJpYXQiOjE1MzY1NzIzMDEsIm5iZiI6MTUzNjU3MjMwMSwiZXhwIjoxNTM2NzIyNTAwLCJzdWIiOiIxIiwidXNlcm5hbWUiOiIxNWEyNGNjYmVkYTY0YTIzOGVkZmNjOGE2ZTRjMzBhNkBleGFtcGxlLm9yZyIsInNjb3BlcyI6W119.l8AbczCmQSEI4ZJm1sjm-nPLiXDG1hy98BZGdGxlzARMQdP1OuMrnAKq6NbymJ8mEk3wbAFT1J45jzlFA4Vh74b5UQf98yXjCVgwDfkIkpPuTOtBUvJ4nFYU3PoIw2ui3ZmAdCK4D5aZ2rsDpIIV0wty61dgxayQ7BqV3puI6PByvXJfG9uD3kL-V4S_lHSsas1P81OjERasxp-A0ZXJvnL3Xa4KJ4tlWoYKaBZuFCxhYCQ9Vk0ZJDfj8Q34A-Sp4-pc2bjABiA3Xk8ACneaXZLMQjJNVxAwqZ2S-UohMkmcFfMlI-Lojju6-JpRzUpKcugzdOSDmTHPVApkLTs5GI683KX7r2DFj7XH_09mGelCPPGGVbrg4d_8-doP0GFa6pqE6oxFr6MCuSo6E2RUrlRpn29QyckFho0menEUlUCI3rwuRAN9Rg3o_vrkY1y8DPYe87srcnLhUouJMxD8Oc88HvmXuBih0OZguSjyAYwFZWE4JgVnONg4puv-N9pYM0L8bZ8OKnPLl3b-krcoT1yWDGU87sPXvj6hb9r4IMIgQJs6jW7AQlIfdk3rqGV063aB3i4PpiWkHvQeejWco1Odgy9sm42fgJXnz_CgxjT3b8yTvMrKNOw6WysMDBrOQIUipcXRYClVtDBQmE4o5iYnEHlB3Rnt2fY20W5oozo',
];

/**
 * The $config argument must be either an array or Traversable.
 * Laravel users can use `app(AirSlate\ApiClient\Client::class)`.
 */
$client = Client::instance('http://127.0.0.1:8019', $config);

$eventBus = $client->eventBus('1', 'dfbPnQbPM3B7JoFGO5oMVC0lqicbcOpb3O4pfFhj');

// create webhook

$source = new Webhook();
$source->setAttributes([
    "routing_key" => "test",
    "callback_url" => "https://webhook.site/TEST-TEST-TEST",
]);

$newbie = $eventBus->createWebhook($source);
print_r($newbie);

// get one webhook

$one = $eventBus->getWebhook($newbie->id);
print_r($one);

// get collection

$collection = $eventBus->getWebhooksCollection();
print_r($collection);

// delete one

$isSuccess = $eventBus->deleteWebhook($one->id);
var_dump($isSuccess);

// push event

$source = new Event();
$source->setAttributes([
    'routing_key' => 'very_test',
    'payload' => [
        'test' => true
    ]
]);

print_r($eventBus->pushEvent($source));
