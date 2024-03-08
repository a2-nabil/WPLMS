jQuery(document).ready(function ($) {
  $(window).on("load", function () {
    var currentX = 0,
      currentY = 0,
      animationSpeed = 8,
      count = 0,
      windowW = $(this).width(),
      windowH = $(this).height(),
      hovered = false,
      pulsed = false,
      activeButton = 0,
      loaded = false;

    var x = 0,
      y = 0,
      a2n_mouse = $(".a2n_mouse");
    $(window).on("mousemove", function (e) {
      loaded = true;
      if (!hovered) {
        x = e.pageX;
        y = e.pageY;
      }
    });

    function move() {
      count++;
      if (!loaded) {
        x = windowW / 2 + Math.sin(count / 20) * (windowW / 4);
        y = windowH / 2;
      }
      var boxCenter = [
        a2n_mouse.offset().left + a2n_mouse.width() / 2,
        a2n_mouse.offset().top + a2n_mouse.height() / 2,
      ];

      var angle =
        Math.atan2(x - boxCenter[0], -(y - boxCenter[1])) * (180 / Math.PI);
      var speedX = Math.abs(x - currentX),
        speedY = Math.abs(y - currentY),
        speed = Math.sqrt(speedX * speedX + speedY * speedY) * -1;

      if (speed > -1) {
        speed = 0;
      }

      var scale = speed / 500 + 1;
      var tailPos = speed / 10 + 50;

      if (tailPos < 0) {
        tailPos = 0;
      } else if (tailPos > 40) {
        tailPos = 50;
      }

      if (scale < 0.2) {
        scale = 0.2;
      }

      currentX += (x - currentX) / animationSpeed;
      currentY += (y - currentY) / animationSpeed;

      if (hovered) {
        angle = 0;
        scale = 1;
        tailPos = 50;

        if (Math.abs(x - currentX) < 10 && Math.abs(y - currentY) < 10) {
          if (!pulsed) {
            activeButton.addClass("pulse");
            pulsed = true;
          }
        }
      }

      a2n_mouse.css({
        transform:
          "translate(" + (currentX - 0) + "px, " + (currentY - 0) + "px)",
      });

      window.requestAnimationFrame(move);
    }

    window.requestAnimationFrame(move);

    $(".slider_container").on("mouseenter", function () {
      hovered = false;
      pulsed = false;
      activeButton = $(this);
      x = $(this).offset().left + $(this).width() / 2;
      y = $(this).offset().top + $(this).height() / 2;

      a2n_mouse.addClass("button-hover");

      $(this).on("mouseleave", function () {
        hovered = false;
        a2n_mouse.removeClass("button-hover");
        $(this).removeClass("pulse");
      });
    });
  });
});
