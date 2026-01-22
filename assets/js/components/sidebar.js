$(() => {
    $('.dropdown-expand-button').on('click', function () {
        $(this).parent().find('.dropdown-arrow').toggleClass('rotate-180')
        $(this).parent().toggleClass('dropdown-active')
    })

    $('#logout-button').on('click', function () {
        $.ajax({
            url: '/admin/logout.php',
            type: 'POST',
            success: function (response) {
                console.log(response);
                window.location.href = '/admin/index.php';
            },
            // error: function () {
            //     window.location.href = 'index.php';
            // }
        });
    });
})