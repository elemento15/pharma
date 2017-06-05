app.factory('CustomerService', ['$http', function($http) {
	return {
		get      : function (data) {
			return $http.get('customers/'+ data.id);
		},
		save     : function (data) {
			return (data.id) ? $http.patch('customers/'+ data.id, data) : $http.post('customers', data);
		},
		read     : function(data) {
			return $http.get('customers?'+ jQuery.param(data), data);
		},
		delete   : function(data) {
			return $http.delete('customers/'+ data.id);
		},
		activate : function(data) {
			return $http.post('customers/'+ data.id +'/activate');
		},
		deactivate : function(data) {
			return $http.post('customers/'+ data.id +'/deactivate');
		}
	} 
}]);

app.factory('VendorService', ['$http', function($http) {
	return {
		get      : function (data) {
			return $http.get('vendors/'+ data.id);
		},
		save     : function (data) {
			return (data.id) ? $http.patch('vendors/'+ data.id, data) : $http.post('vendors', data);
		},
		read     : function(data) {
			return $http.get('vendors?'+ jQuery.param(data), data);
		},
		delete   : function(data) {
			return $http.delete('vendors/'+ data.id);
		},
		activate : function(data) {
			return $http.post('vendors/'+ data.id +'/activate');
		},
		deactivate : function(data) {
			return $http.post('vendors/'+ data.id +'/deactivate');
		}
	}
}]);

app.factory('ProductService', ['$http', function($http) {
	return {
		get      : function (data) {
			return $http.get('products/'+ data.id);
		},
		save     : function (data) {
			return (data.id) ? $http.patch('products/'+ data.id, data) : $http.post('products', data);
		},
		read     : function(data) {
			return $http.get('products?'+ jQuery.param(data), data);
		},
		delete   : function(data) {
			return $http.delete('products/'+ data.id);
		},
		activate : function(data) {
			return $http.post('products/'+ data.id +'/activate');
		},
		deactivate : function(data) {
			return $http.post('products/'+ data.id +'/deactivate');
		}
	}
}]);