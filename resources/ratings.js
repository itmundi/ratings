var ratings = {
    settings: {
        cancel      : false,                                          // Creates a cancel button to cancel the rating.
        cancelClass : 'raty-cancel',                                  // Name of cancel's class.
        cancelHint  : 'Cancel this rating!',                          // The cancel's button hint.
        cancelOff   : 'cancel-off.png',                               // Icon used on active cancel.
        cancelOn    : 'cancel-on.png',                                // Icon used inactive cancel.
        cancelPlace : 'left',                                         // Cancel's button position.
        click       : function(score){                                // Callback executed on rating click.
            if($(this).data('click-submit') != false) {
                ratings.handleClick(this, score)
            }
        },
        half        : true,                                           // Enables half star selection.
        halfShow    : true,                                           // Enables half star display.
        hints       : ['slecht', 'matig', 'voldoende', 'goed', 'fantastisch'], // Hints used on each star.
        iconRange   : undefined,                                      // Object list with position and icon on and off to do a mixed icons.
        mouseout    : undefined,                                      // Callback executed on mouseout.
        mouseover   : undefined,                                      // Callback executed on mouseover.
        noRatedMsg  : 'Not rated yet!',                               // Hint for no rated elements when it's readOnly.
        number      : 5,                                              // Number of stars that will be presented.
        numberMax   : 20,                                             // Max of star the option number can creates.
        path        : undefined,                                      // A global locate where the icon will be looked.
        precision   : false,                                          // Enables the selection of a precision score.
        readOnly    : function(){                                     // Turns the rating read-only.
            return $(this).data('given-score') > 0
        },
        round       : { down: .25, full: .6, up: .76 },               // Included values attributes to do the score round math.
        score       : function(){                                     // Initial rating.
            return $(this).data('given-score')
        },
        scoreName   : function(){                                     // Name of the hidden field that holds the score value.
            var name = $(this).data('name');
            return name == ''? 'score' : name;
        },
        single      : false,                                          // Enables just a single star selection.
        space       : true,                                           // Puts space between the icons.
        starHalf    : 'star-half.png',                                // The name of the half star image.
        starOff     : 'star-off.png',                                 // Name of the star image off.
        starOn      : 'star-on.png',                                  // Name of the star image on.
        target      : undefined,                                      // Element selector where the score will be displayed.
        targetFormat: '{score}',                                      // Template to interpolate the score in.
        targetKeep  : false,                                          // If the last rating value will be kept after mouseout.
        targetScore : undefined,                                      // Element selector where the score will be filled, instead of creating a new hidden field (scoreName option).
        targetText  : '',                                             // Default text setted on target.
        targetType  : 'hint',                                         // Option to choose if target will receive hint o 'score' type.
        starType    : 'i'                                             // Element used to represent a star.
    },

    handleClick: function(element, score) {
        var elementId = $(element).data('entry-id');
        $('[data-entry-id="' + elementId + '"]').html($(element).html());
        ratings.rate(elementId, Math.ceil(score * 2));
    },

    rate: function (id, rating) {
        var data = {'id':id, 'rating':rating};
        data[window.csrfTokenName] = window.csrfTokenValue;
        $.post('/actions/ratings/rate', data );
    }
};

$(function() {
    $('.raty').raty(ratings.settings);
});

window.ratings = ratings;
