<?php
/**
 * DROPinn Payments Controller Class
 *
 * Helps to control payment functionality
 *
 * @package		Dropinn
 * @subpackage	Controllers
 * @category	Profiles
 * @author		Cogzidel Product Team
 * @version		Version 1.6
 * @link		http://www.cogzidel.com
 */

class Payments extends CI_Controller {

	private $stripe_secret;
	private $stripe_pub;

	function Payments() {
		parent::__construct();

		require_once APPPATH . 'libraries/braintree/lib/Braintree.php';

		$merchantId = $this -> db -> get_where('payment_details', array('code' => 'BT_MERCHANT')) -> row() -> value;
		$publicKey = $this -> db -> get_where('payment_details', array('code' => 'BT_PUBLICKEY')) -> row() -> value;
		$privateKey = $this -> db -> get_where('payment_details', array('code' => 'BT_PRIVATEKEY')) -> row() -> value;
		$paymode = $this -> Common_model -> getTableData('payments', array('payment_name' => 'CreditCard')) -> row() -> is_live;
		if ($paymode == 0) {
			$paymode = 'sandbox';
		} else {
			$paymode = 'production';
		}

		Braintree_Configuration::environment($paymode);
		Braintree_Configuration::merchantId($merchantId);
		Braintree_Configuration::publicKey($publicKey);
		Braintree_Configuration::privateKey($privateKey);

		require_once APPPATH . 'libraries/stripe/lib/Stripe.php';

		$SecretKey = $this -> db -> get_where('payment_details', array('code' => 'SecretKey')) -> row() -> value;

		$PublishableKey = $this -> db -> get_where('payment_details', array('code' => 'PublishableKey')) -> row() -> value;
		$LSecretKey = $this -> db -> get_where('payment_details', array('code' => 'LSecretKey')) -> row() -> value;
		$LPublishableKey = $this -> db -> get_where('payment_details', array('code' => 'LPublishableKey')) -> row() -> value;
		$paymode = $this -> Common_model -> getTableData('payments', array('payment_name' => 'Stripe')) -> row() -> is_live;

		if ($paymode == 0) {
			$this -> stripe_secret = $SecretKey;
			//print_r($this->stripe_secret);
			$this -> stripe_pub = $PublishableKey;
		} else {
			$this -> stripe_secret = $LSecretKey;
			$this -> stripe_pub = $LPublishableKey;
		}

		$this -> load -> helper('url');

		$this -> load -> library('Twoco_Lib');
		$this -> load -> library('email');
		$this -> load -> helper('form');
		$this -> load -> model('Users_model');
		$this -> load -> model('Referrals_model');
		$this -> load -> model('Email_model');
		$this -> load -> model('Message_model');
		$this -> load -> model('Contacts_model');

		$this -> load -> model('Trips_model');
		$trackingId = '4568246565';
		$this -> facebook_lib -> enable_debug(TRUE);

		$api_user = $this -> Common_model -> getTableData('payment_details', array('code' => 'CC_USER')) -> row() -> value;
		$api_pwd = $this -> Common_model -> getTableData('payment_details', array('code' => 'CC_PASSWORD')) -> row() -> value;
		$api_key = $this -> Common_model -> getTableData('payment_details', array('code' => 'CC_SIGNATURE')) -> row() -> value;

		$paymode = $this -> Common_model -> getTableData('payments', array('payment_name' => 'Paypal')) -> row() -> is_live;

		if ($paymode == 0) {
			$paymode = TRUE;
		} else {
			$paymode = FALSE;
		}
		$paypal_details = array(
		// you can get this from your Paypal account, or from your
		// test accounts in Sandbox
		'API_username' => $api_user, 'API_signature' => $api_key, 'API_password' => $api_pwd,
		// Paypal_ec defaults sandbox status to true
		// Change to false if you want to go live and
		// update the API credentials above
		'sandbox_status' => $paymode, );
		$this -> load -> library('paypal_ec', $paypal_details);

	}

	function index($param = '') {
		$this -> session -> set_userdata('cnumber_error', '');
		$this -> session -> set_userdata('cname_error', '');
		$this -> session -> set_userdata('ctype_error', '');
		$this -> session -> set_userdata('expire_error', '');

		if ($this -> input -> post('env')) {
			$this -> session -> set_userdata('call_back', 'mobile');
		}

		if ($param == '') {
			redirect('info/deny');
		}

		$result = $this -> Common_model -> getTableData('list', array('id' => $param, 'is_enable' => 1));
		if ($result -> num_rows() == 0) {
			$this -> session -> set_flashdata('flash_message', $this -> Common_model -> flash_message('error', translate("This List Hidden by Host.")));
			redirect('rooms/' . $param);
		}
		$check = $this -> db -> where('id', $param) -> where('user_id', $this -> dx_auth -> get_user_id()) -> get('list');
		if ($check -> num_rows() != 0) {
			$this -> session -> set_flashdata('flash_message', $this -> Common_model -> flash_message('error', translate("Host can't book their list.")));
			redirect('rooms/' . $param);
		}

		$result = $this -> db -> where('id', $param) -> get('lys_status') -> row();
		// check for instance book

		$instance_book = $this -> db -> where('id', $param) -> get('list') -> row() -> instance_book;
		$photo = $this -> Gallery -> profilepic($this -> dx_auth -> get_user_id(), 2);
		$fade = base_url() . 'images/no_avatar-xlarge.jpg';
		//exit;
		if ($instance_book == 1 && $photo == $fade) {

			$this -> session -> set_flashdata('flash_message', $this -> Common_model -> flash_message('error', translate("Please Upload your profile picture.")));
			redirect('rooms/' . $param);
		}

		//
		$total = $result -> calendar + $result -> price + $result -> overview + $result -> photo + $result -> address + $result -> listing;

		if ($total != 6) {
			redirect('info');
		}

		if ((!$this -> dx_auth -> is_logged_in()) && (!$this -> facebook_lib -> logged_in())) {
			if ($this -> input -> get()) {
				//contact me
				$contact = $this -> input -> get('contact');
				if ($this -> input -> get('contact'))
					$redirect_to = 'payments/index/' . $param . '?contact=' . $contact;
				else
					$redirect_to = 'payments/index/' . $param;

				$newdata = array('list_id' => $param, 'Lcheckin' => $this -> input -> get('checkin'), 'Lcheckout' => $this -> input -> get('checkout'), 'number_of_guests' => $this -> input -> get('guest'), 'redirect_to' => $redirect_to, 'formCheckout' => TRUE);
				$this -> session -> set_userdata($newdata);

				redirect('users/signin', 'refresh');
			} else {
				$contact = $this -> input -> get('contact');
				if ($this -> input -> get('contact'))
					$redirect_to = 'payments/index/' . $param . '?contact=' . $contact;
				else
					$redirect_to = 'payments/index/' . $param;

				$newdata = array('list_id' => $param, 'Lcheckin' => $this -> input -> post('checkin'), 'Lcheckout' => $this -> input -> post('checkout'), 'number_of_guests' => $this -> input -> post('number_of_guests'), 'redirect_to' => $redirect_to, 'formCheckout' => TRUE);
				$this -> session -> set_userdata($newdata);

				redirect('users/signin', 'refresh');
			}
		}

		/*Include Get option*/

		if ($this -> input -> post('checkin') || $this -> session -> userdata('Lcheckin') || $this -> input -> get('checkin')) {
			if ($this -> input -> post('SignUp') != NULL) {
				//echo 'got it';
				//$this->guest_signup();

				if ($this -> input -> post() || $this -> input -> get()) {
					$this -> form_validation -> set_rules('first_name', 'First Name', 'required|trim|xss_clean');
					$this -> form_validation -> set_rules('last_name', 'Last Name', 'required|trim|xss_clean');
					$this -> form_validation -> set_rules('username', 'Username', 'required|trim|xss_clean|callback__check_user_name');
					$this -> form_validation -> set_rules('email', 'Email', 'required|trim|valid_email|xss_clean|callback__check_user_email');
					$this -> form_validation -> set_rules('password', 'Password', 'required|trim|min_length[5]|max_length[16]|xss_clean|matches[confirmpassword]');
					$this -> form_validation -> set_rules('confirmpassword', 'Confirm Password', 'required|trim|min_length[5]|max_length[16]|xss_clean');

					if ($this -> form_validation -> run()) {
						//Get the post values
						$first_name = $this -> input -> post('first_name');
						$last_name = $this -> input -> post('last_name');
						$username = $this -> input -> post('username');
						$email = $this -> input -> post('email');
						$password = $this -> input -> post('password');
						$confirmpassword = $this -> input -> post('confirmpassword');
						$newsletter = $this -> input -> post('news_letter');

						$data = $this -> dx_auth -> register($username, $password, $email);

						$this -> dx_auth -> login($username, $password, 'TRUE');

						//To check user come by reference
						if ($this -> session -> userdata('ref_id'))
							$ref_id = $this -> session -> userdata('ref_id');
						else
							$ref_id = "";

						if (!empty($ref_id)) {
							$details = $this -> Referrals_model -> get_user_by_refId($ref_id);
							$invite_from = $details -> row() -> id;

							$insertData = array();
							$insertData['invite_from'] = $invite_from;
							$insertData['invite_to'] = $this -> dx_auth -> get_user_id();
							$insertData['join_date'] = local_to_gmt();

							$this -> Referrals_model -> insertReferrals($insertData);

							$this -> session -> unset_userdata('ref_id');
						}

						$notification = array();
						$notification['user_id'] = $this -> dx_auth -> get_user_id();
						$notification['new_review '] = 1;
						$notification['leave_review'] = 1;
						$this -> Common_model -> insertData('user_notification', $notification);

						//Need to add this data to user profile too
						$add['Fname'] = $first_name;
						$add['Lname'] = $last_name;
						$add['id'] = $this -> dx_auth -> get_user_id();
						$add['email'] = $email;
						$this -> Common_model -> insertData('profiles', $add);
						//End of adding it
						$this -> session -> set_flashdata('flash_message', $this -> Common_model -> flash_message('success', translate('Registered successfully.')));

					}
				}

			} else if ($this -> input -> post('SignIn') != NULL) {

				if ($this -> input -> post() || $this -> input -> get()) {
					if (!$this -> dx_auth -> is_logged_in()) {
						// Set form validation rules
						$this -> form_validation -> set_rules('username1', 'Username or Email', 'required|trim|xss_clean');
						$this -> form_validation -> set_rules('password1', 'password', 'required|trim|xss_clean');
						//	$this->form_validation->set_rules('remember', 'Remember me', 'integer');

						if ($this -> form_validation -> run()) {
							$username = $this -> input -> post("username1");
							$password = $this -> input -> post("password1");

							if ($this -> dx_auth -> login($username, $password, $this -> form_validation -> set_value('TRUE'))) {
								// Redirect to homepage
								$newdata = array('user' => $this -> dx_auth -> get_user_id(), 'username' => $this -> dx_auth -> get_username(), 'logged_in' => TRUE);
								$this -> session -> set_userdata($newdata);
								$this -> session -> set_flashdata('flash_message', $this -> Common_model -> flash_message('success', translate('Logged in successfully.')));
							}
						}

					}
				}
			}
			$this -> form($param);

		} else {
			redirect('rooms/' . $param, "refresh");
		}

		$refer = $this -> db -> query("select * from `referral_management` where `id`=1 ") -> row();
		//$data['fixed_status']=$refer->fixed_status;
		$refamt = $refer -> fixed_amt;
		$refcur = $refer -> currency;
		$type = $refer -> type;
		$trip_amt = $refer -> trip_amt;
		$trip_per = $refer -> trip_per;
		$rent_amt = $refer -> rent_amt;
		$rent_per = $refer -> rent_per;

	}

