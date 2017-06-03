app.factory('CustomerService', ['$http', function($http) {
	return {
		get    : function (data) {
			return $http.get('customers/'+ data.id);
		},
		save   : function (data) {
			return (data.id) ? $http.patch('customers/'+ data.id, data) : $http.post('customers', data);
		},
		read   : function(data) {
			return $http.get('customers', data);
		},
		delete : function(data) {
			return $http.delete('customers/'+ data.id);
		}
	} 
}]);

app.factory('ProductService', ['$http', function($http) {
	return {
		get    : function (data) {
			return $http.post('products/get', data);
		},
		save   : function (data) {
			return $http.post('products/save', data);
		},
		read   : function(data) {
			return $http.post('products/read', data);
		},
		delete : function(data) {
			return $http.post('products/remove', data);
		}
	} 
}]);