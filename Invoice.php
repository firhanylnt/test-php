<?php
class Invoice{
	private $host  = 'localhost';
    private $user  = 'root';
    private $password   = "";
    private $database  = "test_esb";   
	private $dbConnect = false;

    public function __construct(){
        if(!$this->dbConnect){ 
            $conn = new mysqli($this->host, $this->user, $this->password, $this->database);
            if($conn->connect_error){
                die("Error failed to connect to MySQL: " . $conn->connect_error);
            }else{
                $this->dbConnect = $conn;
            }
        }
    }

	private function getData($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die('Error in query: '. mysqli_error());
		}
		$data= array();
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$data[]=$row;            
		}
		return $data;
	}

	private function getNumRows($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die('Error in query: '. mysqli_error());
		}
		$numRows = mysqli_num_rows($result);
		return $numRows;
	}

	
	public function saveInvoice($POST) {		
		$sqlInsertInvoice = "
			INSERT INTO invoice (subject, due_date) 
			VALUES ('".$POST['subject']."','".$POST['due_date']."')";		
		mysqli_query($this->dbConnect, $sqlInsertInvoice);

		$lastInsertId = mysqli_insert_id($this->dbConnect);

		$sqlInsertHeading = "
			INSERT INTO invoice_heading(invoice_id,sender, sender_address, receiver, receiver_address) 
			VALUES ('".$lastInsertId."','".$POST['sender']."','".$POST['sender_address']."','".$POST['receiver']."','".$POST['receiver_address']."')";		
		mysqli_query($this->dbConnect, $sqlInsertHeading);

		$sqlInsertAmount = "
			INSERT INTO invoice_amount(invoice_id, subtotal, tax, total, amount_paid, amount_due) 
			VALUES ('".$lastInsertId."','".$POST['subtotal']."','".$POST['tax']."','".$POST['total']."','".$POST['amount_paid']."','".$POST['amount_due']."')";
		mysqli_query($this->dbConnect, $sqlInsertAmount);

		for ($i = 0; $i < count($POST['item_type']); $i++) {
			$sqlInsertItem = "
			INSERT INTO invoice_item(invoice_id, item_type, description, quantity, unit_price) 
			VALUES ('".$lastInsertId."', '".$POST['item_type'][$i]."', '".$POST['description'][$i]."', '".$POST['quantity'][$i]."', '".$POST['unit_price'][$i]."')";			
			mysqli_query($this->dbConnect, $sqlInsertItem);
		}       	
	}	

	public function updateInvoice($POST) {
		if($POST['invoice_id']) {

			$updateInvoice = "
				UPDATE invoice 
				SET subject = '".$POST['subject']."', due_date = '".$POST['due_date']."' WHERE invoice_id = '".$POST['invoice_id']."'";		
			mysqli_query($this->dbConnect, $updateInvoice);

			$updateInvoiceHeading = "
				UPDATE invoice_heading 
				SET sender = '".$POST['sender']."', sender_address	 = '".$POST['sender_address	']."', receiver = '".$POST['receiver']."', receiver_address	 = '".$POST['receiver_address	']."' WHERE invoice_id = '".$POST['invoice_id']."'";		
			mysqli_query($this->dbConnect, $updateInvoiceHeading);

			$updateInvoiceAmount = "
				UPDATE invoice_amount 
				SET subtotal = '".$POST['subtotal']."', tax = '".$POST['tax']."', total = '".$POST['total']."', amount_paid = '".$POST['amount_paid']."', amount_due = '".$POST['amount_due']."' WHERE invoice_id = '".$POST['invoice_id']."'";		
			mysqli_query($this->dbConnect, $updateInvoiceAmount);

		}
		$this->deleteInvoiceItems($POST['invoice_id']);

		for ($i = 0; $i < count($POST['item_type']); $i++) {
			$sqlInsertItem = "
			INSERT INTO invoice_item(invoice_id, item_type, description, quantity, unit_price) 
			VALUES ('".$lastInsertId."', '".$POST['item_type'][$i]."', '".$POST['description'][$i]."', '".$POST['quantity'][$i]."', '".$POST['unit_price'][$i]."')";			
			mysqli_query($this->dbConnect, $sqlInsertItem);
		}       	
	}

	public function getInvoiceList(){
		$sqlQuery = "
			SELECT i.* , ih.receiver FROM invoice i join invoice_heading ih on i.invoice_id = ih.invoice_id";
		return  $this->getData($sqlQuery);
	}

	public function getInvoice($invoice_id){
		$invoice = "
			SELECT i.* , ih.* , ia.* FROM invoice i join invoice_heading ih on i.invoice_id = ih.invoice_id join invoice_amount ia on i.invoice_id = ia.invoice_id WHERE i.invoice_id = '$invoice_id'";
		$result = mysqli_query($this->dbConnect, $invoice);	
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

		return $row;
	}

	public function getInvoiceItems($invoice_id){
		$sqlQuery = "
			SELECT * FROM invoice_item 
			WHERE invoice_id = '$invoice_id'";
		return  $this->getData($sqlQuery);	
	}

	public function deleteInvoiceItems($invoice_id){
		$sqlQuery = "
			DELETE FROM invoice_item 
			WHERE invoice_id = '".$invoice_id."'";
		mysqli_query($this->dbConnect, $sqlQuery);				
	}

	public function deleteInvoiceHeading($invoice_id){
		$sqlQuery = "
			DELETE FROM invoice_heading 
			WHERE invoice_id = '".$invoice_id."'";
		mysqli_query($this->dbConnect, $sqlQuery);				
	}

	public function deleteInvoiceAmount($invoice_id){
		$sqlQuery = "
			DELETE FROM invoice_amount 
			WHERE invoice_id = '".$invoice_id."'";
		mysqli_query($this->dbConnect, $sqlQuery);				
	}

	public function deleteInvoice($invoice_id){
		$sqlQuery = "
			DELETE FROM invoice 
			WHERE invoice_id = '".$invoice_id."'";
		mysqli_query($this->dbConnect, $sqlQuery);	
		$this->deleteInvoiceItems($invoice_id);	
		$this->deleteInvoiceHeading($invoice_id);	
		$this->deleteInvoiceAmount($invoice_id);	
		return 1;
	}
}
?>