	function contact() {

		if ((!$this -> dx_auth -> is_logged_in()) && (!$this -> facebook_lib -> logged_in())) {
$checkoutdate = $this -> input -> post('checkout');
$checkindate = $this -> input -> post('checkin');
			$data['status'] = "error";
			//Store the values in session to redirect this page after login
			$newdata = array('Lid' => $this -> input -> post('id'), 'Lcheckin' => $this -> input -> post('checkin'), 'Lcheckout' => $this -> input -> post('checkout'), 'number_of_guests' => $this -> input -> post('guests'), 'Lmessage' => $this -> input -> post('message'), 'redirect_to' => 'rooms/' . $this -> input -> post('id'), 'formCheckout' => TRUE);
			$this -> session -> set_userdata($newdata);

		} else {
			$check = $this -> db -> where('id', $this -> input -> post('id')) -> where('user_id', $this -> dx_auth -> get_user_id()) -> get('list');

			if ($check -> num_rows() != 0) {
				$data['status'] = "your_list";
			} else {

				$status = 1;
				if ($this -> session -> userdata('formCheckout')) {
					$id = $this -> session -> userdata('Lid');
					$checkin = $this -> session -> userdata('Lcheckin');
					$checkout = $this -> session -> userdata('Lcheckout');
					$data['guests'] = $this -> session -> userdata('number_of_guests');
					$message = $this -> session -> userdata('Lmessage');
				} else {
					$id = $this -> input -> post('id');
					$checkin = $this -> input -> post('checkin');
					$checkout = $this -> input -> post('checkout');
					$data['guests'] = $this -> input -> post('guests');
					$message = $this -> input -> post('message');
				}

				//Check the rooms availability
				$checkin_time = $checkin;
				$checkin_time = get_gmt_time(strtotime($checkin_time));
				$checkout_time = $checkout;
				$checkout_time = get_gmt_time(strtotime($checkout_time));
				$sql = "select checkin,checkout from contacts where list_id='" . $id . "' and status!=1";
				$query = $this -> db -> query($sql);
				$res = $query -> result_array();
				if ($query -> num_rows() > 0) {
					foreach ($res as $time) {
						$start_date = $time['checkin'];
						$end_date = $time['checkout'];
						$start = get_gmt_time(strtotime($start_date));
						$end = get_gmt_time(strtotime($end_date));
						if (($checkin_time >= $start && $checkin_time <= $end) || ($checkout_time >= $start && $checkout_time <= $end)) {
							$status = 0;
						}
					}
				}
				$daysexist = $this -> db -> query("SELECT id,list_id,booked_days FROM `calendar` WHERE `list_id` = '" . $id . "' AND (`booked_days` >= '" . get_gmt_time(strtotime($checkin)) . "' AND `booked_days` <= '" . get_gmt_time(strtotime($checkout)) . "') GROUP BY `id`");
				//echo $data['status'] = $this->db->last_query();exit;
				$rowsexist = $daysexist -> num_rows();
				// echo $data['status'] = $daysexist->num_rows();exit;
				if ($rowsexist > 0) {
					$status = 0;
				} else {
					$status = 1;
				}

				$contacts_already = $this -> db -> query("SELECT id FROM `contacts` WHERE `list_id` = '" . $id . "' AND `userby` = '" . $this -> dx_auth -> get_user_id() . "' AND `status` != 10 AND ((`checkin` >= '" . $checkin . "' AND `checkin` <= '" . $checkout . "') OR (`status` != 10 AND `checkout` >= '" . $checkin . "' AND `checkout` <= '" . $checkout . "'))");

				$conditions = array("id" => $id, "list.status" => 1);

				$result = $this -> Common_model -> getTableData('list', $conditions);
				$conditions1 = array("id" => $id);

				$lys_status = $this -> Common_model -> getTableData('lys_status', $conditions1) -> row();

				$capacity1 = $this -> db -> where('id', $id) -> get('list') -> row() -> capacity;

				$capacity = $capacity1 + 1;

				$total_status = $lys_status -> calendar + $lys_status -> price + $lys_status -> overview + $lys_status -> address + $lys_status -> photo + $lys_status -> listing;

				if ($result -> row() -> is_enable != 1 || $result -> row() -> list_pay != 1 || $total_status != 6) {
					$data['status'] = 'redirect';
				} else if ($status == 0) {
					$data['status'] = "not_available";
				} else if ($capacity1 == 0) {
					$data['status'] = "not_available";
				} else if ($data['guests'] > $capacity) {
					$data['status'] = "not_available";
				} else if ($contacts_already -> num_rows() != 0) {
					$data['status'] = "already";
				} else {
					$data['status'] = "success";
					$list['list_id'] = $id;
					$list['checkin'] = $checkin;
					$list['checkout'] = $checkout;
					$list['no_quest'] = $data['guests'];
					$list['currency'] = get_currency_code();

					//calculate price for the checkin and checkout dates
					$ckin = explode('/', $checkin);
					$ckout = explode('/', $checkout);

					$xprice = $this -> Common_model -> getTableData('price', array('id' => $id)) -> row();
					//print_r($xprice);exit;
					$guests = $xprice -> guests;
					$per_night = $xprice -> night;

					if (isset($xprice -> cleaning))
						$cleaning = $xprice -> cleaning;
					else
						$cleaning = 0;

					if (isset($xprice -> security))
						$security = $xprice -> security;
					else
						$security = 0;

					if (isset($xprice -> night))
						$price = $xprice -> night;
					else
						$price = 0;

					if (isset($xprice -> week))
						$Wprice = $xprice -> week;
					else
						$Wprice = 0;

					if (isset($xprice -> month))
						$Mprice = $xprice -> month;
					else
						$Mprice = 0;

					//check admin premium condition and apply so for
					$query = $this -> Common_model -> getTableData('paymode', array('id' => 2));
					$row = $query -> row();

					//Seasonal Price
					//1. Store all the dates between checkin and checkout in an array
					$checkin_time = get_gmt_time(strtotime($checkin));
					$checkout_time = get_gmt_time(strtotime($checkout));
					$travel_dates = array();
					$seasonal_prices = array();
					$total_nights = 1;
					$total_price = 0;
					$is_seasonal = 0;
					$i = $checkin_time;
					while ($i < $checkout_time) {
						$checkin_date = date('m/d/Y', $i);
						$checkin_date = explode('/', $checkin_date);
						$travel_dates[$total_nights] = $checkin_date[1] . $checkin_date[0] . $checkin_date[2];
						$i = get_gmt_time(strtotime('+1 day', $i));
						$total_nights++;
					}
					for ($i = 1; $i < $total_nights; $i++) {
						$seasonal_prices[$travel_dates[$i]] = "";
					}
					//Store seasonal price of a list in an array
					$seasonal_query = $this -> Common_model -> getTableData('seasonalprice', array('list_id' => $id));
					$seasonal_result = $seasonal_query -> result_array();
					if ($seasonal_query -> num_rows() > 0) {
						foreach ($seasonal_result as $time) {

							//Get Seasonal price
							$seasonalprice_query = $this -> Common_model -> getTableData('seasonalprice', array('list_id' => $id, 'start_date' => $time['start_date'], 'end_date' => $time['end_date']));
							$seasonalprice = $seasonalprice_query -> row() -> price;
							//Days between start date and end date -> seasonal price
							$start_time = $time['start_date'];
							$end_time = $time['end_date'];
							$i = $start_time;
							while ($i <= $end_time) {
								$start_date = date('m/d/Y', $i);
								$s_date = explode('/', $start_date);
								$s_date = $s_date[1] . $s_date[0] . $s_date[2];
								$seasonal_prices[$s_date] = $seasonalprice;
								$i = get_gmt_time(strtotime('+1 day', $i));
							}

						}
						//Total Price
						for ($i = 1; $i < $total_nights; $i++) {
							if ($seasonal_prices[$travel_dates[$i]] == "") {
								$total_price = $total_price + $xprice -> night;
							} else {
								$total_price = $total_price + $seasonal_prices[$travel_dates[$i]];
								$is_seasonal = 1;
							}
						}
						//Additional Guests
						if ($data['guests'] > $guests) {
							$days = $total_nights - 1;
							$diff_guests = $data['guests'] - $guests;
							$total_price = $total_price + ($days * $xprice -> addguests * $diff_guests);
						}

						//Cleaning
						if ($cleaning != 0) {
							$total_price = $total_price + $cleaning;
						}

						if ($security != 0) {
							$total_price = $total_price + $security;
						}

						//Admin Commission
						$data['commission'] = 0;
						if ($row -> is_premium == 1) {
							if ($row -> is_fixed == 1) {
								$fix = $row -> fixed_amount;
								$amt = $total_price + get_currency_value_lys($row -> currency, get_currency_code(), $fix);
								$data['commission'] = get_currency_value_lys($row -> currency, get_currency_code(), $fix);
							} else {
								$per = $row -> percentage_amount;
								$camt = floatval(($total_price * $per) / 100);
								$amt = $total_price + $camt;
								$data['commission'] = round($camt, 2);
							}
						}

					}
					if ($is_seasonal == 1) {
						//Total days
						$days = $total_nights;
						//Final price
						$data['price'] = $total_price;
					} else {
						if (($ckin[0] == "mm" && $ckout[0] == "mm") or ($ckin[0] == "" && $ckout[0] == "")) {
							$days = 0;

							$data['price'] = $price;

							if ($Wprice == 0) {
								$data['Wprice'] = $price * 7;
							} else {
								$data['Wprice'] = $Wprice;
							}
							if ($Mprice == 0) {
								$data['Mprice'] = $price * 30;
							} else {
								$data['Mprice'] = $Mprice;
							}

							$data['commission'] = 0;

							if ($row -> is_premium == 1) {
								if ($row -> is_fixed == 1) {
									$fix = $row -> fixed_amount;
									$amt = $price + get_currency_value_lys($row -> currency, get_currency_code(), $fix);
									$data['commission'] = get_currency_value_lys($row -> currency, get_currency_code(), $fix);
									$Fprice = $amt;
								} else {
									$per = $row -> percentage_amount;
									$camt = floatval(($price * $per) / 100);
									$amt = $price + $camt;
									$data['commission'] = round($camt, 2);
									$Fprice = $amt;
								}

								if ($Wprice == 0) {
									$data['Wprice'] = $price * 7;
								} else {
									$data['Wprice'] = $Wprice;
								}
								if ($Mprice == 0) {
									$data['Mprice'] = $price * 30;
								} else {
									$data['Mprice'] = $Mprice;
								}

							}
						} else {
							$diff = strtotime($ckout[2] . '-' . $ckout[0] . '-' . $ckout[1]) - strtotime($ckin[2] . '-' . $ckin[0] . '-' . $ckin[1]);
							$days = ceil($diff / (3600 * 24));

							$price = $price * $days;

							//Additional guests
							if ($data['guests'] > $guests) {
								$diff_days = $data['guests'] - $guests;
								$price = $price + ($days * $xprice -> addguests * $diff_days);
							}

							if ($Wprice == 0) {
								$data['Wprice'] = $price * 7;
							} else {
								$data['Wprice'] = $Wprice;
							}
							if ($Mprice == 0) {
								$data['Mprice'] = $price * 30;
							} else {
								$data['Mprice'] = $Mprice;
							}
							$data['commission'] = 0;

							if ($days >= 7 && $days < 30) {
								if (!empty($Wprice)) {
									$finalAmount = $Wprice;
									$differNights = $days - 7;
									$perDay = $Wprice / 7;
									$per_night = round($perDay, 2);
									if ($differNights > 0) {
										$addAmount = $differNights * $per_night;
										$finalAmount = $Wprice + $addAmount;
									}
									$price = $finalAmount;
									//Additional guests
									if ($data['guests'] > $guests) {
										$diff_days = $data['guests'] - $guests;
										$price = $price + ($days * $xprice -> addguests * $diff_days);
									}
								}
							}

							if ($days >= 30) {
								if (!empty($Mprice)) {
									$finalAmount = $Mprice;
									$differNights = $days - 30;
									$perDay = $Mprice / 30;
									$per_night = round($perDay, 2);
									if ($differNights > 0) {
										$addAmount = $differNights * $per_night;
										$finalAmount = $Mprice + $addAmount;
									}
									$price = $finalAmount;
									//Additional guests
									if ($data['guests'] > $guests) {
										$diff_days = $data['guests'] - $guests;
										$price = $price + ($days * $xprice -> addguests * $diff_days);
									}
								}
							}

							if ($row -> is_premium == 1) {
								if ($row -> is_fixed == 1) {
									$fix = $row -> fixed_amount;
									$amt = $price + get_currency_value_lys($row -> currency, get_currency_code(), $fix);
									$data['commission'] = get_currency_value_lys($row -> currency, get_currency_code(), $fix);
									// print_r($data['commission']);
									$Fprice = $amt;
								} else {
									$per = $row -> percentage_amount;
									$camt = floatval(($price * $per) / 100);
									$amt = $price + $camt;
									$data['commission'] = round($camt, 2);
									$Fprice = $amt;
								}

								if ($Wprice == 0) {
									$data['Wprice'] = $price * 7;
								} else {
									$data['Wprice'] = $Wprice;
								}
								if ($Mprice == 0) {
									$data['Mprice'] = $price * 30;
								} else {
									$data['Mprice'] = $Mprice;
								}

							}

							$xprice = $this -> Common_model -> getTableData('list', array('id' => $id)) -> row();

							if ($cleaning != 0) {
								$price = $price + $cleaning;
							}

							if ($security != 0) {
								$price = $price + $security;
							}

							$data['price'] = $price;
						}
					}

					$data['price'] = get_currency_value1($id, $data['price']);

					$data['commission'] = get_currency_value1($id, $data['commission']);

					$list['price'] = $data['price'];

					$list['admin_commission'] = $data['commission'];
					$list['send_date'] = local_to_gmt();
					$list['status'] = 1;
					$query_list = $this -> Common_model -> getTableData('list', array('id' => $id)) -> row();
					$list['userto'] = $query_list -> user_id;
					$list['userby'] = $this -> dx_auth -> get_user_id();
					$key = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz0123456789', 5)), 0, 9);
					$list['contact_key'] = $key;
					$query_user = $this -> Common_model -> getTableData('users', array('id' => $list['userby'])) -> row();
					$username = $query_user -> username;
					$this -> Common_model -> insertData('contacts', $list);
					$contact_id = $this -> db -> insert_id();
					$query_name = $this -> Users_model -> get_user_by_id($list['userby']) -> row();
					$buyer_name = $query_name -> username;
					$link = base_url() . 'contacts/request/' . $contact_id;

					//Send Message Notification
					$insertData = array('list_id' => $list['list_id'], 'contact_id' => $contact_id, 'userby' => $list['userby'], 'userto' => $list['userto'], 'message' => '<b>You have a new contact request from ' . ucfirst($username) . '</b><br><br>' . $message, 'created' => local_to_gmt(), 'message_type' => 7);

					$this -> Message_model -> sentMessage($insertData, ucfirst($buyer_name), ucfirst($username), $query_list -> title, $contact_id);

					
					$checkoutdate = $this -> input -> post('checkout');
					$checkindate = $this -> input -> post('checkin');
					
					
					$checkoutdate = get_user_times(strtotime($checkoutdate), get_user_timezone());
					$checkindate = get_user_times(strtotime($checkindate), get_user_timezone());
					$user_result = $this -> Common_model -> getTableData('profiles', array('id' => $this -> dx_auth -> get_user_id())) -> row();
					$no_user = $user_result -> phnum;
					$msg_content = 'You have a new contact request from ' . ucfirst($buyer_name) . " for " . $list_title . " ( " . $checkindate . " - " . $checkoutdate . " )" . " with special offer. ";
					send_sms_user($no_user, $msg_content);
					////////////////////// send sms to host /////////

					
					////////////////////// send sms to guest /////////
					$query_name_host = $this -> Users_model -> get_user_by_id($list['userto']) -> row();
					$user_result_by = $this -> Common_model -> getTableData('profiles', array('id' => $traveller_id)) -> row();
					$no_user_by = $user_result_by -> phnum;
					$msg_content1 = 'Your new contact Request by ' . ucfirst($username) . " for " . $list_title . " ( " . $checkindate . " - " . $checkoutdate . " )" . " with special offer. ";
					send_sms_user($no_user_by, $msg_content1);
					////////////////////// send sms to guest /////////

					//Request sent
					$insertData = array('list_id' => $list['list_id'], 'contact_id' => $contact_id, 'userby' => $list['userto'], 'userto' => $list['userby'], 'message' => '<b>Contact Request sent </b><br><br>' . $message, 'created' => local_to_gmt(), 'message_type' => 8);
					$this -> Message_model -> sentMessage($insertData, ucfirst($buyer_name), ucfirst($username), $query_list -> title, $contact_id);
					
					$checkindate = get_user_times(strtotime($checkindate), get_user_timezone());
					$checkoutdate = get_user_times(strtotime($checkoutdate), get_user_timezone());
					$user_result = $this -> Common_model -> getTableData('profiles', array('id' => $this -> dx_auth -> get_user_id())) -> row();
					$no_user = $user_result -> phnum;
					$msg_content = 'You have contact request from ' . ucfirst($buyer_name) . " for " . $list_title . " ( " . $checkindate . " - " . $checkoutdate . " )" . " with special offer. ";
					send_sms_user($no_user, $msg_content);
					////////////////////// send sms to host /////////

					////////////////////// send sms to guest /////////
					$query_name_host = $this -> Users_model -> get_user_by_id($list['userto']) -> row();
					$user_result_by = $this -> Common_model -> getTableData('profiles', array('id' => $traveller_id)) -> row();
					$no_user_by = $user_result_by -> phnum;
					$msg_content1 = 'Your contact Request by ' . ucfirst($username) . " for " . $list_title . " ( " . $checkindate . " - " . $checkoutdate . " )" . " with special offer. ";
					send_sms_user($no_user_by, $msg_content1);
					////////////////////// send sms to guest /////////

					//Send mail to host
					$query = $this -> Common_model -> getTableData('list', array('id' => $id)) -> row();
					$host_id = $query -> user_id;
					$list_email = $this -> Common_model -> getTableData('users', array('id' => $host_id)) -> row() -> email;
					$host_username = $this -> Common_model -> getTableData('users', array('id' => $host_id)) -> row() -> username;
					$query2 = $this -> Common_model -> getTableData('users', array('id' => $this -> dx_auth -> get_user_id())) -> row();
					$user_email = $query2 -> email;
					$admin_name = $this -> dx_auth -> get_site_title();
					$admin_email = $this -> dx_auth -> get_site_sadmin();
					$session_lang = $this->session->userdata('locale');
					if($session_lang == "") {
					$email_name = 'contact_request_to_host';}
					else { $email_name = 'contact_request_to_host_'.$session_lang;}
					
					$splVars = array("{link}" => $link, "{checkin}" => $checkin, "{checkout}" => $checkout, "{guest}" => $data['guests'], "{message}" => $message, "{site_name}" => $this -> dx_auth -> get_site_title(), "{host_username}" => ucfirst($host_username), "{title}" => $query -> title);
					$this -> Email_model -> sendMail($list_email, $admin_email, ucfirst($admin_name), $email_name, $splVars);

					if($session_lang == "") {
					$email_name = 'contact_request_to_guest';}
					else { $email_name = 'contact_request_to_guest_'.$session_lang;}
					$splVars = array("{traveller_username}" => $query2 -> username, "{checkin}" => $checkin, "{checkout}" => $checkout, "{guest}" => $data['guests'], "{message}" => $message, "{site_name}" => $this -> dx_auth -> get_site_title(), "{host_username}" => ucfirst($host_username), "{title}" => $query -> title);
					$this -> Email_model -> sendMail($user_email, $admin_email, ucfirst($admin_name), $email_name, $splVars);

					if ($list_email != $admin_email && $user_email != $admin_email) {
						if($session_lang == "") {
							$email_name = 'contact_request_to_admin';}
							else { $email_name = 'contact_request_to_admin_'.$session_lang;}
						$splVars = array("{price}" => '$' . $list['price'], "{traveller_username}" => $query2 -> username, "{checkin}" => $checkin, "{checkout}" => $checkout, "{guest}" => $data['guests'], "{message}" => $message, "{site_name}" => $this -> dx_auth -> get_site_title(), "{host_username}" => ucfirst($host_username), "{title}" => $query -> title);
						$this -> Email_model -> sendMail($admin_email, $list_email, ucfirst($admin_name), $email_name, $splVars);
					}
				}
			}
		}
		echo json_encode($data);
	}

	function hide_email($email) { $character_set = '+-.0123456789@ABCDEFGHIJKLMNOPQRSTUVWXYZ_abcdefghijklmnopqrstuvwxyz';
		$key = str_shuffle($character_set);
		$cipher_text = '';
		$id = 'e' . rand(1, 999999999);
		for ($i = 0; $i < strlen($email); $i += 1)
			$cipher_text .= $key[strpos($character_set, $email[$i])];
		$script = 'var a="' . $key . '";var b=a.split("").sort().join("");var c="' . $cipher_text . '";var d="";';
		$script .= 'for(var e=0;e<c.length;e++)d+=b.charAt(a.indexOf(c.charAt(e)));';
		$script .= 'document.getElementById("' . $id . '").innerHTML="<a href=\\"mailto:"+d+"\\">"+d+"</a>"';
		$script = "eval(\"" . str_replace(array("\\", '"'), array("\\\\", '\"'), $script) . "\")";
		$script = '<script type="text/javascript">/*<![CDATA[*/' . $script . '/*]]>*/</script>';
		return '<span id="' . $id . '">[javascript protected email address]</span>' . $script;
	}

