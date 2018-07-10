
 /*  Start CityController */

 // var myHost = document.location.hostname;

 // console.log(myHost);
 // if(myHost=='www.cbsatwork.com')
 //   var ldh = 'http://www.cbsatwork.com/laundry/';
 // else
 //   var ldh = 'http://192.168.10.104/laundry/';

 /*****************************************************/
 /****************** Login Controller *****************/
 /*****************************************************/
  angular.module('colorAdminApp') 
    .controller('CustomersBalanceListController',['$rootScope', '$scope', '$http', 'Auth','NgTableParams','ngNotify', function($rootScope, $scope, $http, Auth, NgTableParams,ngNotify){
          var storeId = Auth.getAreaId();
          $scope.customer  = {};
          //var storeId = 1;
          var userObj = localStorage.getItem('laundry_admin_user_obj');
          $scope.userRole = JSON.parse(userObj).employee.role;
          $scope.storeId = JSON.parse(userObj).employee.areaId;
         
         console.log("storeId", storeId, $scope.storeId);

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

      $scope.customers =[];
      $scope.getCustomers = function(storeId){

        $http.post(ldh+'cbs-customers-balance-sms-balance',{'storeId':storeId}).success(function(response){
        console.log(response);
          $scope.customerBalance = response;
        $scope.tableParams = new NgTableParams({ count: 5000,  sorting: { id: "dsc" } }, { counts: [200, 500, 1000], dataset:response });                   

        }).error(function(err){
          console.log(err);
        }); 
      };
      

      $scope.areaSelected = function(area){
        console.log("area", area)
        $scope.getCustomers(area);
      };
      $scope.getCustomers(storeId); 

      $scope.sendBalanceSMS = function(){
        console.log($scope.customers);
        var falseCount = 0;
        if($scope.customers.length > 0){
        angular.forEach($scope.customers,function(val, key){
          if(val === false){
            falseCount += 1;
          }
        });
        if(falseCount === $scope.customers.length){ 
          ngNotify.set('Please select at least one customer',{type:'error'});
        }else{
        
        $http.post(ldh+'cbs-customers-balance-sms',$scope.customers).success(function(response,status){
          console.log(response);
          $scope.customers       = { customers:[]};
          ngNotify.set(response.message,{status:'success'});
       
      }).error(function(err){
        console.log(err);
      });
    }
  }else if($scope.customers.length ===0) {
    ngNotify.set('Please select an customer(s) to send it to CU',{type:'error'});
  }
}

}]);

angular.module('colorAdminApp')
.controller('storeCustomerSmsController',['$rootScope','$scope','$http','ngNotify','Auth', 
            function($rootScope, $scope, $http, ngNotify, Auth){
  
  $scope.areas =[];
  $http.get(ldh+'admin/areas/listsz').success(function(response,status){
    $scope.areas = response;
    console.log(response);
    $scope.areas.apply;
  }).error(function(error){
  console.log(error);
});

$scope.sms = {'storeId':'', 'message':''};
$scope.storeCustomerSms = function(){
    $http.post(ldh+'cu-store-customer-sms', $scope.sms).success(function(response, status){
      ngNotify.set(response.message, {'type':'success'});
      $scope.sms = {'storeId':'', 'message':''};
    }).error(function(err){
      console.log(err);
    });
}



}]);

angular.module('colorAdminApp')
.controller('CustomSmsController',['$rootScope','$scope','$http','ngNotify','Auth', 
            function($rootScope, $scope, $http, ngNotify, Auth){
  
//   $scope.areas =[];
//   $http.get(ldh+'admin/areas/listsz').success(function(response,status){
//     $scope.areas = response;
//     console.log(response);
//     $scope.areas.apply;
//   }).error(function(error){
//   console.log(error);
// });

$scope.sms = {'mobile':'', 'message':''};
$scope.storeCustomerSms = function(){
    $http.post(ldh+'custom-sms', $scope.sms).success(function(response, status){
      ngNotify.set(response.message, {'type':'success'});
      $scope.sms = {'mobile':'', 'message':''};
    }).error(function(err){
      console.log(err);
    });
}



}]);
  angular.module('colorAdminApp') 
       .controller('CUEmployeeController',['$rootScope','$scope','$http','$location','NgTableParams','ngNotify','Auth', function($rootScope,$scope,$http,$location,NgTableParams,ngNotify,Auth){
          var areaId = Auth.getAreaId();
          $scope.employees  = [];
          $scope.employee   = {};
          $scope.stores      = [];
          $scope.roles      = [];
          //$scope.city       = 1;
          $scope.addEmployee = function(){
             $http.post(ldh+'cu-employee',$scope.employee).success(function(response){
                ngNotify.set(response.message,{status:'success'});
                  $scope.getEmployees();
                  $scope.employee ={};
             }).error(function(err){
                console.log(err);
             });   
          };
         

          $scope.getEmployees = function(){              
             $http.get(ldh+'cu-employees').success(function(response){
                console.log(response);
                $scope.tableParams = new NgTableParams({ count: 20,  sorting: { id: "dsc" } }, { counts: [20, 50, 100], dataset: response.employees});                   
             }).error(function(err){
                console.log(err);
             });
          };
          $scope.getEmployees();

          $scope.editEmployee = function($eid){
          console.log($eid);
             $http.post(ldh+'cu-edit-employee',{cueId:$eid}).success(function(response){
                $scope.employee = response;
                $scope.employee.apply;
             }).error(function(err){
                console.log(err);
             });
        };

           $scope.getAreas = function(){
              $http.post(ldh+'cu-stores-list',{}).success(function(response){
                $scope.stores = response.stores;
                console.log(response);
                $scope.stores.apply;
             }).error(function(err){
                console.log(err);
             });
          };
          $scope.getAreas();

           $scope.getRoles = function(){
              $http.get(ldh+'api-roles').success(function(response){
                console.log(response);
                $scope.roles = response.roles;
                $scope.roles.apply;
             }).error(function(err){
                console.log(err);
             });
          };
          $scope.getRoles();

}]);         