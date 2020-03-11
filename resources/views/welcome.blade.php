<!doctype html>
<html lang="en" ng-app="App">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <title>Home</title>
</head>
<body>
    <div class="container" ng-controller="home">
        <div class="alert alert-warning" ng-show="alert">
            @{{ message }}
        </div>
        <div class="fields mx-auto col-6 mt-5  border-bottom">
            <form id="form">
             <div class="row" ng-repeat="field in fields">
                <div class="col-3 p-0 pr-1">
                    <div class="form-group">
                        <select name="" class="form-control input-sm" placeholder="Field"  ng-model="field.field">
                            <option value="">Fields</option>
                            <option value="size">Size</option>
                            <option value="forks">forks</option>
                            <option value="stars">stars</option>
                            <option value="followers">followers</option>
                        </select>
                    </div>
                </div>
                <div class="col-3 p-0  pr-1">
                    <div class="form-group">
                        <select name=""  class="form-control input-sm" placeholder="Operator"  ng-model="field.operator">
                            <option value="">Oprators</option>
                            <option value="больше">больше</option>
                            <option value="меньше">меньше</option>
                            <option value="равно">равно</option>
                        </select>
                    </div>
                </div>
                <div class="col-3 p-0  pr-1">
                    <div class="form-group">
                        <input type="number" class="form-control input-sm" placeholder="Value" ng-model="field.value">
                    </div>
                </div>
                <div class="col-3  p-0  pr-1 text-rigth">
                    <input type="button" value="Delete" class="btn btn-warning float-right" ng-click="delete(index)">
                </div>
            </div>
            </form>
        </div>
        <div class="fields mx-auto col-6">
            <div class="row">
                <div class="col-6  p-0 pt-2">
                    <button class="btn btn-info" ng-click="apply()">Apply</button>
                    <button class="btn btn-info" ng-click="clear(fields)">Clear</button>
                </div>
                <div class="col-6 p-0 pt-2">
                    <button class="btn btn-info float-right" ng-click="add()">Add Rule</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.9/angular.min.js"></script>
    <script>
        App = new angular.module("App",[]);
        App.controller('home',function($scope,$http){
            $scope.fields = [{}];
            $scope.alert = false;

            $scope.add = _ => {
                $scope.fields.push({});
            };

            $scope.delete = index => {
                if($scope.fields.length === 1)
                    return false;

                $scope.fields.splice(index,1);
            }

            $scope.clear = _ => {
                document.getElementById("form").reset();
            }

            $scope.apply = _ => {
                $scope.alert = false;

                $http({
                    "method" : "post",
                    "url" : "/rule",
                    "data" : $scope.fields,
                    "headers" : {"Content-Type" : "application/json","X-Requested-With" : "XMLHttpRequest"}
                }).then(res => {
                    alert("created");
                    $scope.fields = [{}];
                }, err => {
                    $scope.alert = true;
                    $scope.message = err.data.errors[0][0];
                })
            }
        })
    </script>
</body>
</html>