<?php
namespace MessageApi\Tests\Domain\Message\Entity;

use MessageApi\Domain\Message\Entity\Message as MessageEntity;
use MessageApi\Features\Store\Mock as StoreMock;
use League\FactoryMuffin\FactoryMuffin;


class Message extends \PHPUnit_Framework_TestCase {

    protected static $factoryMuffin;

    public function setUp() {
        static::$factoryMuffin = new FactoryMuffin(new StoreMock());
        static::$factoryMuffin->loadFactories(__DIR__.'/../../../../Features/Fixtures');
    }

    public function testRead() {
        // Given
        $messageFixture = static::$factoryMuffin->create('MessageApi\Domain\Message\Entity\Message');
        $messageFixture->isRead = false;
        $message = new MessageEntity($messageFixture);

        //When
        $message->read();

        //Then
        $this->assertTrue($message->isRead);
    }

    public function testArchive() {
        // Given
        $messageFixture = static::$factoryMuffin->create('MessageApi\Domain\Message\Entity\Message');
        $messageFixture->isArchived = false;
        $message = new MessageEntity($messageFixture);

        //When
        $message->archive();

        //Then
        $this->assertTrue($message->isArchived);
    }

}
