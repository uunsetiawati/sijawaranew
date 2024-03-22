<?php
defined('BASEPATH') or exit('No direct script access allowed');
error_reporting(error_reporting() & ~E_DEPRECATED & ~E_USER_DEPRECATED);
use Durianpay\Durianpay;
use Durianpay\Exceptions\BadRequestException;

class CheckoutGuest extends Middleware
{
	public $session_data;
	public $serverKeyMidtrans = '';
	public $clientKeyMidtrans = '';
	function __construct()
	{
		parent::__construct();
		$this->load->model(['Event', 'Course', 'Ebook', 'Checkout', 'Promo']);
		$this->serverKeyMidtrans = base64_encode("Mid-server-bc8oy07HC8V92YMl3oKmgL9K");
		$this->clientKeyMidtrans = 'Mid-client-SmG8P47WnRFRNOIt';

		// $this->serverKeyMidtrans = base64_encode("SB-Mid-server-aa9uNlkBEQ8-WIh07RJtckZN");
		// $this->clientKeyMidtrans = 'SB-Mid-client-mQ3zImS0W1dMcr0q';

		// Durianpay::setApiKey('dp_live_HPkbQyQ29oUrgWL9');
		// Durianpay::setApiKey('dp_test_aubDzC4Ddmpac05n');
		// error_reporting(0);
	}

	// PAYMENT CONTROLLER
	public function index()
	{
		($this->session->userdata('ID_USER') == null) ? redirect('login') : "";

		$data['title'] = 'Checkout';

		$data['checking_trans'] = $this->Checkout->get_trans($this->session->userdata('ID_USER'));
		$data['checkout'] = $this->Checkout->get_all_order($this->session->userdata('ID_USER'));
		$data['list_promo'] = $this->Promo->getPromo($this->session->userdata('ID_USER'));

		$this->load->view('template/header', $data);
		$this->load->view('guest/checkout');
		$this->load->view('template/footer');
	}
	public function purchase()
	{
		($this->session->userdata('ID_USER') == null) ? redirect('login') : "";
		$data['title'] = 'Purchase';
		$data['id_trans'] = $this->GenerateUniqID_Transaction(time());

		$checking_trans = $this->Checkout->get_trans($this->session->userdata('ID_USER'));
		(empty($_POST['id_order_purchase']) && empty($checking_trans)) ? redirect('checkout') : "";

		$data['checking_trans'] = $checking_trans;

		$data['order'] = array();
		if (!empty($_POST['id_order_purchase']) && empty($checking_trans)) {
			array_push($data['order'], $this->Checkout->get_detail_order($_POST['id_order_purchase'], ""));
		} else {
			foreach ($checking_trans as $item) {
				$data['id_trans'] = $item['ID_PAY'];
				array_push($data['order'], $this->Checkout->get_detail_order($item['ID_ORDER'], ""));
			}
		}

		if (!empty($_POST['id_promo_code'])) {
			$data['promo'] = $this->Promo->getPromoById($_POST['id_promo_code']);
		}

		$data['ScriptMidtrans'] = '<script type="text/javascript" src="https://app.midtrans.com/snap/snap.js" data-client-key="' . $this->clientKeyMidtrans . '"></script>';

		$this->load->view('template/header', $data);
		$this->load->view('guest/purchase');
		$this->load->view('template/footer');
	}
	public function addOrder()
	{
		$id_activity = $_GET['id_activity'];
		$type = $_GET['type'];

		$checking_order = $this->Checkout->get_detail_order("", $id_activity);

		$msg = "";

		if (substr($id_activity, 0, 3) == "EBK") {
			$ebook = $this->Ebook->get_book_by_id($id_activity);
			if (!empty($checking_order)) {
				$data_order = array(
					"ID_ORDER" => $checking_order['ID_ORDER'],
					"ID_PRODUCT" => $id_activity,
					"ID_USER" => $this->session->userdata('ID_USER'),
					"PRICE_ORDER" => $ebook['PRICE'],
					"LOG_TIME" => date("Y-m-d H:i:s")
				);
				$this->Checkout->update_order($data_order, $id_activity, $this->session->userdata('ID_USER'));
				$msg = "Your Course is Already in Cart!";
			} else {
				$data_order = array(
					"ID_ORDER" => $this->GenerateUniqID_Order(time()),
					"ID_PRODUCT" => $id_activity,
					"ID_USER" => $this->session->userdata('ID_USER'),
					"PRICE_ORDER" => $ebook['PRICE'],
					"LOG_TIME" => date("Y-m-d H:i:s")
				);
				$this->Checkout->insert_order($data_order);
				$msg = "Successfully Added Course to Cart!";
			}
		} else {
			if (!empty($id_activity) && !empty($this->session->userdata('ID_USER')) && $type == 1) {
				$course = $this->Course->get_course($id_activity);
				if (!empty($checking_order)) {
					$data_order = array(
						"ID_ORDER" => $checking_order['ID_ORDER'],
						"ID_PRODUCT" => $id_activity,
						"ID_USER" => $this->session->userdata('ID_USER'),
						"PRICE_ORDER" => $course['PRICE_ACTIVITY'],
						"LOG_TIME" => date("Y-m-d H:i:s")
					);
					$this->Checkout->update_order($data_order, $id_activity, $this->session->userdata('ID_USER'));
					$msg = "Your Course is Already in Cart!";
				} else {
					$data_order = array(
						"ID_ORDER" => $this->GenerateUniqID_Order(time()),
						"ID_PRODUCT" => $id_activity,
						"ID_USER" => $this->session->userdata('ID_USER'),
						"PRICE_ORDER" => $course['PRICE_ACTIVITY'],
						"LOG_TIME" => date("Y-m-d H:i:s")
					);
					$this->Checkout->insert_order($data_order);
					$msg = "Successfully Added Course to Cart!";
				}
			} else if (!empty($id_activity) && !empty($this->session->userdata('ID_USER')) && $type == 2) {
				$event = $this->Event->get_event($id_activity);
				if (!empty($checking_order)) {
					$data_order = array(
						"ID_ORDER" => $checking_order['ID_ORDER'],
						"ID_PRODUCT" => $id_activity,
						"ID_USER" => $this->session->userdata('ID_USER'),
						"PRICE_ORDER" => $event['PRICE_ACTIVITY'],
						"LOG_TIME" => date("Y-m-d H:i:s")
					);
					$this->Checkout->update_order($data_order, $id_activity, $this->session->userdata('ID_USER'));
					$msg = "Your Product is Already in Cart!";
				} else {
					$data_order = array(
						"ID_ORDER" => $this->GenerateUniqID_Order(time()),
						"ID_PRODUCT" => $id_activity,
						"ID_USER" => $this->session->userdata('ID_USER'),
						"PRICE_ORDER" => $event['PRICE_ACTIVITY'],
						"LOG_TIME" => date("Y-m-d H:i:s")
					);
					$this->Checkout->insert_order($data_order);
					$msg = "Successfully Added Product to Cart!";
				}
			}
		}

		echo json_encode(array(
			'IdOrder' => (!empty($data_order['ID_ORDER']) ? $data_order['ID_ORDER'] : ""),
			'Status' => (!empty($id_activity) && !empty($this->session->userdata('ID_USER'))),
			'Message' => (!empty($this->session->userdata('ID_USER'))) ? $msg : 'Please login first!'
		));
	}
	public function deleteOrder()
	{
		$id_order = $_GET['id_order'];
		$this->Checkout->delete_order($id_order);
	}

