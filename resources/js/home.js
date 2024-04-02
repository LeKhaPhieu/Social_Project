const modal = document.getElementById('overlayMobile');
const btnShowSidebar = document.getElementById('btnShowSidebar');
const boxSidebar = document.getElementById('sidebarMobile');
const closeBoxSidebar = document.getElementsByClassName('close')[0];

btnShowSidebar.onclick = function () {
    modal.style.display = "block";
    boxSidebar.style.display = "block";
}

closeBoxSidebar.onclick = function () {
    modal.style.display = "none";
}

window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

const dropdown = document.querySelector('.dropdown');
const dropdownContent = document.querySelector('.dropdown-content');

dropdown.addEventListener('click', function () {
    dropdownContent.style.display = 'block';
})

