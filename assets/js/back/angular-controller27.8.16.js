var blue		= '#348fe2',
blueLight	= '#5da5e8',
blueDark	= '#1993E4',
aqua		= '#49b6d6',
aquaLight	= '#6dc5de',
aquaDark	= '#3a92ab',
green		= '#00acac',
greenLight	= '#33bdbd',
greenDark	= '#008a8a',
orange		= '#f59c1a',
orangeLight	= '#f7b048',
orangeDark	= '#c47d15',
dark		= '#2d353c',
grey		= '#b6c2c9',
purple		= '#727cb6',
purpleLight	= '#8e96c5',
purpleDark	= '#5b6392',
red         = '#ff5b57';


/* -------------------------------
   Custom Part
   ------------------------------- */

   /*  Start CityController */

   var myHost = document.location.hostname;

   console.log(myHost);
   if(myHost=='www.cbsatwork.com')
   	var ldh = 'http://www.cbsatwork.com/laundry/';
   else
   	var ldh = 'http://192.168.10.102/laundry/';


   /*****************************************************/
   /****************** Login Controller *****************/
   /*****************************************************/

   colorAdminApp.controller('loginController',['$rootScope','$scope','$http','$location','ngNotify','$state', function($rootScope,$scope,$http,$location,ngNotify,$state){
   	$scope.login = {'email':'', 'password':''};

   	$scope.login = function(form,data){
   		if(form.$valid){
   			console.log(form, data);
			// $location.path('/app/customerenquiry').replace();
			$http.post(ldh+'store-authentication',data).success(function(response,status){
				if(status == 202){
					ngNotify.set(response.message);
					$location.path('/app/customerenquiry').replace();
					localStorage.setItem('laundry_admin_user_obj',angular.toJson(response))
				}
			}).error(function(error){
				ngNotify.set('Error while trying to login.',  {type: 'error',duration: 5000});
				console.log(error);
			});

		}else{
			console.log('in valid ');	
		}
	};

   $scope.culogin = function(form,data){
         if(form.$valid){
            console.log(form, data);
         // $location.path('/app/customerenquiry').replace();
         $http.post(ldh+'cu-authentication',data).success(function(response,status){
            if(status == 202){
               ngNotify.set(response.message);
              $state.go('cu.cu-send-orders');
              $location.path('/central-unit/cu-send-orders').replace();
               localStorage.setItem('cu_user_obj',angular.toJson(response))
            }
         }).error(function(error){
            ngNotify.set('Error while trying to login.',  {type: 'error',duration: 5000});
            console.log(error);
         });

      }else{
         console.log('in valid ');  
      }
   };

}]);

   colorAdminApp.controller('CityController',['$rootScope','$scope','$http','pagination','ls','ngNotify','NgTableParams',function($rootScope,$scope,$http,$pagination,$ls,ngNotify, NgTableParams){
   	'use strict';
   	$scope.curPage = 0;
   	$scope.pageSize = 5;
   	$scope.pagination =0;

   	$scope.heading = 'Add City ';
   	$scope.city = {name:'',id:''};

   	$scope.unique = function(){
   		validationForm.city.name.$pristine = false;
   		console.log('unique test ');
   	};
   	$scope.addCity =  function(){

   		$http.post(ldh+'admin/cities/store',$scope.city).success(function(response,status){
   			$scope.getCities();
   			if($scope.city.id){
   				ngNotify.set('Your successfully updated '+$scope.city.name+'');
   			}else{
   				ngNotify.set('Your successfully added '+$scope.city.name+'');
   			}

   			$scope.city ={};
   			$scope.city.apply;

   		}).error(function(error){
   			console.log(error);
   		});

   	};
   	$scope.editCity = function($c){
   		console.log('city edited');
   		$http.post(ldh+'admin/cities/edit',$c).success(function(response,status){
			$scope.city.name = response.name; // city name populate
			$scope.city.id = response.id;
			console.log(response);
		}).error(function(error){
			console.log(error);
		});
	};
	$scope.statusCity = function($c){
		console.log('city status');
		$http.post(ldh+'admin/cities/status',$c).success(function(response,status){

			ngNotify.set('status successfully changed.');
			
			$scope.getCities();
			
		}).error(function(error){
			console.log(error);
		});
	};
	
	$scope.heading = ' Cities ';
	$scope.cities = [];
	$scope.getCities  = function(){
		$http.get(ldh+'admin/cities/lists').success(function(response,status){
			$scope.cities = response;

			$scope.tableParams = new NgTableParams({ count: 5,  sorting: { id: "dsc" } }, { counts: [5, 10, 25], dataset: response}); 

			$scope.cities.apply;
		}).error(function(error){
			console.log(error);
		});
	};

	$scope.getCities();	
	
}]);


   /*--- AreaController ----  */
   colorAdminApp.controller('AreaController',['$scope','$http','pagination','ngNotify','NgTableParams',function($scope,$http,$pagination,ngNotify,NgTableParams){
   	'use strict';
   	$scope.curPage = 0;
   	$scope.pageSize = 5;
   	$scope.pagination =0;

   	$scope.heading = 'Add Area ';
   	$scope.area = {name:'',city:'',sservices:[]};
   	$scope.cities =[];
   	$http.get(ldh+'admin/cities/listsz').success(function(response,status){
   		$scope.cities = response;

   		$scope.cities.apply;
   	}).error(function(error){
   		console.log(error);
   	});
   	$scope.addArea =  function(){
   		console.log('area form submited');
   		$http.post(ldh+'admin/areas/store',$scope.area).success(function(response,status){
   			$scope.area = {name:'',city:''};
   			$scope.area.apply;
   			$scope.getAreas();
   			if($scope.area.id)
   				ngNotify.set('Your successfully updated '+$scope.area.name+'');
   			else
   				ngNotify.set('Your successfully added '+$scope.area.name+'');
   			$scope.area ={};
   			$scope.area.apply;
            console.log(response);
   		}).error(function(error){
   			console.log(error);
   		});

   	};
   	$scope.editArea = function($a){

   		$http.post(ldh+'admin/areas/edit',$a).success(function(response,status){
			$scope.area = response;
		}).error(function(error){
			console.log(error);
		});
	};
	$scope.statusArea = function($a){
		$http.post(ldh+'admin/areas/status',$a).success(function(response,status){
			ngNotify.set('status successfully changed.');
			$scope.getAreas();
		}).error(function(error){
			console.log(error);
		});
	};
   $scope.getServices =  function(){
      $scope.services = $http.get(ldh+'admin/services/listsz').success(function(response,status){
         $scope.services = response;
         $scope.services.apply;
      }).error(function(error){
         console.log(error);
      });   
   }
   $scope.getServices();
	
	$scope.heading = ' Areas ';
	$scope.areas = [];
	$scope.getAreas  = function(){
		$http.get(ldh+'admin/areas/lists').success(function(response,status){
			$scope.areas = response;
           console.log(response);
			$scope.tableParams = new NgTableParams({ count: 5,  sorting: { id: "dsc" } }, { counts: [5, 10, 25], dataset: response}); 
			$scope.areas.apply;

		}).error(function(error){
			console.log(error);
		});
	};
	$scope.getAreas();
}]);


   /*--- ApartmentController ----  */
   colorAdminApp.controller('ApartmentController',['$scope','$http','pagination','ngNotify','NgTableParams',function($scope,$http,$pagination,ngNotify,NgTableParams){
   	'use strict';
   	$scope.curPage = 0;
   	$scope.pageSize = 5;
   	$scope.pagination =0;

   	$scope.heading = 'Add Apartment ';
   	$scope.apartment = {name:'',area:''};
   	$scope.areas =[];
   	$http.get(ldh+'admin/areas/listsz').success(function(response,status){
   		$scope.areas = response;
   		$scope.areas.apply;
   	}).error(function(error){
   		console.log(error);
   	});
   	$scope.catalogs =[];
   	$http.get(ldh+'admin/catalog/listsz').success(function(response,status){
   		$scope.catalogs = response;
   		$scope.catalogs.apply;
   	}).error(function(error){
   		console.log(error);
   	});
   	$scope.addApartment =  function(){
   		console.log('apartment form submited');
   		$http.post(ldh+'admin/apartments/store',$scope.apartment).success(function(response,status){
   			$scope.getApartments();
   			if($scope.apartment.id)
   				ngNotify.set('Your successfully updated '+$scope.apartment.name+'',{html:true});
   			else
   				ngNotify.set('Your successfully added '+$scope.apartment.name+'',{html:true});
   			$scope.apartment ={};
   			$scope.apartment.apply;
   		}).error(function(error){
   			console.log(error);
   		});

   	};
   	$scope.editApartment = function($a){

   		$http.post(ldh+'admin/apartments/edit',$a).success(function(response,status){
			$scope.apartment.name = response.name; // apartment name populate
			$scope.apartment.id = response.id;
			$scope.apartment.address = response.address;
			$scope.apartment.pincode = response.pincode;
			$scope.apartment.area = response.area_id.id;
			$scope.apartment.catalog = response.catalog_id.id;
			
		}).error(function(error){
			console.log(error);
		});
	};
	
	$scope.heading = ' Apartment ';
	
	$scope.statusApartment = function($a){
		$http.post(ldh+'admin/apartments/status',$a).success(function(response,status){
			$scope.getApartments();
			ngNotify.set('Status successfully changed.');
		}).error(function(error){
			console.log(error);
		});
	};
	
	$scope.apartments = [];
	$scope.getApartments  = function(){
		$http.get(ldh+'admin/apartments/lists').success(function(response,status){
			$scope.apartments = response;
			console.log(response);
			$scope.apartments.apply;
			$scope.tableParams = new NgTableParams({ count: 5,  sorting: { id: "dsc" } }, { counts: [5, 10, 25], dataset: response}); 

		}).error(function(error){
			console.log(error);
		});
	};
	$scope.getApartments();
}]);

   /*--- ApartmentBlockController ----  */
   colorAdminApp.controller('ApartmentBlockController',['$scope','$http','$stateParams',function($scope,$http,$stateParams){



   	$scope.apartment = ' ';
	//$scope.apartment = {name:'',area:''};
	$scope.blocks = [];  
	$a = $stateParams.id;
	
	$http.put(ldh+'admin/apartments/edit',$a).success(function(response,status){
		console.log(response);
		//	 $scope.apartment.name = response.name;
		$scope.apartment.apply;
	}).error(function(error){
		console.log(error);
	});

	$http.put(ldh+'admin/blocks/apartmentsblockswithflats',$a).success(function(response,status){

		console.log(response);
		$scope.blocks = response;
		$scope.blocks.apply;
	}).error(function(error){
		console.log(error);
	});
}]);

   /*--- FlatCustomerController ----  */
   colorAdminApp.controller('FlatCustomerController',['$scope','$http','$stateParams','NgTableParams',function($scope,$http,$stateParams, NgTableParams){

   	$scope.flat =[];
   	$scope.customers = [];
   	$scope.customer = [];
   	$scope.orders = [];
   	$a = $stateParams.id;

   	$http.put(ldh+'admin/flats/edit',$a).success(function(response,status){
   		console.log(response.name);
   		$scope.flat = response.name;
   		$scope.flat.apply;
   	}).error(function(error){
   		console.log(error);
   	});

   	$http.put(ldh+'admin/customers/flatcustlists',$a).success(function(response,status){

   		console.log(response);
   		$scope.customers = response;
   		$scope.customers.apply;
   	}).error(function(error){
   		console.log(error);
   	});

   	$scope.viewCustomer = function($c){
   		console.log('Customer display');
   		$http.post(ldh+'admin/customers/custview',$c).success(function(response,status){
			$scope.customer.firstname = response.firstname; // firstname populate
			$scope.customer.lastname = response.lastname;
			$scope.customer.email = response.email;
			$scope.customer.mobile = response.mobile;
			$scope.customer.id = response.id;
			console.log(response);
		}).error(function(error){
			console.log(error);
		});
	}
	$scope.viewOrder = function($o){
		$scope.orderhis = 'Order History';			
		console.log('Order History');
		$http.post(ldh+'admin/customers/orderview',$o).success(function(response,status){
			$scope.orders = response; // firstname populate
			$scope.tableParams = new NgTableParams({ count: 5,  sorting: { id: "dsc" } }, { counts: [5, 10, 25], dataset: response}); 

			console.log(response);
		}).error(function(error){
			console.log(error);
		});
	}
	$scope.orderDetails = function($d){
		$scope.orderdetails = 'Order Details';			
		console.log('Order Details');
		$http.post(ldh+'admin/customers/orderdetails',$d).success(function(response,status){
			$scope.orderdetailss = response; // firstname populate
			

			console.log(response);
		}).error(function(error){
			console.log(error);
		});
	}
}]);

   /*--- IndividualUserController ----  */
   colorAdminApp.controller('IndividualUserController',['$scope','$http','$stateParams','NgTableParams','ngNotify',function($scope,$http,$stateParams, NgTableParams,ngNotify){

	   	$scope.orders = {orders:[],details:''};
	   	var customerId = $stateParams.id;
	   	$scope.booleanVal = false;


		$scope.viewOrders = function($o){
			
			$http.post(ldh+'customer-orders',{'customerId':$o}).success(function(response,status){
				$scope.orders = response; 
				$scope.orders.apply;
            if($scope.booleanVal){
				  $scope.tableParams = new NgTableParams({ count: 5,  sorting: { id: "dsc" } }, { counts: [5, 10, 25], dataset: response.orders}); 
              $scope.tableParams.apply;
            }
				console.log(response);
			}).error(function(error){
				console.log(error);
			});

         $http.post(ldh+'transaction-history',{'customerId':$o}).success(function(response,status){
            if(!$scope.booleanVal){
               $scope.tableParams = new NgTableParams({ count: 20,  sorting: { id: "dsc" } }, { counts: [10, 20,50], dataset: response.transactions}); 
               $scope.tableParams.apply;
            }
            console.log(response);
         }).error(function(error){
            console.log(error);
         });



		};
      $scope.toogle = function(){
           $scope.viewOrders(customerId);
            return $scope.booleanVal = !$scope.booleanVal;
      }
		
	  $scope.viewOrders(customerId);

     $scope.setWalletZero = function(){
         $http.post(ldh+'store-customer-wallet',{customerId:customerId}).success(function(response,status){
            ngNotify.set(response.message,{type:'success',duration:2000});
             $scope.viewOrders(customerId);
         }).error(function(err){

         });
     };

}]);

   /*--- BlockController ----  */
   colorAdminApp.controller('BlockController',['$scope','$http','pagination','ngNotify','NgTableParams',function($scope,$http,$pagination,ngNotify, NgTableParams){
   	'use strict';
   	$scope.curPage = 0;
   	$scope.pageSize = 5;
   	$scope.pagination =0;
   	$scope.heading = 'Add Block ';
   	$scope.block = {name:'',apartment:''};
   	$scope.apartments =[];

   	$scope.addBlock =  function(){
   		console.log('block form submited');
   		$http.post(ldh+'admin/blocks/store',$scope.block).success(function(response,status){
   			console.log(response);
   			$scope.getBlocks();
   			if($scope.block.id)
   				ngNotify.set('Your successfully updated '+$scope.block.name+'',{html:true});
   			else
   				ngNotify.set('Your successfully added '+$scope.block.name+'',{html:true});
   			$scope.block ={}; 
   			$scope.block.apply;
   			console.log(status);
   		}).error(function(error){
   			console.log(error);
   		});

   	}
   	$scope.editBlock = function($a){
   		$http.post(ldh+'admin/blocks/edit',$a).success(function(response,status){
   			console.log(response);
			$scope.block.name = response.name; // block name populate
			$scope.block.id = response.id;
			$scope.block.apartment = response.apt_id.id;   
			
		}).error(function(error){
			console.log(error);
		});
	}
	$scope.statusBlock = function($a){
		$http.post(ldh+'admin/blocks/status',$a).success(function(response,status){
			$scope.getBlocks();
			ngNotify.set('Status successfully changed.');
		}).error(function(error){
			console.log(error);
		});
	}
	$http.get(ldh+'admin/apartments/listsz').success(function(response,status){
		$scope.apartments = response;
		$scope.apartments.apply;
	}).error(function(error){
		console.log(error);
	});
	$scope.heading1 = ' Blocks ';
	$scope.blocks = [];
	$scope.getBlocks  = function(){
		$http.get(ldh+'admin/blocks/lists').success(function(response,status){
			$scope.blocks = response;
			console.log(response);
			$scope.blocks.apply;
			$scope.tableParams = new NgTableParams({ count: 5,  sorting: { id: "dsc" } }, { counts: [5, 10, 25], dataset: response}); 


		}).error(function(error){
			console.log(error);
		});
	}
	$scope.getBlocks();
}]);


   /*--- FlatController ----  */
   colorAdminApp.controller('FlatController',['$scope','$http','pagination','ngNotify','NgTableParams',function($scope,$http,$pagination,ngNotify, NgTableParams){
   	'use strict';
   	$scope.heading = 'Add Flat ';
   	$scope.curPage = 0;
   	$scope.pageSize = 5;
   	$scope.pagination =0;
   	$scope.flats =[];

   	$scope.flat = {};

   	$scope.addFlat =  function(){
   		console.log($scope.flat);
   		$http.post(ldh+'admin/flats/store',$scope.flat).success(function(response,status){
   			$scope.getFlats();
   			if($scope.flat.id){
   				ngNotify.set('Your successfully updated '+$scope.flat.name);}
   				else{
   					ngNotify.set('Your successfully added '+$scope.flat.name);
   				}
   				$scope.flat ={};
   				$scope.flat.apply;

   			}).error(function(error){
   				console.log(error);
   			});

   		}
   		$http.get(ldh+'admin/apartments/arealistsz').success(function(response,status){
   			$scope.apartments = response;
   			$scope.apartments.apply;
   		}).error(function(error){
   			console.log(error);
   		});
   		$scope.blocks=[];

   		$scope.getBlocks = function($id){
   			$id = $scope.flat.apartment;
   			$http.post(ldh+'admin/blocks/listsz',$id).success(function(response,status){
   				$scope.blocks = response;
   				$scope.blocks.apply;  
   			}).error(function(error){
   				console.log(error);
   			});
   		}
   		$scope.heading1 = ' Flats ';
   		$scope.flats = [];

   		$scope.editFlat = function($f){
   			console.log('edit');
   			$http.post(ldh+'admin/flats/edit',$f).success(function(response,status){

   				$scope.getBlocks();
   				console.log(response);
   				$scope.flat.id    = response.id;
			$scope.flat.name  = response.name; // area name populate
			$scope.flat.unitType  = response.bhk; // area name populate
			$scope.flat.area  = response.size; // area name populate
			$scope.flat.facing  = response.facing; // area name populate
			$scope.flat.eusn  = response.eusn; // area name populate
			$scope.flat.intercom  = response.intercom; // area name populate
			$scope.flat.sale  = response.readyToSale; // area name populate
			$scope.flat.roccupy  = response.readyToOccupy; // area name populate
			
			$scope.flat.salePrice  = response.salePrice; // area name populate
			$scope.flat.rentPrice  = response.rentPrice; // area name populate
			
			$scope.flat.nofpplStay  = response.nofpplStay; // area name populate
			$scope.flat.cntOneName  = response.cntOneName; // area name populate
			$scope.flat.cntOneMobile  = response.cntOneMobile; // area name populate
			$scope.flat.cntTwoName  = response.cntTwoName; // area name populate
			$scope.flat.cntTwoMobile  = response.cntTwoMobile; // area name populate
			
			$scope.flat.block = response.block_id.id;  
			$scope.flat.apartment = response.block_id.apt_id.id;  
		}).error(function(error){
			console.log(error);
		});
	};
	$scope.statusFlat = function($a){
		$http.post(ldh+'admin/flats/status',$a).success(function(response,status){
			$scope.getFlats();
			ngNotify.set('status successfully changed.');
		}).error(function(error){
			console.log(error);
		});
	};
	$scope.getFlats  = function(){
		$http.get(ldh+'admin/flats/lists').success(function(response,status){
			$scope.flats = response;
			$scope.flats.apply;
			$scope.tableParams = new NgTableParams({ count: 5,  sorting: { id: "dsc" } }, { counts: [5, 10, 25], dataset: response});
		}).error(function(error){  
			console.log(error);
		});
	};
	$scope.getFlats();
}]);

   /*  Start CatalogController */
   colorAdminApp.controller('CatalogController',['$scope','$http','pagination','ngNotify','NgTableParams',function($scope,$http,$pagination,ngNotify, NgTableParams){
   	'use strict';	
   	$scope.curPage = 0;
   	$scope.pageSize = 5;
   	$scope.pagination =0; 
   	$scope.heading = 'Add Catalog ';
   	$scope.catalogs = [];
   	$scope.catalog = {name:'',id:'',description:''};
   	$scope.addCatalog =  function(){
   		console.log('catalog form submited');
   		$http.post(ldh+'admin/catalog/store',$scope.catalog).success(function(response,status){
   			$scope.getCatalogs();
   			if($scope.catalog.id){
   				ngNotify.set('Your successfully updated '+$scope.catalog.name+'',{html:true});}
   				else{
   					ngNotify.set('Your successfully added '+$scope.catalog.name+'',{html:true});}

   					$scope.catalog = {};
   					$scope.catalog.apply;
   				}).error(function(error){
   					console.log(error);
   				});		
   			};
   			$scope.editCatalog = function($c){
   				console.log('catalog edited');
   				$http.post(ldh+'admin/catalog/edit',$c).success(function(response,status){
			$scope.catalog.name = response.name; // catalog name populate
			$scope.catalog.id = response.id;
			$scope.catalog.description = response.description;
			
			//console.log(response);
		}).error(function(error){
			console.log(error);
		});
	};
	$scope.statusCatalog = function($c){
		console.log('catalog status'+$c);
		$http.post(ldh+'admin/catalog/status',$c).success(function(response,status){
			ngNotify.set('status successfully changed.');
			console.log(response);
			$scope.getCatalogs();
		}).error(function(error){
			console.log(error);
		});
	};
	
	$scope.heading = ' Cities ';
	$scope.catalogs = [];
	$scope.getCatalogs  = function(){
		$http.get(ldh+'admin/catalog/lists').success(function(response,status){
			$scope.catalogs = response;
			console.log(response);
			$scope.catalogs.apply;
			$scope.tableParams = new NgTableParams({ count: 5,  sorting: { id: "dsc" } }, { counts: [5, 10, 25], dataset: response});


		}).error(function(error){
			console.log(error);
		});
	};
	$scope.getCatalogs();

}]);

   /*  Start CatalogItemController */
   colorAdminApp.controller('CatalogItemController',['$scope','$http','ls','pagination','ngNotify','NgTableParams',function($scope,$http,$ls,$pagination,ngNotify, NgTableParams){

   	$scope.curPage = 0;
   	$scope.pageSize = 5;
   	$scope.pagination =0;
   	$scope.heading = 'Add Catalog Item';
   	$scope.catalogs = [];
   	$scope.catalogitem = {id:'',catalog:'',service:'',itemtype:'',item:'',price:'',discount:''};

   	$scope.services = [];
   	$scope.itemTypes = [];
   	$scope.services =  $ls.getServices().then(function(data){
   		$scope.services = data.data;
   		$scope.services.apply;

   	});

   	$scope.catalogs =  $ls.getCatalogs().then(function(data){
   		$scope.catalogs = data.data;
   		$scope.catalogs.apply;

   	});

   	$scope.itemTypes =  $ls.getItemTypes().then(function(data){
   		$scope.itemTypes = data.data;
   		$scope.itemTypes.apply;
   	});

   	$scope.items = [];

   	$scope.getItems = function(){
   		if($scope.catalogitem.itemtype===undefined)
   			return;

   		$scope.items =  $ls.getItems($scope.catalogitem.itemtype).then(function(data){
   			$scope.items = data.data;
   			$scope.items.apply;
   		});
   	};									
   	$scope.addCatalogItem =  function(){
		//console.log('catalog item form submited');
		$http.post(ldh+'admin/catalog/storeitems',$scope.catalogitem).success(function(response,status){
			if($scope.catalogitem.id){
				ngNotify.set('Your successfully updated catalog item');
			}else{
				ngNotify.set('Your successfully added catalogitem');
			}
			$scope.getCatalogItems();	
			$scope.catalogitem ={};
			$scope.catalogitem.apply;
		}).error(function(error){
			console.log(error);
		});

	}
	
	$scope.editCatalogItem = function($c){
		console.log('catalog item edited');
		
		$http.post(ldh+'admin/catalog/edititem',$c).success(function(response,status){
			$scope.catalogitem.id = response.id;
			$scope.catalogitem.catalog = response.catalog_id.id;
			$scope.catalogitem.service = response.service_id.id;
			$scope.catalogitem.item = response.item_id.id;
			$scope.catalogitem.itemtype = response.itype_id.id;
			$scope.catalogitem.price = response.cost;
			$scope.catalogitem.discount = response.discount;
			$scope.catalogitem.rpoints = response.rpoints;
			//console.log($scope.catalogitem.id);
			$scope.getItems();
		}).error(function(error){
			console.log(error);
		});
	}
	$scope.statusCatalogItem = function($c){
		console.log('catalog status');
		$http.post(ldh+'admin/catalog/statusitem',$c).success(function(response,status){
			ngNotify.set('status successfully changed.');
			console.log(response);
			$scope.getCatalogItems();
		}).error(function(error){
			console.log(error);
		});
	}
	
	$scope.heading = ' Add items to Catalog ';
	$scope.catalogs = [];
	
	
	$scope.applyGlobalSearch = function() {
		$scope.tableParams.filter({ $: $scope.search });
	}
	$scope.getCatalogItems = function(){
		$ls.getCatalogItems().then(function(data){
			$scope.catalogitems = data.data;
			//console.log(data.data+'items');
			$scope.catalogitems.apply;
			
			$scope.tableParams = new NgTableParams({ count: 5,  sorting: { id: "dsc" } }, { counts: [5, 10, 25], dataset: data.data});   

		});
	}

	$scope.statusArea = function($a){
		$http.post(ldh+'admin/areas/status',$a).success(function(response,status){
			$scope.getAreas();
		}).error(function(error){
			console.log(error);
		});
	}
	$scope.getCatalogItems();

}]);


   /*  Start ItemtypeController */
   colorAdminApp.controller('ItemTypeController',['$scope','$http','pagination','ngNotify','NgTableParams',function($scope,$http,$pagination,ngNotify, NgTableParams){

   	$scope.curPage = 0;
   	$scope.pageSize = 5;
   	$scope.pagination =0;
   	$scope.heading = 'Add Itemtype ';
   	$scope.itemtype = {name:'',code:'',id:''};
   	$scope.addItemtype =  function(){
   		console.log('itemtype form submited');
   		$http.post(ldh+'admin/itemtypes/store',$scope.itemtype).success(function(response,status){
   			console.log(response);
   			$scope.getItemtypes();
   			if($scope.itemtype.id)
   				ngNotify.set('Your successfully updated '+$scope.itemtype.name+'',{html:true});
   			else
   				ngNotify.set('Your successfully added '+$scope.itemtype.name+'',{html:true});

   			$scope.itemtype ={};
   			$scope.itemtype.apply;
   		}).error(function(error){
   			console.log(error);
   		});

   	}
   	$scope.editItemtype = function($c){
   		console.log('itemtype edited');
   		$http.post(ldh+'admin/itemtypes/edit',$c).success(function(response,status){
			$scope.itemtype.name = response.name;			 // item name populate
			$scope.itemtype.code = response.code;
			$scope.itemtype.id = response.id;
			console.log(response);
		}).error(function(error){
			console.log(error);
		});
	}
	$scope.statusItemtype = function($a){
		$http.post(ldh+'admin/itemtypes/status',$a).success(function(response,status){
			$scope.getItemtypes();
			ngNotify.set('status successfully changed.');
		}).error(function(error){
			console.log(error);
		});
	}
	
	$scope.heading = ' Itemtypes ';
	$scope.itemtypes = [];
	$scope.getItemtypes  = function(){
		$http.get(ldh+'admin/itemtypes/lists').success(function(response,status){
			$scope.itemtypes = response;
			console.log(response);
			$scope.itemtypes.apply;
			$scope.tableParams = new NgTableParams({ count: 5,  sorting: { id: "dsc" } }, { counts: [5, 10, 25], dataset: response});

		}).error(function(error){
			console.log(error);
		});
	}
	$scope.getItemtypes();
}]);

   /*  Start ItemController */
   colorAdminApp.controller('ItemController',['$scope','$http','pagination','FileUploader','ngNotify','NgTableParams',function($scope,$http,$pagination,FileUploader,ngNotify, NgTableParams){
   	$scope.curPage = 0;
   	$scope.pageSize = 5;
   	$scope.pagination =0;

   	$scope.heading = 'Add Item ';
   	$scope.item = {name:'',id:'',image:'',itemtype:''};

   	var uploader = $scope.uploader = new FileUploader({
   		url: ldh+'admin/items/upload/',
   		data: $scope.item.name
   	});

   	uploader.filters.push({
   		name: 'imageFilter',
   		fn: function(item , options) {
   			var type = '|' + item.type.slice(item.type.lastIndexOf('/') + 1) + '|';
   			return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
   		}
   	});

   	uploader.onWhenAddingFileFailed = function(item /*{File|FileLikeObject}*/, filter, options) {
          //  console.info('onWhenAddingFileFailed', item, filter, options);
        };
        uploader.onAfterAddingFile = function(fileItem) {
        	$scope.item.image = uploader.queue[0].file.name;
        	$scope.item.apply;
        	console.log($scope.item.image);
        };
        uploader.onAfterAddingAll = function(addedFileItems) {
            //console.info('onAfterAddingAll', addedFileItems);
          };
          uploader.onBeforeUploadItem = function(item) {

          };
          uploader.onProgressItem = function(fileItem, progress) {
            //console.info('onProgressItem', fileItem, progress);
          };
          uploader.onProgressAll = function(progress) {
            //console.info('onProgressAll', progress);
          };
          uploader.onSuccessItem = function(fileItem, response, status, headers) {
            //console.info('onSuccessItem', fileItem, response, status, headers);
          };
          uploader.onErrorItem = function(fileItem, response, status, headers) {
            //console.info('onErrorItem', fileItem, response, status, headers);
          };
          uploader.onCancelItem = function(fileItem, response, status, headers) {
           // console.info('onCancelItem', fileItem, response, status, headers);
         };
         uploader.onCompleteItem = function(fileItem, response, status, headers) {

         };
         uploader.onCompleteAll = function() {

         };

         $scope.addItem =  function(){
         	console.log($scope.item);

         	if(!$scope.item.sservices || $scope.item.sservices.length == 0){
         		ngNotify.set("Please select atleast one service",  {type: 'error',duration: 5000});
         	}else{
         		$http.post(ldh+'admin/items/store',$scope.item).success(function(response,status){
         			$scope.item.apply;
         			$scope.getItems();
         			if($scope.item.id)
         				ngNotify.set('Your successfully updated '+$scope.item.name+'',{html:true});
         			else
         				ngNotify.set('Your successfully added '+$scope.item.name+'',{html:true});

         			$scope.item ={};
         			$scope.item.apply;
         		}).error(function(error){
         			console.log(error);
         		});

         	}

         }
         $scope.sitemServices = [];
         $scope.editItem = function($c){
         	console.log('item edited');
      $http.put(ldh+'admin/items/edit',$c).success(function(response,status){
				$scope.item.name 		= response.name; // item name populate
				$scope.item.id 			= response.id;
				$scope.item.image 	= response.image;
				$scope.item.code 		= response.code;
				$scope.item.itemtype = response.itype_id.id;
			
			var ss = new Array();
			for(var i=0; i< response.itemServices.length;i++){
				ss.push(response.itemServices[i].id);
			}
			$scope.item.sservices = ss;
			
			$scope.item.apply;
		//	console.log(response);
	}).error(function(error){
		console.log(error);
	});
}
$scope.statusItem = function($c){
	console.log('item status');
	$http.post(ldh+'admin/items/status',$c).success(function(response,status){
		ngNotify.set('status successfully changed.');
		console.log(response);
		$scope.getItems();
	}).error(function(error){
		console.log(error);
	});
}

$scope.heading = ' Items ';
$scope.items = [];
$scope.getItems  = function(){
	$http.get(ldh+'admin/items/lists').success(function(response,status){
		$scope.items = response;
		$scope.items.apply;
			// console.log(response);
			$scope.tableParams = new NgTableParams({ count: 5,  sorting: { id: "dsc" } }, { counts: [5, 10, 25], dataset: response});
		}).error(function(error){
			console.log(error);
		});
	}
	$scope.getItems();

	$scope.tfilters = function(){
		var term = $scope.tsearch;
		$scope.tableParams.filter({ $: term });
		$scope.tableParams.apply;
	}
	
	$scope.changeFilter = function(field, value){
		var filter = {};
		filter[field] = value;
		angular.extend($scope.tableParams.filter(), filter);
	}
	

	$scope.getServices =  function(){
		$scope.services = $http.get(ldh+'admin/services/listsz').success(function(response,status){
			$scope.services = response;
			$scope.services.apply;
		}).error(function(error){
			console.log(error);
		});	
	}
	$scope.getServices();
	
	$scope.itemtypes = $http.get(ldh+'admin/itemtypes/listsz').success(function(response,status){
		$scope.itemtypes = response;
		$scope.itemtypes.apply;
	}).error(function(error){
		console.log(error);
	});
}]);


