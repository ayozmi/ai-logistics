<?php
require_once 'config.php';
require_once 'DbConnect.php';

class User
{
    public $id;
    public $firstName;
    public $lastName;
    public $birthDate;
    public $emailUser;
    public $phoneNumber;
    public $sexUser;
    public $profileId;
    public $profile;

    /**
     * @param $emailUser string The user's email input
     * @description Returns the user given its address email
     * @return mixed The return value of this function on success depends on the fetch type.
     * In all cases, False is returned on failure
     */
    public function getUser(string $emailUser): mixed
    {
        if (!checkEmail($emailUser)) {
            return false;
        }
        $conn = new DbConnect();
        $conn = $conn->connect();
        if (!$conn) {
            return $conn;
        }
        $stmt = $conn->prepare("SELECT * FROM users WHERE emailUser = :emailUser");
        $stmt->bindParam(':emailUser', $emailUser);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @description Returns all the users in the database
     * @return array|bool|PDO The return value of this function on success depends on the fetch type.
     * In all cases, False is returned on failure
     */
    public function getAllUsers(): array|bool|PDO
    {
        $conn = new DbConnect();
        $conn = $conn->connect();
        if (!$conn) {
            return $conn;
        }
        $stmt = $conn->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param $userData Array with all data regarding the user.
     * @return void
     */
    public function initializeVariables(array $userData): void
    {
        $this->firstName = $userData['firstName'];
        $this->lastName = $userData['lastName'];
        $this->id = $userData['idUser'];
        $this->birthDate = $userData['birthDate'];
        $this->emailUser = $userData['emailUser'];
        $this->phoneNumber = $userData['phoneNumber'];
        $this->sexUser = $userData['sexUser'];
        $this->profileId = $userData['profileUser'];
        if ($profile = $this->getProfile($this->profileId)) {
            $this->profile = $profile;
        }
    }

    /**
     * @param $inputPassword string The user's password input
     * @param $dbPassword string The hashed password from database
     * @param $salt string The salt value
     * @param $pepper string The pepper value
     * @return bool True if passwords match | False if passwords don't match
     */
    public function checkPassword(string $inputPassword, string $dbPassword, string $salt, string $pepper): bool
    {
        # TODO pepper should be added to increase security
        $pepper = "";
        $saltedPassword = hash('sha256', $inputPassword . $salt . $pepper);
        return strtolower($saltedPassword) == strtolower($dbPassword);
    }

    public function getProfile($idProfile)
    {
        $conn = new DbConnect();
        $conn = $conn->connect();
        if (!$conn) {
            return false;
        }
        $stmt = $conn->prepare("SELECT * FROM profile WHERE idProfile = :idProfile");
        $stmt->bindParam(':idProfile', $idProfile);
        $stmt->execute();
        $profile = $stmt->fetch(PDO::FETCH_ASSOC);
        return $profile['intituleProfile'];
    }

    public function getName(): string
    {
        if ($this->firstName == null OR $this->lastName == null) {
            $con = new DbConnect();
            $con = $con->connect();
            $stmt = $con->prepare("SELECT * FROM users WHERE idUser = :id");
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
            $stmt = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->firstName = $stmt['firstName'];
            $this->lastName = $stmt['lastName'];
        }
        return $this->firstName . ' ' . $this->lastName;
    }
}