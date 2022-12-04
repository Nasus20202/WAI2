<?php
namespace database;
require_once('Config.php');
require_once('Entities/Photo.php');
require_once('Entities/User.php');
use MongoDB;
use MongoDB\BSON\ObjectID;

class Database {
    protected $client;
    protected $db;
    public function __construct(){
        $this->client = new MongoDB\Client(DatabaseConfig::HOST, [
            'username' => DatabaseConfig::USERNAME,
            'password' => DatabaseConfig::PASSWORD
        ]);
        $this->db = $this->client->selectDatabase(DatabaseConfig::DATABASE);
    }
    // Users
    public function getUsers(){
        $users = [];
        foreach($this->db->users->find()->toArray() as $user){
            $users[] = new User($user['username'], $user['email'], $user['passwordHash'], $user['_id']);
        }
        return $users;
    }
    public function getUser($id){
        $userInfo = $this->db->users->findOne(['_id' => new ObjectID($id)]);
        if ($userInfo == null)
            return null;
        return new User($userInfo['username'], $userInfo['email'], $userInfo['passwordHash'], $userInfo['_id']);
    }
    public function createUser(&$userObject){
        $userArray = [
            'username' => $userObject->username,
            'passwordHash' => $userObject->passwordHash,
            'email' => $userObject->email,
            '_id' => new ObjectID()
        ];
        $user = $this->getUser($userObject->id);
        if($user == null){
            $this->db->users->insertOne($userArray);
            $userObject->id = $userArray['_id'];
        }
    }

    public function updateUser($user){
        if($user == null)
            return;
        $currentUser = $this->getUser($user->id);
        if($currentUser != null){
            $userInfo = [
                'username' => $user->username,
                'passwordHash' => $user->passwordHash,
                'email' => $user->email,
                '_id' => new ObjectID($user->id)
            ];
            $this->db->users->replaceOne(['_id' => new ObjectID($user->id)], $userInfo);
        }
    }

    public function deleteUser($user){
        if($user != null && $this->getUser($user->id) != null){
            $this->db->users->deleteOne(['_id' => new ObjectID($user->id)]);
        }
    }

    // Photos
    public function getPhotos(){
        $photos = [];
        foreach($this->db->photos->find()->toArray() as $photo){
            $photos[] = new Photo($photo['title'], $photo['author'], $photo['ownerId'], $photo['private'], $photo['_id']);
        }
        return $photos;
    }
    public function getPhoto($id){
        $photoInfo = $this->db->photos->findOne(['_id' => new ObjectID($id)]);
        if ($photoInfo == null)
            return null;
        return new Photo($photoInfo['title'], $photoInfo['author'], $photoInfo['ownerId'], $photoInfo['private'], $photoInfo['_id']);
    }
    public function createPhoto(&$photoObject){
        if($photoObject == null)
            return;
        $photoArray = [
            'title' => $photoObject->title,
            'author' => $photoObject->author,
            'ownerId' => $photoObject->ownerId,
            'private' => $photoObject->private,
            '_id' => new ObjectID()
        ];
        $photo = $this->getPhoto($photoObject->id);
        if($photo == null){
            $this->db->photos->insertOne($photoObject);
            $photoObject->id = $photoArray['_id'];
        }
    }

    public function updatePhoto($photo){
        if($photo == null)
            return;
        $currentPhoto = $this->getPhoto($photo->id);
        if($currentPhoto != null){
            $photoInfo = [
                'title' => $photo->title,
                'author' => $photo->author,
                'ownerId' => $photo->ownerId,
                'private' => $photo->private,
                '_id' => new ObjectID($photo->id)
            ];
            $this->db->photos->replaceOne(['_id' => new ObjectID($photo->id)], $photoInfo);
        }
    }

    public function deletePhoto($photo){
        if($photo != null && $this->getPhoto($photo->id) != null){
            $this->db->photos->deleteOne(['_id' => new ObjectID($photo->id)]);
        }
    }

}