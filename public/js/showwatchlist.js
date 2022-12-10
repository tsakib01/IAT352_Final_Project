$(document).ready(function() {

  
    // shows the checkout and remove option once the edit watchlist button is clicked
    $('.edit-watchlist-btn').on('click', function(event) {
      event.preventDefault();
      $('.done-editing-btn').css("display", "inline");
      $('.edit-watchlist-btn').css("display", "none");
      $('.show-watchlist-option').css("display", "flex");  
    })

    // hides the checkout and remove option once the done editing button is clicked
    $('.done-editing-btn').on('click', function(event) {
        event.preventDefault();
        $('.done-editing-btn').css("display", "none");
        $('.edit-watchlist-btn').css("display", "inline");
        $('.show-watchlist-option').css("display", "none");
    })

    // clicking the remove button will remove the item from the database asynchronously
    // the item will be removed from the page as well at the same time
    $(".remove-from-watchlist-form").submit(function(event){
      event.preventDefault();
      var data = $(this).serializeArray();
      data.push({name: "api_endpoint_name", value: "remove_item"});

      console.log("data", data);

      //write an AJAX request to send the data to the removefromwatchlist.php
      var request = $.ajax({
          url: "../public/removefromwatchlist.php",
          method: "post",
          data: data
      })

      request.done(function(data){
          console.log(data);
          var result = JSON.parse(data);
          
          var item = ".item" + result.cid;
          console.log(item);
          
          $(item).remove();
      })
  
      request.fail(function(msg){
          console.log(msg);
      });
  });
  
  });