document.addEventListener("DOMContentLoaded", function () {
    const button = document.getElementById("back2top");

    button.addEventListener("click", function () {
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    });
});
