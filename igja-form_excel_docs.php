<?php
include 'db.inc.php';
include 'functions.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

$query = "SELECT * FROM igja_industry_performance_and_theme_based_awards";
$table = $display = ""; 
$fn = "report";

$table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td>Id</td>
<td>Created Date</td>
<td>company name</td>
<td>Year of Establishment</td>
<td>Importer Exporter Code No.</td>
<td>Tel No.</td>
<td>Email ID</td>
<td>Company Website</td>
<td>Address.</td>
<td>Address Line 2</td>
<td>City</td>
<td>State</td>
<td>Zipcode</td>

<td>Annual Reports</td>
<td>Income Tax Return</td>

<td>Countries (not regions)</td>
<td>Documents/literature</td>

<td>Explanation related to financial details</td>
<td>Number of outlets of Company</td>
<td>Number of International Clients and Importing countries</td>
<td>Woman Entrepreneur</td>

<td>Research and Development undertaken by your company</td>
<td>Corporate Social Responsibility Files</td>
<td>Corporate Social Responsibility Video</td>
<td>Marketing undertaken by your company</td>
<td>Marketing undertaken by your company video</td>
<td>Manufacturing undertaken by your company</td>
<td>E- Commerce Platform in last two financial year</td>

<td>CA Docs</td>

