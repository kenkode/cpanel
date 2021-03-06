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



 @page  { margin: 50px 30px; }
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
            <?php if($organization->logo == null || $organization->logo == ''): ?>
            <?php else: ?>
            <img src="<?php echo e(public_path().'/uploads/logo/'.$organization->logo); ?>" alt="logo" width="80%" alt="no logo">
            <?php endif; ?>
        </td>

        <td>
        <strong>
          <?php echo e(strtoupper($organization->name)); ?><br>
          </strong>
          <?php echo e($organization->phone); ?><br>
          <?php echo e($organization->email); ?><br>
          <?php echo e($organization->address); ?>

       

        </td>
        

      </tr>


    </table>
   </div>

<br>

 
	<div class="content" style='margin-top:50px;'>

        <?php if(Auth::user()->type == 'Travel' || Auth::user()->type == 'Taxi'): ?>
        <div align="center"><h3><strong>Vehicle names Report</strong></h3></div>
        <?php elseif(Auth::user()->type == 'SGR'): ?>
        <div align="center"><h3><strong>Train names Report</strong></h3></div>
        <?php elseif(Auth::user()->type == 'Airline'): ?>
        <div align="center"><h3><strong>Airplane names Report</strong></h3></div>
        <?php endif; ?>
 
    <table class="table table-bordered" border='1' cellspacing='0' cellpadding='0'>

      <tr>
     

        <td><strong># </strong></td>
        <td><strong>Logo </strong></td>
        <td><strong>Name </strong></td> 
      </tr>
      <?php $i =1; ?>
      <?php $__currentLoopData = $vehiclenames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehiclename): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
      <tr>


       <td valign="top"><?php echo e($i); ?></td>
            <?php if($vehiclename->logo == null || $vehiclename->logo == ''): ?>
            <td></td>
            <?php else: ?>
            <td><img src="<?php echo e(url('/public/uploads/logo/'.$vehiclename->logo)); ?>" width="100" height="100" alt="no logo" /></td>
            <?php endif; ?>
        <td valign="top"> <?php echo e($vehiclename->name); ?></td>
        </tr>
      <?php $i++; ?>
   
    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
      
    </table>

<br><br>

   
</div>


</body>

</html>



