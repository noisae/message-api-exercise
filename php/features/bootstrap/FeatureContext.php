<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use League\FactoryMuffin\FactoryMuffin;
use MessageApi\Features\Store\Mock as StoreMock;
use MessageApi\Domain\Message\ApiService;
use MessageApi\Domain\Message\Entity\Message as Message;
use MessageApi\Infra\Repository\Message as MessageRepository;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    protected static $factoryMuffin;
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
    public static function BeforeScenario() {
        static::$factoryMuffin = new FactoryMuffin(new StoreMock());
        static::$factoryMuffin->loadFactories(__DIR__.'/../Fixtures');

        Mockery::close();
    }

    /**
     * @Given /^I have (.*)\s?Messages$/
     */
    public function iHaveMessages($archived)
    {
        $this->page = 20;
        $this->limit = 20;
        $this->Messages = [
            static::$factoryMuffin->create('MessageApi\Domain\Message\Entity\Message'),
            static::$factoryMuffin->create('MessageApi\Domain\Message\Entity\Message')
        ];

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
        $this->ApiService = new ApiService($this->MessageRepositoryMock);
        if ($archived) {
            $this->result = $this->ApiService->listArchived($this->page, $this->limit);
            return $this->result;
        }
        $this->result = $this->ApiService->list($this->page, $this->limit);
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
        $this->Message = static::$factoryMuffin->create('MessageApi\Domain\Message\Entity\Message');

        $this->MessageRepositoryMock = Mockery::mock(MessageRepository::class);
        $this->MessageRepositoryMock
            ->shouldReceive('findOne')
            ->once()
            ->with($this->Message->uid)
            ->andReturn($this->Message);
    }

    /**
     * @When I Retrieve a Message
     */
    public function iRetrieveAMessage()
    {
        $this->ApiService = new ApiService($this->MessageRepositoryMock);
        $this->result = $this->ApiService->show($this->Message->uid);
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
        $this->Message = static::$factoryMuffin->create('MessageApi\Domain\Message\Entity\Message');
        $this->expectedMessage = new Message($this->Message);

        $this->expectedMessage->isRead = true;
        $this->Message->isRead = false;
        $method = 'updateRead';
        if ($type === "Archive") {
            $this->Message->isArchived = false;
            $this->expectedMessage->isArchived = true;
            $method = 'updateArchive';
        }

        $this->MessageRepositoryMock = Mockery::mock(MessageRepository::class);
        $this->MessageRepositoryMock
            ->shouldReceive('findOne')
            ->once()
            ->with($this->Message->uid)
            ->andReturn($this->Message);

        $this->MessageRepositoryMock
            ->shouldReceive($method)
            ->once()
            ->andReturn($this->expectedMessage);
    }

    /**
     * @When I Read a Message
     */
    public function iReadAMessage()
    {
        $this->ApiService = new ApiService($this->MessageRepositoryMock);
        $this->result = $this->ApiService->read($this->Message->uid);
    }

    /**
     * @When I Archive a Message
     */
    public function iArchiveAMessage()
    {
        $this->ApiService = new ApiService($this->MessageRepositoryMock);
        $this->result = $this->ApiService->archive($this->Message->uid);
    }

    /**
     * @Then /^The Message was saved as Read$/
     */
    public function theMessageWasSavedAsRead()
    {
        PHPUnit_Framework_Assert::assertSame(
            $this->result->isRead,
            $this->expectedMessage->isRead
        );
    }

    /**
     * @Then /^The Message was saved as Archived$/
     */
    public function theMessageWasSavedAsArchived()
    {
        PHPUnit_Framework_Assert::assertSame(
            $this->result->isArchived,
            $this->expectedMessage->isArchived
        );
    }
}
