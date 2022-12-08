// $(document).ready(function() {
//     $(".filter-item1").on('mouseover', 'option', function(e) {
//         $(".filter-item1-option").css("display", "none");
//     })

//     $(".filter-item1").on('mouseout', 'option', function(e) {
//         $(".filter-item1-option").css("display", "block");
//     })
// });

// $(".filter-item1-option").css("display", "none");

// $(".filter-item1").hover(function() {
//     $(".filter-item1-option").css("display", "block")
// })

//------------------------------------- FILTERING OPTIONS-------------------------------------------------------
$(".filter-option").css("display", "none");

$(".filter-item1-option").on('mouseout', function(e) {
    $(".filter-option").css("display", "none");
})

$(".filter-item1-option").on('mouseover', function(e) {
    $(".filter-option").css("display", "block");
})

// Selecting brands on selecting option brand 
function isBrandSelected(elem)
{
    if(elem.checked){
        //Filtering brands
        $(".filter-item2-brand").css("display", "block");
        $(".filter-brand").css("display", "none");

        $(".filter-item2-brand").on('mouseout', function(e) {
            $(".filter-brand").css("display", "none");
        })

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
        //Filtering year
        $(".filter-item4-storage").css("display", "block");
        $(".filter-storage").css("display", "none");

        $(".filter-item4-storage").on('mouseout', function(e) {
            $(".filter-storage").css("display", "none");
        })
        
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
        //Filtering year
        $(".filter-item5-weight").css("display", "block");
        $(".filter-weight").css("display", "none");

        $(".filter-item5-weight").on('mouseout', function(e) {
            $(".filter-weight").css("display", "none");
        })
        
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
        //Filtering year
        $(".filter-item6-price").css("display", "block");
        $(".filter-price").css("display", "none");

        $(".filter-item6-price").on('mouseout', function(e) {
            $(".filter-price").css("display", "none");
        })
        
        $(".filter-item6-price").on('mouseover', function(e) {
            $(".filter-price").css("display", "block");
        })
    }
    else{
        $(".filter-item6-price").css("display", "none");
    }
};



// Sort

$(".sort-items").css("display", "none");

$(".sort").on('mouseout', function(e) {
    $(".sort-items").css("display", "none");
})

$(".sort").on('mouseover', function(e) {
    $(".sort-items").css("display", "block");
})


