        // Mobile Navigation Toggle
        document.addEventListener("DOMContentLoaded", function () {
            const menuToggle = document.createElement("div");
            menuToggle.innerHTML = "☰";
            menuToggle.classList.add("menu-toggle");
            document.querySelector(".navbar").prepend(menuToggle);

            const navLinks = document.querySelector(".nav-links");

            menuToggle.addEventListener("click", function () {
                navLinks.classList.toggle("active");
            });
        });

        // Smooth Scrolling for links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener("click", function (e) {
                e.preventDefault();

                const target = document.querySelector(this.getAttribute("href"));
                if (target) {
                    target.scrollIntoView({
                        behavior: "smooth",
                        block: "start"
                    });
                }
            });
        });