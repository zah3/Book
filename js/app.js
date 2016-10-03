$(function(){
    var loadAllBooks = function(){
        
        var bookList = $("#listWithBooks");
        $.ajax({
            url: "http://192.168.33.22/REST_Bookshelf/api/Books.php",
            method: "GET",
            dataType: "JSON"
        }).done(function(bookNamesArray){
            bookList.empty();
            for (var i = 0; i < bookNamesArray.length; i++){
                var newLi = $("<li>");
                var removeButton = $("<button class='delBtn'>Usuń</button>");
                var showButton = $("<button class='showBtn'>Wiecej informacji</button>");
                
                newLi.attr("data-id", bookNamesArray[i].id);
                newLi.text(bookNamesArray[i].name);
                
                newLi.append(showButton);
                newLi.append(removeButton);
                
                bookList.append(newLi);
            }
        }).fail(function(xhr, status, error){
            console.log("Load all books ajax failed");
        });
    };
    loadAllBooks();
// show div with book

    var booksList = $("#listWithBooks");
    booksList.on("click",".showBtn", function(event){
       var button = $(this);
       var buttonParent = $(this).parent(); 
       var bookId = buttonParent.data("id");
        $.ajax({
            url:"http://192.168.33.22/REST_Bookshelf/api/Books.php",
            method: "GET",
            data: {id: bookId},
            dataType: "JSON"
        }).done(function(book){
            var newDiv = $("<div><h1>"+ book.name + "</h1><p>"+ book.author +"</p><p>"+ book.description + "</p></div>");
            buttonParent.append(newDiv);
            button.removeClass("showBtn");
            button.text("Zwiń informacje");
            button.addClass("hideBtn");
            console.log('click')
            
        }).fail(function(xhr, status, error){
            console.log("AJAX failed when reading book with id " + bookId);
        })
    });

// hide a div with book.

    booksList.on("click",".hideBtn", function(event){
       var button = $(this);
       var buttonParent = $(this).parent(); 
       var bookId = buttonParent.data("id");
       var div = buttonParent.find("div");
       
        $.ajax({
            url:"http://192.168.33.22/REST_Bookshelf/api/Books.php",
            method: "GET",
            data: {id: bookId},
            dataType: "JSON"
        }).done(function(book){
            div.remove();
            button.removeClass("hideBtn");
            button.text("Więcej informacji");
            button.addClass("showBtn");
            
        }).fail(function(xhr, status, error){
            console.log("AJAX failed when reading book with id " + bookId);
        })
    });
    var submit = $('#submit');
    submit.on('click', function(event){
        event.preventDefault();
        var name = $('input#name').val();
        var author = $('input#author').val();
        var description = $('input#description').val();
        $.ajax({
            url:"http://192.168.33.22/REST_Bookshelf/api/Books.php",
            method:"POST",
            data: $('form').serialize(),
            dataType:'text'
        }).done(function(book){
            console.log("Success");
        }).fail(function(xhr, status, error){
            console.log('AJAX failed during add a new book');
        });
        location.reload();
    });
    // sending by post new book.

    booksList.on("click",".delBtn", function(event){
        event.preventDefault();
        var button = $(this);
        var buttonParent = $(this).parent();
        var bookId = "id=" + buttonParent.data("id");
        console.log(bookId);
        $.ajax({
            url:"http://192.168.33.22/REST_Bookshelf/api/Books.php",
            method: "DELETE",
            data:  bookId,
            dataType: 'JSON'
        }).done(function(book){
            console.log('Book has been deleted');
        }).fail(function(xhr, status, error){
            alert( "Sorry, there was a problem!" );
            console.log( "Error: " + error );
            console.log( "Status: " + status );
            console.dir( xhr );
        });

    });


       
      
    
});
