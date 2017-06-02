<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<style type="text/css">

table {
  max-width: 100%;
  background-color: transparent;
}
th {
  text-align: left;
}
.table {
  width: 100%;
  margin-bottom: 2px;
}
hr {
  
  border: 0;
  border-top: 2px dotted #eee;
}

body {
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  font-size: 12px;
  line-height: 1.428571429;
  color: #333;
  background-color: #fff;
}



 @page  { margin: 170px 30px; }
 .header { position: fixed; left: 0px; top: 0px; right: 0px; height: 150px;  text-align: center; }
 .content {margin-top: 10px; }
 .footer { position: fixed; left: 0px; bottom: -180px; right: 0px; height: 50px;  }
 .footer .page:after { content: counter(page, upper-roman); }



</style>

</head>

<body>

  <div class="header">
     <table >

      <tr>


       
        <td style="width:150px">

            <img src="<?php echo e(public_path().'/uploads/logo/'.$organization->logo); ?>" alt="logo" width="80%">

    
        </td>

        <td>
        <strong>
          <?php echo e(strtoupper($organization->name)); ?><br>
          </strong>
          <?php echo e($organization->phone); ?>,<br>
          <?php echo e($organization->email); ?>,<br>
          <?php echo e($organization->address); ?>

       

        </td>
        

      </tr>


    </table>
   </div>

<br>

<?php $currency = ''; ?>
<?php if($organization->currency_shortname == null || $organization->currency_shortname == ''): ?>
<?php $currency = 'KES'; ?>
<?php else: ?>
<?php $currency = $organization->currency_shortname; ?>
<?php endif; ?>
 
	<div class="content" style='margin-top:170px;'>
 
   <div align="center"><h3><strong>Payment Options Report</strong></h3></div>
    <table class="table table-bordered" border='1' cellspacing='0' cellpadding='0'>

      <tr>
     

        <td><strong># </strong></td>
        <td><strong>Vehicle </strong></td>
        <?php if(Auth::user()->type != 'Taxi'): ?>
        <td><strong>Origin</strong></td>
        <td><strong>Destination</strong></td>
        <td><strong>VIP Fare (<?php echo e($currency); ?>) </strong></td>
        <td><strong>Normal Fare (<?php echo e($currency); ?>) </strong></td>
        <?php else: ?>
        <td><strong>Fare per Kilometer (<?php echo e($currency); ?>) </strong></td>
        <?php endif; ?>
      </tr>
      <?php $i =1; ?>
      <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
      <tr>
        <td valign="top"><?php echo e($i); ?></td>
        <td valign="top"><?php echo e(App\Payment::getVehicle($payment->vehicle_id)); ?></td>
        <?php if(Auth::user()->type != 'Taxi'): ?>
        <td><?php echo e(App\Schedule::getDestination($payment->origin_id)->name); ?></td>
        <td><?php echo e(App\Schedule::getDestination($payment->destination_id)->name); ?></td>
        <td valign="top"><?php echo e(number_format($payment->firstclass,2)); ?></td>
        <?php endif; ?>
        <td valign="top"> <?php echo e(number_format($payment->economic,2)); ?></td>
        </tr>
      <?php $i++; ?>
   
    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
      
    </table>

<br><br>

   
</div>


</body>

</html>



