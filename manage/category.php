<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="../favicon/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="../css/category.css">
  <title>은성 관리자</title>
</head>

<body>
  <div class="wrapper">
    <?php require("./left_menus.php") ?>

    <div class="right_wrap">
      <div class="title">메뉴 관리</div>
      <form class="contents">
        <div class="contents_top">
          <div class="content_tl">
            <div class="category_container_head">전시 카테고리</div>
            <div class="category_container">
              <div class="wrppper_cont">
              <?php
              // require('./getCategory.php')
              $categories = [
                [
                  'name' => '메인 카테고리 1',
                  'subcategories' => [
                    [
                      'name' => '서브 카테고리 1 - 1',
                      'subcategories' => []
                    ],
                    [
                      'name' => '서브 카테고리 1 - 2',
                      'subcategories' => [
                        [
                          'name' => '서브 서브 카테고리 1 - 2 - 1',
                          'subcategories' => []
                        ],
                        [
                          'name' => '서브 서브 카테고리 1 - 2 - 2',
                          'subcategories' => []
                        ],
                      ]
                    ],
                    [
                      'name' => '서브 카테고리 1 - 3',
                      'subcategories' => [
                        [
                          'name' => '서브 서브 카테고리 1 - 3 - 1',
                          'subcategories' => []
                        ],
                        [
                          'name' => '서브 서브 카테고리 1 - 3 - 2',
                          'subcategories' => []
                        ],
                      ]
                    ],
                  ]

                ],
                [
                  'name' => '메인 카테고리 1',
                  'subcategories' => [
                    [
                      'name' => '서브 카테고리 1 - 1',
                      'subcategories' => []
                    ],
                    [
                      'name' => '서브 카테고리 1 - 2',
                      'subcategories' => [
                        [
                          'name' => '서브 서브 카테고리 1 - 2 - 1',
                          'subcategories' => []
                        ],
                        [
                          'name' => '서브 서브 카테고리 1 - 2 - 2',
                          'subcategories' => []
                        ],
                      ]
                    ],
                    [
                      'name' => '서브 카테고리 1 - 3',
                      'subcategories' => [
                        [
                          'name' => '서브 서브 카테고리 1 - 3 - 1',
                          'subcategories' => []
                        ],
                        [
                          'name' => '서브 서브 카테고리 1 - 3 - 2',
                          'subcategories' => []
                        ],
                      ]
                    ],
                  ]

                ],
                [
                  'name' => '메인 카테고리 1',
                  'subcategories' => [
                    [
                      'name' => '서브 카테고리 1 - 1',
                      'subcategories' => []
                    ],
                    [
                      'name' => '서브 카테고리 1 - 2',
                      'subcategories' => [
                        [
                          'name' => '서브 서브 카테고리 1 - 2 - 1',
                          'subcategories' => []
                        ],
                        [
                          'name' => '서브 서브 카테고리 1 - 2 - 2',
                          'subcategories' => []
                        ],
                      ]
                    ],
                    [
                      'name' => '서브 카테고리 1 - 3',
                      'subcategories' => [
                        [
                          'name' => '서브 서브 카테고리 1 - 3 - 1',
                          'subcategories' => []
                        ],
                        [
                          'name' => '서브 서브 카테고리 1 - 3 - 2',
                          'subcategories' => []
                        ],
                      ]
                    ],
                  ]

                ],
                [
                  'name' => '메인 카테고리 2',
                  'subcategories' => [
                    [
                      'name' => '서브 카테고리 2 - 1',
                      'subcategories' => []
                    ],
                    [
                      'name' => '서브 카테고리 2 - 2',
                      'subcategories' => []
                    ],
                    [
                      'name' => '서브 카테고리 2 - 3',
                      'subcategories' => [
                        [
                          'name' => '서브 서브 카테고리 2 - 3 - 1',
                          'subcategories' => []
                        ],
                        [
                          'name' => '서브 서브 카테고리 2 - 3 - 2',
                          'subcategories' => []
                        ],
                      ]
                    ],
                  ]

                ]
              ];
              function buildMenu($categories)
              {
                $html = '<ul class="menu">';
                foreach ($categories as $category) {
                  $html .= '<li class="menu_li"><a class="menu_a" href="#">' . $category['name'] . '</a>';
                  if (!empty($category['subcategories'])) {
                    $html .= '<div class="category_down"><div class="arrow"></div></div>';
                    $html .= buildSubMenu($category['subcategories']);
                  }
                  $html .= '</li>';
                }
                $html .= '</ul>';
                return $html;
              }
              function buildSubMenu($subcategories)
              {
                $html = '<ul class="submenu">';
                foreach ($subcategories as $subcategoryKey => $subcategoryValue) {
                  if (is_array($subcategoryValue)) {
                    $html .= '<li class="submenu_li"><a class="submenu_a" href="#">└ ' . $subcategoryValue['name'] . '</a>';
                    if (!empty($subcategoryValue['subcategories'])) {
                      $html .= '<div class="category_down"><div class="arrow"></div></div>';
                      $html .= buildSubMenu($subcategoryValue['subcategories']);
                    }
                    $html .= '</li>';
                  }
                }
                $html .= '</ul>';
                return $html;
              }
              $menuHtml = buildMenu($categories);
              echo $menuHtml;
              ?>
              </div>
            </div>



            <div class=" category_container_bottom">
                <button class="footer">추가</button>
                <button class="footer">삭제</button>
              </div>
            </div>
            <div class="content_tr">
            </div>
          </div>
          <div class="contents_bottom">
            <div class="save_button">저장하기</div>
          </div>

      </form>


    </div>

  </div>
  <script>
    window.onload = function () {
      // 메뉴의 하위 메뉴 숨기기/보이기
      const categoryDowns = document.querySelectorAll('.category_down');

      categoryDowns.forEach(categoryDown => {
        categoryDown.addEventListener('click', () => {
          categoryDown.classList.toggle('rotate');
        });
      });


      const submenus = document.querySelectorAll('.submenu');
      submenus.forEach(submenu => {
        const parentMenu = submenu.previousElementSibling;
        parentMenu.addEventListener('click', () => {
          submenu.classList.toggle('show');
        });
      });
    }
  </script>
</body>

</html>