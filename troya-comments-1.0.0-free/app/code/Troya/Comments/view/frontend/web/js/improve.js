define([
        "jquery"
    ], function ($) {
        "use strict";
        return function (config, element) {
            $(document).on("click", '.troya-reply', function(event) {
                var parentReviewId = $(this).attr('id');
                var paramToPOST = '<input id="troya-comments-parent-id" type="hidden" name="' + config.related + '" value="' + parentReviewId + '" />';
                if ($('#troya-comments-parent-id').length) {
                    $('#troya-comments-parent-id').val(parentReviewId);
                } else {
                    $(this).parents('#reviews').find('form').append(paramToPOST);
                }

                $(this).parents('.troya-comments').find('.troya-cancel').css('display', 'inline-block');
                $(this).parents('.review-items').children('li').each(function () {
                    if ( $(this).attr('item-rew-id') < parentReviewId) {
                        $(this).css('display', 'none');
                    }
                });
                $(this).css('display', 'none');
            });

            $(document).on("click", '.troya-cancel', function(event) {
                var parentReviewId = $(this).attr('id');
                $('#troya-comments-parent-id').val(0);
                $(this).parents('.troya-comments').find('.troya-reply').css('display', 'inline-block');

                $(this).parents('.review-items').find('li').each(function () {
                    if ( $(this).attr('item-rew-id') < parentReviewId) {
                        $(this).css('display', 'block');
                    }
                });

                $(this).css('display', 'none');
            });



        }
    }
)