	function form($param = '') {
		$refer = $this -> db -> query("select * from `referral_management` where `id`=1 ") -> row();
		//$data['fixed_status']=$refer->fixed_status;
		$refamt = $refer -> fixed_amt;
		$refcur = $refer -> currency;
		$type = $refer -> type;
		$trip_amt = $refer -> trip_amt;
		$trip_per = $refer -> trip_per;
		$rent_amt = $refer -> rent_amt;
		$rent_per = $refer -> rent_per;
		$ref_total = get_currency_value2($refcur, 'USD', $refamt);
		if ($type == 1) {
			$trip_amt0 = $trip_amt;
			$rent_amt0 = $rent_amt;
			$trip = get_currency_value2($refcur, 'USD', $trip_amt);
			$rent = get_currency_value2($refcur, 'USD', $rent_amt);
		}
		if ($type == 0) {
			$trip = (($trip_per) / 100) * $ref_total;
			$rent = (($rent_per) / 100) * $ref_total;
			$current = $this -> session -> userdata("locale_currency");

		}
		$check_paypal = $this -> db -> where('is_enabled', 1) -> get('payments') -> num_rows();

		if ($check_paypal == 0) {
			$this -> session -> set_flashdata('flash_message', $this -> Common_model -> flash_message('error', translate("Payment gateway is not enabled. Please contact admin.")));
			redirect('rooms/' . $param);
		}

		if ($this -> input -> get('contact')) {
			$contact_key = $this -> input -> get('contact');

			$contact_result = $this -> Common_model -> getTableData('contacts', array('contact_key' => $contact_key)) -> row();

			if ($contact_result -> status == 10) {
				$this -> session -> set_flashdata('flash_message', $this -> Common_model -> flash_message('error', translate('Sorry! Access denied.')));
				redirect('rooms/' . $param, "refresh");
			}

			if ($contact_result -> userby != $this -> dx_auth -> get_user_id()) {
				$this -> session -> set_flashdata('flash_message', $this -> Common_model -> flash_message('error', translate('You are not a valid user to use this link.')));
				redirect('rooms/' . $param, "refresh");
			}

			$checkin = $contact_result -> checkin;
			$checkout = $contact_result -> checkout;
			$daysexist = $this -> db -> query("SELECT id,list_id,booked_days FROM `calendar` WHERE `list_id` = '" . $param . "' AND (`booked_days` >= '" . get_gmt_time(strtotime($checkin)) . "' AND `booked_days` <= '" . get_gmt_time(strtotime($checkout)) . "') GROUP BY `list_id`");

			if ($daysexist -> num_rows() == 1) {
				$this -> session -> set_flashdata('flash_message', $this -> Common_model -> flash_message('error', translate('Already Those dates are booked')));
				redirect('rooms/' . $param, "refresh");
			}
			$data['guests'] = $contact_result -> no_quest;
			$data['contact_key'] = $contact_result -> contact_key;
			$data['offer'] = $contact_result -> offer;
		} else if ($this -> session -> userdata('formCheckout')) {
			$checkin = $this -> session -> userdata('Lcheckin');
			$checkout = $this -> session -> userdata('Lcheckout');
			$data['guests'] = $this -> session -> userdata('number_of_guests');
		} else if ($this -> input -> get()) {
			$checkin = $this -> input -> get('checkin');
			$checkout = $this -> input -> get('checkout');
			$data['guests'] = $this -> input -> get('guest');
		} else {
			$checkin = $this -> input -> post('checkin');
			$checkout = $this -> input -> post('checkout');
			$data['guests'] = $this -> input -> post('number_of_guests');
		}

		$data['checkin'] = $checkin;
		$data['checkout'] = $checkout;

		$date1 = new DateTime(date('Y-m-d H:i:s', strtotime($checkin)));
		$date2 = new DateTime(date('Y-m-d H:i:s', strtotime($checkout)));
		$interval = $date1 -> diff($date2);

		if ($interval -> days >= 28) {
			$data['flash_message'] = "Your reservation is 28 or more days. So, the cacellation policy will be changed to Long Term.";
		}

		$ckin = explode('/', $checkin);
		$ckout = explode('/', $checkout);
		$id = $param;

		if ($ckin[0] == "mm") {
			$this->session->set_flashdata('flash_message', $this->Common_model->flash_message('error','Sorry! Access denied.'));
			redirect('rooms/' . $param, "refresh");
		}
		if ($ckout[0] == "mm") {
			$this->session->set_flashdata('flash_message', $this->Common_model->flash_message('error','Sorry! Access denied.'));
			redirect('rooms/' . $param, "refresh");
		}

		$xprice = $this -> Common_model -> getTableData('price', array('id' => $param)) -> row();

		$price = $data['per_night'] = $xprice -> night;

		$list_currency = $xprice -> currency;
		
		$placeid = $xprice -> id;

		$guests = $xprice -> guests;

		if (isset($xprice -> cleaning))
			$cleaning = $xprice -> cleaning;
		
		else
			$cleaning = 0;

		if (isset($xprice -> security))
			$security = $xprice -> security;
		else
			$security = 0;

		$data['cleaning'] = $cleaning;

		$data['security'] = $security;

		if (isset($xprice -> week))
			$Wprice = $xprice -> week;
		else
			$Wprice = 0;

		if (isset($xprice -> month))
			$Mprice = $xprice -> month;
		else
			$Mprice = 0;

		$query = $this -> Common_model -> getTableData('list', array('id' => $id));
		$list = $query -> row();
		$data['address'] = $list -> address;
		$data['room_type'] = $list -> room_type;
		$data['total_guests'] = $list -> capacity;
		$data['tit'] = $list -> title;
		$data['manual'] = $list -> house_rule;

		$diff = strtotime($ckout[2] . '-' . $ckout[0] . '-' . $ckout[1]) - strtotime($ckin[2] . '-' . $ckin[0] . '-' . $ckin[1]);
		$days = ceil($diff / (3600 * 24));

		//Entering it into data variables
		$data['id'] = $id;
		$data['price'] = $xprice -> night;


		$data['days'] = $days;
		$data['full_cretids'] = 'off';

		$data['commission'] = 0;

		$price = $price * $days;
		
			$query = $this -> Common_model -> getTableData('paymode', array('id' => 2));
			$row = $query -> row();			
			/// weekly price check //
			if($days >= 7 && $days < 30)
			{
			 if(!empty($Wprice))
				{
				  $finalAmount     = $Wprice;
						$differNights    = $days - 7;
						$perDay          = $Wprice / 7;
						$per_night       = round($perDay, 2);
						if($differNights > 0)
						{
						  $addAmount     = $differNights * $per_night;
						  $finalAmount   = $Wprice + $addAmount;
						}
						
						$price           = $finalAmount;
				}
			}
			/// weekly end //
			
			/// monthly price check //	
			if($days >= 30)
			{
			 if(!empty($Mprice))
				{
				  $finalAmount     = $Mprice;
						$differNights    = $days - 30;
						$perDay          = $Mprice / 30;
						$per_night       = round($perDay, 2);
						if($differNights > 0)
						{
						  $addAmount     = $differNights * $per_night;
								$finalAmount   = $Mprice + $addAmount;
						}
						
						$price           = $finalAmount;
				}
			}
						
			//// monthly end //
	
		//Seasonal Price
		
		//Store seasonal price of a list in an array
		$seasonal_query	= $this->Common_model->getTableData('seasonalprice',array('list_id' => $id));
		$seasonal_result= $seasonal_query->result_array();
		$seasonal_dates = "no";
		$seasonal_arr = array();
		if($seasonal_query->num_rows()>0)
		{
			//1. Store all the dates between checkin and checkout in an array		
			$checkin_time		= get_gmt_time(strtotime($checkin));
			$checkout_time		= get_gmt_time(strtotime($checkout));
			$travel_dates		= array();
			$travel_dates_show = array();
			$seasonal_prices 	= array();		
			$total_nights		= 1;
			$total_price		= 0;
			$is_seasonal		= 0;
			$i					= $checkin_time;
			
			while($i<$checkout_time)
			{
				$checkin_date					= date('m/d/Y',$i);
				$checkin_date					= explode('/', $checkin_date);
				$travel_dates[$total_nights]	= $checkin_date[1].$checkin_date[0].$checkin_date[2];
				$travel_dates_show[$total_nights]	= $checkin_date[1]."-".$checkin_date[0]."-".$checkin_date[2];
				$i								= get_gmt_time(strtotime('+1 day',$i));
				$total_nights++; 
			}
		
		for ($i = 1; $i < $total_nights; $i++) {
			$seasonal_prices[$travel_dates[$i]] = "";
		}
			foreach($seasonal_result as $time)
			{	
				//Get Seasonal price
				$seasonalprice_query	= $this->Common_model->getTableData('seasonalprice',array('list_id' => $id,'start_date' => $time['start_date'],'end_date' => $time['end_date']));
				$seasonalprice = $seasonalprice_query -> row() -> price;	
				//Days between start date and end date -> seasonal price	
				$start_time	= $time['start_date'];
				$end_time	= $time['end_date'];
				$i			= $start_time;
				while($i<=$end_time)
				{	
					$start_date					= date('m/d/Y',$i);
					$s_date						= explode('/',$start_date);	
					$s_date						= $s_date[1].$s_date[0].$s_date[2];
					$seasonal_prices[$s_date]	= $seasonalprice;
					$i							= get_gmt_time(strtotime('+1 day',$i));			
				}				
				
			}

			$count = 0 ;
			 //Total Price
			for($i=1;$i<$total_nights;$i++)
			{
				if($seasonal_prices[$travel_dates[$i]] != "")	
				{	
					$total_price= $total_price+$seasonal_prices[$travel_dates[$i]];
					$is_seasonal=1;
				/// for showing the list in detail page	
				$seasonal_arr[] = 	$travel_dates_show[$i]."price".get_currency_value1($id,$seasonal_prices[$travel_dates[$i]]);				
				$count++;
				//// end	
				}else{
				$total_price = $total_price + $xprice->night ;
				/// for showing the list in detail page	
				$seasonal_arr[] = $travel_dates_show[$i]."price".get_currency_value1($id,$xprice->night);
				//// end
				} 
			}

			if($count < 1)
			{
			$seasonal_dates = "no";	
			}else{
			$seasonal_dates = "yes";	
			}
				if($is_seasonal>0)
				{	
					//Total days
					$days 			= $total_nights;
					//Final price	
					$price = $total_price;		
					
				}
			// end Seasonal price	
		
		}

if(count($seasonal_arr) > 0)
{
			$seasonal_split = 	implode(":", $seasonal_arr);				
	
}else{
	$seasonal_split = "no";
}
$data['seasonal_status'] = $seasonal_dates ;
$data['seasonal_dates'] = $seasonal_arr;
$data['seasonal_dates_hidden'] = $seasonal_split;
$data['price']    = round($price,0); 	
	///// Base price ended - base price includes per night, seasonal price prices ///

			//Additional guests //
			
			if($data['guests'] > $guests)
			{
			  	$diff_guest = $data['guests'] - $guests;
				$extra_guest_price = ($days * $xprice->addguests * $diff_guest);
				$extra_guest = 1;
				
				$price     = $price + $extra_guest_price;
				$data['diif_guest'] = $diff_guest ;
				$data['guest_price'] = $xprice->addguests ;
			}else{
				$data['diif_guest'] = 0 ;
				$extra_guest_price = 0;
			}
			 ///// end ///	
$data['price_after_guest']    = round($price,0);  /// base price + additional guest fee //			 
		/// Base price & days
		$data['days']   =$days;
		
			
		/// cleaning and security fees //	
			if($cleaning != 0)
			{
				$price = $price + $cleaning;
			}
			
			if($security != 0)
			{
				$price = $price + $security;
			}
	/// end ///
	
$data['subtotal'] = $amt = round($price,2);  // subtotal (base price + cleaning fee + security fee)	
		
		if ($this -> input -> get('contact')) {
			$amt = get_currency_value_lys($contact_result -> currency, get_currency_code(), $contact_result -> price);
			$data['subtotal'] = $amt;
			$this -> session -> set_userdata("total_price_'" . $id . "'_'" . $this -> dx_auth -> get_user_id() . "'", $amt);
		}
		
	//	Getting commission //
$data['commission'] = 0;
			
			 if($row->is_premium == 1)
					{
			    if($row->is_fixed == 1)
				{
							$fix                = $row->fixed_amount; 
							$data['commission'] = get_currency_value_lys($row -> currency, $xprice->currency, $fix);
							$amt = $amt + get_currency_value_lys($row -> currency, $xprice->currency, $fix);
				}
				else
				{  
							$per                = $row->percentage_amount; 
							$camt               = floatval(($price * $per) / 100);
							$data['commission'] = $camt;
							$amt                = $amt + $camt;
							
				}
	
		   }
 $data['total_price'] = $amt ;		

		// Referral amount Starts
		$ref = $this -> db -> select('referral_amount') -> where('id', $this -> dx_auth -> get_user_id()) -> get('users') -> row() -> referral_amount;
		if($ref != 0){
	$data['referral_amount'] = 	$ref ;		
		}

		if ($amt < 0) {
			$this -> session -> set_flashdata('flash_message', $this -> Common_model -> flash_message('error', translate('Sorry! Your payment should be greater than 0.')));
			redirect('rooms/' . $param, "refresh");
		}

		$data['result'] = $this -> Common_model -> getTableData('payments') -> result();
		$array_items = array('list_id' => '', 'Lcheckin' => '', 'Lcheckout' => '', 'number_of_guests' => '', 'formCheckout' => '');
		$this -> session -> unset_userdata($array_items);

		//Coupon Starts
		$is_coupon = 0;
		$data['coupon_amount'] = 0 ;
		$session_coupon = $this -> session -> userdata("coupon");
		$this -> session -> set_userdata("total_price_'" . $id . "'_'" . $this -> dx_auth -> get_user_id() . "'", $amt);
		$this -> session -> unset_userdata('coupon_code_used');
		
		if ($this -> input -> post('apply_coupon')) {
			
			$list_id = $this -> input -> post('hosting_id');
			$coupon_code = $this -> input -> post('coupon_code');
			$user_id = $this -> dx_auth -> get_user_id();

			if ($coupon_code != "") {
				$coupon_res = $this->db->where(array('couponcode'=>$coupon_code,'status'=>0))->get('coupon');
				$is_coupon_already = $this -> Common_model -> getTableData('coupon_users', array('used_coupon_code' => $coupon_code, 'user_id' => $user_id, 'status' => 1));
				//Check the list is already access with the coupon by the host or not
				if ($is_coupon_already -> num_rows() > 0) {
					$this -> session -> unset_userdata('coupon_code_used');
					$this -> session -> set_flashdata('flash_message', $this -> Common_model -> flash_message('error', translate('Sorry! This coupon code is already used')));
					redirect('rooms/' . $param, "refresh");
				} else {
					//Coupon Discount calculation
					if($coupon_res->num_rows()>0)
					{						
						//Currecy coversion
						$current_currency = get_currency_code();
						$coupon_currency = $coupon_res->row()->currency;
						$Coupon_amt = $coupon_res->row()->coupon_price;		
						
						$list_currency = $list -> currency;
						if($coupon_currency != $list_currency)
						{
						$Coupon_amt = get_currency_value_lys1($coupon_currency, $list_currency, $Coupon_amt);
						}else{
						$Coupon_amt =	$Coupon_amt ;
						}
						if ($Coupon_amt >= $amt) {
							$this -> session -> unset_userdata('coupon_code_used');
							$this -> session -> set_flashdata('flash_message', $this -> Common_model -> flash_message('error', translate('Sorry! There is equal money or more money in your coupon to book this list.')));
							redirect('rooms/' . $param, "refresh");
						} else {
							$is_coupon = 1;
							$amt = $famount = $amt - $Coupon_amt ;
							$data['coupon_amount'] = $Coupon_amt ;

							$insertData = array('list_id' => $list_id, 'used_coupon_code' => $coupon_code, 'user_id' => $user_id, 'status' => 0);
							$this -> Common_model -> inserTableData('coupon_users', $insertData);
							/*   $this->db->where('couponcode',$coupon_code)->update('coupon',array('status'=>1));*/
							$this -> session -> set_userdata("total_price_'" . $list_id . "'_'" . $user_id . "'", $amt);
							$this -> session -> set_userdata('coupon_code_used', 1);
							$this -> session -> set_userdata('coupon_code', $coupon_code);
							$this -> session -> set_userdata('coupon_amt', $Coupon_amt);
							//echo	$this->session->userdata("coupon_amt");exit;
						}
				
					}else{
					$is_coupon = 0;
						$this -> session -> set_flashdata('flash_message', $this -> Common_model -> flash_message('error', translate('Sorry! This coupon code not exist or Expired')));
						redirect('rooms/' . $param, "refresh");						
					}

				}
			} else {
				$this -> session -> unset_userdata('coupon_code_used');
				$this -> session -> unset_userdata('coupon_code');
				$this -> session -> set_flashdata('flash_message', $this -> Common_model -> flash_message('error', translate('Sorry! Your coupon does not match.')));
				redirect('rooms/' . $param, "refresh");
			}
		} else {
			$this -> session -> unset_userdata('coupon_code_used');
			$this -> session -> unset_userdata('coupon_code');
		}
		//Coupon Ends
		$data['coupon_status'] = $is_coupon ;
		$data['total_price'] = round($amt, 2);	
		$data['amt'] = round($amt, 2);
		$data['policy'] = $this -> Common_model -> getTableData('cancellation_policy', array('id' => $list -> cancellation_policy)) -> row() -> name;
		// Advertisement popup 1 start
		$data['PagePopupContent'] = GetPagePopupContent('step2');
		// Advertisement popup 1 end
		$data['countries'] = $this -> Common_model -> getCountries() -> result();
		$data['title'] = get_meta_details('Confirm_your_booking', 'title');
		$data["meta_keyword"] = get_meta_details('Confirm_your_booking', 'meta_keyword');
		$data["meta_description"] = get_meta_details('Confirm_your_booking', 'meta_description');
		$data['message_element'] = "payments/view_booking";
		$this -> load -> view('template', $data);
	}

