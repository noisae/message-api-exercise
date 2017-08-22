<?php
namespace MessageApi\Infra\Repository;

use MessageApi\Domain\Message\Entity\Message as MessageEntity;

class Message {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function listMessages($page, $limit) {
        $pointer = ($page - 1) * $limit;
        return $this->db->select('messages', '*', ["isArchived" => false, "LIMIT" => [$pointer, $limit]]);
    }

    public function listArchived($page, $limit) {
        $pointer = ($page - 1) * $limit;
        return $this->db->select('messages', '*', ["isArchived" => true, "LIMIT" => [$pointer, $limit]]);
    }

    public function findOne($uid) {
        return $this->db->get('messages', '*', ["uid" => $uid]);
    }

    public function updateRead(MessageEntity $message) {
        return $this->db->update('messages', ["isRead" => $message->isRead], ["uid" => $message->uid]);
    }

    public function updateArchive(MessageEntity $message) {
        return $this->db->update('messages', ["isArchived" => $message->isArchived], ["uid" => $message->uid]);
    }
}
