<?
class thumbnail {
	var $width;
	var $height;
	var $src;
	var $dst;
	var $mode; //pad | cut | (default)
	var $target_width;
	var $target_height;
	var $img;
	var $tp;
	var $r=255;
	var $g=255;
	var $b=255;

	function thumbnail($src,$dst,$w,$h){

		$this->src = $src;
		$this->dst = $dst;
		$this->target_width = $w;
		$this->target_height = $h;

		// 取得原圖寬、高、類型
		list($this->width,$this->height,$this->tp) = getimagesize($src);
		//type:  1 = GIF, 2 = JPG, 3 = PNG, 4 = SWF, 5 = PSD, 6 = BMP, 7 = TIFF(orden de bytes intel), 8 = TIFF(orden de bytes motorola), 9 = JPC, 10 = JP2, 11 = JPX, 12 = JB2, 13 = SWC, 14 = IFF, 15 = WBMP, 16 = XBM. 

		/*$width = imageSX($img);
		$height = imageSY($img);*/

		if (!$this->width || !$this->height) {
			return "ERROR:Invalid width or height";
		}

		// 載入原圖
		switch($this->tp){
			case '1':
				$this->img = imagecreatefromgif($src);
			break;
			case '2':
				$this->img = imagecreatefromjpeg($src);
			break;
			case '3':
				$this->img = imagecreatefrompng($src);
			break;
		}

		if (!$this->img) {
			return "ERROR:could not create image handle ".$src;
		}

		return true;

	}

	function create(){

		$target_ratio = ($this->target_height<>0) ? $this->target_width / $this->target_height : 0;
		$img_ratio = $this->width / $this->height;

		//設定縮圖比例及起始位置(pad)
		switch ($this->mode){
			case 'pad':
				if ($target_ratio > $img_ratio) {
					$new_height = $this->target_height;
					$new_width = $img_ratio * $this->target_height;
				} else {
					$new_height = $this->target_width / $img_ratio;
					$new_width = $this->target_width;
				}
				$w1 = ($this->target_width-$new_width)/2;
				$h1 = ($this->target_height-$new_height)/2;
		if ($new_height > $this->target_height) {
			$new_height = $this->target_height;
		}
		if ($new_width > $this->target_width) {
			$new_height = $this->target_width;
		}
			break;
			case 'cut':
				if ($target_ratio > $img_ratio) {
					$new_height = $this->target_width / $img_ratio;
					$new_width = $target_width;
				} else {
					$new_height = $this->target_height;
					$new_width = $img_ratio * $this->target_height;
				}
				$w1 = 0;
				$h1 = 0;
		if ($new_height > $this->target_height) {
			$new_height = $this->target_height;
		}
		if ($new_width > $this->target_width) {
			$new_height = $this->target_width;
		}
			break;
			default:
				$new_width = $this->target_width;
				$new_height = $this->target_width / $img_ratio;
				$this->target_height = $new_height;
				$w1 = 0;
				$h1 = 0;
		}

		$new_img = ImageCreateTrueColor($this->target_width, $this->target_height);
		$bg_color = imagecolorallocate($new_img, $this->r, $this->g, $this->b);
		imagefilledrectangle($new_img, 0, 0, $this->target_width-1, $this->target_height-1, $bg_color);

		if (!imagecopyresampled($new_img, $this->img, $w1, $h1, 0, 0, $new_width, $new_height, $this->width, $this->height)) {
			return "ERROR:Could not resize image";
		}else{
			//output image to file
			switch($this->tp){
				case '1':
				$ot = imagegif($new_img,$this->dst);
				break;
				case '2':
				$ot = imagejpeg($new_img,$this->dst);
				break;
				case '3':
				$ot = imagepng($new_img,$this->dst);
				break;
			}
			imagedestroy($this->img);
			return $ot;
		}

	} // end create

} // end class
?>