	public function payment($param = "", $env = "") {
		if ($this -> input -> post('agrees_to_terms') != 'on') {
			$newdata = array('list_id' => $param, 'Lcheckin' => $this -> input -> post('checkin'), 'Lcheckout' => $this -> input -> post('checkout'), 'number_of_guests' => $this -> input -> post('number_of_guests'), 'formCheckout' => TRUE);
			$this -> session -> set_userdata($newdata);
			$this -> session -> set_flashdata('flash_message', $this -> Common_model -> flash_message('error', translate('You must agree to the Cancellation Policy and House Rules!')));
			redirect('payments/index/' . $param, 'refresh');
		}
		$reservation_key = $this -> input -> post('reservation_key');

		$contact_key = $this -> input -> post('contact_key');

		if ($reservation_key_key != '') {
			$this -> session -> set_userdata('reservation_key', $reservation_key);
		} else {
			$this -> session -> unset_userdata('reservation_key');
		}

		if ($contact_key != '') {
			$this -> session -> set_userdata('contact_key', $contact_key);
		} else {
			$this -> session -> unset_userdata('contact_key');
		}

		/*$contact_key=$this->input->post('contact_key');
		 $updateKey      		  = array('contact_key' => $contact_key);
		 $updateData               = array();
		 $updateData['status']    = 10;
		 $this->Contacts_model->update_contact($updateKey,$updateData);*/

		/*	if($this->session->userdata("total_price_'".$param."'_'".$this->dx_auth->get_user_id()."'") == "")
		 {
		 redirect('rooms/'.$param, "refresh");
		 $this->session->set_flashdata('flash_message', $this->Common_model->flash_message('error','Please! Try Again'));

		 }*/
		if ($this -> input -> post('payment_method') == 'stripe') {
			$this -> submission_stripe_payment($param);

		} else if ($this -> input -> post('payment_method') == 'braintree') {
			$this -> submission_cc($param);
		} else if ($this -> input -> post('payment_method') == 'paypal' || $env = "mobile") {

			$this -> submission($param, $contact_key);

		} else if ($this -> input -> post('payment_method') == '2c') {
			//$this->submissionTwoc($param);
		} else {
			redirect('info');
		}

	}

	function submission($param = '', $contact_key) {
		$checkin = $this -> input -> post('checkin');
		$checkout = $this -> input -> post('checkout');
		$number_of_guests = $this -> input -> post('number_of_guests');
		$ckin = explode('/', $checkin);
		$ckout = explode('/', $checkout);
		$id = $this -> uri -> segment(3);

		if ($this -> session -> userdata('mobile_user_id')) {
			$user_id = $this -> session -> userdata('mobile_user_id');
			$this -> session -> unset_userdata('mobile_user_id');
		} else {
			$user_id = $this -> dx_auth -> get_user_id();
		}

		if ($ckin[0] == "mm") {
			$this -> session -> set_flashdata('flash_message', $this -> Common_model -> flash_message('error', translate('Sorry! Access denied.')));
			redirect('rooms/' . $id, "refresh");
		}
		if ($ckout[0] == "mm") {
			$this -> session -> set_flashdata('flash_message', $this -> Common_model -> flash_message('error', translate('Sorry! Access denied.')));
			redirect('rooms/' . $id, "refresh");
		}
		
		$is_travelCretids = md5('No Travel Cretids');
		$user_travel_cretids = 0;
		$total_price = $sub_total = $this -> input -> post('subtotal');
		$security = $this -> input -> post('security');
		$cleaning = $this -> input -> post('cleaning');
		$amt = $this -> input -> post('total');
		$per_night = $this -> input -> post('per_night');
		$admin_commission = $this -> input -> post('commission');
		$contact_key = $this -> input -> post('contact_key');
		$list_currency = $this -> input -> post('list_currency');
		$extra_guest_price = $this -> input -> post('extra_guest_price');
		$coupon_status = $this -> input -> post('coupon_status');
		$coupon_amount = $this -> input -> post('coupon_amount');
		$seasonal_status = $this -> input -> post('seasonal_status');
		$seasonal_dates = $this -> input -> post('seasonal_dates');
		
		$base_price = $this -> input -> post('base_price'); /// (per night amount x number of days) & also seasonal prices		
		
		$custom = $id . '@' . $user_id . '@' . get_gmt_time(strtotime($checkin)) . '@' . get_gmt_time(strtotime($checkout)) . '@' . $number_of_guests . '@' . $is_travelCretids . '@' . $user_travel_cretids . '@' . $total_price . '@' . $admin_commission . '@' . $contact_key . '@' . $cleaning . '@' . $security . '@' . $extra_guest_price . '@' . $guests . '@' . $amt . '@' . $this -> session -> userdata('booking_currency_symbol') . '@' . $per_night.'@'.$list_currency.'@'.$coupon_status.'@'.$coupon_amount.'@'.$seasonal_status.'@'.$seasonal_dates.'@'.$base_price;
		$this -> session -> set_userdata('custom', $custom);
		
		if (get_currency_code() == 'INR' || get_currency_code() == 'MYR' || get_currency_code() == 'ARS' || get_currency_code() == 'CNY' || get_currency_code() == 'IDR' || get_currency_code() == 'KRW' || get_currency_code() == 'VND' || get_currency_code() == 'ZAR') {
			$currency_code = 'USD';
			//$currency_code = $this->session->userdata('booking_currency_symbol');
			$amt = get_currency_value_lys(get_currency_code(), $currency_code, $amt);

		} else {
			//$currency_code = $this->session->userdata('booking_currency_symbol');
			$currency_code = get_currency_code();
			$amt = $amt;
		}

		$this -> session -> set_userdata('currency_code_payment', $currency_code);

		$to_buy = array('desc' => 'Purchase from ACME Store', 'currency' => $currency_code, 'type' => 'sale', 'return_URL' => site_url('payments/paypal_success'),
		// see below have a function for this -- function back()
		// whatever you use, make sure the URL is live and can process
		// the next steps
		'cancel_URL' => site_url('payments/paypal_cancel'), // this goes to this controllers index()
		'shipping_amount' => 0, 'get_shipping' => false);
		// I am just iterating through $this->product from defined
		// above. In a live case, you could be iterating through
		// the content of your shopping cart.
		//foreach($this->product as $p) {
		$temp_product = array('name' => $this -> dx_auth -> get_site_title() . ' Transaction', 'number' => $placeid, 'quantity' => 1, // simple example -- fixed to 1
		'amount' => $amt);

		// add product to main $to_buy array
		$to_buy['products'][] = $temp_product;
		//}
		// enquire Paypal API for token

		$set_ec_return = $this -> paypal_ec -> set_ec($to_buy);
		//echo "<pre>";print_r($set_ec_return);exit;

		if (isset($set_ec_return['ec_status']) && ($set_ec_return['ec_status'] === true)) {
			// redirect to Paypal

			try {
				$this -> paypal_ec -> redirect_to_paypal($set_ec_return['TOKEN']);
			} catch(Exception $e) {
				$this -> session -> set_flashdata('flash_message', $this -> Common_model -> flash_message('error', translate("PayPal Service is currently Not Available Please Try Again Later.")));
				redirect('rooms/' . $id, "refresh");
			}
			// You could detect your visitor's browser and redirect to Paypal's mobile checkout
			// if they are on a mobile device. Just add a true as the last parameter. It defaults
			// to false
			// $this->paypal_ec->redirect_to_paypal( $set_ec_return['TOKEN'], true);
		} else {
			if ($set_ec_return['L_LONGMESSAGE0'] == 'Security header is not valid') {
				$username = $this -> dx_auth -> get_username();
				$list_title = $this -> Common_model -> getTableData('list', array('id' => $id)) -> row() -> title;
				$email = $this -> Common_model -> getTableData('users', array('id' => $this -> dx_auth -> get_user_id())) -> row() -> email;
				$admin_email = $this -> Common_model -> getTableData('users', array('id' => 1)) -> row() -> email;

				$admin_email_from = $this -> dx_auth -> get_site_sadmin();
				$admin_name = $this -> dx_auth -> get_site_title();
				
				$session_lang = $this->session->userdata('locale');
				if($session_lang == "") {
					$email_name = 'payment_issue_to_admin';}
					else { $email_name = 'payment_issue_to_admin_'.$session_lang;}
				
				$splVars = array("{payment_type}" => 'PayPal', "{site_name}" => $this -> dx_auth -> get_site_title(), "{username}" => ucfirst($username), "{list_title}" => $list_title, '{email_id}' => $email);

				$this -> Email_model -> sendMail($admin_email, $admin_email_from, ucfirst($admin_name), $email_name, $splVars);

				$this -> session -> set_flashdata('flash_message', $this -> Common_model -> flash_message('error', translate("PayPal business account is misconfigured. Please contact your Administrator.")));
				redirect('rooms/' . $id, "refresh");
			} else {
				$this -> session -> set_flashdata('flash_message', $this -> Common_model -> flash_message('error', translate("PayPal Service is currently Not Available Please Try Again Later.")));
				redirect('rooms/' . $id, "refresh");
			}
			//$this->_error($set_ec_return);
		}

	}

	function submission_stripe_payment($param) {


		$checkin = $this -> input -> post('checkin');
		$checkout = $this -> input -> post('checkout');
		$number_of_guests = $this -> input -> post('number_of_guests');
		$ckin = explode('/', $checkin);
		$ckout = explode('/', $checkout);
		$id = $this -> uri -> segment(3);

		if ($this -> session -> userdata('mobile_user_id')) {
			$user_id = $this -> session -> userdata('mobile_user_id');
			$this -> session -> unset_userdata('mobile_user_id');
		} else {
			$user_id = $this -> dx_auth -> get_user_id();
		}

		if ($ckin[0] == "mm") {
			$this -> session -> set_flashdata('flash_message', $this -> Common_model -> flash_message('error', translate('Sorry! Access denied.')));
			redirect('rooms/' . $id, "refresh");
		}
		if ($ckout[0] == "mm") {
			$this -> session -> set_flashdata('flash_message', $this -> Common_model -> flash_message('error', translate('Sorry! Access denied.')));
			redirect('rooms/' . $id, "refresh");
		}
		$is_travelCretids = md5('No Travel Cretids');
		$user_travel_cretids = 0;
		$total_price = $sub_total = $this -> input -> post('subtotal');
		$security = $this -> input -> post('security');
		$cleaning = $this -> input -> post('cleaning');
		$amt = $this -> input -> post('total');
		$per_night = $this -> input -> post('per_night');
		$admin_commission = $this -> input -> post('commission');
		$contact_key = $this -> input -> post('contact_key');
		$list_currency = $this -> input -> post('list_currency');
		$extra_guest_price = $this -> input -> post('extra_guest_price');
		$coupon_status = $this -> input -> post('coupon_status');
		$coupon_amount = $this -> input -> post('coupon_amount');
		$seasonal_status = $this -> input -> post('seasonal_status');
		$seasonal_dates = $this -> input -> post('seasonal_dates');
		$base_price = $this -> input -> post('base_price'); /// (per night amount x number of days) & also seasonal prices		
		
		$custom = $id . '@' . $user_id . '@' . get_gmt_time(strtotime($checkin)) . '@' . get_gmt_time(strtotime($checkout)) . '@' . $number_of_guests . '@' . $is_travelCretids . '@' . $user_travel_cretids . '@' . $total_price . '@' . $admin_commission . '@' . $contact_key . '@' . $cleaning . '@' . $security . '@' . $extra_guest_price . '@' . $guests . '@' . $amt . '@' . $this -> session -> userdata('booking_currency_symbol') . '@' . $per_night.'@'.$list_currency.'@'.$coupon_status.'@'.$coupon_amount.'@'.$seasonal_status.'@'.$seasonal_dates.'@'.$base_price;
			//	echo $custom ;exit;
		$this -> session -> set_userdata('custom', $custom);
		
		if (get_currency_code() != 'USD') {
			$currency_code = 'USD';
			$amt = get_currency_value_lys(get_currency_code(), $currency_code, $amt);

		} else {
			$currency_code = get_currency_code();
			$amt = $amt;
		}

		$data['secret_key'] = $this -> stripe_secret;
		$data['publishable_key'] = $this -> stripe_pub;

		Stripe::setApiKey($data['secret_key']);

		$data['amount'] = $amt;
		$data['title'] = "Payments";
		$data["meta_keyword"] = "";
		$data["meta_description"] = "";
		$data['message_element'] = "payments/payment_form";
		$this -> load -> view('template', $data);

	}

	function submission_cc($param = '') {

		$checkin = $this -> input -> post('checkin');
		$checkout = $this -> input -> post('checkout');
		$number_of_guests = $this -> input -> post('number_of_guests');
		$ckin = explode('/', $checkin);
		$ckout = explode('/', $checkout);
		$id = $this -> uri -> segment(3);

		if ($this -> session -> userdata('mobile_user_id')) {
			$user_id = $this -> session -> userdata('mobile_user_id');
			$this -> session -> unset_userdata('mobile_user_id');
		} else {
			$user_id = $this -> dx_auth -> get_user_id();
		}

		if ($ckin[0] == "mm") {
			$this -> session -> set_flashdata('flash_message', $this -> Common_model -> flash_message('error', translate('Sorry! Access denied.')));
			redirect('rooms/' . $id, "refresh");
		}
		if ($ckout[0] == "mm") {
			$this -> session -> set_flashdata('flash_message', $this -> Common_model -> flash_message('error', translate('Sorry! Access denied.')));
			redirect('rooms/' . $id, "refresh");
		}
		$is_travelCretids = md5('No Travel Cretids');
		$user_travel_cretids = 0;
		$total_price = $sub_total = $this -> input -> post('subtotal');
		$security = $this -> input -> post('security');
		$cleaning = $this -> input -> post('cleaning');
		$amt = $this -> input -> post('total');
		$per_night = $this -> input -> post('per_night');
		$admin_commission = $this -> input -> post('commission');
		$contact_key = $this -> input -> post('contact_key');
		$list_currency = $this -> input -> post('list_currency');
		$extra_guest_price = $this -> input -> post('extra_guest_price');
		$coupon_status = $this -> input -> post('coupon_status');
		$coupon_amount = $this -> input -> post('coupon_amount');
		$seasonal_status = $this -> input -> post('seasonal_status');
		$seasonal_dates = $this -> input -> post('seasonal_dates');
		$base_price = $this -> input -> post('base_price'); /// (per night amount x number of days) & also seasonal prices		
		$custom = $id . '@' . $user_id . '@' . get_gmt_time(strtotime($checkin)) . '@' . get_gmt_time(strtotime($checkout)) . '@' . $number_of_guests . '@' . $is_travelCretids . '@' . $user_travel_cretids . '@' . $total_price . '@' . $admin_commission . '@' . $contact_key . '@' . $cleaning . '@' . $security . '@' . $extra_guest_price . '@' . $guests . '@' . $amt . '@' . $this -> session -> userdata('booking_currency_symbol') . '@' . $per_night.'@'.$list_currency.'@'.$coupon_status.'@'.$coupon_amount.'@'.$seasonal_status.'@'.$seasonal_dates.'@'.$base_price;
		$this -> session -> set_userdata('custom', $custom);
		
		$clientToken = Braintree_ClientToken::generate(array());

		if ($clientToken == '401') {

			$username = $this -> dx_auth -> get_username();
			$list_title = $this -> Common_model -> getTableData('list', array('id' => $id)) -> row() -> title;
			$email = $this -> Common_model -> getTableData('users', array('id' => $this -> dx_auth -> get_user_id())) -> row() -> email;
			$admin_email = $this -> Common_model -> getTableData('users', array('id' => 1)) -> row() -> email;

			$admin_email_from = $this -> dx_auth -> get_site_sadmin();
			$admin_name = $this -> dx_auth -> get_site_title();

			$session_lang = $this->session->userdata('locale');
				if($session_lang == "") {
					$email_name = 'payment_issue_to_admin';}
					else { $email_name = 'payment_issue_to_admin_'.$session_lang;}
			$splVars = array("{payment_type}" => 'Braintree', "{site_name}" => $this -> dx_auth -> get_site_title(), "{username}" => ucfirst($username), "{list_title}" => $list_title, '{email_id}' => $email);

			$this -> Email_model -> sendMail($admin_email, $admin_email_from, ucfirst($admin_name), $email_name, $splVars);

			$this -> session -> set_flashdata('flash_message', $this -> Common_model -> flash_message('error', translate("Braintree business account is misconfigured. Please contact your Administrator.")));
			redirect('rooms/' . $id, "refresh");
		}
		//print_r($data); exit;
		$data['title'] = "Payments";
		$data["meta_keyword"] = "";
		$data["meta_description"] = "";
		$data['clientToken'] = $clientToken;
		$data['message_element'] = "payments/checkout";
		$this -> load -> view('template', $data);

	}

	function paypal_cancel() {
		$data['title'] = "Payment Failed";

		if ($this -> session -> userdata('call_back') == 'mobile') {
			$message_element = 'payments/paypal_cancel_mobile';
		} else {
			$message_element = 'payments/paypal_cancel';
		}
		$data['message_element'] = $message_element;
		$this -> load -> view('template', $data);
	}

