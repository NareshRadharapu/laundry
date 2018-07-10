<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" ng-app="colorAdminApp">
<!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<title data-ng-bind="'Laundry Admin | ' + $state.current.data.pageTitle">Laundry Admin</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<base href="<?php echo base_url()?>">
	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<!--<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />-->
	<link href="<?php echo base_url('assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css');?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/plugins/bootstrap/css/bootstrap.min.css');?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/plugins/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/css/animate.min.css');?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/css/style.min.css');?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/css/style-responsive.min.css');?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/css/theme/default.css');?>" rel="stylesheet" id="theme" />
	<link href="<?php echo base_url('assets/css/ng-notify.min.css');?>" rel="stylesheet" id="noti" />
	<link href="<?php echo base_url('assets/css/ng-table.min.css');?>" rel="stylesheet" id="ngt" />
	<link href="<?php echo base_url('assets/css/custom.css');?>" rel="stylesheet" id="ngt" />

	<!-- ================== END BASE CSS STYLE ================== -->

	<!-- ================== BEGIN BASE JS ================== -->
	<script src="<?php echo base_url('assets/plugins/pace/pace.min.js');?>"></script>
	<!-- ================== END BASE JS ================== -->
	
	<!--[if lt IE 9]>
	    <script src="<?php echo base_url('assets/crossbrowserjs/excanvas.min.js');?>"></script>
	    <![endif]-->

	    <!-- ================== BEGIN BASE ANGULAR JS ================== -->
	    <script src="<?php echo base_url('assets/plugins/angularjs/angular.min.js');?>"></script>
	    <script src="<?php echo base_url('assets/plugins/angularjs/angular-ui-route.min.js');?>"></script>
	    <script src="<?php echo base_url('assets/plugins/bootstrap-angular-ui/ui-bootstrap-tpls.min.js');?>"></script>
	    <script src="<?php echo base_url('assets/plugins/angularjs/ocLazyLoad.min.js');?>"></script>
	    <script src="<?php echo base_url('assets/js/ng-notify.min.js');?>"></script>
	    <script src="<?php echo base_url('assets/js/ng-table.min.js');?>"></script>


	    <!-- ================== END BASE ANGULAR JS ================== -->
	</head>
	<body ng-controller="appController" ng-class="{'pace-top': setting.layout.paceTop, 'boxed-layout': setting.layout.pageBoxedLayout, 'bg-white': setting.layout.pageBgWhite }">

		<!-- begin #page-loader -->
		<!-- <div id="page-loader" ng-controller="pageLoaderController" class="fade in"><span class="spinner"></span></div> -->
		<!-- end #page-loader -->

		<div id="spinner" class="spinner" ng-show="showLoader">
		<img src="assets/img/loading_spinner.gif" alt="" class="spinner_img">
		</div>  

		<!-- begin #page-container -->
		<notifications-bar class="notifications"></notifications-bar>

		<div id="page-container" class="page-container page-sidebar-fixed page-header-fixed fade"
		ng-class="{
		'page-sidebar-minified': setting.layout.pageSidebarMinified,
		'page-content-full-height': setting.layout.pageContentFullHeight,
		'page-footer-fixed': setting.layout.pageFixedFooter,
		'page-with-right-sidebar': setting.layout.pageRightSidebar,
		'page-sidebar-minified': setting.layout.pageSidebarMinified,
		'page-with-two-sidebar': setting.layout.pageTwoSidebar,
		'page-right-sidebar-toggled': setting.layout.pageTwoSidebar,
		'page-with-top-menu': setting.layout.pageTopMenu,
		'page-without-sidebar': setting.layout.pageWithoutSidebar,
		'page-with-wide-sidebar': setting.layout.pageWideSidebar,
		'page-with-light-sidebar': setting.layout.pageLightSidebar,
		'p-t-0': setting.layout.pageWithoutHeader
	}">
