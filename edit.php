<?php 
include('include/header.php');
include 'Invoice.php';
$invoice = new Invoice();
if(!empty($_POST['subject']) && $_POST['subject'] && !empty($_POST['invoice_id']) && $_POST['invoice_id']) {	
	$invoice->updateInvoice($_POST);	
	header("Location:invoice_list.php");	
}
if(!empty($_GET['invoice_id']) && $_GET['invoice_id']) {
	$invoiceValues = $invoice->getInvoice($_GET['invoice_id']);		
	$invoiceItems = $invoice->getInvoiceItems($_GET['invoice_id']);		
}
?>
<script src="js/invoice.js"></script>
<link href="css/style.css" rel="stylesheet">
<?php include('include/body.php');?>
	<div class="container content-invoice">
	<form action="" id="invoice-form" method="post" class="invoice-form" role="form" novalidate=""> 
		<div class="load-animate animated fadeInUp">
			<div class="row">
				<?php include('menu.php');?>
			</div>
			<input id="currency" type="hidden" value="$">
			<div class="row headerform">
				<div class="col-md-12">
					<h3>Edit Invoice</h3>
					<hr>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
					<div class="form-group">
						<label>Subject Invoice</label>
						<input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" autocomplete="off" value="<?= $invoiceValues['subject']?>">
					</div>
					<div class="form-group">
						<label>Due Date</label>
						<input type="date" class="form-control"name="due_date" id="due_date" placeholder="Sender Address" value="<?= $invoiceValues['due_date']?>">
					</div>
				</div>      		
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
					<h3>From</h3>
					<div class="form-group">
						<input type="text" class="form-control" name="sender" id="sender" placeholder="Sender Name" autocomplete="off" value="<?= $invoiceValues['sender']?>">
					</div>
					<div class="form-group">
						<textarea class="form-control" rows="3" name="sender_address" id="sender_address" placeholder="Sender Address"><?= $invoiceValues['sender_address']?></textarea>
					</div>
				</div>      		
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 pull-right">
					<h3>For</h3>
					<div class="form-group">
						<input type="text" class="form-control" name="receiver" id="receiver" placeholder="Receiver Name" autocomplete="off" value="<?= $invoiceValues['receiver']?>">
					</div>
					<div class="form-group">
						<textarea class="form-control" rows="3" name="receiver_address" id="receiver_address" placeholder="Receiver Address"><?= $invoiceValues['receiver_address']?></textarea>
					</div>
					
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<table class="table table-bordered table-hover" id="invoiceItem">	
						<tr>
							<th width="2%"><input id="checkAll" class="formcontrol" type="checkbox"></th>
							<th width="15%">Item Type</th>
							<th width="38%">Description</th>
							<th width="15%">Quantity</th>
							<th width="15%">Unit Price</th>								
							<th width="15%">Amount</th>
						</tr>
						<?php foreach($invoiceItems as $item) { ?>					
							<tr>
								<td><input class="itemRow" type="checkbox"></td>
								<td><input type="text" name="item_type[]" id="item_type_1" class="form-control" autocomplete="off" value="<?= $item['item_type']?>"></td>
								<td><input type="text" name="description[]" id="description_1" class="form-control" autocomplete="off" value="<?= $item['description']?>"></td>			
								<td><input type="number" name="quantity[]" id="quantity_1" class="form-control quantity" autocomplete="off" value="<?= $item['quantity']?>"></td>
								<td><input type="number" name="unit_price[]" id="unit_price_1" class="form-control price" autocomplete="off" value="<?= $item['unit_price']?>"></td>
								<td><input type="number" name="amount[]" id="amount_1" class="form-control total" autocomplete="off" value="<?= $item['unit_price']*$item['quantity']?>"></td>
							</tr>
						<?php } ?>					
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
					<button class="btn btn-danger delete" id="removeRows" type="button">Delete</button>
					<button class="btn btn-info" id="addRows" type="button">Add More</button>
				</div>
			</div>
			<div class="row">	
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="float:right">
					<span class="form-inline">
						<div class="form-group">
							<label>Subtotal: &nbsp;</label>
							<div class="input-group">
								<div class="input-group-addon currency">$</div>
								<input readonly type="number" class="form-control" name="subtotal" id="subTotal" placeholder="Subtotal" value="<?= $invoiceValues['subtotal']?>">
							</div>
						</div>
						<div class="form-group">
							<label>Tax (10%): &nbsp;</label>
							<div class="input-group">
								<div class="input-group-addon currency">$</div>
								<input readonly type="number" class="form-control" name="tax" id="taxAmount" placeholder="Tax Amount" value="<?= $invoiceValues['tax']?>">
							</div>
						</div>							
						<div class="form-group">
							<label>Total: &nbsp;</label>
							<div class="input-group">
								<div class="input-group-addon currency">$</div>
								<input readonly type="number" class="form-control" name="total" id="totalAftertax" placeholder="Total" value="<?= $invoiceValues['total']?>">
							</div>
						</div>
						<div class="form-group">
							<label>Payments: &nbsp;</label>
							<div class="input-group">
								<div class="input-group-addon currency">$</div>
								<input type="number" class="form-control" name="amount_paid" id="amountPaid" placeholder="Amount Paid" value="<?= $invoiceValues['amount_paid']?>">
							</div>
						</div>
						<div class="form-group">
							<label>Amount Due: &nbsp;</label>
							<div class="input-group">
							<div class="input-group">
								<div class="input-group-addon currency">$</div>
								<input readonly type="number" class="form-control" name="amount_due" id="amountDue" placeholder="Amount Due" value="<?= $invoiceValues['amount_due']?>">
							</div>
						</div>
						<div style="margin-top: 2em;">
							<button type="submit" class="btn btn-primary btn-block">Finish</button>
						</div>
					</span>
				</div>
			</div>
			<div class="clearfix"></div>		      	
		</div>
	</form>			
</div>
</div>	
<?php include('include/footer.php');?>