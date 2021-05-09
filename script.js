var app = angular.module('contactsApp', ['ngRoute', 'ngAnimate']);

app.config(['$routeProvider', function($routeProvider) {

    $routeProvider
        .when('/', {
            templateUrl: 'views/contactsList.html',
            controller: 'ContactsController'
        })
        .when('/contact/:id', {
            templateUrl: 'views/contact.html',
            controller: 'ContactsController'
        })
        .when('/edit/:id', {
            templateUrl: 'views/edit.html',
            controller: 'ContactsController'
        })
        .otherwise({
            redirectTo: '/'
        })
}]);

app.controller('ContactsController', ['$scope', '$http', '$location', '$routeParams', function($scope, $http, $location, $routeParams) {


    //Toggle button for showing and hiding form for adding new contact to database
    $scope.addNewContactForm = false;
    $scope.toggleAddNewContactForm = function() {
        if($scope.addNewContactForm) {
            $scope.addNewContactForm = false;
        } else {
            $scope.addNewContactForm = true;
        }
    }


    $scope.getAllContacts = function() {
        $http.get('http://localhost/newapp/api/contact/readAll.php')
        .then(function (response){
            $scope.contacts = response.data.data;
            console.log('FROM getAllContacts: ', $scope.contacts);
        });
    }

    $scope.getContactById = function() {
        $http.get('http://newapp/api/contact/read.php?id=' + $routeParams.id)
        .then(function (response){
            $scope.contact = response.data;
            $scope.contact.created_at = new Date($scope.contact.created_at);
        });
    }

    $scope.addNewContact = function(){

        if(!$scope.newcontact.address) {
            $scope.newcontact.address = "";
        }

        $http.post('http://newapp/api/contact/create.php', 
                {
                    'name': $scope.newcontact.name,
                    'phone': $scope.newcontact.phone,
                    'address': $scope.newcontact.address
                }
            ).then(function() {
                $scope.$parent.contacts.push({
                    'name': $scope.newcontact.name,
                    'phone': $scope.newcontact.phone,
                    'address': $scope.newcontact.address
                });
                console.log("New Contact Added");
                //$scope.$parent.addNewContactForm = false;
                $scope.newcontact.name = "";
                $scope.newcontact.phone = "";
                $scope.newcontact.address = "";
                $scope.$parent.getAllContacts();
                
            });
        } 

    $scope.updateContact = function() {
        if(!$scope.contact.address) {
            $scope.contact.address = "";
        }
        $http.put('http://newapp/api/contact/update.php', {
            'id': $scope.contact.id,
            'name': $scope.contact.name,
            'phone': $scope.contact.phone,
            'address': $scope.contact.address
        })
        .then(function () {
           console.log('Contact Updated');
           $scope.messages.info = "Contact updated";
           $location.path('/');
        });
    }


    $scope.deleteContact = function(id) {
        $http.delete('http://newapp/api/contact/delete.php?id=' + id)
        .then(function () {
            $scope.contacts.forEach(contact => {
                if(contact.id == id) {
                    $scope.contacts.splice($scope.contacts.indexOf(contact),1);
                }
            });
            console.log('Contact Deleted');
            $scope.getAllContacts();
           
        });
    }
}]);