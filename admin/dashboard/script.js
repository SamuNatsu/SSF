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

$("#form-email > div.modifiable-btn").click(function() {
	if ($(this).attr("activate") == "0") {
		$("#form-email").prepend('<input id="form-email-input" type="text" class="width-50"/>');
		$("#form-email-input").val($("#form-email-val").text());
		$("#form-email-val").remove();
		$(this).text("OK").attr("activate", "1");
	}
	else {
		$.post(
			"?action=ssf:modify_email",
			{"email":$("#form-email-input").val()},
			function (r, s) {
				if (s != "success") {
					alert("Ajax error occurred");
					return;
				}
				r = JSON.parse(r);
				if (r.status == "fail")
					alert("Fail: " + r.msg);
				else {
					$("#form-email").prepend('<div id="form-email-val">' + $("#form-email-input").val() + '</div>');
					$("#form-email-input").remove();
					$(this).text("Modify").attr("activate", "0");
					window.location.reload();
				}
			}
		);
	}
});
