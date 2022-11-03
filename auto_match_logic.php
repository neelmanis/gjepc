<?php

function buy_sell_auto_match_page() {
	global $user;
	$user_type = db_result(db_query('SELECT buy_sell_profile_code from obmp_profile WHERE uid = %d', $user->uid));

	if(empty($user_type)) {
		   drupal_set_message('Please fill up buy / sell profile form.', 'error');
	       drupal_goto('mygjepc/buy_sell/buy_sell_profile_form');
	}

	$automatch_list = '<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="14"><img src="' . base_path() . path_to_theme().'/images/new_mygjepc/heading_left_curve.gif" width="14" height="37" /></td>
            <td width="68" background="' . base_path() . path_to_theme().'/images/new_mygjepc/heading_bg_curve.gif" class="content_heading">Auto Match</td>
            <td width="14"><img src="' . base_path() . path_to_theme().'/images/new_mygjepc/heading_right_curve.gif" width="14" height="37" /></td>
            <td background="' . base_path() . path_to_theme().'/images/new_mygjepc/heading_content_bg.gif">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td bgcolor="#f3f4f0" class="content_body" style="padding:13px; border:1px solid #ecede9;">';

	if($user_type == 'NM') {
	    $profile = db_fetch_array(db_query("SELECT * FROM obmp_profile WHERE uid = %d", $user->uid));
	    foreach($profile as $key => $value) {
               if(buy_sell_auto_match_is_serialized($value)) {
	          $profile[$key] = unserialize($value);
	       }
	    }

	    $match = array();
	    buy_sell_auto_match_logic($profile, $match);
	    
	    foreach($match as $cat_key => $cat_value) {
		foreach($cat_value as $value) {
			$where[] = $cat_key . " LIKE " . "'%%$value%%'";
		}
	    }

   	    $where_string = implode(' OR ', $where);
	    $query_string['search'] = "SELECT uid, contact_person, company_name, write_up, wa_jewellery, wa_machinery, wa_other, wa_jewellery_other, wa_machinery_other, wa_other_other, pd_jewellery, pd_machinery, pd_jewellery_other, pd_machinery_other, company_logo_fid FROM 
        obmp_profile WHERE buy_sell_profile_code = 'M' AND (" . $where_string . ") ORDER BY created DESC";

	    $query_string['count'] = "SELECT count(*) FROM obmp_profile WHERE buy_sell_profile_code = 'M' AND ("							 . $where_string .")";

	    // sql to fetch number of records
	    $sql_count = $query_string['count'];

	    // define number of results per page
	    $number_results = 10;

	    // sql tofetch records
	    $sql = $query_string['search'];

	    // execute query
	    $resource = pager_query($sql, $number_results, 0, $sql_count);

	    while($result = db_fetch_array($resource)) { 
		$lists[] = $result;
	    }

	    $header = array(array('data' => 'Company'),
			    array('data' => 'Description'),
			    array('data' => 'Operations'),
		           );

	    $rows = array();
	    if(!empty($lists)) {
	        foreach($lists as $key => $list) {
		   //company logo
		   if(!empty($list['company_logo_fid'])) {
		             $filepath = db_result(db_query("SELECT filepath FROM {files} WHERE fid = %d", $list['company_logo_fid']));
			     $image = "<img src = '" . base_path() . $filepath . "' height='100' width='100'>";
		   }
		   else {
			   $c = $key+1;
			   $filepath = 'sites/default/files/list_images/0' . $c . '.jpg';
			     $image = "<img src = '" . base_path() . $filepath . "' height='100' width='100'>";
		   }

			// We are and We deal in
			$we_are = '';
			unset($wa);
			$product_dealing = '';
			unset($pd);
			$list['wa_jewellery'] = unserialize($list['wa_jewellery']);
			$list['wa_machinery'] = unserialize($list['wa_machinery']);
			$list['wa_other'] = unserialize($list['wa_other']);
			$list['pd_jewellery'] = unserialize($list['pd_jewellery']);
			$list['pd_machinery'] = unserialize($list['pd_machinery']);

			$bullet = '<img src="'. base_path() . path_to_theme() . '/images/new_mygjepc/blue_bullet.gif" width="6" height="6" />';
			if(!empty($list['wa_jewellery'])) { 
				if(in_array('any other', $list['wa_jewellery'])) {
				   unset($list['wa_jewellery'][array_search('any other', $list['wa_jewellery'])]);
				}
				if(!empty($list['wa_jewellery_other'])) {
					$list['wa_jewellery'][] = $list['wa_jewellery_other']; 
				}
				$wa[] = "<b>Jewellery</b> $bullet " . implode(', ', $list['wa_jewellery']);
			}
			if(!empty($list['wa_machinery'])) { 
				if(in_array('any other', $list['wa_machinery'])) {
				   unset($list['wa_machinery'][array_search('any other', $list['wa_machinery'])]);
				}
				if(!empty($list['wa_machinery_other'])) { 
				    $list['wa_machinery'][] = $list['wa_machinery_other'];
				}
				$wa[] = "<b>Machinery</b> $bullet " . implode(', ', $list['wa_machinery']);
			}
			if(!empty($list['wa_other'])) {
				if(in_array('any other', $list['wa_other'])) {
				   unset($list['wa_other'][array_search('any other', $list['wa_other'])]);
				}				
				if(!empty($list['wa_other_other'])) {
					$list['wa_other'][] = $list['wa_other_other']; 
				}
				$wa[] = "<b>Others</b> $bullet " . implode(', ', $list['wa_other']);
			}
			if(!empty($wa)) { $we_are = '<b style="color:#F16608">We are : </b>' . 
			ucwords(implode(', ', $wa)); }

			if(!empty($list['pd_jewellery'])) { 
				if(in_array('any other', $list['pd_jewellery'])) {
				   unset($list['pd_jewellery'][array_search('any other', $list['pd_jewellery'])]);
				}								
				if(!empty($list['pd_jewellery_other'])) {
					$list['pd_jewellery'][] = $list['pd_jewellery_other']; 
				}
				$pd[] = "<b>Jewellery</b> $bullet " . implode(', ', $list['pd_jewellery']);
			}
			if(!empty($list['pd_machinery'])) { 
				if(in_array('any other', $list['pd_machinery'])) {
				   unset($list['pd_machinery'][array_search('any other', $list['pd_machinery'])]);
				}					
				if(!empty($list['pd_machinery_other'])) {
					$list['pd_machinery'][] = $list['pd_machinery_other']; 
				}
				$pd[] = "<b>Machinery</b> $bullet " . implode(', ', $list['pd_machinery']);
			}
			if(!empty($pd)) { $product_dealing = '<b style="color:#F16608">We deal in : </b>' . ucwords(implode(', ', $pd)); }

			// Company description			
			$brief = '';
			$no_storefront = 'javascript: var answer = alert("No storefront available");
							  if (answer == true) {
								return true;
							  }
							  else {
								return false;
							  }';
			if(!empty($list['write_up'])) {
				$brief = substr($list['write_up'], 0, 125) . '...';
				$no_storefront = '';
			}

			// Company name and contact person
			$company = '<b style="color:#118BD8">' . 
			l(strtoupper($list['company_name']), 'mygjepc/buy_sell/storefront/view/' . $list['uid'], 
			array('attributes' => array('target' => '_blank',
									    'style' => 'margin-left:0px; font-weight:bold;',
										'onclick' => $no_storefront
										))) . '</b>' . 
			'<span style="font-size:10px; color:#F16608"> (' . ucwords(strtolower($list['contact_person'])) . ')</span>' . '<br>' .
			$brief . '<br><span style="font-size:11px;">' . $we_are . '<br>' . $product_dealing . '</span>';

		    $storefront = l('View Storefront', 'mygjepc/buy_sell/storefront/view/' . $list['uid'], array('attributes' => array('target' => '_blank', 
						  'style' => 'font-size:12px;', 
						  'onclick' => $no_storefront
						  )));

		   $send_enquiries = l('Send Enquiries', 'mygjepc/buy_sell/send_enquiries/' . $list['uid'], array('attributes' => array('target' => '_blank', 'style' => 'font-size:12px;')));

		   $rows[$key] = array(array('data' => $image, 'width' => '100px', 'valign' => 'top'),
			             array('data' => $company, 'width' => '400', 'valign' => 'top'),
					     array('data' => "$storefront<br>$send_enquiries", 'width' => '120px', 'align' => "left", 'style' => "line-height:21px;"),
				      );
	           }
	
		   // create table html
           $table_attributes = array('id' => 'directory_listing');
		   $automatch_list .= "<br>" . theme('table', $header, $rows,$table_attributes);

		   $total = db_result(db_query($sql_count));
	       $automatch_list .= "<span style='font-size:12px;'>Search Result: $total</span>";

	           // create pager html
	           $automatch_list .= theme('pager', NULL, $number_results, 0);
	    }
	    else {
	       $automatch_list .=  "No records found.";
	    }
	}
    $automatch_list .= '</td>
      </tr>
    </table></td>
  </tr>
</table>';
	return $automatch_list;
}

