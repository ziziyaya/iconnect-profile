document.addEventListener("DOMContentLoaded", function () {
  setupNav();
  setupBannerSlider();
  setupContactModal();
});

// ---------- Menu mobile ----------
function setupNav() {
  var toggle = document.querySelector(".nav-toggle");
  var links = document.querySelector(".nav-links");
  if (!toggle || !links) {
    return;
  }
  toggle.addEventListener("click", function () {
    links.classList.toggle("open");
  });
}

// ---------- Carousel banner di beranda ----------
function setupBannerSlider() {
  var track = document.querySelector(".banner-track");
  if (!track) {
    return;
  }

  var slides = track.querySelectorAll(".banner-slide");
  var dotsWrap = document.querySelector(".banner-dots");
  var indexSekarang = 0;
  var jumlahSlide = slides.length;

  if (jumlahSlide <= 1) {
    return;
  }

  function tampilkanSlide(index) {
    track.style.transform = "translateX(-" + (index * 100) + "%)";

    var semuaDot = dotsWrap.querySelectorAll(".banner-dot");
    for (var i = 0; i < semuaDot.length; i++) {
      if (i == index) {
        semuaDot[i].classList.add("active");
      } else {
        semuaDot[i].classList.remove("active");
      }
    }
  }

  // Bikin tombol titik di bawah slider
  for (var i = 0; i < jumlahSlide; i++) {
    var dot = document.createElement("button");
    dot.className = "banner-dot";
    if (i == 0) {
      dot.className = "banner-dot active";
    }
    dot.setAttribute("data-index", i);
    dot.addEventListener("click", function (e) {
      indexSekarang = parseInt(e.target.getAttribute("data-index"));
      tampilkanSlide(indexSekarang);
    });
    dotsWrap.appendChild(dot);
  }

  // Auto geser tiap 5 detik
  setInterval(function () {
    indexSekarang = indexSekarang + 1;
    if (indexSekarang >= jumlahSlide) {
      indexSekarang = 0;
    }
    tampilkanSlide(indexSekarang);
  }, 5000);
}

// ---------- Modal WhatsApp + Peta ----------
function setupContactModal() {
  var tombolBuka = document.querySelectorAll("[data-open-contact-modal]");
  var overlay = document.querySelector("#contact-modal");
  if (!overlay) {
    return;
  }
  var tombolTutup = overlay.querySelector(".modal-close");

  for (var i = 0; i < tombolBuka.length; i++) {
    tombolBuka[i].addEventListener("click", function () {
      overlay.classList.add("open");
    });
  }

  tombolTutup.addEventListener("click", function () {
    overlay.classList.remove("open");
  });

  overlay.addEventListener("click", function (e) {
    if (e.target == overlay) {
      overlay.classList.remove("open");
    }
  });
}
