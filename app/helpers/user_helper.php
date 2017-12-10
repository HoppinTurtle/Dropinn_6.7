<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

function get_all_Users()
{
$CI     =& get_instance();

$query  = $CI->db->order_by("id","asc")->get('users');

return $query;
}
function get_user_by_id($id)
{
$CI     =& get_instance();

$query  = $CI->db->get_where('users', array('id' => $id));

return $query->row();
}

function get_user_by_rollid($id)
{
$CI     =& get_instance();

$query  = $CI->db->get_where('users', array('role_id' => $id));

return $query->row();
}


function get_user_timezone()
{
$CI     =& get_instance();

$id     = $CI->dx_auth->get_user_id();

$query  = $CI->db->get_where('users', array('id' => $id));

$timezone = $query->row()->timezone;

if($timezone == '')
$timezone = 'UTC';

return $timezone;
}

function get_user_timezoneL($id)
{
$CI     =& get_instance();

$query  = $CI->db->get_where('users', array('id' => $id));

$timezone = $query->row()->timezone;

if($timezone == '')
$timezone = 'UTC';

return $timezone;
}


function get_list_by_id($id)
{
$CI     =& get_instance();

$query  = $CI->db->get_where('list', array('id' => $id));

return $query->row();
}


function get_profile_by_id($id)
{
$CI     =& get_instance();

$query  = $CI->db->get_where('profiles', array('id' => $id));

return $query->row();
}

function getreviewoflist($userid='',$listid='')
{
 $CI     =& get_instance();
	$CI->load->model('Trips_model');
	$conditions    	= array('list_id' => $listid, 'userto' => $userid);
	$CI 	=& get_instance();

	$result = $CI->Trips_model->get_review($conditions);

	$conditions  = array('list_id' => $listid, 'userto' => $userid);
	$stars		 = $CI->Trips_model->get_review_sum($conditions)->row();


	$overall=0;
	if($result->num_rows() > 0) { 
							$accuracy      = (($stars->accuracy *2) * 10) / $result->num_rows();
							$cleanliness   = (($stars->cleanliness *2) * 10) / $result->num_rows();
							$communication = (($stars->communication *2) * 10) / $result->num_rows();
							$checkin       = (($stars->checkin *2) * 10) / $result->num_rows();
							$location      = (($stars->location *2) * 10) / $result->num_rows();
							$value         = (($stars->value *2) * 10) / $result->num_rows();
													
						$overall       = ($accuracy + $cleanliness + $communication + $checkin + $location + $value) / 6;

$overall=round($overall,2);
}
return $overall;
}

function getDaysInBetween($startdate, $enddate)
{
$period = (strtotime($enddate) - strtotime($startdate))/(60*60*24);

$dateinfo = get_gmt_time(strtotime($startdate));

	do {
	$days[]       = $dateinfo;
 $dateinfo     = date ( 'm/d/Y' ,$dateinfo);
	$pre_dateinfo = date ( 'm/d/Y' , strtotime ( '+1 day' , strtotime ( $dateinfo ) ) );
	$dateinfo     = get_gmt_time(strtotime($pre_dateinfo));
	$period-- ;
	} while ($period >= 0);
	return $days; 
}


function getDaysInBetweenC($startdate, $enddate)
{
$period = (strtotime($enddate) - strtotime($startdate))/(60*60*24);

$dateinfo = $startdate;

	do {
	$days[] = $dateinfo;

	$dateinfo = date ( 'm/d/Y' , strtotime ( '+1 day' , strtotime ( $dateinfo ) ) );
	$period-- ;
	} while ($period >= 0);

	return $days; 
}


/* Without CDN
function getListImage($list_id)
{
$CI           =& get_instance();
$condition    = array("is_featured" => 1);
$list_image   = $CI->Gallery->get_imagesG($list_id, $condition)->row();

if(isset($list_image->name))
{
	$name=$list_image->name;
	$pieces = explode(".", $name);
	$url = base_url().'images/'.$list_id.'/'.$pieces[0].'_crop.jpg';
}
else
{
$url = base_url().'images/no_image.jpg';
}

return $url;
}*/


