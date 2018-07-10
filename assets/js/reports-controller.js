
/*  Start CityController */

/*****************************************************/
/****************** Login Controller *****************/
/*****************************************************/
angular.module('colorAdminApp')
.controller('OrdersReportController',['$rootScope','$scope','$http','$location','NgTableParams','ngNotify','Auth', function($rootScope,$scope,$http,$location,NgTableParams,ngNotify,Auth){
  	$scope.selectedDate  = {};
	$scope.selectedDate  = new Date();
	$scope.showOrderStatusModal = false;

	$scope.totalRecords = 0;
	var areaId = Auth.getAreaId();
	var userObj = localStorage.getItem('laundry_admin_user_obj');
	$scope.userRole = JSON.parse(userObj).employee.role;

  	$scope.ordersdata = {rtype:'',fromDate:'',toDate:''};

  	var monthsList = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
  
  	$scope.fromDateSelected =  (new Date().getMonth() + 1) + '/' + new Date().getDate() + '/' +(new Date().getFullYear());
	$scope.dateSelected =  (new Date().getMonth()+ 1) + '/' +new Date().getDate() + '/' + (new Date().getFullYear());
	$('#datepicker-default-from').datepicker({
		setDate: new Date(),
		todayHighlight: true,
		format: 'dd/MM/yyyy'
	});
	
	$('#datepicker-default-to').datepicker({
		setDate: new Date(),
		todayHighlight: true,
		format: 'dd/MM/yyyy'
	});
	
	$scope.filterOrdersBydate= function(){
		$scope.ordersdata.fromDate = new Date($('#datepicker-default-from').val());;
		$scope.ordersdata.toDate = new Date($('#datepicker-default-to').val());
		$scope.getReport();
		$scope.ordersdata.apply;		
	};

	$scope.applyGlobalSearch = function() {
		$scope.tableParams.filter({ $: $scope.search });
	}
	$scope.reports = [];

	$scope.getReport = function(){
		$http.post(ldh+'reports-store-orders',$scope.ordersdata).success(function(response, status){
  		var totalOrders = 0;
  		var res = response.reports;
		for(var i in res){
			
			totalOrders +=parseInt(res[i].totalOrders);
		}
		$scope.totalRecords = totalOrders;
		$scope.totalRecords.apply;
		$scope.tableParams = new NgTableParams({ count: 50 }, {counts: [50, 100, 200],  dataset: res});
	    //$scope.tableParams = new NgTableParams({}, {  dataset: res});
	  }).error(function(err){
	      console.log(err);
	  });
	};
	$scope.getReport();
}])
.controller('VendorsReportController', ['$scope', '$http', 'Auth', 'pagination', 'ngNotify', 'NgTableParams', function($scope, $http, $Auth, $pagination, ngNotify, NgTableParams) {
    var areaId = $Auth.getAreaId();
    $scope.applyGlobalSearch = function() {
        $scope.tableParams.filter({ $: $scope.search });
    }
    var userObj = localStorage.getItem('laundry_admin_user_obj');
    $scope.userRole = JSON.parse(userObj).employee.role;

    $scope.ordersdata = { fromDate: '', toDate: '' };
    var monthsList = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    $scope.fromDateSelected = (new Date().getMonth() + 1) + '/' + new Date().getDate() + '/' + (new Date().getFullYear());
    $scope.dateSelected = (new Date().getMonth() + 1) + '/' + new Date().getDate() + '/' + (new Date().getFullYear());
    $('#datepicker-default-from').datepicker({
        setDate: new Date(),
        todayHighlight: true,
        format: 'dd/MM/yyyy'
    });
    $('#datepicker-default-to').datepicker({
        setDate: new Date(),
        todayHighlight: true,
        format: 'dd/MM/yyyy'
    });
    $scope.filterOrdersBydate = function() {
        $scope.ordersdata.fromDate = new Date($('#datepicker-default-from').val());;
        $scope.ordersdata.toDate = new Date($('#datepicker-default-to').val());
        $scope.getVendorsReport();
        $scope.ordersdata.apply;
    };
    $scope.applyGlobalSearch = function() {
        $scope.tableParams.filter({ $: $scope.search });
    }
    $scope.getVendorsReport = function() {
        $http.post(ldh + 'vendors-report', $scope.ordersdata).success(function(response, status) {
            console.log("response", response);            
            $scope.tableParams = new NgTableParams({ count: 20, sorting: { id: "asc" } }, { counts: [25, 50, 100], dataset: response });
        }).error(function(err) {
            console.log("err", err);
        });
    };
    $scope.getVendorOrders = function($a) {
        console.log("vId", $a);
        $scope.vId = $a;
        $http.post(ldh + 'vendor-orders',{vId: $scope.vId}).success(function(response, status) {
            console.log("response", response);  
            $scope.vendorOrders = response;          
            //$scope.tableParams = new NgTableParams({ count: 20, sorting: { id: "asc" } }, { counts: [25, 50, 100], dataset: response });
        }).error(function(err) {
            console.log("err", err);
        });
    };

    $scope.getVendorsReport();
}])
.controller('RevenueReportController',['$rootScope','$scope','$http','$location','NgTableParams','ngNotify','Auth', function($rootScope,$scope,$http,$location,NgTableParams,ngNotify,Auth){
  	$scope.selectedDate  = {};
	$scope.selectedDate  = new Date();
	$scope.showOrderStatusModal = false;
	var areaId = Auth.getAreaId();
	var userObj = localStorage.getItem('laundry_admin_user_obj');
	$scope.userRole = JSON.parse(userObj).employee.role;

  	$scope.ordersdata = {rtype:'',fromDate:'',toDate:''};

  	var monthsList = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
  
  	$scope.fromDateSelected =  (new Date().getMonth()+1) + '/' + new Date().getDate() + '/' +(new Date().getFullYear());
	$scope.dateSelected =  (new Date().getMonth()+1) + '/' +new Date().getDate() + '/' + (new Date().getFullYear());
	$('#datepicker-default-from').datepicker({
		setDate: new Date(),
		todayHighlight: true,
		format: 'dd/MM/yyyy'
	});
	
	$('#datepicker-default-to').datepicker({
		setDate: new Date(),
		todayHighlight: true,
		format: 'dd/MM/yyyy'
	});
	
	$scope.filterOrdersBydate= function(){
		$scope.ordersdata.fromDate = new Date($('#datepicker-default-from').val());;
		$scope.ordersdata.toDate = new Date($('#datepicker-default-to').val());
		$scope.getReport();		
	};

	$scope.applyGlobalSearch = function() {
		$scope.tableParams.filter({ $: $scope.search });
	}
	$scope.reports = [];

	$scope.getReport = function(){
		$http.post(ldh+'reports-store-revenue',$scope.ordersdata).success(function(response, status){
  		
  		var totalRevenue = 0;
  		var res = response.reports;
		for(var i in res){
			
			totalRevenue +=parseInt(res[i].revenue);
		}
		$scope.totalRevenue = totalRevenue;
		$scope.totalRevenue.apply;
	    $scope.tableParams = new NgTableParams({ count: 50 }, {counts: [50, 100, 200],  dataset: response.reports});
	  }).error(function(err){
	      console.log(err);
	  });
	};
	$scope.getReport();
}]) 
.controller('GarmentsReportController',['$rootScope','$scope','$http','$location','NgTableParams','ngNotify','Auth', function($rootScope,$scope,$http,$location,NgTableParams,ngNotify,Auth){
  	$scope.selectedDate  = {};
	$scope.selectedDate  = new Date();
	$scope.showOrderStatusModal = false;
	var areaId = Auth.getAreaId();
	var userObj = localStorage.getItem('laundry_admin_user_obj');
	$scope.userRole = JSON.parse(userObj).employee.role;

  	$scope.ordersdata = {rtype:'',fromDate:'',toDate:''};

  	var monthsList = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
  
  	$scope.fromDateSelected =  (new Date().getMonth()+1) + '/' + new Date().getDate() + '/' +(new Date().getFullYear());
	$scope.dateSelected =  (new Date().getMonth()+1) + '/' +new Date().getDate() + '/' + (new Date().getFullYear());
	$('#datepicker-default-from').datepicker({
		setDate: new Date(),
		todayHighlight: true,
		format: 'dd/MM/yyyy'
	});
	
	$('#datepicker-default-to').datepicker({
		setDate: new Date(),
		todayHighlight: true,
		format: 'dd/MM/yyyy'
	});
	
	$scope.filterOrdersBydate= function(){
		$scope.ordersdata.fromDate = new Date($('#datepicker-default-from').val());;
		$scope.ordersdata.toDate = new Date($('#datepicker-default-to').val());
		$scope.getReport();		
	};

	$scope.applyGlobalSearch = function() {
		$scope.tableParams.filter({ $: $scope.search });
	}
	$scope.reports = [];

	$scope.getReport = function(){
		$http.post(ldh+'reports-store-garments',$scope.ordersdata).success(function(response, status){
  		
  		var totalGcount = 0;
  		var res = response.reports;
		for(var i in res){
			
			totalGcount +=parseInt(res[i].gcount);
		}
		$scope.totalGcount = totalGcount;
		$scope.totalGcount.apply;

		$scope.tableParams = new NgTableParams({ count: 200 }, {counts: [200, 300, 500, 1000],  dataset: response.reports});
	  }).error(function(err){
	      console.log(err);
	  });
	};
	$scope.getReport();
}]) 

