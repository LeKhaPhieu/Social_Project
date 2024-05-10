$('#status-filter').change(function () {
    $('#status-filter-form').submit();
});

const selectedStatus = localStorage.getItem('selectedStatus');
$('#status-filter').change(function () {
    const selectedValue = $(this).val();
    localStorage.setItem('selectedStatus', selectedValue);
});

$(document).ready(function () {
    $('.small-graph-box').hover(function () {
        $(this).find('.box-button').fadeIn('fast');
    }, function () {
        $(this).find('.box-button').fadeOut('fast');
    });

    $('.small-graph-box .box-close').click(function () {
        $(this).closest('.small-graph-box').fadeOut(200);
        return false;
    });
});

function gd(year, day, month) {
    return new Date(year, month - 1, day).getTime();
}

let graphAreaPost;
let graphAreaUser;

$.ajax({
    url: '/admin/posts',
    type: 'GET',
    dataType: 'json',
    success: function (data) {
        graphAreaPost = Morris.Area({
            element: 'posts',
            padding: 10,
            behaveLikeLine: true,
            gridEnabled: false,
            gridLineColor: '#dddddd',
            axes: true,
            resize: true,
            smooth: true,
            pointSize: 0,
            lineWidth: 0,
            fillOpacity: 0.85,
            data,
            lineColors: ['#eb6f6f'],
            xkey: 'day',
            ykeys: ['posts'],
            labels: ['Posts'],
            pointSize: 4,
            hideHover: 'auto',
            resize: true,
        });
    },
    error: function (xhr, status, error) {
        console.error(error);
    }
});

$('#btnApplyChartPost').click(function () {
    const startDate = $('#startDatePost').val();
    const endDate = $('#endDatePost').val();
    if (new Date(startDate) >= new Date(endDate) || 
        new Date(endDate) > new Date()) {
        alert('Invalid date range please check again');
        return;
    }
    $.ajax({
        url: '/admin/filter/posts',
        type: 'POST',
        data: {
            start_date: startDate,
            end_date: endDate,
        },
        dataType: 'json',
        success: function (data) {
            graphAreaPost.setData(data);
        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    });
})

$.ajax({
    url: '/admin/users',
    type: 'GET',
    dataType: 'json',
    success: function (data) {
        graphAreaUser = Morris.Area({
            element: 'users',
            padding: 10,
            behaveLikeLine: true,
            gridEnabled: false,
            gridLineColor: '#dddddd',
            axes: true,
            resize: true,
            smooth: true,
            pointSize: 0,
            lineWidth: 0,
            fillOpacity: 0.85,
            data,
            lineColors: ['#eb6f6f'],
            xkey: 'day',
            ykeys: ['users'],
            labels: ['users'],
            pointSize: 4,
            hideHover: 'auto',
            resize: true,
        });
    },
    error: function (xhr, status, error) {
        console.error(error);
    }
});

$('#btnApplyChartUser').click(function () {
    const startDate = $('#startDateUser').val();
    const endDate = $('#endDateUser').val();
    if (new Date(startDate) >= new Date(endDate) || 
        new Date(endDate) > new Date()) {
        alert('Invalid date range please check again');
        return;
    }
    $.ajax({
        url: '/admin/filter/users',
        type: 'POST',
        data: {
            start_date: startDate,
            end_date: endDate,
        },
        dataType: 'json',
        success: function (data) {
            graphAreaUser.setData(data);
        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    });
})
