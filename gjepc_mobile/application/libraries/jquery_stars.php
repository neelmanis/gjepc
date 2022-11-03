<?php
/*@Name => Codeigniter Stars
 *@Version => 1.0
 *@Developer => Mark Lenard M. Mirandilla
 *@Description => Implementation of orkans' jquery stars (http://orkans-tmp.22web.net/star_rating/index.html)
 * 					This implemntation is configuring the jquery stars in pure PHP thus, 
 * 					making you to maintain your code in PHP instead of maintaning both PHP and Javascript
 */
class jquery_stars {
	
	private $place_holder_id; //id if the div where the stars would be rendered
	private $output_star; //completed script and html of the star
	
	public function set_place_holder_id($div_id) {
		$this->place_holder_id = $div_id;
	}
	
	public function init_stars($config = array()) {
		$name = $id = $config['id'];
		$label = $config['label'];
		$stars = $config['stars'];
		$config['one_vote']='false';
		$selected_text = '';
		$input_type = "select"; /*required since I used the select option for rendering*/
		$disabled = ($config['disabled'] === TRUE)?'true':'false';
		$enable_caption = ($config['enable_caption'] === TRUE)?"$('#ci-stars-cap')":NULL;
		$one_vote = ($config['one_vote'] === TRUE)?'true':'false';
		
		$output = "<label class='col-sm-3 control-label'>$label</label><div class='col-sm-9' id='".$this->place_holder_id."'><select id='$id' name='$name'>";
			foreach ($stars as $star) {
				
				if(isset($star['selected'])) {
					if($star['selected'] === TRUE) $selected_text = "selected='selected'";
					else $selected_text = "";
				}
				
				$output.= "<option value='".$star['value']."' $selected_text >".$star['text']."</option>";
			}
			$output .= "</select><span id='ci-stars-cap' class='ci-stars-cap'></span></div>";

		
		$output .= "
			<script>
			$(document).ready(function() {
			$('#".$this->place_holder_id."').stars({
			inputType: '$input_type',
			disabled: $disabled,";
			if($enable_caption) $output.="captionEl: $enable_caption,";
			$output .= "oneVoteOnly: $one_vote";
		$output .= "});
		});</script>";
		$this->output_star = $output;
	}
	
	public function get_stars() {
		if($this->output_star) return $this->output_star;
		else return "NO STARS";
	}

}
