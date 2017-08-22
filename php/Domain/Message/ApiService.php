<?php
namespace MessageApi\Domain\Message;

use MessageApi\Domain\Message\Entity\Message as MessageEntity;

class ApiService {

    private $messageRepository;

    public function __construct(\MessageApi\Infra\Repository\Message $messageRepository) {
        $this->messageRepository = $messageRepository;
    }

    public function list($page, $limit) {
        return $this->messageRepository->listMessages($page, $limit);
    }

    public function listArchived($page, $limit) {
        return $this->messageRepository->listArchived($page, $limit);
    }

    public function show($uid) {
        return $this->messageRepository->findOne($uid);
    }

    public function read($uid) {
        $message = $this->messageRepository->findOne($uid);

        $messageEntity = new MessageEntity($message);
        $messageEntity->read();

        $this->messageRepository->updateRead($messageEntity);

        return $messageEntity;
    }

    public function archive($uid) {
        $message = $this->messageRepository->findOne($uid);

        $messageEntity = new MessageEntity($message);
        $messageEntity->archive();

        $this->messageRepository->updateArchive($messageEntity);

        return $messageEntity;
    }
}
