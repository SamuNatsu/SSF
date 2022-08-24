const ssf_NavBar = {
	init: function() {
		$(".nav-item").click(function() {
			if ($(this).hasClass("nav-item-disabled") || typeof $(this).attr("data-href") === "undefined")
				return;
			window.location.href = "?page=" + $(this).attr("data-href");
		});
	}
};

const ssf_InputModify = {
	setEmptyAttr: function() {
		// Set empty attribute for each empty fields
		$(".ssf-i-modify-field").each(function() {
			if ($(this).text().length === 0)
				$(this).attr("data-empty", "1");
		});
	},
	activate: function(root, field, btn) {
		let oldval = field.text();
		field.prop("outerHTML", '<input class="ssf-i-modify-field width-50" type="text" value="' + oldval + '"/>');
		btn.text("OK");
		root.attr("data-old-val", oldval);
		root.attr("data-active", "1");
	},
	restore: function(root, field, btn) {
		field.prop("outerHTML", '<div class="ssf-i-modify-field">' + field.val() + '</div>');
		btn.text("Modify");
		ssf_InputModify.setEmptyAttr();
		root.attr("data-active", "0");
	},
	deactivate: function(root, field, btn) {
		if (root.attr("data-old-val") === field.val()) {
			ssf_InputModify.restore(root, field, btn);
			return;
		}
		// Post data
		$.post("?action=" + root.attr("data-action"), {"data": field.val()})
			.done(function(r) {
				r = JSON.parse(r);
				if (r.status === "fail")
					alert("Fail to modify\n" + r.msg);
				else {
					ssf_InputModify.restore(root, field, btn);
					let msg = "Successfully modified";
					if (typeof r.msg !== "undefined")
						msg += "\n" + r.msg;
					alert(msg);
				}
			})
			.fail(function() {
				alert("Ajax error occurred");
			});
	},
	init: function() {
		ssf_InputModify.setEmptyAttr();
		// Bind event
		$(".ssf-i-modify-btn").click(function() {
			let root = $(this).parent().parent();
			let field = $(this).parent().children(".ssf-i-modify-field");
			let btn = $(this);
			if (root.attr("data-active") === "1")
				ssf_InputModify.deactivate(root, field, btn);
			else 
				ssf_InputModify.activate(root, field, btn);
		});
	}
};