// WIth CDN
function getListImage($list_id)
{
$CI           =& get_instance();
$condition    = array("is_featured" => 1);
$list_image   = $CI->Gallery->get_imagesG($list_id, $condition)->row();

if(isset($list_image->name))
{
	$name=$list_image->name;
	$pieces = explode(".", $name);
	$url = cdn_url_images().'w_350,h_200/w_350/images/'.$list_id.'/'.$pieces[0].'.jpg';
}
else
{
$url = cdn_url_images().'images/no_image.jpg';
}

return $url;
}



function get_userPayout($user_id = '')
{

$CI     =& get_instance();

$query  = $CI->Common_model->getTableData('payout_preferences', array('user_id' => $user_id, "is_default" => 1));

return $query->row();
}

function autologin()
	{
		$CI     =& get_instance();
		$result = FALSE;
		
		if ($auto = $CI->input->cookie($CI->config->item('DX_autologin_cookie_name')))
		{
			// Extract data
			$auto = unserialize($auto);
			
			if (isset($auto['key_id']) AND $auto['key_id'] AND $auto['user_id'])
			{
				// Load Models				
				$CI->load->model('dx_auth/user_autologin', 'user_autologin');

				// Get key
				$query = $CI->user_autologin->get_key($auto['key_id'], $auto['user_id']);
				$CI->load->model('common_model');
				
				$CI->Common_model->updateTableData('user_autologin',0,array('key_id'=>md5($auto['key_id'])),array('session_id'=>$CI->session->userdata('session_id')));								

				if ($result = $query->row())
				{
					error_reporting(E_ERROR | E_WARNING | E_PARSE);
					// User verified, log them in
					$CI->dx_auth->_set_session($result);
					// Renew users cookie to prevent it from expiring
					$CI->dx_auth->_auto_cookie($auto);
					
					// Set last ip and last login
					$CI->dx_auth->_set_last_ip_and_last_login($auto['user_id']);
					
					$result = TRUE;
				}
			}
		}
		
		return $result;
	}


