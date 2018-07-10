
colorAdminApp.directive('a', function() {
  return {
    restrict: 'E',
    link: function(scope, elem, attrs) {
      if (attrs.ngClick || attrs.href === '' || attrs.href === '#') {
        elem.on('click', function(e) {
          e.preventDefault();
        });
      }
    }
  };
})
.directive('fixedTableHeaders', ['$timeout', function($timeout) {
  return {
    restrict: 'A',
    link: function(scope, element, attrs) {
      $timeout(function() {
        // var container = element.parentsUntil(attrs.fixedTableHeaders);
        // element.stickyTableHeaders({ scrollableArea: container, "fixedOffset": 2 });
      }, 10);
    }
  }
}])
.directive('paginator', function() {
  return {

   scope:{
    source : '=',
    currentpage: '=',
  },
  restrict:'E',
  template: '<div class="pagination"><div class="col-sm-5"><span>Showing {{currentpage + 1}} of {{ source }}</span></div><div class="col-sm-7" style="text-align:right;"><button type="button" class="btn btn-white" ng-disabled="currentpage == 0" ng-click="currentpage=0">First</button> <button type="button" class="btn btn-white" ng-disabled="currentpage == 0" ng-click="currentpage=currentpage-1">Previous</button><button type="button" class="btn btn-white"  ng-disabled="currentpage >= source-1" ng-click="currentpage = currentpage+1">Next </button><button type="button" class="btn btn-white" ng-disabled="currentpage>= source-1" ng-click="currentpage = source-1">Last</button></div></div>'    };
}) .directive('ngThumb', ['$window', function($window) {
  var helper = {
    support: !!($window.FileReader && $window.CanvasRenderingContext2D),
    isFile: function(item) {
      return angular.isObject(item) && item instanceof $window.File;
    },
    isImage: function(file) {
      var type =  '|' + file.type.slice(file.type.lastIndexOf('/') + 1) + '|';
      return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
    }
  };

  return {
    restrict: 'A',
    template: '<canvas/>',
    link: function(scope, element, attributes) {
      if (!helper.support) return;

      var params = scope.$eval(attributes.ngThumb);

      if (!helper.isFile(params.file)) return;
      if (!helper.isImage(params.file)) return;

      var canvas = element.find('canvas');
      var reader = new FileReader();

      reader.onload = onLoadFile;
      reader.readAsDataURL(params.file);

      function onLoadFile(event) {
        var img = new Image();
        img.onload = onLoadImage;
        img.src = event.target.result;
      }

      function onLoadImage() {
        var width = params.width || this.width / this.height * params.height;
        var height = params.height || this.height / this.width * params.width;
        canvas.attr({ width: width, height: height });
        canvas[0].getContext('2d').drawImage(this, 0, 0, width, height);
      }
    }
  };
}]).directive("ngUnique", function(ls) {
  return {
    restrict: 'A',
    require: 'ngModel',
    link: function (scope, element, attrs, ngModel) {
      element.bind('blur', function (e) {
        if (!ngModel || !element.val()) return;
        var keyProperty = scope.$eval(attrs.ngUnique);
        var currentValue = element.val();
        ls.checkUniqueValue(keyProperty.key, keyProperty.property, currentValue)
        .then(function (unique) {
         console.log(unique);
         if (currentValue == element.val()) {
          console.log('unique = '+unique);
          ngModel.$setValidity('unique', unique);
          scope.$broadcast('show-errors-check-validity');
        }

      });
      });
    }
  }
})

.directive('modal', function () {
 return {
  template: '<div class="modal fade">' + 
  '<div class="modal-dialog">' + 
  '<div class="modal-content">' + 
  '<div class="modal-header">' + 
  '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>' + 
  '<h4 class="modal-title">{{ title }}</h4>' + 
  '</div>' + 
  '<div class="modal-body" ng-transclude></div>' + 
  '</div>' + 
  '</div>' + 
  '</div>',
  restrict: 'E',
  transclude: true,
  replace:true,
  scope:true,
  link: function postLink(scope, element, attrs) {
    scope.title = attrs.title;
    scope.$watch(attrs.visible, function(value){
      if(value == true){
        $(element).modal('show'); 
      }else{
        $(element).modal('hide');
      }
    });


    $(element).on('shown.bs.modal', function(){
      scope.$apply(function(){
        scope.$parent[attrs.visible] = true;
      });
    });

    $(element).on('hidden.bs.modal', function(){
      scope.$apply(function(){
        scope.$parent[attrs.visible] = false;
      });
    });
  }
};
})

.directive('barcode', function(){
  return{
    restrict: 'AE',
    template: '<img id="barcodeImage" style="width:130px" src="{{src}}"/>',
    scope: {
      key: '='
    },
    link: function($scope){
      $scope.$watch('key', function(key){
        console.log($scope.key);
        var barcode = new bytescoutbarcode128();
        var space= "  ";

        barcode.valueSet([$scope.key.inBarCode].join(space));
        barcode.setMargins(5, 5, 5, 5);
        barcode.setBarWidth(1.6);

        var width = barcode.getMinWidth();

        barcode.setSize(width, 100);

        $scope.src = barcode.exportToBase64(width, 100, 0);
      }, true);
    }
  }
});

