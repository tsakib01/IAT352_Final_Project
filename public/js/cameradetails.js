$(document).ready(function(){

    // adds a review using ajax and retrieves the updated list to display in the page
    $(".add-review-form").submit(function(event){
        event.preventDefault();
        var data = $(this).serializeArray();
        data.push({name: "add-review", value: "add-review"});

        console.log("data", data);

        //write an AJAX request to send the data to the server (addreviews.php)
        var request = $.ajax({
            url: "../public/addreviews.php",
            method: "post",
            data: data
        })

        request.done(function(data){
            console.log(data);
            
            var dataOut = JSON.parse(data);

            console.log(dataOut.message);


            $(".message").html("");
            $(".message").append(`${dataOut.message}`);

            $(".comments-area").html("");

            dataOut.reviews.forEach(element => {
                $(".comments-area").append(`
                    <div class='comments'>
                    <h3><strong>Date: ${element.date} User: ${element.email}</h3>
                    <p>${element.comments}</p>
                    </div>
                `)
            })
        })
    
        request.fail(function(msg){
            console.log(msg);
        });
    });

    // adds the product to watchlist using ajax
    $(".add-to-watchlist-form").submit(function(event){
        event.preventDefault();
        var data = $(this).serializeArray();
        data.push({name: "add-to-watchlist", value: "add"});

        console.log("data", data);

        //write an AJAX request to send the data to the server (addreviews.php)
        var request = $.ajax({
            url: "../public/addtowatchlist.php",
            method: "post",
            data: data
        })

        request.done(function(data){
            console.log(data);
            
            var dataOut = JSON.parse(data);

            console.log(dataOut.message);

            $(".add-message").html("");
            $(".add-message").append(`<br>${dataOut.message}`);

        })
    
        request.fail(function(msg){
            console.log(msg);
        });
    });
})