function get_invoice_pdf($param = ''){
	
	$CI     =& get_instance();
	$result = FALSE;
	
	//////////////////////////////////////////////////////// PDF WHILE ACCEPT Starts///////////////////////////////////////////////////////////////////////////
			
			$reservation_id = $param;
			
			$conditions    				= array('reservation.id' => $reservation_id);
			$row           				= $CI->Trips_model->get_reservation($conditions)->row();
			
			$query1 = get_user_by_id($row->userby);
			$traveler_name 				= $query1->username;
			
			$query2 = get_user_by_id($row->userto);
			$host_name 	= $query2->username;

			$list_query1 = $CI -> Common_model -> getTableData('list', array('id' => $row->list_id));
			$row_list = $list_query1 -> row();
			
			$paym_query1 = $CI -> Common_model -> getTableData('payments', array('id' => $row->payment_id));
			$row_paym = $paym_query1 -> row();

			$site_title = $CI -> dx_auth -> get_site_title();

			$Host = $host_name;
			$guest = $traveler = $traveler_name;
			$list_title        = $CI->Common_model->getTableData('list', array('id' => $row->list_id))->row()->title;
			
			foreach ($list_query1->result() as $result_add) {
					
				$address1 = $result_add -> address;
				$roomtype = $result_add -> room_type;
				
			}
			
			$address1 = $row_list -> address;
			$roomtype = $row_list -> room_type;
			$city = $row_list -> city;
			$state = $row_list -> state;
			$book_date = date("F j, Y", $row->book_date);
			$book_time = date('g:i A', time());
			$checkin = date("F j, Y", $row->checkin);
			$checkout = date("F j, Y", $row->checkout);
			$now = $row->checkin;
			$your_date = $row->checkout;
			$datediff = $your_date - $now;
			$daybetween = floor($datediff / (60 * 60 * 24));
			$guest_count = $row->no_quest;
			$per_night_amount = $row->per_night_price;
			
			$base_price = $row->base_price." [ ".$currency.$per_night_amount ." x ".$daybetween." nights ]";			
			$seasonal_dates_price = $row->seasonal_dates_price;
			
			$topay_amount = $row->topay;
			$total_amount = $row->price;
			$commision = $row->admin_commission;
			$extra_guest_price = $row->extra_guest_price;
			$cleaning = $row->cleaning;
			$security = $row->security;
			$currency = $row->currency;
			$list_via = $row_paym->payment_name;
			
			$order = $reservation_id;
			
			$invoice_date = date("F j, Y");
				
			$logo         = $CI->db->get_where('settings',array('code' => 'SITE_LOGO'))->row()->string_value;
			$header_logo = cdn_url_logo().'logo/'.$logo;
				


ob_start(); 

ini_set('memory_limit','32M');

$message = <<<EOF

<style>
	table td.service, table td.desc {
    border-left: none;
    vertical-align: top;
}
tr {
    border-bottom: none;
}
td {
    width: 50%;
}
tbody {
    display: block;
    padding: 2px 0 !important;
}
tr:nth-child(1) {
    border-top:none;
}
.no-margin{
	margin: 0px;
	border: none;
}
.no-border{
	border: none!important;
}
thead td {
    font-size: 30px;
    padding-left: 0 !important;
    text-align: left !important;
}
.pd, .pd1 {
    text-align: left;
     
}
.payment-details {
    border: none;
}
.payment-details tr:nth-child(1) {
    border-top: none!important;
}
.pd td {
    padding: 18px 0;
}
.payment-details{
    padding: 0 !important;
    border-bottom: medium none;
   }
 td > div {
    display: inline-flex;
      width: 100%;
} 
.leftt {
    width: 30%;
} 
.rightt {
    width: 70%;
}
.table1 tr {
    display: block;
}
.pd3 {
    display: inline-flex!important;
    padding: 15px;
    width: 49% !important;
}
.rightt > p:nth-child(1) {
    font-size: 21px;
}
.rightt > p:nth-child(2) ,.pd1 {
      color: rgb(204, 204, 204);
    font-weight: bold;
}
.pd2 {
    text-align: left;
}

.clearfix:after {
  content: "";
  display: table;
  clear: both;
}

table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 20px;
}


table th {
  padding: 5px 20px;
  color: #5D6975;
  border-bottom: none;
  white-space: nowrap;        
  font-weight: normal;
}

table .service,
table .desc {
  text-align: left;
}

table td {
  padding: 15px;
}

table td.service,
table td.desc {
  vertical-align: top;
}

table td.unit,
table td.qty,
table td.total {
  font-size: 1.2em;
}

table td.sub {
  border-top: none;
}

table td.grand {
  border-top: none;
}
td,th {padding-top:10px;padding-bottom:10px; }

