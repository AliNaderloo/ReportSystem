<?php $__env->startSection('title'); ?>
<title>پنل مدیریت | مدیران</title>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('sidebar'); ?>
<li>
 <a href="/All">
  <i class="fa fa-th"></i> <span>شکایات</span>
  <!--    <small class="label pull-right bg-green">جدید</small> -->
</a>
</li>
<li class="active treeview">
 <a href="#">
   <i class="fa fa-gear"></i> <span>تنظیمات</span> <i class="fa fa-angle-left pull-left"></i>
 </a>
 <ul class="treeview-menu">
  <li><a href="/Subjects"><i class="fa  fa-quote-left "></i> <span>موضوعات شکایات</span></a></li>
  <li  class="active"><a href="/Admins"><i class="fa  fa-users"></i> <span>مدیران</span></a></li>
</ul>
</li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('extensions'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('struct', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>