<?php

class Book{
    static public function GetBooksNames(mysqli $conn){
        $ret =[];
        $sql = "SELECT id, name FROM Books";
        $result = $conn->query($sql);
        
        if($result != false){
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $ret[] = $row;
                }
            }
        }
        
        return $ret;
    }
    
    private $id;
    private $name;
    private $author;
    private $description;
    
    public function __construct(){
        $this->id = -1;
        $this->name = "";
        $this->author = "";
        $this->description = "";
    }
    public function getId(){
        return $this->id;
    }
    public function setName($newTitle){
        $this->name = $newTitle;
    }
    public function getTitle(){
        return $this->name;
    }
    public function setAuthor($newAuthor){
        $this->author = $newAuthor;
    }
    public function getAuthor(){
        return $this->author;
    }
    public function setDescription($newDescription){
        $this->description = $newDescription;
    }
    public function getDescription(){
        return $this->description;
    }
    public function loadFromDB($id, mysqli $conn){
        $sql = "SELECT * FROM Books WHERE id = {$id}";
        $result = $conn->query($sql);
        if($result != false){
            if($result->num_rows === 1){
                $row = $result->fetch_assoc();
                $this->id = (int)$row['id'];
                $this->name = $row['name'];
                $this->author = $row['author_name'];
                $this->description = $row['description'];
                return true;
            }
        }
        return false;
    }
    public function saveToDB(mysqli $conn){
        if($this->id === -1){
            //pierwszy zapis do bazy danych;
            $sql = "INSERT INTO Books(name, author_name, description) Values('{$this->name}', '{$this->author}', '{$this->description}')";
            $result = $conn->query($sql);

            if($result == true){
                $this->id = $conn->insert_id;
                return true;
            }
        }
        else{
            //update do bazy danych;
        }
    }
    public function deleteFromDB(mysqli $conn, $id){
        $sql = "Delete FROM Books WHERE id = {$id}";
        $result = $conn->query($sql);
        if ($result === TRUE) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . $conn->error;
        }

    }
    public function toArray(){
        $ret = [];
        $ret['id'] = $this->id;
        $ret['name'] = $this->name;
        $ret['author'] = $this->author;
        $ret['description'] = $this->description;
        
        return $ret;
    }
    
}