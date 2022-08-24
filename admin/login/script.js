const md5 = new Hashes.MD5();
const sha1 = new Hashes.SHA1();

$("#b-back").click(function() {
	window.location.href = "/";
});

$("#b-login").click(function() {
	let pass = $("#i-password").val();
	pass = md5.hex(sha1.hex(pass));
	$.post("?action=ssf:login", {"password": pass})
		.done(function (r) {
			r = JSON.parse(r);
			if (r.status == "success")
				window.location.href = "?page=dashboard";
			else
				alert(r.msg);
		})
		.fail(function() {
			alert("Ajax error occurred");
		});
});
