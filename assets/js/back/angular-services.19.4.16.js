
var ls = colorAdminApp.service('ls',['$http', function($http){
	
	this.getItems = function($itemtype){
		console.log($itemtype+'sss');
		if($itemtype){
		return $http.put('http://192.168.0.102/laundry/admin/items/lists',$itemtype).success(function(response,status){
			 return response;
			}).error(function(error){
				console.log(error);
		});
		}else{
			return $http.get('http://192.168.0.102/laundry/admin/items/lists').success(function(response,status){
			 return response;
			}).error(function(error){
				console.log(error);
		});
		}
	}
	
	this.getItemTypes = function(){
		return $http.get('http://192.168.0.102/laundry/admin/items/itypeslist').success(function(response,status){
			 return response;
			}).error(function(error){
				console.log(error);
		});
	}
	this.getServiceItemTypes = function($sid){
		return $http.put('http://192.168.0.102/laundry/admin/items/serviceitemtypes',$sid).success(function(response,status){
			 return response;
			}).error(function(error){
				console.log(error);
		});
	}
	
	this.getServiceItems = function($catalog){
		return $http.put('http://192.168.0.102/laundry/admin/services/items',$catalog).success(function(response,status){
			 return response;
			}).error(function(error){
				console.log(error);
		});
	}
	
	
	this.getServices = function(){
		return $http.get('http://192.168.0.102/laundry/admin/services/lists').success(function(response,status){
			 return response;
			}).error(function(error){
				console.log(error);
		});
	}
	
	this.getCatalogs = function(){
		return $http.get('http://192.168.0.102/laundry/admin/catalog/lists').success(function(response,status){
			 return response;
			}).error(function(error){
				console.log(error);
		});
	}
	
	this.getCatalogItems = function(){
		return $http.get('http://192.168.0.102/laundry/admin/catalog/itemslist').success(function(response,status){
			 return response;
			}).error(function(error){
				console.log(error);
		});
	}	
}]);

var pagination = colorAdminApp.service('pagination',['$http', function($http){
	this.getPages = function(data,pageSize){
		
		return  nofp = Math.ceil(data.length/pageSize);
		
	}
	
}]);

