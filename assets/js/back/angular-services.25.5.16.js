

var ls = colorAdminApp.service('ls',['$http', function($http){

	

	this.getItems = function($itemtype){

		console.log($itemtype+'sss');

		if($itemtype){

		return $http.post(ldh+'admin/items/listsz',$itemtype).success(function(response,status){

			 return response;

			}).error(function(error){

				console.log(error);

		});

		}else{

			return $http.get(ldh+'admin/items/listsz').success(function(response,status){

			 return response;

			}).error(function(error){

				console.log(error);

		});

		}

	}

	

	this.getItemTypes = function(){

		return $http.get(ldh+'admin/items/itypeslist').success(function(response,status){

			 return response;

			}).error(function(error){

				console.log(error);

		});

	}

	this.getServiceItemTypes = function($sid){

		return $http.post(ldh+'admin/items/serviceitemtypesz',$sid).success(function(response,status){

			 return response;

			}).error(function(error){

				console.log(error);

		});

	}

	

	this.getServiceItems = function($catalog){

		return $http.post(ldh+'admin/services/items',$catalog).success(function(response,status){

			 return response;

			}).error(function(error){

				console.log(error);

		});

	}

	

	

	this.getServices = function(){

		return $http.get(ldh+'admin/services/listsz').success(function(response,status){

			 return response;

			}).error(function(error){

				console.log(error);

		});

	}

	

	this.getCatalogs = function(){

		return $http.get(ldh+'admin/catalog/listsz').success(function(response,status){

			 return response;

			}).error(function(error){

				console.log(error);

		});

	}

	

	this.getCatalogItems = function(){

		return $http.get(ldh+'admin/catalog/itemslist').success(function(response,status){

			 return response;

			}).error(function(error){

				console.log(error);

		});

	}

	

	this.checkUniqueValue = function(id, property, value) {

          var data = {

            id: id,

            property: property,

            value: value

          };

          return $http.post(ldh+"admin/cities/isuniquevalue", data).then(function(res){

			  console.log(res+'ser');

            return false;//res.data.isUnique;

          });

    }

	

		

}]);



var pagination = colorAdminApp.service('pagination',['$http', function($http){

	this.getPages = function(data,pageSize){

		

		return  nofp = Math.ceil(data.length/pageSize);

		

	}

	

}]);



