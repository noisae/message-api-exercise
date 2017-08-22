<?php

use League\FactoryMuffin\Faker\Facade as Faker;

$fm->define('MessageApi\Domain\Message\Entity\Message')->setDefinitions([
    'uid' => Faker::randomDigitNotNull(),
    'sender'    => Faker::word(),
    'subject'   => Faker::word(),
    'message' => Faker::sentence(),
    'time_sent' => Faker::unixTime(),
    'isRead' => Faker::boolean(),
    'isArchived' => Faker::boolean()
]);
