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
  margin-top: 1px;
  margin-bottom: 2px;
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


	<div class="content" style='margin-top:170px;'>
    <?php if(Auth::user()->type == 'Travel' || Auth::user()->type == 'Taxi'): ?>
	  <?php if($status == 'all'): ?>
    <div align="center"><h3><strong>Vehicles Report</strong></h3></div>
    <?php elseif($status == 1): ?>
    <div align="center"><h3><strong>Active Vehicles Report</strong></h3></div>
    <?php elseif($status == 0): ?>
    <div align="center"><h3><strong>Inactive Vehicle names Report</strong></h3></div>
    <?php endif; ?>

    <?php elseif(Auth::user()->type == 'SGR'): ?>
    <?php if($status == 'all'): ?>
    <div align="center"><h3><strong>Train Report</strong></h3></div>
    <?php elseif($status == 1): ?>
    <div align="center"><h3><strong>Active Trains Report</strong></h3></div>
    <?php elseif($status == 0): ?>
    <div align="center"><h3><strong>Inactive Train names Report</strong></h3></div>
    <?php endif; ?>

    <?php elseif(Auth::user()->type == 'Airline'): ?>
    <?php if($status == 'all'): ?>
    <div align="center"><h3><strong>Airplanes Report</strong></h3></div>
    <?php elseif($status == 1): ?>
    <div align="center"><h3><strong>Active Airplanes Report</strong></h3></div>
    <?php elseif($status == 0): ?>
    <div align="center"><h3><strong>Inactive Airplane names Report</strong></h3></div>
    <?php endif; ?>
    <?php endif; ?>

    <table class="table table-bordered" border='1' cellspacing='0' cellpadding='0'>

      <tr>
     

        <td width='20'><strong># </strong></td>
        <?php if(Auth::user()->type == 'Travel' || Auth::user()->type == 'Taxi'): ?>
        <td><strong>Reg No.</strong></td>
        <?php elseif(Auth::user()->type == 'SGR'): ?>
        <td><strong>Reporting Number</strong></td>
        <?php elseif(Auth::user()->type == 'Airline'): ?>
        <td><strong>Reporting Number</strong></td>
        <?php endif; ?>
        <td><strong>Name </strong></td> 
        <td><strong>Capacity </strong></td> 
        <?php if(Auth::user()->type == 'Travel'): ?>
        <td><strong>Type </strong></td> 
        <td><strong>Has Conductor </strong></td>
        <td><strong>Has Chair </strong></td> 
        <?php endif; ?>
        <?php if($status == 'all'): ?> 
        <td><strong>Active </strong></td> 
        <?php endif; ?>
      </tr>
      <?php $i =1; ?>
      <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
      <tr>


       <td width='20'><?php echo e($i); ?></td>
        <td><?php echo e($vehicle->regno); ?></td>
        <td> <?php echo e($vehicle->vehiclename->name); ?></td>
        <td> <?php echo e($vehicle->capacity); ?></td>
        <?php if(Auth::user()->type == 'Travel'): ?>
        <td> <?php echo e($vehicle->type); ?></td>
        <?php if($vehicle->has_conductor == 1): ?>
        <td> Yes</td>
        <?php else: ?>
        <td> No</td>
        <?php endif; ?>
        <?php if($vehicle->has_chair == 1): ?>
        <td> Yes</td>
        <?php else: ?>
        <td> No</td>
        <?php endif; ?>
        <?php endif; ?>
        <?php if($status == 'all'): ?>
        <?php if($vehicle->active == 1): ?>
        <td> Yes</td>
        <?php else: ?>
        <td> No</td>
        <?php endif; ?>
        <?php endif; ?>
        </tr>
      <?php $i++; ?>
   
    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
      
    </table>

<br><br>

   
</div>


</body>

</html>



