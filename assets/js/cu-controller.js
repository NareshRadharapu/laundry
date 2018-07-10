/*  CENTRAL UNIT CONTROLLER  */
angular.module('colorAdminApp') 
.controller('CUSendOrdersController',['$rootScope','$scope','$http','$location','NgTableParams','ngNotify','Auth', function($rootScope,$scope,$http,$location,NgTableParams,ngNotify,Auth){
     //var cbsLocal  = localStorage.getItem('cu_user_obj');
     //var localObj = $.parseJSON(cbsLocal);
     var cityId = Auth.getCityId(); //localObj.employee.cityId;
     $scope.cuOrders  = [];
     $scope.pickupBoyModalFlag = true;
     $scope.cuOrderRequest = {orderId:'',status:'',cueId:''};
     $scope.name = "rkreddy";
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
$scope.applyGlobalSearch = function() {
    $scope.tableParams.filter({ $: $scope.search });
  }
     function filterOrderItems(fromDate,toDate){
      $scope.currentItems = [];
      angular.forEach($scope.allOrders,function(val, key){
        var orderDate = new Date(val.orderDate)
        newToDate = new Date(toDate.valueOf())
           // Trick - To incerease the date by 1 since the default date is set to time 00:00;
           console.log(toDate);
           newToDate.setDate(toDate.getDate()+ 1);
           if(fromDate <= orderDate && newToDate >= orderDate) {
            $scope.currentItems.push(val);
           }
         });
      console.log($scope.currentItems);
      $scope.tableParams = new NgTableParams({count:25, sorting:{id:"desc"}}, {counts:[10,25,50], dataset:$scope.currentItems})
      $scope.tableParams.reload();
     }
     $scope.filterOrdersBydate= function(){
        // $scope.selectedDate = new Date($('#datepicker-default').val());
        var fromDate   =  new Date($('#datepicker-default-from').val());
        var toDate     =  new Date($('#datepicker-default-to').val());
        console.log(toDate);
           // filterOrderItems($scope.selectedDate);
           filterOrderItems(fromDate,toDate);
         }
         $scope.getOrders = function(){
           $http.post(ldh+'cu-send-orders',{"cityId":cityId}).success(function(response){
            $scope.allOrders=response.orders;
            $scope.tableParams = new NgTableParams({count:25, sorting:{id:"desc"}}, {counts:[10,25,50], dataset:response.orders})
          }).error(function(err){
            console.log(err);
          });
        };
        $scope.getOrders();
        $scope.cuOrderTogglef = function(orderId){
          $scope.cuOrderToggle = !$scope.cuOrderToggle;
          $scope.cuOrderToggle.apply;
          $scope.cuOrderRequest.orderId = orderId;
        };
        $scope.updateCuOrderStatus = function(orderId){
          $http.post(ldh+'cua-send-order-status', $scope.cuOrderRequest).success(function(response,status){
            console.log(response);
            $scope.getOrders();
            ngNotify.set(response.message,{duration:4000});
          }).error(function(err){
            console.log(err);
          });
          $scope.cuOrderToggle = false;
        };
        $scope.assignPickupBoy = function(){               
          $http.post(ldh+'cu-send-order-assign',$scope.cuOrderRequest).success(function(response,status){
            ngNotify.set(response.message,{status:'success'});
            $scope.cuOrderRequest = {};
            $scope.pickupBoyModal =false;
            $scope.getOrders();
          }).error(function(err){
            console.log(err);
          });
        };
        $scope.getCUEmployees = function(){
          $http.get(ldh+'cu-employees').success(function(response,status,headers){
            $scope.cuEmployees = response.employees;
            console.log(response.employees);
          }).error(function(err){
            console.log(err);
          });
        };
        $scope.getCUEmployees();
      }])
