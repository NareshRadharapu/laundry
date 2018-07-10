<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width">
<title><?php echo (@$title)?$title:$this->config->item('applicationName');?></title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('themes/front/css/bootstrap.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('themes/front/css/modern-business.css');?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('themes/front/css/app.css'); ?>">

</head>
<body>
<header>
<?php echo $this->config->item('applicationName'); ?>
</header>



