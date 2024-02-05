// Check if browser supports WebP
function supportsWebP() {
    var elem = document.createElement('canvas');

    if (!!(elem.getContext && elem.getContext('2d'))) {
        return elem.toDataURL('image/webp').indexOf('data:image/webp') == 0;
    }

    return false;
}

// If WebP isn't supported, switch to PNG
if (!supportsWebP()) {
    var special = document.querySelector('.section-special');
    var images = document.querySelectorAll('img[data-fallback]');
    images.forEach(function(img) {
        img.src = img.getAttribute('data-fallback');
    });
}


document.addEventListener("DOMContentLoaded", function() {
    var loadMoreButton = document.querySelector('.loadMoreButton');
    var articleCount = document.querySelectorAll('.special_article-container').length;
    var assetBottom = document.querySelector('.special_asset_bot');
    var rowAddBottom = document.querySelector('.row-add');

    if(loadMoreButton != null){
        
        loadMoreButton.addEventListener('click', function() {
            
            if(rowAddBottom != null){
                rowAddBottom.classList.remove('row-add-margin');
            }

            var hiddenRows = document.querySelectorAll('.hidden-row');

            for (var i = 0; i <= 4 && i < hiddenRows.length; i++) {
                hiddenRows[i].classList.add('show-article');
                hiddenRows[i].classList.remove('hidden-row');
            }

            var remainingHiddenRows = document.querySelectorAll('.hidden-row');

            if (remainingHiddenRows.length === 0) {
                loadMoreButton.style.display = "none";
                if( assetBottom != null && articleCount % 2 === 1){
                    assetBottom.classList.add('asset_bottom_right');
                } else if(rowAddBottom != null && articleCount % 2 === 0){
                    rowAddBottom.classList.add('row-add-margin');
                }
            }
        });

    }

});




jQuery(function($) {
    jQuery(document).ready(function(){
      $('.special_roll-brown').slick({
        rtl: false,
        vertical: false,
        infinite: true,
        slidesToShow: 15,
        slidesToScroll: 1,
        variableWidth: true,
        mobileFirst: true,
        centerMode: false,
        dots: false,
        draggable: true,
        swipe: true,
        touchMove: true,
        touchThreshold: 45,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 0,
        speed: 13000,
        pauseOnHover: false,
        pauseOnFocus: false,
        cssEase: 'linear'
      });                              
    });
});


