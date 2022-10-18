'use strict';

let login = (function() {

	let mailControl = (method1, method2) => {
		const input = $(method1);
		const msg = $(method2);
		const validation = filterMail(method1);

		if (!validation) {
			input.removeClass("is-valid");
			input.addClass("is-invalid");
			msg.text("This email isn't valid!");
			return false;
		}

		if (validation) {
			input.addClass("is-valid");
			input.removeClass("is-invalid");
			msg.text("");
			return true;
		}
	}

	const passControl = (method1, method2) => {
		const input = $(method1);
		const msg = $(method2);

		let filter = filterLength(method1, 6);
		if (filter !== true) {
			input.removeClass("is-valid");
			input.addClass("is-invalid");
			msg.text(filter);
			return false;
		} else {
			input.addClass("is-valid");
			input.removeClass("is-invalid");
			msg.text("");
			return true;
		}
	}

	$("#input-email").keyup(function() {
		const input = $("#input-email");
		mailControl("#"+input.attr("id"), "#msg-"+input.attr("id"));
	});

	$("#turn-passwd").click(function() {
		showPasswd("input-password", this.id);
	});

	$("#login").click(function () {
		const btn = $("#login");
		const email = $("#input-email");
		const passwd = $("#input-password");
		let allow = true;

		if (!mailControl("#"+email.attr("id"), "#msg-"+email.attr("id"))) allow = false
		if (!passControl("#"+passwd.attr("id"), "#msg-"+passwd.attr("id"))) allow = false

		if (!allow) return false

		$(".air-badge").html(loadingBackdrop());
		btn.attr("disabled", true);
		email.attr("disabled", true);
		passwd.attr("disabled", true);

		const params = {
			'email': email.val().trim(),
			'password': passwd.val().trim(),
		};

		const executePost = {
			'data' : JEncrypt(JSON.stringify(params)),
		}

		const url = baseUrl("/auth/api/v1/login");

		const execute = postField(url, 'POST', executePost, false);

		execute.done(function(result) {
			let obj = JSON.parse(JSON.stringify(result));

			if (obj.code == 200) {
				$(".air-badge").html(airBadge(obj.msg , 'success'));
				setTimeout(function() {
					window.location = window.location.href;
				}, 5000);
			} else {
				$(".air-badge").html(airBadge(obj.msg , 'danger'));
				btn.attr("disabled", false);
				email.attr("disabled", false);
				passwd.attr("disabled", false);
			}
		});

		execute.fail(function() {
			btn.attr("disabled", false);
			email.attr("disabled", false);
			passwd.attr("disabled", false);
			$(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
		});
	});
});

let main = (function() {
	let isOn = $(".main-cls").attr("main") || false;

	if (isOn == "login") login();
})();