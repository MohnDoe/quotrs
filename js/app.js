/**
 * Created by Personne on 24/06/2015.
 */
var app = angular.module('app', []);

app.controller('formController', function($scope) {

  $scope.artist = {
    name: "Hello",
    age: 20
  }
  $scope.$watch(
    function() {
      return $scope.artist
    },
    function(newVal, oldVal) {
      $scope.artistTwo = newVal.name;
    },
    true
  );

});
