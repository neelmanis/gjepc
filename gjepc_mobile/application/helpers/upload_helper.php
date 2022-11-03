<?php 

if (!function_exists('upload')) {

	function upload($options = array()){
		$ci = &get_instance();

		$path = './uploads/'.$options['upload_path'];
		$config['upload_path'] = $path;
		$config['allowed_types'] = 'gif|jpg|jpeg|png';
		$config['max_size']	= '2048';
		$config['encrypt_name'] = TRUE;

		if(!empty($options['max_width']))
			$config['max_width']  = $options['max_width'];

		if(!empty($options['max_height']))
			$config['max_height']  = $options['max_height'];

		$ci->load->library('upload');
		$ci->upload->initialize($config);

		if ( ! $ci->upload->do_upload($options['name']))
			return array('errors'=>$ci->upload->display_errors());
		else{
			$data = $ci->upload->data();
			$filename = $data['raw_name'].$data['file_ext'];
			/* on success unset config */
			unset($config);
			return array('filename'=>$filename, 'full_path'=>$data['full_path']);
		}
	}
}