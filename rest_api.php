<?php
require_once "Invoice.php";
$inv = new Invoice();

$request_method=$_SERVER["REQUEST_METHOD"];
switch ($request_method) {
	case 'GET':
			if(!empty($_GET["invoice_id"]))
			{
				$id=intval($_GET["invoice_id"]);
				$data = $inv->getInvoice($id);
				$response = array(
					'status' => 1,
					'message' =>'Get Invoice Successfully.',
					'data' => $data
				);
				header('Content-Type: application/json');
				echo json_encode($response);
			}
			else
			{
				$data = $inv->getInvoiceList();
				$response = array(
					'status' => 1,
					'message' =>'Get Invoice Successfully.',
					'data' => $data
				);
				header('Content-Type: application/json');
				echo json_encode($response);
			}
			break;
	default:
		// Invalid Request Method
			header("HTTP/1.0 405 Method Not Allowed");
			break;
		break;
}

?>