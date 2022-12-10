$(document).ready(function(){

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
})