
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

Vue.component('example', require('./components/Example.vue'));

const app = new Vue({
    el: '#app'
});

$(document).ready(function(e) {

	$("form[ajax=true]").submit(function(e) {
		e.preventDefault();

		var token = $('#token').val();
		$.ajax({
			url: '/profile/update',
			type: 'PUT',
				data: {
					name:$('#name').val(),
					email:$('#email').val(),
					phone:$('#phone').val(),
					_token:token
				},
			success: function(){

			}
		});

	});

});