function buy_sell_auto_match_logic($profile, &$match) {
	if(!empty($profile['wa_jewellery'])) {
	   foreach($profile['wa_jewellery'] as $v) {
	      buy_sell_auto_match_switch($match, 'wa_jewellery', $v);
	   }
        }

	if(!empty($profile['wa_machinery'])) {
  	   foreach($profile['wa_machinery'] as $v) {
	      buy_sell_auto_match_switch($match, 'wa_machinery', $v);
	   }
	}

	if(!empty($profile['wa_other'])) {
  	   foreach($profile['wa_other'] as $v) {
	      buy_sell_auto_match_switch($match, 'wa_other', $v);
	   }
	}

	if(!empty($profile['pd_jewellery'])) {
  	   foreach($profile['pd_jewellery'] as $v) {
	      buy_sell_auto_match_switch($match, 'pd_jewellery', $v);
	   }
	}

	if(!empty($profile['pd_machinery'])) {
  	   foreach($profile['pd_machinery'] as $v) {
	      buy_sell_auto_match_switch($match, 'pd_machinery', $v);
	   }
	}

	if(!empty($profile['objective'])) {
  	   foreach($profile['objective'] as $v) {
	      buy_sell_auto_match_switch($match, 'objective', $v);
	   }
	}
}

function buy_sell_auto_match_switch(&$match, $category, $subcategory) {
	switch($category) {
		case 'wa_jewellery':
			switch($subcategory) {
			       case 'importers': 
					$match_keys = array(2, 3, 5, 7);
					buy_sell_auto_match_wa_jewellery_options($match, $match_keys);
					break;

			       case 'exporters': 
					$match_keys = array(1, 5, 6, 7, 8);
					buy_sell_auto_match_wa_jewellery_options($match, $match_keys);
					break;
			            
			       case 'manufacturers': 
					$match_keys = array(1, 5, 6, 7, 8);
					buy_sell_auto_match_wa_jewellery_options($match, $match_keys);
					break;

			       case 'goldsmiths': 
					$match_keys = array(2);
					buy_sell_auto_match_wa_jewellery_options($match, $match_keys);
					break;

			       case 'wholesalers': 
					$match_keys = array(1, 5, 6, 7, 8);
					buy_sell_auto_match_wa_jewellery_options($match, $match_keys);
					break;

			       case 'retailers': 
					$match_keys = array(2, 3, 5);
					buy_sell_auto_match_wa_jewellery_options($match, $match_keys);
					break;

			       case 'agents': 
					//pending all
					break;

			       case 'chain stores': 
					$match_keys = array(2, 3, 5);
					buy_sell_auto_match_wa_jewellery_options($match, $match_keys);
					break;

		               case 'designers':
					$match_keys = array(4, 3, 10);
					buy_sell_auto_match_wa_jewellery_options($match, $match_keys);
					break;

		               case 'artists/craftstmen':
					$match_keys = array(3, 10);
					buy_sell_auto_match_wa_jewellery_options($match, $match_keys);
					break;
			}
			break;

		case 'wa_machinery':
			switch($subcategory) {
			       case 'importers': 
					$match_keys = array(2, 3, 4, 6);
					buy_sell_auto_match_wa_machinery_options($match, $match_keys);
					break;

			       case 'exporters': 
					$match_keys = array(1, 4, 5, 6, 7, 8);
					buy_sell_auto_match_wa_machinery_options($match, $match_keys);
					break;
			            
			       case 'manufacturers': 
					$match_keys = array(1, 4, 5, 6, 7, 8);
					buy_sell_auto_match_wa_machinery_options($match, $match_keys);
					break;

			       case 'wholesalers': 
					$match_keys = array(2, 3, 4, 6, 7);
					buy_sell_auto_match_wa_machinery_options($match, $match_keys);
					break;

			       case 'retailers': 
					$match_keys = array(2, 3, 4, 6);
					buy_sell_auto_match_wa_machinery_options($match, $match_keys);
					break;

			       case 'agents': 

					//pending all
					break;

			       case 'chain stores': 
					$match_keys = array(2, 3, 4, 6);
					buy_sell_auto_match_wa_machinery_options($match, $match_keys);
					break;

		               case 'distributors':
					$match_keys = array(2, 5, 6, 7);
					buy_sell_auto_match_wa_machinery_options($match, $match_keys);
					break;

		               case 'students':
					$match_keys = array(9);
					buy_sell_auto_match_wa_machinery_options($match, $match_keys);
					break;

		               case 'foreign representatives':
					$match_keys = array(10);
					buy_sell_auto_match_wa_machinery_options($match, $match_keys);
					break;
			}
			break;

		case 'wa_other':
			switch($subcategory) {
			       case 'ancillary suppliers': 
					$match_keys = array(3);
					buy_sell_auto_match_wa_jewellery_options($match, $match_keys);
					$match_keys = array(1);
					buy_sell_auto_match_wa_other_options($match, $match_keys);
					break;

			       case 'publications': 
					$match_keys = array(2);
					buy_sell_auto_match_wa_other_options($match, $match_keys);
					break;
			            
			       case 'service providers': 
					$match_keys = array(3);
					buy_sell_auto_match_wa_other_options($match, $match_keys);
					break;

			       case 'raw material suppliers': 
					$match_keys = array(3);
					buy_sell_auto_match_wa_jewellery_options($match, $match_keys);
					break;

			       case 'associations': 
					$match_keys = array(5);
					buy_sell_auto_match_wa_other_options($match, $match_keys);
					break;
			}
			break;

		case 'pd_jewellery':
			switch($subcategory) {
			       case 'plain gold jewellery': 
					$match_keys = array(1);
					buy_sell_auto_match_pd_jewellery_options($match, $match_keys);
					break;

			       case 'studded gold jewellery': 
					$match_keys = array(2);
					buy_sell_auto_match_pd_jewellery_options($match, $match_keys);
					break;

			       case 'loose diamonds': 
					$match_keys = array(3);
					buy_sell_auto_match_pd_jewellery_options($match, $match_keys);
					break;

			       case 'coloured gemstones': 
					$match_keys = array(4);
					buy_sell_auto_match_pd_jewellery_options($match, $match_keys);
					break;

			       case 'pearls': 
					$match_keys = array(5);
					buy_sell_auto_match_pd_jewellery_options($match, $match_keys);
					break;

			       case 'costume jewellery': 
					$match_keys = array(6);
					buy_sell_auto_match_pd_jewellery_options($match, $match_keys);
					break;

			       case 'platinum jewellery': 
					$match_keys = array(7);
					buy_sell_auto_match_pd_jewellery_options($match, $match_keys);
					break;

			       case 'silver jewellery': 
					$match_keys = array(8);
					buy_sell_auto_match_pd_jewellery_options($match, $match_keys);
					break;

			       case 'software products': 
					$match_keys = array(9);
					buy_sell_auto_match_pd_jewellery_options($match, $match_keys);
					break;

			       case 'publications': 
					$match_keys = array(10);
					buy_sell_auto_match_pd_jewellery_options($match, $match_keys);
					break;

			       case 'educational institutions': 
					$match_keys = array(11);
					buy_sell_auto_match_pd_jewellery_options($match, $match_keys);
					break;

			       case 'associations': 
					$match_keys = array(12);
					buy_sell_auto_match_pd_jewellery_options($match, $match_keys);
					break;

			       case 'service providers': 
					$match_keys = array(13);
					buy_sell_auto_match_pd_jewellery_options($match, $match_keys);
					break;
			}
			break;

		case 'pd_machinery':
			switch($subcategory) {
			       case 'jewellery making machinery': 
					$match_keys = array(1);
					buy_sell_auto_match_pd_machinery_options($match, $match_keys);
					break;

			       case 'equipments/tools': 
					$match_keys = array(2);
					buy_sell_auto_match_pd_machinery_options($match, $match_keys);
					break;
			            
			       case 'ancillary products': 
					$match_keys = array(3);
					buy_sell_auto_match_pd_machinery_options($match, $match_keys);
					break;

			       case 'software company': 
					$match_keys = array(4);
					buy_sell_auto_match_pd_machinery_options($match, $match_keys);
					break;

			       case 'publications': 
					$match_keys = array(5);
					buy_sell_auto_match_pd_machinery_options($match, $match_keys);
					break;

			       case 'educational insitutions': 
					$match_keys = array(6);
					buy_sell_auto_match_pd_machinery_options($match, $match_keys);
					break;

			       case 'associations': 
					$match_keys = array(7);
					buy_sell_auto_match_pd_machinery_options($match, $match_keys);
					break;
			}
			break;

		case 'objective':
			switch($subcategory) {
			       case 'buying': 
					$match_keys = array(2, 3, 5, 7);
					buy_sell_auto_match_wa_jewellery_options($match, $match_keys);
					break;

			       case 'source suppliers': 
					$match_keys = array(2, 3, 5, 7);
					buy_sell_auto_match_wa_jewellery_options($match, $match_keys);
					break;
			            
			       case 'joint ventures': 
					break;

			       case 'importing': 

					break;

			       case 'appointing agents': 
					$match_keys = array(7);
					buy_sell_auto_match_wa_jewellery_options($match, $match_keys);
					$match_keys = array(6);
					buy_sell_auto_match_wa_machinery_options($match, $match_keys);
					break;

			       case 'evaluate for future participation': 
					break;

			       case 'market information': 
					break;

			       case 'seek representatives': 
					break;

			       case 'source technology': 
					$match_keys = array(3);
					buy_sell_auto_match_wa_machinery_options($match, $match_keys);
					break;

			       case 'place orders': 
					break;
			}
			break;
	}

}

