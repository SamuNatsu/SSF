let passErrCnt = 0;
const setWarning = function(el, str) {
	++passErrCnt;
	if (passErrCnt > 1)
		str += " +" + (passErrCnt - 1);
	$("#warning-" + el).text(str);
};

$("#btn-back").click(function() {
	window.location.href = "/";
});

const md5 = new Hashes.MD5();
const sha1 = new Hashes.SHA1();
$("#btn-login").click(function() {
	let pass = $("#form-password").val();
	pass = md5.hex(sha1.hex(pass));
	$.post(
		"?action=ssf:login",
		{"password": pass})
		.done(function (r) {
			r = JSON.parse(r);
			if (r.status == 'success')
				window.location.href = r.href;
			else
				setWarning("password", r.msg);
		})
		.fail(function() {
			alert("Ajax error occurred");
		});
});
