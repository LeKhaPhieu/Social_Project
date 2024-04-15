const dropdown = document.querySelector('.header-user-avatar');
const dropdownContent = document.querySelector('.dropdown-content');

dropdown.addEventListener('click', function (event) {
    dropdownContent.style.display = 'block';
    event.stopPropagation(); 
})

document.addEventListener('click', function () {
    dropdownContent.style.display = 'none';
})