<td>Status</td>
</tr>';
$sql="SELECT * FROM igja_industry_performance_declaration WHERE STATUS='Y' AND email_id !='sample@email.tst' AND email_id != 1";
$result1 = $conn->query($sql);   
//print_r($result1);die();
while(($row = $result1->fetch_assoc()) !== null)
{  
    $id=$row['reg_id'];
    //$sql="SELECT * FROM  igja_industry_performance_and_theme_based_awards";

    $sql="SELECT * FROM  igja_industry_performance_and_theme_based_awards where id=$id";
    $result = $conn->query($sql);   
    while(($row = $result->fetch_assoc()) !== null)
    {   

    $id=$row['id'];
    $created_at = $row['created_at'];
    $company_name=$row['company_name'];
    $est_year=$row['est_year'];
    $imp_exp_code=$row['imp_exp_code'];
    $tel_no=$row['tel_no'];
    $email=$row['email_id'];
    $website = $row['website'];
    $address_line_1 = $row['address_line_1'];
    $address_line_2 = $row['address_line_2'];
    $city = $row['city'];
    $state = $row['state'];
    $zipcode = $row['zipcode'];
    $attachments_array = array();
    $attachments_array = unserialize($row['attatchments']);
    $attach = '';$income_tax_return_attatchments='';
    $upload_dir = 'https://gjepc.org/images/igja_awards/';
    if($attachments_array){
        foreach($attachments_array['annual_reports'] as $key=>$value){
            $attach .= $upload_dir.$value.',';
        }
        foreach($attachments_array['income_tax_return_attatchments'] as $key=>$value){
            $income_tax_return_attatchments .= 'images/igja_awards/'.$value.',';
        }
       
    } else{
        $attach = '';$income_tax_return_attatchments='';
    }
    
   
    $sql_query = "SELECT * FROM  igja_industry_performance_best_growing_performance where reg_id=$id ORDER BY id desc";
    $growing = $conn->query($sql_query);
    $growing =  $growing->fetch_assoc();
    $countries = '';
    $attatch_array=array();
    if(!empty($growing['attatchments'])){
        $attatch_array = unserialize($growing['attatchments']);
        if($attatch_array){
            foreach($attatch_array['attatchments'] as $key=>$value){
                $countries .= $upload_dir.$value.',';
            }
        } else{
            $countries = '';
        }
    }
    $financial_ = '';
    if(!empty($growing)){
        $financial_year = unserialize($growing['financial_year']);
        if(!empty($financial_year)){
             
            if($financial_year){
                foreach($financial_year['financial_year'] as $key=>$value){
                    $financial_ .= $upload_dir.$value.',';
                }
            } else{
                $financial_ = '';
            }
        }
    }
    
    

    $sql_query = "SELECT * FROM  igja_industry_perfomance_qualitative_info where reg_id=$id ORDER BY id desc";
    $qualitative_info = $conn->query($sql_query);
    if($qualitative_info){
        $qualitative_info =  $qualitative_info->fetch_assoc();
    } else{
        $qualitative_info =  array();
    }
    $financial_details=array();$financial = '';
    if(!empty($qualitative_info['attatchments'])){
        $financial_details = unserialize($qualitative_info['attatchments']);
        
        if(!empty($financial_details)){
            if($financial_details){
                foreach($financial_details['attatchments'] as $key=>$value){
                    $financial .= $upload_dir.$value.',';
                }
            } else{
                $financial = '';
            }
        }
    }
    $number_comp_outlets = '';
    if(!empty($qualitative_info['number_comp_outlets_files'])){
        $number_comp_outlets_files = unserialize($qualitative_info['number_comp_outlets_files']);
       
        if($number_comp_outlets_files){
            foreach($number_comp_outlets_files['number_comp_outlets_files'] as $key=>$value){
                $number_comp_outlets .= $upload_dir.$value.',';
            }
        } else{
            $number_comp_outlets = '';
        }
    }
    $number_of_internation_clients_fi = '';
    if(!empty($qualitative_info['number_of_internation_clients_files'])){
        $number_of_internation_clients_files = unserialize($qualitative_info['number_of_internation_clients_files']);
        
        if(!empty($number_of_internation_clients_files)){
            if($number_of_internation_clients_files){
                foreach($number_of_internation_clients_files['number_of_internation_clients_files'] as $key=>$value){
                    $number_of_internation_clients_fi .= $upload_dir.$value.',';
                }
            } else{
                $number_of_internation_clients_fi = '';
            }
        }
    
    }
    
    // $igja_industry_perfomance_qualitative_info = $qualitative_info['igja_industry_perfomance_qualitative_info'];
    // $igja_industry_perfomance_qualitative = '';
    // if($igja_industry_perfomance_qualitative_info){
    //     foreach($igja_industry_perfomance_qualitative_info['igja_industry_perfomance_qualitative_info'] as $key=>$value){
    //         $igja_industry_perfomance_qualitative .= $upload_dir.$value.',';
    //     }
    // } else{
    //     $igja_industry_perfomance_qualitative = '';
    // }
    $approach = '';
    if(!empty($qualitative_info['approach_file'])){
        $approach_file = unserialize($qualitative_info['approach_file']);
       
        if(!empty($approach_file)){
            foreach($approach_file['approach_file'] as $key=>$value){
                $approach .= $upload_dir.$value.',';
            }
        } else{
            $approach = '';
        }
    }
    

    $sql_query = "SELECT * FROM  igja_theme_based_innovative_company where reg_id=$id ORDER BY id desc";
    $innovative_company = $conn->query($sql_query);
    $innovative_company =  $innovative_company->fetch_assoc();
    $activities=array(); $activit = '';
    if(!empty($innovative_company['attatchments'])){
        $activities = unserialize($innovative_company['attatchments']);
       
        if(!empty($activities)){
            foreach($activities['attatchments'] as $key=>$value){
                $activit .= $upload_dir.$value.',';
            }
        } else{
            $activit = '';
        }
    }
    $additional_s = '';
    if(!empty($innovative_company['additional_sheets'])){
        $additional_sheets = unserialize($innovative_company['additional_sheets']);
        if(!empty($additional_sheets)){
            foreach($additional_sheets['additional_sheets'] as $key=>$value){
                $additional_s .= $upload_dir.$value.',';
            }
        } else{
            $additional_s = '';
        }
    }
    $additional_sheets_v = '';
    if(!empty($innovative_company['additional_sheets_video'])){
        $additional_sheets_video = unserialize($innovative_company['additional_sheets_video']);
        if(!empty($additional_sheets_video)){
            foreach($additional_sheets_video['additional_sheets_video'] as $key=>$value){
                $additional_sheets_v .= $upload_dir.$value.',';
            }
        } else{
            $additional_sheets_v = '';
        }
    }
    $relevant_mate = '';
    if(!empty($innovative_company['relevant_material'])){
        $relevant_material = unserialize($innovative_company['relevant_material']);
        if(!empty($relevant_material)){
            foreach($relevant_material['relevant_material'] as $key=>$value){
                $relevant_mate .= $upload_dir.$value.',';
            }
        } else{
            $relevant_mate = '';
        }
    }
    $relevant_material_vid = '';
    if(!empty($innovative_company['relevant_material_video'])){
        $relevant_material_video = unserialize($innovative_company['relevant_material_video']);
        if(!empty($relevant_material_video)){
            foreach($relevant_material_video['relevant_material_video'] as $key=>$value){
                $relevant_material_vid .= $upload_dir.$value.',';
            }
        } else{
            $relevant_material_vid = '';
        }
    }
    $innovation_of_manufactur = '';
    if(!empty($innovative_company['innovation_of_manufacturing'])){
        $innovation_of_manufacturing = unserialize($innovative_company['innovation_of_manufacturing']);
        if($innovation_of_manufacturing){
            foreach($innovation_of_manufacturing['innovation_of_manufacturing'] as $key=>$value){
                $innovation_of_manufactur .= $upload_dir.$value.',';
            }
        } else{
            $innovation_of_manufactur = '';
        }
    }
    $e_commer = '';
    if(!empty($innovative_company['e_commerce'])){
        $e_commerce = unserialize($innovative_company['e_commerce']);
        if($e_commerce){
            foreach($e_commerce['e_commerce'] as $key=>$value){
                $e_commer .= $upload_dir.$value.',';
            }
        } else{
            $e_commer = '';
        }
    }
    

    $sql_query = "SELECT * FROM  igja_industry_performance_declaration where reg_id=$id ORDER BY id desc";
    $declaration = $conn->query($sql_query);
    $declaration =  $declaration->fetch_assoc();
    $ca_attachments=array(); $ca_attachment = '';
    if(!empty($declaration['attatchments'])){
        $ca_attachments = unserialize($declaration['attatchments']);
        if($ca_attachments){
            foreach($ca_attachments['attatchments'] as $key=>$value){
                $ca_attachment .= $upload_dir.$value.',';
            }
        } else{
            $ca_attachment = '';
        }
    }
    if(!empty($declaration['status'])){
        $status = $declaration['status'];
    } else{
        $status = '';
    }
   

    $table .= '<tr>
    <td>'.$id.'</td>
    <td>'.$created_at.'</td>
    <td>'.$company_name.'</td>
    <td>'.$est_year.'</td>
    <td>'.$imp_exp_code.'</td>
    <td>'.$tel_no.'</td>
    <td>'.$email.'</td>
    <td>'.$website.'</td>
    <td>'.$address_line_1.'</td>
    <td>'.$address_line_2.'</td>
    <td>'.$city.'</td>
    <td>'.$state.'</td>
    <td>'.$zipcode.'</td>

    <td>'.$attach.'</td>
    <td>'.$income_tax_return_attatchments.'</td>

    <td>'.$financial_.'</td>
    <td>'.$countries.'</td>

    <td>'.$financial.'</td>
    <td>'.$number_comp_outlets.'</td>
    <td>'.$number_of_internation_clients_fi.'</td>
    <td>'.$approach.'</td>
   
    <td>'.$activit.'</td>
    <td>'.$additional_s.'</td>
    <td>'.$additional_sheets_v.'</td>
    <td>'.$relevant_mate.'</td>
    <td>'.$relevant_material_vid.'</td>
    <td>'.$innovation_of_manufactur.'</td>
    <td>'.$e_commer.'</td>

    <td>'.$ca_attachment.'</td>

    <td>'.$status.'</td>
    </tr>';
   
    }    
}
$table .= $display;
$table .= '</table>';

    header("Content-type: application/x-msdownload"); 
    # replace excelfile.xls with whatever you want the filename to default to
    header("Content-Disposition: attachment; filename=$fn.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    echo $table;
exit;   

?>