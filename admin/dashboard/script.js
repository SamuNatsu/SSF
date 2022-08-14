$("#nav-btn-logout").click(function() {
	$.post(
		"?action=ssf:logout",
		{},
		function (r, s) {
			r = JSON.parse(r);
			window.location.href = r.href;
		}
	)
});
