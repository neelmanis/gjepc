<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Category extends MX_Controller
{
	function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('mdl_category');	

	}

	function _getWhere($data = array()){
		return $this->mdl_category->get_where($data);
	}

	function _getSlug($catId = 0){
		$result = $this->mdl_category->get_where(array('catId'=>$catId));
		return $result[0]->slug;
	}

	function _getName($catId = 0){
		$result = $this->mdl_category->get_where(array('catId'=>$catId));
		return $result[0]->catName;
	}
	
	function lists($status = 'active')
	{
		$template = 'admin';
		$data['viewFile'] = "lists";
		$data['page'] = 'categories';
		$data['menu'] = 'lists';

		$isActive = ($status == 'active') ? '1' : '0';

		$getCategories = $this->mdl_category->get_where(array('isActive'=>$isActive));
		$data['getAllCategories'] = $getCategories;
		echo Modules::run('template/'.$template, $data);
	}

	function add(){
		$template = 'admin';
		$data['viewFile'] = "add";
		$data['page'] = 'categories';
		$data['menu'] = 'add';

		echo Modules::run('template/'.$template, $data);
	}

	function edit($catId){
		$template = 'admin';
		$data['viewFile'] = "edit";
		$data['page'] = 'categories';
		$data['menu'] = 'edit';
	    $catId = intval($catId);
       	$getCategories = $this->mdl_category->get_where(array('catId'=>$catId));
		$data['categories'] = $getCategories[0];
		$data['status'] = $getCategories[0]->isActive;
		echo Modules::run('template/'.$template, $data);
	}

	function jsonCategories(){
		$new = array(); $json = array();
		$categories = $this->mdl_category->_conditions(array('isActive'=>'1'), array('parentId'=>0, 'parentId'=>1));

		foreach($categories as $category){
			$new['id'] = $category->catId;
			$new['text'] = $category->catName;

			array_push($json, $new);
		}
		echo json_encode($json);
	}
	
	function collection()
	{
		if(isset($_POST['isAjax'])){
			$getCategories = $this->_getwhere(array('parentId' => '1','isActive'=>'1'));
			
			echo json_encode($getCategories);
		}
		else {
			redirect('/');
		} 
	}

	function newcategory(){
		if(Modules::run('site_security/is_admin')):
			if(!isset($_POST)) {
				show_error(INVALID_PAGE);
			}
			else{
				$result = $this->mdl_category->newcategory();
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

	function editcategory(){
		if(Modules::run('site_security/is_admin')):
			if(!isset($_POST)) {
				show_error(INVALID_PAGE);
			}
			else{
				$result = $this->mdl_category->editcategory();
				if( $result == 'validationErrors')
					echo validation_errors('<p>','</p>');
				elseif( $result == 'failed')
					echo '"Oops. Something went wrong. Please try again later."';
				elseif( $result == 'success') {
					$this->session->set_flashdata('success', 'Category Updated Successfully!!!');
					echo 'success';
				}
				else
					echo $result;
			}
		else:
			show_error(INVALID_PAGE);
		endif;
	}

	function delcategory($catId){
		if(Modules::run('site_security/is_admin')):
			$catId = intval($catId);
			if($this->mdl_category->_delete($catId))
				echo 'success';
			else
				echo 'failure';
		else:
			show_error(INVALID_PAGE);
		endif;
	}

	function view($slug = '',$order=''){
		$template = 'twoColLeft';
		$data['viewFile'] = "listing";

		if($order == 'lowtohigh') {
			$orderStatus = 'asc'; 
			$data['position'] = "lowtohigh";
			}
		else {
			$orderStatus = 'desc';
			$data['position'] = "hightolow";
		}
		$categories = $this->mdl_category->get_where(array('slug'=>$slug,'isActive'=>'1'));
		$data['categories'] = $categories[0];
		$data['pagetitle'] = $categories[0]->name;
		$cat = $categories[0]->name;
		$catId = $categories[0]->catId;
		$subcategories = $this->mdl_category->get_where(array('parentId'=>$catId,'isActive'=>'1'));
		$productRecord = $this->mdl_category->get_catproduct(array('catId'=>$catId,'status'=>'A'),$orderStatus);
		
		$data['hightolow'] = base_url()."category/view/".$slug."/hightolow";
		$data['lowtohigh'] = base_url()."category/view/".$slug."/lowtohigh";
		
		/*----- PRICE FILTER ------*/
		$data['content'] = $this->mdl_category->showprice($catId);
		$min = $data['content']->minprice;
		$max = $data['content']->maxprice;

		$j = $max/100;
		$set = $min;
		$pricelist = array();
			for($i=1;$i<=$j;$i++)
			{
				$a = $set;
				$b = $a + 99;
			    $count = $this->mdl_category->getcount($catId,$a,$b);	
				$c = "<a href='".base_url()."product/searchrange/".$cat."/".$a."-".$b."'><i class='fa fa-rupee'></i>".$a." - <i class='fa fa-rupee'></i>.".$b." (".$count.")</a>"; 
				$set = $b+1;
				if($a <= $max){
					if($count != 0){
					array_push($pricelist,$c);
					}
				}
			}
		$data['pricefilter'] = $pricelist;
		/*----- PRICE FILTER ------*/
		
		
		$data['catproduct'] = $productRecord['result'];
		$data['totalcounts'] = $productRecord['totalcount'];
		
		$data['catname'] = $slug;
		$data['breadcrumb'] = $categories[0]->name;
		$data['title'] = 'EASYRENTIL - '.$categories[0]->name;
		$data['leftPanel'] = 'filters';

		if(sizeof($subcategories))
			$data['subcategories'] = $subcategories;
		
		echo Modules::run('template/'.$template, $data);
	}
	
	/*---- sheetal code -----*/
	
	function subCategory($parentId='',$selectCat='')
	{
		if(!empty($parentId))
			$parentId=$parentId;
		else
			$parentId=$this->input->post('parentId');
		if(!empty($selectCat))
			$selectCat=$selectCat;
		else
			$selectCat=$this->input->post('selectCat');

		if($selectCat=='edit')
		{
			$userId=Modules::run('site_security/getUserIdfromSession');
			$catresult=Modules::run('category/get_categories_by_userId',$userId,1)->result();
		
			
			$usersubcategories = array();
			$catresult=array_filter($catresult);
				foreach($catresult as $catlist):
					$usersubcategories[] = $catlist->subCatId;
				endforeach;
		}

		 $parentIds=explode(",",trim($parentId));
		
		$categories_list=$this->get_categories_by_parentId($parentIds)->result();
		$categories = array();
		$str="";
		$cnt=1;
		if($categories_list!='')
		{
			foreach($categories_list as $cat)
				{
					$str .= "<div class='col-xs-6 col-sm-3'>";
					$str .= "<label class='selectCat' for='c$cnt'>";
					$str .= "<input type='radio' class='hiddenFile' name='selCat' id='c".$cnt."' value='$cat->name' onclick="."'subcat(\'c".$cnt."\')'>";
					$str .= "<i class='icon'><img src='<?php echo base_url() ?>uploads/category_icons/$cat->icon'></i> <span class='name'>$cat->name</span> </label></div>";				
					$cnt++;	
				}
		}
		
		echo $str;
	}
	
	function getsubcat()
	{
		if(isset($_POST['isAjax']))
		{
			if(!empty($_POST['catId']))
			{
				$catId = $_POST['catId'];	
				$categories_list = $this->mdl_category->get_subcat_by_cat_id($catId);
				echo json_encode($categories_list);
			}
			else
			{
				redirect('/product/add_product');	
			}
		}
		else {
			redirect('/');	
		}	
	}
		
	/*---- sheetal code -----*/
	
	
	
}

