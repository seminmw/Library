$(document).ready(function(){

    function registerAjaxApiAuthors() {
        $('body').on('click', '.js-getDataByAuthors', function(e){

            var id = $(this).attr('id');

            var request = $.ajax({
                url: "/api/api.authors.php",
                method: "POST",
                data: { id : id },
                dataType: "json"
            });

            request.done(function( res ) {
                if(res.status === 'ok') {
                    var content = '';

                    for(var i = 0; i < res.data.length; i++) {
                        var id = res.data[i].id;
                        var name = res.data[i].name;

                        content += `<a href="author.php?id=${id}"> ${name} </a> <br>`
                    }

                    $(".modal-body").html(content);
                } else {
                    $(".modal-body").text('Empty data');
                }
            });

            request.fail(function( jqXHR, textStatus ) {
                alert( "Request failed: " + textStatus );
            });
        });
    }


    function registerAjaxApiBooks() {
        $('body').on('click', '.js-getDataByBooks', function(e){

            var id = $(this).attr('id');

            var request = $.ajax({
                url: "/api/api.books.php",
                method: "POST",
                data: { id : id },
                dataType: "json"
            });

            request.done(function( res ) {
                if(res.status === 'ok') {
                    var content = '';

                    for(var i = 0; i < res.data.length; i++) {
                        var id = res.data[i].id;
                        var title = res.data[i].title;

                        content += `<a href="book.php?id=${id}"> ${title} </a> <br>`
                    }

                    $(".modal-body").html(content);
                } else {
                    $(".modal-body").text('Empty data');
                }
            });

            request.fail(function( jqXHR, textStatus ) {
                alert( "Request failed: " + textStatus );
            });
        });
    }

    function registerModelHide(){
        $('#exampleModal').on('hide.bs.modal', function (e) {
            $(".modal-body").text('');
        })
    }

    function registerBookFormEvents() {
        $("#js-showAuthor").on('click', function(e) {
            $(".js-newAuthor").show();
            $(".js-newAuthors").hide();
        });

        $("#js-showAuthors").on('click', function(e) {
            $(".js-newAuthors").show();
            $(".js-newAuthor").hide();
        });
    }

    function registerAuthorFormEvents() {
        $("#js-showBook").on('click', function(e) {
            $(".js-newBook").show();
            $(".js-newBooks").hide();
        });

        $("#js-showBooks").on('click', function(e) {
            $(".js-newBooks").show();
            $(".js-newBook").hide();
        });
    }

    registerAjaxApiAuthors();
    registerAjaxApiBooks();

    registerModelHide();

    registerAuthorFormEvents();
    registerBookFormEvents();
});