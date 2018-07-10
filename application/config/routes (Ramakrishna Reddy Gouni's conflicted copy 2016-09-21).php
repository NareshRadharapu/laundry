<?php

defined('BASEPATH') OR exit('No direct script access allowed');
$route['default_controller'] 	= 'admin';
$route['404_override'] 			= '';
$route['translate_uri_dashes'] 	= FALSE;


$route['api-apartments'] 		= 'api/apartments';
$route['api-itemtypes'] 		= 'api/itemtypes';
$route['api-blocks'] 			= 'api/blocks';
$route['api-flats'] 			= 'api/flats';
$route['api-flat'] 				= 'api/flat';
$route['api-ownerflats'] 		= 'api/ownerflats';
$route['api-flatupdate'] 		= 'api/flatupdate';



/************************************************************/

$route['store-authentication'] 			= 'api/storeAdmin/authentication';
$route['store-pre-process-order']		= 'api/storeAdmin/preprocessorder';
$route['store-process-order']			= 'api/storeAdmin/processorder';
$route['store-process-order-details']	= 'api/storeAdmin/processOrderDetails';
$route['store-order-receipt'] 			= 'api/storeAdmin/orderReceipt';
$route['store-tash-temp-orders'] 		= 'api/storeAdmin/trashTempOrders';
$route['store-order-ready-for-deliver'] = 'api/storeAdmin/readyForDeliver';

$route['customer-orders'] 				= 'api/storeAdmin/customerOrders';
$route['store-pickup-boys'] 			= 'api/storeAdmin/storePickupBoys';
$route['store-customer-wallet'] 		= 'api/storeAdmin/walletZero';

$route['store-order-change'] 			= 'api/storeAdmin/changeOrderStatus';

$route['store-return-garments'] 		= 'api/storeAdmin/returnGarments';
$route['store-return-garment'] 			= 'api/storeAdmin/returnGarment';

$route['store-hold-garments'] 			= 'api/storeAdmin/holdGarments';


$route['order-return-garments'] 		= 'api/storeAdmin/orderReturnGarments';
$route['global-search'] 				= 'api/storeAdmin/globalSearch';






/**************** CUSTOMER REQUEST *************************/

$route['customer-requests'] 			= 'api/storeAdmin/customerRequests';
$route['customer-add-request'] 			= 'api/storeAdmin/customerAddRequest';
$route['customer-request-assign'] 		= 'api/storeAdmin/customerRequestAssign';

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
$route['employees']						= 'api/cbsAdmin/employees';

$route['edit-employee']					= 'api/cbsAdmin/editEmployee';

$route['cu-authentication'] 			= 'api/cUnit/authentication';

$route['cu-employee']					= 'api/cbsAdmin/CUEmployee';
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

$route['cu-order-details-trash']		= 'api/cbsAdmin/cuOrderDetailsTrash';
$route['cu-order-details']				= 'api/cbsAdmin/cuOrderDetails';
$route['cus-order-details']				= 'api/cbsAdmin/cusOrderDetails';
$route['cud-order-details']				= 'api/cbsAdmin/cudOrderDetails';
$route['cu-process-orders']				= 'api/cbsAdmin/cuProcessOrders';
$route['cu-do-delivery-order']			= 'api/cbsAdmin/doDeliveryOrder';

$route['order-status']					= 'api/cbsAdmin/cuOrderStatus';
$route['order-item-status']				= 'api/cbsAdmin/cuOrderItemStatus';

$route['cua-send-order-status']			= 'api/cbsAdmin/cuAdminSendOrderStatus';

$route['cu-stores']						= 'api/cbsAdmin/cuStores';

$route['cu-apartment-stores']			= 'api/cbsAdmin/cuAprtmentStores';

$route['cu-return-garment']				= 'api/cbsAdmin/returnGarment';
$route['cu-return-garments']			= 'api/cbsAdmin/returnGarments';

$route['cu-hold-garment']				= 'api/cbsAdmin/holdGarment';
$route['cu-hold-garments']				= 'api/cbsAdmin/holdGarments';


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
$route['edit-pickupboy'] 				= 'api/pickupBoy/editPickupboy';
$route['cr-status'] 					= 'api/pickupBoy/crStatus';


$route['pickup-boy-order-status'] 		= 'api/pickupBoy/orderStatus';


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


$route['api/example/users/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'api/example/users/id/$1/format/$3$4'; // Example 8
