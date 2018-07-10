/*  Start CityController */
// var myHost = document.location.hostname;
// console.log(myHost);
// if(myHost=='www.cbsatwork.com')
//  var ldh = 'http://www.cbsatwork.com/laundry/';
// else
//  var ldh = 'http://192.168.10.104/laundry/';
/*****************************************************/
/****************** Login Controller *****************/
/*****************************************************/
angular.module('colorAdminApp')
    .controller('EmployeeController', ['$rootScope', '$scope', '$http', '$location', 'NgTableParams', 'ngNotify', 'Auth', function($rootScope, $scope, $http, $location, NgTableParams, ngNotify, Auth) {
        var areaId = Auth.getAreaId();
        $scope.employees = [];
        $scope.employee = {};
        $scope.areas = [];
        $scope.roles = [];
        $scope.addEmployee = function() {
            $http.post(ldh + 'employee-add-edit', $scope.employee).success(function(response) {
                ngNotify.set(response.message, { status: 'success' });
                $scope.getEmployees();
                $scope.employee = {};
            }).error(function(err) {
                console.log(err);
            });
        };
        $scope.getEmployees = function() {
            $http.get(ldh + 'employees').success(function(response) {
                console.log(response);
                $scope.tableParams = new NgTableParams({ count: 100, sorting: { id: "dsc" } }, { counts: [100, 500, 1000], dataset: response.employees });
            }).error(function(err) {
                console.log(err);
            });
        };
        $scope.getEmployees();
        $scope.getAreas = function() {
            $http.get(ldh + 'api-areas').success(function(response) {
                $scope.areas = response;
                console.log(response);
                $scope.areas.apply;
            }).error(function(err) {
                console.log(err);
            });
        };
        $scope.getAreas();
        $scope.getRoles = function() {
            $http.get(ldh + 'api-roles').success(function(response) {
                console.log(response);
                $scope.roles = response.roles;
                $scope.roles.apply;
            }).error(function(err) {
                console.log(err);
            });
        };
        $scope.getRoles();
        $scope.editEmployee = function($eid) {
            console.log($eid);
            $http.post(ldh + 'edit-employee', { empId: $eid }).success(function(response) {
                $scope.employee = response;
                $scope.employee.apply;
            }).error(function(err) {
                console.log(err);
            });
        };
    }]);
angular.module('colorAdminApp')
    .controller('VendorController', ['$rootScope', '$scope', '$http', '$location', 'NgTableParams', 'ngNotify', 'Auth', function($rootScope, $scope, $http, $location, NgTableParams, ngNotify, Auth) {
        var areaId = Auth.getAreaId();
        var monthsList = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        $scope.fromDateSelected = (new Date().getMonth() + 1) + '/' + new Date().getDate() + '/' + (new Date().getFullYear());
        $scope.dateSelected = (new Date().getMonth() + 1) + '/' + new Date().getDate() + '/' + (new Date().getFullYear());
        $('#discountExpiry').datepicker({
            todayHighlight: true,
            dateFormat: 'dd-mm-yy',
            autoclose: true,
        });
        $('#commissionExpiry').datepicker({
            todayHighlight: true,
            dateFormat: 'dd-mm-yy',
            autoclose: true,
        });
        $scope.vendor = { name: '', email: '', mobile: '', code: '', vgroupId: '', discountPercent: '', discountExpiry: '', commissionPercent: '', commissionExpiry: '' }
        $scope.addVendor = function() {
            $scope.vendor.discountExpiry = $('#discountExpiry').val();
            $scope.vendor.commissionExpiry = $('#commissionExpiry').val();
            $scope.storeVendor();
            $scope.vendor.apply;
        };
        $scope.storeVendor = function() {
            $http.post(ldh + 'vendor-add-edit', $scope.vendor).success(function(response) {
                ngNotify.set(response.message, { status: 'success' });
                $scope.getVendorsList();
                $scope.vendor = {};
            }).error(function(error) {
                console.log(error);
            });
        };
        $scope.getVendorsList = function() {
            $http.get(ldh + 'api-vendors')
                .then(function(response, status) {
                    $scope.vendorsList = response.data;
                    $scope.tableParams = new NgTableParams({ count: 20, sorting: { id: "dsc" } }, { counts: [20, 50, 100], dataset: response.data });
                    console.log($scope.vendorsList);
                }, function(error) {
                    console.log(error);
                });
        }
        $scope.getVendorsList();
        $scope.getVendorsGroupList = function() {
            $http.get(ldh + 'api-vendors-group')
                .then(function(response, status) {
                    $scope.vendorsGroupList = response.data;
                    //  $scope.tableParams = new NgTableParams({ count: 20,  sorting: { id: "dsc" } }, { counts: [20, 50, 100], dataset: response.data});
                    console.log($scope.vendorsGroupList);
                }, function(error) {
                    console.log(error);
                });
        }
        $scope.getVendorsGroupList();
        $scope.editVendor = function($id) {
            console.log($id);
            $http.post(ldh + 'edit-vendor', { vdId: $id }).success(function(response) {
                $scope.vendor = response;
                $scope.vendor.apply;
            }).error(function(err) {
                console.log(err);
            });
        };
        $scope.statusVendor = function($v) {
            $http.post(ldh + 'vendor-status', $v).success(function(response) {
                ngNotify.set('status successfully changed.');
                $scope.getVendorsList();
            }).error(function(error) {
                console.log(error);
            });
        };
    }]);
