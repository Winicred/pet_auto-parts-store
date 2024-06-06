import './bootstrap';
import './search';

import.meta.glob([
  '../images/**',
  '../fonts/**',
]);

const modalToggle = document.querySelectorAll(".modal-toggle");
modalToggle.forEach((el) => {
  el.addEventListener("change", () => {
    if (el.checked) {
      document.body.style.overflowY = "hidden";
    } else {
      document.body.style.overflowY = "auto";
    }
  });
});

document.addEventListener("DOMContentLoaded", function() {
  const lazyImages = [].slice.call(document.querySelectorAll("img.lazy-image"));

  lazyImages.forEach((lazyImage) => {
    lazyImage.style.height = "100%";
  });

  if ("IntersectionObserver" in window) {
    const lazyImageObserver = new IntersectionObserver((entries, observer) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          const lazyImage = entry.target;

          if (!lazyImage.dataset.format) {
            fetch(lazyImage.dataset.src)
              .then(response => response.blob())
              .then(blob => {

                const reader = new FileReader();
                reader.onload = () => {
                  lazyImage.src = reader.result;
                  lazyImage.classList.remove("lazy-image");
                  lazyImage.style.height = "auto";
                  lazyImageObserver.unobserve(lazyImage);
                };
                reader.readAsDataURL(blob);
              });
          } else {
            // load from local
            lazyImage.src = lazyImage.dataset.src;
            lazyImage.classList.remove("lazy-image");
            lazyImage.style.height = "auto";
            lazyImageObserver.unobserve(lazyImage);
          }
        }
      });
    });

    lazyImages.forEach((lazyImage) => {
      lazyImageObserver.observe(lazyImage);
    });
  }
});