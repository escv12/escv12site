<?php
require('./dbConnect.php');

function getCateIndex($categories, $cate_parent) {
    foreach ($categories as $index => $category) {
        if (isset($category['cate']) && $category['cate'] == $cate_parent) {
            return $index;
        }
    }
    return null; // 해당 요소를 찾지 못한 경우 null 반환
}

// SQL 쿼리 실행
$sql = "SELECT * FROM category";
$stmt = $pdo->prepare($sql);
$stmt->execute();

// 카테고리 배열 초기화
$categories = array();

// 카테고리 배열에 데이터 추가
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $num = $row['num'];
    $cate = $row['cate'];
    $cate_name = $row['cate_name'];
    $cate_class = $row['cate_class'];
    $cate_parent = $row['cate_parent'];

    // 1단계 카테고리일 경우
    if ($cate_class == 1) {
        $categories[] = [
            'name' => $cate_name,
            'subcategories' => [],
            'cate' => $cate
        ];
    }
    // 2단계 카테고리일 경우
    else if ($cate_class == 2) {
        $parent_index = getCateIndex($categories, $cate_parent);
        $categories[$parent_index]['subcategories'][] = [
            'name' => $cate_name,
            'subcategories' => [],
            'cate' => $cate
        ];
    }

    else if ($cate_class == 3) {
        $prefix = substr($cate_parent, 0, 2);
        $result = $prefix . str_repeat('0', 4);
        $parent = getCateIndex($categories, $result);
        $subCate = $categories[$parent]['subcategories'];
        $parent_index = getCateIndex($subCate, $cate_parent);
        $categories[$parent]['subcategories'][$parent_index]['subcategories'][] = [
            'name' => $cate_name,
            'subcategories' => [],
            'cate' => $cate
        ];
    }
}



// print_r($categories);



// HTML 코드 생성
function buildMenu($categories)
{
    $html = '<ul class="menu">';
    foreach ($categories as $category) {
        $html .= '<li><a href="#">' . $category['name'] . '</a>';
        if (!empty($category['subcategories'])) {
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
            $html .= '<li><a href="#">' . $subcategoryValue['name'] . '</a>';
            $html .= buildSubMenu($subcategoryValue['subcategories']);
            $html .= '</li>';
        } else {
            $html .= '<li><a href="#">' . $subcategoryValue['name'] . '</a></li>';
        }
    }
    $html .= '</ul>';
    return $html;
}

// 최상위 카테고리를 가져와서 메뉴 생성
$menuHtml = buildMenu($categories);

echo $menuHtml;
?>