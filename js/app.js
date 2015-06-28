/**
 * Created by Personne on 24/06/2015.
 */
var app = angular.module('app', ['ui.bootstrap']);

app.config(function($httpProvider) {
  $httpProvider.defaults.transformRequest = function(data) {
    if (data === undefined) {
      return data;
    }
    return $.param(data);
  };
  $httpProvider.defaults.headers.post['Content-Type'] = '' + 'application/x-www-form-urlencoded; charset=UTF-8';
});

app.controller('formController', function($scope, $http) {

  $scope.quote = {
    content: [],
    words: 0,
    song: {
      title: "",
      url_youtube: "",
      album: {
        title: "",
        albumIsNew: false,
        existingID: -1,
        artist: {
          name: "",
          artistIsSameAsSong: false,
          artistIsNew: false,
          existingID: -1
        }
      },
      artist: {
        name: "",
        artistIsNew: false,
        existingID: -1
      }
    }
  };
  $scope.autocompleteArtists = {};

  $scope.create = function(event) {
    event.preventDefault();
    $http.post('./api/quotes/create', $scope.quote).
    success(function(data, status, headers, config) {
      // this callback will be called asynchronously
      // when the response is available
      console.log(data);
    }).
    error(function(data, status, headers, config) {
      // called asynchronously if an error occurs
      // or server returns response with an error status.
    });
  };

  $scope.getArtists = function(val) {
    var artists = [];
    return $http.get('./api/artists/' + val).then(
      function(res) {
        angular.forEach(res.data.artists, function(artist) {
          artists.push(artist);
        });
        return artists;
      });
  };
  $scope.getSongs = function(val) {
    var songs = [];
    var request = './api/songs/'+val;
    if($scope.quote.song.artist.existingID != -1){
      var request = './api/artists/'+$scope.quote.song.artist.existingID+"/songs/"+val
    }
    return $http.get(request).then(
      function(res) {
        $scope.autocompleteArtists = res.data.artists;
        angular.forEach(res.data.songs, function(song) {
          songs.push(song);
        });
        return songs;
      });
  };

  $scope.onSelectArtistSong = function($item, $model, $label) {
    $scope.quote.song.artist = {
      name: $item.name,
      existingID: $item.id,
      artistIsNew: true
    }
    $scope.quote.song.album.artist = {
      name: $item.name,
      existingID: $item.id,
      artistIsNew: true,
      artistIsSameAsSong: true
    }
  };
  $scope.onSelectSong = function($item, $model, $label) {
    $scope.quote.song.title = $item.title;
    $scope.quote.song.url_youtube = $item.url_youtube;
    $scope.quote.song.album.title = $item.album.title;
  };

  $scope.$watchCollection(
    'quote.content',
    function(newVal, oldVal) {
      var numberWords = 0;
      for (var i = 0; i < newVal.length; i++) {
        numberWords += newVal[i] ? newVal[i].split(/\s+/).length : 0;
      }
      $scope.quote.words = numberWords;
    },
    true
  );
  $scope.$watch(
    function() {
      return $scope.quote.song.artist.name
    },
    function(newVal) {
      $scope.quote.song.album.artist.name = newVal;
    },
    true
  );
});
