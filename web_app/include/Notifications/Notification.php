<?php

abstract class Notification
{
    protected $id;
    protected $recipient;
    protected $sender;
    protected $unread;
    protected $type;
    protected $parameters;
    protected $reference;
    protected $createdAt;

    public function __construct(Sender $sender, Receiver $recipient, Reference $ref)
    {
        $this->sender = $sender;
        $this->recipient = $recipient;
        $this->reference = $ref;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getRecipient(): Receiver
    {
        return $this->recipient;
    }

    public function getSender(): Sender
    {
        return $this->sender;
    }

    /**
     * @return mixed
     */
    public function getType(): mixed
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getParameters(): mixed
    {
        return $this->parameters;
    }

    /**
     * @return Reference
     */
    public function getReference(): Reference
    {
        return $this->reference;
    }

    /**
     * Message generators that have to be defined in subclasses
     */
    abstract function messageForNotification(Notification $notification);

    /**
     * Generate message of the current notification.
     */
    public function message()
    {
        return $this->messageForNotification($this);
    }
}