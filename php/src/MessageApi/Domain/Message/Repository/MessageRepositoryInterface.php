<?php

namespace MessageApi\Domain\Message\Repository;

use  MessageApi\Domain\Message\Entity\AbstractEntity;
use  MessageApi\Domain\Message\Entity\MessageEntity;
use  MessageApi\Domain\Message\Entity\MessageEntityCollection;

interface MessageRepositoryInterface
{
    /**
     * @param int $page
     * @param int $limit
     *
     * @return MessageEntityCollection
     */
    public function listMessages(int $page, int $limit) : MessageEntityCollection;

    /**
     * @param int $page
     * @param int $limit
     *
     * @return MessageEntityCollection
     */
    public function listArchived(int $page, int $limit) : MessageEntityCollection;

    /**
     * @param int $uid
     *
     * @return AbstractEntity
     */
    public function findOne(int $uid) : AbstractEntity;

    /**
     * @param MessageEntity $message
     *
     * @return AbstractEntity
     */
    public function updateRead(MessageEntity $message) : AbstractEntity;

    /**
     * @param MessageEntity $message
     *
     * @return AbstractEntity
     */
    public function updateArchive(MessageEntity $message) : AbstractEntity;
}
