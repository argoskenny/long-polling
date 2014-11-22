<?php
/**
*   圖片 處理
*   @author Kenny 
*   @package tool    
*   Last update: 2014/11/12
**/

/**
* 撈取圖片位置
*
* @param array $article_no 文章編號陣列
* @param array $article_arr 文章內容陣列
* @param int $w 圖片寬度
* @param int $h 圖片高度 要轉換的目標語言編碼，默認為網站語言常量
* @param string $size 圖片大小標記 'l' 'm' 's'
* 
* @return array $img 索引為文章編號的圖片陣列
*/
function makeimg($no_arr,$article_arr,$w,$h,$size){
    $link = new JbLink(_HOST, _USER, _PASSWD, 'LTNewsWeb');
    $frontP = array();
    $img = array();

    if ($no_arr) {
        $sql = "SELECT min(LT3P_Name) LT3P_Name, LT3A_No FROM LT3cPhoto 
                WHERE LT3A_No IN (".implode(",", $no_arr).") 
                GROUP BY LT3A_No";
        $link->query($sql);
        while( $row = $link->fetch() ) {
            $frontP[$row['LT3A_No']] = $row['LT3P_Name'];
        }
    }
    foreach ($article_arr as $key => $value) {
        $src = _ROOT._UPLOAD.'/3c'.$value['LT3A_PhotoPath'].'/'.@$frontP[$value['LT3A_No']];
        $dst = _UPLOAD.'/3c/pic_thumb/'.$size.'-'.@$frontP[$value['LT3A_No']];
        $img[$value['LT3A_No']] = editimg($src,$dst,$w,$h,$size);
    }

    return $img;
}

function editimg($src,$dst,$w,$h,$size) {    
    if ( is_file($src) ) {
        $im = new thumbnail($src,_ROOT.$dst,$w,$h);
        $im->mode = 'pad';
        $r = $im->create();
    } else {
        if ( is_file($dst) == false) {
            $dst = _UPLOAD.'/3c/pic_thumb/'.$size.'-default.jpg'; 
            $im = new thumbnail(_HTMLPATH.'assets/images/default.jpg',_ROOT.$dst,$w,$h);
            $im->mode = 'pad';
            $r = $im->create();
        }
    }
    return $dst;
}

?>