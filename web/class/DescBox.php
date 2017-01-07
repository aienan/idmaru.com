<?php
	class DescBox {
		public $element;
		public $comment;
		public $width;
		public $direction;
		function __construct($element="", $comment="", $width=0, $direction='left') {
			$this->element = (string)$element;
			$this->comment = (string)$comment;
			$this->width = $width;
			$this->direction = $direction;
			if($element!="" && $comment!=""){$this->append();}
		}
		public function append() {
			if($this->element=="" || $this->comment==""){exit();}
			if($this->width != 0){
				$commbox = '<div class=\"descbox\" style=\"position:absolute; line-height:1.4; text-align:right; width:'.$this->width.'px;\">'.$this->comment.'</div>';
			} else {
				$commbox = '<div class=\"descbox\" style=\"position:absolute; line-height:1.4; text-align:right;\">'.$this->comment.'</div>';
			}
			echo '
				<script>
					$("'.$this->element.'").append("'.$commbox.'");
					$("'.$this->element.' > .descbox").css("display", "none").css("top", $("'.$this->element.'").height()).css("'.$this->direction.'", "0");
					$("'.$this->element.'").bind({
						mouseenter: function () {
								$("'.$this->element.' > .descbox").css("display", "block");
						},
						mouseleave: function () {
								$("'.$this->element.' > .descbox").css("display", "none");
						}
					});
				</script>
			';
		}
	}
?>