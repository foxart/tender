<?php

namespace fa\core\services;

use fa\core\classes\Singleton;

class Image extends Singleton {

	public static $instance;
	private $image;

	public function create($width, $height) {
		if (function_exists('imagecreatetruecolor')) {
			$this->image = imagecreatetruecolor($width, $height);
		} elseif (function_exists('imagecreate')) {
			$this->image = imagecreate($width, $height);
		} else {
			throw new \Exception('unable to create an image');
		}
		// $this->image = imagecreatetruecolor( $width, $height );
		imagealphablending($this->image, TRUE);
		imagesavealpha($this->image, TRUE);
		imagefill($this->image, 0, 0, imagecolorallocatealpha($this->image, 0, 0, 0, 127));
	}

	public function load($filename) {
		$image_info = getimagesize($filename);
		$image_type = $image_info[2];
		if ($image_type == IMAGETYPE_JPEG) {
			$this->image = imagecreatefromjpeg($filename);
		} elseif ($image_type == IMAGETYPE_GIF) {
			$this->image = imagecreatefromgif($filename);
		} elseif ($image_type == IMAGETYPE_PNG) {
			$this->image = imagecreatefrompng($filename);
		} else {
			throw new \Exception('undefined image type: ' . $image_type);
		}
	}

	public function save($filename, $image_type = 'jpg', $image_quality = 75, $permissions = NULL) {
		if ($image_type == 'jpg') {
			imagejpeg($this->image, $filename, $image_quality);
		} elseif ($image_type == 'gif') {
			imagegif($this->image, $filename);
		} elseif ($image_type == 'png') {
			$compression = 9 - round(($image_quality / 100) * 9); // Scale quality from 0-100 to 9-0, 0 is best, 9 is poorest
			imagepng($this->image, $filename, $compression);
		}
		if ($permissions != NULL) {
			chmod($filename, $permissions);
		}
	}

	public function output($image_type = 'jpg', $image_quality = 75) {
		if ($image_type == 'jpg') {
			header('Content-Type: image/jpeg');
			imagejpeg($this->image, NULL, $image_quality);
		} elseif ($image_type == 'gif') {
			header('Content-Type: image/gif');
			imagegif($this->image, NULL);
		} elseif ($image_type == 'png') {
			$compression = 9 - round(($image_quality / 100) * 9); // Scale quality from 0-100 to 9-0, 0 is best, 9 is poorest
			header('Content-Type: image/png');
			imagepng($this->image, NULL, $compression);
		}
		imagedestroy($this->image);
	}

	public function resizeToFit($width, $height) {
		$ratioX = $this->getWidth() / $width;
		$ratioY = $this->getHeight() / $height;
		if ($ratioX > $ratioY) {
			$this->resizeToWidth($width);
		} else {
			$this->resizeToHeight($height);
		}
	}

	public function getWidth() {
		return imagesx($this->image);
	}

	public function getHeight() {
		return imagesy($this->image);
	}

	public function resizeToWidth($width) {
		$ratio = $width / $this->getWidth();
		$height = $this->getHeight() * $ratio;
		$this->resize($width, $height);
	}

	public function resize($width, $height) {
		$new_image = imagecreatetruecolor($width, $height);
		imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
		$this->image = $new_image;
	}

	public function resizeToHeight($height) {
		$ratio = $height / $this->getHeight();
		$width = $this->getWidth() * $ratio;
		$this->resize($width, $height);
	}

	public function scale($scale) {
		$width = $this->getWidth() * $scale / 100;
		$height = $this->getHeight() * $scale / 100;
		$this->resize($width, $height);
	}

	public function drawLine($positionX1, $positionY1, $positionX2, $positionY2, $color, $boldness = 2) {
		$center = round($boldness / 2);
		for ($i = 0; $i < $boldness; $i++) {
			$a = $center - $i;
			if ($a < 0) {
				$a -= $a;
			};
			for ($j = 0; $j < $boldness; $j++) {
				$b = $center - $j;
				if ($b < 0) {
					$b -= $b;
				};
				$c = sqrt($a * $a + $b * $b);
				if ($c <= $boldness) {
					imageline($this->image, $positionX1 + $i, $positionY1 + $j, $positionX2 + $i, $positionY2 + $j, $color);
				};
			};
		};
	}

	/* graphics */
	public function drawPoint($positionX, $positionY, $radius, $color) {
		imagefilledellipse($this->image, $positionX, $positionY, $radius, $radius, $color);
	}

	/*
		alpha 0-127
		0-100%
		127-0%
	*/
	public function drawPointNew($positionX, $positionY, $radius, $color, $alpha = 0) {
		$pointColor = $this->allocateColor($this->hexToRgb($color), $alpha);
		imagefilledellipse($this->image, $positionX, $positionY, $radius, $radius, $pointColor);
	}

	public function allocateColor($color, $alpha = 0) {
		$color = imagecolorallocatealpha($this->image, $color[0], $color[1], $color[2], $alpha);

		return $color;
	}

	public function hexToRgb($color) {
		$color = str_replace('#', '', $color);
		$s = strlen($color) / 3;
		$rgb[] = hexdec(str_repeat(substr($color, 0, $s), 2 / $s));
		$rgb[] = hexdec(str_repeat(substr($color, $s, $s), 2 / $s));
		$rgb[] = hexdec(str_repeat(substr($color, 2 * $s, $s), 2 / $s));

		return $rgb;
	}

	public function drawPointGradient($positionX, $positionY, $radius, $rgb, $alpha_start, $alpha_end, $step = 0) {
		list($r, $g, $b) = $this->hexToRgb($rgb);
		$a1 = $this->alphaToSevenbit($alpha_start);
		$a2 = $this->alphaToSevenbit($alpha_end);
		$line_numbers = $radius;
		imagefill($this->image, 0, 0, imagecolorallocatealpha($this->image, $r, $g, $b, $a1));
		for ($i = 0; $i < $line_numbers; $i = $i + 1 + $step) {
//			$old_a = (empty($a)) ? $a2 : $a;
			if ($a2 - $a1 != 0) {
				$a = intval($a1 + ($a2 - $a1) * ($i / $line_numbers));
			} else {
				$a = $a1;
			}
//			if ($old_a != $a) {
			$fill = imagecolorallocatealpha($this->image, $r, $g, $b, $a);
//			}
			imagefilledellipse($this->image, $positionX, $positionY, $line_numbers - $i, $line_numbers - $i, $fill);
		}
		// exit;
	}

	public function alphaToSevenbit($alpha) {
		return (abs($alpha - 255) >> 1);
	}

	public function drawText($positionX, $positionY, $text, $font, $color) {
		$fontHeight = imagefontheight($font);
		$fontWidth = imagefontwidth($font);
		if ($positionX == 'center' and $positionY == 'center') {
			$positionX = $this->getWidth() / 2 - strlen($text) / 2 * $fontWidth;
			$positionY = $this->getHeight() / 2 - 1 / 2 * $fontHeight;
		} else {
		}
		imagestring($this->image, $font, $positionX, $positionY, $text, $color);
	}
}