colorAdminApp.controller('StorewiseCollectionController', ['$scope', '$rootScope', '$state', '$http', 'Auth', function($scope, $rootScope, $state, $http, Auth) {
	$scope.dashboard = {};
	$scope.userRole = Auth.getRole();
	console.log($scope.userRole);
	$scope.today = new Date();
    console.log($scope.today);

	$scope.result = {};
	$scope.detailsIn = {};
	$scope.dcTotal = 0;
	$scope.dcItemsTotal = 0;
	$scope.siTotal = 0;
	$scope.siItemsTotal = 0;
	$scope.wiTotal = 0;
	$scope.wiItemsTotal = 0;
	$scope.roTotal = 0;
	$scope.roItemsTotal = 0;
	$scope.dnTotal = 0;
	$scope.dnItemsTotal = 0;
	$scope.cwTotal = 0;
	$scope.cwItemsTotal = 0;
	$scope.collectionsTotal = 0;
	$scope.CashTotal = 0;
	$scope.PayTMTotal = 0;
	$scope.CreditCardTotal = 0;
	$scope.DebitCardTotal = 0;
	$scope.OnlineTransferTotal = 0;
	$scope.ChequeTotal=0;
	$scope.qdAmountTotal = 0;
	$scope.discountAmountTotal = 0;
	$scope.crrTotal = 0;
	$scope.crcTotal = 0;
	$scope.crdTotal = 0;
	$scope.crssTotal = 0;
	$scope.crapbTotal = 0;
	$scope.cuponsCods = [];
	var storeId = Auth.getAreaId();
	$scope.detailsIn.storeId = storeId;
	$scope.orderPayLoad = { 'storeId': storeId, 'fromDate': '', 'toDate': '' };
	var checkin = $('#fromDate').datepicker({
		setDate: new Date(),
		todayHighlight: true,
		format: 'dd-MM-yyyy',
		endDate: '+0d',
		autoclose: true
	}).on('changeDate', function(ev) {
		if (ev.date.valueOf() > checkout.datepicker("getDate").valueOf() || !checkout.datepicker("getDate").valueOf()) {
			var newDate = new Date(ev.date);
			newDate.setDate(newDate.getDate());
			checkout.datepicker("update", new Date());
		}
		$('#toDatef').focus();
	});
	var checkout = $('#toDatef').datepicker({
		setDate: new Date(),
		todayHighlight: true,
		format: 'dd-MM-yyyy',
		endDate: '+0d',
		autoclose: true
	});
    // changes made by ankit, ends
    $scope.doFilter = function() {
    	$scope.dcTotal = 0;
    	$scope.dcItemsTotal = 0;
    	$scope.siTotal = 0;
    	$scope.siItemsTotal = 0;
    	$scope.wiTotal = 0;
    	$scope.wiItemsTotal = 0;
    	$scope.roTotal = 0;
    	$scope.roItemsTotal = 0;
    	$scope.dnTotal = 0;
    	$scope.dnItemsTotal = 0;
    	$scope.cwTotal = 0;
    	$scope.cwItemsTotal = 0;
    	$scope.collectionsTotal = 0;
    	$scope.CashTotal = 0;
    	$scope.PayTMTotal = 0;
    	$scope.CreditCardTotal = 0;
    	$scope.DebitCardTotal = 0;
    	$scope.OnlineTransferTotal = 0;
		$scope.ChequeTotal=0;
    	$scope.qdAmountTotal = 0;
    	$scope.discountAmountTotal = 0;
    	$scope.crrTotal = 0;
    	$scope.crcTotal = 0;
    	$scope.crdTotal = 0;
    	$scope.crssTotal = 0;
    	$scope.crapbTotal = 0;
    	$scope.cuponsCods = [];
    	var fromDate = new Date($('#fromDate').val());;
    	var toDate = new Date($('#toDatef').val());
    	$scope.orderPayLoad.fromDate = fromDate;
    	$scope.orderPayLoad.toDate = toDate;
    	$scope.getDashBoard();
    };
    $scope.getDashBoard = function() {
    	$http.post(ldh + 'storewise-collection', $scope.orderPayLoad).success(function(response, state) {
    		$scope.dashboard = response;
    		if (typeof(response.ordersTable) == 'object' && response.ordersTable && Object.values(response.ordersTable).length) {
    			var res = Object.values(response.ordersTable);
    			for (var obj in res) {
    				if (typeof(res[obj].DC) == 'undefined') {
    					res[obj].DC = 0;
    					res[obj].DCItems = 0;
    				} else {
    					$scope.dcTotal += parseFloat(res[obj].DC);
    					$scope.dcItemsTotal += parseFloat(res[obj].DCItems);
    				}
    				if (typeof(res[obj].SI) == 'undefined') {
    					res[obj].SI = 0;
    					res[obj].SIItems = 0;
    				} else {
    					$scope.siTotal += parseFloat(res[obj].SI);
    					$scope.siItemsTotal += parseFloat(res[obj].SIItems);
    				}
    				if (typeof(res[obj].WI) == 'undefined') {
    					res[obj].WI = 0;
    					res[obj].WIItems = 0;
    				} else {
    					$scope.wiTotal += parseFloat(res[obj].WI);
    					$scope.wiItemsTotal += parseFloat(res[obj].WIItems);
    				}
    				if (typeof(res[obj].RO) == 'undefined') {
    					res[obj].RO = 0;
    					res[obj].ROItems = 0;
    				} else {
    					$scope.roTotal += parseFloat(res[obj].RO);
    					$scope.roItemsTotal += parseFloat(res[obj].ROItems);
    				}
    				if (typeof(res[obj].DN) == 'undefined') {
    					res[obj].DN = 0;
    					res[obj].DNItems = 0;
    				} else {
    					$scope.dnTotal += parseFloat(res[obj].DN);
    					$scope.dnItemsTotal += parseFloat(res[obj].DNItems);
    				}
    				if (typeof(res[obj].CW) == 'undefined') {
    					res[obj].CW = 0;
    					res[obj].CWItems = 0;
    				} else {
    					$scope.cwTotal += parseFloat(res[obj].CW);
    					$scope.cwItemsTotal += parseFloat(res[obj].CWItems);
    				}
    				if (typeof(res[obj].collections) == 'undefined') {
    					res[obj].collections = 0;
    				} else {
    					$scope.collectionsTotal += parseFloat(res[obj].collections);
    				}
    				if (typeof(res[obj].Cash) == 'undefined') {
    					res[obj].Cash = 0;
    				} else {
    					$scope.CashTotal += parseFloat(res[obj].Cash);
    				}
    				if (typeof(res[obj].PayTM) == 'undefined') {
    					res[obj].PayTM = 0;
    				} else {
    					$scope.PayTMTotal += parseFloat(res[obj].PayTM);
    				}
    				if (typeof(res[obj].OnlineTransfer) == 'undefined') {
    					res[obj].OnlineTransfer = 0;
    				} else {
    					$scope.OnlineTransferTotal += parseFloat(res[obj].OnlineTransfer);
    				}
    				if (typeof(res[obj].Cheque) == 'undefined') {
    					res[obj].Cheque = 0;
    				} else {
    					$scope.ChequeTotal += parseFloat(res[obj].Cheque);
    				}
    				if (typeof(res[obj].CreditCard) == 'undefined') {
    					res[obj].CreditCard = 0;
    				} else {
    					$scope.CreditCardTotal += parseFloat(res[obj].CreditCard);
    				}
    				if (typeof(res[obj].DebitCard) == 'undefined') {
    					res[obj].DebitCard = 0;
    				} else {
    					$scope.DebitCardTotal += parseFloat(res[obj].DebitCard);
    				}
    				if (typeof(res[obj].discountAmount) == 'undefined') {
    					res[obj].discountAmount = 0;
    				} else {
    					$scope.discountAmountTotal += parseFloat(res[obj].discountAmount);
    				}
    				if (typeof(res[obj].qdAmount) == 'undefined') {
    					res[obj].qdAmount = 0;
    				} else {
    					$scope.qdAmountTotal += parseFloat(res[obj].qdAmount);
    				}
    			}
    		}
    		if (typeof(response.crTable) == 'object' && response.crTable && Object.values(response.crTable).length) {
    			var crRes = Object.values(response.crTable);
    			for (var crobj in crRes) {
    				if (typeof(crRes[crobj].CRR) == 'undefined') {
    					crRes[crobj].CRR = 0;
    				} else {
    					$scope.crrTotal += parseInt(crRes[crobj].CRR);
    				}
    				if (typeof(crRes[crobj].CRC) == 'undefined') {
    					crRes[crobj].CRC = 0;
    				} else {
    					$scope.crcTotal += parseInt(crRes[crobj].CRC);
    				}
    				if (typeof(crRes[crobj].CRD) == 'undefined') {
    					crRes[crobj].CRD = 0;
    				} else {
    					$scope.crdTotal += parseInt(crRes[crobj].CRD);
    				}
    				if (typeof(crRes[crobj].CRSS) == 'undefined') {
    					crRes[crobj].CRSS = 0;
    				} else {
    					$scope.crssTotal += parseInt(crRes[crobj].CRSS);
    				}
    				if (typeof(crRes[crobj].CRAPB) == 'undefined') {
    					crRes[crobj].CRAPB = 0;
    				} else {
    					$scope.crapbTotal += parseInt(crRes[crobj].CRAPB);
    				}
    			}
    		}
    		if (typeof(response.cuponsTable) == 'object' && response.cuponsTable && Object.values(response.cuponsTable).length) {
    			var cupnRes = Object.values(response.cuponsTable);
    			var keys = Object.keys(cupnRes[0]);
    			$scope.cuponsCods = keys;
    			console.log("key", keys);
    			for (var cupnobj in cupnRes) {
    				for (var kk in keys) {
    					if (typeof(cupnRes[cupnobj][keys[kk]]) == 'undefined') {
    						cupnRes[cupnobj][keys[kk]] = 0;
    					} else {
    						$scope.Total += parseFloat(cupnRes[cupnobj][keys[kk]]);
    					}
    				}
    			}
    		}
    		console.log("response table", response);
    	}).error(function(err, status, headers) {
    		console.log(err, status, headers);
    	});
    }
    $scope.getDashBoard();
    $scope.showModal = false;
    $scope.ordersInDetails = function(a) {
    	$scope.modalTitle = a + " orders";
    	$scope.showModal = true;
    	$scope.detailsIn.rtype = a;
    	$scope.detailsIn.apply;
    	$scope.detailResult = [];
    	$scope.detailResult.apply;
    	$http.post(ldh + 'dashboard-details', $scope.detailsIn).success(function(response, status) {
    		$scope.detailResult = response;
    		$scope.detailResult.apply;
    		console.log("details response", response);
    	}).error(function(err) {
    		console.log("err", err);
    	});
    };
}])
.controller('BalanceReportController',['$rootScope','$scope','$http','$location','NgTableParams','ngNotify','Auth', function($rootScope,$scope,$http,$location,NgTableParams,ngNotify,Auth){
  	$scope.selectedDate  = {};
	$scope.selectedDate  = new Date();
	$scope.showOrderStatusModal = false;
	var areaId = Auth.getAreaId();
	var userObj = localStorage.getItem('laundry_admin_user_obj');
	$scope.userRole = JSON.parse(userObj).employee.role;

  	$scope.ordersdata = {rtype:'',fromDate:'',toDate:''};

  	var monthsList = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
  
  	$scope.fromDateSelected =  (new Date().getMonth()+1) + '/' + new Date().getDate() + '/' +(new Date().getFullYear());
	$scope.dateSelected =  (new Date().getMonth()+1) + '/' +new Date().getDate() + '/' + (new Date().getFullYear());
	$('#datepicker-default-from').datepicker({
		setDate: new Date(),
		todayHighlight: true,
		format: 'dd/MM/yyyy'
	});
	
	$('#datepicker-default-to').datepicker({
		setDate: new Date(),
		todayHighlight: true,
		format: 'dd/MM/yyyy'
	});
	
	$scope.filterOrdersBydate= function(){
		$scope.ordersdata.fromDate = new Date($('#datepicker-default-from').val());;
		$scope.ordersdata.toDate = new Date($('#datepicker-default-to').val());
		$scope.getReport();		
	};

	$scope.applyGlobalSearch = function() {
		$scope.tableParams.filter({ $: $scope.search });
	}
	$scope.reports = [];

	$scope.getReport = function(){
		$http.post(ldh+'reports-store-balance',$scope.ordersdata).success(function(response, status){
  		
  		var totalBalance = 0;
  		var res = response.reports;
		for(var i in res){
			
			totalBalance +=parseInt(res[i].balanceAmount);
		}
		$scope.totalBalance = totalBalance;
		$scope.totalBalance.apply;
        $scope.tableParams = new NgTableParams({ count: 50 }, {counts: [50, 100, 200],  dataset: response.reports});	    
	  }).error(function(err){
	      console.log(err);
	  });
	};
	$scope.getReport();
}]) 
.controller('PaidAmountReportController',['$rootScope','$scope','$http','$location','NgTableParams','ngNotify','Auth', function($rootScope,$scope,$http,$location,NgTableParams,ngNotify,Auth){
  	$scope.selectedDate  = {};
	$scope.selectedDate  = new Date();
	$scope.showOrderStatusModal = false;
	var areaId = Auth.getAreaId();
	var userObj = localStorage.getItem('laundry_admin_user_obj');
	$scope.userRole = JSON.parse(userObj).employee.role;
     function getAreasList() {
        $http.get(ldh + 'api-areas')
        .then(function(response, status) {
            $scope.areasList = response.data;
            console.log($scope.areasList);
        }, function(error) {
            console.log(error);
        });
    }
     getAreasList();

  	$scope.ordersdata = {rtype:'',fromDate:'',toDate:''};

  	var monthsList = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
  
  	$scope.fromDateSelected =  (new Date().getMonth()+1) + '/' + new Date().getDate() + '/' +(new Date().getFullYear());
	$scope.dateSelected =  (new Date().getMonth()+1) + '/' +new Date().getDate() + '/' + (new Date().getFullYear());
	$('#datepicker-default-from').datepicker({
		setDate: new Date(),
		todayHighlight: true,
		format: 'dd/MM/yyyy'
	});
	
	$('#datepicker-default-to').datepicker({
		setDate: new Date(),
		todayHighlight: true,
		format: 'dd/MM/yyyy'
	});
	
	$scope.filterOrdersBydate= function(){
		$scope.ordersdata.fromDate = new Date($('#datepicker-default-from').val());;
		$scope.ordersdata.toDate = new Date($('#datepicker-default-to').val());
		$scope.getReport();		
	};

	$scope.applyGlobalSearch = function() {
		$scope.tableParams.filter({ $: $scope.search });
	}
	$scope.reports = [];

	$scope.getReport = function(){
		$http.post(ldh+'reports-store-paid-amount',$scope.ordersdata).success(function(response, status){
  		
  		var totalPaidAmount = 0;
  		var res = response.reports;
		for(var i in res){
			
			totalPaidAmount +=parseInt(res[i].paidAmount);
		}
		$scope.totalPaidAmount = totalPaidAmount;
		$scope.totalPaidAmount.apply;
		$scope.tableParams = new NgTableParams({ count: 50 }, {counts: [50, 100, 200],  dataset: response.reports});
	  }).error(function(err){
	      console.log(err);
	  });
	};
	$scope.getReport();
}]) 
.controller('DiscountAmountReportController',['$rootScope','$scope','$http','$location','NgTableParams','ngNotify','Auth', function($rootScope,$scope,$http,$location,NgTableParams,ngNotify,Auth){
  	$scope.selectedDate  = {};
	$scope.selectedDate  = new Date();
	$scope.showOrderStatusModal = false;
	var areaId = Auth.getAreaId();
	var userObj = localStorage.getItem('laundry_admin_user_obj');
	$scope.userRole = JSON.parse(userObj).employee.role;

  	$scope.ordersdata = {rtype:'',fromDate:'',toDate:''};

  	var monthsList = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
  
  	$scope.fromDateSelected =  (new Date().getMonth()+1) + '/' + new Date().getDate() + '/' +(new Date().getFullYear());
	$scope.dateSelected =  (new Date().getMonth()+1) + '/' +new Date().getDate() + '/' + (new Date().getFullYear());
	$('#datepicker-default-from').datepicker({
		setDate: new Date(),
		todayHighlight: true,
		format: 'dd/MM/yyyy'
	});
	
	$('#datepicker-default-to').datepicker({
		setDate: new Date(),
		todayHighlight: true,
		format: 'dd/MM/yyyy'
	});
	
	$scope.filterOrdersBydate= function(){
		$scope.ordersdata.fromDate = new Date($('#datepicker-default-from').val());;
		$scope.ordersdata.toDate = new Date($('#datepicker-default-to').val());
		$scope.getReport();		
	};

	$scope.applyGlobalSearch = function() {
		$scope.tableParams.filter({ $: $scope.search });
	}
	$scope.reports = [];

	$scope.getReport = function(){
		$http.post(ldh+'reports-store-discount-amount',$scope.ordersdata).success(function(response, status){
  		var totalDiscountAmount = 0;
  		var res = response.reports;
		for(var i in res){
			
			totalDiscountAmount +=parseInt(res[i].adminDiscountAmount);
		}
		$scope.totalDiscountAmount = totalDiscountAmount;
		$scope.totalDiscountAmount.apply;
		$scope.tableParams = new NgTableParams({ count: 50 }, {counts: [50, 100, 200],  dataset: response.reports});
	  }).error(function(err){
	      console.log(err);
	  });
	};
	$scope.getReport();
}]) 
.controller('GarmentsAmountReportController',['$rootScope','$scope','$http','$location','NgTableParams','ngNotify','Auth', function($rootScope,$scope,$http,$location,NgTableParams,ngNotify,Auth){
  	$scope.selectedDate  = {};
	$scope.selectedDate  = new Date();
	$scope.showOrderStatusModal = false;
	var areaId = Auth.getAreaId();
	var userObj = localStorage.getItem('laundry_admin_user_obj');
	$scope.userRole = JSON.parse(userObj).employee.role;

  	$scope.ordersdata = {rtype:'',fromDate:'',toDate:''};

  	var monthsList = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
  
  	$scope.fromDateSelected =  (new Date().getMonth()+1) + '/' + new Date().getDate() + '/' +(new Date().getFullYear());
	$scope.dateSelected =  (new Date().getMonth()+1) + '/' +new Date().getDate() + '/' + (new Date().getFullYear());
	$('#datepicker-default-from').datepicker({
		setDate: new Date(),
		todayHighlight: true,
		format: 'dd/MM/yyyy'
	});
	
	$('#datepicker-default-to').datepicker({
		setDate: new Date(),
		todayHighlight: true,
		format: 'dd/MM/yyyy'
	});
	
	$scope.filterOrdersBydate= function(){
		$scope.ordersdata.fromDate = new Date($('#datepicker-default-from').val());;
		$scope.ordersdata.toDate = new Date($('#datepicker-default-to').val());
		$scope.getReport();		
	};

	$scope.applyGlobalSearch = function() {
		$scope.tableParams.filter({ $: $scope.search });
	}
	$scope.reports = [];

	$scope.getReport = function(){
		$http.post(ldh+'reports-store-garment-amount',$scope.ordersdata).success(function(response, status){
  		var totalReturnGarments = 0;
  		var res = response.reports;
		for(var i in res){
			
			totalReturnGarments +=parseInt(res[i].garments);
		}
		$scope.totalReturnGarments = totalReturnGarments;
		$scope.totalReturnGarments.apply;
		$scope.tableParams = new NgTableParams({ count: 50 }, {counts: [50, 100, 200],  dataset: response.reports});
	    
	  }).error(function(err){
	      console.log(err);
	  });
	};
	$scope.getReport();
}]) 

