$(() => {
    $('.dropdown-expand-button').on('click', function() {
        $(this).parent().find('.dropdown-arrow').toggleClass('rotate-180')
        $(this).parent().toggleClass('dropdown-active')
    })
})