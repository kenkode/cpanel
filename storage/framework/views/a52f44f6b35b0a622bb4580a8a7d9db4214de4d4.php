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

 
	<div class="content" style='margin-top:170px;'>

   <div align="center"><h3><strong>Destinations Report</strong></h3></div>
    <table class="table table-bordered" border='1' cellspacing='0' cellpadding='0'>

      <tr>
     

        <td><strong># </strong></td>
        <td><strong>Name </strong></td> 
      </tr>
      <?php $i =1; ?>
      <?php $__currentLoopData = $destinations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $destination): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
      <tr>


       <td valign="top"><?php echo e($i); ?></td>
        <td valign="top"> <?php echo e($destination->name); ?></td>
        </tr>
      <?php $i++; ?>
   
    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
      
    </table>

<br><br>

   
</div>


</body>

</html>



