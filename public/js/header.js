const header = $("header")[0];
const progress_bar = $("#scroll_process_bar span")[0];
document.addEventListener("scroll", () => {
    if (window.scrollY > 100) {
        header.addClass("scrolled");
    } else if (window.scrollY < 10) {
        header.removeClass("scrolled");
    }
    if (progress_bar) {
        progress_bar.addCSS("width", scrollPercentage + "%");
    }
});
const go_to_top_controller = new go_to_top({
    button: $(".go_to_top")[0],
    onScroll: function () {
        $(".go_to_top .second")[0].addCSS(
            "height",
            window.scrollPercentage + "%"
        );
    },
});