.controller('CustomersReportController',['$rootScope','$scope','$http','$location','NgTableParams','ngNotify','Auth', function($rootScope,$scope,$http,$location,NgTableParams,ngNotify,Auth){
  	$scope.selectedDate  = {};
	$scope.selectedDate  = new Date();
	$scope.showOrderStatusModal = false;
	var areaId = Auth.getAreaId();
	var userObj = localStorage.getItem('laundry_admin_user_obj');
	$scope.userRole = JSON.parse(userObj).employee.role;

  	$scope.ordersdata = {rtype:'',fromDate:'',toDate:''};

  	var monthsList = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
  
  	$scope.fromDateSelected =  (new Date().getMonth()+1) + '/' + new Date().getDate() + '/' +(new Date().getFullYear());
	$scope.dateSelected =  (new Date().getMonth()+1) + '/' +new Date().getDate() + '/' + (new Date().getFullYear());
	$('#datepicker-default-from').datepicker({
		setDate: new Date(),
		todayHighlight: true,
		format: 'dd/MM/yyyy'
	});
	
	$('#datepicker-default-to').datepicker({
		setDate: new Date(),
		todayHighlight: true,
		format: 'dd/MM/yyyy'
	});
	
	$scope.filterOrdersBydate= function(){
		$scope.ordersdata.fromDate = new Date($('#datepicker-default-from').val());;
		$scope.ordersdata.toDate = new Date($('#datepicker-default-to').val());
		$scope.getReport();		
	};

	$scope.applyGlobalSearch = function() {
		$scope.tableParams.filter({ $: $scope.search });
	}
	$scope.reports = [];

	$scope.getReport = function(){
		$http.post(ldh+'reports-customers',$scope.ordersdata).success(function(response, status){
  		var totalCustomers = 0;
  		var res = response.reports;
		for(var i in res){
			
			totalCustomers +=parseInt(res[i].totalCustomers);
		}
		$scope.totalCustomers = totalCustomers;
		$scope.totalCustomers.apply;
		$scope.tableParams = new NgTableParams({ count: 50 }, {counts: [50, 100, 200],  dataset: response.reports});		$scope.tableParams = new NgTableParams({ count: 50 }, {counts: [50, 100, 200],  dataset: response.reports});
	    
	  }).error(function(err){
	      console.log(err);
	  });
	};
	$scope.getReport();
}]) 

