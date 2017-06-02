Hello <?php echo e($name); ?>,<br/>
Thank you for registering with TMA....<br/>
Please wait for the admin to approve your registration and click on the link below to confirm you email<br/>
<a href="<?php echo e(url('http://localhost/tmapp/userconfirmation/'.$name)); ?>">Click to confirm registration!</a>