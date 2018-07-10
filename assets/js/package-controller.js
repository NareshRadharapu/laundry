
/*  CENTRAL UNIT CONTROLLER  */

angular.module('colorAdminApp') 
.controller('AddPackageController',
  ['$rootScope','$scope','$http','$location','ls','ngNotify','Auth','$stateParams','$state',
 function($rootScope,$scope,$http,$location,$ls,ngNotify,Auth,$stateParams,$state){

/*   1st */

 /*     add package   */
 
  $scope.getCatalogPriceItems = function(){
      $http.post(ldh+'catalog-price-items',{}).then(function(response){
         $scope.pd.catalogItems = response.data;
      })
  }
 


  $scope.getAddons = function(){
      $http.post(ldh+'addon-items',{}).then(function(response){
         $scope.pd.addons = response.data;
      });
  }
  $scope.getAddons();

 $scope.getCatalogPriceItems();
 var packageId = $stateParams.pid;
  $scope.itemChoices = [{id: 'choice1'} ];
  $scope.addonChoices = [{id: 'choice1'}];

  $scope.pd = {pid:'', name:'', cost:'', duration:'',details:'', item_ids:[], pic:[],pa:[],pac:[], catalogItems:[], addons:[]};
  $scope.getPackage = function(pid){

    $http.post(ldh+'get-package',{'pid':pid}).success(function(response, status){
        $scope.pd = response;
        
        var pd = angular.fromJson(response.details);
        console.log(pd);
        for(var i = 1; i<Object.keys(pd.items).length; i++){
           var newItemNo = $scope.itemChoices.length+1;
          $scope.itemChoices.push({'id':'choice'+newItemNo});  
        }
        
        $scope.pd.item_ids = Object.keys(pd.items);
        $scope.pd.item_ids.apply;
        $scope.pd.pic = Object.values(pd.items);
        $scope.pd.pic.apply;
        
        for(var j = 1; j < Object.keys(pd.addons).length; j++){
          var newItemNo = $scope.addonChoices.length+1;
          $scope.addonChoices.push({'id':'choice'+newItemNo});
        }

        $scope.pd.pa = Object.keys(pd.addons);
        $scope.pd.pa.apply;
        $scope.pd.pac = Object.values(pd.addons);
        $scope.pd.pac.apply;
        

      }).error(function(err){
          console.log(err);
      });
  };

  $scope.getPackage(packageId);
  
  $scope.addItemChoice = function() {
    var newItemNo = $scope.itemChoices.length+1;
    $scope.itemChoices.push({'id':'choice'+newItemNo});
  };
    
  $scope.removeItemChoice = function(index) {
    var lastItem = $scope.itemChoices.length-1;
    console.log(index);
    $scope.itemChoices.splice(lastItem);
    console.log($scope.itemChoices)
  };

/*   addon choices  */
  
  $scope.addAddonChoice = function() {
    var newItemNo = $scope.addonChoices.length+1;
    $scope.addonChoices.push({'id':'choice'+newItemNo});
  };
    
  $scope.removeAddonChoice = function(index) {
    var lastItem = $scope.addonChoices.length-1;
    $scope.addonChoices.splice(lastItem);
  };

 

  $scope.addPackages = function(){
      $http.post(ldh+'add-edit-package',$scope.pd).success(function(respone, status){
        console.log(respone);
        $state.go('app.packages');
      }).error(function(err){
          console.log(err);
      });
  }

}])

.controller('PackagesController',
  ['$rootScope','$scope','$http','$location','NgTableParams','ngNotify','Auth',
    function($rootScope,$scope,$http,$location,NgTableParams,ngNotify,Auth){

    $scope.getPackages = function(){
      $http.post(ldh+'cbs-packages',{}).success(function(response, status){
        $scope.tableParams = new NgTableParams({ count: 25,  sorting: { id: "dsc" } }, { counts: [25, 35, 50], dataset: response.packages});

      }).error(function(err){
          console.log(err);
      });
    }

    $scope.getPackages();
}])  
