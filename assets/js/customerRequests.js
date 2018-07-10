
/*  Start CustomerRequestController */


angular.module('colorAdminApp')
.controller('CustomerRequestController',['$rootScope','$scope','$http','$location','NgTableParams','ngNotify','Auth', function($rootScope,$scope,$http,$location,NgTableParams,ngNotify,Auth){
  var areaId = Auth.getAreaId();
  var userObj = localStorage.getItem('laundry_admin_user_obj');
  var userRole = '';
  $scope.userRole = userRole= JSON.parse(userObj).employee.role;
  // STORE_ADMIN
  $scope.applyGlobalSearch = function() {
    $scope.tableParams.filter({ $: $scope.search });
  }
  areaId = (areaId == 0) ? null : areaId;
  $scope.customerRequests = [];
  $scope.customerRequest = {crId:'',pickupBoyId:'',requests:[]};
  // $scope.pickupBoys = [];
  $scope.showModal = false;
  var monthsList = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
  $scope.dateSelected = new Date().getDate() + '/' + monthsList[new Date().getMonth()] + '/' + new Date().getFullYear();

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

  function getAreasList(){
    $http.get(ldh+'api-areas')
    .then(function(response,status){
      $scope.areasList = response.data;
      console.log($scope.areasList);
    },function(error){
      console.log(error);
    }); 
  }
  getAreasList();

  $scope.areaSelected=function(area){
    console.log("area",area);
      $scope.customerRequest.storeId = JSON.parse(area).id;
        
    $scope.customerRequest.apply;
    var fromDate = new Date($('#datepicker-default-from').val());;
    var toDate = new Date($('#datepicker-default-to').val());
      if(userRole=='STORE_ADMIN'){
        filterOrderItems(fromDate,toDate,JSON.parse(area).code);  
      }else{
        filterOrderItems(fromDate,toDate,'');  
      }
      
  };
  
  $scope.requestToggled=function(customerRequest){
    console.log(customerRequest);
  };

  $scope.sendToStore=function(){
      
      $http.post(ldh+'customer-request-assign-to-store',$scope.customerRequest).success(function(response,status){
        ngNotify.set(response.message);

      }).error(function(err){
          console.log(err);
      });
  };

  function filterOrderItems(fromDate,toDate,areaCode){
    $scope.currentItems = [];
    fromDate=new Date(fromDate);
    toDate=new Date(toDate);
    fromDate.setHours("0");
    fromDate.setMinutes("0");
    fromDate.setSeconds("0");
    toDate.setDate(toDate.getDate()+1);

    fromDate=fromDate.getTime();
    toDate=toDate.getTime();

    angular.forEach($scope.allCustomerRequests,function(val, key){
      if((userRole =='STORE_ADMIN' || val.status=='CRR') && val.requestDateTime && val.requestDateTime >= fromDate && val.requestDateTime <= toDate){
      
        $scope.currentItems.push(val);
      }
      
      
    })

    if(areaCode){
      var areaItems=[];
      angular.forEach($scope.currentItems,function(val,key){
        console.log(val,areaCode)
        if(val.areaCode.indexOf(areaCode) >= 0){
          areaItems.push(val);
        }
      });
      $scope.currentItems = areaItems;
    }
    console.log('$scope.allCustomerRequests', $scope.currentItems);

    $scope.tableParams = new NgTableParams({ count: 20,  sorting: { id: "dsc" } }, { counts: [20, 50, 100], dataset: $scope.currentItems});
    $scope.tableParams.reload();
  }

  $scope.filterRequestsBydate= function(){
    var fromDate = new Date($('#datepicker-default-from').val());;
    var toDate = new Date($('#datepicker-default-to').val());
    filterOrderItems(fromDate,toDate);
  };

  $scope.getCustomerRequests = function($id){
   $http.post(ldh+'customer-requests',{areaId:$id})
   .success(function(response){
    $scope.allCustomerRequests = response.customers;
    filterOrderItems($scope.dateSelected, $scope.dateSelected);
    console.log(response);
  }).error(function(err){
    console.log(err);
  });	
};

$scope.getCustomerRequests(areaId);

$scope.pickupBoys = function($id){
 $http.post(ldh+'store-pickup-boys',{areaId:$id}).success(function(response){
  if(response.pickupBoys){
    $scope.pickupBoys = response.pickupBoys;
  }else{
    $scope.pickupBoys = [];
  }
  $scope.pickupBoys.push({pbId:'',name:'select'});
  $scope.pickupBoys.apply;

}).error(function(err){
  console.log(err);
});
}

$scope.pickupBoys(areaId);


$scope.toggle = function($a){
 $scope.customerRequest.crId =$a;
 $scope.customerRequest.apply;
 $scope.showModal = true;
 $scope.showModal.apply;
}
$scope.assignPickupBoy = function(){               
 $http.post(ldh+'customer-request-assign',$scope.customerRequest).success(function(response,status){
  ngNotify.set(response.message,{status:'success'});
  $scope.customerRequest = {};
  $scope.showModal =false;
  $scope.getCustomerRequests(areaId);
}).error(function(err){
  console.log(err);
});
}
}])


