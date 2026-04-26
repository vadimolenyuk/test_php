function applyFilters(page) {
    console.log( 1231313)
    const url = new URL(window.location.href);
    url.searchParams.set('page', page);
    url.searchParams.set('sort', $('#sort').val());
    url.searchParams.set('date', $('#datepicker').val());
console.log( url.toString())
    window.location.href = url.toString();
}
$(function(){
      flatpickr("#datepicker", {
        dateFormat: "Y-m-d"
    });
});