thead{
	padding-top:10px;padding-bottom:10px; 
}
</style>
      <table  class="table1" style="font-family: serif;border:none;">
      
        <tbody>
         <tr>
		  <td width="250"  class="service"><b style="font-size:15pt;">INVOICE</b><br />Order no: $order<br />Invoice Date: $invoice_date</td>
		 </tr>
          <tr>
            <td class="service"><div class=""><span class="leftt"></span><span class="rightt"><p>$Host</p><br /><p class="pd1" style="text-align:left; margin-top:12px !important;">Host Name</p></span></div></td>
            <td class="desc"><div class=""><span class="leftt"></span><span class="rightt"><p>$guest</p><br /><p class="pd1" style="text-align:left; margin-top:12px !important;">Guest Name</p></span></div></td>
          </tr>
          <tr>
            <td class="service"><div><span class="leftt"></span><span class="rightt"><p>$city</p><br /><p class="pd1" style="text-align:left; margin-top:12px !important;" >Travel Destination</p></span></div></td>
            <td class="desc"><div><span class="leftt"></span><span class="rightt"><p>$address1</p><br /><p class="pd1" style="text-align:left; margin-top:12px !important;" >Accomodation Address</p></span></div></td>
          </tr>
          <tr>
            <td class="service"><div><span class="leftt"></span><span class="rightt"><p>$list_title</p><br /><p class="pd1" style="text-align:left; margin-top:12px !important;" >Property Name</p></span></div></td>
            <td class="desc"><div><span class="leftt"></span><span class="rightt"><p>$roomtype</p><br /><p class="pd1" style="text-align:left; margin-top:12px !important;">Accomodation Type</p></span></div></td>
          </tr>
          <tr>
            <td class="service"><div><span class="leftt"></span><span class="rightt"><p>$checkin</p><br /><p class="pd1" style="text-align:left; margin-top:12px !important;">Check In</p></span></div></td>
            <td class="desc"><div><span class="leftt"></span><span class="rightt"><p>$checkout</p><br /><p class="pd1" style="text-align:left; margin-top:12px !important;">Check Out</p></span></div></td>
          </tr>
           <tr>
            <td class="service"><div><span class="leftt"></span><span class="rightt"><p>$guest_count</p><br /><p class="pd1" style="text-align:left; margin-top:12px !important;">Guests</p></span></div></td>
            <td class="desc"><div><span class="leftt"></span><span class="rightt"><p>$daybetween</p><br /><p class="pd1" style="text-align:left; margin-top:12px !important;">Total Nights</p></span></div></td>
          </tr>
       
    	
        	
        	<tr class="" style="text-align:left; font-size: 17pt;"> <td class="no-border" style="text-align:left; font-size: 17pt; margin-bottom:10px !important;"><b>Payment Details</b></td></tr>
        
          <tr>
            <td class="">Payment Method</td>
            <td class="">$list_via</td>
          </tr>
          <tr>
            <td class="">Per night Fee</td>
            <td class="">$currency  $per_night_amount</td>
          </tr>
          <tr>
            <td class="">Base Price</td>
            <td class="">$currency  $base_price</td>
          </tr>
          
          <tr>
            <td class="" >Additional Guest Fee</td>
            <td class="">$currency  $extra_guest_price</td>
          </tr>
          <tr>
            <td class="">Cleaning Fee</td>
            <td class="">$currency  $cleaning</td>
          </tr>
          <tr>
            <td class="">Security Fee</td>
            <td class="">$currency  $security</td>
          </tr>
                 <tr>
            <td class="" >Sub Total</td>
            <td class="">$currency  $topay_amount</td>
          </tr>
          <tr>
            <td class="">Service Fee</td>
            <td class="">$currency  $commision</td>
          </tr>
          <tr style="text-align:left; font-size: 13pt;">
            <td class=""><b style="font-size: 13pt;">Total Amount</b></td>
            <td class="pd2"><b style="font-size: 13pt;">$currency $total_amount</b></td>
          </tr>
          </tbody> 
        </table>
 
EOF;


//include("mpdf60/mpdf.php");
 
ob_end_clean(); 
 
$CI->load->helper('download'); 
 
$CI->load->library('pdf');

$pdf = $CI->pdf->load();

$pdf->SetHTMLHeader('<img height="45" width="137" src="' . $header_logo . '" style="float: right;"/>');

$pdf->WriteHTML($message);

$pdfFilePath = FCPATH."invoice/Invoice-".$reservation_id.".pdf"; 

$pdf->Output($pdfFilePath, 'F'); 

ob_end_flush();


//////////////////////////////////////////////////////// PDF WHILE ACCEPT Ends ///////////////////////////////////////////////////////////////////////////
			
	
}

?>