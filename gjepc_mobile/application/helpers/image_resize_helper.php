<?php
if (!function_exists('image_resizer')) {
    
    function image_resizer($projectId='',$width,$height,$croptofit='crop-to-fit',$other='',$regId='',$imagetype='')
    {   
        if(!empty($other)){
            
            if(!empty($imagetype) && $imagetype=='products')
            {
                    $imgpath= 'uploads/users/' . $regId . '/'.$imagetype.'/' . $other;
            }
		
			/*             
            elseif(!empty($imagetype) && $imagetype=='featured')
            {
                
                    $imgpath= 'uploads/featured/' . $regId . '/profile/' . $other;
            }
            else if(!empty($imagetype) && $imagetype=='project')
                $imgpath= 'uploads/' . $regId . '/'. $other;
            else
                $imgpath= 'uploads/' . $regId . '/'. $other; */			
            if(file_exists($imgpath))
            {
                $cacheimgpath= 'cache/'.$regId.'/'. $other;
                if(!empty($other) && file_exists($cacheimgpath)==true)
                    $stringimgpath= 'cache/'.$regId.'/'. $other;
                else
                $string = base_url(). $imgpath;
            }
            else
			{	
                $string = base_url() . 'assets/new/images/no-image.jpg';
			}	
			
			
			if(isset($stringimgpath) && !empty($stringimgpath))
                $sourceurl=base_url().$stringimgpath;
            else
            $sourceurl=base_url()."imglib/config/img.php?src=".$string."&w=$width&h=$height&$croptofit";
            return $sourceurl;
        }
        else
        {
            $string =base_url() . 'assets/new/images/no-image.jpg';
        }
    }
}

function organisation_types()
{

    $organisation_types=array("1"=>"Private Limited","2"=>"Public Limited","3"=>"Partnership Firm","4"=>"Proprietary Firm");
    return $organisation_types;
}
?>