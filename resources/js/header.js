$(document).ready(function () {
    $('.header-navbar-mobile').click(function () {
        $('.dropdown-menu-user').toggleClass('active');
    });
});

window.addEventListener("scroll", function () {
    let lastScrollTop = 0
    const headerNavbar = document.querySelector(".header-form")
    const currentScrollTop = window.scrollY

    if (currentScrollTop === 0) {
        headerNavbar.classList.remove("header-scrolled")
    } else {
        headerNavbar.classList.add("header-scrolled")
    }

    lastScrollTop = currentScrollTop
})

const dropdown = document.querySelector('.header-user-avatar');
const dropdownContent = document.querySelector('.dropdown-content');

dropdown.addEventListener('click', function (event) {
    dropdownContent.style.display = 'block';
    event.stopPropagation();
})

document.addEventListener('click', function () {
    dropdownContent.style.display = 'none';
})
