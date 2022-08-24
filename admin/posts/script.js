/*! Posts script v0.0.1 */

ssf_NavBar.init();

$("#b-logout").click(function() {
	$.post("?action=ssf:logout")
		.done(function() {
			window.location.href = '/admin/';
		})
		.fail(function() {
			alert("Ajax error occurred");
		});
});