	function paypal_success() {

		$custom = $this -> session -> userdata('custom');
		$data = array();
		$list = array();
		$data = explode('@', $custom);

		$contact_key = $data[9];
		$list['list_id'] = $data[0];
		
		
		$token = $_GET['token'];
		$payer_id = $_GET['PayerID'];
		// GetExpressCheckoutDetails
		$get_ec_return = $this -> paypal_ec -> get_ec($token);
		if (isset($get_ec_return['ec_status']) && ($get_ec_return['ec_status'] === true)) {

			// at this point, you have all of the data for the transaction.
			// you may want to save the data for future action. what's left to
			// do is to collect the money -- you do that by call DoExpressCheckoutPayment
			// via $this->paypal_ec->do_ec();
			//
			// I suggest to save all of the details of the transaction. You get all that
			// in $get_ec_return array
			$currency_code = $this -> session -> userdata('currency_code_payment');
			if ($currency_code == 'INR' || $currency_code == 'MYR' || $currency_code == 'ARS' || $currency_code == 'CNY' || $currency_code == 'IDR' || $currency_code == 'KRW' || $currency_code == 'VND' || $currency_code == 'ZAR') {
				$currency_code = 'USD';
			} else {
				$currency_code = $currency_code;
			}
			$ec_details = array('token' => $token, 'payer_id' => $payer_id, 'currency' => $currency_code, 'amount' => $get_ec_return['PAYMENTREQUEST_0_AMT'], 'IPN_URL' => site_url('payments/ipn'),
			// in case you want to log the IPN, and you
			// may have to in case of Pending transaction
			'type' => 'sale');

			$instance_book = $this -> db -> where('id', $list['list_id']) -> get('list') -> row() -> instance_book;
			
			//echo $this->db->last_query();
			if ($instance_book == 1) {
				$do_ec_return = $this -> paypal_ec -> do_ec($ec_details);
				if (isset($do_ec_return['ec_status']) && ($do_ec_return['ec_status'] === true)) {
					$paypal_go = true;
					$list['paypal_transactionid'] = $do_ec_return['PAYMENTINFO_0_TRANSACTIONID'];
				} else {
					$paypal_go = false;
				}
			} else {
				if (($get_ec_return['CHECKOUTSTATUS'] === 'PaymentActionCompleted')) {
					redirect('home');
					exit ;
				}
				if (isset($get_ec_return['ec_status']) && ($get_ec_return['ec_status'] === true)) {
					$paypal_go = true;
				} else {
					$paypal_go = false;
				}
			}

			// DoExpressCheckoutPayment
			//$do_ec_return = $this->paypal_ec->do_ec($ec_details);

			//if (isset($do_ec_return['ec_status']) && ($do_ec_return['ec_status'] === true)) {
			//if (isset($get_ec_return['ec_status']) && ($get_ec_return['ec_status'] === true)) {
			if ($paypal_go === true) {

				// DoExpressCheckoutPayment
				// $do_ec_return = $this->paypal_ec->do_ec($ec_details);
				//
				// if (isset($do_ec_return['ec_status']) && ($do_ec_return['ec_status'] === true)) {
				// at this point, you have collected payment from your customer
				// you may want to process the order now.

				/* echo "<h1>Thank you. We will process your order now.</h1>";
				 echo "<pre>";
				 echo "\nGetExpressCheckoutDetails Data\n" . print_r($get_ec_return, true);
				 echo "\n\nDoExpressCheckoutPayment Data\n" . print_r($do_ec_return, true);
				 echo "</pre>";exit; */

				// if(isset($do_ec_return['L_SHORTMESSAGE0']) && ($do_ec_return['L_SHORTMESSAGE0'] === 'Duplicate Request'))
				// {
				// redirect('home');
				// }

				$refer = $this -> db -> query("select * from `referral_management` where `id`=1 ") -> row();
				//$data['fixed_status']=$refer->fixed_status;
				$refamt = $refer -> fixed_amt;
				$refcur = $refer -> currency;
				$type = $refer -> type;
				$trip_amt = $refer -> trip_amt;
				$trip_per = $refer -> trip_per;
				$rent_amt = $refer -> rent_amt;
				$rent_per = $refer -> rent_per;
				$ref_total = get_currency_value2($refcur, 'USD', $refamt);
				if ($type == 1) {
					$trip_amt0 = $trip_amt;
					$rent_amt0 = $rent_amt;
					$trip = get_currency_value2($refcur, 'USD', $trip_amt);
					$rent = get_currency_value2($refcur, 'USD', $rent_amt);
				}
				if ($type == 0) {
					$trip = (($trip_per) / 100) * $ref_total;
					$rent = (($rent_per) / 100) * $ref_total;
					$current = $this -> session -> userdata("locale_currency");

				}

				$list['userby'] = $data[1];

				$query1 = $this -> Common_model -> getTableData('list', array('id' => $list['list_id']));
				$buyer_id = $query1 -> row() -> user_id;

				$list['userto'] = $buyer_id;
				$list['checkin'] = $data[2];
				$list['checkout'] = $data[3];
				$list['no_quest'] = $data[4];

				$list['paypal_token'] = $token;
				$list['paypal_payer_id'] = $payer_id;

				$date1 = new DateTime(date('Y-m-d H:i:s', $list['checkin']));
				$date2 = new DateTime(date('Y-m-d H:i:s', $list['checkout']));
				$interval = $date1 -> diff($date2);

				if ($interval -> days >= 28) {
					$list['policy'] = 5;
				} else {
					$list['policy'] = $query1 -> row() -> cancellation_policy;
				}
				
				$amt = $list['price'] = $data[14]; // total amount
				$currency = $data[15];

				$list['payment_id'] = 2;
				$list['credit_type'] = 1;
				$list['transaction_id'] = 0;

				$is_travelCretids = $data[5];
				$user_travel_cretids = $data[6];

				$list['currency'] = $currency;
				$list['admin_commission'] = $data[8]; // admin commission
				$list['cleaning'] = $data[10];
				$list['security'] = $data[11];
				$list['topay'] =  $data[7]; /// sub total
				$list['per_night_price'] =  $data[16]; /// per night list price

				$list['guest_count'] = $data[13];
				$list['coupon'] = $data[18];
				$list['coupon_amt'] = $data[19]; // coupon amount
				
				$seasonal_status = $data[20];
				if($seasonal_status != "" && $seasonal_status != "no")
				{
				$list['seasonal_dates_price'] = $data[21];	/// seasonal dates and its prices				
				}else{
				$list['seasonal_dates_price'] = 0;				
				}
				$list['base_price'] = $data[22];  /// base price { per night x days along with seasonal prices}
				
				if ($list['no_quest'] > $list['guest_count']) {
						$list['extra_guest_price'] = $data[12];
				}

				if ($contact_key != '' && $contact_key != "None") {
					$updateKey = array('contact_key' => $contact_key);
					$updateData = array();
					$updateData['status'] = 10;
					$list['contacts_offer'] = $this -> session -> userdata('contacts_offer');
					$this -> Contacts_model -> update_contact($updateKey, $updateData);
					
					$list['status'] = 1;
					$this -> db -> select_max('group_id');
					$group_id = $this -> db -> get('calendar') -> row() -> group_id;

					if(empty($group_id))
					{
						$countJ = 0;
					} else{
						 $countJ = $group_id;
					}

					$insertData['list_id'] = $list['list_id'];
					$insertData['group_id'] = $countJ + 1;
					$insertData['availability'] = 'Booked';
					$insertData['booked_using'] = 'Other';

					$checkin = date('m/d/Y', $list['checkin']);
					$checkout = date('m/d/Y', $list['checkout']);

					$days = getDaysInBetween($checkin, $checkout);

					$count = count($days);
					$i = 1;
					$listid1 = $list['list_id'];
					$instance_book = $this -> db -> where('id', $listid1) -> get('list') -> row() -> instance_book;
					//echo $this->db->last_query();
					if ($instance_book == 1) {
						foreach ($days as $val) {
							if ($count == 1) {
								$insertData['style'] = 'single';
							} else if ($count > 1) {
								if ($i == 1) {
									$insertData['style'] = 'left';
								} else if ($count == $i) {
									$insertData['notes'] = '';
									$insertData['style'] = 'right';
								} else {
									$insertData['notes'] = '';
									$insertData['style'] = 'both';
								}
							}
							$insertData['booked_days'] = $val;
							$this -> Trips_model -> insert_calendar($insertData);
							$i++;
						}
					}
					
					
				} else {
					$listid1 = $list['list_id'];
					$instance_book = $this -> db -> where('id', $listid1) -> get('list') -> row() -> instance_book;
					if ($instance_book == 1) {
						$list['status'] = 3;
					} else {
						$list['status'] = 1;
					}

				}
				if ($list['price'] > $rent) {
					$user_id = $list['userby'];
					$details = $this -> Referrals_model -> get_details_by_Iid($user_id);
					$row = $details -> row();
					$count = $details -> num_rows();
					if ($count > 0) {
						$user = $this -> Users_model -> get_user_by_id($this -> dx_auth -> get_user_id()) -> row();
						$trip1 = $user -> ref_trip;
						$rent1 = $user -> ref_rent;
						$details1 = $this -> Referrals_model -> get_details_refamount($row -> invite_from);
						$amt_check = $this -> db -> where('id', $row -> invite_from) -> get('users');
						if ($amt_check -> num_rows() == 0) {
							$insertData = array();
							$insertData['user_id'] = $row -> invite_from;
							$insertData['count_trip'] = 1;
							$insertData['amount'] = $trip1;
							$this -> Referrals_model -> insertReferralsAmount($insertData);
						} else {
							$count_trip = $details1 -> row() -> count_trip;
							$amount = $amt_check -> row() -> amount;
							$updateKey = array('id' => $row -> id);
							$updateData = array();
							$updateData['count_trip'] = $count_trip + 1;
							$updateData['amount'] = $amount + $trip1;
							$this -> Referrals_model -> updateReferralsAmount($updateKey, $updateData);
						}
					}
				}

				$q = $query1 -> result();
				$row_list = $query1 -> row();
				$iUser_id = $q[0] -> user_id;
				$details2 = $this -> Referrals_model -> get_details_by_Iid($iUser_id);
				$row = $details2 -> row();
				$count = $details2 -> num_rows();
				if ($count > 0) {
					$user = $this -> Users_model -> get_user_by_id($this -> dx_auth -> get_user_id()) -> row();
					$trip1 = $user -> ref_trip;
					$rent1 = $user -> ref_rent;
					$details3 = $this -> Referrals_model -> get_details_refamount($row -> invite_from);
					$amt_check1 = $this -> db -> where('id', $row -> invite_from) -> get('users');
					if ($amt_check1 -> num_rows() == 0) {
						$insertData = array();
						$insertData['user_id'] = $row -> invite_from;
						$insertData['count_book'] = 1;
						$insertData['amount'] = $rent1;
						$this -> Referrals_model -> insertReferralsAmount($insertData);
					} else {
						$count_book = $amt_check1 -> row() -> count_book;
						$amount = $amt_check1 -> row() -> amount;
						$updateKey = array('id' => $row -> id);
						$updateData = array();
						$updateData['count_trip'] = $count_book + 1;
						$updateData['amount'] = $amount + $rent1;
						$this -> Referrals_model -> updateReferralsAmount($updateKey, $updateData);
					}
				}

				$admin_email = $this -> dx_auth -> get_site_sadmin();
				$admin_name = $this -> dx_auth -> get_site_title();

				$query3 = $this -> Common_model -> getTableData('users', array('id' => $list['userby']));
				$rows = $query3 -> row();

				$username = $rows -> username;
				$user_id = $rows -> id;
				$email_id = $rows -> email;

				$query4 = $this -> Users_model -> get_user_by_id($buyer_id);
				$buyer_name = $query4 -> row() -> username;
				$buyer_email = $query4 -> row() -> email;

				//Check md5('No Travel Cretids') || md5('Yes Travel Cretids')
				if ($is_travelCretids == '7c4f08a53f4454ea2a9fdd94ad0c2eeb') {
					$query5 = $this -> Referrals_model -> get_details_refamount($user_id);
					$amount = $query5 -> row() -> amount;

					$updateKey = array('user_id ' => $user_id);
					$updateData = array();
					$updateData['amount'] = $amount - $user_travel_cretids;
					$this -> Referrals_model -> updateReferralsAmount($updateKey, $updateData);

					$list['credit_type'] = 2;
					$list['ref_amount'] = $user_travel_cretids;

					$row = $query4 -> row();

					//sent mail to administrator
					$session_lang = $this->session->userdata('locale');
					if($session_lang == "") {
						$email_name = 'tc_book_to_admin';}
						else { $email_name = 'tc_book_to_admin_'.$session_lang;}
					
					$splVars = array("{site_name}" => $this -> dx_auth -> get_site_title(), "{traveler_name}" => ucfirst($username), "{list_title}" => $row_list -> title, "{book_date}" => date('m/d/Y'), "{book_time}" => date('g:i A'), "{traveler_email_id}" => $email_id, "{checkin}" => date('d-m-Y', $list['checkin']), "{checkout}" => date('d-m-Y', $list['checkout']), "{market_price}" => $user_travel_cretids + $list['price'], "{payed_amount}" => $list['price'], "{travel_credits}" => $user_travel_cretids, "{host_name}" => ucfirst($buyer_name), "{host_email_id}" => $buyer_email);
					//Send Mail
					$this -> Email_model -> sendMail($admin_email, $email_id, ucfirst($username), $email_name, $splVars);

					//sent mail to buyer
					
					if($session_lang == "") {
						$email_name = 'tc_book_to_host';}
						else { $email_name = 'tc_book_to_host_'.$session_lang;}
					$splVars = array("{site_name}" => $this -> dx_auth -> get_site_title(), "{username}" => ucfirst($buyer_name), "{traveler_name}" => ucfirst($username), "{list_title}" => $row_list -> title, "{book_date}" => date('m/d/Y'), "{book_time}" => date('g:i A'), "{traveler_email_id}" => $email_id, "{checkin}" => date('d-m-Y', $list['checkin']), "{checkout}" => date('d-m-Y', $list['checkout']), "{market_price}" => $list['price']);
					//Send Mail
					if ($buyer_email != '0') {
						$this -> Email_model -> sendMail($buyer_email, $admin_email, ucfirst($admin_name), $email_name, $splVars);
					}
				}

				$list['book_date'] = local_to_gmt();

				//Actual insertion into the database
				$this -> Common_model -> insertData('reservation', $list);
				$reservation_id = $this -> db -> insert_id();

				// booktime policy

				$sql_ = "select * from cancellation_policy where id='" . $row_list -> cancellation_policy . "'";
				$query_ = $this -> db -> query($sql_);
				if ($query_ -> num_rows() > 0) {
					$row_cancel = $query_ -> row_array();
					$row_cancel['reservation_id'] = $reservation_id;
					$row_cancel['id'] = '';
					$this -> Common_model -> insertData('booktime_policy', $row_cancel);
				} else {
					$sql_ = "select * from cancellation_policy where id=1";
					$query_ = $this -> db -> query($sql_);
					$row_cancel = $query_ -> row_array();
					$row_cancel['reservation_id'] = $reservation_id;
					$row_cancel['id'] = '';
					$this -> Common_model -> insertData('booktime_policy', $row_cancel);
				}

				// booktime policy

				$reservation_result = $this -> Common_model -> getTableData('reservation', array('id' => $reservation_id)) -> row();

				$currency_symbol = $this -> Common_model -> getTableData('currency', array('currency_code' => $reservation_result -> currency)) -> row() -> currency_symbol;

				$price = $reservation_result -> currency . ' ' . $currency_symbol . $reservation_result -> price;

				$host_price = $reservation_result -> currency . ' ' . $currency_symbol . $reservation_result -> topay;

				if ($interval -> days >= 28) {
					$conversation = $this -> db -> where('userto', $list['userto']) -> where('userby', $list['userby']) -> order_by('id', 'desc') -> get('messages');
					$conversation1 = $this -> db -> where('userto', $list['userby']) -> where('userby', $list['userto']) -> order_by('id', 'desc') -> get('messages');

					if ($conversation -> num_rows() != 0) {
						$conversation_id = $conversation -> row() -> id;
					} elseif ($conversation1 -> num_rows() != 0) {
						$conversation_id = $conversation1 -> row() -> id;
					} else {
						$conversation_id = $reservation_id . '1';
					}

					//Send Message Notification
					$insertData = array('list_id' => $list['list_id'], 'reservation_id' => $reservation_id, 'conversation_id' => $conversation_id, 'userby' => 1, 'userto' => $list['userby'], 'message' => "Your reservation is 28 days or more. So, Long Term cancellation policy applied for " . $row_list -> title, 'created' => local_to_gmt(), 'message_type' => 3);
					$this -> Message_model -> sentMessage($insertData, ucfirst($buyer_name), ucfirst($username), $row_list -> title, $reservation_id);

					//Send Message Notification
					$insertData = array('list_id' => $list['list_id'], 'reservation_id' => $reservation_id, 'conversation_id' => $conversation_id, 'userby' => 1, 'userto' => $list['userto'], 'message' => ucfirst($username) . " reservation is 28 days or more. So, Long Term cancellation policy applied for " . $row_list -> title, 'created' => local_to_gmt(), 'message_type' => 3);
					$this -> Message_model -> sentMessage($insertData, ucfirst($buyer_name), ucfirst($username), $row_list -> title, $reservation_id);

				}
				//Send Message Notification
				$checkindate = date('m/d/Y', $list['checkout']) ;
				$checkoutdate = date('m/d/Y', $list['checkout']) ;
				$user_result_by = $this -> Common_model -> getTableData('profiles', array('id' => $list['userby'])) -> row();
				$user_result_by_host = $this -> Common_model -> getTableData('profiles', array('id' => $list['userto'])) -> row();
				$no_user_by = $user_result_by -> phnum;
				$no_user_by = $user_result_by -> phnum;
						
				$actionurl = site_url('trips/request/' . $reservation_id);


//////////////////////////////////////////////////////// PDF WHILE ACCEPT STARS ///////////////////////////////////////////////////////////////////////////			

if ($instance_book == 1) 
	{
		get_invoice_pdf($reservation_id);
		$invoice = "Invoice-".$reservation_id;
	}
else
	{
	  $invoice = NULL;
	}			

//////////////////////////////////////////////////////// PDF WHILE ACCEPT ENDS ///////////////////////////////////////////////////////////////////////////

						if ($instance_book == 1) {
					$insertData = array('list_id' => $list['list_id'], 'reservation_id' => $reservation_id, 'conversation_id' => $reservation_id, 'userby' => $list['userto'], 'userto' => $list['userby'], 'message' => 'Your reservation is successfully done ', 'created' => local_to_gmt(), 'message_type' => 3);
					$this -> Message_model -> sentMessage($insertData, ucfirst($username), ucfirst($buyer_name), $row_list -> title, $reservation_id);

					//Request sent

					$insertData = array('list_id' => $list['list_id'], 'reservation_id' => $reservation_id, 'conversation_id' => $reservation_id, 'userby' => $list['userto'], 'userto' => $list['userby'], 'message' => 'You have sent a new reservation request to ' . ucfirst($buyer_name), 'created' => local_to_gmt(), 'message_type' => 12);

					$this -> Message_model -> sentMessage($insertData, $isCoversation = 0, ucfirst($username), ucfirst($buyer_name), $row_list -> title, $reservation_id);

					$insertData = array('list_id' => $list['list_id'], 'reservation_id' => $reservation_id, 'conversation_id' => $reservation_id, 'userby' => $list['userby'], 'userto' => $list['userto'], 'message' => 'You have a new reservation request from ' . ucfirst($username), 'created' => local_to_gmt(), 'message_type' => 1);

					
					$session_lang = $this->session->userdata('locale');
					if($session_lang == "") {
					$email_name = 'instant_book_reservation_granted';}
					else { $email_name = 'instant_book_reservation_granted_'.$session_lang;}
					
					$splVars    = array("{site_name}" => $this->dx_auth->get_site_title(), "{traveler_name}" => ucfirst($username), "{list_title}" => $row_list->title);
					$this -> Email_model -> sendMail($email_id, $admin_email, ucfirst($admin_name), $email_name, $splVars, NULL, NULL, NULL, $invoice);
					
				////////////////////// send sms to guest /////////
					if($no_user_by != '')
					{
					$msg_content = "Your reservation is successfully done for the listing " . $row_list -> title . " ( " . $checkindate . " - " . $checkoutdate . " )";
					send_sms_user($no_user_by, $msg_content);
					}
				////////////////////// send sms to guest /////////
				
					} else {
					//Request sent

					$insertData = array('list_id' => $list['list_id'], 'reservation_id' => $reservation_id, 'conversation_id' => $reservation_id, 'userby' => $list['userto'], 'userto' => $list['userby'], 'message' => 'You have sent a new reservation request to ' . ucfirst($buyer_name), 'created' => local_to_gmt(), 'message_type' => 12);
					$this -> Message_model -> sentMessage($insertData, $isCoversation = 0, ucfirst($username), ucfirst($buyer_name), $row_list -> title, $reservation_id);

					$insertData = array('list_id' => $list['list_id'], 'reservation_id' => $reservation_id, 'userby' => $list['userby'], 'userto' => $list['userto'], 'message' => 'You have a new reservation request from ' . ucfirst($username), 'created' => local_to_gmt(), 'message_type' => 1);
					$this -> Message_model -> sentMessage($insertData, ucfirst($buyer_name), ucfirst($username), $row_list -> title, $reservation_id);
					
					////////////////////// send sms to guest /////////
					if($no_user_by != '')
					{
					$msg_content = "You have sent a new reservation request to " . ucfirst($buyer_name) . " for the listing " . $row_list -> title . " ( " . $checkindate . " - " . $checkoutdate . " )";
					send_sms_user($no_user_by, $msg_content);
					}
					////////////////////// send sms to guest /////////	
					
										//Reservation Notification To Traveller
					
					if($session_lang == "") {
					$email_name = 'traveller_reservation_notification';}
					else { $email_name = 'traveller_reservation_notification_'.$session_lang;}
					$splVars = array("{site_name}" => $this -> dx_auth -> get_site_title(), "{traveler_name}" => ucfirst($username));
					//Send Mail
					$this -> Email_model -> sendMail($email_id, $admin_email, ucfirst($admin_name), $email_name, $splVars, NULL, NULL, NULL, $invoice);
					
							
					}
				
				////////////////////// common for instant and normal booking - send sms to Host /////////
					if($no_user_by_host != '')
					{
					$msg_content_host = 'You have a new reservation request from ' . ucfirst($username) . " forthe listing" . $row_list -> title . " ( " . $checkindate . " - " . $checkoutdate . " )";
					send_sms_user($no_user_by_host, $msg_content_host);
					}
				////////////////////// send sms to Host /////////
		
		
				//Reservation Notification To Host
				$session_lang = $this->session->userdata('locale');
				if($session_lang == "") {
					$email_name = 'host_reservation_notification';}
					else { $email_name = 'host_reservation_notification_'.$session_lang;}
				
				$splVars = array("{site_name}" => $this -> dx_auth -> get_site_title(), "{username}" => ucfirst($buyer_name), "{traveler_name}" => ucfirst($username), "{list_title}" => $row_list -> title, "{book_date}" => date('m/d/Y'), "{book_time}" => date('g:i A', time()), "{traveler_email_id}" => $email_id, "{checkin}" => date('m/d/Y', $list['checkin']), "{checkout}" => date('m/d/Y', $list['checkout']), "{market_price}" => $host_price, "{action_url}" => $actionurl);

				//Send Mail
				//
				if ($buyer_email != '0') {
					$this -> Email_model -> sendMail($buyer_email, $admin_email, ucfirst($admin_name), $email_name, $splVars, NULL, NULL, NULL, NULL);
				}
				
					//Reservation Notification To Administrator
					if($session_lang == "") {
					$email_name = 'admin_reservation_notification';}
					else { $email_name = 'admin_reservation_notification_'.$session_lang;}
					
					$splVars = array("{site_name}" => $this -> dx_auth -> get_site_title(), "{traveler_name}" => ucfirst($username), "{list_title}" => $row_list -> title, "{book_date}" => date('m/d/Y'), "{book_time}" => date('g:i A', time()), "{traveler_email_id}" => $email_id, "{checkin}" => date('m/d/Y', $list['checkin']), "{checkout}" => date('m/d/Y', $list['checkout']), "{market_price}" => $price, "{payed_amount}" => $price, "{travel_credits}" => $user_travel_cretids, "{host_name}" => ucfirst($buyer_name), "{host_email_id}" => $buyer_email);
					//Send Mail
					$this -> Email_model -> sendMail($admin_email, $email_id, ucfirst($username), $email_name, $splVars, NULL, NULL, NULL, NULL);
				

				$referral_amount = $this -> db -> where('id', $this -> dx_auth -> get_user_id()) -> get('users') -> row() -> referral_amount;
				if ($referral_amount > $ref_total) {
					$this -> db -> set('referral_amount', $referral_amount - $ref_total) -> where('id', $this -> dx_auth -> get_user_id()) -> update('users');
				}

				if ($this -> session -> userdata('call_back') == 'mobile') {
					$message_element = 'payments/paypal_success_mobile';
				} else {

					// Advertisement popup 2 start
					$data['PagePopupContent'] = GetPagePopupContent('step4');
					// Advertisement popup 2 end

					$message_element = 'payments/paypal_success';
				}

				$data['title'] = "Payment Success !";
				$data['message_element'] = $message_element;
				$this -> load -> view('template', $data);

			} else {
				$this -> _error($do_ec_return);
			}
		} else {
			$this -> _error($get_ec_return);
		}
	}

