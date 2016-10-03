<?php
require_once('./src/conn.php');
if($_SERVER['REQUEST_METHOD'] === "GET" ){
    if(isset($_GET['id'])){
        $bookToshow = new Book();
        $bookToshow ->loadFromDB($_GET['id'], $conn);
        $bookToshowJSON = json_encode($bookToshow->toArray());
        echo($bookToshowJSON);
        // show information about book
    }
    else{
        $allBooksNames = Book::GetBooksNames($conn);
        $allBooksNamesJSON = json_encode($allBooksNames);
        echo($allBooksNamesJSON);
    }
    
}
// add a new book
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(!empty($_POST['author']) && !empty($_POST['name'])&& !empty($_POST['author'])) {

        $book = new book();
        $book->setAuthor($_POST['author']);
        $book->setName($_POST['name']);
        $book->setDescription($_POST['description']);
        $book->saveToDB($conn);
    }else{
        echo "Is there en empties";
    }
}
if($_SERVER['REQUEST_METHOD'] == 'DELETE'){

    $bookToDelete = new Book();
    parse_str(file_get_contents("php://input"), $deleteBook);
    $bookId = $deleteBook['id'];
    $bookToDelete->lodfromDB($bookId,$conn);
    $bookToDelete->deleteFromDB($conn, $bookId);
    $bookToDeleteJSON = json_encode($bookToDelete);
    echo($bookToDeleteJSON);

}