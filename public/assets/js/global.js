$("#btn-logout").on("click", function () {
    $("#form-logout").submit();
});

$(window).on("load", function () {
    $(".preloader").fadeOut("slow");
});
