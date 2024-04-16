$(document).ready(function() {
    const dropdown = $('.menu');
    const dropdownContent = $('.dropdown-menu');

    dropdown.on('click', function(event) {
        dropdownContent.css('display', 'block');
        event.stopPropagation();
    });

    $(document).on('click', function() {
        dropdownContent.css('display', 'none');
    });
});

$(document).ready(function() {
    const btnDelete = $('#showBoxDelete');
    const closeFormIcon = $('#closeBox');
    const cancelDeleteButton = $('#cancelBox');
    const formDelete = $('#formBox');

    btnDelete.on('click', function() {
        formDelete.css('display', 'block');
    });

    closeFormIcon.on('click', function() {
        formDelete.css('display', 'none');
    });

    cancelDeleteButton.on('click', function() {
        formDelete.css('display', 'none');
    });
});
