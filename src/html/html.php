<?php 
namespace Src\html;
use Form;
/**
 * html Form genarator
 */
class Html extends Form
{
	
	function __construct(){
		parent::__construct();
	}

	static function img($src, $attr = []){
		$attr = self::attr($attr);
		echo '<img src="'.$src.'" '.$attr.' >';
	}

	static function a($href, $text, $attr = []){
		$attr = self::attr($attr);?>
		<a href="<?php echo $href; ?>" <?php echo $attr; ?>><?php echo $text; ?></a>
		<?php
	}

	static function cssLink($href){
		?>
		<link rel="stylesheet" href="<?php echo $href; ?>" type="text/css">
		<?php
	}
	static function script($src){
		echo '<script src="'.$src.'" type="text/javascript"></script>';
	}
}
?>
