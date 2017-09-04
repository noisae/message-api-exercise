<?php
namespace MessageApi\Tests\Domain\Message\Entity;

use MessageApi\Domain\Message\Entity\MessageEntity;


class MessageEntityTest extends \PHPUnit_Framework_TestCase {

    private $faker;

    public function setUp() {
        $this->faker = \Faker\Factory::create();
    }

    private function createMessageData() {
        return [
            'uid' => $this->faker->randomDigitNotNull,
            'sender'    => $this->faker->word,
            'subject'   => $this->faker->word,
            'message' => $this->faker->sentence,
            'time_sent' => $this->faker->unixTime,
            'isRead' => false,
            'isArchived' => false
        ];
    }

    public function testRead() {
        // Given
        $messageData = $this->createMessageData();
        $message = new MessageEntity(
            $messageData['uid'],
            $messageData['sender'],
            $messageData['subject'],
            $messageData['message'],
            $messageData['time_sent'],
            $messageData['isRead'],
            $messageData['isArchived']
        );

        //When
        $message->read();

        //Then
        $this->assertTrue($message->isRead());
    }

    public function testArchive() {
        // Given
        $messageData = $this->createMessageData();
        $message = new MessageEntity(
            $messageData['uid'],
            $messageData['sender'],
            $messageData['subject'],
            $messageData['message'],
            $messageData['time_sent'],
            $messageData['isRead'],
            $messageData['isArchived']
        );

        //When
        $message->archive();

        //Then
        $this->assertTrue($message->isArchived());
    }

}
