const setWarning = function(el, str) {
	$("#warning-" + el).text(str);
};

const validatePassword = function(str) {
	setWarning("password", "");
	if (str.length < 6) {
		setWarning("password", "Password TOO short");
		return false;
	}
	if (!/\d/.test(str)) {
		setWarning("password", "Password MUST contains digit");
		return false;
	}
	if (!/[a-zA-Z]/.test(str)) {
		setWarning("password", "Password MUST contains letter");
		return false;
	}
	return true;
};

$("#btn-back").click(function() {
	window.location.href = "/";
});

const md5 = new Hashes.MD5();
const sha1 = new Hashes.SHA1();
$("#btn-login").click(function() {
	let pass = $("#form-password").val();
	if (!validatePassword(pass))
		return;
	pass = md5.hex(sha1.hex(pass));
	$.post(
		"?action=ssf:login",
		{"password": pass},
		function (r, s) {
			if (s != 'success') {
				setWarning("password", "Ajax error occurred");
				return;
			}
			r = JSON.parse(r);
			if (r.status == 'success')
				window.location.href = r.href;
			else {
				setWarning("password", r.msg);
				$("#form-password").focus();
			}
		}
	);
});
