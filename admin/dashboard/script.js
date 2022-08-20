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

$(".ssf-i-modify-field").each(function() {
	if ($(this).text().length == 0)
		$(this).attr("data-empty", "1");
});
$(".ssf-i-modify-btn").click(function() {
	let main = $(this).parent();
	let root = main.parent();
	let field = main.children(".ssf-i-modify-field");
	let key = field.attr("data-field");
	if (root.attr("data-active") == "0") {
		let oldval = field.text();
		if (field.attr("data-empty") === "1")
			oldval = "";
		field.prop("outerHTML", '<input class="ssf-i-modify-field width-50" type="text" value="' + oldval + '" data-field="' + key + '" data-old-val="' + oldval + '"/>');
		$(this).text("OK");
		root.attr("data-active", "1");
	}
	else {
		if (field.attr("data-old-val") == field.val()) {
			let b = field.attr("data-old-val").length;
			field.prop("outerHTML", '<div class="ssf-i-modify-field" data-field="' + key + '">' + field.val() + '</div>');
			if (b == 0)
				main.children(".ssf-i-modify-field").attr("data-empty", "1");
			$(this).text("Modify");
			root.attr("data-active", "0");
			return;
		}
		let query = {};
		query[key] = field.val();
		$.post("?action=" + $(this).attr("data-action"), query)
			.done(function(r) {
				r = JSON.parse(r);
				if (r.status == "fail")
					alert("Fail: " + r.msg);
				else {
					field.prop("outerHTML", '<div data-field="' + key + '">' + field.val() + '</div>');
					$(this).text("Modify");
					root.attr("data-active", "0");
					alert("Successfully modified");
				}
			})
			.fail(function() {
				alert("Ajax error occurred");
			});
	}
});
