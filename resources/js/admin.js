$('#status-filter').change(function () {
    $('#status-filter-form').submit();
});

const selectedStatus = localStorage.getItem('selectedStatus');
$('#status-filter').change(function () {
    const selectedValue = $(this).val();
    localStorage.setItem('selectedStatus', selectedValue);
});
