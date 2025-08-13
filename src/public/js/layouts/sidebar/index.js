$(document).ready(function () {
    $('.selectpicker').select2({
        theme: 'bootstrap4'
    });
});

const search_menu = (element) => {
    let _id = $(element).val();

    if (_id != "") {
        window.location.href = _id;
    }
}