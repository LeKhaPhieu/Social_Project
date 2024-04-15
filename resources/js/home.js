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

document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.category-box');
    const checkboxesMobile = document.querySelectorAll('.category-box-mobile');

    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            document.getElementById('categoryForm').submit();
        });
    });

    checkboxesMobile.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            document.getElementById('categoryFormMobile').submit();
        });
    });
});
