function size_img_optimizaciya() {
        if (screen.width <= '300') {
          [].forEach.call(document.querySelectorAll('img[data-src-300px]'), function(img) {
            img.setAttribute('src', img.getAttribute('data-src-300px'));
            });
        }
        else if ((screen.width > '300') && (screen.width <= '400')) {
          [].forEach.call(document.querySelectorAll('img[data-src-400px]'), function(img) {
            img.setAttribute('src', img.getAttribute('data-src-400px'));
            });
        }
        else if ((screen.width > '400') && (screen.width <= '500')) {
          [].forEach.call(document.querySelectorAll('img[data-src-500px]'), function(img) {
            img.setAttribute('src', img.getAttribute('data-src-500px'));
            });
        }
        else if ((screen.width > '500') && (screen.width <= '600')) {
          [].forEach.call(document.querySelectorAll('img[data-src-600px]'), function(img) {
            img.setAttribute('src', img.getAttribute('data-src-600px'));
            });
        }
        else if ((screen.width > '600') && (screen.width <= '700')) {
          [].forEach.call(document.querySelectorAll('img[data-src-700px]'), function(img) {
            img.setAttribute('src', img.getAttribute('data-src-700px'));
            });
        }
        else if ((screen.width > '700') && (screen.width <= '800')) {
          [].forEach.call(document.querySelectorAll('img[data-src-800px]'), function(img) {
            img.setAttribute('src', img.getAttribute('data-src-800px'));
            });
        }
        else if ((screen.width > '800') && (screen.width <= '900')) {
          [].forEach.call(document.querySelectorAll('img[data-src-900px]'), function(img) {
            img.setAttribute('src', img.getAttribute('data-src-900px'));
            });
        }
        else if ((screen.width > '900') && (screen.width <= '1000')) {
          [].forEach.call(document.querySelectorAll('img[data-src-1000px]'), function(img) {
            img.setAttribute('src', img.getAttribute('data-src-1000px'));
            });
        }
        else if ((screen.width > '1000') && (screen.width <= '1100')) {
          [].forEach.call(document.querySelectorAll('img[data-src-1100px]'), function(img) {
            img.setAttribute('src', img.getAttribute('data-src-1100px'));
            });
        }
        else if ((screen.width > '1100') && (screen.width <= '1200')) {
          [].forEach.call(document.querySelectorAll('img[data-src-1200px]'), function(img) {
            img.setAttribute('src', img.getAttribute('data-src-1200px'));
            });
        }
        else if ((screen.width > '1200') && (screen.width <= '1300')) {
          [].forEach.call(document.querySelectorAll('img[data-src-1300px]'), function(img) {
            img.setAttribute('src', img.getAttribute('data-src-1300px'));
            });
        }
        else if ((screen.width > '1300') && (screen.width <= '1400')) {
          [].forEach.call(document.querySelectorAll('img[data-src-1400px]'), function(img) {
            img.setAttribute('src', img.getAttribute('data-src-1400px'));
            });
        }
        else if ((screen.width > '1400') && (screen.width <= '1600')) {
          [].forEach.call(document.querySelectorAll('img[data-src-1600px]'), function(img) {
            img.setAttribute('src', img.getAttribute('data-src-1600px'));
            });
        }
        else if ((screen.width > '1600') && (screen.width <= '1800')) {
          [].forEach.call(document.querySelectorAll('img[data-src-1800px]'), function(img) {
            img.setAttribute('src', img.getAttribute('data-src-1800px'));
            });
        }
        else if ((screen.width > '1800') && (screen.width <= '2000')) {
          [].forEach.call(document.querySelectorAll('img[data-src-2000px]'), function(img) {
            img.setAttribute('src', img.getAttribute('data-src-2000px'));
            });
        }
        else if ((screen.width > '2000') && (screen.width <= '2500')) {
          [].forEach.call(document.querySelectorAll('img[data-src-2500px]'), function(img) {
            img.setAttribute('src', img.getAttribute('data-src-2500px'));
            });
        }
        else if ((screen.width > '2500') && (screen.width <= '3000')) {
          [].forEach.call(document.querySelectorAll('img[data-src-3000px]'), function(img) {
            img.setAttribute('src', img.getAttribute('data-src-3000px'));
            });
        }
        else if ((screen.width > '3000') && (screen.width <= '4000')) {
          [].forEach.call(document.querySelectorAll('img[data-src-4000px]'), function(img) {
            img.setAttribute('src', img.getAttribute('data-src-4000px'));
            });
        }
        else if ((screen.width > '4000') && (screen.width <= '5000')) {
          [].forEach.call(document.querySelectorAll('img[data-src-5000px]'), function(img) {
            img.setAttribute('src', img.getAttribute('data-src-5000px'));
            });
        }
        else if ((screen.width > '5000') && (screen.width <= '6000')) {
          [].forEach.call(document.querySelectorAll('img[data-src-6000px]'), function(img) {
            img.setAttribute('src', img.getAttribute('data-src-6000px'));
            });
        }
        else if ((screen.width > '6000') && (screen.width <= '7000')) {
          [].forEach.call(document.querySelectorAll('img[data-src-7000px]'), function(img) {
            img.setAttribute('src', img.getAttribute('data-src-7000px'));
            });
        }
        else if ((screen.width > '7000') && (screen.width <= '8000')) {
          [].forEach.call(document.querySelectorAll('img[data-src-8000px]'), function(img) {
            img.setAttribute('src', img.getAttribute('data-src-8000px'));
            });
        }
        else if (screen.width > '8000') {
          [].forEach.call(document.querySelectorAll('img[data-src-max]'), function(img) {
            img.setAttribute('src', img.getAttribute('data-src-max'));
            });
        }
        else {
          [].forEach.call(document.querySelectorAll('img[data-src]'), function(img) {
            img.setAttribute('src', img.getAttribute('data-src'));
            });
        };

        [].forEach.call(document.querySelectorAll('img[data-src]'), function(img) {
            img.setAttribute('src', img.getAttribute('data-src'));
        });
 
};
size_img_optimizaciya();

$(window).resize(function() {
        size_img_optimizaciya();
});
