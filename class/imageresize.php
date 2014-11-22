<?php
public function resizeImg($img, $width = 300, $height = 300, $newFilename = '', $maxImgWidth = 800, $maxImgHeight=800, $bgColor=null) {
        
$bgColor = $bgColor === null || !is_array($bgColor) ? array('r'=>255, 'g'=>255, 'b'=>255) : $bgColor;

switch (strtolower($img['type'])) {
    case 'image/jpg':
    case 'image/jpeg':
    case 'image/pjpeg':
        $image = imagecreatefromjpeg($img['tmp_name']);
        break;
    case 'image/png':
        $image = imagecreatefrompng($img['tmp_name']);
        break;
    case 'image/gif':
        $image = imagecreatefromgif($img['tmp_name']);
        break;
    default:
        throw new Exception('Unsupported type: ' . $img['type']);
}

// Target dimensions
$max_width = $width;
$max_height = $height;

// Get current dimensions
$old_width = imagesx($image);
$old_height = imagesy($image);

// Calculate the scaling we need to do to fit the image inside our frame
$scale = min($max_width / $old_width, $max_height / $old_height);

$new_width = ceil($scale * $old_width);
$new_height = ceil($scale * $old_height);
    
// Create new empty image
$new = imagecreatetruecolor($new_width, $new_height);

// Get the new dimensions
if($old_width >= $maxImgWidth){
    imagecopyresampled($new, $image, 0, 0, 0, 0, $new_width, $new_height, $old_width, $old_height);
}else{
    $new_width = $maxImgWidth;
    $new_height = ($maxImgHeight >= $old_height ? $maxImgHeight : $old_height);
    $new = imagecreatetruecolor($new_width, $new_height);
    $backgroundColor = imagecolorallocate($new, $bgColor['r'], $bgColor['g'], $bgColor['b']);
    imagefill($new, 0, 0, $backgroundColor);
    $centerX = (($new_width - $old_width)   / 2);
    $centerY = (($new_height - $old_height) / 2);
    $centerY = $centerY + $old_height >= $new_height ? 0 : $centerY;
    imagecopy($new, $image, $centerX, $centerY, 0, 0, $old_width, $old_height);
}


switch (strtolower($img['type'])) {
    case 'image/jpg':
    case 'image/jpeg':
    case 'image/pjpeg':
        $optImg = imagejpeg($new, $newFilename, 100);
        break;
    case 'image/png':
        $optImg = imagepng($new, $newFilename, 0, PNG_ALL_FILTERS);
        break;
    case 'image/gif':
        $optImg = imagegif($new, $newFilename);
        break;
}

imagedestroy($image);
imagedestroy($new);
}
?>