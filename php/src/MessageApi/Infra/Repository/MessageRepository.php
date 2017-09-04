<?php
namespace MessageApi\Infra\Repository;

use Medoo\Medoo;
use MessageApi\Domain\Message\Repository\MessageRepositoryInterface;
use MessageApi\Domain\Message\Entity\AbstractEntity;
use MessageApi\Domain\Message\Entity\EmptyEntity;
use MessageApi\Domain\Message\Entity\MessageEntity;
use MessageApi\Domain\Message\Entity\MessageEntityCollection;
use MessageApi\Infra\Repository\Parser\MessageEntityParser;

class MessageRepository implements MessageRepositoryInterface {

    /**
     * @var Medoo $db
     */
    private $db;

    /**
     * @var MessageEntityParser $messageEntityParser
     */
    private $messageEntityParser;

    /**
     * @param Medoo $db
     * @param int $limit
     *
     * @return MessageEntityCollection
     */
    public function __construct(Medoo $db, MessageEntityParser $messageEntityParser) {
        $this->db = $db;
        $this->messageEntityParser = $messageEntityParser;
    }

    /**
     * @param int $page
     * @param int $limit
     *
     * @return MessageEntityCollection
     */
    public function listMessages(int $page, int $limit) : MessageEntityCollection {
        $pointer = ($page - 1) * $limit;
        $result = $this->db->select('messages', '*', ["isArchived" => false, "LIMIT" => [$pointer, $limit]]);
        return $this->parseCollection($result);
    }

    /**
     * @param int $page
     * @param int $limit
     *
     * @return MessageEntityCollection
     */
    public function listArchived(int $page, int $limit) : MessageEntityCollection {
        $pointer = ($page - 1) * $limit;
        $result = $this->db->select('messages', '*', ["isArchived" => true, "LIMIT" => [$pointer, $limit]]);
        return $this->parseCollection($result);
    }

    /**
     * @param int $puid
     *
     * @return AbstractEntity
     */
    public function findOne(int $uid) : AbstractEntity {
        $result = $this->db->get('messages', '*', ["uid" => $uid]);
        return $this->parseItem($result);
    }

    /**
     * @param MessageEntity $message
     *
     * @return AbstractEntity
     */
    public function updateRead(MessageEntity $message) : AbstractEntity {
        $result = $this->db->update('messages', ["isRead" => $message->isRead()], ["uid" => $message->getUid()]);
        return $this->parseItem($result);
    }

    /**
     * @param MessageEntity $message
     *
     * @return AbstractEntity
     */
    public function updateArchive(MessageEntity $message) : AbstractEntity {
        $result = $this->db->update('messages', ["isArchived" => $message->isArchived()], ["uid" => $message->getUid()]);
        return $this->parseItem($result);
    }

    private function parseItem($result) {
        if (!is_array($result)) {
            return new EmptyEntity();
        }

        return $this->messageEntityParser->parseItem($result);
    }

    private function parseCollection($result) {
        if(!is_array($result) || count($result) <= 0) {
            $result = [];
        }

        return $this->messageEntityParser->parseCollection($result);
    }
}