	function charge() {

		$currency_code = $this -> session -> userdata('currency_code_payment');
		if ($currency_code == 'INR' || $currency_code == 'MYR' || $currency_code == 'ARS' || $currency_code == 'CNY' || $currency_code == 'IDR' || $currency_code == 'KRW' || $currency_code == 'VND' || $currency_code == 'ZAR') {
			$currency_code = 'USD';
			//$currency_code = $this->session->userdata('booking_currency_symbol');
			$amt = get_currency_value_lys($currency_code, $currency_code, $amt);
		} else {
			//$currency_code = $this->session->userdata('booking_currency_symbol');
			$currency_code = $currency_code;
			$amt = $amt;
		}

		$data['secret_key'] = $this -> stripe_secret;
		//$data['publishable_key'] = $this->stripe_pub;

		Stripe::setApiKey($data['secret_key']);

		if ($_POST) {

			$error = NULL;
			try {

				if (isset($_POST['customer_id'])) {

					$charge = Stripe_Charge::create(array('customer' => $_POST['customer_id'], 'amount' => $_POST['total_amount'] * 100, 'currency' => 'usd', 'description' => 'Single quote purchase after login'));
				} else if (isset($_POST['stripeToken'])) {
					$charge = Stripe_Charge::create(array('card' => $_POST['stripeToken'], 'amount' => $_POST['total_amount'], 'currency' => 'usd'));

				} else {
					throw new Exception("The Stripe Token or customer was not generated correctly");
				}

			} catch (Exception $e) {
				$error = $e -> getMessage();
			}

			if ($error == NULL) {

				//echo "sucess";

				$custom = $this -> session -> userdata('custom');
				$data = array();
				$list = array();
				$data = explode('@', $custom);
				//print_r($data);exit;
				$contact_key = $data[9];

				$list['list_id'] = $data[0];
				$list['userby'] = $data[1];

				$query1 = $this -> Common_model -> getTableData('list', array('id' => $list['list_id']));

				$buyer_id = $query1 -> row() -> user_id;

				$list['userto'] = $buyer_id;
				$list['checkin'] = $data[2];
				$list['checkout'] = $data[3];
				$list['no_quest'] = $data[4];

				$list['extra_guest_price'] = $data[12];

				$date1 = new DateTime(date('Y-m-d H:i:s', $list['checkin']));
				$date2 = new DateTime(date('Y-m-d H:i:s', $list['checkout']));
				$interval = $date1 -> diff($date2);

				if ($interval -> days >= 28) {
					$list['policy'] = 5;
				} else {
					$list['policy'] = $query1 -> row() -> cancellation_policy;
				}


				$list['payment_id'] = 4;
				$list['transaction_id'] = $charge -> id;
				$amt = $data[14];

				$list['price'] = $data[14]; // total amount
				$currency = $data[15];
				$list['credit_type'] = 1;
				$is_travelCretids = $data[5];
				$user_travel_cretids = $data[6];

				$list['currency'] = $currency;
				$list['admin_commission'] = $data[8]; // admin commission
				$list['cleaning'] = $data[10];
				$list['security'] = $data[11];
				$list['topay'] =  $data[7]; /// sub total
				$list['per_night_price'] =  $data[16]; /// per night list price

				$list['guest_count'] = $data[13];
				$list['coupon'] = $data[18];
				$list['coupon_amt'] = $data[19];  /// coupon amount
				
				$seasonal_status = $data[20];
				if($seasonal_status != "" && $seasonal_status != "no")
				{
				$list['seasonal_dates_price'] = $data[21];	/// seasonal dates and its prices				
				}else{
				$list['seasonal_dates_price'] = 0;				
				}
				$list['base_price'] = $data[22];  /// base price { per night x days along with seasonal prices}
				
				
				if ($list['no_quest'] > $list['guest_count']) {
						$list['extra_guest_price'] = $data[12];
				}

				if ($contact_key != '' && $contact_key != "None") {
					$updateKey = array('contact_key' => $contact_key);
					$updateData = array();
					$updateData['status'] = 10;
					$list['contacts_offer'] = $this -> session -> userdata('contacts_offer');
					$this -> Contacts_model -> update_contact($updateKey, $updateData);
					
					$list['status'] = 1;
					$this -> db -> select_max('group_id');
					$group_id = $this -> db -> get('calendar') -> row() -> group_id;

						if(empty($group_id))
						{
							$countJ = 0;
						} else{
							 $countJ = $group_id;
						}

					$insertData['list_id'] = $list['list_id'];
					$insertData['group_id'] = $countJ + 1;
					$insertData['availability'] = 'Booked';
					$insertData['booked_using'] = 'Other';

					$checkin = date('m/d/Y', $list['checkin']);
					$checkout = date('m/d/Y', $list['checkout']);

					$days = getDaysInBetween($checkin, $checkout);

					$count = count($days);
					$i = 1;
					$listid1 = $list['list_id'];
					$instance_book = $this -> db -> where('id', $listid1) -> get('list') -> row() -> instance_book;
					//echo $this->db->last_query();
					if ($instance_book == 1) {
						foreach ($days as $val) {
							if ($count == 1) {
								$insertData['style'] = 'single';
							} else if ($count > 1) {
								if ($i == 1) {
									$insertData['style'] = 'left';
								} else if ($count == $i) {
									$insertData['notes'] = '';
									$insertData['style'] = 'right';
								} else {
									$insertData['notes'] = '';
									$insertData['style'] = 'both';
								}
							}
							$insertData['booked_days'] = $val;
							$this -> Trips_model -> insert_calendar($insertData);
							$i++;
						}
					}
					
					
				} else {
					$listid1 = $list['list_id'];
					$instance_book = $this -> db -> where('id', $listid1) -> get('list') -> row() -> instance_book;
					if ($instance_book == 1) {
						$list['status'] = 3;
					} else {
						$list['status'] = 1;
					}

				}
				if ($list['price'] > 75) {
					$user_id = $list['userby'];
					$details = $this -> Referrals_model -> get_details_by_Iid($user_id);
					$row = $details -> row();
					$count = $details -> num_rows();
					if ($count > 0) {
						$details1 = $this -> Referrals_model -> get_details_refamount($row -> invite_from);
						if ($details1 -> num_rows() == 0) {
							$insertData = array();
							$insertData['user_id'] = $row -> invite_from;
							$insertData['count_trip'] = 1;
							$insertData['amount'] = 25;
							$this -> Referrals_model -> insertReferralsAmount($insertData);
						} else {
							$count_trip = $details1 -> row() -> count_trip;
							$amount = $details1 -> row() -> amount;
							$updateKey = array('id' => $row -> id);
							$updateData = array();
							$updateData['count_trip'] = $count_trip + 1;
							$updateData['amount'] = $amount + 25;
							$this -> Referrals_model -> updateReferralsAmount($updateKey, $updateData);
						}
					}
				}

				$q = $query1 -> result();
				$row_list = $query1 -> row();
				$iUser_id = $q[0] -> user_id;
				$details2 = $this -> Referrals_model -> get_details_by_Iid($iUser_id);
				$row = $details2 -> row();
				$count = $details2 -> num_rows();
				if ($count > 0) {
					$details3 = $this -> Referrals_model -> get_details_refamount($row -> invite_from);
					if ($details3 -> num_rows() == 0) {
						$insertData = array();
						$insertData['user_id'] = $row -> invite_from;
						$insertData['count_book'] = 1;
						$insertData['amount'] = 75;
						$this -> Referrals_model -> insertReferralsAmount($insertData);
					} else {
						$count_book = $details3 -> row() -> count_book;
						$amount = $details3 -> row() -> amount;
						$updateKey = array('id' => $row -> id);
						$updateData = array();
						$updateData['count_trip'] = $count_book + 1;
						$updateData['amount'] = $amount + 75;
						$this -> Referrals_model -> updateReferralsAmount($updateKey, $updateData);
					}
				}

				$admin_email = $this -> dx_auth -> get_site_sadmin();
				$admin_name = $this -> dx_auth -> get_site_title();

				$query3 = $this -> Common_model -> getTableData('users', array('id' => $list['userby']));
				$rows = $query3 -> row();

				$username = $rows -> username;
				$user_id = $rows -> id;
				$email_id = $rows -> email;

				$query4 = $this -> Users_model -> get_user_by_id($buyer_id);
				$buyer_name = $query4 -> row() -> username;
				$buyer_email = $query4 -> row() -> email;

				//Check md5('No Travel Cretids') || md5('Yes Travel Cretids')
				if ($is_travelCretids == '7c4f08a53f4454ea2a9fdd94ad0c2eeb') {
					$query5 = $this -> Referrals_model -> get_details_refamount($user_id);
					$amount = $query5 -> row() -> amount;

					$updateKey = array('user_id ' => $user_id);
					$updateData = array();
					$updateData['amount'] = $amount - $user_travel_cretids;
					$this -> Referrals_model -> updateReferralsAmount($updateKey, $updateData);

					$list['credit_type'] = 1;
					$list['ref_amount'] = $user_travel_cretids;

					$row = $query4 -> row();

					//sent mail to administrator
					$session_lang = $this->session->userdata('locale');
					if($session_lang == "") {
					$email_name = 'tc_book_to_admin';}
					else {$email_name = 'tc_book_to_admin_'.$session_lang;}
					$splVars = array("{site_name}" => $this -> dx_auth -> get_site_title(), "{traveler_name}" => ucfirst($username), "{list_title}" => $row_list -> title, "{book_date}" => date('m/d/Y'), "{book_time}" => date('g:i A'), "{traveler_email_id}" => $email_id, "{checkin}" => date('d-m-Y', $list['checkin']), "{checkout}" => date('d-m-Y', $list['checkout']), "{market_price}" => $user_travel_cretids + $list['price'], "{payed_amount}" => $list['price'], "{travel_credits}" => $user_travel_cretids, "{host_name}" => ucfirst($buyer_name), "{host_email_id}" => $buyer_email);
					//Send Mail
					$this -> Email_model -> sendMail($admin_email, $email_id, ucfirst($username), $email_name, $splVars);

					//sent mail to buyer
					if($session_lang == "") {
					$email_name = 'tc_book_to_admin';}
					else {$email_name = 'tc_book_to_admin_'.$session_lang;}
					$splVars = array("{site_name}" => $this -> dx_auth -> get_site_title(), "{username}" => ucfirst($buyer_name), "{traveler_name}" => ucfirst($username), "{list_title}" => $row_list -> title, "{book_date}" => date('m/d/Y'), "{book_time}" => date('g:i A'), "{traveler_email_id}" => $email_id, "{checkin}" => date('d-m-Y', $list['checkin']), "{checkout}" => date('d-m-Y', $list['checkout']), "{market_price}" => $list['price']);
					//Send Mail
					if ($buyer_email != '0') {
						$this -> Email_model -> sendMail($buyer_email, $admin_email, ucfirst($admin_name), $email_name, $splVars);
					}
				}

				$list['book_date'] = local_to_gmt();

				if ($this -> session -> userdata('coupon_code_used') == 1) {
					$list['coupon'] = $this -> session -> userdata('coupon_code');
					$this -> session -> unset_userdata('coupon_code');
					$this -> session -> unset_userdata('coupon_code_used');
				} else {
					$list['coupon'] = 0;
				}

				//Actual insertion into the database
				$this -> Common_model -> insertData('reservation', $list);
				$reservation_id = $this -> db -> insert_id();

				$reservation_result = $this -> Common_model -> getTableData('reservation', array('id' => $reservation_id)) -> row();

				$currency_symbol = $this -> Common_model -> getTableData('currency', array('currency_code' => $reservation_result -> currency)) -> row() -> currency_symbol;

				$price = $reservation_result -> currency . ' ' . $currency_symbol . $reservation_result -> price;

				$host_price = $reservation_result -> currency . ' ' . $currency_symbol . $reservation_result -> topay;

				if ($interval -> days >= 28) {
					$conversation = $this -> db -> where('userto', $list['userto']) -> where('userby', $list['userby']) -> order_by('id', 'desc') -> get('messages');
					$conversation1 = $this -> db -> where('userto', $list['userby']) -> where('userby', $list['userto']) -> order_by('id', 'desc') -> get('messages');

					if ($conversation -> num_rows() != 0) {
						$conversation_id = $conversation -> row() -> id;
					} elseif ($conversation1 -> num_rows() != 0) {
						$conversation_id = $conversation1 -> row() -> id;
					} else {
						$conversation_id = $reservation_id . '1';
					}

					//Send Message Notification
					$insertData = array('list_id' => $list['list_id'], 'reservation_id' => $reservation_id, 'conversation_id' => $conversation_id, 'userby' => 1, 'userto' => $list['userby'], 'message' => "Your reservation is 28 days or more. So, Long Term cancellation policy applied for " . $row_list -> title, 'created' => local_to_gmt(), 'message_type' => 3);
					$this -> Message_model -> sentMessage($insertData, ucfirst($buyer_name), ucfirst($username), $row_list -> title, $reservation_id);

					//Send Message Notification
					$insertData = array('list_id' => $list['list_id'], 'reservation_id' => $reservation_id, 'conversation_id' => $conversation_id, 'userby' => 1, 'userto' => $list['userto'], 'message' => ucfirst($username) . " reservation is 28 days or more. So, Long Term cancellation policy applied for " . $row_list -> title, 'created' => local_to_gmt(), 'message_type' => 3);
					$this -> Message_model -> sentMessage($insertData, ucfirst($buyer_name), ucfirst($username), $row_list -> title, $reservation_id);

				}

				//Send Message Notification
				$checkindate = date('m/d/Y', $list['checkout']) ;
				$checkoutdate = date('m/d/Y', $list['checkout']) ;
				$user_result_by = $this -> Common_model -> getTableData('profiles', array('id' => $list['userby'])) -> row();
				$user_result_by_host = $this -> Common_model -> getTableData('profiles', array('id' => $list['userto'])) -> row();
				$no_user_by = $user_result_by -> phnum;
				$no_user_by = $user_result_by -> phnum;
						
				$actionurl = site_url('trips/request/' . $reservation_id);

$listid1 = $list['list_id'];
$instance_book = $this -> db -> where('id', $listid1) -> get('list') -> row() -> instance_book;

//////////////////////////////////////////////////////// PDF WHILE ACCEPT STARS ///////////////////////////////////////////////////////////////////////////			

if ($instance_book == 1) 
	{
		get_invoice_pdf($reservation_id);
		$invoice = "Invoice-".$reservation_id;
	}
else
	{
	  $invoice = NULL;
	}			

//////////////////////////////////////////////////////// PDF WHILE ACCEPT ENDS ///////////////////////////////////////////////////////////////////////////			

				if ($instance_book == 1) {
					$insertData = array('list_id' => $list['list_id'], 'reservation_id' => $reservation_id, 'conversation_id' => $reservation_id, 'userby' => $list['userto'], 'userto' => $list['userby'], 'message' => 'Your reservation is successfully done ', 'created' => local_to_gmt(), 'message_type' => 3);
					$this -> Message_model -> sentMessage($insertData, ucfirst($username), ucfirst($buyer_name), $row_list -> title, $reservation_id);

					//Request sent

					$insertData = array('list_id' => $list['list_id'], 'reservation_id' => $reservation_id, 'conversation_id' => $reservation_id, 'userby' => $list['userto'], 'userto' => $list['userby'], 'message' => 'You have sent a new reservation request to ' . ucfirst($buyer_name), 'created' => local_to_gmt(), 'message_type' => 12);

					$this -> Message_model -> sentMessage($insertData, $isCoversation = 0, ucfirst($username), ucfirst($buyer_name), $row_list -> title, $reservation_id);

					$insertData = array('list_id' => $list['list_id'], 'reservation_id' => $reservation_id, 'conversation_id' => $reservation_id, 'userby' => $list['userby'], 'userto' => $list['userto'], 'message' => 'You have a new reservation request from ' . ucfirst($username), 'created' => local_to_gmt(), 'message_type' => 1);
				

				////////////////////// send sms to guest /////////
					if($no_user_by != '')
					{
					$msg_content = "Your reservation is successfully done for the listing " . $row_list -> title . " ( " . $checkindate . " - " . $checkoutdate . " )";
					send_sms_user($no_user_by, $msg_content);
					}
				////////////////////// send sms to guest /////////
									$session_lang = $this->session->userdata('locale');
					if($session_lang == "") {
					$email_name = 'instant_book_reservation_granted';}
					else { $email_name = 'instant_book_reservation_granted_'.$session_lang;}

					$splVars    = array("{site_name}" => $this->dx_auth->get_site_title(), "{traveler_name}" => ucfirst($username), "{list_title}" => $row_list->title);					
					$this -> Email_model -> sendMail($email_id, $admin_email, ucfirst($admin_name), $email_name, $splVars, NULL, NULL, NULL, $invoice);
				
					} else {
					//Request sent

					$insertData = array('list_id' => $list['list_id'], 'reservation_id' => $reservation_id, 'conversation_id' => $reservation_id, 'userby' => $list['userto'], 'userto' => $list['userby'], 'message' => 'You have sent a new reservation request to ' . ucfirst($buyer_name), 'created' => local_to_gmt(), 'message_type' => 12);
					$this -> Message_model -> sentMessage($insertData, $isCoversation = 0, ucfirst($username), ucfirst($buyer_name), $row_list -> title, $reservation_id);

					$insertData = array('list_id' => $list['list_id'], 'reservation_id' => $reservation_id, 'userby' => $list['userby'], 'userto' => $list['userto'], 'message' => 'You have a new reservation request from ' . ucfirst($username), 'created' => local_to_gmt(), 'message_type' => 1);
					$this -> Message_model -> sentMessage($insertData, ucfirst($buyer_name), ucfirst($username), $row_list -> title, $reservation_id);
					
					////////////////////// send sms to guest /////////
					if($no_user_by != '')
					{
					$msg_content = "You have sent a new reservation request to " . ucfirst($buyer_name) . " for the listing " . $row_list -> title . " ( " . $checkindate . " - " . $checkoutdate . " )";
					send_sms_user($no_user_by, $msg_content);
					}
					////////////////////// send sms to guest /////////
					
									//Reservation Notification To Traveller
				if($session_lang == "") {
					$email_name = 'traveller_reservation_notification';}
					else {$email_name = 'traveller_reservation_notification_'.$session_lang;}
				
				$splVars = array("{site_name}" => $this -> dx_auth -> get_site_title(), "{traveler_name}" => ucfirst($username));
				//Send Mail
				$this -> Email_model -> sendMail($email_id, $admin_email, ucfirst($admin_name), $email_name, $splVars, NULL, NULL, NULL, $invoice);
					
								
					}
					
////////////////////// common for instant and normal booking - send sms to Host /////////
					if($no_user_by_host != '')
					{
					$msg_content_host = 'You have a new reservation request from ' . ucfirst($username) . " forthe listing" . $row_list -> title . " ( " . $checkindate . " - " . $checkoutdate . " )";
					send_sms_user($no_user_by_host, $msg_content_host);
					}
				////////////////////// send sms to Host /////////


				//Reservation Notification To Host
				$session_lang = $this->session->userdata('locale');
				if($session_lang == "") {
					$email_name = 'host_reservation_notification';}
					else {$email_name = 'host_reservation_notification_'.$session_lang;}
				
				$splVars = array("{site_name}" => $this -> dx_auth -> get_site_title(), "{username}" => ucfirst($buyer_name), "{traveler_name}" => ucfirst($username), "{list_title}" => $row_list -> title, "{book_date}" => date('m/d/Y'), "{book_time}" => date('g:i A', time()), "{traveler_email_id}" => $email_id, "{checkin}" => date('m/d/Y', $list['checkin']), "{checkout}" => date('m/d/Y', $list['checkout']), "{market_price}" => $host_price, "{action_url}" => $actionurl);
						
				//Send Mail
				//
				if ($buyer_email != '0') {
					$this -> Email_model -> sendMail($buyer_email, $admin_email, ucfirst($admin_name), $email_name, $splVars, NULL, NULL, NULL, NULL);
				}

				//Reservation Notification To Administrator
				if($session_lang == "") {
					$email_name = 'admin_reservation_notification';}
					else {$email_name = 'admin_reservation_notification_'.$session_lang;}
					
				$splVars = array("{site_name}" => $this -> dx_auth -> get_site_title(), "{traveler_name}" => ucfirst($username), "{list_title}" => $row_list -> title, "{book_date}" => date('m/d/Y'), "{book_time}" => date('g:i A', time()), "{traveler_email_id}" => $email_id, "{checkin}" => date('m/d/Y', $list['checkin']), "{checkout}" => date('m/d/Y', $list['checkout']), "{market_price}" => $price, "{payed_amount}" => $list['price'], "{travel_credits}" => $user_travel_cretids, "{host_name}" => ucfirst($buyer_name), "{host_email_id}" => $buyer_email);
				//Send Mail
				$this -> Email_model -> sendMail($admin_email, $email_id, ucfirst($username), $email_name, $splVars, NULL, NULL, NULL, NULL);


				$referral_amount = $this -> db -> where('id', $this -> dx_auth -> get_user_id()) -> get('users') -> row() -> referral_amount;
				if ($referral_amount > 100) {
					$this -> db -> set('referral_amount', $referral_amount - 100) -> where('id', $this -> dx_auth -> get_user_id()) -> update('users');
				} else {
					$this -> db -> set('referral_amount', 0) -> where('id', $this -> dx_auth -> get_user_id()) -> update('users');
				}

				// Advertisement popup 2 start
				$data['PagePopupContent'] = GetPagePopupContent('step4');
				// Advertisement popup 2 end

				$message_element = 'payments/paypal_success';

				$data['title'] = "Payment Success !";
				$data['message_element'] = $message_element;
				$this -> load -> view('template', $data);

			} else {
				$data['title'] = "Payment Cancelled !";
				$data['content'] = $error;
				$data['message_element'] = "payments/paypal_cancel";
				$this -> load -> view('template', $data);

			}

		}
	}

