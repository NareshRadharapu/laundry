<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$route['default_controller'] 		= 'admin';
$route['404_override'] 					= '';
$route['translate_uri_dashes'] 	= FALSE;
$route['api-apartments'] 				= 'api/apartments';
$route['api-itemtypes'] 				= 'api/itemtypes';
$route['api-blocks'] 						= 'api/blocks';
$route['api-flats'] 						= 'api/flats';
$route['api-flat'] 							= 'api/flat';
$route['api-ownerflats'] 				= 'api/ownerflats';
$route['api-flatupdate'] 				= 'api/flatupdate';
/*************************************************************/
/*******************	coupon codes   ***********************/
/*************************************************************/
$route['add-coupon-code'] 	= 'api/storeAdmin/addCouponCode';
$route['coupon-code'] 			= 'api/storeAdmin/getCoupon';
$route['coupon-codes'] 			= 'api/storeAdmin/getCoupons';
$route['api-checkCoupon']		= 'api/couponCheck';
$route['api-checkVendor']		= 'api/vendorCheck';
/*************************************************************/
$route['test-calender']					= 'api/storeAdmin/calendarReport';
$route['test-api']							= 'api/storeAdmin/testApi';
$route['cboy-assign']						= 'api/storeAdmin/cboyAssign';
$route['cboy-unassign']					= 'api/storeAdmin/cboyUnAssign';
$route['accountant-assign']			= 'api/storeAdmin/accountantAssign';
$route['accountant-unassign']		= 'api/storeAdmin/accountantUnAssign';
$route['api-vendors-group']			= 'api/vendorsGroup';
$route['api-vendors']						= 'api/vendors';
$route['api-vendor']						= 'api/vendor';
$route['vendorgroup-status']		= 'api/cbsAdmin/vendorGroupStatus';
$route['vendorgroup-add-edit']	= 'api/cbsAdmin/vendorGroup';
$route['edit-vendorgroup']			= 'api/cbsAdmin/editVendorGroup';
$route['vendor-status']					= 'api/cbsAdmin/vendorStatus';
$route['vendor-add-edit']				= 'api/cbsAdmin/vendor';
$route['edit-vendor']						= 'api/cbsAdmin/editVendor';
$route['vendors-report']				= 'api/cbsAdmin/vendorsReport';
$route['vendor-orders']					= 'api/cbsAdmin/vendorOrders';
$route['bank-assign']						= 'api/storeAdmin/bankAssign';
$route['store-transactions'] 		= 'api/storeAdmin/storeTransactions';
$route['storeCboy-transactions']= 'api/storeAdmin/storeCboyTransactions';
$route['cboy-transactions'] 		= 'api/storeAdmin/cboyTransactions';
$route['cboyAcc-transactions'] 	= 'api/storeAdmin/cboyAccTransactions';
$route['accountant-transactions']= 'api/storeAdmin/accountantTransactions';
$route['api-cboys'] 							= 'api/collectionBoys';
$route['api-accountants'] 				= 'api/accountants';
$route['handover-report']					= 'api/storeAdmin/handoverReport';
$route['store-check'] 						= 'api/storeAdmin/storeCheck';
$route['store-authentication'] 		= 'api/storeAdmin/authentication_live';
$route['store-logout'] 						= 'api/storeAdmin/storeLogout';
$route['store-authentications'] 	= 'api/storeAdmin/authentications';
$route['store-login-logout-history']= 'api/storeAdmin/storeLoginHistory';
$route['store-pre-process-order']	= 'api/storeAdmin/preprocessorder';
$route['store-process-order']			= 'api/storeAdmin/processorder';
$route['store-process-order-details']	= 'api/storeAdmin/processOrderDetails';
$route['store-order-receipt'] 			= 'api/storeAdmin/orderReceipt';
$route['store-tash-temp-orders'] 		= 'api/storeAdmin/trashTempOrders';
$route['store-order-ready-for-deliver'] = 'api/storeAdmin/readyForDeliver';
$route['customer-orders'] 				= 'api/storeAdmin/customerOrders';
$route['store-pickup-boys'] 			= 'api/storeAdmin/storePickupBoys';
$route['store-customer-wallet'] 	= 'api/storeAdmin/walletZero';
$route['store-order-change'] 			= 'api/storeAdmin/changeOrderStatus';
$route['store-return-garment'] 		= 'api/storeAdmin/returnGarment';
$route['store-return-garments'] 	= 'api/storeAdmin/returnGarments';
$route['store-return-garment-delete']	= 'api/storeAdmin/returnGarmentDelete';
$route['store-hold-garment'] 			= 'api/storeAdmin/holdGarment';
$route['store-hold-garments'] 			= 'api/storeAdmin/holdGarments';
$route['store-delivery-order-status']	= 'api/storeAdmin/deliveryOrderStatus';
$route['store-delivery-single-order-status'] = 'api/storeAdmin/deliverySingleOrderStatus';
$route['store-collections'] 			= 'api/storeAdmin/storeCollections';
$route['store-paid-amount'] 			= 'api/storeAdmin/storePaidAmount';
$route['order-return-garments'] 		= 'api/storeAdmin/orderReturnGarments';
$route['global-search'] 				= 'api/storeAdmin/globalSearch';
$route['store-add-edit-target'] 		= 'api/storeAdmin/addEditStoreTarget';
$route['stores-targets'] 				= 'api/storeAdmin/storesTargets';
$route['store-target-status']			= 'api/storeAdmin/storeTargetStatus';
$route['store-target']					= 'api/storeAdmin/storeTarget';
$route['store-pending-balance']			= 'api/storeAdmin/storePendingBalance';
$route['store-day-to-delivery-orders']	= 'api/storeAdmin/dayToDeliveryOrders';
$route['stores-day-to-delivery-orders']	= 'api/storeAdmin/storesDayToDeliveryOrders';
$route['store-closing-report']			= 'api/storeAdmin/storeClosingReport';
$route['store-daily-closing-report']	= 'api/storeAdmin/storeDailyClosingReport';
$route['stores-daily-closing-report-email']	= 'api/storeAdmin/storesDailyClosingReportEmail';
$route['orderwise-status-report']		= 'api/storeAdmin/orderwiseStatusReport';
$route['store-report']					= 'api/reports/storeReport';
/***************************************************************/
$route['resource-add-edit'] 			= 'api/storeAdmin/resourceAddEdit';
$route['resource-list'] 				= 'api/storeAdmin/resourceList';
$route['resource-status']				= 'api/storeAdmin/resourceStatus';
$route['single-resource']				= 'api/storeAdmin/singleResource';
$route['permissions-list'] 				= 'api/storeAdmin/permissionsList';
$route['permissions-update'] 			= 'api/storeAdmin/updatePermissions';
/***************************************************************/
/**************** CUSTOMER REQUEST *************************/
$route['customer-requests'] 			= 'api/storeAdmin/customerRequests';
$route['customer-add-request'] 			= 'api/storeAdmin/customerAddRequest';
$route['customer-request-assign'] 		= 'api/storeAdmin/customerRequestAssign';
$route['customer-request-assign-to-store'] = 'api/storeAdmin/customerRequestAssignStore';
$route['place-order-assign']			= 'api/storeAdmin/pickupBoyOrderRequest';
/************************** Ads ******************************/
$route['display-ads'] 					= 'api/apartmentAdmin/displayAds';
$route['apartment-admin-ads'] 			= 'api/apartmentAdmin/apartmentAdminAds';
$route['admin-ads'] 					= 'api/apartmentAdmin/adminAds';
$route['create-ad'] 					= 'api/apartmentAdmin/adCreate';
$route['ad-status'] 					= 'api/apartmentAdmin/adStatus';
$route['admin-ad-status'] 				= 'api/apartmentAdmin/adAdminStatus';
$route['ad-view'] 						= 'api/apartmentAdmin/adView';
$route['ad-click'] 						= 'api/apartmentAdmin/adClick';
/************************* CC cams ***************************/
$route['cams-lists'] 					= 'api/cbsAdmin/camsLists';
$route['apartment-cams-lists'] 			= 'api/cbsAdmin/apartmentCamsLists';
//$route['user-cams-lists'] 				= 'api/cbsAdmin/userCamsLists';
$route['create-cam'] 					= 'api/cbsAdmin/createCam';
$route['cam-view'] 						= 'api/cbsAdmin/camView';
$route['cam-status'] 					= 'api/cbsAdmin/camStatus';
$route['employee-add-edit']				= 'api/cbsAdmin/employee';
$route['cbs-customers-balance-sms-balance']	= 'api/cbsAdmin/customersBalanceList';
$route['cbs-customers-balance-sms']		= 'api/cbsAdmin/customerBalanceSms';
$route['employees']						= 'api/cbsAdmin/employees';
$route['edit-employee']					= 'api/cbsAdmin/editEmployee';
$route['cu-authentication'] 			= 'api/cUnit/authentication';
$route['cu-employee']					= 'api/cbsAdmin/CUEmployee';
$route['cu-edit-employee']				= 'api/cbsAdmin/store-order-ready-for-deliver';
$route['cu-employees']					= 'api/cbsAdmin/CUEmployees';
$route['cu-place-order']				= 'api/cbsAdmin/cuPlaceOrder';
$route['cu-send-orders']				= 'api/cbsAdmin/cuSendOrders';
$route['store-cu-send-orders']			= 'api/cbsAdmin/storeCUSendOrders';
$route['cu-send-order-assign']			= 'api/cbsAdmin/cuSendOrderAssign';
$route['cu-send-order-status']			= 'api/cbsAdmin/cuSendOrderStatus';
$route['cu-delivery-orders']			= 'api/cbsAdmin/cuDeliveryOrders';
$route['store-cu-delivery-orders']		= 'api/cbsAdmin/storeCUDeliveryOrders';
$route['cu-delivery-order-assign']		= 'api/cbsAdmin/cuDeliveryOrderAssign';
$route['cu-delivery-order-status']		= 'api/cbsAdmin/cuDeliveryOrderStatus';
$route['cu-day-to-delivery-orders']		= 'api/cbsAdmin/cuDayToDeliveryOrders';
$route['cu-order-details-trash']		= 'api/cbsAdmin/cuOrderDetailsTrash';
$route['cu-delete-delivery-order']		= 'api/cbsAdmin/cuDeleteDeliveryOrder';
$route['cu-order-details']				= 'api/cbsAdmin/cuOrderDetails';
$route['cus-order-details']				= 'api/cbsAdmin/cusOrderDetails';
$route['cud-order-details']				= 'api/cbsAdmin/cudOrderDetails';
$route['cu-process-orders']				= 'api/cbsAdmin/cuProcessOrders';
$route['cu-do-delivery-order']			= 'api/cbsAdmin/doDeliveryOrder';
$route['order-status']					= 'api/cbsAdmin/cuOrderStatus';
$route['order-item-status']				= 'api/cbsAdmin/cuOrderItemStatus';
$route['cua-send-order-status']			= 'api/cbsAdmin/cuAdminSendOrderStatus';
$route['cu-stores']						= 'api/cbsAdmin/cuStores';
$route['cu-stores-list']				= 'api/cbsAdmin/cuStoresList';
$route['cu-apartment-stores']			= 'api/cbsAdmin/cuAprtmentStores';
$route['cu-return-garment']				= 'api/cbsAdmin/returnGarment';
$route['cu-return-garments']			= 'api/cbsAdmin/returnGarments';
$route['cu-hold-garment']				= 'api/cbsAdmin/holdGarment';
$route['cu-hold-garments']				= 'api/cbsAdmin/holdGarments';
$route['cu-orders-delivery-print']		= 'api/cbsAdmin/ordersDeliveryPrint';
$route['cu-store-customer-sms']			= 'api/cbsAdmin/storeCustomerSms';
$route['custom-sms']					= 'api/cbsAdmin/customSms';
$route['cuStatuswiseReport']			= 'api/cbsAdmin/cuStatuswiseReport';
$route['cuStatuswiseOrders']			= 'api/cbsAdmin/cuStatuswiseOrders';
/******************* images/files upload *********************/
$route['item-image-upload'] 			= 'api/itemImageUpload';
$route['service-image-upload'] 			= 'api/serviceImageUpload';
$route['visitor-image-upload'] 			= 'api/visitorImageUpload';
$route['ad-image-upload'] 				= 'api/adImageUpload';
$route['notification-file-upload'] 		= 'api/notificationFileUpload';
/*********************** ADMIN API ***************************/
$route['admin-order-records']			= 'api/cbsAdmin/ordersRecord';
$route['admin-order-records-search']    = 'api/cbsAdmin/ordersRecordSearch';
$route['transaction-history']    		= 'api/cbsAdmin/customerTransactionHistory';
/*************************** COMPLAINTS *****************************/
$route['apartment-complaint-add'] 		= 'api/apartmentAdmin/addComplaint';
$route['apartment-complaints-list'] 	= 'api/apartmentAdmin/complaintsList';
$route['apartment-complaints-history'] 	= 'api/apartmentAdmin/complaintsHistory';
$route['apartment-complaint-status'] 	= 'api/apartmentAdmin/complaintStatus';
/*************************** PICKUP BOY *****************************/
$route['pickup-boy-payment-orders'] 	= 'api/pickupBoy/paymentOrders';
$route['pickup-boy-catalogitems'] 		= 'api/pickupBoy/catalogitems';
$route['pickup-boy-placeorder'] 		= 'api/pickupBoy/placeorder';
$route['pickup-boy-placeorders'] 		= 'api/pickupBoy/placeorderids';
$route['pickup-boy-add-edit'] 			= 'api/pickupBoy/addEdit';
$route['pickup-boy-status'] 			= 'api/pickupBoy/pickupBoyStatus';
$route['pickup-boy-authentication'] 	= 'api/pickupBoy/authentication';
$route['customer-search'] 				= 'api/pickupBoy/customerSearch';
$route['pickup-boy-search'] 			= 'api/pickupBoy/pickupBoySearch';
$route['pickup-boy-customer-requests'] 	= 'api/pickupBoy/customerRequests';
$route['pickupboys'] 					= 'api/pickupBoy/pickupboys';
$route['pickup-boy-delivery-orders']	= 'api/pickupBoy/pickupBoyDeliveryOrders';
$route['edit-pickupboy'] 				= 'api/pickupBoy/editPickupboy';
$route['cr-status'] 					= 'api/pickupBoy/crStatus';
$route['pickupboy-order-payment'] 		= 'api/pickupBoy/orderPayment';
$route['pickup-boy-order-status'] 		= 'api/pickupBoy/orderStatus';
$route['pickup-order-status'] 		= 'api/pickupBoy/PickupOrderStatus';
$route['pickup-boy-package-orders']     = 'api/pickupBoy/packageOrders';
$route['pickup-boy-package-payment']    = 'api/pickupBoy/packagePayment';
// for areas
$route['api-areas'] 			= 'api/areas';
$route['api-roles']				= 'api/roles';
// for  registration
$route['api-registration'] 		= 'api/registration';
$route['api-getprofile'] 		= 'api/getprofile';
$route['api-updateprofile'] 	= 'api/updateprofile';
// for  services
$route['api-services'] 			= 'api/services';
// for authentication
$route['api-authentication'] 	= 'api/authentication';
// for servoces
$route['api-services'] 			= 'api/services';
// for catalog
$route['api-catalog'] 			= 'api/catalog';
///:(num)/:(num)/:(num)/:(num)
// for place order
$route['api-placeorder'] 		= 'api/placeorder';
$route['api-catalogitems'] 		= 'api/catalogitems';
$route['api-serviceitems'] 		= 'api/serviceitems';
$route['api-settings'] 			= 'api/settings';
$route['api-getrpoints'] 		= 'api/getrpoints';
$route['api-getaddress'] 		= 'api/getaddress';
$route['api-postaddress'] 		= 'api/postaddress';
$route['api-updateaddress'] 	= 'api/updateaddress';
$route['api-trash-address'] 	= 'api/trashAddress';
$route['api-placeorderhistory'] = 'api/placeorderhistory';
$route['api-placeorderids'] 	= 'api/placeorderids';
$route['api-changepwd'] 		= 'api/changepwd';
$route['api-reset-password'] 	= 'api/resetPassword';
/***** packages *********/
$route['customer-packages']		= 'api/customerPackages';
$route['get-package']			= 'api/getPackage';
$route['cbs-packages']			= 'api/cbsAdmin/cbsPackages';
$route['api-premiumcustomers']	= 'api/premiumCustomers';
$route['current-packages']		= 'api/cbsAdmin/currentPackages';
$route['add-customer-package']	= 'api/storeAdmin/addCustomerPackage';
$route['catalog-price-items']     		= 'api/cbsAdmin/catalogPirceItems';
$route['addon-items']					= 'api/cbsAdmin/addonItems';
$route['add-edit-package']				= 'api/cbsAdmin/addEditPackage';
/*******************************************************/
/************* AMS ROUTINGS ***************/
/*******************************************************/
$route['ams-authentication'] 			= 'api/ams/authentication';
$route['ams-fm-registration'] 			= 'api/ams/fmregistration';
$route['ams-fm-status'] 				= 'api/ams/fmstatus';
$route['ams-family-members'] 			= 'api/ams/familymembers';
//$route['ams-vehicle-registration'] = 'api/ams/vehicleregistration';
$route['ams-vehicles'] 					= 'api/ams/vehicles';
$route['ams-family-members'] 			= 'api/ams/familymembers';
$route['ams-family-members'] 			= 'api/ams/familymembers';
$route['ams-family-members'] 			= 'api/ams/familymembers';
// visitor registration
$route['ams-visitor-search'] 			= 'api/ams/visitorsearch'; //k
$route['ams-customer-visitor-reg'] 		= 'api/ams/customervisitorregistration'; // k
$route['ams-faculty-visitor-reg'] 		= 'api/ams/facultyvisitorregistration'; //k
$route['ams-freq-visitor-reg'] 			= 'api/ams/frequentvisitorregistration'; //k
$route['ams-faculty-visitor-status'] 	= 'api/ams/facultyvisitorstatus'; //k
$route['ams-flat-visitor-status'] 		= 'api/ams/flatvisitorstatus'; //k
$route['ams-visitor-vs-frequent'] 		= 'api/ams/visitorvsfrequent';
$route['ams-flat-freq-visitor-list'] 	= 'api/ams/flatfrequentvisitorlist'; //k
$route['ams-apart-freq-visitor-list'] 	= 'api/ams/apartmentfrequentvisitorlist'; //k
$route['ams-flat-visitors'] 			= 'api/ams/flatvisitors'; //k
$route['ams-flat-unknown-visitors'] 	= 'api/ams/flatunknownvisitors'; //k
$route['ams-flat-visitor-history'] 		= 'api/ams/flatvisitorhistory';
$route['ams-apartment-visitors'] 		= 'api/ams/apartmentvisitors';
$route['ams-apartment-visitors-history'] = 'api/ams/apartmentvisitorshistory'; //k
$route['ams-telephone-directory'] 		= 'api/ams/telephonedirectory';
$route['ams-trash-visitor'] 			= 'api/ams/trashvisitor';
/****************************************************************/
/******************* ADMIN NOTIFICATIONS ************************/
/****************************************************************/
$route['ams-aa-notification-types'] 	= 'api/ams/aanotificationtypes';
$route['ams-aa-bulk-notifications'] 	= 'api/ams/aabulknotifications';
///$route['ams-aa-notifications'] 			= 'api/storeAdmin/aanotifications';
$route['ams-aa-notifications'] 			= 'api/ams/aanotifications';
//$route['ams-aa-flat-notifications'] = 'api/ams/aaflatnotifications';
$route['ams-aa-bulk-notification-send'] = 'api/ams/aabulknotifsend';
$route['ams-aa-notification-send'] 		= 'api/ams/aanotificationsend';
//$route['ams-aa-flat-notification-send'] = 'api/ams/aafnsend';
$route['ams-vendor-save']				= 'api/ams/vendorSave';
$route['ams-vendors']					= 'api/ams/vendors';
$route['ams-vendor-status']				= 'api/ams/vendorStatus';
$route['ams-staff-save']				= 'api/ams/staffSave';
$route['ams-staff']						= 'api/ams/staff';
$route['ams-staff-status']				= 'api/ams/staffStatus';
$route['flats-sale']					= 'api/ams/flatsSale';
$route['flats-rent']					= 'api/ams/flatsRent';
$route['api-sms']						= 'api/sendSMS';
// reports
$route['reports-store-orders'] 			= 'api/reports/storeWiseOrders';
$route['reports-store-revenue'] 		= 'api/reports/storeWiseRevenue';
$route['reports-store-garments'] 		= 'api/reports/storeWiseGarments';
$route['reports-store-balance'] 		= 'api/reports/storeWiseBalance';
$route['reports-store-paid-amount'] 	= 'api/reports/storeWisePaidAmount';
$route['reports-store-discount-amount'] = 'api/reports/storeWiseDiscountAmount';
$route['reports-store-garment-amount'] 	= 'api/reports/storeWiseReturnGarmentAmount';
$route['reports-store-return-garments'] = 'api/reports/storeWiseReturnGarments';
$route['reports-order-by-status'] 		= 'api/reports/ordersByStatus';
$route['reports-customers'] 			= 'api/reports/customersByDate';
$route['store-dashboard']				= 'api/storeAdmin/dashBoard';
$route['super-admin-dashboard']			= 'api/storeAdmin/superAdmindashBoard';
$route['dashboard-details']				= 'api/storeAdmin/dashBoardDetails';
$route['storewise-collection']			= 'api/reports/storewiseCollection';
//packages
$route['customer-package-orders']		= 'api/storeAdmin/customerPackageOrders';
$route['package-assign-to-pickupboy']	= 'api/storeAdmin/pickupboyAssignCustomerPackage';
$route['api/example/users/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'api/example/users/id/$1/format/$3$4'; // Example 8

// 10jul2018 onwords

$route['superadmin-discount-report'] = 'api/reports/storeWiseDiscountReport';
