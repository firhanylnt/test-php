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
					<h3>View Invoice</h3>
					<hr>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="col-md-12">
						<h1>INVOICE</h1>
						<?php if($invoiceValues['amount_due'] == 0) {?>
							<h3 class="status">PAID</h3>
						<?php }else{ ?>
							<h3 class="status2">UNPAID</h3>
						<?php } ?>
					</div>
				</div>
				<div class="col-md-4 pull-right">
					<div class="col-md-3">
						<div class="form-group" >
							<p>FROM</p>
						</div>
					</div>
					<div class="col-md-9"  style="border-left: 1px solid black;">
						<div class="form-group">
							<p><?= $invoiceValues['sender']?></p>
						</div>
						<div class="form-group">
							<p><?= $invoiceValues['sender_address']?></p>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="col-md-4">
						<div class="form-group">
							<p>Invoice ID</p>
						</div>
						<div class="form-group">
							<p>Issue Date</p>
						</div>
						<div class="form-group">
							<p>Due Date</p>
						</div>
						<div class="form-group">
							<p>Subject</p>
						</div>
					</div>
					<div class="col-md-8">
						<div class="form-group">
							<p><?= $invoiceValues['invoice_id']?></p>
						</div>
						<div class="form-group">
							<p><?= $invoiceValues['issue_date']?></p>
						</div>
						<div class="form-group">
							<p><?= $invoiceValues['due_date']?></p>
						</div>
						<div class="form-group">
							<p><?= $invoiceValues['subject']?></p>
						</div>
					</div>
				</div>
				<div class="col-md-4 pull-right" style="margin-top:2em">
					<div class="col-md-3">
						<div class="form-group" >
							<p>For</p>
						</div>
					</div>
					<div class="col-md-9"  style="border-left: 1px solid black;">
						<div class="form-group">
							<p><?= $invoiceValues['receiver']?></p>
						</div>
						<div class="form-group">
							<p><?= $invoiceValues['receiver_address']?></p>
						</div>
					</div>
				</div>
			</div>
			<div class="row" style="margin-top:2em">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<table class="table table-bordered table-hover" id="">	
						<tr>
							<th width="15%">Item Type</th>
							<th width="38%">Description</th>
							<th width="15%">Quantity</th>
							<th width="15%">Unit Price</th>								
							<th width="15%">Amount</th>
						</tr>
						<?php foreach($invoiceItems as $item) { 
							$amount = $item['unit_price']*$item['quantity'];
						?>					
							<tr>
								<td><?= $item['item_type']?></td>
								<td><?= $item['description']?></td>			
								<td><?= $item['quantity']?></td>
								<td><?= number_format($item['unit_price'])?></td>
								<td><?= number_format($amount)?></td>
							</tr>
						<?php } ?>					
					</table>
				</div>
			</div>
			<div class="row">	
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="float:right">
					<span class="form-inline">
						<div class="form-group">
							<label>Subtotal: &nbsp;</label>
							<div class="input-group">
								<div class="input-group-addon currency">Rp</div>
								<input readonly type="text" class="form-control" name="subtotal" id="subTotal" placeholder="Subtotal" value="<?= number_format($invoiceValues['subtotal'])?>">
							</div>
						</div>
						<div class="form-group">
							<label>Tax (10%): &nbsp;</label>
							<div class="input-group">
								<div class="input-group-addon currency">Rp</div>
								<input readonly type="text" class="form-control" name="tax" id="taxAmount" placeholder="Tax Amount" value="<?= number_format($invoiceValues['tax'])?>">
							</div>
						</div>							
						<div class="form-group">
							<label>Total: &nbsp;</label>
							<div class="input-group">
								<div class="input-group-addon currency">Rp</div>
								<input readonly type="text" class="form-control" name="total" id="totalAftertax" placeholder="Total" value="<?= number_format($invoiceValues['total'])?>">
							</div>
						</div>
						<div class="form-group">
							<label>Payments: &nbsp;</label>
							<div class="input-group">
								<div class="input-group-addon currency">Rp</div>
								<input readonly type="text" class="form-control" name="amount_paid" id="amountPaid" placeholder="Amount Paid" value="<?= number_format($invoiceValues['amount_paid'])?>">
							</div>
						</div>
						<div class="form-group">
							<label>Amount Due: &nbsp;</label>
							<div class="input-group">
							<div class="input-group">
								<div class="input-group-addon currency">Rp</div>
								<input readonly type="text" class="form-control" name="amount_due" id="amountDue" placeholder="Amount Due" value="<?= number_format($invoiceValues['amount_due'])?>">
							</div>
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