	function test() {
		$checkin = date('m/d/Y', '1413763200');
		$checkout = date('m/d/Y', '1413849600');
		$days = getDaysInBetween($checkin, $checkout);

		$count = count($days);
		$i = 1;
		foreach ($days as $val) {
			if ($count == 1) {
				$insertData1['style'] = 'single';
			} else if ($count > 1) {
				if ($i == 1) {
					$insertData1['style'] = 'left';
				} else if ($count == $i) {
					$insertData1['notes'] = '';
					$insertData1['style'] = 'right';
				} else {
					$insertData1['notes'] = '';
					$insertData1['style'] = 'both';
				}
			}
			$insertData1['booked_days'] = $val;
			echo $val;
		}
	}

	function braintree_success() {
		$nonce = $_POST['payment_method_nonce'];
		$result = Braintree_Customer::create(array('paymentMethodNonce' => $nonce));
		$custom = $this -> session -> userdata('custom');
		$comment = $this->session->userdata('comment');
		$data = array();
		$list = array();
		$data = explode('@', $custom);
		$transaction = 0;
		
		if ($result -> success) {
			$customer_id = $result -> customer -> id;
		}else{
		$customer_id = 0 ;	
		}
		if ($result -> success) {
			$custom = $this -> session -> userdata('custom');

			$data = array();
			$list = array();
			$data = explode('@', $custom);

			$contact_key = $data[9];
			$currency = $data[15];
			$list['list_id'] = $data[0];
			
			$instance_book = $this -> db -> where('id', $list['list_id']) -> get('list') -> row() -> instance_book;
			//echo $this->db->last_query();
			if ($instance_book == 1) {
				
				if($currency != "USD")
				{
				$amount_braintree  = get_currency_value_lys($currency, 'USD', $data[14]);	
				}else{
				$amount_braintree  = $data[14];	
				}
				if($customer_id != 0)
				{
			$result = Braintree_Transaction::sale(array('amount' => $amount_braintree, 'customerId' => $customer_id, 'options' => array('submitForSettlement' => true)));
			$transaction = $result->transaction-> id;				
			if($transaction == "")
			{
				$transaction = 0 ;
			}
			
				}
				 //echo '<pre>';
				//print_r($result);
				// exit;				
				//print_r($transaction);exit;
			} else {
				$transaction = 0;
				$list['cc_cusid'] = $customer_id;
			}
//echo $transaction ;exit;
			$contact_key = $data[9];

			$list['list_id'] = $data[0];
			$list['userby'] = $data[1];

			$query1 = $this -> Common_model -> getTableData('list', array('id' => $list['list_id']));
			$buyer_id = $query1 -> row() -> user_id;

			$list['userto'] = $buyer_id;
			$list['checkin'] = $data[2];
			$list['checkout'] = $data[3];
			$list['no_quest'] = $data[4];
			$date1 = new DateTime(date('Y-m-d H:i:s', $list['checkin']));
			$date2 = new DateTime(date('Y-m-d H:i:s', $list['checkout']));
			$interval = $date1 -> diff($date2);
			if ($interval -> days >= 28) {
				$list['policy'] = 5;
			} else {
				$list['policy'] = $query1 -> row() -> cancellation_policy;
			}

			$amt = $data[14];
			$list['transaction_id'] = $transaction;
			
				$list['payment_id'] = 1;
				$list['credit_type'] = 1;
				$list['price'] = $data[14]; // total amount
				$currency = $data[15];
				$list['credit_type'] = 1;
				$is_travelCretids = $data[5];
				$user_travel_cretids = $data[6];

				$list['currency'] = $currency;
				$list['admin_commission'] = $data[8]; // admin commission
				$list['cleaning'] = $data[10];
				$list['security'] = $data[11];
				$list['topay'] =  $data[7]; /// sub total
				$list['per_night_price'] =  $data[16]; /// per night list price

				$list['guest_count'] = $data[13];
				$list['coupon'] = $data[18];
				$list['coupon_amt'] = $data[19];  /// coupon amount
				
				$seasonal_status = $data[20];
				if($seasonal_status != "" && $seasonal_status != "no")
				{
				$list['seasonal_dates_price'] = $data[21];	/// seasonal dates and its prices				
				}else{
				$list['seasonal_dates_price'] = 0;				
				}
				$list['base_price'] = $data[22]; /// base price { per night x days along with seasonal prices}
				
				
				if ($list['no_quest'] > $list['guest_count']) {
						$list['extra_guest_price'] = $data[12];
				}

				if ($contact_key != '' && $contact_key != "None") {
					$updateKey = array('contact_key' => $contact_key);
					$updateData = array();
					$updateData['status'] = 10;
					$list['contacts_offer'] = $this -> session -> userdata('contacts_offer');
					$this -> Contacts_model -> update_contact($updateKey, $updateData);
					
					$list['status'] = 1;
					$this -> db -> select_max('group_id');
					$group_id = $this -> db -> get('calendar') -> row() -> group_id;

						if(empty($group_id))
						{
							$countJ = 0;
						} else{
							 $countJ = $group_id;
						}

					$insertData['list_id'] = $list['list_id'];
					$insertData['group_id'] = $countJ + 1;
					$insertData['availability'] = 'Booked';
					$insertData['booked_using'] = 'Other';

					$checkin = date('m/d/Y', $list['checkin']);
					$checkout = date('m/d/Y', $list['checkout']);

					$days = getDaysInBetween($checkin, $checkout);
					$count = count($days);
					$i = 1;
					$listid1 = $list['list_id'];
					$instance_book = $this -> db -> where('id', $listid1) -> get('list') -> row() -> instance_book;
					//echo $this->db->last_query();
					if ($instance_book == 1) {
						foreach ($days as $val) {
							if ($count == 1) {
								$insertData['style'] = 'single';
							} else if ($count > 1) {
								if ($i == 1) {
									$insertData['style'] = 'left';
								} else if ($count == $i) {
									$insertData['notes'] = '';
									$insertData['style'] = 'right';
								} else {
									$insertData['notes'] = '';
									$insertData['style'] = 'both';
								}
							}
							$insertData['booked_days'] = $val;
							$this -> Trips_model -> insert_calendar($insertData);
							$i++;
						}
					}
					
					
				} else {
					$listid1 = $list['list_id'];
					$instance_book = $this -> db -> where('id', $listid1) -> get('list') -> row() -> instance_book;
					if ($instance_book == 1) {
						$list['status'] = 3;
					} else {
						$list['status'] = 1;
					}

				}

			if ($list['price'] > $rent) {
				$user_id = $list['userby'];
				$details = $this -> Referrals_model -> get_details_by_Iid($user_id);
				$row = $details -> row();
				$count = $details -> num_rows();
				if ($count > 0) {
					$details1 = $this -> Referrals_model -> get_details_refamount($row -> invite_from);
					$amt_check2 = $this -> db -> where('id', $row -> invite_from) -> get('users');
					$user = $this -> Users_model -> get_user_by_id($this -> dx_auth -> get_user_id()) -> row();
					$trip1 = $user -> ref_trip;
					$rent1 = $user -> ref_rent;
					if ($amt_check2 -> num_rows() == 0) {
						$insertData = array();
						$insertData['user_id'] = $row -> invite_from;
						$insertData['count_trip'] = 1;
						$insertData['amount'] = $trip1;
						$this -> Referrals_model -> insertReferralsAmount($insertData);
					} else {
						$count_trip = $amt_check2 -> row() -> count_trip;
						$amount = $amt_check2 -> row() -> amount;
						$updateKey = array('id' => $row -> id);
						$updateData = array();
						$updateData['count_trip'] = $count_trip + 1;
						$updateData['amount'] = $amount + $trip1;
						$this -> Referrals_model -> updateReferralsAmount($updateKey, $updateData);
					}
				}
			}

			$iUser_id = $buyer_id;
			
			$details2 = $this -> Referrals_model -> get_details_by_Iid($iUser_id);
			$row = $details2 -> row();
			$count = $details2 -> num_rows();
			if ($count > 0) {
				$user = $this -> Users_model -> get_user_by_id($this -> dx_auth -> get_user_id()) -> row();
				$trip1 = $user -> ref_trip;
				$rent1 = $user -> ref_rent;
				$details3 = $this -> Referrals_model -> get_details_refamount($row -> invite_from);
				$amt_check3 = $this -> db -> where('id', $row -> invite_from) -> get('users');
				if ($amt_check3 -> num_rows() == 0) {
					$insertData = array();
					$insertData['user_id'] = $row -> invite_from;
					$insertData['count_book'] = 1;
					$insertData['amount'] = $rent1;
					$this -> Referrals_model -> insertReferralsAmount($insertData);
				} else {
					$count_book = $amt_check3 -> row() -> count_book;
					$amount = $amt_check3 -> row() -> amount;
					$updateKey = array('id' => $row -> id);
					$updateData = array();
					$updateData['count_trip'] = $count_book + 1;
					$updateData['amount'] = $amount + $rent1;
					$this -> Referrals_model -> updateReferralsAmount($updateKey, $updateData);
				}
			}
			 $admin_email = $this -> dx_auth -> get_site_sadmin();
			 $admin_name = $this -> dx_auth -> get_site_title();

			$query3 = $this -> Common_model -> getTableData('users', array('id' => $list['userby']));
			$rows = $query3 -> row();

			 $username = $rows -> username;
			 $user_id = $rows -> id;
			 $email_id = $rows -> email;
			$query4 = $this -> Common_model -> getTableData('users', array('id' => $buyer_id));
			 $buyer_name = $query4 -> row() -> username;
			 $buyer_email = $query4 -> row() -> email;
			//Check md5('No Travel Cretids') || md5('Yes Travel Cretids')
			if ($is_travelCretids == '7c4f08a53f4454ea2a9fdd94ad0c2eeb') {
				$query5 = $this -> Referrals_model -> get_details_refamount($user_id);
				$amount = $query5 -> row() -> amount;

				$updateKey = array('user_id ' => $user_id);
				$updateData = array();
				$updateData['amount'] = $amount - $user_travel_cretids;
				$this -> Referrals_model -> updateReferralsAmount($updateKey, $updateData);

				$list['credit_type'] = 2;
				$list['ref_amount'] = $user_travel_cretids;

				$row = $query4 -> row();
				$session_lang = $this->session->userdata('locale');
				if($session_lang == "") {
				//sent mail to administrator
				$email_name = 'tc_book_to_admin';} 
				else {$email_name = 'tc_book_to_admin_'.$session_lang;}
				$splVars = array("{site_name}" => $this -> dx_auth -> get_site_title(), "{traveler_name}" => ucfirst($username), "{list_title}" => $row_list -> title, "{book_date}" => date('m/d/Y'), "{book_time}" => date('g:i A'), "{traveler_email_id}" => $email_id, "{checkin}" => date('d-m-Y', $list['checkin']), "{checkout}" => date('d-m-Y', $list['checkout']), "{market_price}" => $user_travel_cretids + $list['price'], "{payed_amount}" => $list['price'], "{travel_credits}" => $user_travel_cretids, "{host_name}" => ucfirst($buyer_name), "{host_email_id}" => $buyer_email);
				//Send Mail
				$this -> Email_model -> sendMail($admin_email, $email_id, ucfirst($username), $email_name, $splVars);

				//sent mail to buyer
				if($session_lang == ""){
				$email_name = 'tc_book_to_host';}
				else {$email_name = 'tc_book_to_host_'.$session_lang;} 
				$splVars = array("{site_name}" => $this -> dx_auth -> get_site_title(), "{username}" => ucfirst($buyer_name), "{traveler_name}" => ucfirst($username), "{list_title}" => $row_list -> title, "{book_date}" => date('m/d/Y'), "{book_time}" => date('g:i A'), "{traveler_email_id}" => $email_id, "{checkin}" => date('d-m-Y', $list['checkin']), "{checkout}" => date('d-m-Y', $list['checkout']), "{market_price}" => $list['price']);
				//Send Mail
				if ($buyer_email != '0') {
					$this -> Email_model -> sendMail($buyer_email, $admin_email, ucfirst($admin_name), $email_name, $splVars);
				}
}
			$list['book_date'] = local_to_gmt();

			$this -> Common_model -> insertData('reservation', $list);
			$reservation_id = $this -> db -> insert_id();

				//Send Message Notification
				$checkindate = date('m/d/Y', $list['checkout']) ;
				$checkoutdate = date('m/d/Y', $list['checkout']) ;
				$user_result_by = $this -> Common_model -> getTableData('profiles', array('id' => $list['userby'])) -> row();
				$user_result_by_host = $this -> Common_model -> getTableData('profiles', array('id' => $list['userto'])) -> row();
				$no_user_by = $user_result_by -> phnum;
				$no_user_by = $user_result_by -> phnum;

				$actionurl = site_url('trips/request/' . $reservation_id);
			
			
//////////////////////////////////////////////////////// PDF WHILE ACCEPT STARS ///////////////////////////////////////////////////////////////////////////			
if ($instance_book == 1) 
	{
		get_invoice_pdf($reservation_id);
		$invoice = "Invoice-".$reservation_id;
	}
else
	{
	  $invoice = NULL;
	}			
//////////////////////////////////////////////////////// PDF WHILE ACCEPT ENDS ///////////////////////////////////////////////////////////////////////////										
						if ($instance_book == 1) {
					$insertData = array('list_id' => $list['list_id'], 'reservation_id' => $reservation_id, 'conversation_id' => $reservation_id, 'userby' => $list['userto'], 'userto' => $list['userby'], 'message' => 'Your reservation is successfully done ', 'created' => local_to_gmt(), 'message_type' => 3);
					$this -> Message_model -> sentMessage($insertData, ucfirst($username), ucfirst($buyer_name), $row_list -> title, $reservation_id);

					//Request sent

					$insertData = array('list_id' => $list['list_id'], 'reservation_id' => $reservation_id, 'conversation_id' => $reservation_id, 'userby' => $list['userto'], 'userto' => $list['userby'], 'message' => 'You have sent a new reservation request to ' . ucfirst($buyer_name), 'created' => local_to_gmt(), 'message_type' => 12);

					$this -> Message_model -> sentMessage($insertData, $isCoversation = 0, ucfirst($username), ucfirst($buyer_name), $row_list -> title, $reservation_id);

					$insertData = array('list_id' => $list['list_id'], 'reservation_id' => $reservation_id, 'conversation_id' => $reservation_id, 'userby' => $list['userby'], 'userto' => $list['userto'], 'message' => 'You have a new reservation request from ' . ucfirst($username), 'created' => local_to_gmt(), 'message_type' => 1);
					
					$row_list = $query1 -> row();
					
					$session_lang = $this->session->userdata('locale');
					if($session_lang == "") {
					$email_name = 'instant_book_reservation_granted';}
					else { $email_name = 'instant_book_reservation_granted_'.$session_lang;}
					
					$splVars    = array("{site_name}" => $this->dx_auth->get_site_title(), "{traveler_name}" => ucfirst($username), "{list_title}" => $row_list->title);
					$this -> Email_model -> sendMail($email_id, $admin_email, ucfirst($admin_name), $email_name, $splVars, NULL, NULL, NULL, $invoice);
				////////////////////// send sms to guest /////////
					if($no_user_by != '')
					{
					$msg_content = "Your reservation is successfully done for the listing " . $row_list -> title . " ( " . $checkindate . " - " . $checkoutdate . " )";
					send_sms_user($no_user_by, $msg_content);
					}
				////////////////////// send sms to guest /////////
				
					} else {
					//Request sent

					$insertData = array('list_id' => $list['list_id'], 'reservation_id' => $reservation_id, 'conversation_id' => $reservation_id, 'userby' => $list['userto'], 'userto' => $list['userby'], 'message' => 'You have sent a new reservation request to ' . ucfirst($buyer_name), 'created' => local_to_gmt(), 'message_type' => 12);
					$this -> Message_model -> sentMessage($insertData, $isCoversation = 0, ucfirst($username), ucfirst($buyer_name), $row_list -> title, $reservation_id);

					$insertData = array('list_id' => $list['list_id'], 'reservation_id' => $reservation_id, 'userby' => $list['userby'], 'userto' => $list['userto'], 'message' => 'You have a new reservation request from ' . ucfirst($username), 'created' => local_to_gmt(), 'message_type' => 1);
					$this -> Message_model -> sentMessage($insertData, ucfirst($buyer_name), ucfirst($username), $row_list -> title, $reservation_id);
					
					////////////////////// send sms to guest /////////
					if($no_user_by != '')
					{
					$msg_content = "You have sent a new reservation request to " . ucfirst($buyer_name) . " for the listing " . $row_list -> title . " ( " . $checkindate . " - " . $checkoutdate . " )";
					send_sms_user($no_user_by, $msg_content);
					}
					////////////////////// send sms to guest /////////	
					
			//Reservation Notification To Traveller
			if($session_lang == "") {
			$email_name = 'traveller_reservation_notification';}
			else {$email_name = 'traveller_reservation_notification_'.$session_lang;}
			$splVars = array("{site_name}" => $this -> dx_auth -> get_site_title(), "{traveler_name}" => ucfirst($username));			

			//Send Mail
			$this -> Email_model -> sendMail($email_id, $admin_email, ucfirst($admin_name), $email_name, $splVars, NULL, NULL, NULL, $invoice);
							
					}
				
				////////////////////// common for instant and normal booking - send sms to Host /////////
					if($no_user_by_host != '')
					{
					$msg_content_host = 'You have a new reservation request from ' . ucfirst($username) . " forthe listing" . $row_list -> title . " ( " . $checkindate . " - " . $checkoutdate . " )";
					send_sms_user($no_user_by_host, $msg_content_host);
					}
				////////////////////// send sms to Host /////////
		
			//Reservation Notification To Host
			$session_lang = $this->session->userdata('locale');
			if($session_lang == "") {
			$email_name = 'host_reservation_notification';}
			else {$email_name = 'host_reservation_notification_'.$session_lang;}
			$splVars = array("{site_name}" => $this -> dx_auth -> get_site_title(), "{username}" => ucfirst($buyer_name), "{traveler_name}" => ucfirst($username), "{list_title}" => $row_list -> title, "{book_date}" => date('m/d/Y'), "{book_time}" => date('g:i A'), "{traveler_email_id}" => $email_id, "{checkin}" => date('d-m-Y', $list['checkin']), "{checkout}" => date('d-m-Y', $list['checkout']), "{market_price}" => $list['price'], "{action_url}" => $actionurl);
			//Send Mail
			//
			if ($buyer_email != '0') {
				$this -> Email_model -> sendMail($buyer_email, $admin_email, ucfirst($admin_name), $email_name, $splVars, NULL, NULL, NULL, NULL);
			}

			//Reservation Notification To Administrator
			if($session_lang == "") {
			$email_name = 'admin_reservation_notification';}
			else {$email_name = 'admin_reservation_notification_'.$session_lang;}
			$splVars = array("{site_name}" => $this -> dx_auth -> get_site_title(), "{traveler_name}" => ucfirst($username), "{list_title}" => $row_list -> title, "{book_date}" => date('m/d/Y'), "{book_time}" => date('g:i A'), "{traveler_email_id}" => $email_id, "{checkin}" => date('d-m-Y', $list['checkin']), "{checkout}" => date('d-m-Y', $list['checkout']), "{market_price}" => $user_travel_cretids + $list['price'], "{payed_amount}" => $list['price'], "{travel_credits}" => $user_travel_cretids, "{host_name}" => ucfirst($buyer_name), "{host_email_id}" => $buyer_email);
			//Send Mail
			$this -> Email_model -> sendMail($admin_email, $email_id, ucfirst($username), $email_name, $splVars, NULL, NULL, NULL, NULL);


			$referral_amount = $this -> db -> where('id', $this -> dx_auth -> get_user_id()) -> get('users') -> row() -> referral_amount;
			if ($referral_amount > 100) {
				$this -> db -> set('referral_amount', $referral_amount - 100) -> where('id', $this -> dx_auth -> get_user_id()) -> update('users');
			} else {
				$this -> db -> set('referral_amount', 0) -> where('id', $this -> dx_auth -> get_user_id()) -> update('users');
			}
			$data['title'] = "Payment Success !";
			$data['message_element'] = "payments/paypal_success";
			$this -> load -> view('template', $data);
		} else {
			$data['title'] = "Payment Cancelled !";
			$data['message_element'] = "payments/paypal_cancel";
			$this -> load -> view('template', $data);
			//$this->_error($do_ec_return);
		}

	}

	function paypal_ipn() {
		$logfile = 'ipnlog/' . uniqid() . '.html';
		$logdata = "<pre>\r\n" . print_r($_POST, true) . '</pre>';
		file_put_contents($logfile, $logdata);
	}

	function _error($ecd) {
		echo "<br>error at Express Checkout<br>";
		echo "<pre>" . print_r($ecd, true) . "</pre>";
		echo "<br>CURL error message<br>";
		echo 'Message:' . $this -> session -> userdata('curl_error_msg') . '<br>';
		echo 'Number:' . $this -> session -> userdata('curl_error_no') . '<br>';
	}

	//Date convert module
	public function dateconvert($date) {
		$ckout = explode('/', $date);
		$diff = $ckout[2] . '-' . $ckout[0] . '-' . $ckout[1];
		return $diff;
	}

}

/* End of file payments.php */
/* Location: ./app/controllers/payments.php */
?>