.controller('OrderByStatusReportController',['$rootScope','$scope','$http','$location','NgTableParams','ngNotify','Auth', function($rootScope,$scope,$http,$location,NgTableParams,ngNotify,Auth){
  	$scope.selectedDate  = {};
	$scope.selectedDate  = new Date();
	$scope.showOrderStatusModal = false;
	var areaId = Auth.getAreaId();
	var userObj = localStorage.getItem('laundry_admin_user_obj');
	$scope.userRole = JSON.parse(userObj).employee.role;

  	$scope.ordersdata = {rtype:'',fromDate:'',toDate:''};

  	var monthsList = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
  
  	$scope.fromDateSelected =  (new Date().getMonth()+1) + '/' + new Date().getDate() + '/' +(new Date().getFullYear());
	$scope.dateSelected =  (new Date().getMonth()+1) + '/' +new Date().getDate() + '/' + (new Date().getFullYear());
	$('#datepicker-default-from').datepicker({
		setDate: new Date(),
		todayHighlight: true,
		format: 'dd/MM/yyyy'
	});
	
	$('#datepicker-default-to').datepicker({
		setDate: new Date(),
		todayHighlight: true,
		format: 'dd/MM/yyyy'
	});
	
	$scope.filterOrdersBydate= function(){
		$scope.ordersdata.fromDate = new Date($('#datepicker-default-from').val());;
		$scope.ordersdata.toDate = new Date($('#datepicker-default-to').val());
		$scope.getReport();		
	};

	$scope.applyGlobalSearch = function() {
		$scope.tableParams.filter({ $: $scope.search });
	}
	$scope.reports = [];

	$scope.getReport = function(){
		$http.post(ldh+'reports-order-by-status',$scope.ordersdata).success(function(response, status){
  		
  		var totalStatus = 0;
  		var res = response.reports;
		for(var i in res){
			
			totalStatus +=parseInt(res[i].totalOrders);
		}
		$scope.totalStatus = totalStatus;
		$scope.totalStatus.apply;
		$scope.tableParams = new NgTableParams({ count: 100 }, {counts: [100, 200, 300],  dataset: response.reports});		$scope.tableParams = new NgTableParams({ count: 50 }, {counts: [50, 100, 200],  dataset: response.reports});
	    
	  }).error(function(err){
	      console.log(err);
	  });
	};
	$scope.getReport();
}]) 
.controller('ReturnGarmentsReportController',['$rootScope','$scope','$http','$location','NgTableParams','ngNotify','Auth', function($rootScope,$scope,$http,$location,NgTableParams,ngNotify,Auth){
  	$scope.selectedDate  = {};
	$scope.selectedDate  = new Date();
	$scope.showOrderStatusModal = false;
	var areaId = Auth.getAreaId();
	var userObj = localStorage.getItem('laundry_admin_user_obj');
	$scope.userRole = JSON.parse(userObj).employee.role;

  	$scope.ordersdata = {rtype:'',fromDate:'',toDate:''};

  	var monthsList = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
  
  	$scope.fromDateSelected =  (new Date().getMonth()+1) + '/' + new Date().getDate() + '/' +(new Date().getFullYear());
	$scope.dateSelected =  (new Date().getMonth()+1) + '/' +new Date().getDate() + '/' + (new Date().getFullYear());
	$('#datepicker-default-from').datepicker({
		setDate: new Date(),
		todayHighlight: true,
		format: 'dd/MM/yyyy'
	});
	
	$('#datepicker-default-to').datepicker({
		setDate: new Date(),
		todayHighlight: true,
		format: 'dd/MM/yyyy'
	});
	
	$scope.filterOrdersBydate= function(){
		$scope.ordersdata.fromDate 	= new Date($('#datepicker-default-from').val());;
		$scope.ordersdata.toDate 	= new Date($('#datepicker-default-to').val());
		$scope.getReport();		
	};

	$scope.applyGlobalSearch = function() {
		$scope.tableParams.filter({ $: $scope.search });
	}
	$scope.reports = [];

	$scope.getReport = function(){
		$http.post(ldh+'reports-store-return-garments',$scope.ordersdata).success(function(response, status){
  		var totalReturnGarments = 0;
  		var res = response.reports;
		for(var i in res){
			
			totalReturnGarments +=parseInt(res[i].garments);
		}
		$scope.totalReturnGarments = totalReturnGarments;
		$scope.totalReturnGarments.apply;
		$scope.tableParams = new NgTableParams({ count: 50 }, {counts: [50, 100, 200],  dataset: response.reports});		$scope.tableParams = new NgTableParams({ count: 50 }, {counts: [50, 100, 200],  dataset: response.reports});

	  }).error(function(err){
	      console.log(err);
	  });
	};
	$scope.getReport();
}]) 

