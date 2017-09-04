<?php

namespace MessageApi\Domain;

use MessageApi\Domain\Message\Repository\MessageRepositoryInterface;
use MessageApi\Domain\Message\Entity\AbstractEntity;
use MessageApi\Domain\Message\Entity\MessageEntity;
use MessageApi\Domain\Message\Entity\MessageEntityCollection;

class ExposeApiService {

    /**
     * @var MessageRepositoryInterface
     */
    private $messageRepository;

    /**
     * @param MessageRepositoryInterface $messageRepository
     */
    public function __construct(MessageRepositoryInterface $messageRepository) {
        $this->messageRepository = $messageRepository;
    }

    /**
     * @param integer $page
     * @param integer $limit
     *
     * @return MessageEntityCollection
     */
    public function list(int $page, int $limit) : MessageEntityCollection {
        return $this->messageRepository->listMessages($page, $limit);
    }

    /**
     * @param integer $page
     * @param integer $limit
     *
     * @return MessageEntityCollection
     */
    public function listArchived(int $page, int $limit) : MessageEntityCollection  {
        return $this->messageRepository->listArchived($page, $limit);
    }

    /**
     * @param integer $uid
     *
     * @return AbstractEntity
     */
    public function show(int $uid) : AbstractEntity {
        return $this->messageRepository->findOne($uid);
    }

    /**
     * @param integer $uid
     *
     * @return AbstractEntity
     */
    public function read(int $uid) : AbstractEntity {
        $message = $this->messageRepository->findOne($uid);

        if ($message instanceOf MessageEntity) {
            $message->read();
            $this->messageRepository->updateRead($message);
        }

        return $message;
    }

    /**
     * @param integer $uid
     *
     * @return AbstractEntity
     */
    public function archive(int $uid) : AbstractEntity {
        $message = $this->messageRepository->findOne($uid);

        if ($message instanceOf MessageEntity) {
            $message->archive();
            $this->messageRepository->updateArchive($message);
        }

        return $message;
    }
}
