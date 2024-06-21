<?php

class NotificationAdapter
{
    public function isDoublicate(Notification $notification): bool
    {
        $stmt = $conn->prepare('SELECT * FROM notifications WHERE recipientNotif=:recip AND senderNotif=:sender AND typeNotif=:type');
        $stmt->bindParam(':recip', $notification->getRecipient());
        $stmt->bindParam(':sender', $notification->getSender());
        $stmt->bindParam(':type', $notification->getType());
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$row)
        {
            return false;
        }
        return true;
    }

    public function add(array $Notifications){

    }
}