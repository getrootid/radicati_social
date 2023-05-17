(function ($, Drupal) {
  'use strict';
  Drupal.behaviors.socialShare = {
    attach: function (context, settings) {

      $('.social-share__link.social-popup').once().on('click', function() {
        var screenLeft = window.screenLeft;
        var screenTop = window.screenTop;

        var width = window.outerWidth;
        var height = window.outerHeight;

        var popupWidth = 626;
        var popupHeight = 436;

        var left = screenLeft + (width/2) - (popupWidth / 2);
        var top = screenTop + (height/2) - (popupHeight / 2);

        var url = $(this).attr('href');

        window.open(url, '', 'toolbar=0,status=0,width=626,height=436,left=' + left + ',top='+top);
        return false;
      });

      $('.social-share__link.social-copy-link').once().on('click', function() {
        if(navigator.clipboard !== undefined) {
          navigator.clipboard.writeText(window.location.href);

        } else {
          var dummy = document.createElement('input'),
          text = window.location.href;
          document.body.appendChild(dummy);
          dummy.value = window.location.href;
          dummy.select();
          document.execCommand('copy');
          document.body.removeChild(dummy);
        }


        $('.social-share__link__label', this).html(Drupal.t('Link Copied'));
        $('.social-share__link__label', this).css('display', 'block');
        var $that = $('.social-share__link__label', this);

        setTimeout( function() {
          $that.css('display', 'none');
        }, 2000);
        return false;
      });
    }
  };
})(jQuery, Drupal);
