<?php

class Receiver extends User
{
    public function getId()
    {
        return $this->id;
    }

    public function getGroup()
    {
        return $this->profileId;
    }
}