	// Access payment gateway
	public function get_order_id()
	{
		$checking_trans = $this->Checkout->get_trans($this->session->userdata('ID_USER'));
		$ID_PAY = $this->GenerateUniqIDPay('CI3-checkout-' . date('Y-m-d H:i:s'));

		if (empty($checking_trans) || empty($checking_trans[0]['TOKEN'])) {
			$data_res = [
				"transaction_details" => [
					"order_id" => $ID_PAY,
					"gross_amount" => (int)$_POST['TotPrice']
				],
				"customer_details" => [
					"first_name" => "TEST",
					"last_name" => "MIDTRANSER",
					"email" => "test@midtrans.com",
					"phone" => "+628123456",
					"billing_address" => [
						"first_name" => "TEST",
						"last_name" => "MIDTRANSER",
						"email" => "test@midtrans.com",
						"phone" => "081 2233 44-55",
						"address" => "Sudirman",
						"city" => "Jakarta",
						"postal_code" => "12190",
						"country_code" => "IDN"
					]
				],
				"item_details" => []
			];
			foreach ($_POST['id_order'] as $item) {
				$_response = $this->Checkout->get_detail_order($item, "")[0];
				array_push(
					$data_res['item_details'],
					array(
						'id' => $_response['TITLE_ACTIVITY'],
						'quantity' => 1,
						'price' => (int)$_response['PRICE_ORDER'],
						"name" => $_response['TITLE_ACTIVITY'],
						"brand" => "TBH Academy",
						"category" => "Course",
						"merchant_name" => "PT. DBI",
						"url" => ""
					)
				);

				$data_order = array(
					"ID_PAY" => $ID_PAY,
					"LOG_TIME" => date("Y-m-d H:i:s"),
					"MAPPING_COUNT" => 1
				);
				$this->Checkout->update_order($data_order, $_response['ID_PRODUCT'], $this->session->userdata('ID_USER'));
			}

			$url = 'https://app.midtrans.com/snap/v1/transactions';
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data_res));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'accept: application/json',
				'authorization: Basic ' . $this->serverKeyMidtrans,
				'content-type: application/json',
			));

			$response = curl_exec($ch);
			curl_close($ch);
			$data = json_decode($response, true);

			$data_payment = array(
				"ID_PAY" => $ID_PAY,
				"TOKEN" => $data['token'],
				"KODE_USER" => $this->session->userdata('ID_USER'),
				"DATE_CREATED" => date("Y-m-d H:i:s")
			);
			$this->Checkout->insert_payment($data_payment);

			$data_payment = array(
				"ID_PAY" => $ID_PAY,
				"GROSS_AMMOUNT" => $_POST['TotPrice'],
				"STATUS" => 'pending'
			);
			$this->Checkout->insert_payment_method($data_payment);
			echo json_encode([
				'status' => 200,
				'token' => $data['token']
			]);
		} else {
			echo json_encode([
				'status' => 200,
				'token' => $checking_trans[0]['TOKEN']
			]);
		}
	}
	public function check_status()
	{
		($this->session->userdata('ID_USER') == null) ? redirect('login') : "";
		$id_item = $_POST['id_activity'];
		$id_order = $_POST['id_order_whenPay'];
		$id_trans = $_POST['id_trans'];
		$id_pay_method = $_POST['id_pay_method'];
		$id_promo_code = $_POST['id_promo_code'];

		// if (!empty($id_promo_code)) {
		// 	$this->Promo->usePromo($id_promo_code);
		// }

		if ((int)$_POST['total_bayar'] != 0) {
			$url = 'https://api.midtrans.com/v2/' . $id_trans . '/status';
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'accept: application/json',
				'authorization: Basic ' . $this->serverKeyMidtrans,
				'content-type: application/json',
			));

			$response = curl_exec($ch);
			curl_close($ch);
			header('Content-Type: application/json');
			$data = json_decode($response, true);

			if (!empty($data['transaction_status'])) {
				if ($data['transaction_status'] == 'pending') {
					$this->session->set_flashdata('msg', "<script> 
						const Toast = Swal.mixin({
							toast: true,
							position: 'top-end',
							showConfirmButton: false,
							timer: 3000,
							timerProgressBar: true,
							didOpen: (toast) => {
								toast.addEventListener('mouseenter', Swal.stopTimer)
								toast.addEventListener('mouseleave', Swal.resumeTimer)
							}
						})
						Toast.fire({
							icon: 'warning',
							title: 'Purchase pending complete the transaction'
						})
						</script>
					");

					$data_payment_method = array(
						"TRANSACTION_ID" => $data['transaction_id'],
						"PAY_METHOD" => $data['payment_type'],
						"EXP_DATE" => $data['expiry_time']
					);
					$this->Checkout->update_payment_method($data_payment_method, $id_pay_method);
				} else if ($data['transaction_status'] == 'settlement' || $data['transaction_status'] == 'capture') {
					$data_payment_method = array(
						"TRANSACTION_ID" => $data['transaction_id'],
						"PAY_METHOD" => $data['payment_type'],
						"EXP_DATE" => $data['expiry_time'],
						"STATUS" => 'success'
					);
					$this->Checkout->update_payment_method($data_payment_method, $id_pay_method);

					$data_payment = array(
						"DATE_PAY" => date('Y-m-d H:i:s')
					);
					$this->Checkout->update_payment($data_payment, $id_trans);

					foreach ($id_item as $item) {
						$this->InsertDataMapping($item);
					}

					$this->session->set_flashdata('msg', "<script> 
						const Toast = Swal.mixin({
							toast: true,
							position: 'top-end',
							showConfirmButton: false,
							timer: 3000,
							timerProgressBar: true,
							didOpen: (toast) => {
								toast.addEventListener('mouseenter', Swal.stopTimer)
								toast.addEventListener('mouseleave', Swal.resumeTimer)
							}
						})
						Toast.fire({
							icon: 'success',
							title: 'Purchase Success'
						})
						</script>
					");
				} else if ($data['transaction'] == 'expire') {
					$this->session->set_flashdata('msg', "<script> 
						const Toast = Swal.mixin({
							toast: true,
							position: 'top-end',
							showConfirmButton: false,
							timer: 3000,
							timerProgressBar: true,
							didOpen: (toast) => {
								toast.addEventListener('mouseenter', Swal.stopTimer)
								toast.addEventListener('mouseleave', Swal.resumeTimer)
							}
						})
						Toast.fire({
							icon: 'warning',
							title: 'Purchase Failed, transaction was expire'
						})
						</script>
					");
					$this->Checkout->delete_transaction($id_trans, $id_order);
				} else {
					$this->session->set_flashdata('msg', "<script> 
						const Toast = Swal.mixin({
							toast: true,
							position: 'top-end',
							showConfirmButton: false,
							timer: 3000,
							timerProgressBar: true,
							didOpen: (toast) => {
								toast.addEventListener('mouseenter', Swal.stopTimer)
								toast.addEventListener('mouseleave', Swal.resumeTimer)
							}
						})
						Toast.fire({
							icon: 'warning',
							title: 'Purchase Failed'
						})
						</script>
					");
					$this->Checkout->delete_transaction($id_trans, $id_order);
				}
			}
			redirect('checkout');
		} else if ((int)$_POST['total_bayar'] == 0) {
			$ID_PAY = $this->GenerateUniqIDPay('CI3-checkout-' . date('Y-m-d H:i:s'));
			$data_payment = array(
				"ID_PAY" => $ID_PAY,
				"TOKEN" => NULL,
				"KODE_USER" => $this->session->userdata('ID_USER'),
				"DATE_CREATED" => date("Y-m-d H:i:s"),
				"DATE_PAY" => date("Y-m-d H:i:s")
			);
			$this->Checkout->insert_payment($data_payment);

			foreach ($id_item as $item) {
				$data_order = array(
					"ID_PAY" => $ID_PAY,
					"LOG_TIME" => date("Y-m-d H:i:s"),
					"MAPPING_COUNT" => 1
				);
				$this->Checkout->update_order($data_order, $item, $this->session->userdata('ID_USER'));
				$this->InsertDataMapping($item);
			}

			$this->session->set_flashdata('msg', "<script> 
				const Toast = Swal.mixin({
					toast: true,
					position: 'top-end',
					showConfirmButton: false,
					timer: 3000,
					timerProgressBar: true,
					didOpen: (toast) => {
						toast.addEventListener('mouseenter', Swal.stopTimer)
						toast.addEventListener('mouseleave', Swal.resumeTimer)
					}
				})
				Toast.fire({
					icon: 'success',
					title: 'Purchase Success'
				})
				</script>
			");

			redirect('checkout');
		}
	}
	public function DeleteTrans()
	{
		$id_trans = $_POST['id_trans'];
		$id_order = $_POST['id_order'];
		$this->Checkout->delete_transaction($id_trans, $id_order);

		redirect('checkout');
	}
	public function InsertDataMapping($item)
	{
		$data_course = $this->Course->get_course($item);
		$condition = ["ID_COURSE" => $data_course['ID_COURSE']];
		$data_itemCourse = $this->Course->get_item_course($condition);
		for ($i = 0; $i < count($data_itemCourse); $i++) {
			$data_mapping = array(
				"ID_USER" => $this->session->userdata('ID_USER'),
				"ID_ACTIVITY" => $item,
				"ID_ITEM" => $data_itemCourse[$i]['ID_ITEM'],
			);
			$this->Checkout->insert_mapping($data_mapping);
		}
	}
	public function GenerateUniqID_Order($var)
	{
		$string = preg_replace('/[^a-z]/i', '', $var);
		$vocal  = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", " ");
		$scrap  = str_replace($vocal, "", $string);
		$begin  = substr($scrap, 0, 6);
		$uniqid = strtoupper($begin);
		return "ORD_" . $uniqid . substr(md5(time()), 0, 6);
	}
	public function GenerateUniqID_Transaction($var)
	{
		$string = preg_replace('/[^a-z]/i', '', $var);
		$vocal  = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", " ");
		$scrap  = str_replace($vocal, "", $string);
		$begin  = substr($scrap, 0, 6);
		$uniqid = strtoupper($begin);
		return "TRAN_" . $uniqid . substr(md5(time()), 0, 6);
	}
	public function GenerateUniqIDPay($var)
	{
		$string = preg_replace('/[^a-z]/i', '', $var);
		$vocal  = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", " ");
		$scrap  = str_replace($vocal, "", $string);
		$begin  = substr($scrap, 0, 4);
		$uniqid = strtoupper($begin);
		return "PAY_" . $uniqid . substr(md5(time()), 0, 3);
	}
}