function buy_sell_auto_match_wa_jewellery_options(&$match, $match_keys) {
	$options = array();
	$options[1] = 'importers';
	$options[2] = 'exporters';
	$options[3] = 'manufacturers';
	$options[4] = 'goldsmiths';
	$options[5] = 'wholesalers';
	$options[6] = 'retailers';
	$options[7] = 'agents';
	$options[8] = 'chain stores';
	$options[9] = 'designers';
	$options[10] = 'artists/craftsmen';

	foreach($match_keys as $key) {
		$match['wa_jewellery'][$options[$key]] = $options[$key];
	}
}

function buy_sell_auto_match_wa_machinery_options(&$match, $match_keys) {
	$options = array();
	$options[1] = 'importers';
	$options[2] = 'exporters';
	$options[3] = 'manufacturers';
	$options[4] = 'wholesalers';
	$options[5] = 'retailers';
	$options[6] = 'agents';
	$options[7] = 'chain stores';
	$options[8] = 'distributors';
	$options[9] = 'students';
	$options[10] = 'foreign representatives';

	foreach($match_keys as $key) {
		$match['wa_machinery'][$options[$key]] = $options[$key];
	}
}

function buy_sell_auto_match_wa_other_options(&$match, $match_keys) {
	$options = array();
	$options[1] = 'ancillary suppliers';
	$options[2] = 'publications';
	$options[3] = 'service providers';
	$options[4] = 'raw material suppliers';
	$options[5] = 'associations';

	foreach($match_keys as $key) {
		$match['wa_other'][$options[$key]] = $options[$key];
	}
}

