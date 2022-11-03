<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Cms extends MX_Controller
{
	function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('mdl_cms');	

	}
	
	function index()
	{
		echo "heooo";
	}
	function lists($status = 'active')
	{
		$template = 'admin';
		$data['viewFile'] = "lists";
		$data['page'] = 'cms';
		$data['menu'] = 'lists';

		$isActive = ($status == 'active') ? '1' : '0';

		$getCms = $this->mdl_cms->get_where(array('isActive'=>$isActive));
		$data['getAllCms'] = $getCms;
		echo Modules::run('template/'.$template, $data);
	}

	function add(){
		$template = 'admin';
		$data['viewFile'] = "add";
		$data['page'] = 'cms';
		$data['menu'] = 'add';

		echo Modules::run('template/'.$template, $data);
	}

	function edit($cmsId){
		$template = 'admin';
		$data['viewFile'] = "edit";
		$data['page'] = 'cms';
		$data['menu'] = 'edit';
		$cmsId = intval($cmsId);

		$getcms = $this->mdl_cms->get_where(array('cmsId'=>$cmsId));
		$data['cms'] = $getcms[0];
		echo Modules::run('template/'.$template, $data);
	}


	function newcms(){
		if(Modules::run('site_security/is_admin')):
			if(!isset($_POST)) {
				show_error(INVALID_PAGE);
			}
			else{
				$result = $this->mdl_cms->newcms();
				if( $result == 'validationErrors')
					echo validation_errors('<p>','</p>');
				elseif( $result == 'failed')
					echo '"Oops. Something went wrong. Please try again later."';
				elseif( $result == 'success')
					echo 'success';
				else
					echo $result;
			}
		else:
			show_error(INVALID_PAGE);
		endif;
	}

	function editcms(){
		if(Modules::run('site_security/is_admin')):
			if(!isset($_POST)) {
				show_error(INVALID_PAGE);
			}
			else{
				$result = $this->mdl_cms->editcms();
				if( $result == 'validationErrors')
					echo validation_errors('<p>','</p>');
				elseif( $result == 'failed')
					echo '"Oops. Something went wrong. Please try again later."';
				elseif( $result == 'success') {
					$this->session->set_flashdata('success', 'Cms Updated Successfully!!!');
					echo 'success';
				}
				else
					echo $result;
			}
		else:
			show_error(INVALID_PAGE);
		endif;
	}

	function delcms($cmsId){
		if(Modules::run('site_security/is_admin')):
			$cmsId = intval($cmsId);
			if($this->mdl_cms->_delete($cmsId))
				echo 'success';
			else
				echo 'failure';
		else:
			show_error(INVALID_PAGE);
		endif;
	}
}

