<?php
namespace MessageApi\Domain\Message\Entity;

class Message {

    public $uid;
    public $sender;
    public $subject;
    public $message;
    public $time_sent;
    public $isRead;
    public $isArchived;

    public function __construct($data = []) {

        if (is_array($data)) {
            $this->uid = $data['uid'] ? $data['uid'] : null;
            $this->sender = $data['sender'] ? $data['sender'] : null;
            $this->subject = $data['subject'] ? $data['subject'] : null;
            $this->message = $data['message'] ? $data['message'] : null;
            $this->time_sent = $data['time_sent'] ? $data['time_sent'] : null;
            $this->isRead = $data['isRead'] ? $data['isRead'] : false;
            $this->isArchived = $data['isArchived'] ? $data['isArchived'] : false;
        }

        if (is_object($data)) {
            $this->uid = $data->uid;
            $this->sender = $data->sender;
            $this->subject = $data->subject;
            $this->message = $data->message;
            $this->time_sent = $data->time_sent;
            $this->isRead = $data->isRead;
            $this->isArchived = $data->isArchived;
        }
    }

    public function read() {
        $this->isRead = true;
    }

    public function archive() {
        $this->isArchived = true;
    }
}