function buy_sell_auto_match_pd_jewellery_options(&$match, $match_keys) {
	$options = array();
	$options[1] = 'plain gold jewellery';
	$options[2] = 'studded gold jewellery';
	$options[3] = 'loose diamonds';
	$options[4] = 'coloured gemstones';
	$options[5] = 'pearls';
	$options[6] = 'costume jewellery';
	$options[7] = 'platinum jewellery';
	$options[8] = 'silver jewellery';
	$options[9] = 'software products';
	$options[10] = 'publications';
	$options[11] = 'educational institutions';
	$options[12] = 'associations';
	$options[13] = 'service providers';

	foreach($match_keys as $key) {
		$match['pd_jewellery'][$options[$key]] = $options[$key];
	}
}

function buy_sell_auto_match_pd_machinery_options(&$match, $match_keys) {
	$options = array();
	$options[1] = 'jewellery making machinery';
	$options[2] = 'equipments/tools';
	$options[3] = 'ancillary products';
	$options[4] = 'software company';
	$options[5] = 'publications';
	$options[6] = 'educational insitutions';
	$options[7] = 'associations';

	foreach($match_keys as $key) {
		$match['pd_machinery'][$options[$key]] = $options[$key];
	}
}

function auto_match_objective_options(&$match, $match_keys) {
	$options = array();
	$options[1] = 'buying';
	$options[2] = 'source suppliers';
	$options[3] = 'joint ventures';
	$options[4] = 'importing';
	$options[5] = 'appointing agents';
	$options[6] = 'evaluate for future participation';
	$options[7] = 'market information';
	$options[8] = 'seek representatives';
	$options[9] = 'source technology';
	$options[10] = 'place orders';

	foreach($match_keys as $key) {
		$match['objective'][$options[$key]] = $options[$key];
	}
}

/*
 * Function to check whether the string is in serialized or not.
 */
function buy_sell_auto_match_is_serialized($value, &$result = null)
{
// Bit of a give away this one
if (!is_string($value))
{
return false;
}

// Serialized false, return true. unserialize() returns false on an
// invalid string or it could return false if the string is serialized
// false, eliminate that possibility.
if ($value === 'b:0;')
{
$result = false;
return true;
}

$length = strlen($value);
$end = '';

switch ($value[0])
{
case 's':
if ($value[$length - 2] !== '"')
{
return false;
}
case 'b':
case 'i':
case 'd':
// This looks odd but it is quicker than isset()ing
$end .= ';';
case 'a':
case 'O':
$end .= '}';

if ($value[1] !== ':')
{
return false;
}

switch ($value[2])
{
case 0:
case 1:
case 2:
case 3:
case 4:
case 5:
case 6:
case 7:
case 8:
case 9:
break;

default:
return false;
}
case 'N':
$end .= ';';

if ($value[$length - 1] !== $end[0])
{
return false;
}
break;

default:
return false;
}

if (($result = @unserialize($value)) === false)
{
$result = null;
return false;
}
return true;
}