/*--- CatalogServiceController ----  */
colorAdminApp.controller('CatalogServiceController',['$scope','$http','$stateParams','NgTableParams', function($scope,$http,$stateParams,NgTableParams){
	$scope.catalog = ' ';
	$scope.catalog = {name:''};
	$c = $stateParams.id;
	
	$http.put(ldh+'admin/catalog/edit',$c).success(function(response,status){
		console.log(response.name);
		$scope.catalog.name = response.name;
		$scope.catalog.id = response.id;
		$scope.catalog.apply;
	}).error(function(error){
		console.log(error);
	});


	$http.put(ldh+'admin/catalog/catalogservices',$c).success(function(response,status){
		console.log(response);
		$scope.catalogservices = response;
		$scope.catalogservices.apply;
		$scope.tableParams = new NgTableParams({ count: 5,  sorting: { id: "asc" } }, { counts: [5, 10, 25], dataset: response});
	}).error(function(error){
		console.log(error);
	});



	$scope.viewServiceItem = function($a,$b){
		console.log('items='+$a+' '+$b);
		$scope.serviceitem = {catalogid:$a,serviceid:$b};
		$http.post(ldh+'admin/catalog/serviceitems',$scope.serviceitem).success(function(response,status){
			console.log(response);
			$scope.serviceitems = response; 
			$scope.tableParams = new NgTableParams({ count: 5,  sorting: { id: "dsc" } }, { counts: [5, 10, 25], dataset: response}); 

			//console.log(response);
		}).error(function(error){
			console.log(error);
		});
	}
}]);

/*  Start ServiceController */
colorAdminApp.controller('ServiceController',['$scope','$http','pagination','FileUploader','ngNotify','NgTableParams', function($scope,$http,$pagination,FileUploader,ngNotify, NgTableParams){
	$scope.curPage = 0;
	$scope.pageSize = 5;
	$scope.pagination =0;
	
	$scope.heading = 'Add Service ';
	$scope.service = {name:'', id:'', image:'',aimage:'', description:'', discount:''};

	var uploader = $scope.uploader = new FileUploader({
		url: ldh+'admin/services/upload/',
		data: $scope.service.name
	});

	uploader.filters.push({
		name: 'imageFilter',
		fn: function(item , options) {
			console.log('filters')
			var type = '|' + item.type.slice(item.type.lastIndexOf('/') + 1) + '|';
			return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
		}
	});

	uploader.onWhenAddingFileFailed = function(item, filter, options) {
		
	};
	
	uploader.onAfterAddingFile = function(fileItem) {

			$scope.service.aimage = uploader.queue[0].file.name;
			$scope.service.apply;
      console.log(uploader.queue[0].file.name);
	};
	
	uploader.onAfterAddingAll = function(addedFileItems) {
		//console.info('onAfterAddingAll', addedFileItems);
	};

	uploader.onBeforeUploadItem = function(item) {

	};

	uploader.onProgressItem = function(fileItem, progress) {
    //console.info('onProgressItem', fileItem, progress);
  };
  
  uploader.onProgressAll = function(progress) {
    //console.info('onProgressAll', progress);
  };
  
  uploader.onSuccessItem = function(fileItem, response, status, headers) {
    //console.info('onSuccessItem', fileItem, response, status, headers);
  };
  
  uploader.onErrorItem = function(fileItem, response, status, headers) {
    //console.info('onErrorItem', fileItem, response, status, headers);
  };
  
  uploader.onCancelItem = function(fileItem, response, status, headers) {
   // console.info('onCancelItem', fileItem, response, status, headers);
 };
 uploader.onCompleteItem = function(fileItem, response, status, headers) {
	 // console.info('onCompleteItem', fileItem, response, status, headers);
	};
	uploader.onCompleteAll = function() {
	 // console.info('onCompleteAll');
	};

	//	console.info('uploader', uploader);		
	$scope.addService =  function()	{
		console.log($scope.service);
		$http.post(ldh+'admin/services/store',$scope.service).success(function(response,status){
			$scope.service ={};
			$scope.service.apply;

			$scope.getServices();
			if($scope.service.id)
				ngNotify.set('Your successfully updated '+$scope.service.name+'');
			else
				ngNotify.set('Your successfully added '+$scope.service.name+'');
			
			console.log(response);
		}).error(function(error){
			console.log(error);
		});

	}
	$scope.editService = function($c){
		console.log('service edited');
		$http.post(ldh+'admin/services/edit',$c).success(function(response,status){
			
			$scope.service.name = response.name; // item name populate
			$scope.service.id = response.id;
			$scope.service.code = response.code;
			$scope.service.description = response.description;
			$scope.service.discount = response.discount;
			$scope.service.image = response.image;
			var addons = new Array();
			angular.forEach(response.serviceAddons, function(add){
				addons.push(add.id);
			});
			$scope.service.saddons = addons;
			console.log(response);
		}).error(function(error){
			console.log(error);
		});
	}
	$scope.statusService = function($c){
		console.log('service status');
		
		$http.post(ldh+'admin/services/status',$c).success(function(response,status){
			ngNotify.set('status successfully changed.');
			console.log(response);
			$scope.getServices();
		}).error(function(error){
			console.log(error);
		});
	}
	
	$scope.heading = ' Items ';
	$scope.services = [];
	
	$scope.getServices  = function(){
		
		$http.get(ldh+'admin/services/lists').success(function(response,status){
			$scope.services = response;
			$scope.services.apply;
			$scope.tableParams = new NgTableParams({ count: 5,  sorting: { id: "dsc" } }, { counts: [5, 10, 25], dataset: response});
		}).error(function(error){
			console.log(error);
		});
	}

	$scope.getServices();
	$scope.addons = [];
	
	$http.get(ldh+'admin/addon/listsz').success(function(response,status){
		$scope.addons = response;
		$scope.addons.apply;
	}).error(function(error){
		console.log(error);
	});
}]);


/*  Start AddonController */
colorAdminApp.controller('AddonController',['$scope','$http','pagination','FileUploader','ngNotify','NgTableParams',function($scope,$http,$pagination,FileUploader,ngNotify, NgTableParams){
	$scope.curPage = 0;
	$scope.pageSize = 5;
	$scope.pagination =0;
	
	$scope.heading = 'Add Addon ';
	$scope.addon = {name:'',id:'',image:'',price:'', description:''};
	
	console.log(angular.array);
	var uploader = $scope.uploader = new FileUploader({
		url: ldh+'admin/addon/upload/',
		data: $scope.addon.name
	});

	uploader.filters.push({
		name: 'imageFilter',
		fn: function(item , options) {
			var type = '|' + item.type.slice(item.type.lastIndexOf('/') + 1) + '|';
			return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
		}
	});

	uploader.onAfterAddingFile = function(fileItem) {
		$scope.addon.image = uploader.queue[0].file.name;
		$scope.addon.apply;
         ///    console.log($scope.addon.image);
       };

       uploader.onBeforeUploadItem = function(item) {
            //console.info('onBeforeUploadItem', item);
			//$scope.addon.image = '';
			//$scope.addon.apply;
		};

		$scope.addAddon =  function(){
	//	console.log($scope.addon);
	$http.post(ldh+'admin/addon/store',$scope.addon).success(function(response,status){
		$scope.addon.apply;
		$scope.getAddons();
		if($scope.addon.id)
			ngNotify.set('Your successfully updated '+$scope.addon.name+'',{html:true});
		else
			ngNotify.set('Your successfully added '+$scope.addon.name+'',{html:true});

		$scope.addon ={};
		$scope.addon.apply;
	}).error(function(error){
		console.log(error);
	});

}
$scope.editAddon = function($c){
	//	console.log('item edited');
	$http.post(ldh+'admin/addon/edit',$c).success(function(response,status){
			$scope.addon.name = response.name; // addon name populate
			$scope.addon.id = response.id;
			$scope.addon.price  = response.price;      
			$scope.addon.description = response.description;
			$scope.addon.image = response.image;   

			//console.log(response);
		}).error(function(error){
			console.log(error);
		});
	}
	$scope.statusAddon = function($c){
		////console.log('item status');
		$http.post(ldh+'admin/addon/status',$c).success(function(response,status){
			ngNotify.set('status successfully changed.');
			//console.log(response);
			$scope.getAddons();
		}).error(function(error){
			console.log(error);
		});
	}
	
	$scope.heading = ' Addons ';
	$scope.addons = [];
	$scope.getAddons  = function(){
		$http.get(ldh+'admin/addon/lists').success(function(response,status){
			$scope.addons = response;
			$scope.addons.apply;
			$scope.tableParams = new NgTableParams({ count: 5,  sorting: { id: "dsc" } }, { counts: [5, 10, 25], dataset: response});
		}).error(function(error){
			console.log(error);
		});
	}
	$scope.getAddons();
}]);

/*--- CustomerListController ----  */
colorAdminApp.controller('CustomerListController',['$scope','$http','pagination','ngNotify','NgTableParams',function($scope,$http,$pagination,ngNotify, NgTableParams){
	
	$scope.curPage = 0;
	$scope.pageSize = 5;
	$scope.pagination =0;
	$scope.heading = 'Add Customer ';
	$scope.customer = {firstname:'',id:''};
	
	$scope.areas =[];
	
	$http.get(ldh+'admin/areas/listsz').success(function(response,status){
		$scope.areas = response;
		$scope.areas.apply;
	}).error(function(error){
		console.log(error);
	});

	$scope.apartments = [];
	
	$http.get(ldh+'admin/apartments/listsz').success(function(response,status){
		$scope.apartments = response;
		console.log(response);
		$scope.apartments.apply;
	}).error(function(error){
		console.log(error);
	});
	
	
	$scope.addCustomer =  function(){
		console.log('Customer form submited');
		$http.post(ldh+'admin/customers/customerstore',$scope.customer).success(function(response,status){
			$scope.getCustomers();
			if($scope.customer.id)
				ngNotify.set('Your successfully updated '+$scope.customer.name+'',{html:true});
			else
				ngNotify.set('Your successfully added '+$scope.customer.name+'',{html:true});
			$scope.customer ={};
			$scope.customer.apply;
			console.log(status);
		}).error(function(error){
			console.log(error);
		});

	}
	$scope.editCustomer = function($a){
		$http.put(ldh+'admin/customers/customeredit',$a).success(function(response,status){
			$scope.customer.firstname = response.firstname; // customer name populate
			$scope.customer.lastname = response.lastname;
			$scope.customer.email = response.email;
			$scope.customer.mobile = response.mobile;
			$scope.customer.address = response.address;
			$scope.customer.id = response.id;
			$scope.customer.area = response.area_id.id;

			
		}).error(function(error){
			console.log(error);
		});
	}
	$scope.statusCustomer = function($a){
		$http.post(ldh+'admin/customers/status',$a).success(function(response,status){
			$scope.getCustomers();
			ngNotify.set('Status successfully changed.');
		}).error(function(error){
			console.log(error);
		});
	}

	$scope.heading1 = ' Customers List ';
	$scope.customers = [];
	$scope.getCustomers  = function(){
		$http.get(ldh+'admin/customers/customerlists').success(function(response,status){
			$scope.customers = response;
			console.log(response);
			$scope.customers.apply;

			$scope.tableParams = new NgTableParams({ count: 5,  sorting: { id: "dsc" } }, { counts: [5, 10, 25], dataset: response});

		}).error(function(error){
			console.log(error);
		});
	}
	$scope.getCustomers();
}]);


/*--- CustomerAptListController ----  */
colorAdminApp.controller('CustomerAptListController',['$scope','$http','pagination','ngNotify','NgTableParams',function($scope,$http,$pagination,ngNotify, NgTableParams){
	
	$scope.curPage = 0;
	$scope.pageSize = 5;
	$scope.pagination =0;
	$scope.heading = 'Add Customer ';
	$scope.customer = {firstname:'',lastname:'',email:'',subType:'',id:'',mobile:'',refid:''};
	
	$scope.subtypes = ["owner","tenant"];
	
	$scope.areas =[];
	$http.get(ldh+'admin/areas/listsz').success(function(response,status){
		$scope.areas = response;
		$scope.areas.apply;
	}).error(function(error){
		console.log(error);
	});

	$scope.apartments = [];
	
	$http.get(ldh+'admin/apartments/listsz').success(function(response,status){
		$scope.apartments = response;
		console.log(response);
		$scope.apartments.apply;
	}).error(function(error){
		console.log(error);
	});
	$scope.blocks = [];
	$scope.getBlocks = function(){
		$aprt = $scope.customer.apartment;
		$http.post(ldh+'admin/blocks/lists',$aprt).success(function(response,status){
			console.log(response);
			$scope.blocks = response;
			$scope.blocks.apply;
		}).error(function(error){
			console.log(error);
		});
	}
	$scope.flats = [];
	$scope.getFlats = function(){
		$block = $scope.customer.block;
		$http.post(ldh+'admin/flats/lists',$block).success(function(response,status){
			console.log(response);
			$scope.flats = response;
			$scope.flats.apply;
		}).error(function(error){
			console.log(error);
		});
	}
	
	
	
	$scope.addAptCustomer =  function(){
		console.log('Customer form submited');
		$http.post(ldh+'admin/customers/aptstore',$scope.customer).success(function(response,status){
			$scope.getCustomers();
			if($scope.customer.id)
				ngNotify.set('Your successfully updated '+$scope.customer.name+'',{html:true});
			else
				ngNotify.set('Your successfully added '+$scope.customer.name+'',{html:true});
			$scope.customer ={};
			$scope.customer.apply;
			console.log(status);
		}).error(function(error){
			console.log(error);
		});

	}
	$scope.editAptCustomer = function($a){
		$http.put(ldh+'admin/customers/aptedit',$a).success(function(response,status){
			$scope.getBlocks();
			$scope.getFlats();
			$scope.customer.firstname = response.firstname; // customer name populate
			$scope.customer.lastname = response.lastname;
			$scope.customer.email = response.email;
			$scope.customer.mobile = response.mobile;
			$scope.customer.id = response.id;
			$scope.customer.apartment = response.apt_id.id;
			$scope.customer.block = response.block_id.id;
			$scope.customer.flat = response.flat_id.id;
			
			
			
		}).error(function(error){
			console.log(error);
		});
	}
	$scope.statusCustomer = function($a){
		$http.post(ldh+'admin/customers/status',$a).success(function(response,status){
			$scope.getCustomers();
			ngNotify.set('Status successfully changed.');
		}).error(function(error){
			console.log(error);
		});
	}

	$scope.heading1 = ' Customers List ';
	$scope.customers = [];
	$scope.getCustomers  = function(){
		$http.get(ldh+'admin/customers/aptlists').success(function(response,status){
			$scope.customers = response;
			// console.log(response);
			$scope.customers.apply;

			$scope.tableParams = new NgTableParams({ count: 5,  sorting: { id: "dsc" } }, { counts: [5, 10, 25], dataset: response});

		}).error(function(error){
			console.log(error);
		});
	}

	$scope.getCustomers();
}]);


/*--- SettingsController ----  */
colorAdminApp.controller('SettingsController',['$scope','$http','pagination','ngNotify','NgTableParams',function($scope,$http,$pagination,ngNotify, NgTableParams){
	$scope.curPage = 0;
	$scope.pageSize = 5;
	$scope.pagination =0;
	$scope.heading = 'Settings ';
	$scope.settings = {refpoints:''};
	
	$scope.addSettings =  function(){
		console.log('Ref Points Entered');
		$http.post(ldh+'admin/settings/store',$scope.settings).success(function(response,status){
			$scope.getSettings();
			console.log(response);
		}).error(function(error){
			console.log(error);
		});

	}
	$scope.addCustomer =  function(){
		console.log('Settings changed');
		$http.post(ldh+'admin/settings/store',$scope.settings).success(function(response,status){
			$scope.getSettings();
			if($scope.settings.id)
				ngNotify.set('Your successfully updated '+$scope.settings.name+'',{html:true});
			else
				ngNotify.set('Your successfully added '+$scope.settings.name+'',{html:true});
			$scope.settings ={};
			$scope.settings.apply;
			console.log(status);
		}).error(function(error){
			console.log(error);
		});

	}
	$scope.editCustomer = function($a){
		$http.put(ldh+'admin/settings/edit',$a).success(function(response,status){

			$scope.settings.id = response.id;

			
		}).error(function(error){
			console.log(error);
		});
	}
	$scope.statusSettings = function($a){
		$http.post(ldh+'admin/settings/status',$a).success(function(response,status){
			$scope.getSettings();
			ngNotify.set('Status successfully changed.');
		}).error(function(error){
			console.log(error);
		});
	}

	$scope.settings = [];
	$scope.getSettings  = function(){
		$http.get(ldh+'admin/settings/lists').success(function(response,status){
			$scope.settings = response;
			console.log(response);
			$scope.settings.apply;

			$scope.tableParams = new NgTableParams({ count: 5,  sorting: { id: "dsc" } }, { counts: [5, 10, 25], dataset: response});
		}).error(function(error){
			console.log(error);
		});
	}
	$scope.getSettings();
}]);

/*********************************************************/
/***********	FacultyController ************************/
/*********************************************************/
colorAdminApp.controller('FacultyController',['$scope','$http','ls','ngNotify','NgTableParams',function($scope,$http,$ls,ngNotify,NgTableParams ){
	
	$scope.curPage = 0;
	$scope.pageSize = 5;
	$scope.pagination =0;
	$scope.heading = 'Add Faculty ';
	$scope.faculty = {id:'',firstname:'',lastname:'',email:'',mobile:'',designation:'',status:'',apartment:''};
	
	$scope.froles = ["admin","supervisor","watchmen"];
	$scope.areas =[];
	
	$http.get(ldh+'admin/areas/listsz').success(function(response,status){
		$scope.areas = response;
		$scope.areas.apply;
	}).error(function(error){
		console.log(error);
	});

	$scope.apartments = [];
	
	$http.get(ldh+'admin/apartments/listsz').success(function(response,status){
		$scope.apartments = response;
		console.log(response);
		$scope.apartments.apply;
	}).error(function(error){
		console.log(error);
	});
	
	$scope.addFaculty =  function(){

		$http.post(ldh+'ams/faculty/store',$scope.faculty).success(function(response,status){
			$scope.getFaculties();
			if($scope.faculty.id)
				ngNotify.set('Your successfully updated '+$scope.faculty.name+'');
			else
				ngNotify.set('Your successfully added '+$scope.faculty.name+'');
			$scope.faculty ={};
			$scope.faculty.apply;
			console.log(status);
		}).error(function(error){
			console.log(error);
		});

	}
	$scope.editFaculty = function($a){
		$http.put(ldh+'ams/faculty/edit',$a).success(function(response,status){
	$scope.faculty.firstname = response.firstname; // faculty name populate
	$scope.faculty.lastname = response.lastname;
	$scope.faculty.email = response.email;
	$scope.faculty.mobile = response.mobile;
	$scope.faculty.id = response.id;
	$scope.faculty.role = response.designation;
	$scope.faculty.apartment = response.apt_id.id;

}).error(function(error){
	console.log(error);
});
}
$scope.statusFaculty = function($a){
	$http.post(ldh+'ams/faculty/status',$a).success(function(response,status){
		$scope.getFaculties();
		ngNotify.set('Status successfully changed.');
	}).error(function(error){
		console.log(error);
	});
}

$scope.heading1 = ' Faculties List ';
$scope.faculties = [];
$scope.getFaculties  = function(){
	$http.get(ldh+'ams/faculty/lists').success(function(response,status){
		$scope.faculties = response;
		$scope.faculties.apply;

		$scope.tableParams = new NgTableParams({ count: 5,  sorting: { id: "dsc" } }, { counts: [5, 10, 25], dataset: response});

	}).error(function(error){
		console.log(error);
	});
}

$scope.getFaculties();
}]);

