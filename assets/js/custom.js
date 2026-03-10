


$(document).ready(function () {
  $(".ranking-carousel").owlCarousel({
    loop: true,
    margin: 20,
    autoplay: true,
    autoplayTimeout: 3000,
    autoplayHoverPause: true,
    responsive: {
      0: {
        items: 1
      },
      768: {
        items: 2
      },
      992: {
        items: 3
      },
      1200: {
        items: 4
      }
    }
  });

  $(".lab-image-slider").owlCarousel({
    loop: true,
    margin: 10,
    autoplay: true,
    autoplayTimeout: 4000,
    autoplayHoverPause: true,
    smartSpeed: 1000,
    nav: false,
    dots: true,
    items: 1,
    animateOut: 'fadeOut'
  });

  $(".mou-slider").each(function () {
    const $this = $(this);
    const itemsCount = $this.children().length;

    $this.owlCarousel({
      loop: itemsCount > 1,
      margin: 20,
      autoplay: itemsCount > 1,
      autoplayTimeout: 3000,
      autoplayHoverPause: true,
      smartSpeed: 1000,
      nav: false,
      dots: itemsCount > 1,
      responsive: {
        0: {
          items: 1
        },
        768: {
          items: Math.min(itemsCount, 2)
        },
        992: {
          items: Math.min(itemsCount, 4)
        }
      }
    });
  });

  $(document).on('click', '.mou-slider .read-more-btn', function () {
    const card = $(this).closest('.hit-dpt-collab-card');
    const wrapper = card.find('.mou-text-wrapper');
    const btn = $(this);

    // Close other expanded cards
    $('.mou-text-wrapper.expanded').not(wrapper).each(function () {
      $(this).removeClass('expanded');
      $(this).closest('.hit-dpt-collab-card').find('.read-more-btn').html('Read More <i class="bx bx-chevron-down"></i>');
    });

    wrapper.toggleClass('expanded');

    if (wrapper.hasClass('expanded')) {
      btn.html('Read Less <i class="bx bx-chevron-up"></i>');
    } else {
      btn.html('Read More <i class="bx bx-chevron-down"></i>');
    }
  });
});




// counter code js
const counters = document.querySelectorAll('.counter');

const runCounter = (counter) => {
  const target = +counter.getAttribute('data-target');
  const speed = 200;
  const increment = target / speed;

  const update = () => {
    const current = +counter.innerText.replace('+', '');
    if (current < target) {
      counter.innerText = Math.ceil(current + increment) + '+';
      setTimeout(update, 10);
    } else {
      counter.innerText = target.toLocaleString() + '+';
    }
  };
  update();
};

const observer = new IntersectionObserver(entries => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      runCounter(entry.target);
      observer.unobserve(entry.target);
    }
  });
}, { threshold: 1.0 });

counters.forEach(counter => {
  observer.observe(counter);
});


const canvas = document.getElementById('counter-bg');
if (canvas) {
  const ctx = canvas.getContext('2d');
  let width, height;
  let particles = [];

  function resizeCanvas() {
    width = canvas.width = window.innerWidth;
    height = canvas.height = document.querySelector('.counter-section').offsetHeight;
  }

  window.addEventListener('resize', resizeCanvas);
  resizeCanvas();

  class Particle {
    constructor() {
      this.reset();
    }

    reset() {
      this.x = Math.random() * width;
      this.y = Math.random() * height;
      this.radius = Math.random() * 2 + 1;
      this.alpha = Math.random();
      this.dx = Math.random() * 0.5 - 0.25;
      this.dy = Math.random() * 0.5 - 0.25;
    }

    update() {
      this.x += this.dx;
      this.y += this.dy;

      if (this.x < 0 || this.x > width || this.y < 0 || this.y > height) {
        this.reset();
      }
    }

    draw() {
      ctx.beginPath();
      ctx.globalAlpha = this.alpha;
      ctx.fillStyle = '#ffffff';
      ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
      ctx.fill();
    }
  }

  function initParticles(count = 100) {
    particles = [];
    for (let i = 0; i < count; i++) {
      particles.push(new Particle());
    }
  }

  function animate() {
    ctx.clearRect(0, 0, width, height);
    particles.forEach(p => {
      p.update();
      p.draw();
    });
    requestAnimationFrame(animate);
  }

  initParticles();
  animate();
}


// Simple AOS (Animate On Scroll) implementation
document.addEventListener('DOMContentLoaded', function () {
  const animatedElements = document.querySelectorAll('[data-aos]');

  function checkIfInView() {
    animatedElements.forEach(element => {
      const elementTop = element.getBoundingClientRect().top;
      const elementVisible = 150;

      if (elementTop < window.innerHeight - elementVisible) {
        element.classList.add('aos-animate');
      } else {
        element.classList.remove('aos-animate');
      }
    });
  }

  // Initialize animations
  setTimeout(checkIfInView, 100);

  // Add event listener for scroll
  window.addEventListener('scroll', checkIfInView);
});