.controller('CustomerDatewisePaymentController',['$rootScope','$scope','$http','$location','NgTableParams','ngNotify','Auth', function($rootScope,$scope,$http,$location,NgTableParams,ngNotify,Auth){
  	$scope.selectedDate  = {};
	$scope.selectedDate  = new Date();
	$scope.showOrderStatusModal = false;
	var areaId = Auth.getAreaId();
	var userObj = localStorage.getItem('laundry_admin_user_obj');
	$scope.userRole = JSON.parse(userObj).employee.role;

	$scope.applyGlobalSearch = function() {
		$scope.tableParams.filter({ $: $scope.search });
	}
	$scope.reports = [];

	$scope.areas =[];
 	$http.get(ldh+'admin/areas/listsz').success(function(response,status){
 		console.log(response);
 		$scope.areas = response;
 		$scope.areas.apply;
 	}).error(function(error){
 		console.log(error);
 	});
 	$('#dDate').datepicker({
        todayHighlight: true,
        format: 'yyyy-mm-dd'
    });

}]) 

.controller('ActivePassiveCustomersController',['$rootScope','$scope','$http','$location','NgTableParams','ngNotify','Auth', function($rootScope,$scope,$http,$location,NgTableParams,ngNotify,Auth){
  	$scope.selectedDate  = {};
	$scope.selectedDate  = new Date();
	$scope.showOrderStatusModal = false;
	//var storeId = Auth.getAreaId();
	var activeCount = 15;
	var userObj = localStorage.getItem('laundry_admin_user_obj');
	$scope.userRole = JSON.parse(userObj).employee.role;

	$scope.applyGlobalSearch = function() {
		$scope.tableParams.filter({ $: $scope.search });
	}
	$scope.reports = [];

	$scope.areas =[];
 	$http.get(ldh+'admin/areas/listsz').success(function(response,status){
 		//console.log(response);
 		$scope.areas = response;
 		$scope.areas.apply;
 	}).error(function(error){
 		console.log(error);
 	});
 	$('#dDate').datepicker({
        todayHighlight: true,
        format: 'yyyy-mm-dd'
    });
    $scope.resultKeys = [];
 	$scope.reportResult = {};

 	function getReportDetails(storeId){
 		console.log("storeId",storeId);
 		 $http.post(ldh+'store-report',{'storeId':storeId})
    		.success(function(response,status){

    	var pk='';
    	angular.forEach(response, function(obj,k){
    		obj.passiveCustomers = obj.totalCustomers - obj.activeCustomers - obj.newCustomers;
    		obj.avgOrderCount = Math.round(obj.totalOrders/(obj.activeCustomers + obj.newCustomers));
    		obj.avgOrderValue = Math.round(obj.totalSales/obj.activeCustomers);

    		if(pk!=''){
			var prevSales,presntSales,
				prevOrders,presntOrders,
				prevNewCustomers,presntNewCustomers,
				prevTotalCustomers,presntTotalCustomers,
				prevActiveCustomers,presntActiveCustomers,
				prevOrderCount, presntOrderCount,
				prevOrderValue, presntOrderValue;
				
				prevSales = response[pk].totalSales;
				presntSales = obj.totalSales;
				
				prevOrders = response[pk].totalOrders;
				presntOrders = obj.totalOrders;
				
				prevNewCustomers = response[pk].newCustomers;
				presntNewCustomers = obj.newCustomers;
				
				prevTotalCustomers = response[pk].totalCustomers;
				presntTotalCustomers = obj.totalCustomers;
				
				prevActiveCustomers = response[pk].activeCustomers;
				presntActiveCustomers = obj.activeCustomers;
				
				prevOrderCount = response[pk].avgOrderCount;
				presntOrderCount = obj.avgOrderCount;

				prevOrderValue = response[pk].avgOrderValue;
				presntOrderValue = obj.avgOrderValue;

			if(prevSales>presntSales){
				obj.salesGrowthSymbol = 'fa fa-arrow-down';
				obj.salesGrowth = Math.round((prevSales - presntSales)*100/prevSales);
				
			}else{
				if(presntSales)
				obj.salesGrowth = Math.round((presntSales - prevSales)*100/presntSales);
				else
				obj.salesGrowth=0;
				obj.salesGrowthSymbol = 'fa fa-arrow-up';
			}
			if(prevOrders>presntOrders){
				obj.ordersGrowthSymbol = 'fa fa-arrow-down';
				obj.ordersGrowth = Math.round((prevOrders - presntOrders)*100/prevOrders);
			}else{
				if(presntOrders)
					obj.ordersGrowth = Math.round((presntOrders - prevOrders)*100/presntOrders);
				else
					obj.ordersGrowth = 0;
				obj.ordersGrowthSymbol = 'fa fa-arrow-up';
			}
			if(prevNewCustomers>presntNewCustomers){
				obj.newCustomersGrowthSymbol = 'fa fa-arrow-down';
				obj.newCustomersGrowth = Math.round((prevNewCustomers - presntNewCustomers)*100/prevNewCustomers);
			}else{
				if(presntNewCustomers)
					obj.newCustomersGrowth = Math.round((presntNewCustomers - prevNewCustomers)*100/presntNewCustomers);
				else
					obj.newCustomersGrowth= 0;
				obj.newCustomersGrowthSymbol = 'fa fa-arrow-up';
			}
			if(prevTotalCustomers>presntTotalCustomers){
				obj.totalCustomersGrowthSymbol = 'fa fa-arrow-down';
				obj.totalCustomersGrowth = Math.round((prevTotalCustomers - presntTotalCustomers)*100/prevTotalCustomers);
			}else{
				if(presntTotalCustomers)
					obj.totalCustomersGrowth = Math.round((presntTotalCustomers - prevTotalCustomers)*100/presntTotalCustomers);
				else
					obj.totalCustomersGrowth = 0;
				obj.totalCustomersGrowthSymbol = 'fa fa-arrow-up';
			}
			if(prevActiveCustomers>presntActiveCustomers){
				obj.activeCustomersGrowthSymbol = 'fa fa-arrow-down';
				obj.activeCustomersGrowth = Math.round((prevActiveCustomers - presntActiveCustomers)*100/prevActiveCustomers);
			}else{
				if(presntActiveCustomers)
				obj.activeCustomersGrowth = Math.round((presntActiveCustomers - prevActiveCustomers)*100/presntActiveCustomers);
				else
					obj.activeCustomersGrowth = 0;
				obj.activeCustomersGrowthSymbol = 'fa fa-arrow-up';
			}
			
	 }else{
		obj.salesGrowth = obj.totalSales;
		obj.ordersGrowth = obj.totalOrders;
		obj.newCustomersGrowth = obj.netCustomers;
		obj.totalCustomersGrowth = obj.totalCustomers;
		obj.activeCustomersGrowth = obj.activeCustomers;
		obj.activeCustomersGrowth = obj.avgOrderCount;
		obj.avgOrderCountGrowth = obj.avgOrderCount;
		obj.avgOrderValueGrowth = obj.avgOrderValue;

		}
		pk= k;



    });

    	$scope.resultKeys = Object.keys(response).reverse();

    	$scope.reportResult = response;
    	console.log("response",response);
    }).error(function(err){
    	console.log(err);
    });

 	}

 	$scope.areaSelected = function(storeId){
 		getReportDetails(storeId);
 	};

   
}]);