/***************************************************************/
/************** VECHICLE REGISTRATION *****************/
/***************************************************************/


colorAdminApp.controller('VehicleController',['$scope','$http','pagination','ngNotify','NgTableParams', '$filter', function($scope,$http,$pagination,ngNotify, NgTableParams, $filter){
	
	$scope.curPage = 0;
	$scope.pageSize = 5;
	$scope.pagination =0;
	$scope.heading = 'Add Vehicle ';
	$scope.vehicle = {vtype:'',customerId:'',brand:'',regno:'',rfid:''};
	
	$scope.apartments = [];
	
	$http.get(ldh+'admin/apartments/listsz').success(function(response,status){
		$scope.apartments = response;
		console.log(response);
		$scope.apartments.apply;
	}).error(function(error){
		console.log(error);
	});
	$scope.blocks = [];
	$scope.getBlocks = function($aprt){
		$http.post(ldh+'admin/blocks/listsz',$aprt).success(function(response,status){
			console.log(response);
			$scope.blocks = response;
			$scope.blocks.apply;
		}).error(function(error){
			console.log(error);
		});
	}
	$scope.flats = [];
	$scope.getFlats = function($block){
		
		//$block = $scope.vehicle.block;
		$http.post(ldh+'admin/flats/listsz',$block).success(function(response,status){
			console.log(response);
			$scope.flats = response;
			$scope.flats.apply;
		}).error(function(error){
			console.log(error);
		});
	}
	
	$scope.customers = [];
	$scope.getCustomers = function($flat){
		return $http.post(ldh+'admin/flats/customers',$flat).success(function(response,status){
			console.log(response);
			$scope.customers = response;
			$scope.customers.apply;
		}).error(function(error){
			console.log(error);
		});
	}
	
	
	$scope.addVehicle =  function(){
		console.log('Customer form submited');
		$http.post(ldh+'ams/vehicle/store',$scope.vehicle).success(function(response,status){
			$scope.getVehicles();
			if($scope.vehicle.id)
				ngNotify.set('Your successfully updated '+$scope.vehicle.name+'',{html:true});
			else
				ngNotify.set('Your successfully added '+$scope.vehicle.name+'',{html:true});
			$scope.vehicle ={};
			$scope.vehicle.apply;
			console.log(status);
		}).error(function(error){
			console.log(error);
		});

	}
	$scope.editVehicle = function($a){
		$http.put(ldh+'ams/vehicle/edit',$a).success(function(response,status){

			$scope.vehicle.rfid = response.rfid; // vehicle name populate
			$scope.vehicle.regno = response.regNumber;
			$scope.vehicle.vtype = response.vtype;
			$scope.vehicle.brand = response.make;
			
			$scope.vehicle.id = response.id;
			$scope.vehicle.apartment = response.apt_id.id;
			$scope.getBlocks(response.apt_id.id);
			$scope.vehicle.block = response.block_id.id;
			$scope.getFlats(response.block_id.id);
			$scope.vehicle.flat = response.flat_id.id;
			$scope.getCustomers(response.flat_id.id).then(function () {
				$scope.vehicle.customerId = $filter('filter')($scope.customers, {customerId: response.cust_id.id})[0];	
			});
			
			
			
			
			console.log($filter('filter')($scope.customers, {customerId: response.cust_id.id})[0]);
			console.log($scope.vehicle.customerId);
			
			console.log(response);
			
		}).error(function(error){
			console.log(error);
		});
	}
	$scope.statusVehicle = function($a){
		$http.post(ldh+'ams/vehicle/status',$a).success(function(response,status){
			$scope.getVehicles();
			ngNotify.set('Status successfully changed.');
		}).error(function(error){
			console.log(error);
		});
	}

	$scope.heading1 = ' Vechickes List ';
	$scope.vehicles = [];
	$scope.getVehicles  = function(){
		$http.get(ldh+'ams/vehicle/lists').success(function(response,status){
			$scope.vehicles = response;
			// console.log(response);
			$scope.vehicles.apply;

			$scope.tableParams = new NgTableParams({ count: 5,  sorting: { id: "dsc" } }, { counts: [5, 10, 25], dataset: response});

		}).error(function(error){
			console.log(error);
		});
	}

	$scope.getVehicles();
}]);

/******************************************************/
/************ VISITORS FUNCTION ********************/
/******************************************************/


colorAdminApp.controller('VisitorController',['$scope','$http','NgTableParams',function($scope,$http,NgTableParams){

	$scope.visitors = [];
	$http.get(ldh+'ams/visitor/listsz').success(function(response,status,header,config){
		
		console.log(response);
		console.log(status);
		console.log(header);
		console.log(config);
		
		$scope.tableParams = new NgTableParams({ count: 5,  sorting: { id: "dsc" } }, { counts: [5, 10, 25], dataset: response});

	}).error(function(error){
		console.log(error);
	});
}]);

colorAdminApp.controller('ApprovedVisitorsController',['$scope','$http','NgTableParams', function($scope,$http,NgTableParams){
	
}]);

/*--- customerEnquiryController ----  */

colorAdminApp.controller('customerEnquiryController',['$scope','$http','ls','ngNotify',function($scope,$http,$ls,ngNotify){
	'use strict';
	$scope.customer = {mobile:'',areaId:'',requestDateTime:''};
	$scope.checkExist = function(){
		$http.post(ldh+'admin/customers/getbymobile',$scope.customer.mobile).success(function(response,status){
			if(!response.id){
				ngNotify.set('customer not exist in our database, please add as new customer');
			}

			$scope.customer.customerId = response.id;
			$scope.customer.firstname 	= response.firstname;
			$scope.customer.lastname 	= response.lastname;
			$scope.customer.email 		= response.email;
			$scope.customer.mobile 		= response.mobile;
			$scope.customer.firstname 	= response.firstname;
			$scope.customer.type 	   = response.type;
			$scope.customer.address 	= response.address;
			$scope.customer.areaId     = response.area_id.id;
			$scope.customer.apply;
		}).error(function(error){
			console.log(error);
		});
		
	};

   $scope.cRequest = false;
   $scope.toggle = function($c){
      $scope.customer.customerId = $c;
      $scope.customer.customerId.apply;


       // Changes by Rajeshwar 25-08-2016 START
      $('#datetimepicker1').datetimepicker({
      useCurrent:true,
      format:'YYYY-MM-DD hh:mm:ss a'
      });
      $('#datetimepicker1').on("dp.change", function(e) {
      console.log('changeDate', e.date);
      $scope.customer.requestDateTime = e.date
      });
      // Changes by Rajeshwar 25-08-2016 END

      /*$('#datetimepicker1').datetimepicker({
            format:'YYYY-MM-DD hh:mm:ss a'
      });
      $('#datetimepicker1').on("changeDate", function() {
         $scope.customer.requestDateTime = $('#datetimepicker1').val()
      });*/

      $scope.cRequest =!$scope.cRequest;
      $scope.cRequest.apply;
   };
   
   $scope.makeRequest = function(){
        console.log('$scope.customer : ', $scope.customer);
      $http.post(ldh+'customer-add-request',$scope.customer).success(function(response,status){
        $scope.cRequest = false; 
        ngNotify.set(response.message,{type:'success',duration:4000});
      
      }).error(function(error){
         console.log(error);
      });
   };


}]);

/*******************************************************************/
/********************* PlaceOrderController  ***********************/
/*******************************************************************/

colorAdminApp.controller('PlaceOrderController',['$scope','$rootScope' ,'$http','ls','ngNotify','$stateParams','$state', function($scope,$rootScope,$http,$ls,ngNotify, $stateParams,$state){
	'use strict';
	$scope.heading = ' Place Order Form';
	$scope.subtotal =0;
	var orderSaved=false;

	$scope.placeorder 	= {id:'',customerId:'', orderId:'',service:'', itemtype:'', pitem:'', icount:'', addons:[]};

	$scope.mainorder 	= { customerId:'', temporders:[], orderDate:'',deliveryDate:'', adminDiscount:'', addressId:'',totalAmount:'' };
	$scope.mainorderStack 	= { customerId:'', temporders:[], orderDate:'', adminDiscount:'', addressId:'',totalAmount:'' };
	$scope.sitems = {customerId:'',serviceId:'',itemTypeId:''};
	
	$scope.epo = false;

   // Changes by Rajeshwar 25-08-2016 START
   $('#datepicker-default-order').datepicker({
    todayHighlight: true,
    format: 'dd-mm-yyyy'
   });

   $('#datepicker-default-order').on("changeDate", function() {
    $scope.mainorder.orderDate = $('#datepicker-default-order').val()
   });

   $('#datepicker-default-delivery').datetimepicker({
     useCurrent:true,
     format:'DD-MM-YYYY hh:mm:ss a'
   });

   $('#datepicker-default-delivery').on("dp.change", function(e) {
     console.log('changeDate', e.date);
     $scope.mainorder.deliveryDate = e.date
   });
   // Changes by Rajeshwar 25-08-2016 END

/*	$('#datepicker-default-order,#datepicker-default-delivery').datepicker({
		todayHighlight: true,
		format: 'dd-mm-yyyy'
	});

	$('#datepicker-default-order').on("changeDate", function() {
		$scope.mainorder.orderDate = $('#datepicker-default-order').val()
	});

   $('#datepicker-default-delivery').on("changeDate", function() {
      $scope.mainorder.deliveryDate = $('#datepicker-default-delivery').val()
   });*/


	$scope.getPreOrder = function($customerId){
		if($customerId!=''){
			$scope.placeorder.customerId = $customerId;
		}
		//console.log($scope.placeorder);
		$http.post(ldh+'admin/orders/getpreorder',$scope.placeorder).success(function(response,status){
			$scope.temporders = response;
         console.log(response);
			$scope.mainorder.temporders = response; 

			$scope.subtotal=0;
			angular.forEach($scope.temporders,function(val,key){
				$scope.subtotal += val.cost;
			})
		}).error(function(error){
			console.log(error);
		});			
	};
	if($stateParams.id){
		$scope.customerId = $stateParams.id;
		$scope.placeorder.customerId = $stateParams.id;
		$scope.mainorder.customerId = $stateParams.id;
		$scope.sitems.customerId = $stateParams.id;
		$scope.getPreOrder($stateParams.id);
	}else{
		$scope.orderId 				= $stateParams.orderid;
		$scope.placeorder.orderId 	= $stateParams.orderid;
		$scope.placeorder.apply;
	  //	console.log($scope.orderId);
	  $http.post(ldh+'admin/orders/editMainOrder', $scope.orderId).success(function(response,status){
   		console.log(response);
   		$scope.customerId 					= response.customerId;
   		$scope.sitems.customerId 			= response.customerId;
   		$scope.mainorder.customerId 		= response.customerId;
   		$scope.placeorder.customerId 		= response.customerId;
   		$scope.mainorder.addressId			= response.addressId;
   		$scope.mainorder.adminDiscount 		= response.adminDiscount;
   		$scope.mainorder.discountAmount     = response.discountAmount;
   		$scope.mainorder.orderDate 			= response.orderDate;
        // $scope.mainorder.deliveryDate       = response.deliveryDate;
   		$scope.mainorder.orderId      		= response.orderId;
   		$scope.mainorder.apply;
   		$scope.getPreOrder(response.customerId);
   		$scope.getAddress();
   	}).error(function(error){
   		console.log(error);
   	});
   };

   $scope.addresses = [];
   $scope.getAddress = function(){
		//console.log($scope.customerId);
		$http.post(ldh+'admin/customers/getaddress', $scope.customerId).success(function(response,status){
			$scope.addresses = response;
			$scope.addresses.apply;

		}).error(function(error){
			console.log(error);
		});
	}
	if($scope.customerId){
		$scope.getAddress();
	}



	$scope.sitems.serviceId = $scope.placeorder.service;
	$scope.sitems.itemTypeId = $scope.placeorder.itemtype;


	$scope.services = [];
	$scope.itemTypes = [];
	
	$scope.services =  $ls.getServices().then(function(data){
		$scope.services = data.data;
		$scope.services.apply;
	});

	$scope.itemTypes =  $ls.getItemTypes().then(function(data){
		$scope.itemTypes = data.data;
		$scope.itemTypes.apply;
	});
	
	$scope.items = [];
	$scope.addons = [];

	$scope.$watch('placeorder.service',function(n,o){
		$scope.placeorder.apply;
		$scope.sitems.serviceId = n;
		if(!$scope.epo){
			$scope.placeorder.itemtype='';
			$scope.placeorder.pitem='';	
		}
		
		$scope.sitems.apply;
	});

	$scope.$watch('placeorder.itemtype',function(p,q){

		$scope.sitems.itemTypeId = q;
		$scope.sitems.apply;
	});
	
	$scope.getServiceItems = function($it){
		
		$scope.sitems.itemTypeId = $it;
		$scope.sitems.apply;

		return $http.post(ldh+'admin/orders/getserviceitems',$scope.sitems).then(function(response){
			$scope.items = response.data.items;
			$scope.items.apply;
			$scope.addons = response.data.addons;
			$scope.addons.apply;
		});
	};
	
	$scope.savePreOrder = function(){
		$scope.epo ='';
		$scope.epo.apply;
		$scope.placeorder.addons = $scope.addons;
		var quantityExceeded = false;
		var existingItem = false;

		/*angular.forEach($scope.temporders,function(val, key){
			if($scope.placeorder.service === val.service_id.id &&  $scope.placeorder.itemtype === val.item_id.id && $scope.placeorder.pitem === val.item_id.id){
				existingItem = true;
			}
		});*/

		if(existingItem){
			ngNotify.set("Item already exists. Please add a different item",  {type: 'error',duration: 5000});
		}else{
			angular.forEach($scope.addons,function(val,key){
				if(val.selected){
					if(val.quantity > $scope.placeorder.icount){
						quantityExceeded=true;
					}
				}
			});

			if(quantityExceeded){
				ngNotify.set("Please make sure that the addons count doesn't exceed the actual count",  {type: 'error',duration: 5000});
			}else{
				$http.post(ldh+'admin/orders/savepreorder',$scope.placeorder).success(function(response,status){
					$scope.mainorderStack.temporders.push(angular.copy($scope.placeorder)); 
					console.log(response);
					if($scope.placeorder.orderId)
						ngNotify.set('Your successfully added/updated  ');
					else
						ngNotify.set('Your successfully added ');
					$scope.getPreOrder($scope.placeorder.customerId);
					var tplaceorder = {id:'', customerId:$scope.placeorder.customerId,service:'', itemtype:'', pitem:'', icount:'', addons:[]};
					$scope.placeorder 	= tplaceorder;
				}).error(function(error){
					console.log(error);
				});			
			}
		}
	}

	$scope.editOrderItem = function($toid ,to, index){
		$scope.epo = true;
		$http.post(ldh+'admin/orders/editorderitem',$toid).then(function(response,status){
			console.log(response.data);
			$scope.placeorder = response.data;
			$scope.placeorder.customerId = response.data.customerId;
			$scope.placeorder.orderId = response.data.orderId;
			$scope.items = response.data.items;
			$scope.addons = response.data.addons;
		});
	};

	$scope.temporders =[];

	$scope.discountChange = function(n){
		$scope.mainorder.discountAmount = Math.round($scope.mainorder.totalAmount*(n/100));
	};

	$scope.saveMainOrder = function(){
		orderSaved=true;
		if($scope.mainorder.addressId == '' || !$scope.mainorder.addressId){
			ngNotify.set('Please select one address',  {type: 'error',duration: 5000});
		}else{			
			/*var   orderDate = new Date($scope.mainorder.orderDate);
		   	   orderDate.setHours(new Date().getHours())
	           orderDate.setMinutes(new Date().getMinutes())
         	  orderDate.setSeconds(new Date().getSeconds())
			$scope.mainorder.orderDate = orderDate;
*/
         console.log($scope.mainorder);
					$http.post(ldh+'admin/orders/saveorder',$scope.mainorder).success(function(response,status){
						console.log(response);
						ngNotify.set(' main order completed..... ');
						$state.go('app.placeorders');
					}).error(function(error){
						console.log(error);
					});
		}
	};

	$scope.deleteOrderItem = function(id){
		$http.post(ldh+'admin/orders/trashtemporder',id).success(function(response,status){
			ngNotify.set(' order item moved to trashed... ');
			console.log(response);
			$scope.getPreOrder(response.customerId);
		}).error(function(error){
			console.log(error);
		});	
	};

			
	$scope.clearCartItems = function(){
		$http.post(ldh+'store-tash-temp-orders',$scope.placeorder).success(function(response,status){
			ngNotify.set(' order item moved to trashed... ');
			$scope.getPreOrder(response.customerId);
		}).error(function(error){
			console.log(error);
		});	
	}
   $scope.assignable= function(order_id){
      var orderId=order_id;
      var indigator=orderId.split("-");
      console.log(indigator);
      if(indigator=='M'){
         return true;
      }
      else{
         return false;
      }
   }

		$scope.$on('$stateChangeStart', function(event, toState, toParams, fromState, fromParams){ 
				console.log('from controller stateChangeStart')
				if(!orderSaved){
					var confirmExit = window.confirm('Are you sure you want to exit from this page?');
					if(confirmExit){
						$scope.clearCartItems();
					}else{
						event.preventDefault();
					}
				}
		});

		}]);


/*******************************************************************/
/***************** Edit PlaceOrderController  **********************/
/*******************************************************************/

colorAdminApp.controller('EditPlaceOrderController',['$scope','$http','ls','ngNotify','$stateParams', '$filter', function($scope,$http,$ls,ngNotify, $stateParams,$filter){
	'use strict';
	$scope.id = $stateParams.id;
	$scope.placeorder = [];
   	// $scope.placeorder = [{ orderId:'', orderDate:'',adminDiscount:'',service:{} , itemtype:[],pitem:[],quantity:[],addons:[],addressId:'',customerId:'', addonFlag:[]}];

   	$('#datepicker-default').datepicker({
   		todayHighlight: true
   	});

   	$scope.previousOrder = {};
   	$scope.getOrder =  function(){
   		$http.post(ldh+'admin/orders/getorder',$scope.id).then(function(response,status){

   			$scope.placeorder.orderId = response.data.orderId;
   			$scope.$watch('placeorder', function () {
   				console.log($scope.placeorder);
   			}, true);
   			console.log(response.data.orderId);
   			$scope.placeorder.adminDiscount = response.adminDiscount;
   			$scope.placeorder.apply;
   			if(response.data.orderId){
   				$scope.orderId = response.data.orderId;
   				$http.post(ldh+'admin/orders/getordersummary',$scope).success(function(response,status){
   					console.log(JSON.stringify(response));
   					initPlaceOrderArray(response.length);
   					getItems(response);
   					console.log(JSON.stringify(response));
   					$scope.previousOrder = response;
   					console.log(response);
   				}).error(function(error){
   					console.log(error);
   				});  
   			}else{
   				console.log('else');	
   			}
   		});
   	};

   	function initPlaceOrderArray (length) {
   		var baseObject = { orderId:'', orderDate:'',adminDiscount:'',service:{} , itemtype:[],pitem:[],quantity:[],addons:[],addressId:'',customerId:'', addonFlag:[]};
   		for(var i=0; i<length; i++){
   			$scope.placeorder.push(baseObject)
   		}
   	}

   	function getItems (data) {
   		angular.forEach(data, function (each, key) {
  		// if(each.addons.length > 0) {
  		// 	$scope.placeorder['addonFlag'][key] = true;
  		// }

  		$scope.getAddons(each.serviceId, key, function (res) {
  			$scope.addons[res.index] = res.data;
  			//$scope.placeorder['addons'][res.index]['addon'] = [];
  		//	$scope.placeorder['addons'][res.index]['addon'] = true;
  			//$scope.placeorder['addons'][res.index]['addon'][res.index];
  		});

  		$scope.getServiceItems(each.itemTypeId, key, function (res) {
  			$scope.items[res.index] = res.data;
  		});
  	})
   	}


 /* $scope.getOrderSummary =  function(){
	 $http.post(ldh+'admin/orders/getordersummary',$scope.placeorder.orderId).success(function(response,status){
		console.log(response);
		}).error(function(error){
			console.log(error);
			});  
	  
		};*/

		$scope.getOrder();

		$scope.addresses = [];
		$scope.getAddress = function(){
			$http.post(ldh+'admin/customers/getaddress', $scope.customerId).success(function(response,status){
				console.log(response);
				$scope.addresses = response;
				$scope.addresses.apply;
			}).error(function(error){
				console.log(error);
			});
		}
		if($scope.customerId){

			$scope.getAddress();
		}


		$scope.n =1; 

		$scope.poitems =  [1];

		$scope.placeorder.customerId = $scope.customerId;
		$scope.addNewChoice = function() {
	    // $scope.n = $scope.n +1;
	    // $scope.poitems.push($scope.n);
	    $scope.previousOrder.push({});
	  };

	  $scope.getServiceAddons = function (serviceId, index) {
	  	$scope.getAddons(serviceId, index, function (res) {
	  		$scope.addons[res.index] = res.data;
  			//$scope.placeorder['addons'][res.index]['addon'] = [];
  		//	$scope.placeorder['addons'][res.index]['addon'] = true;
  			//$scope.placeorder['addons'][res.index]['addon'][res.index];
  		});

	  }

	  $scope.getItems = function (itemId, index)	 {
	  	$scope.getServiceItems(itemId, index, function (res) {
	  		$scope.items[res.index] = res.data;
	  	});
	  } 

	  $scope.removeChoice = function($i) {
	  	$scope.poitems.pop($i);	
	  };

	  console.log('test 4');
	  $scope.heading = ' Place Order Form';
	  $scope.catalogs = [];
	  $scope.catalogitem = {id:'',catalog:'',service:'',itemtype:'',item:'',price:'',discount:''};

	  $scope.services = [];
	  $scope.itemTypes = [];

	  $scope.services =  $ls.getServices().then(function(data){
	  	$scope.services = data.data;
	  	console.log(data.data);
	  	$scope.services.apply;
	  });

	  $scope.catalogs =  $ls.getCatalogs().then(function(data){
	  	$scope.catalogs = data.data;
	  	$scope.catalogs.apply;
	  });

	  $scope.itemTypes =  $ls.getItemTypes().then(function(data){
	  	$scope.itemTypes = data.data;
	  	$scope.itemTypes.apply;
	  });

	  $scope.items = [];
	  $scope.addons = [];

	  $scope.initModelFilter = function (name, value, index) {
	  	$scope.placeorder[index]['service'] = $filter('filter')($scope.services, {id : value})[0];
	  }
	// $scope.getAddons = function($s,$ai){
	// 		$scope.addons[$ai] =  $ls.getServiceAddons($s).then(function(data){
	// 			$scope.addons[$ai] = data.data;
	// 			$scope.addons[$ai].apply;
	// 		});
	// }
	
	// $scope.getServiceItems = function($s,$i){
	// 		$scope.items[$i] =  $ls.getServiceItems($s).then(function(data){
	// 			$scope.items[$i] = data.data;
	// 			$scope.items[$i].apply;
	// 		});
	// }									
	
	$scope.getAddons = function($s, $ai, callback){
		$ls.getServiceAddons($s).then(function(data){
			callback({'data': data.data, index: $ai});
		});
	}

	$scope.getServiceItems = function($s,$i, callback){
		$ls.getServiceItems($s).then(function(data){
			callback({'data': data.data, index: $i});
		});
	}		

	$scope.saveOrder = function(){
		console.log('save');
			/*$http.post(ldh+'admin/orders/saveorder',$scope.placeorder).success(function(response,status){

				  $scope.placeorder = {}; 
				  ngNotify.set('Order Successfully placed...');
			}).error(function(error){
				console.log(error);
			});		*/	
		}

	}]);



/** PlaceOrdersController */

