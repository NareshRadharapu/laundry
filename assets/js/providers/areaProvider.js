if(document.location.hostname=='www.cbsatwork.com'){
	var ldp = 'http://www.cbsatwork.com/laundry/';
}else{
	var ldp = 'http://localhost/laundry/';	
}


angular.module('colorAdminApp')
.factory('Area',function($http){
	return {
		all:function(){
			return $http.get('')
		}
	}
})