
   /*  Start CityController */

   // var myHost = document.location.hostname;

   // console.log(myHost);
   // if(myHost=='www.cbsatwork.com')
   // 	var ldh = 'http://www.cbsatwork.com/laundry/';
   // else
   // 	var ldh = 'http://192.168.10.104/laundry/';

   /*****************************************************/
   /****************** Login Controller *****************/
   /*****************************************************/
   	angular.module('colorAdminApp')
   		.controller('PickupboyController',['$rootScope','$scope','$http','$location','NgTableParams','ngNotify','Auth', function($rootScope,$scope,$http,$location,NgTableParams,ngNotify,Auth){
            var areaId =  Auth.getAreaId();
   			    $scope.pickupboys  = []; 
            $scope.pickupboy   = {};
            $scope.areas       = [];
            $scope.roles       = [];

   			$scope.addPickupboy = function(){

   				$http.post(ldh+'pickup-boy-add-edit',$scope.pickupboy).success(function(response){
                  ngNotify.set(response.message,{status:'success'});
                   $scope.getPickupboys();
                   $scope.pickupboy ={}; 
                   $scope.pickupboy.apply;
   				}).error(function(err){
   					console.log(err);
   				});	
   			};
           

            $scope.getPickupboys = function(){              
               $http.get(ldh+'pickupboys').success(function(response){
                  console.log(response);
                  $scope.tableParams = new NgTableParams({ count: 20,  sorting: { id: "dsc" } }, { counts: [20, 50, 100], dataset: response.pickupboys});                   
               }).error(function(err){
                  console.log(err);
               });
            };
            $scope.getPickupboys();

            $scope.getAreas = function(){
                $http.get(ldh+'api-areas').success(function(response){
                  $scope.areas = response;
                  console.log(response);
                  $scope.areas.apply;
               }).error(function(err){
                  console.log(err);
               });
            };
            $scope.getAreas();
 
          $scope.editPickupboy = function($pid){
            console.log($pid);
               $http.post(ldh+'edit-pickupboy',{pbId:$pid}).success(function(response){
                  $scope.pickupboy = response;
                 // $scope.pickupboy ={};
                  $scope.pickupboy.apply;
               }).error(function(err){
                  console.log(err);
               });
          };
}]);