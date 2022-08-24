ssf_NavBar.init();
ssf_InputModify.init();

$("#b-logout").click(function() {
	$.post("?action=ssf:logout")
		.done(function() {
			window.location.href = '/admin/';
		})
		.fail(function() {
			alert("Ajax error occurred");
		});
});

$("#b-clear-history").click(function() {
	if (!confirm("Sure to clear login history?"))
		return;
	$.post(
		"?action=ssf:clear_history",
		{},
		function (r) {
			r = JSON.parse(r);
			alert("Done");
			window.location.href = window.location.href;
		}
	);
});