angular.module('colorAdminApp') 
      .controller('VendorGroupController',['$rootScope','$scope','$http','$location','NgTableParams','ngNotify','Auth', function($rootScope,$scope,$http,$location,NgTableParams,ngNotify,Auth){

    $scope.vendorgroup ={name:'', code:''}

    $scope.addVendorGroup = function(){
      $http.post(ldh+'vendorgroup-add-edit',$scope.vendorgroup).success(function(response){
              ngNotify.set(response.message,{status:'success'});
                $scope.getVendorsGroupList();
                $scope.vendorgroup ={};
      }).error(function(error){
        console.log(error);
      }); 
    };      

    $scope.getVendorsGroupList = function() {
    $http.get(ldh + 'api-vendors-group')
        .then(function(response, status) {
            $scope.vendorsGroupList = response.data;
            $scope.tableParams = new NgTableParams({ count: 20,  sorting: { id: "dsc" } }, { counts: [20, 50, 100], dataset: response.data});
            console.log($scope.vendorsGroupList);
        }, function(error) {
            console.log(error);
        });
    }
    $scope.getVendorsGroupList();


    $scope.editVendorGroup = function($id){
      console.log($id);
         $http.post(ldh+'edit-vendorgroup',{vdId:$id}).success(function(response){
            $scope.vendorgroup = response;
            $scope.vendorgroup.apply;
         }).error(function(err){
            console.log(err);
         });
    };
    $scope.statusVendorGroup = function($v) {
        $http.post(ldh + 'vendorgroup-status', $v).success(function(response) {
            ngNotify.set('status successfully changed.');
            $scope.getVendorsGroupList();
        }).error(function(error) {
            console.log(error);
        });
    };

}]);
angular.module('colorAdminApp')
    .controller('CUEmployeeController', ['$rootScope', '$scope', '$http', '$location', 'NgTableParams', 'ngNotify', 'Auth', function($rootScope, $scope, $http, $location, NgTableParams, ngNotify, Auth) {
        var areaId = Auth.getAreaId();
        $scope.employees = [];
        $scope.employee = {};
        $scope.stores = [];
        $scope.roles = [];
        //$scope.city       = 1;
        $scope.addEmployee = function() {
            $http.post(ldh + 'cu-employee', $scope.employee).success(function(response) {
                ngNotify.set(response.message, { status: 'success' });
                $scope.getEmployees();
                $scope.employee = {};
            }).error(function(err) {
                console.log(err);
            });
        };
        $scope.getEmployees = function() {
            $http.get(ldh + 'cu-employees').success(function(response) {
                console.log(response);
                $scope.tableParams = new NgTableParams({ count: 20, sorting: { id: "dsc" } }, { counts: [20, 50, 100], dataset: response.employees });
            }).error(function(err) {
                console.log(err);
            });
        };
        $scope.getEmployees();
        $scope.editEmployee = function($eid) {
            console.log($eid);
            $http.post(ldh + 'cu-edit-employee', { cueId: $eid }).success(function(response) {
                $scope.employee = response;
                $scope.employee.apply;
            }).error(function(err) {
                console.log(err);
            });
        };
        $scope.getAreas = function() {
            $http.post(ldh + 'cu-stores-list', {}).success(function(response) {
                $scope.stores = response.stores;
                console.log(response);
                $scope.stores.apply;
            }).error(function(err) {
                console.log(err);
            });
        };
        $scope.getAreas();
        $scope.getRoles = function() {
            $http.get(ldh + 'api-roles').success(function(response) {
                console.log(response);
                $scope.roles = response.roles;
                $scope.roles.apply;
            }).error(function(err) {
                console.log(err);
            });
        };
        $scope.getRoles();
    }]);