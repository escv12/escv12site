window.onload = function () {
    const header = document.getElementById("header_wrap");
    let prevScrollpos = window.pageYOffset;

    window.addEventListener('scroll', function () {
        const currentScrollPos = window.pageYOffset;
        if (prevScrollpos > currentScrollPos) {
            header.classList.remove('header--hidden');
        } else {
            header.classList.add('header--hidden');
        }
        prevScrollpos = currentScrollPos;
    });
}