//////// Institution Selection search ///////
function goToInstitution() {
  const select = document.getElementById('institutionSelect');
  const url = select.value;
  if (url) {
    window.open(url, '_blank');
  } else {
    alert("Please select an institution.");
  }
}


//////// Institution Selection search ///////

//// acadmic page sticky sidebar  start ////

/*
window.addEventListener('scroll', function () {
  const sidebar = document.querySelector('.sticky-sidebar');
  if(!sidebar) return;
  const parent = sidebar.parentElement; // .col-lg-4
  const parentRect = parent.getBoundingClientRect();
  const sidebarRect = sidebar.getBoundingClientRect();

  const stopPoint = parentRect.bottom - sidebarRect.height;

  if (stopPoint <= 100) {
    sidebar.style.position = 'absolute';
    sidebar.style.top = (parent.offsetHeight - sidebar.offsetHeight) + 'px';
  } else {
    sidebar.style.position = 'sticky';
    sidebar.style.top = '100px'; // same as in CSS
  }
});
*/



//// acadmic page sticky sidebar  end ////

/*
  =========================================
  DEPARTMENT CUSTOM JS
  =========================================
*/

document.addEventListener("DOMContentLoaded", function () {

  // 1. Accordion Toggle Logic
  const accordionHeaders = document.querySelectorAll(".hit-dpt-accordion-header");

  accordionHeaders.forEach(header => {
    header.addEventListener("click", function () {
      const item = this.parentElement;
      const isOpen = item.classList.contains("active");

      // Close all other items in the same accordion
      const accordion = item.closest(".hit-dpt-accordion");
      if (accordion) {
        accordion.querySelectorAll(".hit-dpt-accordion-item").forEach(i => {
          i.classList.remove("active");
        });
      }

      // Toggle current item
      if (!isOpen) {
        item.classList.add("active");
      }
    });
  });

  // 2. Gallery Slider Logic
  const galleryTrack = document.getElementById("dptGalleryTrack");
  const galleryPrev = document.getElementById("dptGalleryPrev");
  const galleryNext = document.getElementById("dptGalleryNext");
  let galleryIndex = 0;

  if (galleryTrack && galleryPrev && galleryNext) {
    function getItemsPerView() {
      if (window.innerWidth < 768) return 1;
      if (window.innerWidth < 992) return 3;
      return 5;
    }

    function updateGallery() {
      const itemsPerView = getItemsPerView();
      const items = document.querySelectorAll(".hit-dpt-gallery-item");
      const totalItems = items.length;
      const maxIndex = totalItems - itemsPerView;

      if (galleryIndex > maxIndex) galleryIndex = 0;
      if (galleryIndex < 0) galleryIndex = maxIndex;

      const offset = -(galleryIndex * (100 / itemsPerView));
      galleryTrack.style.transform = `translateX(${offset}%)`;
    }

    galleryNext.addEventListener("click", () => {
      galleryIndex++;
      updateGallery();
    });

    galleryPrev.addEventListener("click", () => {
      galleryIndex--;
      updateGallery();
    });

    // Auto-play gallery
    let galleryAutoPlay = setInterval(() => {
      galleryIndex++;
      updateGallery();
    }, 5000);

    // Pause on hover
    const gallerySlider = document.getElementById("dptGallerySlider");
    if (gallerySlider) {
      gallerySlider.addEventListener("mouseenter", () => {
        clearInterval(galleryAutoPlay);
      });
      gallerySlider.addEventListener("mouseleave", () => {
        galleryAutoPlay = setInterval(() => {
          galleryIndex++;
          updateGallery();
        }, 5000);
      });
    }

    window.addEventListener("resize", updateGallery);
  }
});





/*--------------------------------------------------
  Hit Hero Slider (Control speed here)
---------------------------------------------------*/
$(document).ready(function () {
  $(".hit-hero-slider").owlCarousel({
    nav: true,
    loop: true,
    dots: false,
    margin: 0,
    autoplay: true,
    autoplayHoverPause: true,
    autoplayTimeout: 3000, // <--- Control slider speed (duration of each slide in ms)
    smartSpeed: 1000,      // <--- Control transition speed (ms)
    navText: [
      "<i class='bx bx-left-arrow-alt'></i>",
      "<i class='bx bx-right-arrow-alt'></i>"
    ],
    responsive: {
      0: { items: 1 },
      576: { items: 1 },
      768: { items: 1 },
      992: { items: 1 },
      1200: { items: 1 }
    }
  });
});






