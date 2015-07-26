/**
 * Created by Personne on 24/06/2015.
 */
//$(document).ready(function() {
var app = angular.module('appQuotrs', ['ngRoute', 'ui.bootstrap']);

app.config(function ($httpProvider) {
    $httpProvider.defaults.transformRequest = function (data) {
        if (data === undefined) {
            return data;
        }
        return $.param(data);
    };
    $httpProvider.defaults.headers.post['Content-Type'] = '' + 'application/x-www-form-urlencoded; charset=UTF-8';
});

app.directive('contenteditable', function () {
    return {
        restrict: 'A', // only activate on element attribute
        require: '?ngModel', // get a hold of NgModelController
        link: function (scope, element, attrs, ngModel) {
            if (!ngModel) return; // do nothing if no ng-model

            // Specify how UI should be updated
            ngModel.$render = function () {
                element.html(ngModel.$viewValue || '');
            };

            // Listen for change events to enable binding
            element.on('blur keyup change', function () {
                scope.$apply(read);
            });
            read(); // initialize

            // Write data to the model
            function read() {
                var html = element.html();
                // When we clear the content editable the browser leaves a <br> behind
                // If strip-br attribute is provided then we strip this out
                if (attrs.stripBr && html == '<br>') {
                    html = '';
                }
                ngModel.$setViewValue(html);
            }
        }
    }
});

app.controller('formQuoteController', function ($scope, $http) {

    $scope.quote = {
        content: "",
        words: 0,
        url_background: "",
        related_songs_rg : [],
        song: {
            title: "",
            id_rg: -1,
            ur_rg: "",
            url_img_rg: "",
            artist: {
                name: "",
                id_rg: -1,
                url_rg: "",
                url_img_rg: ""
            }
        }
    };
    $scope.autocompleteArtists = {};

    $scope.createQuote = function (event) {
        console.log('posting quote...');
        event.preventDefault();
        $http.post('./api/quotes/create', $scope.quote).
            success(function (data, status, headers, config) {
                // this callback will be called asynchronously
                // when the response is available
                console.log(data);
            }).
            error(function (data, status, headers, config) {
                // called asynchronously if an error occurs
                // or server returns response with an error status.
            });
    };

    $scope.$watch(
        function () {
            return $scope.quote.content;
        },
        function (newVal) {
            var access_token = "uWibAg6C7pcdQpvynsw8zk-fqo7crN5-bckfL0rJ1_SOTRM5BOTKygD4Q-e_ppDz";
            var request = "https://api.genius.com/search?q=" + newVal;
            request += "&access_token=" + access_token;

            $http.get(request).then(
                function (res) {
                    data = res.data;
                    meta = data.meta;
                    status = meta.status;
                    if (status == 200) {
                        // no error, niiiiiiiiice
                        response = data.response;
                        hits = response.hits;

                        if (hits.length > 0) {
                            // some result, super nice !
                            $scope.quote.related_songs_rg = hits;
                            first_hit = hits[0].result;
                            artist_hit = first_hit.primary_artist;

                            // on a tout ce qu'il faut, let's go
                            //song info
                            $scope.quote.song.title = first_hit.title;
                            $scope.quote.song.id_rg = first_hit.id;
                            $scope.quote.song.url_rg = first_hit.url;
                            $scope.quote.song.url_img_rg = first_hit.header_image_url;

                            //artist info
                            $scope.quote.song.artist.name = artist_hit.name;
                            $scope.quote.song.artist.id_rg = artist_hit.id;
                            $scope.quote.song.artist.url_rg = artist_hit.url;
                            $scope.quote.song.artist.url_img_rg = artist_hit.image_url;
                            //backgroud, 4 swag
                            //$scope.quote.url_background = first_hit.header_image_url;
                        }
                    }
                });
        }, true
    )
});
//});