colorAdminApp.controller('PlaceOrdersController',['$scope','$state','$http','NgTableParams','ngNotify', function($scope, $state,$http,NgTableParams,ngNotify){
   
   $scope.order = { orderId:'', customerId:''};
   $scope.placeOrders   = [];
   $scope.curPage       = 0;
   $scope.pageSize      = 5;
   $scope.pagination    = 0;
   $scope.payment       = {oid:'',totalAmount:'',balanceAmount:'',payingAmount:'',walletAmount:''}   ;
   $scope.showModal     = false;
   $scope.selectedDate  = {};
   $scope.selectedDate  = new Date();
   $scope.totalOrders = 0;

   var cbsLocal  = localStorage.getItem('laundry_admin_user_obj');
   var localObj = $.parseJSON(cbsLocal);
   var areaId = localObj.employee.areaId;
   var empId = localObj.employee.id;
   $scope.cuOrder       = { orders:[],cueId:'',empId:empId};
  // $scope.cuEmployees   = [];
 

   $scope.placeOrderRequest = {orderId:'',pickupBoyId:''};

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
   $scope.filterOrdersBydate= function(){
         // $scope.selectedDate = new Date($('#datepicker-default').val());
         var fromDate=new Date($('#datepicker-default-from').val());;
         var toDate=new Date($('#datepicker-default-to').val());;
         // filterOrderItems($scope.selectedDate);
         filterOrderItems(fromDate,toDate);
         
   }
   // $('#datepicker-default').on("changeDate", function() {
      
   // });
   $scope.assignable= function(order_id){
      var orderId=order_id;
      var indigator=orderId.split("-");
      indigator=indigator[1];
      if(indigator=='M'){
         return true;
      }
      else{
         return false;
      }
   }

   $scope.toggleModal = function($o, $t,$paidAmount,$walletAmount){
      $scope.payment.oid           = $o;
      $scope.payment.totalAmount   = $t;
      $scope.payment.paidAmount    = $paidAmount;
      $scope.payment.balanceAmount = $t - $paidAmount;
      $scope.payment.payingAmount  =0;
      $scope.payment.walletAmount   = $walletAmount;
      $scope.showModal = !$scope.showModal;
   };

   

   /*** Make Payment **/
   $scope.makePayment = function(){
      $scope.showModal = false;
      $http.post(ldh+'admin/orders/makepayment',$scope.payment).then(function(response,status){
         $scope.getOrdersList();
      });  
   };
   
   $scope.pickupBoyModal = false;
   $scope.pickupToggle = function($a){
      $scope.placeOrderRequest.orderId = $a;
      $scope.pickupBoyModal = !$scope.pickupBoyModal;
   }

   // Modified by Arihant on 25/08/2016
   function filterOrderItems(fromDate,toDate){
     $scope.currentItems = [];
     $scope.filteredTamount=0;
     $scope.filteredBalamount=0;
     $scope.filteredPaidTamount=0;
     $scope.orderCount=0;
     $scope.tDiscount=0;
     angular.forEach($scope.allItems,function(val, key){
      var orderDate = new Date(val.orderDate)
      newToDate=new Date(toDate.valueOf())
            // Trick - To incerease the date by 1 since the default date is set to time 00:00;
            console.log(toDate);
            newToDate.setDate(toDate.getDate()+ 1);

            if(fromDate<=orderDate && newToDate>=orderDate) {
             $scope.currentItems.push(val);
             $scope.orderCount+=1;
             $scope.filteredTamount+=parseFloat(val.totalAmount);
             $scope.filteredBalamount+=parseFloat(val.balanceAmount);
             $scope.filteredPaidTamount+=parseFloat(val.paidAmount);
             $scope.tDiscount+=parseFloat(val.adminDiscountAmount);

           }
         });
     console.log($scope.currentItems);
     $scope.tableParams = new NgTableParams({count: 500, sorting: { id: "dsc" } }, { dataset: $scope.currentItems}); 
     $scope.tableParams.reload();
   }


  /* function filterOrderItems(fromDate,toDate){
   
      $scope.currentItems = [];
      angular.forEach($scope.allItems,function(val, key){
         var orderDate = new Date(val.orderDate)
         newToDate=new Date(toDate.valueOf())
         // Trick - To incerease the date by 1 since the default date is set to time 00:00;
         console.log(toDate);
         newToDate.setDate(toDate.getDate()+ 1);
         // console.log(orderDate);
         // console.log("/n");

         // console.log(toDate);
         // console.log("/n");
         
         // console.log(fromDate);
         // console.log("/n");

         // if(selectedDate.getDate() == orderDate.getDate() && selectedDate.getMonth() == orderDate.getMonth() && selectedDate.getFullYear() ==  orderDate.getFullYear()){
         //    $scope.currentItems.push(val);
         // } 
         if(fromDate<=orderDate && newToDate>=orderDate) {
               $scope.currentItems.push(val);
         }
      });
      console.log($scope.currentItems);
      $scope.tableParams = new NgTableParams({ count: 25,  sorting: { id: "dsc" } }, { counts: [15,25,50], dataset: $scope.currentItems}); 
      $scope.tableParams.reload();
   }*/

   /*** end make payment ***/  
   $scope.getOrdersList = function(){
      $http.post(ldh+'admin/orders/orderslist',areaId).then(function(response,status){
         console.log(response.data);
         $scope.allItems = response.data;
         // console.log($scope.selectedDate);
         var selectedDate=$scope.selectedDate;
         selectedDate.setHours(0);
         selectedDate.setMinutes(0);
         selectedDate.setSeconds(0);
         var init_from_date=new Date(selectedDate.valueOf());
         var init_to_date=new Date(selectedDate.valueOf());
         filterOrderItems(init_from_date,init_to_date);
      });   
   }

   $scope.getCUEmployees = function(){
      $http.get(ldh+'cu-employees').success(function(response,status,headers){
         $scope.cuEmployees = response.employees;
         console.log(response.employees);
      }).error(function(err){
         console.log(err);
      })
   }
   $scope.getCUEmployees();

   $scope.assignToCu = function(){
      console.log($scope.cuOrder);
      $http.post(ldh+'cu-place-order',$scope.cuOrder).success(function(response,status){
         console.log(response);
         $scope.cuOrder       = { orders:[]};
         ngNotify.set(response.message,{status:'success'});
         $scope.getOrdersList();
      }).error(function(err){
         console.log(err);
      });
   }
   $scope.applyGlobalSearch = function() {
      $scope.tableParams.filter({ $: $scope.search });
   }

   $scope.goToOrderSummary=function(orderId){
      console.log(orderId);
      $state.go('app.orderdetails',{orderId:orderId},{})
   };

   $scope.orderSummaryPrint = function($o,$c){
      $scope.order.orderId = $o;
      $scope.order.customerName = $c.firstname+' '+$c.lastname;
      $scope.order.userType = $c.type;
      $scope.order.apartmentAddress = $c.address;
      $http.post(ldh+'store-order-receipt',$scope.order).success(function(response,status){
         console.log(response);
         $scope.ordersummary = response;
      }).error(function(error){
         console.log(error);
      }); 
   }

   $scope.orderStatus = function($o){
      console.log('order status');
      $http.post(ldh+'admin/orders/orderidstatus',$o).success(function(response,status){
         $scope.getOrdersList();
      }).error(function(error){
         console.log(error);
      }); 
   }
   $scope.pickupBoys = [];
    $scope.pickupBoys = function($id){
         $http.post(ldh+'store-pickup-boys',{areaId:$id}).success(function(response){
            $scope.pickupBoys = response.pickupBoys;
            $scope.pickupBoys.push({pbId:'',name:'select'});
            $scope.pickupBoys.apply;
            
         }).error(function(err){
            console.log(err);
         });
   };

   $scope.pickupBoys(areaId);
   
   $scope.assignPickupBoy = function(){               
      $http.post(ldh+'place-order-assign',$scope.placeOrderRequest).success(function(response,status){
            ngNotify.set(response.message,{status:'success'});
            $scope.placeOrderRequest = {};
            $scope.pickupBoyModal =false;
            $scope.getOrdersList();
      }).error(function(err){
               console.log(err);
      });
   };

   $scope.getOrdersList();
}]);
colorAdminApp.controller('GlobalSearchController',['$scope','$state','$http','NgTableParams','ngNotify', function($scope, $state,$http,NgTableParams,ngNotify){




}]);
 


/*colorAdminApp.controller('PrintOrderController',['$scope','$http','$stateParams','$state', function($scope,$http, $stateParams,$state){
	'use strict';
	var orderId = $stateParams.porderid;
	$scope.order = {};
	$scope.orderSummaryPrint = function($o){
		$scope.order.orderId = $o;
	//	$scope.order.customerName = $c.firstname+' '+$c.lastname;
//		$scope.order.userType = $c.type;
//		$scope.order.apartmentAddress = $c.address;
$http.post(ldh+'store-order-receipt',$scope.order).success(function(response,status){
	console.log(response);
	$scope.ordersummary = response;
}).error(function(error){
	console.log(error);
}); 
};
$scope.orderSummaryPrint(orderId);

}])*/

colorAdminApp.controller('PrintOrderController',['$scope','$http','$stateParams','$state', function($scope,$http, $stateParams,$state){
	'use strict';
	var orderId = $stateParams.porderid;
	$scope.order = {};
	$scope.orderSummaryPrint = function($o){
		$scope.order.orderId = $o;
	//	$scope.order.customerName = $c.firstname+' '+$c.lastname;
	//	$scope.order.userType = $c.type;
	//	$scope.order.apartmentAddress = $c.address;
		$http.post(ldh+'store-order-receipt',$scope.order).success(function(response,status){
			console.log(response);
			$scope.ordersummary = response;
		}).error(function(error){
			console.log(error);
		}); 
	}
	
	$scope.orderSummaryPrint(orderId);
	$scope.printToCart=function(){
		window.print();
	}
 	
}]);

colorAdminApp.controller('OrdersRecordController', function($scope,$http){
	$scope.record = {};

	$scope.ordersRecord = function(){
		$http.get(ldh+'admin-order-records').success(function(response,status){
			$scope.record = response;
			$scope.record.apply;
			console.log(response);
		}).error(function(error){
			console(error);
		});
	}

	$scope.ordersRecord();
	$('#datepicker-default').datepicker({
		todayHighlight: true
	});
});

colorAdminApp.controller('OrderDetailsController',
	['$rootScope','$scope','$stateParams','$http','$location','ngNotify', 
	function($rootScope,$scope,$stateParams,$http,$location,ngNotify){

		console.log('OrderDetailsController');	
		var orderId = $stateParams.orderId;

		function getWholeOrderDetails(){
			$http.post(ldh+'store-process-order-details', {orderId:orderId})
			.success(function(response,status){
				$scope.ordersDetails = [];
				angular.forEach(response,function(val,key){
					if(val.proceItems.items && val.proceItems.items.length > 0){
						angular.forEach(val.proceItems.items,function(val2,key2){
							$scope.ordersDetails.push(val2)
						})
					}
				})
				console.log($scope.ordersDetails)
			}).error(function(error){
				console.log(error);
			});
		}

		getWholeOrderDetails();

		$scope.submitOrder=function(order){
			
			console.log(order);
			if(!order.inBarCode || (order.inBarCode != order.outBarCodeIp)){
				ngNotify.set('Please make sure in barcode and out barcode are same',  {type: 'error',duration: 5000});
			}else{
				var obj= {
					"processId":order.id,
					"outBarCode":order.outBarCodeIp
				};

				$http.post(ldh+'store-order-ready-for-deliver', obj)
				.success(function(response,status){
					console.log(response);
					getWholeOrderDetails();
				}).error(function(error){
					console.log(error);
				});
			}
		};

	}]);

/*colorAdminApp.controller('OrderDetailsController',
	['$rootScope','$scope','$stateParams','$http','$location','ngNotify', 
	function($rootScope,$scope,$stateParams,$http,$location,ngNotify){

		console.log('OrderDetailsController');	
		var orderId = $stateParams.orderId;

		function getWholeOrderDetails(){
			$http.post(ldh+'store-process-order-details', {orderId:orderId})
			.success(function(response,status){
				$scope.ordersDetails = [];
				angular.forEach(response,function(val,key){
					if(val.proceItems.items && val.proceItems.items.length > 0){
						angular.forEach(val.proceItems.items,function(val2,key2){
							$scope.ordersDetails.push(val2)
						})
					}
				})
				console.log($scope.ordersDetails)
			}).error(function(error){
				console.log(error);
			});
		}

		getWholeOrderDetails();

		$scope.submitOrder=function(order){
			
			console.log(order);
			if(!order.inBarCode || (order.inBarCode != order.inBarCodeIp)){
				ngNotify.set('Please make sure in barcode and out barcode are same',  {type: 'error',duration: 5000});
			}else{
				var obj= {
					"processId":order.id,
					"outBarCode":order.inBarCodeIp
				};

				$http.post(ldh+'store-order-ready-for-deliver', obj)
				.success(function(response,status){
					console.log(response);
					getWholeOrderDetails();
				}).error(function(error){
					console.log(error);
				});
			}
		};

	}]);*/


colorAdminApp.controller('ProcessOrderController',
	['$rootScope','$scope','$stateParams','$http','$location','ngNotify', 
	function($rootScope,$scope,$stateParams,$http,$location,ngNotify){

		console.log('ProcessOrderController');	
		var orderId = $stateParams.orderId ;

		function getOrderDetails(){
			$http.post(ldh+'admin/orders/mainOrderItems', orderId)
			.success(function(response,status){
				$scope.ordersList = response;
			}).error(function(error){
				console.log(error);
			});

		}
		getOrderDetails();

		$scope.viewProcessDetils=function(item, type){
			$scope.itemSelectedType = type;
			$scope.selectedOrder = item;
			console.log(item)

			$http.post(ldh+'store-pre-process-order', {"placeOrderId":item.id, "status":item.status})
			.success(function(response,status){
				$scope.processOrderDetails=response; 
				console.log(response,status)
			}).error(function(error){
				console.log(error);
			});
		}

		$scope.submitOrderDetails=function(){
			console.log('submitted',$scope.processOrderDetails);
			var addOnCountsOriginal = {};
			var addOnCounts = {};
			var typeKeys;
			validation = true;

			angular.forEach($scope.processOrderDetails.processItems,function(val,key){
				angular.forEach(val.addons,function(val2,key2){
					if(val2.selected){
						if(Object.keys(addOnCounts).indexOf(val2.name) >= 0){
							addOnCounts[val2.name] = (addOnCounts[val2.name] + 1) 
						}else{
							addOnCounts[val2.name] = 1;
						}
					}
				})
			});

			angular.forEach($scope.processOrderDetails.pacount,function(val,key){
				addOnCountsOriginal[val.key] = val.value;
			});

			typeKeys = Object.keys(addOnCountsOriginal);
			console.log(addOnCounts, addOnCountsOriginal, typeKeys);

			angular.forEach(typeKeys,function(val,key){
				if(addOnCountsOriginal[val] !== addOnCounts[val]){
					validation = false;
				}
			});

			if(validation){
				$http.post(ldh+'store-process-order', $scope.processOrderDetails)
				.success(function(response,status){
					console.log(response,status)
					if(status == 200){
						$scope.processOrderDetails = [];
						$scope.itemSelectedType = null;
						ngNotify.set(response.message);
						getOrderDetails();
					}
				}).error(function(error){
					console.log(error);
				});
			}else{
				ngNotify.set('Please make sure that the addons count is equal to the actual addons count',  {type: 'error',duration: 5000});
			}
		};

	}]);


   colorAdminApp.factory('Auth',function(){

         if(localStorage.getItem('cu_user_obj')!==null){
            var cbsLocal   = localStorage.getItem('cu_user_obj');
            var localObj   = $.parseJSON(cbsLocal);
            var empObj     = localObj.employee;
         }else if(localStorage.getItem('laundry_admin_user_obj')!==null){
            var cbsLocal   = localStorage.getItem('laundry_admin_user_obj');
            var localObj   = $.parseJSON(cbsLocal);
            var empObj     = localObj.employee;
         }else{
            
            var empObj     = {};
         }
         var employee = {};
            employee.getCityId =  function(){
               return empObj.cityId;
            },
            employee.getAreaId = function(){
               return empObj.areaId;  
            },
            employee.getEmpId  = function(){
               return empObj.id;
            }
         return employee;
         
   });


/*--- TakeOrderController ----  */

var app = angular.module('angularjs-starter', []);

app.controller('TakeOrderController', function($scope) {

	$scope.choices = [{id: 'choice1'}];

	$scope.addNewChoice = function() {
		var newItemNo = $scope.choices.length+1;
		$scope.choices.push({'id':'choice'+newItemNo});
	};

	$scope.removeChoice = function() {
		if($scope.choices.length>=2){
			var lastItem = $scope.choices.length-1;
			$scope.choices.splice(lastItem);
		};
	};

});


/* -------------------------------
  End Custom Part
  ------------------------------- */



/* -------------------------------
   1.0 CONTROLLER - App
   ------------------------------- */
   colorAdminApp.controller('appController', ['$rootScope', '$scope', function($rootScope, $scope) {
   	$scope.$on('$includeContentLoaded', function() {
   		App.initComponent();
   	});
   	$scope.$on('$viewContentLoaded', function() {
   		App.initComponent();
   		App.initLocalStorage();
   	});
   	$scope.$on('$stateChangeStart', function() {
        // reset layout setting
        $rootScope.setting.layout.pageSidebarMinified = false;
        $rootScope.setting.layout.pageFixedFooter = false;
        $rootScope.setting.layout.pageRightSidebar = false;
        $rootScope.setting.layout.pageTwoSidebar = false;
        $rootScope.setting.layout.pageTopMenu = false;
        $rootScope.setting.layout.pageBoxedLayout = false;
        $rootScope.setting.layout.pageWithoutSidebar = false;
        $rootScope.setting.layout.pageContentFullHeight = false;
        $rootScope.setting.layout.pageContentFullWidth = false;
        $rootScope.setting.layout.paceTop = false;
        $rootScope.setting.layout.pageLanguageBar = false;
        $rootScope.setting.layout.pageSidebarTransparent = false;
        $rootScope.setting.layout.pageWideSidebar = false;
        $rootScope.setting.layout.pageLightSidebar = false;
        $rootScope.setting.layout.pageFooter = false;
        $rootScope.setting.layout.pageMegaMenu = false;
        $rootScope.setting.layout.pageWithoutHeader = false;
        $rootScope.setting.layout.pageBgWhite = false;
        
        App.scrollTop();
        $('.pace .pace-progress').addClass('hide');
        $('.pace').removeClass('pace-inactive');
      });
   	$scope.$on('$stateChangeSuccess', function() {
   		Pace.restart();
   		App.initPageLoad();
   		App.initSidebarSelection();
   		App.initLocalStorage();
   		App.initSidebarMobileSelection();
   	});
   	$scope.$on('$stateNotFound', function() {
   		Pace.stop();
   	});
   	$scope.$on('$stateChangeError', function() {
   		Pace.stop();
   	});
   }]);



/* -------------------------------
   2.0 CONTROLLER - Sidebar
   ------------------------------- */
   colorAdminApp.controller('sidebarController', function($scope, $rootScope, $state) {
   	App.initSidebar();
   });



/* -------------------------------
   3.0 CONTROLLER - Right Sidebar
   ------------------------------- */
   colorAdminApp.controller('rightSidebarController', function($scope, $rootScope, $state) {
   	var getRandomValue = function() {
   		var value = [];
   		for (var i = 0; i<= 19; i++) {
   			value.push(Math.floor((Math.random() * 10) + 1));
   		}
   		return value;
   	};

   	$('.knob').knob();

   	var blue		= '#348fe2', green		= '#00acac', purple		= '#727cb6', red         = '#ff5b57';
   	var options = { height: '50px', width: '100%', fillColor: 'transparent', type: 'bar', barWidth: 8, barColor: green };

   	var value = getRandomValue();
   	$('#sidebar-sparkline-1').sparkline(value, options);

   	value = getRandomValue();
   	options.barColor = blue;
   	$('#sidebar-sparkline-2').sparkline(value, options);

   	value = getRandomValue();
   	options.barColor = purple;
   	$('#sidebar-sparkline-3').sparkline(value, options);

   	value = getRandomValue();
   	options.barColor = red;
   	$('#sidebar-sparkline-4').sparkline(value, options);
   });



/* -------------------------------
   4.0 CONTROLLER - Header
   ------------------------------- */
   colorAdminApp.controller('headerController', function($scope, $rootScope, $state) {
   	$scope.logout=function(){
   		console.log('logout');
   		localStorage.removeItem('laundry_admin_user_obj');
   		$state.go('login');
   	}
   });



/* -------------------------------
   5.0 CONTROLLER - Top Menu
   ------------------------------- */
   colorAdminApp.controller('topMenuController', function($scope, $rootScope, $state) {
   	setTimeout(function() {
   		App.initTopMenu();
   	}, 0);

      // Changes by Rajeshwar 25-08-2016 START
      $scope.userObj = angular.fromJson(localStorage.getItem('laundry_admin_user_obj'));
      $scope.userRole='';

      if($scope.userObj && $scope.userObj.employee){
        $scope.userRole = $scope.userObj.employee.role;
      }

      // STORE_ADMIN
      // SUPER_ADMIN
      // CENTRAL_UNIT_ADMIN
      // Changes by Rajeshwar 25-08-2016 END
   });



/* -------------------------------
   6.0 CONTROLLER - Page Loader
   ------------------------------- */
   colorAdminApp.controller('pageLoaderController', function($scope, $rootScope, $state) {
   	App.initPageLoad();
   });



/* -------------------------------
   7.0 CONTROLLER - Theme Panel
   ------------------------------- */
   colorAdminApp.controller('themePanelController', function($scope, $rootScope, $state) {
   	App.initThemePanel();
   });



/* -------------------------------
   8.0 CONTROLLER - Dashboard v1
   ------------------------------- */
   colorAdminApp.controller('dashboardController', function($scope, $rootScope, $state) {

    /* Vector Map
    ------------------------- */
    $('#world-map').vectorMap({
    	map: 'world_mill_en',
    	scaleColors: ['#e74c3c', '#0071a4'],
    	normalizeFunction: 'polynomial',
    	hoverOpacity: 0.5,
    	hoverColor: false,
    	markerStyle: {
    		initial: {
    			fill: '#4cabc7',
    			stroke: 'transparent',
    			r: 3
    		}
    	},
    	regionStyle: {
    		initial: {
    			fill: 'rgb(97,109,125)',
    			"fill-opacity": 1,
    			stroke: 'none',
    			"stroke-width": 0.4,
    			"stroke-opacity": 1
    		},
    		hover: { "fill-opacity": 0.8 },
    		selected: { fill: 'yellow' }
    	},
    	focusOn: { x: 0.5, y: 0.5, scale: 0 },
    	backgroundColor: '#2d353c',
    	markers: [
    	{latLng: [41.90, 12.45], name: 'Vatican City'},
    	{latLng: [43.73, 7.41], name: 'Monaco'},
    	{latLng: [-0.52, 166.93], name: 'Nauru'},
    	{latLng: [-8.51, 179.21], name: 'Tuvalu'},
    	{latLng: [43.93, 12.46], name: 'San Marino'},
    	{latLng: [47.14, 9.52], name: 'Liechtenstein'},
    	{latLng: [7.11, 171.06], name: 'Marshall Islands'},
    	{latLng: [17.3, -62.73], name: 'Saint Kitts and Nevis'},
    	{latLng: [3.2, 73.22], name: 'Maldives'},
    	{latLng: [35.88, 14.5], name: 'Malta'},
    	{latLng: [12.05, -61.75], name: 'Grenada'},
    	{latLng: [13.16, -61.23], name: 'Saint Vincent and the Grenadines'},
    	{latLng: [13.16, -59.55], name: 'Barbados'},
    	{latLng: [17.11, -61.85], name: 'Antigua and Barbuda'},
    	{latLng: [-4.61, 55.45], name: 'Seychelles'},
    	{latLng: [7.35, 134.46], name: 'Palau'},
    	{latLng: [42.5, 1.51], name: 'Andorra'},
    	{latLng: [14.01, -60.98], name: 'Saint Lucia'},
    	{latLng: [6.91, 158.18], name: 'Federated States of Micronesia'},
    	{latLng: [1.3, 103.8], name: 'Singapore'},
    	{latLng: [1.46, 173.03], name: 'Kiribati'},
    	{latLng: [-21.13, -175.2], name: 'Tonga'},
    	{latLng: [15.3, -61.38], name: 'Dominica'},
    	{latLng: [-20.2, 57.5], name: 'Mauritius'},
    	{latLng: [26.02, 50.55], name: 'Bahrain'},
    	{latLng: [0.33, 6.73], name: 'São Tomé and Príncipe'}
    	]
    });
    
    
    /* Line Chart
    ------------------------- */
    var data1 = [ 
    [1, 40], [2, 50], [3, 60], [4, 60], [5, 60], [6, 65], [7, 75], [8, 90], [9, 100], [10, 105], 
    [11, 110], [12, 110], [13, 120], [14, 130], [15, 135],[16, 145], [17, 132], [18, 123], [19, 135], [20, 150] 
    ];
    var data2 = [
    [1, 10],  [2, 6], [3, 10], [4, 12], [5, 18], [6, 20], [7, 25], [8, 23], [9, 24], [10, 25], 
    [11, 18], [12, 30], [13, 25], [14, 25], [15, 30], [16, 27], [17, 20], [18, 18], [19, 31], [20, 23]
    ];
    var xLabel = [
    [1,''],[2,''],[3,'May&nbsp;15'],[4,''],[5,''],[6,'May&nbsp;19'],[7,''],[8,''],[9,'May&nbsp;22'],[10,''],
    [11,''],[12,'May&nbsp;25'],[13,''],[14,''],[15,'May&nbsp;28'],[16,''],[17,''],[18,'May&nbsp;31'],[19,''],[20,'']
    ];
    $.plot($("#interactive-chart"), [{
    	data: data1, 
    	label: "Page Views", 
    	color: blue,
    	lines: { show: true, fill:false, lineWidth: 2 },
    	points: { show: true, radius: 3, fillColor: '#fff' },
    	shadowSize: 0
    }, {
    	data: data2,
    	label: 'Visitors',
    	color: green,
    	lines: { show: true, fill:false, lineWidth: 2 },
    	points: { show: true, radius: 3, fillColor: '#fff' },
    	shadowSize: 0
    }], {
    	xaxis: {  ticks:xLabel, tickDecimals: 0, tickColor: '#ddd' },
    	yaxis: {  ticks: 10, tickColor: '#ddd', min: 0, max: 200 },
    	grid: { 
    		hoverable: true, 
    		clickable: true,
    		tickColor: "#ddd",
    		borderWidth: 1,
    		backgroundColor: '#fff',
    		borderColor: '#ddd'
    	},
    	legend: {
    		labelBoxBorderColor: '#ddd',
    		margin: 10,
    		noColumns: 1,
    		show: true
    	}
    });
    var previousPoint = null;
    $("#interactive-chart").bind("plothover", function (event, pos, item) {
    	$("#x").text(pos.x.toFixed(2));
    	$("#y").text(pos.y.toFixed(2));
    	if (item) {
    		if (previousPoint !== item.dataIndex) {
    			previousPoint = item.dataIndex;
    			$("#tooltip").remove();
    			var y = item.datapoint[1].toFixed(2);
    			var content = item.series.label + " " + y;
    			$('<div id="tooltip" class="flot-tooltip">' + content + '</div>').css({ top: item.pageY - 45, left: item.pageX - 55 }).appendTo("body").fadeIn(200);
    		}
    	} else {
    		$("#tooltip").remove();
    		previousPoint = null;            
    	}
    	event.preventDefault();
    });
    
    
    /* Donut Chart
    ------------------------- */
    var donutData = [
    { label: "Chrome",  data: 35, color: purpleDark},
    { label: "Firefox",  data: 30, color: purple},
    { label: "Safari",  data: 15, color: purpleLight},
    { label: "Opera",  data: 10, color: blue},
    { label: "IE",  data: 5, color: blueDark}
    ];
    $.plot('#donut-chart', donutData, {
    	series: {
    		pie: {
    			innerRadius: 0.5,
    			show: true,
    			label: { show: true }
    		}
    	},
    	legend: { show: true }
    });
    

    /* Sparkline
    ------------------------- */
    var options = {
    	height: '50px',
    	width: '100%',
    	fillColor: 'transparent',
    	lineWidth: 2,
    	spotRadius: '4',
    	highlightLineColor: blue,
    	highlightSpotColor: blue,
    	spotColor: false,
    	minSpotColor: false,
    	maxSpotColor: false
    };
    function renderDashboardSparkline() {
    	var value = [50,30,45,40,50,20,35,40,50,70,90,40];
    	options.type = 'line';
    	options.height = '23px';
    	options.lineColor = red;
    	options.highlightLineColor = red;
    	options.highlightSpotColor = red;

    	var countWidth = $('#sparkline-unique-visitor').width();
    	if (countWidth >= 200) {
    		options.width = '200px';
    	} else {
    		options.width = '100%';
    	}

    	$('#sparkline-unique-visitor').sparkline(value, options);
    	options.lineColor = orange;
    	options.highlightLineColor = orange;
    	options.highlightSpotColor = orange;
    	$('#sparkline-bounce-rate').sparkline(value, options);
    	options.lineColor = green;
    	options.highlightLineColor = green;
    	options.highlightSpotColor = green;
    	$('#sparkline-total-page-views').sparkline(value, options);
    	options.lineColor = blue;
    	options.highlightLineColor = blue;
    	options.highlightSpotColor = blue;
    	$('#sparkline-avg-time-on-site').sparkline(value, options);
    	options.lineColor = grey;
    	options.highlightLineColor = grey;
    	options.highlightSpotColor = grey;
    	$('#sparkline-new-visits').sparkline(value, options);
    	options.lineColor = dark;
    	options.highlightLineColor = dark;
    	options.highlightSpotColor = grey;
    	$('#sparkline-return-visitors').sparkline(value, options);
    }
    renderDashboardSparkline();
    
    $(window).on('resize', function() {
    	$('#sparkline-unique-visitor').empty();
    	$('#sparkline-bounce-rate').empty();
    	$('#sparkline-total-page-views').empty();
    	$('#sparkline-avg-time-on-site').empty();
    	$('#sparkline-new-visits').empty();
    	$('#sparkline-return-visitors').empty();
    	renderDashboardSparkline();
    });


    /* Datepicker
    ------------------------- */
    $('#datepicker-inline').datepicker({ todayHighlight: true });


    
    /* Todolist
    ------------------------- */
    $('[data-click=todolist]').click(function() {
    	var targetList = $(this).closest('li');
    	if ($(targetList).hasClass('active')) {
    		$(targetList).removeClass('active');
    	} else {
    		$(targetList).addClass('active');
    	}
    });
    

    
    /* Gritter Notification
    ------------------------- */
    $(window).load(function() {
    	setTimeout(function() {
    		$.gritter.add({
    			title: 'Welcome back, Admin!',
    			text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tempus lacus ut lectus rutrum placerat.',
    			image: 'assets/img/user-2.jpg',
    			sticky: true,
    			time: '',
    			class_name: 'my-sticky-class'
    		});
    	}, 1000);
    });
  });



