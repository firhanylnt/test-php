<?php 
include('include/header.php');
include 'Invoice.php';
$invoice = new Invoice();
?>

<?php include('include/body.php');?>
<script src="js/invoice.js"></script>
	<div class="container">		
	  <h2 class="title">Invoice System</h2>
	  <div class="row">
	  	<?php include('menu.php');?>
	  </div>
      <table id="data-table" class="table table-condensed table-striped"> 
        <thead>
          <tr>
            <th>Invoice ID</th>
            <th>Customer Name</th>
            <th>Invoice Date</th>
            <th>Action</th>
          </tr>
        </thead>
        <?php		
		$invoiceList = $invoice->getInvoiceList();
        foreach($invoiceList as $invoiceDetails){
			$invoiceDate = date("d-M-Y", strtotime($invoiceDetails["due_date"]));
            echo '
              <tr>
                <td>'.$invoiceDetails["invoice_id"].'</td>
                <td>'.$invoiceDetails["receiver"].'</td>
                <td>'.$invoiceDate.'</td>
                <td>
                <a href="edit.php?invoice_id='.$invoiceDetails["invoice_id"].'"  title="Edit Invoice"><span class="glyphicon glyphicon-edit"></span></a>
                <a href="#" id="'.$invoiceDetails["invoice_id"].'" class="deleteInvoice"  title="Delete Invoice"><span class="glyphicon glyphicon-remove"></span></a>
                <a href="view.php?invoice_id='.$invoiceDetails["invoice_id"].'" id="'.$invoiceDetails["invoice_id"].'" class=""  title="Delete Invoice"><span class="glyphicon glyphicon-eye-open"></span></a>
                </td>
              </tr>
            ';
        }       
        ?>
      </table>	
</div>	
<?php include('include/footer.php');?>