document.addEventListener("DOMContentLoaded", function () {
    const button = document.getElementById("back2top");

    // Add the click event listener for the button
    button.addEventListener("click", function () {
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    });
});
