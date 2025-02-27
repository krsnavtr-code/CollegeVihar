$(".owl-carousel").owlCarousel({
  loop: true,
  margin: 10,
  autoplay: true,
  items: 1,
  nav: false,
});

const counter = () => {
  const counts = document.querySelectorAll(".count");

  counts.forEach((count) => {
    const initialCount = parseInt(count.getAttribute("initial-count"));
    count.innerText = 1;

    setInterval(() => {
      if (count.innerText < initialCount) {
        count.innerText++;
      }
    }, 50);
  });
};

counter()

// window.addEventListener("scroll", counter);