.controller('StoreCUSendOrdersController',['$rootScope','$scope','$http','$location','NgTableParams','ngNotify','Auth', function($rootScope,$scope,$http,$location,NgTableParams,ngNotify,Auth){
     //var cbsLocal  = localStorage.getItem('laundry_admin_user_obj');
     //var localObj = $.parseJSON(cbsLocal);
     var areaId =   Auth.getAreaId();
     $scope.cuOrders  = [];
     $scope.pickupBoyModal = false;
     $scope.cuOrderRequest = {orderId:'',status:'',cueId:''};
     $scope.name = "rkreddy";
     $scope.selectedDate  = new Date();
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
$scope.applyGlobalSearch = function() {
    $scope.tableParams.filter({ $: $scope.search });
  }
     function filterOrderItems(fromDate,toDate){
      $scope.currentItems = [];
      angular.forEach($scope.allOrders,function(val, key){
        var orderDate = new Date(val.orderDate)
        newToDate = new Date(toDate.valueOf())
           // Trick - To incerease the date by 1 since the default date is set to time 00:00;
           console.log(toDate);
           newToDate.setDate(toDate.getDate()+ 1);
           if(fromDate <= orderDate && newToDate >= orderDate) {
            $scope.currentItems.push(val);
           }
         });
      console.log($scope.currentItems);
      $scope.tableParams = new NgTableParams({count: 500, sorting: { id: "dsc" } },{ counts: [5, 10, 25], dataset: $scope.currentItems}); 
      $scope.tableParams.reload();
    }
    $scope.filterOrdersBydate= function(){
           // $scope.selectedDate = new Date($('#datepicker-default').val());
           var fromDate   =  new Date($('#datepicker-default-from').val());
           var toDate     =  new Date($('#datepicker-default-to').val());
           console.log(toDate);
           // filterOrderItems($scope.selectedDate);
           filterOrderItems(fromDate,toDate);
         }
         $scope.getOrders = function(){
           $http.post(ldh+'store-cu-send-orders',{"areaId":areaId}).success(function(response){
            $scope.allOrders=response.orders;
            $scope.allItems = response.data;
            console.log($scope.selectedDate);
            var selectedDate=$scope.selectedDate;
            selectedDate.setHours(0);
            selectedDate.setMinutes(0);
            selectedDate.setSeconds(0);
            var init_from_date=new Date(selectedDate.valueOf());
            var init_to_date=new Date(selectedDate.valueOf());
            console.log(init_to_date);
            console.log(init_from_date);
            filterOrderItems(init_from_date,init_to_date);
            // $scope.tableParams = new NgTableParams({count:25, sorting:{id:"desc"}}, {counts:[10,25,50], dataset:response.orders})
          }).error(function(err){
            console.log(err);
          });
        };
        $scope.getOrders();
        $scope.cuOrderTogglef = function(orderId){
          $scope.pickupBoyModal = !$scope.pickupBoyModal;
          $scope.pickupBoyModal.apply;
          $scope.cuOrderRequest.orderId = orderId;
        };
        $scope.assignPickupBoy = function(){               
          $http.post(ldh+'cu-send-order-assign',$scope.cuOrderRequest).success(function(response,status){
            ngNotify.set(response.message,{status:'success'});
            $scope.cuOrderRequest = {};
            $scope.pickupBoyModal =false;
            $scope.getOrders();
          }).error(function(err){
            console.log(err);
          });
        };
        $scope.getCUEmployees = function(){
          $http.get(ldh+'cu-employees').success(function(response,status,headers){
            $scope.cuEmployees = response.employees;
            console.log(response.employees);
          }).error(function(err){
            console.log(err);
          });
        };
        $scope.getCUEmployees();
      }])
