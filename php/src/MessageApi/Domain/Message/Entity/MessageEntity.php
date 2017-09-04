<?php

namespace MessageApi\Domain\Message\Entity;

use MessageApi\Domain\Message\Entity\AbstractEntity;

class MessageEntity extends AbstractEntity {
    /**
     * @var int
     */
    private $uid;
    /**
     * @var string
     */
    private $sender;
    /**
     * @var string
     */
    private $subject;
    /**
     * @var string
     */
    private $message;
    /**
     * @var int
     */
    private $time_sent;
    /**
     * @var bool
     */
    private $isRead;
    /**
     * @var bool
     */
    private $isArchived;

    /**
     *
     * @param int $uid
     * @param string $sender
     * @param string $subject
     * @param string $message
     * @param int $time_sent
     * @param bool $isRead
     * @param bool $isArchived
     */
    public function __construct(int $uid, string $sender, string $subject, string $message, int $time_sent, bool $isRead, bool $isArchived) {

        $this->uid = $uid;
        $this->sender = $sender;
        $this->subject = $subject;
        $this->message = $message;
        $this->time_sent = $time_sent;
        $this->isRead = $isRead;
        $this->isArchived = $isArchived;
    }

    /**
     * @return int
     */
    public function getUid() : int {
        return $this->uid;
    }

    /**
     * @return bool
     */
    public function isRead() : bool {
        return $this->isRead === true;
    }

    /**
     * @return bool
     */
    public function isArchived()  : bool {
        return $this->isArchived === true;
    }

    /**
     * @param void
     *
     * @return void
     */
    public function read() {
        $this->isRead = true;
    }

    /**
     * @param void
     *
     * @return void
     */
    public function archive() {
        $this->isArchived = true;
    }

    /**
     * @return array
     */
    public function jsonSerialize() : array {
        return [
            "uid" => $this->uid,
            "sender" => $this->sender,
            "subject" => $this->subject,
            "message" => $this->message,
            "time_sent" => $this->time_sent,
            "isRead" => $this->isRead,
            "isArchived" => $this->isArchived,
        ];
    }
}
