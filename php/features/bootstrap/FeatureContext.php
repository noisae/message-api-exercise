<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use MessageApi\Domain\ExposeApiService;
use MessageApi\Domain\Message\Entity\MessageEntity;
use MessageApi\Domain\Message\Entity\MessageEntityCollection;
use MessageApi\Infra\Repository\MessageRepository;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    private $faker;
    private $page;
    private $limit;
    private $result;
    private $Message;
    private $Messages;
    private $MessageRepositoryMock;
    private $ApiService;

    /**
     * @BeforeScenario
     */
    public function BeforeScenario() {
        $this->faker = \Faker\Factory::create();

        Mockery::close();
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

    private function createMessageEntity() {
        $messageData = $this->createMessageData();
        return new MessageEntity(
            $messageData['uid'],
            $messageData['sender'],
            $messageData['subject'],
            $messageData['message'],
            $messageData['time_sent'],
            $messageData['isRead'],
            $messageData['isArchived']
        );
    }

    private function createMessageEntityCollection($count) {
        $messageEntityCollection = new MessageEntityCollection();
        for ($i = 0; $i < $count; $i++) {
            $messageEntityCollection->set($this->createMessageEntity());
        }

        return $messageEntityCollection;
    }

    /**
     * @Given /^I have (.*)\s?Messages$/
     */
    public function iHaveMessages($archived)
    {
        $this->page = 20;
        $this->limit = 20;
        $this->Messages = $this->createMessageEntityCollection(2);

        $method = 'listMessages';
        if ($archived) {
            $method ='listArchived';
        }

        $this->MessageRepositoryMock = Mockery::mock(MessageRepository::class);
        $this->MessageRepositoryMock
            ->shouldReceive($method)
            ->once()
            ->with($this->page, $this->limit)
            ->andReturn($this->Messages);

    }

    /**
     * @When /^I Retrieve a paginateable list of (.*)\s?Messages$/
     */
    public function iRetrieveAPaginateableListOfMessages($archived)
    {
        $this->ExposeApiService = new ExposeApiService($this->MessageRepositoryMock);
        if ($archived) {
            $this->result = $this->ExposeApiService->listArchived($this->page, $this->limit);
            return $this->result;
        }
        $this->result = $this->ExposeApiService->list($this->page, $this->limit);
    }

    /**
     * @Then /^I receive a paginateable list of (.*)\s?Messages$/
     */
    public function iReceiveAPaginateableListOfMessages()
    {
        PHPUnit_Framework_Assert::assertSame(
            $this->result,
            $this->Messages
        );
    }

    /**
     * @Given I have a Message
     */
    public function iHaveAMessage()
    {
        $this->Message = $this->createMessageEntity();

        $this->MessageRepositoryMock = Mockery::mock(MessageRepository::class);
        $this->MessageRepositoryMock
            ->shouldReceive('findOne')
            ->once()
            ->with($this->Message->getUid())
            ->andReturn($this->Message);
    }

    /**
     * @When I Retrieve a Message
     */
    public function iRetrieveAMessage()
    {
        $this->ExposeApiService = new ExposeApiService($this->MessageRepositoryMock);
        $this->result = $this->ExposeApiService->show($this->Message->getUid());
    }

    /**
     * @Then I receive a Message
     */
    public function iReceiveAMessage()
    {
        PHPUnit_Framework_Assert::assertSame(
            $this->result,
            $this->Message
        );
    }

    /**
     * @Given /^I have a Message to (Read|Archive)$/
     */
    public function iHaveAMessageToReadOrArchive($type)
    {
        $this->Message = $this->createMessageEntity();

        $method = 'updateRead';
        if ($type === "Archive") {
            $method = 'updateArchive';
        }

        $this->MessageRepositoryMock = Mockery::mock(MessageRepository::class);
        $this->MessageRepositoryMock
            ->shouldReceive('findOne')
            ->once()
            ->with($this->Message->getUid())
            ->andReturn($this->Message);

        $this->MessageRepositoryMock
            ->shouldReceive($method)
            ->once()
            ->andReturn($this->Message);
    }

    /**
     * @When I Read a Message
     */
    public function iReadAMessage()
    {
        $this->ExposeApiService = new ExposeApiService($this->MessageRepositoryMock);
        $this->result = $this->ExposeApiService->read($this->Message->getUid());
    }

    /**
     * @When I Archive a Message
     */
    public function iArchiveAMessage()
    {
        $this->ExposeApiService = new ExposeApiService($this->MessageRepositoryMock);
        $this->result = $this->ExposeApiService->archive($this->Message->getUid());
    }

    /**
     * @Then /^The Message was saved as Read$/
     */
    public function theMessageWasSavedAsRead()
    {
        PHPUnit_Framework_Assert::assertSame(
            $this->result->isRead(),
            true
        );
    }

    /**
     * @Then /^The Message was saved as Archived$/
     */
    public function theMessageWasSavedAsArchived()
    {
        PHPUnit_Framework_Assert::assertSame(
            $this->result->isArchived(),
            true
        );
    }
}
