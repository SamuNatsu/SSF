const validateSuccess = function(el) {
	el = "#validate-" + el;
	$(el).text(" ✔").css("color", "green");
}

const validateFail = function(el) {
	el = "#validate-" + el;
	$(el).text(" ✘").css("color", "red");
}

$("#form-password").blur(function() {
	let pass = $(this).val();
	if (!/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?\d)[A-Za-z\d@$!%*#?&-]{8,}$/.test(pass))
		validateFail("password");
	else 
		validateSuccess("password");
});

$("#form-submit").click(function() {
	$.post(
		"?action=ssf:install", 
		{"password": $("#form-password").val()})
		.done(function (r) {
			r = JSON.parse(r);
			if (r.status == "success") {
				alert('Done!\nNow jumping to login page...');
				window.location.href = r.href;
			}
			else 
				alert(r.msg);
		})
		.fail(function () {
			alert("Ajax error occurred");
		});
});
