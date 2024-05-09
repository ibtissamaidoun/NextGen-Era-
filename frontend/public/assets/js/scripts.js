document.addEventListener("DOMContentLoaded", function() {
    // This function will run once the DOM is fully loaded

    // Function to handle scroll behavior
    function scrollFunction() {
        var navbar = document.getElementById("navbarExample");
        if (navbar) {
            if (document.documentElement.scrollTop > 30) {
                navbar.classList.add("top-nav-collapse");
            } else {
                navbar.classList.remove("top-nav-collapse");
            }
        }
    }

    // Function to handle scroll behavior for Back To Top Button
    function scrollFunctionBTT() {
        var myButton = document.getElementById("myBtn");
        if (myButton) {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                myButton.style.display = "block";
            } else {
                myButton.style.display = "none";
            }
        }
    }

    // Adding scroll event listener
    window.onscroll = function() {
        scrollFunction();
        scrollFunctionBTT(); // Now scrollFunctionBTT can be accessed here
    };

    // Function to handle scroll behavior on window load
    window.onload = function() {
        scrollFunction();
    };

    // Navbar on mobile
    let elements = document.querySelectorAll(".nav-link:not(.dropdown-toggle)");

    for (let i = 0; i < elements.length; i++) {
        elements[i].addEventListener("click", () => {
            let offcanvasCollapse = document.querySelector(".offcanvas-collapse");
            if (offcanvasCollapse) {
                offcanvasCollapse.classList.toggle("open");
            }
        });
    }

    let navbarToggler = document.querySelector(".navbar-toggler");
    if (navbarToggler) {
        navbarToggler.addEventListener("click", () => {
            let offcanvasCollapse = document.querySelector(".offcanvas-collapse");
            if (offcanvasCollapse) {
                offcanvasCollapse.classList.toggle("open");
            }
        });
    }

    // Hover on desktop
    function toggleDropdown(e) {
        const _d = e.target.closest(".dropdown");
        if (_d) {
            let _m = document.querySelector(".dropdown-menu", _d);

            setTimeout(
                function () {
                    const shouldOpen = _d.matches(":hover");
                    if (_m) {
                        _m.classList.toggle("show", shouldOpen);
                    }
                    _d.classList.toggle("show", shouldOpen);

                    _d.setAttribute("aria-expanded", shouldOpen);
                },
                e.type === "mouseleave" ? 300 : 0
            );
        }
    }

    // On hover
    const dropdownCheck = document.querySelector('.dropdown');

    if (dropdownCheck !== null) { 
        let dropdown = document.querySelector(".dropdown");
        if (dropdown) {
            dropdown.addEventListener("mouseleave", toggleDropdown);
            dropdown.addEventListener("mouseover", toggleDropdown);

            // On click
            dropdown.addEventListener("click", (e) => {
                const _d = e.target.closest(".dropdown");
                let _m = document.querySelector(".dropdown-menu", _d);
                if (_d.classList.contains("show")) {
                    if (_m) {
                        _m.classList.remove("show");
                    }
                    _d.classList.remove("show");
                } else {
                    if (_m) {
                        _m.classList.add("show");
                    }
                    _d.classList.add("show");
                }
            });
        }
    }

    // Card Slider - Swiper
    if (typeof Swiper !== 'undefined') {
        var cardSlider = new Swiper('.card-slider', {
            autoplay: {
                delay: 4000,
                disableOnInteraction: false
            },
            loop: true,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev'
            }
        });

        // Image Slider - Swiper
        var imageSlider = new Swiper('.image-slider', {
            autoplay: {
                delay: 3000,
                disableOnInteraction: false
            },
            loop: true,
            spaceBetween: 50,
            slidesPerView: 5,
            breakpoints: {
                // when window is <= 575px
                575: {
                    slidesPerView: 1,
                    spaceBetween: 10
                },
                // when window is <= 767px
                767: {
                    slidesPerView: 2,
                    spaceBetween: 20
                },
                // when window is <= 991px
                991: {
                    slidesPerView: 3,
                    spaceBetween: 20
                },
                // when window is <= 1199px
                1199: {
                    slidesPerView: 4,
                    spaceBetween: 20
                }
            }
        });

        // Back To Top Button
        // Get the button
        var myButton = document.getElementById("myBtn");

        // When the user clicks on the button, scroll to the top of the document
        if (myButton) {
            myButton.onclick = function() {
                document.body.scrollTop = 0; // for Safari
                document.documentElement.scrollTop = 0; // for Chrome, Firefox, IE and Opera
            };
        }
    }
});
