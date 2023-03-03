window.onload = function () {


    /* 스크롤시 헤더 숨김 / 보임 처리 */
    const header = document.getElementById("header_wrap");
    let prevScrollpos = window.pageYOffset;

    window.addEventListener('wheel', function (event) {
        const currentScrollPos = window.pageYOffset;
        if (event.deltaY > 0) {
            // User scrolled down with the wheel
            header.classList.add('header--hidden');
        } else {
            // User scrolled up with the wheel
            header.classList.remove('header--hidden');
        }
        prevScrollpos = currentScrollPos;
    });



    /* 드롭 메뉴 몇번째 hover */
    const listItems = document.querySelectorAll('.header_nav .header_nav_item');

    listItems.forEach((li, index) => {
        li.addEventListener('mouseover', () => {
          const dropDownElement = li.querySelector('.drop_down');
          if (!dropDownElement) return;
          dropDownElement.classList.add('visible');
        });
      
        li.addEventListener('mouseout', () => {
          const dropDownElement = li.querySelector('.drop_down');
          if (!dropDownElement) return;
          dropDownElement.classList.remove('visible');
        });
      });
}