/* -------------------------------
   9.0 CONTROLLER - Dashboard v2
   ------------------------------- */
   colorAdminApp.controller('dashboardV2Controller', function($scope, $rootScope, $state) {

    /* Line Chart
    ------------------------- */
    var green = '#0D888B';
    var greenLight = '#00ACAC';
    var blue = '#3273B1';
    var blueLight = '#348FE2';
    var blackTransparent = 'rgba(0,0,0,0.6)';
    var whiteTransparent = 'rgba(255,255,255,0.4)';
    var month = [];
    month[0] = "January";
    month[1] = "February";
    month[2] = "March";
    month[3] = "April";
    month[4] = "May";
    month[5] = "Jun";
    month[6] = "July";
    month[7] = "August";
    month[8] = "September";
    month[9] = "October";
    month[10] = "November";
    month[11] = "December";

    Morris.Line({
    	element: 'visitors-line-chart',
    	data: [
    	{x: '2014-02-01', y: 60, z: 30},
    	{x: '2014-03-01', y: 70, z: 40},
    	{x: '2014-04-01', y: 40, z: 10},
    	{x: '2014-05-01', y: 100, z: 70},
    	{x: '2014-06-01', y: 40, z: 10},
    	{x: '2014-07-01', y: 80, z: 50},
    	{x: '2014-08-01', y: 70, z: 40}
    	],
    	xkey: 'x',
    	ykeys: ['y', 'z'],
    	xLabelFormat: function(x) {
    		x = month[x.getMonth()];
    		return x.toString();
    	},
    	labels: ['Page Views', 'Unique Visitors'],
    	lineColors: [green, blue],
    	pointFillColors: [greenLight, blueLight],
    	lineWidth: '2px',
    	pointStrokeColors: [blackTransparent, blackTransparent],
    	resize: true,
    	gridTextFamily: 'Open Sans',
    	gridTextColor: whiteTransparent,
    	gridTextWeight: 'normal',
    	gridTextSize: '11px',
    	gridLineColor: 'rgba(0,0,0,0.5)',
    	hideHover: 'auto',
    });

    /* Donut Chart
    ------------------------- */
    var green = '#00acac';
    var blue = '#348fe2';
    Morris.Donut({
    	element: 'visitors-donut-chart',
    	data: [
    	{label: "New Visitors", value: 900},
    	{label: "Return Visitors", value: 1200}
    	],
    	colors: [green, blue],
    	labelFamily: 'Open Sans',
    	labelColor: 'rgba(255,255,255,0.4)',
    	labelTextSize: '12px',
    	backgroundColor: '#242a30'
    });


    /* Vector Map
    ------------------------- */
    map = new jvm.WorldMap({
    	map: 'world_merc_en',
    	scaleColors: ['#e74c3c', '#0071a4'],
    	container: $('#visitors-map'),
    	normalizeFunction: 'linear',
    	hoverOpacity: 0.5,
    	hoverColor: false,
    	markerStyle: {
    		initial: {
    			fill: '#4cabc7',
    			stroke: 'transparent',
    			r: 3
    		}
    	},
    	regions: [{ attribute: 'fill' }],
    	regionStyle: {
    		initial: {
    			fill: 'rgb(97,109,125)',
    			"fill-opacity": 1,
    			stroke: 'none',
    			"stroke-width": 0.4,
    			"stroke-opacity": 1
    		},
    		hover: { "fill-opacity": 0.8 },
    		selected: { fill: 'yellow' }
    	},
    	series: {
    		regions: [{
    			values: {
    				IN:'#00acac',
    				US:'#00acac',
    				KR:'#00acac'
    			}
    		}]
    	},
    	focusOn: { x: 0.5, y: 0.5, scale: 2 },
    	backgroundColor: '#2d353c'
    });
    

    /* Calendar
    ------------------------- */
    var monthNames = ["January", "February", "March", "April", "May", "June",  "July", "August", "September", "October", "November", "December"];
    var dayNames = ["S", "M", "T", "W", "T", "F", "S"];
    var now = new Date(),
    month = now.getMonth() + 1,
    year = now.getFullYear();
    var events = [[
    '2/' + month + '/' + year,
    'Popover Title',
    '#',
    '#00acac',
    'Some contents here'
    ], [
    '5/' + month + '/' + year,
    'Tooltip with link',
    'http://www.seantheme.com/color-admin-v1.3',
    '#2d353c'
    ], [
    '18/' + month + '/' + year,
    'Popover with HTML Content',
    '#',
    '#2d353c',
    'Some contents here <div class="text-right"><a href="http://www.google.com">view more >>></a></div>'
    ], [
    '28/' + month + '/' + year,
    'Color Admin V1.3 Launched',
    'http://www.seantheme.com/color-admin-v1.3',
    '#2d353c',
    ]];
    var calendarTarget = $('#schedule-calendar');
    $(calendarTarget).calendar({
    	months: monthNames,
    	days: dayNames,
    	events: events,
    	popover_options:{
    		placement: 'top',
    		html: true
    	}
    });
    $(calendarTarget).find('td.event').each(function() {
    	var backgroundColor = $(this).css('background-color');
    	$(this).removeAttr('style');
    	$(this).find('a').css('background-color', backgroundColor);
    });
    $(calendarTarget).find('.icon-arrow-left, .icon-arrow-right').parent().on('click', function() {
    	$(calendarTarget).find('td.event').each(function() {
    		var backgroundColor = $(this).css('background-color');
    		$(this).removeAttr('style');
    		$(this).find('a').css('background-color', backgroundColor);
    	});
    });


    /* Gritter Notification
    ------------------------- */
    setTimeout(function() {
    	$.gritter.add({
    		title: 'Welcome back, Admin!',
    		text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tempus lacus ut lectus rutrum placerat.',
    		image: 'assets/img/user-14.jpg',
    		sticky: true,
    		time: '',
    		class_name: 'my-sticky-class'
    	});
    }, 1000);
  });



/* -------------------------------
   10.0 CONTROLLER - Email Inbox v1
   ------------------------------- */
   colorAdminApp.controller('emailInboxController', function($scope, $rootScope, $state) {
   	$rootScope.setting.layout.pageContentFullWidth = true;

    /* Email Select All
    ------------------------- */
    $('[data-click=email-select-all]').click(function(e) {
    	e.preventDefault();
    	if ($(this).closest('tr').hasClass('active')) {
    		$('.table-email tr').removeClass('active');
    	} else {
    		$('.table-email tr').addClass('active');
    	}
    });
    
    
    /* Email Select Single
    ------------------------- */
    $('[data-click=email-select-single]').click(function(e) { 
    	e.preventDefault();
    	var targetRow = $(this).closest('tr');
    	if ($(targetRow).hasClass('active')) {
    		$(targetRow).removeClass('active');
    	} else {
    		$(targetRow).addClass('active');
    	}
    });
    
    
    /* Email Remove
    ------------------------- */
    $('[data-click=email-remove]').click(function(e) { 
    	e.preventDefault();
    	var targetRow = $(this).closest('tr');
    	$(targetRow).fadeOut().remove();
    });
    
    
    /* Email Highlight
    ------------------------- */
    $('[data-click=email-highlight]').click(function(e) { 
    	e.preventDefault();
    	if ($(this).hasClass('text-danger')) {
    		$(this).removeClass('text-danger');
    	} else {
    		$(this).addClass('text-danger');
    	}
    });
  });



/* -------------------------------
   11.0 CONTROLLER - Email Inbox v2
   ------------------------------- */
   colorAdminApp.controller('emailInboxV2Controller', function($scope, $rootScope, $state) {
   	$rootScope.setting.layout.pageContentFullWidth = true;

    /* Email Checkbox
    ------------------------- */
    $('[data-checked=email-checkbox]').live('click', function() {
    	var targetLabel = $(this).closest('label');
    	var targetEmailList = $(this).closest('li');
    	if ($(this).prop('checked')) {
    		$(targetLabel).addClass('active');
    		$(targetEmailList).addClass('selected');
    	} else {
    		$(targetLabel).removeClass('active');
    		$(targetEmailList).removeClass('selected');
    	}
    	if ($('[data-checked=email-checkbox]:checked').length !== 0) {
    		$('[data-email-action]').removeClass('hide');
    	} else {
    		$('[data-email-action]').addClass('hide');
    	}
    });
    
    
    /* Email Action
    ------------------------- */
    $('[data-email-action]').live('click', function() {
    	var targetEmailList = '[data-checked=email-checkbox]:checked';
    	if ($(targetEmailList).length !== 0) {
    		$(targetEmailList).closest('li').slideToggle(function() {
    			$(this).remove();
    			if ($('[data-checked=email-checkbox]:checked').length !== 0) {
    				$('[data-email-action]').removeClass('hide');
    			} else {
    				$('[data-email-action]').addClass('hide');
    			}

    		});
    	}
    });
  });



/* -------------------------------
   12.0 CONTROLLER - Email Compose
   ------------------------------- */
   colorAdminApp.controller('emailComposeController', function($scope, $rootScope, $state) {
   	$rootScope.setting.layout.pageContentFullWidth = true;

    /* jQuery TagIt
    ------------------------- */
    $('#email-to').tagit({
    	availableTags: ["c++", "java", "php", "javascript", "ruby", "python", "c"]
    });
    
    
    /* WYSIHTML5
    ------------------------- */
    $('#wysihtml5').wysihtml5();
  });



/* -------------------------------
   13.0 CONTROLLER - Email Detail
   ------------------------------- */
   colorAdminApp.controller('emailDetailController', function($scope, $rootScope, $state) {
   	$rootScope.setting.layout.pageContentFullWidth = true;
   });



/* -------------------------------
   14.0 CONTROLLER - UI Modal & Notifications
   ------------------------------- */
   colorAdminApp.controller('uiModalNotificationController', function($scope, $rootScope, $state) {

    /* Gritter Notification
    ------------------------- */
    $('#add-sticky').click( function() {
    	$.gritter.add({
    		title: 'This is a sticky notice!',
    		text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tempus lacus ut lectus rutrum placerat. ',
    		image: 'assets/img/user-2.jpg',
    		sticky: true,
    		time: '',
    		class_name: 'my-sticky-class'
    	});
    	return false;
    });
    $('#add-regular').click( function() {
    	$.gritter.add({
    		title: 'This is a regular notice!',
    		text: 'This will fade out after a certain amount of time. Sed tempus lacus ut lectus rutrum placerat. ',
    		image: 'assets/img/user-3.jpg',
    		sticky: false,
    		time: ''
    	});
    	return false;
    });
    $('#add-max').click( function() {
    	$.gritter.add({
    		title: 'This is a notice with a max of 3 on screen at one time!',
    		text: 'This will fade out after a certain amount of time. Sed tempus lacus ut lectus rutrum placerat. ',
    		sticky: false,
    		image: 'assets/img/user-4.jpg',
    		before_open: function() {
    			if($('.gritter-item-wrapper').length === 3) {
    				return false;
    			}
    		}
    	});
    	return false;
    });
    $('#add-without-image').click(function(){
    	$.gritter.add({
    		title: 'This is a notice without an image!',
    		text: 'This will fade out after a certain amount of time.'
    	});
    	return false;
    });
    $('#add-gritter-light').click(function(){
    	$.gritter.add({
    		title: 'This is a light notification',
    		text: 'Just add a "gritter-light" class_name to your $.gritter.add or globally to $.gritter.options.class_name',
    		class_name: 'gritter-light'
    	});
    	return false;
    });
    $('#add-with-callbacks').click(function(){
    	$.gritter.add({
    		title: 'This is a notice with callbacks!',
    		text: 'The callback is...',
    		before_open: function(){
    			alert('I am called before it opens');
    		},
    		after_open: function(e){
    			alert("I am called after it opens: \nI am passed the jQuery object for the created Gritter element...\n" + e);
    		},
    		before_close: function(manual_close) {
    			var manually = (manual_close) ? 'The "X" was clicked to close me!' : '';
    			alert("I am called before it closes: I am passed the jQuery object for the Gritter element... \n" + manually);
    		},
    		after_close: function(manual_close){
    			var manually = (manual_close) ? 'The "X" was clicked to close me!' : '';
    			alert('I am called after it closes. ' + manually);
    		}
    	});
    	return false;
    });
    $('#add-sticky-with-callbacks').click(function(){
    	$.gritter.add({
    		title: 'This is a sticky notice with callbacks!',
    		text: 'Sticky sticky notice.. sticky sticky notice...',
    		sticky: true,
    		before_open: function(){
    			alert('I am a sticky called before it opens');
    		},
    		after_open: function(e){
    			alert("I am a sticky called after it opens: \nI am passed the jQuery object for the created Gritter element...\n" + e);
    		},
    		before_close: function(e){
    			alert("I am a sticky called before it closes: I am passed the jQuery object for the Gritter element... \n" + e);
    		},
    		after_close: function(){
    			alert('I am a sticky called after it closes');
    		}
    	});
    	return false;
    });
    $("#remove-all").click(function(){
    	$.gritter.removeAll();
    	return false;
    });
    $("#remove-all-with-callbacks").click(function(){
    	$.gritter.removeAll({
    		before_close: function(e){
    			alert("I am called before all notifications are closed.  I am passed the jQuery object containing all  of Gritter notifications.\n" + e);
    		},
    		after_close: function(){
    			alert('I am called after everything has been closed.');
    		}
    	});
    	return false;
    });
  });



/* -------------------------------
   15.0 CONTROLLER - UI Tree
   ------------------------------- */
   colorAdminApp.controller('uiTreeController', function($scope, $rootScope, $state) {

   	$('#jstree-default').jstree({
   		"core": {
   			"themes": {
   				"responsive": false
   			}            
   		},
   		"types": {
   			"default": {
   				"icon": "fa fa-folder text-warning fa-lg"
   			},
   			"file": {
   				"icon": "fa fa-file text-inverse fa-lg"
   			}
   		},
   		"plugins": ["types"]
   	});

   	$('#jstree-default').on('select_node.jstree', function(e,data) { 
   		var link = $('#' + data.selected).find('a');
   		if (link.attr("href") != "#" && link.attr("href") != "javascript:;" && link.attr("href") != "") {
   			if (link.attr("target") == "_blank") {
   				link.attr("href").target = "_blank";
   			}
   			document.location.href = link.attr("href");
   			return false;
   		}
   	});

   	$('#jstree-checkable').jstree({
   		'plugins': ["wholerow", "checkbox", "types"],
   		'core': {
   			"themes": {
   				"responsive": false
   			},    
   			'data': [{
   				"text": "Same but with checkboxes",
   				"children": [{
   					"text": "initially selected",
   					"state": { "selected": true }
   				}, {
   					"text": "Folder 1"
   				}, {
   					"text": "Folder 2"
   				}, {
   					"text": "Folder 3"
   				}, {
   					"text": "initially open",
   					"icon": "fa fa-folder fa-lg",
   					"state": {
   						"opened": true
   					},
   					"children": [{
   						"text": "Another node"
   					}, {
   						"text": "disabled node",
   						"state": {
   							"disabled": true
   						}
   					}]
   				}, {
   					"text": "custom icon",
   					"icon": "fa fa-cloud-download fa-lg text-inverse"
   				}, {
   					"text": "disabled node",
   					"state": {
   						"disabled": true
   					}
   				}
   				]},
   				"Root node 2"
   				]},
   				"types": {
   					"default": {
   						"icon": "fa fa-folder text-primary fa-lg"
   					},
   					"file": {
   						"icon": "fa fa-file text-success fa-lg"
   					}
   				}
   			});

   	$("#jstree-drag-and-drop").jstree({
   		"core": {
   			"themes": {
   				"responsive": false
   			}, 
   			"check_callback": true,
   			'data': [{
   				"text": "Parent Node",
   				"children": [{
   					"text": "Initially selected",
   					"state": {
   						"selected": true
   					}
   				}, {
   					"text": "Folder 1"
   				}, {
   					"text": "Folder 2"
   				}, {
   					"text": "Folder 3"
   				}, {
   					"text": "Initially open",
   					"icon": "fa fa-folder text-success fa-lg",
   					"state": {
   						"opened": true
   					},
   					"children": [
   					{"text": "Disabled node", "disabled": true},
   					{"text": "Another node"}
   					]
   				}, {
   					"text": "Another Custom Icon",
   					"icon": "fa fa-cog text-inverse fa-lg"
   				}, {
   					"text": "Disabled Node",
   					"state": {
   						"disabled": true
   					}
   				}, {
   					"text": "Sub Nodes",
   					"icon": "fa fa-folder text-danger fa-lg",
   					"children": [
   					{"text": "Item 1", "icon": "fa fa-file fa-lg"},
   					{"text": "Item 2", "icon": "fa fa-file fa-lg"},
   					{"text": "Item 3", "icon": "fa fa-file fa-lg"},
   					{"text": "Item 4", "icon": "fa fa-file fa-lg"},
   					{"text": "Item 5", "icon": "fa fa-file fa-lg"}
   					]
   				}]
   			},
   			"Another Node"
   			]
   		},
   		"types": {
   			"default": {
   				"icon": "fa fa-folder text-warning fa-lg"
   			},
   			"file": {
   				"icon": "fa fa-file text-warning fa-lg"
   			}
   		},
   		"state": { "key": "demo2" },
   		"plugins": [ "contextmenu", "dnd", "state", "types" ]
   	});

   	$('#jstree-ajax').jstree({
   		"core": {
   			"themes": { "responsive": false },
   			"check_callback": true,
   			'data': {
   				'url': function (node) {
   					return node.id === '#' ? 'assets/plugins/jstree/demo/data_root.json': 'assets/plugins/jstree/demo/' + node.original.file;
   				},
   				'data': function (node) {
   					return { 'id': node.id };
   				},
   				"dataType": "json"
   			}
   		},
   		"types": {
   			"default": { "icon": "fa fa-folder text-warning fa-lg" },
   			"file": { "icon": "fa fa-file text-warning fa-lg" }
   		},
   		"plugins": [ "dnd", "state", "types" ]
   	});
   });



/* -------------------------------
   16.0 CONTROLLER - UI Language Bar
   ------------------------------- */
   colorAdminApp.controller('uiLanguageBarIconController', function($scope, $rootScope, $state) {
   	$rootScope.setting.layout.pageLanguageBar = true;
   });



