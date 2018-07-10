
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
   		.controller('vendorController',['$rootScope','$scope','$http','$location','ngNotify', function($rootScope,$scope,$http,$location,ngNotify){
   			$scope.login = {'email':'', 'password':''};

   			$scope.vendor = {name:'',email:'',mobile:''};
   			$scope.addVendor = function(){
   				$http.post(ldh+'admin/vendor/store').success(function(response){
   					console.log(response);
   				}).error(function(err){
   					console.log(err);
   				});	
   			};
}]);