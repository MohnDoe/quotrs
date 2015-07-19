/**
 * Created by Personne on 24/06/2015.
 */
var app = angular.module('appQuotrs', ['ui.bootstrap']);

app.config(function($httpProvider) {
  $httpProvider.defaults.transformRequest = function(data) {
    if (data === undefined) {
      return data;
    }
    return $.param(data);
  };
  $httpProvider.defaults.headers.post['Content-Type'] = '' + 'application/x-www-form-urlencoded; charset=UTF-8';
});
app.directive('contenteditable', function() {
    return {
        restrict: 'A', // only activate on element attribute
        require: '?ngModel', // get a hold of NgModelController
        link: function(scope, element, attrs, ngModel) {
            if(!ngModel) return; // do nothing if no ng-model

            // Specify how UI should be updated
            ngModel.$render = function() {
                element.html(ngModel.$viewValue || '');
            };

            // Listen for change events to enable binding
            element.on('blur keyup change', function() {
                scope.$apply(read);
            });
            read(); // initialize

            // Write data to the model
            function read() {
                var html = element.html();
                // When we clear the content editable the browser leaves a <br> behind
                // If strip-br attribute is provided then we strip this out
                if( attrs.stripBr && html == '<br>' ) {
                    html = '';
                }
                ngModel.$setViewValue(html);
            }
        }
    }
});

app.controller('formQuoteController', function($scope, $http, $sce) {

  $scope.quote = {
    content: "",
    words: 0,
    song: {
      title: "",
      url_youtube: "",
      songIsNew: true,
      existingID: -1,
      album: {
        title: "",
        albumIsNew: true,
        existingID: -1,
        url_cover: "",
        artist: {
          name: "",
          artistIsSameAsSong: false,
          artistIsNew: true,
          existingID: -1
        }
      },
      artist: {
        name: "",
        artistIsNew: true,
        existingID: -1
      }
    }
  };
  $scope.autocompleteArtists = {};

  $scope.createQuote = function(event) {
    event.preventDefault();
    $http.post('./api/quotes/create', $scope.quote).
    success(function(data, status, headers, config) {
      // this callback will be called asynchronously
      // when the response is available
      console.log(data);
        window.location = data['url_quote'];
    }).
    error(function(data, status, headers, config) {
      // called asynchronously if an error occurs
      // or server returns response with an error status.
    });
  };

  $scope.getArtists = function(val) {
    var artists = [];
      console.log(val);
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
      artistIsNew: false
    }

    // ALBUM
    $scope.quote.song.album.artist = {
      name: $item.name,
      existingID: $item.id,
      artistIsNew: false,
      artistIsSameAsSong: true
    }
  };
  $scope.onSelectSong = function($item, $model, $label) {
    console.log($item);
    $scope.quote.song.title = $item.title;
    $scope.quote.song.url_youtube = $item.url_youtube;
    $scope.quote.song.songIsNew = false;
    $scope.quote.song.existingID = $item.id;

    $scope.quote.song.artist.name = $item.Artist.name;
    $scope.quote.song.artist.existingID = $item.Artist.id;
    $scope.quote.song.artist.artistIsNew = false;

    $scope.quote.song.album.title = $item.Album.title;
    $scope.quote.song.album.existingID = $item.Album.id;
    $scope.quote.song.album.url_cover = $item.Album.url_cover;
    $scope.quote.song.album.albumIsNew = false;
    // console.log($scope.quote);

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
