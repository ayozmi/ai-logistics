<?php

class NotificationManager
{
    protected $notificationAdapter;

    public function __construct(){
        $this->notificationAdapter = new NotificationAdapter();
    }

    /**
     * Marks the notification read for the user
     * @param Notification $notification
     * @return bool|string
     */
    public function markRead(Notification $notification): bool|string
    {
            try{
                $con = new DbConnect();
                if($con = $con->connect()){
                    throw new Exception("Can't access the database!");
                }
                $sql = "UPDATE notifications SET unreadNotif = 0 WHERE idNotif = :idNotif";
                $statement = $con->prepare($sql);
                $notificationId = $notification->getId();
                $statement->bindParam(':idNotif', $notificationId);
                if ($stmt->execute()){
                    throw new Exception("Error in SQL code!");
                }
            }
            catch (Exception $exception){
                return $exception->getMessage();
            }
            return true;
    }

    public function get(User $user, $limit = 20, $offset = 0){

    }

    public function add(Notification $notification): void
    {
        // only save the notification if no possible duplicate is found.
        if (!$this->notificationAdapter->isDoublicate($notification)) {
            $this->notificationAdapter->add([
                'recipient_id' => $notification->getRecipient()->getGroup(),
                'sender_id' => $notification->getSender()->getId(),
                'unread' => 1,
                'type' => $notification->getType(),
                'parameters' => $notification->getParameters(),
                'reference_id' => $notification->getReference()->getId(),
                'created_at' => time(),
            ]);
        }
    }
}