/* -------------------------------
   17.0 CONTROLLER - Form Plugins
   ------------------------------- */
   colorAdminApp.controller('formPluginsController', function($scope, $rootScope, $state) {

    /* Datepicker
    ------------------------- */
    $('#datepicker-default').datepicker({
    	todayHighlight: true
    });
    $('#datepicker-default-to').datepicker({
      todayHighlight: true
    });
    $('#datepicker-default-from').datepicker({
      todayHighlight: true
    });
    $('#datepicker-inline').datepicker({
    	todayHighlight: true
    });
    $('.input-daterange').datepicker({
    	todayHighlight: true
    });
    $('#datepicker-disabled-past').datepicker({
    	todayHighlight: true
    });
    $('#datepicker-autoClose').datepicker({
    	todayHighlight: true,
    	autoclose: true
    });
    
    
    /* Ion Range Slider
    ------------------------- */
    $('#default_rangeSlider').ionRangeSlider({
    	min: 0,
    	max: 5000,
    	type: 'double',
    	prefix: "$",
    	maxPostfix: "+",
    	prettify: false,
    	hasGrid: true
    });
    $('#customRange_rangeSlider').ionRangeSlider({
    	min: 1000,
    	max: 100000,
    	from: 30000,
    	to: 90000,
    	type: 'double',
    	step: 500,
    	postfix: " €",
    	hasGrid: true
    });
    $('#customValue_rangeSlider').ionRangeSlider({
    	values: [
    	'January', 'February', 'March',
    	'April', 'May', 'June',
    	'July', 'August', 'September',
    	'October', 'November', 'December'
    	],
    	type: 'single',
    	hasGrid: true
    });
    
    
    /* Masked Input
    ------------------------- */
    $("#masked-input-date").mask("99/99/9999");
    $("#masked-input-phone").mask("(999) 999-9999");
    $("#masked-input-tid").mask("99-9999999");
    $("#masked-input-ssn").mask("999-99-9999");
    $("#masked-input-pno").mask("aaa-9999-a");
    $("#masked-input-pkey").mask("a*-999-a999");
    
    
    /* Colorpicker
    ------------------------- */
    $('#colorpicker').colorpicker({format: 'hex'});
    $('#colorpicker-prepend').colorpicker({format: 'hex'});
    $('#colorpicker-rgba').colorpicker();
    
    
    /* Timepicker
    ------------------------- */
    $('#timepicker').timepicker();
    
    
    /* Password Indicator
    ------------------------- */
    $('#password-indicator-default').passwordStrength();
    $('#password-indicator-visible').passwordStrength({targetDiv: '#passwordStrengthDiv2'});
    
    
    /* jQuery Autocomplete
    ------------------------- */
    var availableTags = [
    'ActionScript',
    'AppleScript',
    'Asp',
    'BASIC',
    'C',
    'C++',
    'Clojure',
    'COBOL',
    'ColdFusion',
    'Erlang',
    'Fortran',
    'Groovy',
    'Haskell',
    'Java',
    'JavaScript',
    'Lisp',
    'Perl',
    'PHP',
    'Python',
    'Ruby',
    'Scala',
    'Scheme'
    ];
    $('#jquery-autocomplete').autocomplete({
    	source: availableTags
    });
    
    
    /* Combobox
    ------------------------- */
    $('.combobox').combobox();
    
    
    /* Bootstrap TagsInput
    ------------------------- */
    $('.bootstrap-tagsinput input').focus(function() {
    	$(this).closest('.bootstrap-tagsinput').addClass('bootstrap-tagsinput-focus');
    });
    $('.bootstrap-tagsinput input').focusout(function() {
    	$(this).closest('.bootstrap-tagsinput').removeClass('bootstrap-tagsinput-focus');
    });
    
    
    /* Selectpicker
    ------------------------- */
    $('.selectpicker').selectpicker('render');
    
    
    /* jQuery Tagit
    ------------------------- */
    $('#jquery-tagIt-default').tagit({
    	availableTags: ["c++", "java", "php", "javascript", "ruby", "python", "c"]
    });
    $('#jquery-tagIt-inverse').tagit({
    	availableTags: ["c++", "java", "php", "javascript", "ruby", "python", "c"]
    });
    $('#jquery-tagIt-white').tagit({
    	availableTags: ["c++", "java", "php", "javascript", "ruby", "python", "c"]
    });
    $('#jquery-tagIt-primary').tagit({
    	availableTags: ["c++", "java", "php", "javascript", "ruby", "python", "c"]
    });
    $('#jquery-tagIt-info').tagit({
    	availableTags: ["c++", "java", "php", "javascript", "ruby", "python", "c"]
    });
    $('#jquery-tagIt-success').tagit({
    	availableTags: ["c++", "java", "php", "javascript", "ruby", "python", "c"]
    });
    $('#jquery-tagIt-warning').tagit({
    	availableTags: ["c++", "java", "php", "javascript", "ruby", "python", "c"]
    });
    $('#jquery-tagIt-danger').tagit({
    	availableTags: ["c++", "java", "php", "javascript", "ruby", "python", "c"]
    });
    
    
    /* Date Range Picker
    ------------------------- */
    $('#default-daterange').daterangepicker({
    	opens: 'right',
    	format: 'MM/DD/YYYY',
    	separator: ' to ',
    	startDate: moment().subtract('days', 29),
    	endDate: moment(),
    	minDate: '01/01/2012',
    	maxDate: '12/31/2018',
    },
    function (start, end) {
    	$('#default-daterange input').val(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    });
    $('#advance-daterange span').html(moment().subtract('days', 29).format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
    $('#advance-daterange').daterangepicker({
    	format: 'MM/DD/YYYY',
    	startDate: moment().subtract(29, 'days'),
    	endDate: moment(),
    	minDate: '01/01/2012',
    	maxDate: '12/31/2015',
    	dateLimit: { days: 60 },
    	showDropdowns: true,
    	showWeekNumbers: true,
    	timePicker: false,
    	timePickerIncrement: 1,
    	timePicker12Hour: true,
    	ranges: {
    		'Today': [moment(), moment()],
    		'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
    		'Last 7 Days': [moment().subtract(6, 'days'), moment()],
    		'Last 30 Days': [moment().subtract(29, 'days'), moment()],
    		'This Month': [moment().startOf('month'), moment().endOf('month')],
    		'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    	},
    	opens: 'right',
    	drops: 'down',
    	buttonClasses: ['btn', 'btn-sm'],
    	applyClass: 'btn-primary',
    	cancelClass: 'btn-default',
    	separator: ' to ',
    	locale: {
    		applyLabel: 'Submit',
    		cancelLabel: 'Cancel',
    		fromLabel: 'From',
    		toLabel: 'To',
    		customRangeLabel: 'Custom',
    		daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
    		monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
    		firstDay: 1
    	}
    }, function(start, end, label) {
    	$('#advance-daterange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    });
    
    
    /* Select2
    ------------------------- */
    $(".default-select2").select2();
    $(".multiple-select2").select2({ placeholder: "Select a state" });
    
    
    /* DateTimepicker
    ------------------------- */
    $('#datetimepicker1').datetimepicker();
    $('#datetimepicker2').datetimepicker({
    	format: 'LT'
    });
    $('#datetimepicker3').datetimepicker();
    $('#datetimepicker4').datetimepicker();
    $("#datetimepicker3").on("dp.change", function (e) {
    	$('#datetimepicker4').data("DateTimePicker").minDate(e.date);
    });
    $("#datetimepicker4").on("dp.change", function (e) {
    	$('#datetimepicker3').data("DateTimePicker").maxDate(e.date);
    });
  });



/* -------------------------------
   18.0 CONTROLLER - Form Slider + Switcher
   ------------------------------- */
   colorAdminApp.controller('formSliderSwitcherController', function($scope, $rootScope, $state) {
   	var green = '#00acac',
   	red = '#ff5b57',
   	blue = '#348fe2',
   	purple = '#727cb6',
   	orange = '#f59c1a',
   	black = '#2d353c';

   	if ($('[data-render=switchery]').length !== 0) {
   		$('[data-render=switchery]').each(function() {
   			var themeColor = green;
   			if ($(this).attr('data-theme')) {
   				switch ($(this).attr('data-theme')) {
   					case 'red':
   					themeColor = red;
   					break;
   					case 'blue':
   					themeColor = blue;
   					break;
   					case 'purple':
   					themeColor = purple;
   					break;
   					case 'orange':
   					themeColor = orange;
   					break;
   					case 'black':
   					themeColor = black;
   					break;
   				}
   			}
   			var option = {};
   			option.color = themeColor;
   			option.secondaryColor = ($(this).attr('data-secondary-color')) ? $(this).attr('data-secondary-color') : '#dfdfdf';
   			option.className = ($(this).attr('data-classname')) ? $(this).attr('data-classname') : 'switchery';
   			option.disabled = ($(this).attr('data-disabled')) ? true : false;
   			option.disabledOpacity = ($(this).attr('data-disabled-opacity')) ? $(this).attr('data-disabled-opacity') : 0.5;
   			option.speed = ($(this).attr('data-speed')) ? $(this).attr('data-speed') : '0.5s';
   			var switchery = new Switchery(this, option);
   		});
   	}

   	$('[data-click="check-switchery-state"]').live('click', function() {
   		alert($('[data-id="switchery-state"]').prop('checked'));
   	});
   	$('[data-change="check-switchery-state-text"]').live('change', function() {
   		$('[data-id="switchery-state-text"]').text($(this).prop('checked'));
   	});

   	if ($('[data-render="powerange-slider"]').length !== 0) {
   		$('[data-render="powerange-slider"]').each(function() {
   			var option = {};
   			option.decimal = ($(this).attr('data-decimal')) ? $(this).attr('data-decimal') : false;
   			option.disable = ($(this).attr('data-disable')) ? $(this).attr('data-disable') : false;
   			option.disableOpacity = ($(this).attr('data-disable-opacity')) ? $(this).attr('data-disable-opacity') : 0.5;
   			option.hideRange = ($(this).attr('data-hide-range')) ? $(this).attr('data-hide-range') : false;
   			option.klass = ($(this).attr('data-class')) ? $(this).attr('data-class') : '';
   			option.min = ($(this).attr('data-min')) ? $(this).attr('data-min') : 0;
   			option.max = ($(this).attr('data-max')) ? $(this).attr('data-max') : 100;
   			option.start = ($(this).attr('data-start')) ? $(this).attr('data-start') : null;
   			option.step = ($(this).attr('data-step')) ? $(this).attr('data-step') : null;
   			option.vertical = ($(this).attr('data-vertical')) ? $(this).attr('data-vertical') : false;
   			if ($(this).attr('data-height')) {
   				$(this).closest('.slider-wrapper').height($(this).attr('data-height'));
   			}
   			var switchery = new Switchery(this, option);
   			var powerange = new Powerange(this, option);
   		});
   	}
   });



/* -------------------------------
   19.0 CONTROLLER - Form Validation
   ------------------------------- */
   colorAdminApp.controller('formValidationController', function($scope, $rootScope, $state) {
   	$scope.submitForm = function(form) {
   		if (!form.$valid) {
   			$('form[name="'+ form.$name +'"] *').tooltip('destroy');
   			angular.forEach(form.$error, function(field) {
   				angular.forEach(field, function(errorField) {
   					errorField.$setTouched();
   					var targetContainer = 'form[name="'+ form.$name +'"] [name="'+ errorField.$name +'"]';
   					var targetMessage = (errorField.$error.required) ? 'This is required' : '';
   					targetMessage = (errorField.$error.email) ? 'Invalid email' : targetMessage;
   					targetMessage = (errorField.$error.url) ? 'Invalid website url' : targetMessage;
   					targetMessage = (errorField.$error.number) ? 'Only number is allowed' : targetMessage;
   					targetMessage = (errorField.$name == 'alphabets') ? 'Only alphabets is allowed' : targetMessage;
   					targetMessage = (errorField.$error.minlength) ? 'You must provide at least 20 characters for this field' : targetMessage;
   					targetMessage = (errorField.$error.maxlength) ? 'You must not exceed the maximum of 200 characters for this field' : targetMessage;

   					$(targetContainer).first().tooltip({
   						placement: 'top',
   						trigger: 'normal',
   						title: targetMessage,
   						container: 'body',
   						animation: false
   					});
   					$(targetContainer).first().tooltip('show');
   				});
   			});
   		}
   	};
   });



/* -------------------------------
   20.0 CONTROLLER - Table Manage Default
   ------------------------------- */
   colorAdminApp.controller('tableManageDefaultController', function($scope, $rootScope, $state) {
   	if ($('#data-table').length !== 0) {
   		$('#data-table').DataTable({
   			responsive: true
   		});
   	}
   });



/* -------------------------------
   21.0 CONTROLLER - Table Manage Autofill
   ------------------------------- */
   colorAdminApp.controller('tableManageAutofillController', function($scope, $rootScope, $state) {
   	if ($('#data-table').length !== 0) {
   		$('#data-table').DataTable({
   			autoFill: true,
   			responsive: true
   		});
   	}
   });



/* -------------------------------
   22.0 CONTROLLER - Table Manage Buttons
   ------------------------------- */
   colorAdminApp.controller('tableManageButtonsController', function($scope, $rootScope, $state) {
   	if ($('#data-table').length !== 0) {
   		$('#data-table').DataTable({
   			dom: 'Bfrtip',
   			buttons: [
   			{ extend: 'copy', className: 'btn-sm' },
   			{ extend: 'csv', className: 'btn-sm' },
   			{ extend: 'excel', className: 'btn-sm' },
   			{ extend: 'pdf', className: 'btn-sm' },
   			{ extend: 'print', className: 'btn-sm' }
   			],
   			responsive: true
   		});
   	}
   });



/* -------------------------------
   23.0 CONTROLLER - Table Manage ColReorder
   ------------------------------- */
   colorAdminApp.controller('tableManageColReorderController', function($scope, $rootScope, $state) {
   	if ($('#data-table').length !== 0) {
   		$('#data-table').DataTable({
   			colReorder: true,
   			responsive: true
   		});
   	}
   });



/* -------------------------------
   24.0 CONTROLLER - Table Manage Fixed Columns
   ------------------------------- */
   colorAdminApp.controller('tableManageFixedColumnsController', function($scope, $rootScope, $state) {
   	if ($('#data-table').length !== 0) {
   		$('#data-table').DataTable({
   			scrollY:        300,
   			scrollX:        true,
   			scrollCollapse: true,
   			paging:         false,
   			fixedColumns:   true,
   			responsive: true
   		});
   	}
   });



/* -------------------------------
   25.0 CONTROLLER - Table Manage Fixed Header
   ------------------------------- */
   colorAdminApp.controller('tableManageFixedHeaderController', function($scope, $rootScope, $state) {
   	if ($('#data-table').length !== 0) {
   		$('#data-table').DataTable({
   			lengthMenu: [20, 40, 60],
   			fixedHeader: {
   				header: true,
   				headerOffset: $('#header').height()
   			},
   			responsive: true
   		});
   	}
   });



/* -------------------------------
   26.0 CONTROLLER - Table Manage KeyTable
   ------------------------------- */
   colorAdminApp.controller('tableManageKeyTableController', function($scope, $rootScope, $state) {
   	if ($('#data-table').length !== 0) {
   		$('#data-table').DataTable({
   			scrollY: 300,
   			paging: false,
   			autoWidth: true,
   			keys: true,
   			responsive: true
   		});
   	}
   });



/* -------------------------------
   27.0 CONTROLLER - Table Manage Responsive
   ------------------------------- */
   colorAdminApp.controller('tableManageResponsiveController', function($scope, $rootScope, $state) {

   });



/* -------------------------------
   28.0 CONTROLLER - Table Manage RowReorder
   ------------------------------- */
   colorAdminApp.controller('tableManageRowReorderController', function($scope, $rootScope, $state) {
   	if ($('#data-table').length !== 0) {
   		$('#data-table').DataTable({
   			responsive: true,
   			rowReorder: true
   		});
   	}
   });



/* -------------------------------
   29.0 CONTROLLER - Table Manage Scroller
   ------------------------------- */
   colorAdminApp.controller('tableManageScrollerController', function($scope, $rootScope, $state) {
   	if ($('#data-table').length !== 0) {
   		$('#data-table').DataTable({
   			ajax:           "assets/plugins/DataTables/json/scroller-demo.json",
   			deferRender:    true,
   			scrollY:        300,
   			scrollCollapse: true,
   			scroller:       true,
   			responsive: true
   		});
   	}
   });



/* -------------------------------
   30.0 CONTROLLER - Table Manage Select
   ------------------------------- */
   colorAdminApp.controller('tableManageSelectController', function($scope, $rootScope, $state) {
   	if ($('#data-table').length !== 0) {
   		$('#data-table').DataTable({
   			select: true,
   			responsive: true
   		});
   	}
   });



/* -------------------------------
   31.0 CONTROLLER - Table Manage Extension Combination
   ------------------------------- */
   colorAdminApp.controller('tableManageCombineController', function($scope, $rootScope, $state) {
   	if ($('#data-table').length !== 0) {
   		$('#data-table').DataTable({
   			dom: 'lBfrtip',
   			buttons: [
   			{ extend: 'copy', className: 'btn-sm' },
   			{ extend: 'csv', className: 'btn-sm' },
   			{ extend: 'excel', className: 'btn-sm' },
   			{ extend: 'pdf', className: 'btn-sm' },
   			{ extend: 'print', className: 'btn-sm' }
   			],
   			responsive: true,
   			autoFill: true,
   			colReorder: true,
   			keys: true,
   			rowReorder: true,
   			select: true
   		});
   	}
   });



/* -------------------------------
   32.0 CONTROLLER - Flot Chart
   ------------------------------- */
   colorAdminApp.controller('chartFlotController', function($scope, $rootScope, $state) {

    /* Basic Chart
    ------------------------- */
    var d1 = [], d2 = [], d3 = [];
    for (var x = 0; x < Math.PI * 2; x += 0.25) {
    	d1.push([x, Math.sin(x)]);
    	d2.push([x, Math.cos(x)]);
    	var z = x - 0.15;
    	d3.push([z, Math.tan(z)]);
    }

    var basicChartData = [
    { label: "data 1",  data: d1, color: purple, shadowSize: 0 },
    { label: "data 2",  data: d2, color: green, shadowSize: 0 },
    { label: "data 3",  data: d3, color: dark, shadowSize: 0 }
    ];
    var basicChartOptions = {
    	series: {
    		lines: { show: true },
    		points: { show: false }
    	},
    	xaxis: {
    		tickColor: '#ddd'
    	},
    	yaxis: {
    		min: -2,
    		max: 2,
    		tickColor: '#ddd'
    	},
    	grid: {
    		borderColor: '#ddd',
    		borderWidth: 1
    	}
    }
    this.basicChartData = basicChartData;
    this.basicChartOptions = basicChartOptions;


	/* Stacked Chart
	------------------------- */
	var d1 = [], d2 = [], d3 = [], d4 = [], d5 = [], d6 = [];
	for (var a = 0; a <= 5; a += 1) {
		d1.push([a, parseInt(Math.random() * 5)]);
		d2.push([a, parseInt(Math.random() * 5 + 5)]);
		d3.push([a, parseInt(Math.random() * 5 + 5)]);
		d4.push([a, parseInt(Math.random() * 5 + 5)]);
		d5.push([a, parseInt(Math.random() * 5 + 5)]);
		d6.push([a, parseInt(Math.random() * 5 + 5)]);
	}
	var ticksLabel = [[0, "Monday"], [1, "Tuesday"], [2, "Wednesday"], [3, "Thursday"], [4, "Friday"], [5, "Saturday"]];
	var stackedChartOptions = { 
		xaxis: {  tickColor: 'transparent',  ticks: ticksLabel},
		yaxis: {  tickColor: '#ddd', ticksLength: 10},
		grid: {  hoverable: true,  tickColor: "#ccc", borderWidth: 0, borderColor: 'rgba(0,0,0,0.2)' },
		series: {
			stack: true,
			lines: { show: false, fill: false, steps: false },
			bars: { show: true, barWidth: 0.5, align: 'center', fillColor: null },
			highlightColor: 'rgba(0,0,0,0.8)'
		},
		legend: { show: true, labelBoxBorderColor: '#ccc', position: 'ne', noColumns: 1 }
	};
	var stackedChartData = [
	{ data:d1, color: purpleDark, label: 'China', bars: { fillColor: purpleDark } }, 
	{ data:d2, color: purple, label: 'Russia', bars: { fillColor: purple } }, 
	{ data:d3, color: purpleLight, label: 'Canada', bars: { fillColor: purpleLight } }, 
	{ data:d4, color: blueDark, label: 'Japan', bars: { fillColor: blueDark } }, 
	{ data:d5, color: blue, label: 'USA', bars: { fillColor: blue } }, 
	{ data:d6, color: blueLight, label: 'Others', bars: { fillColor: blueLight } }
	];

	var previousXValue = null;
	var previousYValue = null;
	$("#stacked-chart").bind("plothover", function (event, pos, item) {
		if (item) {
			var y = item.datapoint[1] - item.datapoint[2];
			if (previousXValue != item.series.label || y != previousYValue) {
				previousXValue = item.series.label;
				previousYValue = y;
				$("#tooltip").remove();
				$('<div id="tooltip" class="flot-tooltip">' + item.series.label + '</div>').css({ top: item.pageY, left: item.pageX + 35 }).appendTo("body").fadeIn(200);
			}
		} else {
			$("#tooltip").remove();
			previousXValue = null;
			previousYValue = null;       
		}
	});

	this.stackedChartOptions = stackedChartOptions;
	this.stackedChartData = stackedChartData;


    /* Tracking Chart
    ------------------------- */
    var sin = [], cos = [];
    for (var i = 0; i < 14; i += 0.1) {
    	sin.push([i, Math.sin(i)]);
    	cos.push([i, Math.cos(i)]);
    }

    var trackingChartData = [ 
    { data: sin, label: "Series1", color: dark, shadowSize: 0},
    { data: cos, label: "Series2", color: red, shadowSize: 0} 
    ];
    var trackingChartOptions = {
    	series: { lines: { show: true } },
    	crosshair: { mode: "x", color: grey },
    	grid: { hoverable: true, autoHighlight: false, borderColor: '#ccc', borderWidth: 0 },
    	xaxis: {  tickLength: 0 },
    	yaxis: {  tickColor: '#ddd' },
    	legend: {
    		labelBoxBorderColor: '#ddd',
    		backgroundOpacity: 0.4,
    		color:'#fff',
    		show: true
    	}
    };
    this.trackingChartData = trackingChartData;
    this.trackingChartOptions = trackingChartOptions;
    
    
    /* Bar Chart
    ------------------------- */
    var barChartData = [{
    	data: [ ["January", 10], ["February", 8], ["March", 4], ["April", 13], ["May", 17], ["June", 9] ],
    	color: purple
    }];
    var barChartOptions = {
    	series: {
    		bars: {
    			show: true, barWidth: 0.4, align: 'center', fill: true, fillColor: purple, zero: true
    		}
    	},
    	xaxis: { mode: "categories", tickColor: '#ddd', tickLength: 0 },
    	grid: { borderWidth: 0 }
    };
    this.barChartData = barChartData;
    this.barChartOptions = barChartOptions;
    
    
    /* Pie Chart
    ------------------------- */
    var pieChartData = [];
    var series = 3;
    var colorArray = [purple, dark, grey];
    for (var i=0; i<series; i++) {
    	pieChartData[i] = { label: "Series"+(i+1), data: Math.floor(Math.random()*100)+1, color: colorArray[i] };
    }
    var pieChartOptions = {
    	series: {
    		pie: { 
    			show: true
    		}
    	},
    	grid: { hoverable: true, clickable: true },
    	legend: { labelBoxBorderColor: '#ddd', backgroundColor: 'none' }
    };
    this.pieChartData = pieChartData;
    this.pieChartOptions = pieChartOptions;
    
    
    /* Donut Chart
    ------------------------- */
    var donutChartData = [];
    var donutChartOptions = {
    	series: {
    		pie: { 
    			innerRadius: 0.5,
    			show: true,
    			combine: { color: '#999', threshold: 0.1 }
    		}
    	},
    	grid:{ borderWidth:0, hoverable: true, clickable: true },
    	legend: { show: false }
    };
    var colorArray = [dark, green, purple];
    var nameArray = ['Unique Visitor', 'Bounce Rate', 'Total Page Views', 'Avg Time On Site'];
    var dataArray = [20,14,12,31];
    for( var i = 0; i<3; i++) {
    	donutChartData[i] = { label: nameArray[i], data: dataArray[i], color: colorArray[i] };
    }
    
    this.donutChartData = donutChartData;
    this.donutChartOptions = donutChartOptions;
    
    
    /* Interactive Chart
    ------------------------- */
    var interactiveChartOptions = {
    	xaxis: {  tickColor: '#ddd',tickSize: 2 },
    	yaxis: {  tickColor: '#ddd', tickSize: 20 },
    	grid: {  hoverable: true,  clickable: true, tickColor: "#ccc", borderWidth: 1, borderColor: '#ddd' },
    	legend: { labelBoxBorderColor: '#ddd', margin: 0, noColumns: 1, show: true }
    };
    var d1 = [[0, 42], [1, 53], [2,66], [3, 60], [4, 68], [5, 66], [6,71],[7, 75], [8, 69], [9,70], [10, 68], [11, 72], [12, 78], [13, 86]];
    var d2 = [[0, 12], [1, 26], [2,13], [3, 18], [4, 35], [5, 23], [6, 18],[7, 35], [8, 24], [9,14], [10, 14], [11, 29], [12, 30], [13, 43]];
    var interactiveChartData = [{
    	data: d1, 
    	label: "Page Views", 
    	color: purple,
    	lines: { show: true, fill:false, lineWidth: 2 },
    	points: { show: false, radius: 5, fillColor: '#fff' },
    	shadowSize: 0
    }, {
    	data: d2,
    	label: 'Visitors',
    	color: green,
    	lines: { show: true, fill:false, lineWidth: 2, fillColor: '' },
    	points: { show: false, radius: 3, fillColor: '#fff' },
    	shadowSize: 0
    }];
    
    this.interactiveChartOptions = interactiveChartOptions;
    this.interactiveChartData = interactiveChartData;

    var previousPoint = null;
    
    $("#interactive-chart").bind("plothover", function (event, pos, item) {
    	$("#x").text(pos.x.toFixed(2));
    	$("#y").text(pos.y.toFixed(2));
    	if (item) {
    		if (previousPoint !== item.dataIndex) {
    			previousPoint = item.dataIndex;
    			$("#tooltip").remove();
    			var y = item.datapoint[1].toFixed(2);
    			var content = item.series.label + " " + y;
    			$('<div id="tooltip" class="flot-tooltip">' + content + '</div>').css({ top: item.pageY - 45, left: item.pageX - 55 }).appendTo("body").fadeIn(200);
    		}
    	} else {
    		$("#tooltip").remove();
    		previousPoint = null;            
    	}
    	event.preventDefault();
    });


    /* Live Updated Chart 
    ------------------------- */
    function update() {
    	plot.setData([ getRandomData() ]);
    	plot.draw();
    	setTimeout(update, updateInterval);
    }
    function getRandomData() {
    	if (data.length > 0) {
    		data = data.slice(1);
    	}
    	while (data.length < totalPoints) {
    		var prev = data.length > 0 ? data[data.length - 1] : 50;
    		var y = prev + Math.random() * 10 - 5;
    		y = (y < 0) ? 0 : y;
    		y = (y > 100) ? 100 : y;
    		data.push(y);
    	}
    	var res = [];
    	for (var i = 0; i < data.length; ++i) {
    		res.push([i, data[i]]);
    	}
    	return res;
    }
    
    var data = [], totalPoints = 150;
    var updateInterval = 1000;
    
    $("#updateInterval").val(updateInterval).change(function () {
    	var v = $(this).val();
    	if (v && !isNaN(+v)) {
    		updateInterval = +v;
    		updateInterval = (updateInterval < 1) ? 1 : updateInterval;
    		updateInterval = (updateInterval > 2000) ? 2000 : updateInterval;
    		$(this).val("" + updateInterval);
    	}
    });
    var options = {
        series: { shadowSize: 0, color: purple, lines: { show: true, fill:true } }, // drawing is faster without shadows
        yaxis: { min: 0, max: 100, tickColor: '#ddd' },
        xaxis: { show: true, tickColor: '#ddd' },
        grid: { borderWidth: 1, borderColor: '#ddd' }
      };
      var plot = $.plot($("#live-updated-chart"), [ getRandomData() ], options);
      update();
    });



/* -------------------------------
   33.0 CONTROLLER - Morris Chart
   ------------------------------- */
   colorAdminApp.controller('chartMorrisController', function($scope, $rootScope, $state) {

    /* Morris Line Chart
    ------------------------- */
    var tax_data = [
    {"period": "2011 Q3", "licensed": 3407, "sorned": 660},
    {"period": "2011 Q2", "licensed": 3351, "sorned": 629},
    {"period": "2011 Q1", "licensed": 3269, "sorned": 618},
    {"period": "2010 Q4", "licensed": 3246, "sorned": 661},
    {"period": "2009 Q4", "licensed": 3171, "sorned": 676},
    {"period": "2008 Q4", "licensed": 3155, "sorned": 681},
    {"period": "2007 Q4", "licensed": 3226, "sorned": 620},
    {"period": "2006 Q4", "licensed": 3245, "sorned": null},
    {"period": "2005 Q4", "licensed": 3289, "sorned": null}
    ];
    Morris.Line({
    	element: 'morris-line-chart',
    	data: tax_data,
    	xkey: 'period',
    	ykeys: ['licensed', 'sorned'],
    	labels: ['Licensed', 'Off the road'],
    	resize: true,
    	lineColors: [dark, blue]
    });
    
    
    /* Morris Bar Chart
    ------------------------- */
    Morris.Bar({
    	element: 'morris-bar-chart',
    	data: [
    	{device: 'iPhone', geekbench: 136},
    	{device: 'iPhone 3G', geekbench: 137},
    	{device: 'iPhone 3GS', geekbench: 275},
    	{device: 'iPhone 4', geekbench: 380},
    	{device: 'iPhone 4S', geekbench: 655},
    	{device: 'iPhone 5', geekbench: 1571}
    	],
    	xkey: 'device',
    	ykeys: ['geekbench'],
    	labels: ['Geekbench'],
    	barRatio: 0.4,
    	xLabelAngle: 35,
    	hideHover: 'auto',
    	resize: true,
    	barColors: [dark]
    });
    
    
    /* Morris Area Chart
    ------------------------- */
    Morris.Area({
    	element: 'morris-area-chart',
    	data: [
    	{period: '2010 Q1', iphone: 2666, ipad: null, itouch: 2647},
    	{period: '2010 Q2', iphone: 2778, ipad: 2294, itouch: 2441},
    	{period: '2010 Q3', iphone: 4912, ipad: 1969, itouch: 2501},
    	{period: '2010 Q4', iphone: 3767, ipad: 3597, itouch: 5689},
    	{period: '2011 Q1', iphone: 6810, ipad: 1914, itouch: 2293},
    	{period: '2011 Q2', iphone: 5670, ipad: 4293, itouch: 1881},
    	{period: '2011 Q3', iphone: 4820, ipad: 3795, itouch: 1588},
    	{period: '2011 Q4', iphone: 15073, ipad: 5967, itouch: 5175},
    	{period: '2012 Q1', iphone: 10687, ipad: 4460, itouch: 2028},
    	{period: '2012 Q2', iphone: 8432, ipad: 5713, itouch: 1791}
    	],
    	xkey: 'period',
    	ykeys: ['iphone', 'ipad', 'itouch'],
    	labels: ['iPhone', 'iPad', 'iPod Touch'],
    	pointSize: 2,
    	hideHover: 'auto',
    	resize: true,
    	lineColors: [red, orange, dark]
    });
    
    
    /* Morris Area Chart
    ------------------------- */
    Morris.Donut({
    	element: 'morris-donut-chart',
    	data: [
    	{label: 'Jam', value: 25 },
    	{label: 'Frosted', value: 40 },
    	{label: 'Custard', value: 25 },
    	{label: 'Sugar', value: 10 }
    	],
    	formatter: function (y) { return y + "%" },
    	resize: true,
    	colors: [dark, orange, red, grey]
    });
  });



/* -------------------------------
   34.0 CONTROLLER - Chart JS
   ------------------------------- */
   colorAdminApp.controller('chartJsController', function($scope, $rootScope, $state) {

    // white
    var white = 'rgba(255,255,255,1.0)';
    var fillBlack = 'rgba(45, 53, 60, 0.6)';
    var fillBlackLight = 'rgba(45, 53, 60, 0.2)';
    var strokeBlack = 'rgba(45, 53, 60, 0.8)';
    var highlightFillBlack = 'rgba(45, 53, 60, 0.8)';
    var highlightStrokeBlack = 'rgba(45, 53, 60, 1)';

    // blue
    var fillBlue = 'rgba(52, 143, 226, 0.6)';
    var fillBlueLight = 'rgba(52, 143, 226, 0.2)';
    var strokeBlue = 'rgba(52, 143, 226, 0.8)';
    var highlightFillBlue = 'rgba(52, 143, 226, 0.8)';
    var highlightStrokeBlue = 'rgba(52, 143, 226, 1)';

    // grey
    var fillGrey = 'rgba(182, 194, 201, 0.6)';
    var fillGreyLight = 'rgba(182, 194, 201, 0.2)';
    var strokeGrey = 'rgba(182, 194, 201, 0.8)';
    var highlightFillGrey = 'rgba(182, 194, 201, 0.8)';
    var highlightStrokeGrey = 'rgba(182, 194, 201, 1)';

    // green
    var fillGreen = 'rgba(0, 172, 172, 0.6)';
    var fillGreenLight = 'rgba(0, 172, 172, 0.2)';
    var strokeGreen = 'rgba(0, 172, 172, 0.8)';
    var highlightFillGreen = 'rgba(0, 172, 172, 0.8)';
    var highlightStrokeGreen = 'rgba(0, 172, 172, 1)';

    // purple
    var fillPurple = 'rgba(114, 124, 182, 0.6)';
    var fillPurpleLight = 'rgba(114, 124, 182, 0.2)';
    var strokePurple = 'rgba(114, 124, 182, 0.8)';
    var highlightFillPurple = 'rgba(114, 124, 182, 0.8)';
    var highlightStrokePurple = 'rgba(114, 124, 182, 1)';


    /* ChartJS Bar Chart
    ------------------------- */
    var randomScalingFactor = function() { 
    	return Math.round(Math.random()*100)
    };

    var barChartData = {
    	labels : ['January','February','March','April','May','June','July'],
    	datasets : [{
    		fillColor : fillBlackLight,
    		strokeColor : strokeBlack,
    		highlightFill: highlightFillBlack,
    		highlightStroke: highlightStrokeBlack,
    		data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
    	}, {
    		fillColor : fillBlueLight,
    		strokeColor : strokeBlue,
    		highlightFill: highlightFillBlue,
    		highlightStroke: highlightStrokeBlue,
    		data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
    	}]
    };
    this.barChartData = barChartData;


    /* ChartJS Doughnut Chart
    ------------------------- */
    var doughnutChartData = [
    { value: 300, color: fillGrey, highlight: highlightFillGrey, label: 'Grey' },
    { value: 50, color: fillGreen, highlight: highlightFillGreen, label: 'Green' },
    { value: 100, color: fillBlue, highlight: highlightFillBlue, label: 'Blue' },
    { value: 40, color: fillPurple, highlight: highlightFillPurple, label: 'Purple' },
    { value: 120, color: fillBlack, highlight: highlightFillBlack, label: 'Black' }
    ];
    this.doughnutChartData = doughnutChartData;


    /* ChartJS Line Chart
    ------------------------- */
    var lineChartData = {
    	labels : ['January','February','March','April','May','June','July'],
    	datasets : [{
    		label: 'My First dataset',
    		fillColor : fillBlackLight,
    		strokeColor : strokeBlack,
    		pointColor : strokeBlack,
    		pointStrokeColor : white,
    		pointHighlightFill : white,
    		pointHighlightStroke : strokeBlack,
    		data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
    	}, {
    		label: 'My Second dataset',
    		fillColor : 'rgba(52,143,226,0.2)',
    		strokeColor : 'rgba(52,143,226,1)',
    		pointColor : 'rgba(52,143,226,1)',
    		pointStrokeColor : '#fff',
    		pointHighlightFill : '#fff',
    		pointHighlightStroke : 'rgba(52,143,226,1)',
    		data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
    	}]
    };
    this.lineChartData = lineChartData;


    /* ChartJS Pie Chart
    ------------------------- */
    var pieChartData = [
    { value: 300, color: strokePurple, highlight: highlightStrokePurple, label: 'Purple' },
    { value: 50, color: strokeBlue, highlight: highlightStrokeBlue, label: 'Blue' },
    { value: 100, color: strokeGreen, highlight: highlightStrokeGreen, label: 'Green' },
    { value: 40, color: strokeGrey, highlight: highlightStrokeGrey, label: 'Grey' },
    { value: 120, color: strokeBlack, highlight: highlightStrokeBlack, label: 'Black' }
    ];
    this.pieChartData = pieChartData;


    /* ChartJS Polar Chart
    ------------------------- */
    var polarChartData = [
    { value: 300, color: strokePurple, highlight: highlightStrokePurple, label: 'Purple' },
    { value: 50, color: strokeBlue, highlight: highlightStrokeBlue, label: 'Blue' },
    { value: 100, color: strokeGreen, highlight: highlightStrokeGreen, label: 'Green' },
    { value: 40, color: strokeGrey, highlight: highlightStrokeGrey, label: 'Grey' },
    { value: 120, color: strokeBlack, highlight: highlightStrokeBlack, label: 'Black' }
    ];
    this.polarChartData = polarChartData;


    /* ChartJS Radar Chart
    ------------------------- */
    var radarChartData = {
    	labels: ['Eating', 'Drinking', 'Sleeping', 'Designing', 'Coding', 'Cycling', 'Running'],
    	datasets: [{
    		label: 'My First dataset',
    		fillColor: 'rgba(45,53,60,0.2)',
    		strokeColor: 'rgba(45,53,60,1)',
    		pointColor: 'rgba(45,53,60,1)',
    		pointStrokeColor: '#fff',
    		pointHighlightFill: '#fff',
    		pointHighlightStroke: 'rgba(45,53,60,1)',
    		data: [65,59,90,81,56,55,40]
    	}, {
    		label: 'My Second dataset',
    		fillColor: 'rgba(52,143,226,0.2)',
    		strokeColor: 'rgba(52,143,226,1)',
    		pointColor: 'rgba(52,143,226,1)',
    		pointStrokeColor: '#fff',
    		pointHighlightFill: '#fff',
    		pointHighlightStroke: 'rgba(52,143,226,1)',
    		data: [28,48,40,19,96,27,100]
    	}]
    };
    this.radarChartData = radarChartData;


    /* ChartJS Chart Options
    ------------------------- */
    var chartOptions = {
    	animation: true,
    	animationSteps: 60,
    	animationEasing: 'easeOutQuart',
    	showScale: true,
    	scaleOverride: false,
    	scaleSteps: null,
    	scaleStepWidth: null,
    	scaleStartValue: null,
    	scaleLineColor: 'rgba(0,0,0,.1)',
    	scaleLineWidth: 1,
    	scaleShowLabels: true,
    	scaleLabel: '<%=value%>',
    	scaleIntegersOnly: true,
    	scaleBeginAtZero: false,
    	scaleFontFamily: '"Open Sans", "Helvetica Neue", "Helvetica", "Arial", sans-serif',
    	scaleFontSize: 12,
    	scaleFontStyle: 'normal',
    	scaleFontColor: '#707478',
    	responsive: true,
    	maintainAspectRatio: true,
    	showTooltips: true,
    	customTooltips: false,
    	tooltipEvents: ['mousemove', 'touchstart', 'touchmove'],
    	tooltipFillColor: 'rgba(0,0,0,0.8)',
    	tooltipFontFamily: '"Open Sans", "Helvetica Neue", "Helvetica", "Arial", sans-serif',
    	tooltipFontSize: 12,
    	tooltipFontStyle: 'normal',
    	tooltipFontColor: '#ccc',
    	tooltipTitleFontFamily: '"Open Sans", "Helvetica Neue", "Helvetica", "Arial", sans-serif',
    	tooltipTitleFontSize: 12,
    	tooltipTitleFontStyle: 'bold',
    	tooltipTitleFontColor: '#fff',
    	tooltipYPadding: 10,
    	tooltipXPadding: 10,
    	tooltipCaretSize: 8,
    	tooltipCornerRadius: 3,
    	tooltipXOffset: 10,
    	tooltipTemplate: '<%if (label){%><%=label%>: <%}%><%= value %>',
    	multiTooltipTemplate: '<%= value %>',
    	onAnimationProgress: function(){},
    	onAnimationComplete: function(){}
    }
    this.chartOptions = chartOptions;
  });



/* -------------------------------
   35.0 CONTROLLER - Chart d3
   ------------------------------- */
   colorAdminApp.controller('chartD3Controller', function($scope, $rootScope, $state) {

    /* d3 Line Chart
    ------------------------- */
    nv.addGraph(function() {
    	var sin = [], cos = [];
    	for (var i = 0; i < 100; i++) {
    		sin.push({x: i, y:  Math.sin(i/10) });
    		cos.push({x: i, y: .5 * Math.cos(i/10)});
    	}
    	var lineChartData = [
    	{ values: sin, key: 'Sine Wave', color: green }, 
    	{ values: cos, key: 'Cosine Wave', color: blue }
    	];
    	var lineChart = nv.models.lineChart().options({ transitionDuration: 300, useInteractiveGuideline: true });
    	lineChart.xAxis.axisLabel('Time (s)').tickFormat(d3.format(',.1f'));
    	lineChart.yAxis.axisLabel('Voltage (v)').tickFormat(function(d) {
    		if (d == null) {
    			return 'N/A';
    		}
    		return d3.format(',.2f')(d);
    	});

    	d3.select('#nv-line-chart').append('svg').datum(lineChartData).call(lineChart);
    	nv.utils.windowResize(lineChart.update);
    	return lineChart;
    });


    /* d3 Bar Chart
    ------------------------- */
    nv.addGraph(function() {
    	var barChartData = [{
    		key: 'Cumulative Return',
    		values: [
    		{ 'label' : 'A', 'value' : 29, 'color' : red }, 
    		{ 'label' : 'B', 'value' : 15, 'color' : orange }, 
    		{ 'label' : 'C', 'value' : 32, 'color' : green }, 
    		{ 'label' : 'D', 'value' : 196, 'color' : aqua },  
    		{ 'label' : 'E', 'value' : 44, 'color' : blue },  
    		{ 'label' : 'F', 'value' : 98, 'color' : purple },  
    		{ 'label' : 'G', 'value' : 13, 'color' : grey },  
    		{ 'label' : 'H', 'value' : 5, 'color' : dark }
    		]
    	}];
    	var barChart = nv.models.discreteBarChart()
    	.x(function(d) { return d.label })
    	.y(function(d) { return d.value })
    	.showValues(true)
    	.duration(250);

    	barChart.yAxis.axisLabel("Total Sales");
    	barChart.xAxis.axisLabel('Product');

    	d3.select('#nv-bar-chart').append('svg').datum(barChartData).call(barChart);
    	nv.utils.windowResize(barChart.update);
    	return barChart;
    });


    /* d3 Pie Chart
    ------------------------- */
    nv.addGraph(function() {
    	var pieChartData = [
    	{ 'label': 'One', 'value' : 29, 'color': red }, 
    	{ 'label': 'Two', 'value' : 12, 'color': orange }, 
    	{ 'label': 'Three', 'value' : 32, 'color': green }, 
    	{ 'label': 'Four', 'value' : 196, 'color': aqua }, 
    	{ 'label': 'Five', 'value' : 17, 'color': blue }, 
    	{ 'label': 'Six', 'value' : 98, 'color': purple }, 
    	{ 'label': 'Seven', 'value' : 13, 'color': grey }, 
    	{ 'label': 'Eight', 'value' : 5, 'color': dark }
    	];

    	var pieChart = nv.models.pieChart()
    	.x(function(d) { return d.label })
    	.y(function(d) { return d.value })
    	.showLabels(true)
    	.labelThreshold(.05);

    	d3.select('#nv-pie-chart').append('svg').datum(pieChartData).transition().duration(350).call(pieChart);
    	return pieChart;
    });


    /* d3 Donut Chart
    ------------------------- */
    nv.addGraph(function() {
    	var donutChartData = [
    	{ 'label': 'One', 'value' : 29, 'color': red }, 
    	{ 'label': 'Two', 'value' : 12, 'color': orange }, 
    	{ 'label': 'Three', 'value' : 32, 'color': green }, 
    	{ 'label': 'Four', 'value' : 196, 'color': aqua }, 
    	{ 'label': 'Five', 'value' : 17, 'color': blue }, 
    	{ 'label': 'Six', 'value' : 98, 'color': purple }, 
    	{ 'label': 'Seven', 'value' : 13, 'color': grey }, 
    	{ 'label': 'Eight', 'value' : 5, 'color': dark }
    	];
    	var chart = nv.models.pieChart()
    	.x(function(d) { return d.label })
    	.y(function(d) { return d.value })
    	.showLabels(true)
    	.labelThreshold(.05)
    	.labelType("percent")
    	.donut(true) 
    	.donutRatio(0.35);

    	d3.select('#nv-donut-chart').append('svg')
    	.datum(donutChartData)
    	.transition().duration(350)
    	.call(chart);
    	return chart;
    });


    /* d3 Stacked Area Chart
    ------------------------- */
    nv.addGraph(function() {
    	var stackedAreaChartData = [{
    		'key' : 'Financials',
    		'color' : red,
    		'values' : [ [ 1138683600000 , 13.356778764352] , [ 1141102800000 , 13.611196863271] , [ 1143781200000 , 6.895903006119] , [ 1146369600000 , 6.9939633271352] , [ 1149048000000 , 6.7241510257675] , [ 1151640000000 , 5.5611293669516] , [ 1154318400000 , 5.6086488714041] , [ 1156996800000 , 5.4962849907033] , [ 1159588800000 , 6.9193153169279] , [ 1162270800000 , 7.0016334389777] , [ 1164862800000 , 6.7865422443273] , [ 1167541200000 , 9.0006454225383] , [ 1170219600000 , 9.2233916171431] , [ 1172638800000 , 8.8929316009479] , [ 1175313600000 , 10.345937520404] , [ 1177905600000 , 10.075914677026] , [ 1180584000000 , 10.089006188111] , [ 1183176000000 , 10.598330295008] , [ 1185854400000 , 9.968954653301] , [ 1188532800000 , 9.7740580198146] , [ 1191124800000 , 10.558483060626] , [ 1193803200000 , 9.9314651823603] , [ 1196398800000 , 9.3997715873769] , [ 1199077200000 , 8.4086493387262] , [ 1201755600000 , 8.9698309085926] , [ 1204261200000 , 8.2778357995396] , [ 1206936000000 , 8.8585045600123] , [ 1209528000000 , 8.7013756413322] , [ 1212206400000 , 7.7933605469443] , [ 1214798400000 , 7.0236183483064] , [ 1217476800000 , 6.9873088186829] , [ 1220155200000 , 6.8031713070097] , [ 1222747200000 , 6.6869531315723] , [ 1225425600000 , 6.138256993963] , [ 1228021200000 , 5.6434994016354] , [ 1230699600000 , 5.495220262512] , [ 1233378000000 , 4.6885326869846] , [ 1235797200000 , 4.4524349883438] , [ 1238472000000 , 5.6766520778185] , [ 1241064000000 , 5.7675774480752] , [ 1243742400000 , 5.7882863168337] , [ 1246334400000 , 7.2666010034924] , [ 1249012800000 , 7.519182132226] , [ 1251691200000 , 7.849651451445] , [ 1254283200000 , 10.383992037985] , [ 1256961600000 , 9.0653691861818] , [ 1259557200000 , 9.6705248324159] , [ 1262235600000 , 10.856380561349] , [ 1264914000000 , 11.27452370892] , [ 1267333200000 , 11.754156529088] , [ 1270008000000 , 8.2870811422456] , [ 1272600000000 , 8.0210264360699] , [ 1275278400000 , 7.5375074474865] , [ 1277870400000 , 8.3419527338039] , [ 1280548800000 , 9.4197471818443] , [ 1283227200000 , 8.7321733185797] , [ 1285819200000 , 9.6627062648126] , [ 1288497600000 , 10.187962234549] , [ 1291093200000 , 9.8144201733476] , [ 1293771600000 , 10.275723361713] , [ 1296450000000 , 16.796066079353] , [ 1298869200000 , 17.543254984075] , [ 1301544000000 , 16.673660675084] , [ 1304136000000 , 17.963944353609] , [ 1306814400000 , 16.637740867211] , [ 1309406400000 , 15.84857094609] , [ 1312084800000 , 14.767303362182] , [ 1314763200000 , 24.778452182432] , [ 1317355200000 , 18.370353229999] , [ 1320033600000 , 15.2531374291] , [ 1322629200000 , 14.989600840649] , [ 1325307600000 , 16.052539160125] , [ 1327986000000 , 16.424390322793] , [ 1330491600000 , 17.884020741105] , [ 1333166400000 , 7.1424929577921] , [ 1335758400000 , 7.8076213051482] , [ 1338436800000 , 7.2462684949232]]
    	}, {
    		'key' : 'Health Care',
    		'color' : orange,
    		'values' : [ [ 1138683600000 , 14.212410956029] , [ 1141102800000 , 13.973193618249] , [ 1143781200000 , 15.218233920665] , [ 1146369600000 , 14.38210972745] , [ 1149048000000 , 13.894310878491] , [ 1151640000000 , 15.593086090032] , [ 1154318400000 , 16.244839695188] , [ 1156996800000 , 16.017088850646] , [ 1159588800000 , 14.183951830055] , [ 1162270800000 , 14.148523245697] , [ 1164862800000 , 13.424326059972] , [ 1167541200000 , 12.974450435753] , [ 1170219600000 , 13.23247041802] , [ 1172638800000 , 13.318762655574] , [ 1175313600000 , 15.961407746104] , [ 1177905600000 , 16.287714639805] , [ 1180584000000 , 16.246590583889] , [ 1183176000000 , 17.564505594809] , [ 1185854400000 , 17.872725373165] , [ 1188532800000 , 18.018998508757] , [ 1191124800000 , 15.584518016603] , [ 1193803200000 , 15.480850647181] , [ 1196398800000 , 15.699120036984] , [ 1199077200000 , 19.184281817226] , [ 1201755600000 , 19.691226605207] , [ 1204261200000 , 18.982314051295] , [ 1206936000000 , 18.707820309008] , [ 1209528000000 , 17.459630929761] , [ 1212206400000 , 16.500616076782] , [ 1214798400000 , 18.086324003979] , [ 1217476800000 , 18.929464156258] , [ 1220155200000 , 18.233728682084] , [ 1222747200000 , 16.315776297325] , [ 1225425600000 , 14.63289219025] , [ 1228021200000 , 14.667835024478] , [ 1230699600000 , 13.946993947308] , [ 1233378000000 , 14.394304684397] , [ 1235797200000 , 13.724462792967] , [ 1238472000000 , 10.930879035806] , [ 1241064000000 , 9.8339915513708] , [ 1243742400000 , 10.053858541872] , [ 1246334400000 , 11.786998438287] , [ 1249012800000 , 11.780994901769] , [ 1251691200000 , 11.305889670276] , [ 1254283200000 , 10.918452290083] , [ 1256961600000 , 9.6811395055706] , [ 1259557200000 , 10.971529744038] , [ 1262235600000 , 13.330210480209] , [ 1264914000000 , 14.592637568961] , [ 1267333200000 , 14.605329141157] , [ 1270008000000 , 13.936853794037] , [ 1272600000000 , 12.189480759072] , [ 1275278400000 , 11.676151385046] , [ 1277870400000 , 13.058852800017] , [ 1280548800000 , 13.62891543203] , [ 1283227200000 , 13.811107569918] , [ 1285819200000 , 13.786494560787] , [ 1288497600000 , 14.04516285753] , [ 1291093200000 , 13.697412447288] , [ 1293771600000 , 13.677681376221] , [ 1296450000000 , 19.961511864531] , [ 1298869200000 , 21.049198298158] , [ 1301544000000 , 22.687631094008] , [ 1304136000000 , 25.469010617433] , [ 1306814400000 , 24.883799437121] , [ 1309406400000 , 24.203843814248] , [ 1312084800000 , 22.138760964038] , [ 1314763200000 , 16.034636966228] , [ 1317355200000 , 15.394958944556] , [ 1320033600000 , 12.625642461969] , [ 1322629200000 , 12.973735699739] , [ 1325307600000 , 15.786018336149] , [ 1327986000000 , 15.227368020134] , [ 1330491600000 , 15.899752650734] , [ 1333166400000 , 18.994731295388] , [ 1335758400000 , 18.450055817702] , [ 1338436800000 , 17.863719889669]]
    	}, {
    		'key' : 'Information Technology',
    		'color' : dark,
    		'values' : [ [ 1138683600000 , 13.242301508051] , [ 1141102800000 , 12.863536342042] , [ 1143781200000 , 21.034044171629] , [ 1146369600000 , 21.419084618803] , [ 1149048000000 , 21.142678863691] , [ 1151640000000 , 26.568489677529] , [ 1154318400000 , 24.839144939905] , [ 1156996800000 , 25.456187462167] , [ 1159588800000 , 26.350164502826] , [ 1162270800000 , 26.47833320519] , [ 1164862800000 , 26.425979547847] , [ 1167541200000 , 28.191461582256] , [ 1170219600000 , 28.930307448808] , [ 1172638800000 , 29.521413891117] , [ 1175313600000 , 28.188285966466] , [ 1177905600000 , 27.704619625832] , [ 1180584000000 , 27.490862424829] , [ 1183176000000 , 28.770679721286] , [ 1185854400000 , 29.060480671449] , [ 1188532800000 , 28.240998844973] , [ 1191124800000 , 33.004893194127] , [ 1193803200000 , 34.075180359928] , [ 1196398800000 , 32.548560664833] , [ 1199077200000 , 30.629727432728] , [ 1201755600000 , 28.642858788159] , [ 1204261200000 , 27.973575227842] , [ 1206936000000 , 27.393351882726] , [ 1209528000000 , 28.476095288523] , [ 1212206400000 , 29.29667866426] , [ 1214798400000 , 29.222333802896] , [ 1217476800000 , 28.092966093843] , [ 1220155200000 , 28.107159262922] , [ 1222747200000 , 25.482974832098] , [ 1225425600000 , 21.208115993834] , [ 1228021200000 , 20.295043095268] , [ 1230699600000 , 15.925754618401] , [ 1233378000000 , 17.162864628346] , [ 1235797200000 , 17.084345773174] , [ 1238472000000 , 22.246007102281] , [ 1241064000000 , 24.530543998509] , [ 1243742400000 , 25.084184918242] , [ 1246334400000 , 16.606166527358] , [ 1249012800000 , 17.239620011628] , [ 1251691200000 , 17.336739127379] , [ 1254283200000 , 25.478492475753] , [ 1256961600000 , 23.017152085245] , [ 1259557200000 , 25.617745423683] , [ 1262235600000 , 24.061133998642] , [ 1264914000000 , 23.223933318644] , [ 1267333200000 , 24.425887263937] , [ 1270008000000 , 35.501471156693] , [ 1272600000000 , 33.775013878676] , [ 1275278400000 , 30.417993630285] , [ 1277870400000 , 30.023598978467] , [ 1280548800000 , 33.327519522436] , [ 1283227200000 , 31.963388450371] , [ 1285819200000 , 30.498967232092] , [ 1288497600000 , 32.403696817912] , [ 1291093200000 , 31.47736071922] , [ 1293771600000 , 31.53259666241] , [ 1296450000000 , 41.760282761548] , [ 1298869200000 , 45.605771243237] , [ 1301544000000 , 39.986557966215] , [ 1304136000000 , 43.846330510051] , [ 1306814400000 , 39.857316881857] , [ 1309406400000 , 37.675127768208] , [ 1312084800000 , 35.775077970313] , [ 1314763200000 , 48.631009702577] , [ 1317355200000 , 42.830831754505] , [ 1320033600000 , 35.611502589362] , [ 1322629200000 , 35.320136981738] , [ 1325307600000 , 31.564136901516] , [ 1327986000000 , 32.074407502433] , [ 1330491600000 , 35.053013769976] , [ 1333166400000 , 26.434568573937] , [ 1335758400000 , 25.305617871002] , [ 1338436800000 , 24.520919418236]]
    	}];

    	var stackedAreaChart = nv.models.stackedAreaChart()
    	.useInteractiveGuideline(true)
    	.x(function(d) { return d[0] })
    	.y(function(d) { return d[1] })
    	.controlLabels({stacked: 'Stacked'})
    	.showControls(false)
    	.duration(300);

    	stackedAreaChart.xAxis.tickFormat(function(d) { return d3.time.format('%x')(new Date(d)) });
    	stackedAreaChart.yAxis.tickFormat(d3.format(',.4f'));

    	d3.select('#nv-stacked-area-chart')
    	.append('svg')
    	.datum(stackedAreaChartData)
    	.transition().duration(1000)
    	.call(stackedAreaChart)
    	.each('start', function() {
    		setTimeout(function() {
    			d3.selectAll('#nv-stacked-area-chart *').each(function() {
    				if(this.__transition__)
    					this.__transition__.duration = 1;
    			})
    		}, 0)
    	});
    	nv.utils.windowResize(stackedAreaChart.update);
    	return stackedAreaChart;
    });


    /* d3 Stacked Bar Chart
    ------------------------- */
    var stackedBarChartData = [{
    	key: 'Stream 1',
    	'color' : red,
    	values: [
    	{ x:1, y: 10}, { x:2, y: 15}, { x:3, y: 16}, { x:4, y: 20}, { x:5, y: 57}, { x:6, y: 42}, { x:7, y: 12}, { x:8, y: 65}, { x:9, y: 34}, { x:10, y: 52}, 
    	{ x:11, y: 23}, { x:12, y: 12}, { x:13, y: 22}, { x:14, y: 22}, { x:15, y: 48}, { x:16, y: 54}, { x:17, y: 32}, { x:18, y: 13}, { x:19, y: 21}, { x:20, y: 12}
    	]
    },{
    	key: 'Stream 2',
    	'color' : orange,
    	values: [
    	{ x:1, y: 10}, { x:2, y: 15}, { x:3, y: 16}, { x:4, y: 45}, { x:5, y: 67}, { x:6, y: 34}, { x:7, y: 43}, { x:8, y: 65}, { x:9, y: 32}, { x:10, y: 12}, 
    	{ x:11, y: 43}, { x:12, y: 45}, { x:13, y: 32}, { x:14, y: 32}, { x:15, y: 38}, { x:16, y: 64}, { x:17, y: 42}, { x:18, y: 23}, { x:19, y: 31}, { x:20, y: 22}
    	]
    },{
    	key: 'Stream 2',
    	'color' : dark,
    	values: [
    	{ x:1, y: 20}, { x:2, y: 25}, { x:3, y: 26}, { x:4, y: 30}, { x:5, y: 57}, { x:6, y: 52}, { x:7, y: 22}, { x:8, y: 75}, { x:9, y: 44}, { x:10, y: 62}, 
    	{ x:11, y: 35}, { x:12, y: 15}, { x:13, y: 25}, { x:14, y: 25}, { x:15, y: 45}, { x:16, y: 55}, { x:17, y: 35}, { x:18, y: 15}, { x:19, y: 25}, { x:20, y: 15}
    	]
    }];
    nv.addGraph({
    	generate: function() {
    		var stackedBarChart = nv.models.multiBarChart()
    		.stacked(true)
    		.showControls(false);

    		var svg = d3.select('#nv-stacked-bar-chart').append('svg').datum(stackedBarChartData);
    		svg.transition().duration(0).call(stackedBarChart);
    		return stackedBarChart;
    	}
    });
  });



/* -------------------------------
   36.0 CONTROLLER - Calendar
   ------------------------------- */
   colorAdminApp.controller('calendarController', function($scope, $rootScope, $state) {

   	var buttonSetting = {left: 'today prev,next ', center: 'title', right: 'month,agendaWeek,agendaDay'};
   	var date = new Date();
   	var m = date.getMonth();
   	var y = date.getFullYear();

   	var calendar = $('#calendar').fullCalendar({
   		header: buttonSetting,
   		selectable: true,
   		selectHelper: true,
   		droppable: true,
		drop: function(date, allDay) { // this function is called when something is dropped

			// retrieve the dropped element's stored Event Object
			var originalEventObject = $(this).data('eventObject');
			
			// we need to copy it, so that multiple events don't have a reference to the same object
			var copiedEventObject = $.extend({}, originalEventObject);
			
			// assign it the date that was reported
			copiedEventObject.start = date;
			copiedEventObject.allDay = allDay;
			
			// render the event on the calendar
			// the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
			$('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
			
			// is the "remove after drop" checkbox checked?
			if ($('#drop-remove').is(':checked')) {
				// if so, remove the element from the "Draggable Events" list
				$(this).remove();
			}
			
		},
		select: function(start, end, allDay) {
			var title = prompt('Event Title:');
			if (title) {
				calendar.fullCalendar('renderEvent',
				{
					title: title,
					start: start,
					end: end,
					allDay: allDay
				},
					true // make the event "stick"
					);
			}
			calendar.fullCalendar('unselect');
		},
		eventRender: function(event, element, calEvent) {
			var mediaObject = (event.media) ? event.media : '';
			var description = (event.description) ? event.description : '';
			element.find(".fc-event-title").after($("<span class=\"fc-event-icons\"></span>").html(mediaObject));
			element.find(".fc-event-title").append('<small>'+ description +'</small>');
		},
		editable: true,
		events: [
		{
			title: 'Event',
			start: new Date(y, m, 0),
			end: new Date(y, m, 1),
			className: 'bg-purple',
			media: '<i class="fa fa-trophy"></i>',
			description: 'Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.'
		},
		{
			title: 'Daily Meeting',
			start: new Date(y, m, 10),
			end: new Date(y, m, 12),
			allDay: false,
			className: 'bg-blue',
			media: '<i class="fa fa-users"></i>',
			description: 'Lorem ipsum dolor sit amet adipiscing elit.'
		},
		{
			title: 'Click for Google',
			start: new Date(y, m, 15),
			end: new Date(y, m, 17),
			url: 'http://google.com/',
			className: 'bg-green',
			media: '<i class="fa fa-google-plus"></i>',
			description: 'Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.'
		}
		]
	});

	/* initialize the external events
	-----------------------------------------------------------------*/
	$('#external-events .external-event').each(function() {
		var eventObject = {
			title: $.trim($(this).attr('data-title')),
			className: $(this).attr('data-bg'),
			media: $(this).attr('data-media'),
			description: $(this).attr('data-desc')
		};
		
		$(this).data('eventObject', eventObject);
		
		$(this).draggable({
			zIndex: 999,
			revert: true,
			revertDuration: 0
		});
	});
});



/* -------------------------------
   37.0 CONTROLLER - Vector Map
   ------------------------------- */
   colorAdminApp.controller('mapVectorController', function($scope, $rootScope, $state) {
   	$rootScope.setting.layout.pageContentFullWidth = true;
   	$rootScope.setting.layout.pageContentInverseMode = true;

   	var wHeight = $(window).height();
   	$('#world-map').css('height', wHeight);
   	$('#world-map').vectorMap({
   		map: 'world_mill_en',
   		scaleColors: ['#e74c3c', '#0071a4'],
   		normalizeFunction: 'polynomial',
   		hoverOpacity: 0.5,
   		hoverColor: false,
   		markerStyle: {
   			initial: {
   				fill: '#4cabc7',
   				stroke: 'transparent',
   				r: 3
   			}
   		},
   		regionStyle: {
   			initial: {
   				fill: 'rgb(97,109,125)',
   				"fill-opacity": 1,
   				stroke: 'none',
   				"stroke-width": 0.4,
   				"stroke-opacity": 1
   			},
   			hover: { "fill-opacity": 0.8 },
   			selected: { fill: 'yellow' }
   		},
   		focusOn: { x: 0.5, y: 0.5, scale: 2 },
   		backgroundColor: '#242a30',
   		markers: [
   		{latLng: [41.90, 12.45], name: 'Vatican City'},
   		{latLng: [43.73, 7.41], name: 'Monaco'},
   		{latLng: [-0.52, 166.93], name: 'Nauru'},
   		{latLng: [-8.51, 179.21], name: 'Tuvalu'},
   		{latLng: [43.93, 12.46], name: 'San Marino'},
   		{latLng: [47.14, 9.52], name: 'Liechtenstein'},
   		{latLng: [7.11, 171.06], name: 'Marshall Islands'},
   		{latLng: [17.3, -62.73], name: 'Saint Kitts and Nevis'},
   		{latLng: [3.2, 73.22], name: 'Maldives'},
   		{latLng: [35.88, 14.5], name: 'Malta'},
   		{latLng: [12.05, -61.75], name: 'Grenada'},
   		{latLng: [13.16, -61.23], name: 'Saint Vincent and the Grenadines'},
   		{latLng: [13.16, -59.55], name: 'Barbados'},
   		{latLng: [17.11, -61.85], name: 'Antigua and Barbuda'},
   		{latLng: [-4.61, 55.45], name: 'Seychelles'},
   		{latLng: [7.35, 134.46], name: 'Palau'},
   		{latLng: [42.5, 1.51], name: 'Andorra'},
   		{latLng: [14.01, -60.98], name: 'Saint Lucia'},
   		{latLng: [6.91, 158.18], name: 'Federated States of Micronesia'},
   		{latLng: [1.3, 103.8], name: 'Singapore'},
   		{latLng: [1.46, 173.03], name: 'Kiribati'},
   		{latLng: [-21.13, -175.2], name: 'Tonga'},
   		{latLng: [15.3, -61.38], name: 'Dominica'},
   		{latLng: [-20.2, 57.5], name: 'Mauritius'},
   		{latLng: [26.02, 50.55], name: 'Bahrain'},
   		{latLng: [0.33, 6.73], name: 'São Tomé and Príncipe'}
   		]
   	});
   });



/* -------------------------------
   38.0 CONTROLLER - Google Map
   ------------------------------- */
   function handleGoogleMapLoaded() {
   	$(window).trigger('googleMapLoaded');
   }
   colorAdminApp.controller('mapGoogleController', function($scope, $rootScope, $state) {
   	$rootScope.setting.layout.pageContentFullWidth = true;

   	var mapDefault;

   	function initialize() {
   		var mapOptions = {
   			zoom: 6,
   			center: new google.maps.LatLng(-33.397, 145.644),
   			mapTypeId: google.maps.MapTypeId.ROADMAP,
   			disableDefaultUI: true,
   		};
   		mapDefault = new google.maps.Map(document.getElementById('google-map-default'), mapOptions);
   	}

   	$(window).unbind('googleMapLoaded');
   	$(window).bind('googleMapLoaded', initialize);
   	$.getScript("http://maps.google.com/maps/api/js?sensor=false&callback=handleGoogleMapLoaded");

   	$(window).resize(function() {
   		google.maps.event.trigger(mapDefault, "resize");
   	});

   	var defaultMapStyles = [];
   	var flatMapStyles = [{"stylers":[{"visibility":"off"}]},{"featureType":"road","stylers":[{"visibility":"on"},{"color":"#ffffff"}]},{"featureType":"road.arterial","stylers":[{"visibility":"on"},{"color":"#fee379"}]},{"featureType":"road.highway","stylers":[{"visibility":"on"},{"color":"#fee379"}]},{"featureType":"landscape","stylers":[{"visibility":"on"},{"color":"#f3f4f4"}]},{"featureType":"water","stylers":[{"visibility":"on"},{"color":"#7fc8ed"}]},{},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#83cead"}]},{"elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"landscape.man_made","elementType":"geometry","stylers":[{"weight":0.9},{"visibility":"off"}]}]; 
   	var turquoiseWaterStyles = [{"featureType":"landscape.natural","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#e0efef"}]},{"featureType":"poi","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"hue":"#1900ff"},{"color":"#c0e8e8"}]},{"featureType":"landscape.man_made","elementType":"geometry.fill"},{"featureType":"road","elementType":"geometry","stylers":[{"lightness":100},{"visibility":"simplified"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"water","stylers":[{"color":"#7dcdcd"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"visibility":"on"},{"lightness":700}]}];
   	var icyBlueStyles = [{"stylers":[{"hue":"#2c3e50"},{"saturation":250}]},{"featureType":"road","elementType":"geometry","stylers":[{"lightness":50},{"visibility":"simplified"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]}];
   	var oldDryMudStyles = [{"featureType":"landscape","stylers":[{"hue":"#FFAD00"},{"saturation":50.2},{"lightness":-34.8},{"gamma":1}]},{"featureType":"road.highway","stylers":[{"hue":"#FFAD00"},{"saturation":-19.8},{"lightness":-1.8},{"gamma":1}]},{"featureType":"road.arterial","stylers":[{"hue":"#FFAD00"},{"saturation":72.4},{"lightness":-32.6},{"gamma":1}]},{"featureType":"road.local","stylers":[{"hue":"#FFAD00"},{"saturation":74.4},{"lightness":-18},{"gamma":1}]},{"featureType":"water","stylers":[{"hue":"#00FFA6"},{"saturation":-63.2},{"lightness":38},{"gamma":1}]},{"featureType":"poi","stylers":[{"hue":"#FFC300"},{"saturation":54.2},{"lightness":-14.4},{"gamma":1}]}];
   	var cobaltStyles  = [{"featureType":"all","elementType":"all","stylers":[{"invert_lightness":true},{"saturation":10},{"lightness":10},{"gamma":0.8},{"hue":"#293036"}]},{"featureType":"water","stylers":[{"visibility":"on"},{"color":"#293036"}]}];
   	var darkRedStyles   = [{"featureType":"all","elementType":"all","stylers":[{"invert_lightness":true},{"saturation":10},{"lightness":10},{"gamma":0.8},{"hue":"#000000"}]},{"featureType":"water","stylers":[{"visibility":"on"},{"color":"#293036"}]}];

   	$('[data-map-theme]').click(function() {
   		var targetTheme = $(this).attr('data-map-theme');
   		var targetLi = $(this).closest('li');
   		var targetText = $(this).text();
   		var inverseContentMode = false;
   		$('#map-theme-selection li').not(targetLi).removeClass('active');
   		$('#map-theme-text').text(targetText);
   		$(targetLi).addClass('active');
   		switch(targetTheme) {
   			case 'flat':
   			mapDefault.setOptions({styles: flatMapStyles});
   			break;
   			case 'turquoise-water':
   			mapDefault.setOptions({styles: turquoiseWaterStyles});
   			break;
   			case 'icy-blue':
   			mapDefault.setOptions({styles: icyBlueStyles});
   			break;
   			case 'cobalt':
   			mapDefault.setOptions({styles: cobaltStyles});
   			inverseContentMode = true;
   			break;
   			case 'old-dry-mud':
   			mapDefault.setOptions({styles: oldDryMudStyles});
   			break;
   			case 'dark-red':
   			mapDefault.setOptions({styles: darkRedStyles});
   			inverseContentMode = true;
   			break;
   			default:
   			mapDefault.setOptions({styles: defaultMapStyles});
   			break;
   		}

   		if (inverseContentMode === true) {
   			$('#content').addClass('content-inverse-mode');
   		} else {
   			$('#content').removeClass('content-inverse-mode');
   		}
   	});
   });



/* -------------------------------
   39.0 CONTROLLER - Gallery V1
   ------------------------------- */
   colorAdminApp.controller('galleryController', function($scope, $rootScope, $state) {

   	function calculateDivider() {
   		var dividerValue = 4;
   		if ($(this).width() <= 480) {
   			dividerValue = 1;
   		} else if ($(this).width() <= 767) {
   			dividerValue = 2;
   		} else if ($(this).width() <= 980) {
   			dividerValue = 3;
   		}
   		return dividerValue;
   	}

   	var container = $('#gallery');
   	var dividerValue = calculateDivider();
   	var containerWidth = $(container).width() - 20;
   	var columnWidth = containerWidth / dividerValue;
   	$(container).isotope({
   		resizable: true,
   		masonry: {
   			columnWidth: columnWidth
   		}
   	});

   	$(window).smartresize(function() {
   		var dividerValue = calculateDivider();
   		var containerWidth = $(container).width() - 20;
   		var columnWidth = containerWidth / dividerValue;
   		$(container).isotope({
   			masonry: { 
   				columnWidth: columnWidth 
   			}
   		});
   	});

   	var $optionSets = $('#options .gallery-option-set'),
   	$optionLinks = $optionSets.find('a');

   	$optionLinks.click( function(){
   		var $this = $(this);
   		if ($this.hasClass('active')) {
   			return false;
   		}
   		var $optionSet = $this.parents('.gallery-option-set');
   		$optionSet.find('.active').removeClass('active');
   		$this.addClass('active');

   		var options = {};
   		var key = $optionSet.attr('data-option-key');
   		var value = $this.attr('data-option-value');
   		value = value === 'false' ? false : value;
   		options[ key ] = value;
   		$(container).isotope( options );
   		return false;
   	});
   });



/* -------------------------------
   40.0 CONTROLLER - Gallery V2
   ------------------------------- */
   colorAdminApp.controller('galleryV2Controller', function($scope, $rootScope, $state) {
   	$('.superbox').SuperBox();
   });



/* -------------------------------
   41.0 CONTROLLER - Page with Footer
   ------------------------------- */
   colorAdminApp.controller('pageWithFooterController', function($scope, $rootScope, $state) {
   	$rootScope.setting.layout.pageFooter = true;
   });



/* -------------------------------
   42.0 CONTROLLER - Page without Sidebar
   ------------------------------- */
   colorAdminApp.controller('pageWithoutSidebarController', function($scope, $rootScope, $state) {
   	$rootScope.setting.layout.pageWithoutSidebar = true;
   });



/* -------------------------------
   43.0 CONTROLLER - Page with Right Sidebar
   ------------------------------- */
   colorAdminApp.controller('pageWithRightSidebarController', function($scope, $rootScope, $state) {
   	$rootScope.setting.layout.pageRightSidebar = true;
   });



/* -------------------------------
   44.0 CONTROLLER - Page with Minified Sidebar
   ------------------------------- */
   colorAdminApp.controller('pageWithMinifiedSidebarController', function($scope, $rootScope, $state) {
   	$rootScope.setting.layout.pageSidebarMinified = true;
   });



/* -------------------------------
   45.0 CONTROLLER - Page with Two Sidebar
   ------------------------------- */
   colorAdminApp.controller('pageWithTwoSidebarController', function($scope, $rootScope, $state) {
   	$rootScope.setting.layout.pageTwoSidebar = true;
   });



/* -------------------------------
   46.0 CONTROLLER - Full Height Content
   ------------------------------- */
   colorAdminApp.controller('pageFullHeightContentController', function($scope, $rootScope, $state) {
   	$rootScope.setting.layout.pageContentFullHeight = true;
   	$rootScope.setting.layout.pageContentFullWidth = true;
   });



/* -------------------------------
   47.0 CONTROLLER - Page with Wide Sidebar
   ------------------------------- */
   colorAdminApp.controller('pageWithWideSidebarController', function($scope, $rootScope, $state) {
   	$rootScope.setting.layout.pageWideSidebar = true;
   });



/* -------------------------------
   48.0 CONTROLLER - Page with Light Sidebar
   ------------------------------- */
   colorAdminApp.controller('pageWithLightSidebarController', function($scope, $rootScope, $state) {
   	$rootScope.setting.layout.pageLightSidebar = true;
   });


/* -------------------------------
   49.0 CONTROLLER - Page with Mega Menu
   ------------------------------- */
   colorAdminApp.controller('pageWithMegaMenuController', function($scope, $rootScope, $state) {
   	$rootScope.setting.layout.pageMegaMenu = true;
   });



/* -------------------------------
   50.0 CONTROLLER - Page with Top Menu
   ------------------------------- */
   colorAdminApp.controller('pageWithTopMenuController', function($scope, $rootScope, $state) {
   	$rootScope.setting.layout.pageTopMenu = true;
   	$rootScope.setting.layout.pageWithoutSidebar = true;
   });



/* -------------------------------
   51.0 CONTROLLER - Page with Boxed Layout
   ------------------------------- */
   colorAdminApp.controller('pageWithBoxedLayoutController', function($scope, $rootScope, $state) {
   	$rootScope.setting.layout.pageBoxedLayout = true;
   });



/* -------------------------------
   52.0 CONTROLLER - Page with Mixed Menu
   ------------------------------- */
   colorAdminApp.controller('pageWithMixedMenuController', function($scope, $rootScope, $state) {
   	$rootScope.setting.layout.pageTopMenu = true;
   });



/* -------------------------------
   53.0 CONTROLLER - Page Boxed Layout with Mixed Menu
   ------------------------------- */
   colorAdminApp.controller('pageBoxedLayoutWithMixedMenuController', function($scope, $rootScope, $state) {
   	$rootScope.setting.layout.pageBoxedLayout = true;
   	$rootScope.setting.layout.pageTopMenu = true;
   });



/* -------------------------------
   54.0 CONTROLLER - Page with Transparent Sidebar
   ------------------------------- */
   colorAdminApp.controller('pageWithTransparentSidebarController', function($scope, $rootScope, $state) {
   	$rootScope.setting.layout.pageSidebarTransparent = true;
   });



/* -------------------------------
   55.0 CONTROLLER - Timeline
   ------------------------------- */
   colorAdminApp.controller('extraTimelineController', function($scope, $rootScope, $state) {
   	var mapDefault;

   	function initialize() {
   		var mapOptions = {
   			zoom: 6,
   			center: new google.maps.LatLng(-33.397, 145.644),
   			mapTypeId: google.maps.MapTypeId.ROADMAP,
   			disableDefaultUI: true,
   		};
   		mapDefault = new google.maps.Map(document.getElementById('google-map'), mapOptions);
   	}

   	$(window).unbind('googleMapLoaded');
   	$(window).bind('googleMapLoaded', initialize);
   	$.getScript("http://maps.google.com/maps/api/js?sensor=false&callback=handleGoogleMapLoaded");

   	$(window).resize(function() {
   		google.maps.event.trigger(mapDefault, "resize");
   	});
   });



/* -------------------------------
   56.0 CONTROLLER - Coming Soon
   ------------------------------- */
   colorAdminApp.controller('comingSoonController', function($scope, $rootScope, $state) {
   	$rootScope.setting.layout.pageWithoutHeader = true;
   	$rootScope.setting.layout.pageBgWhite = true;
   	$rootScope.setting.layout.paceTop = true;

   	var newYear = new Date();
   	newYear = new Date(newYear.getFullYear() + 1, 1 - 1, 1);
   	$('#timer').countdown({until: newYear});
   });



/* -------------------------------
   57.0 CONTROLLER - 404 Error
   ------------------------------- */
   colorAdminApp.controller('errorController', function($scope, $rootScope, $state) {
   	$rootScope.setting.layout.pageWithoutHeader = true;
   	$rootScope.setting.layout.paceTop = true;
   });



/* -------------------------------
   58.0 CONTROLLER - Login V1
   ------------------------------- */
   colorAdminApp.controller('loginV1Controller', function($scope, $rootScope, $state) {
   	$rootScope.setting.layout.pageWithoutHeader = true;
   	$rootScope.setting.layout.paceTop = true;

   	$scope.submitForm = function(form) {
   		$state.go('app.dashboard.v2');
   	};
   });



/* -------------------------------
   59.0 CONTROLLER - Login V2
   ------------------------------- */
   colorAdminApp.controller('loginV2Controller', function($scope, $rootScope, $state) {
   	$rootScope.setting.layout.pageWithoutHeader = true;
   	$rootScope.setting.layout.paceTop = true;

   	$scope.submitForm = function(form) {
   		$state.go('app.dashboard.v2');
   	};

   	$('[data-click="change-bg"]').click(function() {
   		var targetImage = '[data-id="login-cover-image"]';
   		var targetImageSrc = $(this).find('img').attr('src');
   		var targetImageHtml = '<img src="'+ targetImageSrc +'" data-id="login-cover-image" />';

   		$('.login-cover-image').prepend(targetImageHtml);
   		$(targetImage).not('[src="'+ targetImageSrc +'"]').fadeOut('slow', function() {
   			$(this).remove();
   		});
   		$('[data-click="change-bg"]').closest('li').removeClass('active');
   		$(this).closest('li').addClass('active');	
   	});
   });



/* -------------------------------
   60.0 CONTROLLER - Login V3
   ------------------------------- */
   colorAdminApp.controller('loginV3Controller', function($scope, $rootScope, $state) {
   	$rootScope.setting.layout.pageWithoutHeader = true;
   	$rootScope.setting.layout.paceTop = true;
   	$rootScope.setting.layout.pageBgWhite = true;

   	$scope.submitForm = function(form) {
   		$state.go('app.dashboard.v2');
   	};
   });



/* -------------------------------
   61.0 CONTROLLER - Register V3
   ------------------------------- */
   colorAdminApp.controller('registerV3Controller', function($scope, $rootScope, $state) {
   	$rootScope.setting.layout.pageWithoutHeader = true;
   	$rootScope.setting.layout.paceTop = true;
   	$rootScope.setting.layout.pageBgWhite = true;

   	$scope.submitForm = function(form) {
   		$state.go('app.dashboard.v2');
   	};
   });