/*  Start CustomerPackageController */


angular.module('colorAdminApp')
.controller('CustomersPackageController',['$rootScope','$scope','$http','$location','NgTableParams','ngNotify','Auth', function($rootScope,$scope,$http,$location,NgTableParams,ngNotify,Auth){
  var areaId = Auth.getAreaId();
  var userObj = localStorage.getItem('laundry_admin_user_obj');
  $scope.userRole = JSON.parse(userObj).employee.role;
  // STORE_ADMIN
  $scope.applyGlobalSearch = function() {
    $scope.tableParams.filter({ $: $scope.search });
  }
  areaId = (areaId == 0) ? null : areaId;
  $scope.customerRequests = [];
  $scope.customerRequest = {crId:'',pickupBoyId:'',requests:[]};
  // $scope.pickupBoys = [];
  $scope.showModal = false;
  var monthsList = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
  $scope.dateSelected = new Date().getDate() + '/' + monthsList[new Date().getMonth()] + '/' + new Date().getFullYear();

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

  function getAreasList(){
    $http.get(ldh+'api-areas')
    .then(function(response,status){
      $scope.areasList = response.data;
      console.log($scope.areasList);
    },function(error){
      console.log(error);
    }); 
  }
  getAreasList();

  $scope.areaSelected=function(area){
    $scope.customerRequest.storeId = JSON.parse(area).id;
    $scope.customerRequest.apply;
    var fromDate = new Date($('#datepicker-default-from').val());;
    var toDate = new Date($('#datepicker-default-to').val());
      filterOrderItems(fromDate,toDate,JSON.parse(area).code);
  };
  
  $scope.requestToggled=function(customerRequest){
    console.log(customerRequest);
  };

  $scope.sendToStore=function(){
      
      $http.post(ldh+'customer-request-assign-to-store',$scope.customerRequest).success(function(response,status){
        ngNotify.set(response.message);

      }).error(function(err){
          console.log(err);
      });
  };

  function filterOrderItems(fromDate,toDate,areaCode){
    $scope.currentItems = [];
    fromDate=new Date(fromDate);
    toDate=new Date(toDate);
    fromDate.setHours("0");
    fromDate.setMinutes("0");
    fromDate.setSeconds("0");
    toDate.setDate(toDate.getDate()+1);

    fromDate=fromDate.getTime();
    toDate=toDate.getTime();

    angular.forEach($scope.allPremiumCustomers,function(val, key){
      if(val.status!='assign to store' && val.requestDateTime && val.requestDateTime > fromDate && val.requestDateTime < toDate){
        $scope.currentItems.push(val);
      }
    })

    if(areaCode){
      var areaItems=[];
      angular.forEach($scope.currentItems,function(val,key){
        console.log(val,areaCode)
        if(val.areaCode.indexOf(areaCode) >= 0){
          areaItems.push(val);
        }
      });
      $scope.currentItems = areaItems;
    }
    console.log('$scope.allPremiumCustomers', $scope.currentItems);

    $scope.tableParams = new NgTableParams({ count: 20,  sorting: { id: "dsc" } }, { counts: [20, 50, 100], dataset: $scope.currentItems});
    $scope.tableParams.reload();
  }

  $scope.filterRequestsBydate= function(){
    var fromDate = new Date($('#datepicker-default-from').val());;
    var toDate = new Date($('#datepicker-default-to').val());
    filterOrderItems(fromDate,toDate);
  };

  $scope.getPremiumCustomers = function(){
   $http.get(ldh+'api-premiumcustomers')
   .success(function(response){
    console.log(response);
    $scope.allPremiumCustomers = response.customers;
    filterOrderItems($scope.dateSelected, $scope.dateSelected);
  }).error(function(err){
    console.log(err);
  }); 
};

$scope.getPremiumCustomers(areaId);

$scope.pickupBoys = function($id){
 $http.post(ldh+'store-pickup-boys',{areaId:$id}).success(function(response){
  if(response.pickupBoys){
    $scope.pickupBoys = response.pickupBoys;
  }else{
    $scope.pickupBoys = [];
  }
  $scope.pickupBoys.push({pbId:'',name:'select'});
  $scope.pickupBoys.apply;

}).error(function(err){
  console.log(err);
});
}

$scope.pickupBoys(areaId);


$scope.toggle = function($a){
 $scope.customerRequest.crId =$a;
 $scope.customerRequest.apply;
 $scope.showModal = true;
 $scope.showModal.apply;
}
$scope.assignPickupBoy = function(){               
 $http.post(ldh+'customer-request-assign',$scope.customerRequest).success(function(response,status){
  ngNotify.set(response.message,{status:'success'});
  $scope.customerRequest = {};
  $scope.showModal =false;
  $scope.getCustomerRequests(areaId);
}).error(function(err){
  console.log(err);
});
}
}])