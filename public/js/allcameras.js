// Filter

// hide items under filter
$(".filter-option").css("display", "none");

// on mouse out of the filter will hide all the options under it
$(".filter-item1-option").on('mouseout', function(e) {
    $(".filter-option").css("display", "none");
})

// on mouse over the filter will show all options to select for sorting
$(".filter-item1-option").on('mouseover', function(e) {
    $(".filter-option").css("display", "block");
})

// Selecting brands on selecting option brand 
function isBrandSelected(elem)
{
    if(elem.checked){
        // no brand option will be shown
        $(".filter-item2-brand").css("display", "block");
        $(".filter-brand").css("display", "none");

        // moving mouse out will hide the options under brand
        $(".filter-item2-brand").on('mouseout', function(e) {
            $(".filter-brand").css("display", "none");
        })

        // moving mouse over will show all the options under brand
        $(".filter-item2-brand").on('mouseover', function(e) {
            $(".filter-brand").css("display", "block");
        })
    }
    else{
        $(".filter-item2-brand").css("display", "none");
    }
};


// Selecting year on selecting option year 
function isYearSelected(elem)
{
    if(elem.checked){
        //Filtering year
        // no year option will be shown
        // moving mouse out will hide the options under year
        // moving mouse over will show all the options under year
        $(".filter-item3-year").css("display", "block");
        $(".filter-year").css("display", "none");

        $(".filter-item3-year").on('mouseout', function(e) {
            $(".filter-year").css("display", "none");
        })
        
        $(".filter-item3-year").on('mouseover', function(e) {
            $(".filter-year").css("display", "block");
        })
    }
    else{
        $(".filter-item3-year").css("display", "none");
    }
};

// Selecting storage on selecting option storage 
function isStorageSelected(elem)
{
    if(elem.checked){
        // Filtering storage
        // no storage option will be shown
        $(".filter-item4-storage").css("display", "block");
        $(".filter-storage").css("display", "none");

        // moving mouse out will hide the options under storage
        $(".filter-item4-storage").on('mouseout', function(e) {
            $(".filter-storage").css("display", "none");
        })
        
        // moving mouse over will show all the options under storage
        $(".filter-item4-storage").on('mouseover', function(e) {
            $(".filter-storage").css("display", "block");
        })
    }
    else{
        $(".filter-item4-storage").css("display", "none");
    }
};


// Selecting weight on selecting option weight 
function isWeightSelected(elem)
{
    if(elem.checked){
        // Filtering weight
        // no weight option will be shown
        $(".filter-item5-weight").css("display", "block");
        $(".filter-weight").css("display", "none");

        // moving mouse out will hide the options under weight
        $(".filter-item5-weight").on('mouseout', function(e) {
            $(".filter-weight").css("display", "none");
        })

        // moving mouse over will show all the options under weight 
        $(".filter-item5-weight").on('mouseover', function(e) {
            $(".filter-weight").css("display", "block");
        })
    }
    else{
        $(".filter-item5-weight").css("display", "none");
    }
};

// Selecting price on selecting option price 
function isPriceSelected(elem)
{
    if(elem.checked){
        // Filtering price
        // no price option will be shown        
        $(".filter-item6-price").css("display", "block");
        $(".filter-price").css("display", "none");

        // moving mouse out will hide the options under price
        $(".filter-item6-price").on('mouseout', function(e) {
            $(".filter-price").css("display", "none");
        })

        // moving mouse over will show all the options under price
        $(".filter-item6-price").on('mouseover', function(e) {
            $(".filter-price").css("display", "block");
        })
    }
    else{
        $(".filter-item6-price").css("display", "none");
    }
};



// Sort

// hide items under sort
$(".sort-items").css("display", "none");

// on mouse out of the sort will hide all the options under it
$(".sort").on('mouseout', function(e) {
    $(".sort-items").css("display", "none");
})

// on mouse over the sort will show all options to select for sorting
$(".sort").on('mouseover', function(e) {
    $(".sort-items").css("display", "block");
})


// sends the selected options to the server file filterlist.php 
// where the data is retrieved based on the options and returned
$(document).ready(function(){

    $(".apply-filter-form").submit(function(event){
        event.preventDefault();
        var data = $(this).serializeArray();
        data.push({name: "api_endpoint_name", value: "filter_list"});

        //write an AJAX request to send the data to the server filterlist.php
        var request = $.ajax({
            url: "../public/server/filterlist.php",
            method: "post",
            data: data
        })

        // on success adds the matched items in the page
        request.done(function(data){
            console.log(data);
            var result = JSON.parse(data);
            
            $(".camera-list .camera-list").html("");

            result.forEach(element => {
                $(".camera-list .camera-list").append(`
                    <a href="../public/cameradetails.php?cid=${element.cid}">
                    <h2>${element.model}</h2>
                    <img src="${element.url}" alt="Picture of the camera" width='1302' height='868'>
                    <p>Price per day: $ ${Math.round(element.price/10)}</p>
                    </a>
                `)
            })
        })
    
        request.fail(function(msg){
            console.log(msg);
        });
    });
})


