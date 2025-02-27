$(document).ready(function () {
    $('.filter-btn').on('click', function () {
        $('.filter-btn').removeClass("active");
        $(this).toggleClass("active")
        var filter = $(this).data('filter').toLowerCase();
        if (filter === 'all') {
            $('.filter-card').show();
        } else {
            $('.filter-card').hide();
            $('.filter-card').filter(function () {
                var courses = $(this).data('courses').toLowerCase().split(',');
                return courses.includes(filter);
            }).show();
        }
    });
});