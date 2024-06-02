<?php

class userLoggedInNotification extends Notification
{
    /**
     * Generate a message for a single notification
     *
     * @param Notification $notification
     * @return string
     */
    public function messageForNotification(Notification $notification): string
    {
        return $this->sender->getName() . 'has logged in!';
    }
}