.controller('StoreCUDeliveryOrdersController',['$rootScope','$scope','$http','$location','NgTableParams','ngNotify','Auth', function($rootScope,$scope,$http,$location,NgTableParams,ngNotify,Auth){
  var areaId  = Auth.getAreaId();
  $scope.cuOrders  = [];
  $scope.pickupBoyModal = false;
  $scope.cuOrderRequest = {orderId:'',status:'',cueId:'',statusList:['SADA','SADPA','SPDA','SPDR']};
  $scope.selectedDate  = new Date();
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
  $scope.applyGlobalSearch = function() {
    $scope.tableParams.filter({ $: $scope.search });
  }
  function filterOrderItems(fromDate,toDate){
    $scope.currentItems = [];
    angular.forEach($scope.allOrders,function(val, key){
     var orderDate =  new Date(val.orderDate)
     newToDate    =   new Date(toDate.valueOf())
           // Trick - To incerease the date by 1 since the default date is set to time 00:00;
           console.log(toDate);
           newToDate.setDate(toDate.getDate()+ 1);
           if(fromDate<=orderDate && newToDate>=orderDate) {
            $scope.currentItems.push(val);
           }
         });
    console.log($scope.currentItems);
    $scope.tableParams = new NgTableParams({count:25, sorting:{id:"desc"}}, {counts:[10,25,50], dataset:$scope.currentItems})
    $scope.tableParams.reload();
  }
  $scope.filterOrdersBydate= function(){
    var fromDate=new Date($('#datepicker-default-from').val());
    var toDate=new Date($('#datepicker-default-to').val());
    console.log(toDate);
    filterOrderItems(fromDate,toDate);
  }
  $scope.getOrders = function(){
    $http.post(ldh+'store-cu-delivery-orders',{"areaId":areaId})
    .success(function(response){
     console.log(response);
     $scope.allOrders=response.orders;
     var selectedDate=$scope.selectedDate;
     selectedDate.setHours(0);
     selectedDate.setMinutes(0);
     selectedDate.setSeconds(0);
     var init_from_date=new Date(selectedDate.valueOf());
     var init_to_date=new Date(selectedDate.valueOf());
     console.log(init_to_date);
     console.log(init_from_date);
     filterOrderItems(init_from_date,init_to_date);
      // $scope.tableParams = new NgTableParams({count:25, sorting:{id:"desc"}}, {counts:[10,25,50], dataset:response.orders})
    }).error(function(err){
     console.log(err);
   });
  };
  $scope.getOrders();
  $scope.cuOrderTogglef = function(orderId){
    $scope.pickupBoyModal = !$scope.pickupBoyModal;
    $scope.pickupBoyModal.apply;
    $scope.cuOrderRequest.orderId = orderId;
  };
  $scope.changeDeliverOrderStatus = function(){
    $http.post(ldh+'store-delivery-order-status',$scope.cuOrderRequest).success(function(response,status){
      ngNotify.set(response.message,{duration:2000});
      $scope.pickupBoyModal = false;
      $scope.getOrders();
    }).error(function(err){
      console.log(err);
    });
  };
    /*
  $scope.assignPickupBoy = function(){               
    $http.post(ldh+'cu-delivery-order-assign',$scope.cuOrderRequest).success(function(response,status){
      ngNotify.set(response.message,{status:'success'});
      $scope.cuOrderRequest = {};
      $scope.pickupBoyModal =false;
      $scope.getOrders();
    }).error(function(err){
      console.log(err);
    });
  };
  $scope.getCUEmployees = function(){
    $http.get(ldh+'cu-employees').success(function(response,status,headers){
      $scope.cuEmployees = response.employees;
      console.log(response.employees);
    }).error(function(err){
      console.log(err);
    });
  };
  $scope.getCUEmployees();*/
}])
.controller('CUDeliveryOrdersController',['$rootScope','$scope','$http','$location','NgTableParams','ngNotify','Auth', function($rootScope,$scope,$http,$location,NgTableParams,ngNotify,Auth){
     //var cbsLocal  = localStorage.getItem('cu_user_obj');
     //var localObj = $.parseJSON(cbsLocal);
     var cityId     = Auth.getCityId(); //localObj.employee.cityId;
     $scope.cuOrders  = [];
     $scope.pickupBoyModal = false;
     $scope.cuOrderRequest = {orderId:'',status:'',cueId:''};
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
     $scope.applyGlobalSearch = function() {
      $scope.tableParams.filter({ $: $scope.search });
    }
    function filterOrderItems(fromDate,toDate){
      $scope.currentItems = [];
      angular.forEach($scope.allOrders,function(val, key){
       var orderDate = new Date(val.orderDate)
       newToDate=new Date(toDate.valueOf())
           // Trick - To incerease the date by 1 since the default date is set to time 00:00;
           console.log(toDate);
           newToDate.setDate(toDate.getDate()+ 1);
           if(fromDate<=orderDate && newToDate>=orderDate) {
            $scope.currentItems.push(val);
           }
         });
      console.log($scope.currentItems);
      $scope.tableParams = new NgTableParams({count:25, sorting:{cuId:"desc"}}, {counts:[10,25,50], dataset:$scope.currentItems})
      $scope.tableParams.reload();
    }
    $scope.filterOrdersBydate= function(){
      var fromDate=new Date($('#datepicker-default-from').val());
      var toDate=new Date($('#datepicker-default-to').val());
      console.log(toDate);
      filterOrderItems(fromDate,toDate);
    }
    $scope.getOrders = function(){
      $http.post(ldh+'cu-delivery-orders',{"cityId":cityId})
      .success(function(response){
       console.log(response);
       $scope.allOrders=response.orders;
       $scope.tableParams = new NgTableParams({count:25, sorting:{cuId:"desc"}}, {counts:[10,25,50], dataset:response.orders})
     }).error(function(err){
       console.log(err);
     });
   };
   $scope.getOrders();
   $scope.cuOrderTogglef = function(orderId){
    $scope.cuOrderToggle = true;
    $scope.cuOrderToggle.apply;
    $scope.cuOrderRequest.orderId = orderId;
  };
  $scope.assignPickupBoy = function(){
    $scope.cuOrderRequest.status = 'CUPA';
    $http.post(ldh+'cu-delivery-order-assign',$scope.cuOrderRequest).success(function(response,status){
     ngNotify.set(response.message,{status:'success'});
     $scope.cuOrderRequest = {};
     $scope.cuOrderToggle =false;
     $scope.getOrders();
   }).error(function(err){
     console.log(err);
   });
 };
 $scope.getCUEmployees = function(){
  $http.get(ldh+'cu-employees').success(function(response,status,headers){
   $scope.cuEmployees = response.employees;
   console.log(response.employees);
 }).error(function(err){
   console.log(err);
 });
};
$scope.getCUEmployees();
}])
.controller('CUSOrderDetailsController',['$rootScope','$scope','$http','$location','NgTableParams','ngNotify','$stateParams', function($rootScope,$scope,$http,$location,NgTableParams,ngNotify,$stateParams){
  var orderId = $stateParams.orderId;
  $scope.cuOrderDetails  = [];
  $scope.cusOrder = {status:'',message:'',orderId:'',statusList:['CUAA','CUAPA','HOLD']}; 
  $scope.applyGlobalSearch = function() {
    $scope.tableParams.filter({ $: $scope.search });
  }
  $scope.getOrderDetails = function(){
    $http.post(ldh+'cus-order-details',{"orderId":orderId})
    .success(function(response){
     $scope.cuOrderDetails = response;
     $scope.cuOrderItemDetails = Object.keys($scope.cuOrderDetails.itemDetails);
   }).error(function(err){
     console.log(err);
   });
 };
 $scope.cuOrderDetailsTogglef=function(orderIdValue){
  $scope.cuOrderDetailsToggle = !$scope.cuOrderDetailsToggle;
  $scope.cusOrder.orderId = orderIdValue;
  console.log($scope.cusOrder);
};
$scope.updateStatus=function(){
  $http.post(ldh+'order-status',$scope.cusOrder).success(function(response,status){
    console.log(response);
    ngNotify.set(response.message,{duration:2000});
    $scope.cuOrderDetailsToggle =false;
  }).error(function(err){
    console.log(err);
  });
  $scope.getOrderDetails();
};
$scope.getOrderDetails();
$scope.trash = function(id){
  if(confirm("Are You sure to delete "+id)){
   $('#'+id).remove();
   $http.post(ldh+'cu-order-details-trash',{'orderId':id})
   .success(function(response){
    console.log(response);
    ngNotify.set('successfully trashed order details item: '+id,{'type':'success'});
    $scope.getOrderDetails();
  }).error(function(response){
    console.log(response);
  });   
}
};
$scope.printCuorders=function(){
  window.print();
}
$scope.getOrderDetails();
}])
.controller('CUDOrderDetailsController',['$rootScope','$scope','$http','$location','NgTableParams','ngNotify','$stateParams', function($rootScope,$scope,$http,$location,NgTableParams,ngNotify,$stateParams){
  var orderId = $stateParams.orderId;
  $scope.cuOrderDetails  = [];
  $scope.name = 'laundry ';
  $scope.applyGlobalSearch = function() {
    $scope.tableParams.filter({ $: $scope.search });
  }
  $scope.cuOrderRequest = {orderId:'',status:'',statusList:['SADA','SADPA']};
  var cuOrderRequest = $scope.cuOrderRequest;
  $scope.getOrderDetails = function(){
    $http.post(ldh+'cud-order-details',{"orderId":orderId})
    .success(function(response){
     console.log(response);
     $scope.cuOrderDetails = response;
     $scope.cuOrderItemDetails = Object.keys($scope.cuOrderDetails.itemDetails);
   }).error(function(err){
     console.log(err);
   });
 };
 $scope.cuOrderDetailsToggle = false;
 $scope.cudOrderDetailsTogglef=function(orderIdValue) {
  $scope.cuOrderDetailsToggle = !$scope.cuOrderDetailsToggle;
  $scope.cuOrderRequest.orderId = orderIdValue;
}
$scope.updateStatus=function(status){
  $scope.cuOrderDetailsToggle = false;
  $http.post(ldh+'store-delivery-single-order-status', $scope.cuOrderRequest).success(function(response,status){
    ngNotify.set(response.message);
    $scope.getOrderDetails();
    $scope.cuOrderRequest = cuOrderRequest;
  }).error(function(err){
    console.log(err);
  });
};
$scope.getOrderDetails();
$scope.deleteOrder = function(id){
  if(confirm("Are You sure to delete "+id)){
     $('#'+id).remove();
     $http.post(ldh+'cu-delete-delivery-order',{'orderId':id})
     .success(function(response){
      console.log(response);
      ngNotify.set('successfully trashed order details : '+id,{'type':'success'});
      $scope.getOrderDetails();
    }).error(function(response){
      console.log(response);
    });   
  }
}
$scope.trash = function(id){
  if(confirm("Are You sure to delete "+id)){
     $('#'+id).remove();
     $http.post(ldh+'cu-order-details-trash',{'orderId':id})
     .success(function(response){
      console.log(response);
      ngNotify.set('successfully trashed order details item: '+id,{'type':'success'});
    }).error(function(response){
      console.log(response);
    });   
  }
};
$scope.printCuorders=function(){
  window.print();
}
}])
.controller('CUOrderDetailsController',['$rootScope','$scope','$http','$location','ngNotify','$stateParams', function($rootScope,$scope,$http,$location,ngNotify,$stateParams){
  var orderId = $stateParams.orderId;
  $scope.cuOrderDetails  = [];
  $scope.applyGlobalSearch = function() {
    $scope.tableParams.filter({ $: $scope.search });
  }
  $scope.getOrderDetails = function(){
    $http.post(ldh+'cus-order-details',{"orderId":orderId}).success(function(response){
     console.log(response);
     $scope.cuOrderDetails = response;
   }).error(function(err){
     console.log(err);
   });
 };
 $scope.getOrderDetails();
 $scope.trash = function(id){
  if(confirm("Are You sure to delete "+id)){
   $('#'+id).remove();
   $http.post(ldh+'cu-order-details-trash',{'orderId':id}).success(function(response){
    console.log(response);
    $scope.getOrderDetails();
    ngNotify.set('successfully trashed order details item: '+id,{'type':'success'});
  }).error(function(response){
    console.log(response);
  });   
}           
};
$scope.printCuorders=function(){
  window.print();
}
}])
.controller('CUProcessOrdersController',['$rootScope','$scope','$http','ngNotify','Auth',function($rootScope,$scope,$http,ngNotify,Auth){
  var cityId  = Auth.getCityId();
  var cueId   = Auth.getEmpId();
  console.log(cueId);
   $scope.processOrders = {};
   $scope.cuStores = {};
   $scope.cuApartmentStores = {};
    $scope.applyGlobalSearch = function() {
      $scope.tableParams.filter({ $: $scope.search });
    }
    $scope.dorder = { orders:[], storeId:'',cueId:cueId};
    $('#datepicker-default-from').datepicker();
    $('#datepicker-default-to').datepicker();
    var fromDate = '', toDate='';
     $scope.filterOrdersBydate= function(){
        // $scope.selectedDate = new Date($('#datepicker-default').val());
        var fromDate = $('#datepicker-default-from').val();
        var fromDateObj   =  +new Date(fromDate);
            if(fromDate==''){
              fromDateObj = '';
            }
        var toDate = $('#datepicker-default-to').val();
        var toDateObj     =  +new Date(toDate);
          if(toDate==''){
              toDateObj = '';
            }
         filterOrderItems(fromDateObj,toDateObj,0);
    };
    $scope.areaSelected = function(store){
        var fromDate = $('#datepicker-default-from').val();
        var fromDateObj   =  +new Date(fromDate);
            if(fromDate==''){
              fromDateObj = '';
            }
        var toDate = $('#datepicker-default-to').val();
        var toDateObj     =  +new Date(toDate);
          if(toDate==''){
              toDateObj = '';
            }
         filterOrderItems(fromDateObj,toDateObj,store);
    };
    function getProcessOrders(){
      $http.post(ldh+'cu-process-orders',{'cityId':cityId}).success(function(response,status){
        console.log(response);
        $scope.processOrders = response.orders;
        filterOrderItems('','',0);
      }).error(function(error){
        console.log(error);
      });
    };
    getProcessOrders();
    function filterOrderItems(fromDate,toDate,storeId){
        var rs = new Array();
        angular.forEach($scope.processOrders,function(obj,k){
            console.log("obj",obj,fromDate,toDate);
            if((fromDate=='' || obj.details.orderDate>=fromDate) &&
              (toDate=='' || obj.details.orderDate<=toDate) &&
              (storeId==0 || obj.details.storeId==storeId)){
              rs.push(obj);
            }
        });
        $scope.processOrders.orders = rs;
    }
 $scope.getStores = function(cid){
  $http.post(ldh+'cu-stores',{cityId:cid}).success(function(response,status){
   $scope.cuStores.stores = response.stores;
 }).error(function(error){
   console.log(error);
 });
}  
$scope.getStores(cityId);
$scope.getApartmentStores = function(cid){
  $http.post(ldh+'cu-apartment-stores',{cityId:cid}).success(function(response,status){
   $scope.cuApartmentStores.stores = response.stores;
 }).error(function(error){
   console.log(error);
 });
}  
$scope.getApartmentStores(cityId);
$scope.doDeliverOrder = function(){
  $http.post(ldh+'cu-do-delivery-order',$scope.dorder).success(function(response,status){
   ngNotify.set(response.message,{'duration':5000})
   $scope.getProcessOrders();
 }).error(function(error){
   console.log(error);
 });
};
}])
.controller('CUReturnGarmentsController',['$rootScope','$scope','$http','NgTableParams','ngNotify','Auth',function($rootScope,$scope,$http,NgTableParams,ngNotify,Auth){
  var cityId  = Auth.getCityId();
  var cueId   = Auth.getEmpId();
  console.log(cueId);
  $scope.returnGarments = [];
  $scope.garment = {inBarCode:'',message:'',status:'',secondStatus:'CUAA'};
  $scope.applyGlobalSearch = function() {
    $scope.tableParams.filter({ $: $scope.search });
  }
  $scope.getReturnGarments = function(){
    $http.post(ldh+'cu-return-garments',{cueId:cueId}).success(function(response,status){
     console.log(response);
     $scope.tableParams = new NgTableParams({count:25, sorting:{id:"desc"}}, {counts:[10,25,50], dataset:response.garments});
   }).error(function(error){
     console.log(error);
   });
 };
 $scope.getReturnGarments();
 $scope.setReturnGarment = function(){
  $scope.garment.status = 'return';
  $scope.garment.secondStatus = 'return';
  $scope.garment.message = 'return';
  $http.post(ldh+'cu-return-garment',$scope.garment).success(function(response,status){
    $scope.getReturnGarments();
    ngNotify.set(response.message,{duration:4000});
  }).error(function(error){
   console.log(error);
 });
};
$scope.deleteReturnGarment = function(inBarCodeValue){
  if(confirm("are you want to delete return garment of "+inBarCodeValue)){
    $scope.orderStatusObj = {status:'CUAA',message:'',secondStatus:'cuaa',secondMessage:'return garment taken back',inBarCode:inBarCodeValue};
    $http.post(ldh+'cu-return-garment',$scope.orderStatusObj).success(function(response,status){
      ngNotify.set(inBarCodeValue+" deleted from return garments ",{duration:5000});
      $scope.getReturnGarments();
    }).error(function(error){
      console.log(error);
    });
  };
}
}])
.controller('CUHoldGarmentsController',['$rootScope','$scope','$http','ngNotify','Auth',function($rootScope,$scope,$http,ngNotify,Auth){
  var cityId  = Auth.getCityId();
  var cueId   = Auth.getEmpId();
  console.log(cueId);
  $scope.holdGarments = [];
  $scope.holdGarment = {inBarCode:'',status:'',secondStatus:'',statusList:['HG-CUF','HG-CUO','HG-CUP','HG-CUD']};
  var holdGarment = angular.copy($scope.holdGarment);
  $scope.getHoldGarments = function(){
    $http.post(ldh+'cu-hold-garments',{cueId:cueId}).success(function(response,status){
     $scope.holdGarments = response.garments;
   }).error(function(error){
     console.log(error);
   });
 };
 $scope.applyGlobalSearch = function() {
  $scope.tableParams.filter({ $: $scope.search });
}
$scope.getHoldGarments();
$scope.itemStatusChangeFlag = false;
$scope.holdItemStatusToggle = function(inBarCodeValue){
  $scope.itemStatusChangeFlag = !$scope.itemStatusChangeFlag;
  $scope.holdGarment.inBarCode= inBarCodeValue;
  $scope.holdGarment.apply;
}
$scope.changeOrderStatus = function(){
  $http.post(ldh+'order-item-status',$scope.holdGarment).success(function(response,status){
    $scope.itemStatusChangeFlag = false;
    ngNotify.set(response.message,{duration:5000});
    $scope.holdGarment =holdGarment;
    $scope.getHoldGarments();
  }).error(function(error){
    console.log(error);
  });
};
}])
.controller('CUDayToDeliveryGarmentsController',['$rootScope','$scope','$http','ngNotify','Auth','$stateParams','NgTableParams', function($rootScope,$scope,$http,ngNotify,Auth,$stateParams,NgTableParams){
  'use strict';
    $scope.dtdOrders = [];
    $scope.dtd ={'dDate':''};
    $('#dDate').datepicker({
        todayHighlight: true,
        format: 'yyyy-mm-dd'
    });
    $scope.totalItemsCount = 0;
    $scope.store = {'storeName':'','address':'','pincode':'','mobileNO':''};
    $scope.storeOrders = [];
    $scope.storePrintOrders = [];
    $scope.getDTDOrders = function(){
      var dDate =  $('#dDate').val();
      console.log('dDate',dDate);
      $http.post(ldh+'cu-day-to-delivery-orders',{'dDate':dDate}).success(function(response, state){
        //console.log(response);
       $scope.dtdOrders = response;
        var totalItems = 0;
        var res = response;
        for (var i in res) {
            totalItems += parseInt(res[i].totalItems);
        }
        $scope.totalItemsCount = totalItems;
        $scope.totalItemsCount.apply;
      }).error(function(err){
        console.log(err);
      });
    };
    $scope.getDTDOrders();
    $scope.cuOrderPrint = function(){
       var dDate =  $('#dDate').val();
        $scope.storePrintOrders = [];
        var storeIds = new Array();
        angular.forEach($scope.storeOrders, function(p, pi){
            storeIds.push(p.storeId);
        });
      $http.post(ldh+'cu-orders-delivery-print',{'dDate':dDate,'storeIds':storeIds}).success(function(response, state){
        $scope.storePrintOrders = response;
        console.log("response",response);
      }).error(function(err){
        console.log(err);
      });
          var printHTML =document.getElementById("printHTML");
          var printBtn =document.getElementById("printBtn");
            console.log("test 0");
            printBtn.addEventListener("click", function(event){
            console.log("test 1");
            var printContents = printHTML.outerHTML;
            console.log("test 2");
            var originalContents = document.body.innerHTML;
            console.log("test 3");
            document.body.innerHTML = printContents;
            console.log("test 4");
            window.print();
            console.log("test 5");
            document.location.reload();
            console.log("test 6");
          });
    };

}])
.controller('CUOrderItemsController',['$rootScope','$scope','$http','ngNotify','Auth','$stateParams','NgTableParams', function($rootScope,$scope,$http,ngNotify,Auth,$stateParams,NgTableParams){
  'use strict';
  var orderId = $stateParams.orderId;
  $scope.order = {};
  $scope.ordersDetails = [];
  $scope.orderStatusObj = {status:'',message:'',inBarCode:'',statusList:['hold','return']};
  var orderStatusObj = $scope.orderStatusObj;
  $scope.orderSummaryPrint = function($o){
    $scope.applyGlobalSearch = function() {
      $scope.tableParams.filter({ $: $scope.search });
    }
    $scope.order.orderId = $o;
    $http.post(ldh+'store-process-order-details',{'orderId':orderId}).success(function(response,status){
     console.log(response);
     $scope.ordersDetails = [];
     angular.forEach(response,function(val,key){
      if(val.proceItems.items && val.proceItems.items.length > 0){
       angular.forEach(val.proceItems.items,function(val2,key2){
        $scope.ordersDetails.push(val2)
      })
     }
   });
   }).error(function(error){
     console.log(error);
   }); 
 }
 $scope.orderSummaryPrint(orderId);
 $scope.itemStatusChangeFlag = false;
 $scope.itemStatusChange = function(inBarCode){
  $scope.itemStatusChangeFlag = !$scope.itemStatusChangeFlag;
  $scope.orderStatusObj.inBarCode = inBarCode;
  $scope.orderStatusObj.apply;
}
$scope.changeOrderStatus = function(){
  $scope.orderStatusObj.secondStatus = $scope.orderStatusObj.status;
  $scope.orderStatusObj.secondMessage = $scope.orderStatusObj.status+' garment ';
  $http.post(ldh+'order-item-status',$scope.orderStatusObj).success(function(response,status){
    $scope.itemStatusChangeFlag = false;
    ngNotify.set(response.message,{duration:5000});
    $scope.orderSummaryPrint(orderId);
    $scope.orderStatusObj = orderStatusObj;
  }).error(function(error){
   console.log(error);
 }); 
};
}])
.controller('CUStatuswiseReportController',['$rootScope','$scope','$http','ngNotify','Auth','$stateParams','NgTableParams', function($rootScope,$scope,$http,ngNotify,Auth,$stateParams,NgTableParams){
  'use strict';

    var monthsList = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    $scope.fromDateSelected = (new Date().getMonth() + 1) + '/' + new Date().getDate() + '/' + (new Date().getFullYear());
    $scope.dateSelected = (new Date().getMonth() + 1) + '/' + new Date().getDate() + '/' + (new Date().getFullYear());
    $('#date').datepicker({
        setDate: new Date(),
        todayHighlight: true,
        format: 'dd/MM/yyyy'
    });
    $scope.filterOrdersBydate = function() {
        $scope.payload.date = new Date($('#date').val());
        $scope.getCuStatusReport();
        $scope.payload.apply;
    };
    $scope.CuStatusReport = [];
    $scope.payload = {date:''}
    $scope.getCuStatusReport = function() {
        $http.post(ldh + 'cuStatuswiseReport', $scope.payload).success(function(response, status) {
            $scope.CuStatusReport = response;
          // console.log(response.cuaa); 
            $scope.CuStatusReport.apply;
            $scope.tableParams = new NgTableParams({ count: 100, sorting: { id: "dsc" } }, { counts: [200, 300, 500], dataset: response });
        }).error(function(error) {
            console.log(error);
        });
    };
    $scope.getCuStatusReport();
    $scope.filterOrdersByStatus1 = function(o) {
    console.log(o);
    if (!o.storeId) {
        ngNotify.set('something went wrong', { type: 'error', duration: 5000 });
    } else {
       var obj1 = {"storeId": o.storeId, "date": o.date, "status":'received' };
       $http.post(ldh + 'cuStatuswiseOrders', obj1).success(function(response, status) {
          $scope.CuStatusOrders = response;
          $scope.CuStatusOrders.apply;
          console.log(response);
        }).error(function(error) {
          console.log(error);
       });
    }
  };
  $scope.filterOrdersByStatus2 = function(p) {
    console.log(p);
    if (!p.storeId) {
        ngNotify.set('something went wrong', { type: 'error', duration: 5000 });
    } else {
       var obj2 = {"storeId": p.storeId, "date": p.date, "status":'sent' };
       $http.post(ldh + 'cuStatuswiseOrders', obj2).success(function(response, status) {
          $scope.CuStatusOrders = response;
          $scope.CuStatusOrders.apply;
          console.log(response);
        }).error(function(error) {
          console.log(error);
       });
    }
  };
  $scope.filterOrdersByStatus3 = function(q) {
    console.log(q);
    if (!q.storeId) {
        ngNotify.set('something went wrong', { type: 'error', duration: 5000 });
    } else {
       var obj3 = {"storeId": q.storeId, "status":'pending' };
       $http.post(ldh + 'cuStatuswiseOrders', obj3).success(function(response, status) {
          $scope.CuStatusOrders = response;
          $scope.CuStatusOrders.apply;
          console.log(response);
        }).error(function(error) {
          console.log(error);
       });
    }
  };

}])
colorAdminApp.controller('StoresDeliveryOrdersController', ['$scope', '$http', 'Auth', 'pagination', 'ngNotify', 'NgTableParams', function($scope, $http, Auth, $pagination, ngNotify, NgTableParams) {
    var areaId = Auth.getAreaId();
   // var userObj = localStorage.getItem('laundry_admin_user_obj');
   // $scope.userRole = JSON.parse(userObj).employee.role;
    $scope.applyGlobalSearch = function() {
        $scope.tableParams.filter({ $: $scope.search });
    }

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
    $scope.ordersdata = { storeId:'', dDate: '' };
    var monthsList = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    $scope.fromDateSelected = (new Date().getMonth() + 1) + '/' + new Date().getDate() + '/' + (new Date().getFullYear());
    $scope.dateSelected = (new Date().getMonth() + 1) + '/' + new Date().getDate() + '/' + (new Date().getFullYear());
    $('#dDate').datepicker({
        setDate: new Date(),
        todayHighlight: true,
        format: 'dd/MM/yyyy'
    });
    $scope.filterOrdersBydate = function() {
        $scope.ordersdata.dDate = new Date($('#dDate').val());
        $scope.ordersdata.storeId = $scope.storeId;        
        $scope.getDeliveryOrders();
        $scope.ordersdata.apply;
    };
    $scope.orders = [];
    $scope.totalItemCount =0;
    $scope.getDeliveryOrders = function() {
        $http.post(ldh + 'stores-day-to-delivery-orders', $scope.ordersdata).success(function(response, status) {
            console.log("response", response);
            $scope.storeDeliveryOrders = {};
            angular.forEach(response, function(obj, k) {
                obj.detailsObj = obj.stringItems.split(',');
            });
            $scope.storeDeliveryOrders = response;
            console.log("response", response);

            var totalItems = 0;
            var res = response;
            for(var i in res){
            
                totalItems +=parseInt(res[i].totalItems);
            }
            $scope.totalItemCount = totalItems;
            $scope.totalItemCount.apply;
            $scope.tableParams = new NgTableParams({ count: 20, sorting: { id: "asc" } }, { counts: [25, 50, 100], dataset: res });

        }).error(function(err) {
            console.log(err);
        });
    }
    $scope.getDeliveryOrders();
}]);
/*.controller('StoreReturnGarmentsController',['$rootScope','$scope','$http','ngNotify','Auth',function($rootScope,$scope,$http,ngNotify,Auth){
  var vareaId  = Auth.getAreaId();
  var empId   = Auth.getEmpId();
  $scope.returnGarments = [];
  $scope.returnGarment = {inBarCode:''};
  $scope.getReturnGarments = function(vareaId){
    $http.post(ldh+'store-return-garments',{areaId:vareaId}).success(function(response,status){
      console.log(response);
      $scope.returnGarments = response.returnGarments;
    }).error(function(error){
      console.log(error);
    });
  };
  $scope.getReturnGarments();
  $scope.setReturnGarment = function(vareaId){
    $http.post(ldh+'store-return-garment',$scope.returnGarment).success(function(response,status){
      console.log(response);
        $scope.returnGarment = {};
    ngNotify.set(response.message,{duration:4000});
        $scope.getReturnGarments(vareaId);
    }).error(function(error){
      console.log(error);
    });
  };
}])*/
/*.controller('StoreHoldGarmentsController',['$rootScope','$scope','$http','ngNotify','Auth',function($rootScope,$scope,$http,ngNotify,Auth){
  var areaId  = Auth.getAreaId();
  var cueId   = Auth.getEmpId();
  console.log(cueId);
  $scope.holdGarments = [];
  $scope.holdGarment = {inBarCode:''};
  $scope.getHoldGarments = function(){
    $http.post(ldh+'store-return-garments',{areaId:areaId}).success(function(response,status){
      console.log(response);
      $scope.returnGarments = response.returnGarments;
    }).error(function(error){
      console.log(error);
    });
  };
  $scope.getHoldGarments();
  $scope.itemStatusChange =  function(inBarCode){
        $scope.holdGarment.inBarCode =  inBarCode;       
    }
    $scope.findHoldGarment = function(){
    }
  }])*/
  ;
