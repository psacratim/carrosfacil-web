$(function() {
    // Relógio
    function updateCurrentDate() {
    const now = new Date();
    const formatter = new Intl.DateTimeFormat('pt-BR', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: 'numeric',
        minute: 'numeric',
        second: 'numeric',
        hour12: false
    });
    $("#current-time").text(formatter.format(now).replace(', ', ' - '));
    }
    updateCurrentDate();
    setInterval(updateCurrentDate, 1000);
});