'use strict';

let profile = (function () {
	let newFileCandidate = null;
	let changeFileCandidate = null;
	let newAvatar = null;
	let changeAvatar = null;
	let fileInput = null;
	let myFile = null;
	let image = document.getElementById('image-cropper');
	let thumbnail = null;
	let fileName = null;
	let modalCropper = $("#modal-crop-image");
	let cropper = null;
	let TypeAction = null;
	let saveFile = null;
	let options = {
		// aspectRatio: 1,
		// viewMode: 3,
		dragMode: 'move',
		aspectRatio: 1,
		autoCropArea: 1,
		restore: false,
		guides: false,
		center: true,
		highlight: true,
		cropBoxMovable: false,
		cropBoxResizable: false,
		toggleDragModeOnDblclick: false,

		ready: function (e) {
			console.log(e.type);
		},

		cropstart: function (e) {
			console.log(e.type, e.detail.action);
		},
		cropmove: function (e) {
			console.log(e.type, e.detail.action);
		},
		cropend: function (e) {
			console.log(e.type, e.detail.action);
		},
		zoom: function (e) {
			console.log(e.type, e.detail.ratio);
		},
		crop: function (e) {
			console.log(e.detail);
		},
	};

	let inputPassword = (method1, method2, method3) => {
		let password = $(method1);
		let msgPassword = $(method2);
		let confirm = $(method3);

		let filter = filterPass(method1, 8);

		if (!filter.status) {
			password.attr("class", "form-control is-invalid");
			msgPassword.text(filter.msg);
			return false;
		}

		if (filter.status) {

			if (confirm.val().trim().length >= 1) {
				if (password.val().trim() == confirm.val().trim()) {
					password.attr("class", "form-control is-valid");
					confirm.attr("class", "form-control is-valid");
					msgPassword.text("");
					return true;
				}

				if (password.val().trim() !== confirm.val().trim()) {
					password.attr("class", "form-control is-invalid");
					confirm.attr("class", "form-control is-invalid");
					msgPassword.text("This password is not sync!");
					return false;
				}
			}

			if (confirm.val().trim().length <= 0) {
				password.attr("class", "form-control is-valid");
				msgPassword.text("");
				return true;
			}
		}
	}

	let confirmPassowrd = (method1, method2, method3) => {
		let password = $(method1);
		let msgPassword = $(method2);
		let confirm = $(method3);

		let fPass = filterPass(method1, 8);

		if (!fPass.status) {
			password.attr("class", "form-control is-invalid");
			msgPassword.text(fPass.msg);
			return false;
		}

		if (fPass.status) {
			if (password.val().trim() == confirm.val().trim()) {
				password.attr("class", "form-control is-valid");
				confirm.attr("class", "form-control is-valid");
				msgPassword.text("");
				return true;
			}

			if (password.val().trim() !== confirm.val().trim()) {
				password.attr("class", "form-control is-invalid");
				confirm.attr("class", "form-control is-invalid");
				msgPassword.text("Password is not sync!");
				return false;
			}
		}
	}

	const newPasswd = (method1, method2, method3) => {
		const input = $(method1);
		const msg = $(method2);

		let filter = filterPass(method1, 6);
		
		if (filter.status) {
			msg.text('');
			input.addClass("is-valid");
			input.removeClass("is-invalid");
		}

		if (!filter.status) {
			msg.text(filter.msg);
			input.removeClass("is-valid");
			input.addClass("is-invalid");
		}

		return filter.status ? true:false;
	}

	let inputName = (method1, method2) => {
		let input = $(method1);
		let msg = $(method2);

		let filter = filterChar(input, [" "], 3);
		if (filter.status) {
			msg.text('');
			input.attr('class', 'form-control is-valid');
		}

		if (!filter.status) {
			msg.text(filter.msg);
			input.attr('class', 'form-control is-invalid');
		}

		return filter.status ? true:false;
	}

	const filterImage = (method1, method2, fname) => {
		let input = $(method1);
		let msg = $(method2);
		let _fname = $(fname);

		if (input && input.prop('files').length == 1) {
			msg.text('');
			input.removeClass('is-invalid');
			input.addClass('is-valid');
			return true;
		}

		if (!method1 || !input.prop('files').length == 1) {
			msg.text("Please choose a image!");
			_fname.text("Choose a image");
			input.removeClass('is-valid');
			input.addClass('is-invalid');
			return false;
		}
	}

	$("#turn-input-password").click(function() {
		showPasswd("input-password", this.id);
	});

	$("#turn-input-new-password").click(function() {
		multiShowPasswd("input-new-password", "input-new-confirm-password", this.id);
	});

	$("#switch-pass").change(function() {
		const turnPass = $("#switch-pass");
		const password = $("#input-password");
		const newPassword = $("#input-new-password");
		const confPassword = $("#input-new-confirm-password");

		if (turnPass.prop("checked")) {
			password.attr("disabled", false);
			newPassword.attr("disabled", false);
			confPassword.attr("disabled", false);
		}
		if (!turnPass.prop("checked")) {
			password.attr("disabled", true);
			newPassword.attr("disabled", true);
			confPassword.attr("disabled", true);
		}
	});

	$("#input-name").keyup(function() {
		inputName("#"+this.id, "#msg-"+this.id);
	});

	$("#input-password").keyup(function () {
		newPasswd("#"+this.id, "#msg-"+this.id);
	});

	$("#input-new-password").keyup(function () {
		const password = $("#input-password");
		const newPassword = $("#input-new-password");
		const confPassword = $("#input-new-confirm-password");

		inputPassword("#"+newPassword.attr("id"), "#msg-"+newPassword.attr("id"), "#"+confPassword.attr("id"));
	});

	$("#input-new-confirm-password").keyup(function () {
		const password = $("#input-password");
		const newPassword = $("#input-new-password");
		const confPassword = $("#input-new-confirm-password");

		confirmPassowrd("#"+newPassword.attr("id"), "#msg-"+newPassword.attr("id"), "#"+confPassword.attr("id"));
	});

	$("#turn-image").click(function() {
		let turn = $("#turn-image");
		let label = $("#label-turn-image");
		let change = $("#change-choose-image");
		let msg = $("#msg-change-choose-image");

		if (turn.prop('checked')) {
			// label.text("Disabled change image");
			change.addClass("custom-input-file--2");
			change.attr("disabled", false);
			if (fileName) fileName.text("Choose a image");
		} else {
			// label.text("Enable change image");
			change.removeClass("is-invalid");
			change.removeClass("custom-input-file--2");
			msg.text("");
			change.attr("disabled", true);
			change.val("");
		}
	});

	$("#change-choose-image").click(function() {
		const choose = $(this);
		TypeAction = choose.attr("data-choose");
		fileInput = choose;

		if (TypeAction == "new") {
			fileName = $(".new-file-name");
			thumbnail = $("#new-img-thumbnail");
		}

		if (TypeAction == "change") {
			fileName = $(".change-file-name");
			thumbnail = $("#change-img-thumbnail");
		}

		fileName.text("Choose a image");
		fileInput.val("");
	});

	$("#change-choose-image").change(function() {
		myFile = fileInput.prop('files')[0];
		let cropImage = $("#image-cropper");
		let modal = $('#modal-crop-image');

		fileName.text("Choose a image");

		if (imgExtension(myFile) == false ) {
			$(".air-badge").html(airBadge("The file must be an image!" , 'danger'));
			return false;
		}

		const reader = new FileReader();
		reader.onload = function() {

			const img = new Image;
			img.onload = function() {
				if (img.width > 5000 && img.height > 5000) {
					fileInput.val("");
					$(".air-badge").html(airBadge("Upload JPG or PNG image. 5000 x 5000 required!" , 'danger'));
				}
				cropImage.attr('src', reader.result);

				if (cropper) {
					cropper.destroy();
					cropper = null;
				}

				modal.modal('show');
			};

			img.onerror = function() {
				fileInput.val("");
				$(".air-badge").html(airBadge("Malicious files detected!" , 'danger'));
			};
			img.src = reader.result;
		}
		reader.readAsDataURL(myFile);
	});

	$("#rotate-l").click(function() {
		cropper.rotate(-90);
	});

	$("#rotate-r").click(function() {
		cropper.rotate(90);
	});

	$("#scale-l-r").click(function() {
		let dataScale = this.getAttribute('data-scale');

		if (this.getAttribute('data-scale') == "true") {
			cropper.scale(-1, 1);
			this.setAttribute('data-scale', false);
		} else {
			cropper.scale(1, 1);
			this.setAttribute('data-scale', true);
		}
	});

	$("#crop-image").click(function() {
		let finish = cropper.getCroppedCanvas({
			width: 1500,
			height: 1500,
			minWidth: 1000,
			minHeight: 1000,
			maxWidth: 1500,
			maxHeight: 1500,
			imageSmoothingEnabled: false,
			imageSmoothingQuality: 'high',
		});

		let blobBin = atob(finish.toDataURL().split(',')[1]);
		let array = [];
		for(let i = 0; i < blobBin.length; i++) {
			array.push(blobBin.charCodeAt(i));
		}
		let avatarFile = new Blob([new Uint8Array(array)], {type: 'image/png'});

		fileName.text(myFile.name);
		thumbnail.attr("src", finish.toDataURL());
		modalCropper.modal("hide");

		if (TypeAction == "new") {
			newFileCandidate = fileInput;
			newAvatar = avatarFile;
		}

		if (TypeAction == "change") {
			changeFileCandidate = fileInput;
			changeAvatar = avatarFile;
		}
	});

	modalCropper.on('shown.bs.modal', function () {
		cropper = new Cropper(image, options);
	});

	$("#save-account").click(function() {
		const name = $("#input-name");
		const turnPass = $("#switch-pass");
		const password = $("#input-password");
		const newPassword = $("#input-new-password");
		const confPassword = $("#input-new-confirm-password");
		const button = $("#save-account");
		const turnImage = $("#turn-image");
		const changeImage = $("#change-choose-image");
		const nameFile = $(".change-file-name");
		let allow = true;
		let onFile = null;
		let formData = null;

		if (!inputName("#"+name.attr('id'), "#msg-"+name.attr('id'))) allow =false;
		if (turnPass.prop("checked")) {
			if (!newPasswd("#"+password.attr('id'), "#msg-"+password.attr('id'))) allow =false;
			if (!inputPassword("#"+newPassword.attr("id"), "#msg-"+newPassword.attr("id"), "#"+confPassword.attr("id"))) allow =false;
			if (!confirmPassowrd("#"+newPassword.attr("id"), "#msg-"+newPassword.attr("id"), "#"+confPassword.attr("id"))) allow =false;
		}
		if (turnImage.prop("checked")) {
			if (!filterImage("#"+changeImage.attr("id"), "#msg-"+changeImage.attr("id"), "."+nameFile.attr("class"))) allow = false;
			if (!changeFileCandidate || !changeFileCandidate.prop('files').length == 1) {
				$("#msg-"+changeImage.attr("id")).text("Please choose a image!");
				nameFile.text("Choose a image");
				changeImage.removeClass('is-valid');
				changeImage.addClass('is-invalid');
				allow = false;
			}
		}

		if (!allow) return false;

		$(".air-badge").html(loadingBackdropSecond());
		name.attr("disabled", true);
		turnPass.attr("disabled", true);
		if (turnPass.prop("checked")) {
			password.attr("disabled", true);
			newPassword.attr("disabled", true);
			confPassword.attr("disabled", true);
		}
		turnImage.attr("disabled", true);
		if (turnImage.prop("checked")) {
			changeImage.attr("disabled", true);
		}
		button.attr("disabled", true);

		let params = {
			'name': name.val().trim(),
		};

		if (turnPass.prop("checked")) {
			params = {
				'name': name.val().trim(),
				'on-password': turnPass.prop("checked"),
				'old-password': password.val().trim(),
				'new-password': newPassword.val().trim(),
				'confirm-new-password': confPassword.val().trim(),
			};
		}

		if (turnImage.prop("checked")) {
			params['on-image'] = turnImage.prop("checked");
			formData = new FormData();
			formData.append('data', JEncrypt(JSON.stringify(params)));
			formData.append('original-avatar', changeFileCandidate.prop('files')[0]);
			formData.append('avatar', changeAvatar, changeFileCandidate.prop('files')[0].name);
			onFile = true;
		} else {
			formData = {
				'data' : JEncrypt(JSON.stringify(params)),
			}
			onFile = false;
		}

		const url = baseUrl("/auth/api/v1/setprofile");
		const execute = postField(url, 'POST', formData, false, onFile);

		execute.done(function(result) {
			let obj = JSON.parse(JSON.stringify(result));

			if (obj.code == 200) {
				$(".air-badge").html(airBadge(obj.msg , 'success'));
				setTimeout(function() {
					window.location = baseUrl("/dashboard/profile");
				}, 5000);
			} else {
				$(".air-badge").html(airBadge(obj.msg , 'danger'));
				name.attr("disabled", false);
				turnPass.attr("disabled", false);
				if (turnPass.prop("checked")) {
					password.attr("disabled", false);
					newPassword.attr("disabled", false);
					confPassword.attr("disabled", false);
				}
				turnImage.attr("disabled", false);
				if (turnImage.prop("checked")) {
					changeImage.attr("disabled", false);
				}
				button.attr("disabled", false);
			}
		});

		execute.fail(function() {
			name.attr("disabled", false);
			turnPass.attr("disabled", false);
			if (turnPass.prop("checked")) {
				password.attr("disabled", false);
				newPassword.attr("disabled", false);
				confPassword.attr("disabled", false);
			}
			turnImage.attr("disabled", false);
			if (turnImage.prop("checked")) {
				changeImage.attr("disabled", false);
			}
			button.attr("disabled", false);
			$(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
		});
	});
});

let usersManagement = (function () {
	
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

	let inputName = (method1, method2) => {
		let input = $(method1);
		let msg = $(method2);

		let filter = filterChar(input, [" "], 3);
		if (filter.status) {
			msg.text('');
			input.addClass("is-valid");
			input.removeClass("is-invalid");
		}

		if (!filter.status) {
			msg.text(filter.msg);
			input.removeClass("is-valid");
			input.addClass("is-invalid");
		}

		return filter.status ? true:false;
	}

	let inputPassword = (method1, method2, method3) => {
		let password = $(method1);
		let msgPassword = $(method2);
		let confirm = $(method3);

		let filter = filterPass(method1, 8);

		if (!filter.status) {
			password.attr("class", "form-control is-invalid");
			msgPassword.text(filter.msg);
			return false;
		}

		if (filter.status) {

			if (confirm.val().trim().length >= 1) {
				if (password.val().trim() == confirm.val().trim()) {
					password.attr("class", "form-control is-valid");
					confirm.attr("class", "form-control is-valid");
					msgPassword.text("");
					return true;
				}

				if (password.val().trim() !== confirm.val().trim()) {
					password.attr("class", "form-control is-invalid");
					confirm.attr("class", "form-control is-invalid");
					msgPassword.text("This password is not sync!");
					return false;
				}
			}

			if (confirm.val().trim().length <= 0) {
				password.attr("class", "form-control is-valid");
				msgPassword.text("");
				return true;
			}
		}
	}

	let confirmPassowrd = (method1, method2, method3) => {
		let password = $(method1);
		let msgPassword = $(method2);
		let confirm = $(method3);

		let fPass = filterPass(method1, 8);

		if (!fPass.status) {
			password.attr("class", "form-control is-invalid");
			msgPassword.text(fPass.msg);
			return false;
		}

		if (fPass.status) {
			if (password.val().trim() == confirm.val().trim()) {
				password.attr("class", "form-control is-valid");
				confirm.attr("class", "form-control is-valid");
				msgPassword.text("");
				return true;
			}

			if (password.val().trim() !== confirm.val().trim()) {
				password.attr("class", "form-control is-invalid");
				confirm.attr("class", "form-control is-invalid");
				msgPassword.text("Password is not sync!");
				return false;
			}
		}
	}

	$("#input-new-name-user").keyup(function() {
		inputName("#"+this.id, "#msg-"+this.id);
	});

	$("#input-new-email-user").keyup(function() {
		mailControl("#"+this.id, "#msg-"+this.id);
	});

	$("#input-new-password-user").keyup(function () {
		const newPassword = $("#input-new-password-user");
		const confPassword = $("#input-new-confirm-password-user");

		inputPassword("#"+newPassword.attr("id"), "#msg-"+newPassword.attr("id"), "#"+confPassword.attr("id"));
	});

	$("#input-new-confirm-password-user").keyup(function () {
		const newPassword = $("#input-new-password-user");
		const confPassword = $("#input-new-confirm-password-user");

		confirmPassowrd("#"+newPassword.attr("id"), "#msg-"+newPassword.attr("id"), "#"+confPassword.attr("id"));
	});

	$('[id^="open-disab-user"]').click(function() {
		const myData = $(this);
		const myName = $("#name-"+myData.attr("data-info"));
		const name = $(".info-disab-user");
		const data = $("#save-disab-user");

		name.text(myName.text());
		data.attr("data-info", myData.attr("data-info"));
	});

	$('[id^="open-enab-user"]').click(function() {
		const myData = $(this);
		const myName = $("#name-"+myData.attr("data-info"));
		const name = $(".info-enab-user");
		const data = $("#save-enab-user");

		name.text(myName.text());
		data.attr("data-info", myData.attr("data-info"));
	});

	$('[id^="open-delete-user"]').click(function() {
		const myData = $(this);
		const myName = $("#name-"+myData.attr("data-info"));
		const name = $(".info-delete-user");
		const data = $("#save-delete-user");

		name.text(myName.text());
		data.attr("data-info", myData.attr("data-info"));
	});

	$("#save-enab-user").click(function() {
		const modal = $("#modal-enable-user");
		const button = $("#save-enab-user");
		let allow = true;

		if (button.attr("data-info").trim().length !== 5) allow = false;

		if (!allow) return false;

		modal.modal('hide');
		$(".air-badge").html(loadingBackdropSecond());
		button.attr("disabled", true);

		const params = {
			'info': button.attr("data-info").trim(),
		};

		const executePost = {
			'data' : JEncrypt(JSON.stringify(params)),
		}

		const url = baseUrl("/auth/api/v1/enableuser");

		const execute = postField(url, 'POST', executePost, false);

		execute.done(function(result) {
			let obj = JSON.parse(JSON.stringify(result));

			if (obj.code == 200) {
				$(".air-badge").html(airBadge(obj.msg , 'success'));
				setTimeout(function() {
					window.location = baseUrl("/dashboard/users-management");
				}, 5000);
			} else {
				$(".air-badge").html(airBadge(obj.msg , 'danger'));
				button.attr("disabled", false);
			}
		});

		execute.fail(function() {
			button.attr("disabled", false);
			$(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
		});
	})

	$("#save-disab-user").click(function() {
		const modal = $("#modal-disab-user");
		const button = $("#save-disab-user");
		let allow = true;

		if (button.attr("data-info").trim().length !== 5) allow = false;

		if (!allow) return false;

		modal.modal('hide');
		$(".air-badge").html(loadingBackdropSecond());
		button.attr("disabled", true);

		const params = {
			'info': button.attr("data-info").trim(),
		};

		const executePost = {
			'data' : JEncrypt(JSON.stringify(params)),
		}

		const url = baseUrl("/auth/api/v1/disableuser");

		const execute = postField(url, 'POST', executePost, false);

		execute.done(function(result) {
			let obj = JSON.parse(JSON.stringify(result));

			if (obj.code == 200) {
				$(".air-badge").html(airBadge(obj.msg , 'success'));
				setTimeout(function() {
					window.location = baseUrl("/dashboard/users-management");
				}, 5000);
			} else {
				$(".air-badge").html(airBadge(obj.msg , 'danger'));
				button.attr("disabled", false);
			}
		});

		execute.fail(function() {
			button.attr("disabled", false);
			$(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
		});
	})

	$("#save-delete-user").click(function() {
		const modal = $("#modal-delete-user");
		const button = $("#save-delete-user");
		let allow = true;

		if (button.attr("data-info").trim().length !== 5) allow = false;

		if (!allow) return false;

		modal.modal('hide');
		$(".air-badge").html(loadingBackdropSecond());
		button.attr("disabled", true);

		const params = {
			'info': button.attr("data-info").trim(),
		};

		const executePost = {
			'data' : JEncrypt(JSON.stringify(params)),
		}

		const url = baseUrl("/auth/api/v1/deleteuser");

		const execute = postField(url, 'POST', executePost, false);

		execute.done(function(result) {
			let obj = JSON.parse(JSON.stringify(result));

			if (obj.code == 200) {
				$(".air-badge").html(airBadge(obj.msg , 'success'));
				setTimeout(function() {
					window.location = baseUrl("/dashboard/users-management");
				}, 5000);
			} else {
				$(".air-badge").html(airBadge(obj.msg , 'danger'));
				button.attr("disabled", false);
			}
		});

		execute.fail(function() {
			button.attr("disabled", false);
			$(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
		});
	})

	$("#add-new-user").click(function() {
		const name = $("#input-new-name-user");
		const email = $("#input-new-email-user");
		const password = $("#input-new-password-user");
		const confPassword = $("#input-new-confirm-password-user");
		const button = $("#add-new-user");
		const modal = $("#modal-add-new-user");
		let allow = true;

		if (!inputName("#"+name.attr('id'), "#msg-"+name.attr('id'))) allow = false;
		if (!mailControl("#"+email.attr('id'), "#msg-"+email.attr('id'))) allow = false;
		if (!inputPassword("#"+password.attr("id"), "#msg-"+password.attr("id"), "#"+confPassword.attr("id"))) allow =false;
		if (!confirmPassowrd("#"+password.attr("id"), "#msg-"+password.attr("id"), "#"+confPassword.attr("id"))) allow =false;

		if (!allow) return false;

		$(".air-badge").html(loadingBackdropSecond());
		modal.modal('hide');
		name.attr("disabled", true);
		email.attr("disabled", true);
		password.attr("disabled", true);
		confPassword.attr("disabled", true);
		button.attr("disabled", true);

		const params = {
			'name': name.val().trim(),
			'email': email.val().trim(),
			'password': password.val().trim(),
			'confirm-password': confPassword.val().trim(),
		};

		const executePost = {
			'data' : JEncrypt(JSON.stringify(params)),
		}
		const url = baseUrl("/auth/api/v1/newuser");

		const execute = postField(url, 'POST', executePost, false);
		execute.done(function(result) {
			let obj = JSON.parse(JSON.stringify(result));

			if (obj.code == 200) {
				$(".air-badge").html(airBadge(obj.msg , 'success'));
				setTimeout(function() {
					window.location = baseUrl("/dashboard/users-management");
				}, 5000);
			} else {
				$(".air-badge").html(airBadge(obj.msg , 'danger'));
				name.attr("disabled", false);
				email.attr("disabled", false);
				password.attr("disabled", false);
				confPassword.attr("disabled", false);
				button.attr("disabled", false);
			}
		});

		execute.fail(function() {
			name.attr("disabled", false);
			email.attr("disabled", false);
			password.attr("disabled", false);
			confPassword.attr("disabled", false);
			button.attr("disabled", false);
			$(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
		});
	});
});

let webSettings = (function () {

	let newFileCandidate = null;
	let changeFileCandidate = null;
	let newAvatar = null;
	let changeAvatar = null;
	let fileInput = null;
	let myFile = null;
	let image = document.getElementById('image-cropper');
	let thumbnail = null;
	let fileName = null;
	let modalCropper = $("#modal-crop-image");
	let cropper = null;
	let TypeAction = null;
	let saveFile = null;
	let options = {
		// aspectRatio: 1,
		// viewMode: 3,
		dragMode: 'move',
		aspectRatio: 1,
		autoCropArea: 1,
		restore: false,
		guides: false,
		center: true,
		highlight: true,
		cropBoxMovable: false,
		cropBoxResizable: false,
		toggleDragModeOnDblclick: false,

		ready: function (e) {
			console.log(e.type);
		},

		cropstart: function (e) {
			console.log(e.type, e.detail.action);
		},
		cropmove: function (e) {
			console.log(e.type, e.detail.action);
		},
		cropend: function (e) {
			console.log(e.type, e.detail.action);
		},
		zoom: function (e) {
			console.log(e.type, e.detail.ratio);
		},
		crop: function (e) {
			console.log(e.detail);
		},
	};

	const passControl = (method1, method2) => {
		const input = $(method1);
		const msg = $(method2);

		let filter = filterLength(method1, 3);
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

	const filterImage = (method1, method2, fname) => {
		let input = $(method1);
		let msg = $(method2);
		let _fname = $(fname);

		if (input && input.prop('files').length == 1) {
			msg.text('');
			input.removeClass('is-invalid');
			input.addClass('is-valid');
			return true;
		}

		if (!method1 || !input.prop('files').length == 1) {
			msg.text("Please choose a image!");
			_fname.text("Choose a image");
			input.removeClass('is-valid');
			input.addClass('is-invalid');
			return false;
		}
	}
	$("#turn-image").click(function() {
		let turn = $("#turn-image");
		let label = $("#label-turn-image");
		let change = $("#change-choose-image");
		let msg = $("#msg-change-choose-image");

		if (turn.prop('checked')) {
			// label.text("Disabled change image");
			change.addClass("custom-input-file--2");
			change.attr("disabled", false);
			if (fileName) fileName.text("Choose a image");
		} else {
			// label.text("Enable change image");
			change.removeClass("is-invalid");
			change.removeClass("custom-input-file--2");
			msg.text("");
			change.attr("disabled", true);
			change.val("");
		}
	});

	$("#change-choose-image").click(function() {
		const choose = $(this);
		TypeAction = choose.attr("data-choose");
		fileInput = choose;

		if (TypeAction == "new") {
			fileName = $(".new-file-name");
			thumbnail = $("#new-img-thumbnail");
		}

		if (TypeAction == "change") {
			fileName = $(".change-file-name");
			thumbnail = $("#change-img-thumbnail");
		}

		fileName.text("Choose a image");
		fileInput.val("");
	});

	$("#change-choose-image").change(function() {
		myFile = fileInput.prop('files')[0];
		let cropImage = $("#image-cropper");
		let modal = $('#modal-crop-image');

		fileName.text("Choose a image");

		if (imgExtension(myFile) == false ) {
			$(".air-badge").html(airBadge("The file must be an image!" , 'danger'));
			return false;
		}

		const reader = new FileReader();
		reader.onload = function() {

			const img = new Image;
			img.onload = function() {
				if (img.width > 5000 && img.height > 5000) {
					fileInput.val("");
					$(".air-badge").html(airBadge("Upload JPG or PNG image. 5000 x 5000 required!" , 'danger'));
				}
				cropImage.attr('src', reader.result);

				if (cropper) {
					cropper.destroy();
					cropper = null;
				}

				modal.modal('show');
			};

			img.onerror = function() {
				fileInput.val("");
				$(".air-badge").html(airBadge("Malicious files detected!" , 'danger'));
			};
			img.src = reader.result;
		}
		reader.readAsDataURL(myFile);
	});

	$("#rotate-l").click(function() {
		cropper.rotate(-90);
	});

	$("#rotate-r").click(function() {
		cropper.rotate(90);
	});

	$("#scale-l-r").click(function() {
		let dataScale = this.getAttribute('data-scale');

		if (this.getAttribute('data-scale') == "true") {
			cropper.scale(-1, 1);
			this.setAttribute('data-scale', false);
		} else {
			cropper.scale(1, 1);
			this.setAttribute('data-scale', true);
		}
	});

	$("#crop-image").click(function() {
		let finish = cropper.getCroppedCanvas({
			width: 1500,
			height: 1500,
			minWidth: 1000,
			minHeight: 1000,
			maxWidth: 1500,
			maxHeight: 1500,
			imageSmoothingEnabled: false,
			imageSmoothingQuality: 'high',
		});

		let blobBin = atob(finish.toDataURL().split(',')[1]);
		let array = [];
		for(let i = 0; i < blobBin.length; i++) {
			array.push(blobBin.charCodeAt(i));
		}
		let avatarFile = new Blob([new Uint8Array(array)], {type: 'image/png'});

		fileName.text(myFile.name);
		thumbnail.attr("src", finish.toDataURL());
		modalCropper.modal("hide");

		if (TypeAction == "new") {
			newFileCandidate = fileInput;
			newAvatar = avatarFile;
		}

		if (TypeAction == "change") {
			changeFileCandidate = fileInput;
			changeAvatar = avatarFile;
		}
	});

	modalCropper.on('shown.bs.modal', function () {
		cropper = new Cropper(image, options);
	});

	$("#input-web-title, #input-web-brand, #input-web-desc").keyup(function () {
		passControl("#"+this.id, "#msg-"+this.id);
	});

	$("#save-input-web").click(function () {
		const title = $("#input-web-title");
		const brand = $("#input-web-brand");
		const desc = $("#input-web-desc");
		const button = $("#save-input-web");
		const turnImage = $("#turn-image");
		const changeImage = $("#change-choose-image");
		const nameFile = $(".change-file-name");
		let allow = true;
		let onFile = null;
		let formData = null;

		if (!passControl("#"+title.attr('id'), "#msg-"+title.attr('id'))) allow = false;
		if (!passControl("#"+brand.attr('id'), "#msg-"+brand.attr('id'))) allow = false;
		if (!passControl("#"+desc.attr('id'), "#msg-"+desc.attr('id'))) allow = false;
		if (turnImage.prop("checked")) {
			if (!filterImage("#"+changeImage.attr("id"), "#msg-"+changeImage.attr("id"), "."+nameFile.attr("class"))) allow = false;
			if (!changeFileCandidate || !changeFileCandidate.prop('files').length == 1) {
				$("#msg-"+changeImage.attr("id")).text("Please choose a image!");
				nameFile.text("Choose a image");
				changeImage.removeClass('is-valid');
				changeImage.addClass('is-invalid');
				allow = false;
			}
		}

		if (!allow) return false;

		$(".air-badge").html(loadingBackdropSecond());
		title.attr("disabled", true);
		brand.attr("disabled", true);
		desc.attr("disabled", true);
		turnImage.attr("disabled", true);
		if (turnImage.prop("checked")) {
			changeImage.attr("disabled", true);
		}
		button.attr("disabled", true);

		let params = {
			'title': title.val().trim(),
			'brand': brand.val().trim(),
			'desc': desc.val().trim(),
		};

		if (turnImage.prop("checked")) {
			params['on-image'] = turnImage.prop("checked");
			formData = new FormData();
			formData.append('data', JEncrypt(JSON.stringify(params)));
			formData.append('original-logo', changeFileCandidate.prop('files')[0]);
			formData.append('avatar', changeAvatar, changeFileCandidate.prop('files')[0].name);
			onFile = true;
		} else {
			formData = {
				'data' : JEncrypt(JSON.stringify(params)),
			}
			onFile = false;
		}

		const url = baseUrl("/auth/api/v1/setHeader");
		const execute = postField(url, 'POST', formData, false, onFile);

		execute.done(function(result) {
			let obj = JSON.parse(JSON.stringify(result));

			if (obj.code == 200) {
				$(".air-badge").html(airBadge(obj.msg , 'success'));
				setTimeout(function() {
					window.location = baseUrl("/dashboard/web-settings");
				}, 5000);
			} else {
				$(".air-badge").html(airBadge(obj.msg , 'danger'));
				title.attr("disabled", false);
				brand.attr("disabled", false);
				desc.attr("disabled", false);
				turnImage.attr("disabled", false);
				if (turnImage.prop("checked")) {
					changeImage.attr("disabled", false);
				}
				button.attr("disabled", false);
			}
		});

		execute.fail(function() {
			title.attr("disabled", false);
			brand.attr("disabled", false);
			desc.attr("disabled", false);
			turnImage.attr("disabled", false);
			if (turnImage.prop("checked")) {
				changeImage.attr("disabled", false);
			}
			button.attr("disabled", false);
			$(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
		});
	});
});

let openForm = (function() {

	const filterInput = (method1, method2) => {
		let inputBox = $(method1);
		let msgBox = $(method2);

		if (inputBox.val().trim().length >= 1) {
			inputBox.removeClass("is-invalid");
			inputBox.addClass("is-valid");
			msgBox.text("");

			return true;
		} else {
			inputBox.removeClass("is-valid");
			inputBox.addClass("is-invalid");
			msgBox.text("Cannot be empty!");

			return false;
		}
	}

	const filterSelect = (method1, method2) => {
		let inputBox = $(method1);
		let msgBox = $(method2);

		if (inputBox.val() != null && inputBox.val().trim().length >= 1) {
			inputBox.removeClass("is-invalid");
			inputBox.addClass("is-valid");
			msgBox.text("");

			return true;
		} else {
			inputBox.removeClass("is-valid");
			inputBox.addClass("is-invalid");
			msgBox.text("Cannot be empty!");

			return false;
		}
	}

	const filterCode = (method1, method2, status=false, min=false, max=false, must=false) => {
		let inputBox = $(method1);
		let msgBox = $(method2);

		let filter = filterNumb(inputBox, status, min, max, must);

		if (!filter.status) {
			inputBox.removeClass("is-valid");
			inputBox.addClass("is-invalid");
			msgBox.text(filter.msg);
			return false;
		} else {
			inputBox.removeClass("is-invalid");
			inputBox.addClass("is-valid");
			msgBox.text("");
			return true;
		}
	}

	const filterName = (method1, method2) => {
		let inputBox = $(method1);
		let msgBox = $(method2);

		let filter = filterChar(inputBox, [" "], 3);

		if (filter.status) {
			inputBox.removeClass("is-invalid");
			inputBox.addClass("is-valid");
			msgBox.text('');
		}

		if (!filter.status) {
			inputBox.removeClass("is-valid");
			inputBox.addClass("is-invalid");
			msgBox.text(filter.msg);
		}

		return (filter.status == true) ? true:false;
	}

	$("#turn-column").click(function() {
		let clone = $("#clone");
		let totalClone = $('[id^="clone-column"]');
		$("#gz-form-total-guest").val((totalClone.length+1));

		let sc = `
            <div class="form-row mt-3 mt-lg-0" number="${totalClone.length}" id="clone-column">
                <div class="form-group col-lg-1 mb-0" id="default-checked">
                    <label class="d-lg-none">Checked</label>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input m-lg-2" number="${totalClone.length}" id="gu-form-checked-${totalClone.length}">
                        <label class="form-check-label" for="gu-form-checked-${totalClone.length}">
                            <span class="d-lg-none">Checked for delete column</span>
                        </label>
                    </div>
                </div>
                <div class="form-group col-lg-3" id="default-name">
                    <label class="d-lg-none">Name</label>
                    <input type="text" class="form-control" number="${totalClone.length}" id="gu-form-user-name" placeholder="Full name">
                    <div class="invalid-feedback" number="${totalClone.length}" id="msg-gu-form-user-name"></div>
                </div>
                <div class="form-group col-lg-2" id="default-checked">
                    <label class="d-lg-none">Identity</label>
                    <input type="text" class="form-control" number="${totalClone.length}" id="gu-form-user-identity" placeholder="Identity number">
                    <div class="invalid-feedback" number="${totalClone.length}" id="msg-gu-form-user-identity"></div>
                </div>
                <div class="form-group col-lg-2" id="default-temperature">
                    <label class="d-lg-none">Temperature</label>
                    <input type="text" class="form-control" number="${totalClone.length}" id="gu-form-user-temperature" placeholder="Temperature">
                    <div class="invalid-feedback" number="${totalClone.length}" id="msg-gu-form-user-temperature"></div>
                </div>
                <div class="form-group col-lg-2" id="default-vak">
                    <label class="d-lg-none">Antigen/Vaksin</label>
                    <input type="text" class="form-control" number="${totalClone.length}" id="gu-form-user-no-vak" placeholder="Antigen/Vaksin dosis">
                    <div class="invalid-feedback" number="${totalClone.length}" id="msg-gu-form-user-no-vak"></div>
                </div>
                <div class="form-group col-lg-2" id="default-card">
                    <label class="d-lg-none">Card number</label>
                    <input type="text" class="form-control" number="${totalClone.length}" id="gu-form-user-card" placeholder="Card number">
                    <div class="invalid-feedback" number="${totalClone.length}" id="msg-gu-form-user-card"></div>
                </div>
            </div>
		`;
		clone.append(sc);
		// clone.html(sc);
	});

	$("#burn-column").click(function () {
		const dv = $('[id^="clone-column"]');
		const checkbox = $('[id^="gu-form-checked"]');

		let number = false;

		for (let i = 0; i < checkbox.length; i++) {
			if (checkbox[i].checked) {
				number = checkbox[i].getAttribute('number');
				dv[i].remove();
			} else {
				checkbox[i].setAttribute("number", (i-1));
				dv[i].setAttribute("number", (i-1));
			}
		}

		$("#gz-form-total-guest").val(($('[id^="clone-column"]').length));

		if (!number) {
			$(".air-badge").html(airBadge("Please check the box", 'danger'));
		}
	});

	$("#gz-form-company, #gz-form-bussines, #gz-form-relation-other, #gz-form-area-other, #gz-form-pic-dept").keyup(function () {
		filterInput("#"+this.id, "#msg-"+this.id);
	});

	$("#gz-form-relation, #gz-form-area").change(function () {
		let other = $("#"+ this.id.split("-")[2] +"-other");
		let otherBox = $("#gz-form-"+ this.id.split("-")[2] +"-other");

		filterSelect("#"+this.id, "#msg-"+this.id);

		if (this.value.trim() == "OTHER") {
			other.removeClass("d-none");
			otherBox.attr("disabled", false);
		}

		if (this.value.trim() !== "OTHER") {
			other.addClass("d-none");
			otherBox.attr("disabled", true);
		}
	});

	$("#gz-form-pic-name").keyup(function() {
		filterName("#"+this.id, "#msg-"+this.id);
	});

	$("#gz-form-total-guest").keyup(function() {
		filterCode("#"+this.id, "#msg-"+this.id, true ,1, 3);
	});

	$("#gz-form-total-guest").keypress(function() {
		return allowNumberic(this);
	});

	$("#gz-agreement").change(function() {
		const picAg = $("#gz-agreement");
		const note = $("#note-agreement");
		const noteInput = $("#gz-form-pic-note");

		if (picAg.prop("checked")) {
			noteInput.attr("disabled", false);
			note.removeClass("d-none");
			$("#gz-form-pic-note").focus();
		}

		if (!picAg.prop("checked")) {
			noteInput.attr("disabled", true);
			note.addClass("d-none");
		}
	});

	// $('[id^="gu-form-user-name"]').keyup(function() {
	// 	const myData = $(this);
	// 	console.log($('[id^="gu-form-user-name"]'));
	// });

	$("#gz-form-save").click(function () {
		const btnCancel = $("#gz-form-cancel");
		const btn = $("#gz-form-save");
		const company = $("#gz-form-company");
		const relation = $("#gz-form-relation");
		const otherRelation = $("#gz-form-relation-other");
		const bussines = $("#gz-form-bussines");
		const area = $("#gz-form-area");
		const otherArea = $("#gz-form-area-other");
		const totalGuest = $("#gz-form-total-guest");
		const picName = $("#gz-form-pic-name");
		const picDept = $("#gz-form-pic-dept");
		const picAg = $("#gz-agreement");
		const picNote = $("#gz-form-pic-note");
		const guCheckBox = $('[id^="gu-form-checked"]');
		const guName = $('[id^="gu-form-user-name"]');
		const guIdentity = $('[id^="gu-form-user-identity"]');
		const guTemp = $('[id^="gu-form-user-temperature"]');
		const guVaksin = $('[id^="gu-form-user-no-vak"]');
		const guCard = $('[id^="gu-form-user-card"]');
		const turn = $('#turn-column');
		const burn = $('#burn-column');
		let allow = true;
		let GU = false;

		if (!filterInput("#"+company.attr('id') ,"#msg-"+company.attr('id'))) allow = false;
		if (!filterSelect("#"+relation.attr('id') ,"#msg-"+relation.attr('id'))) allow = false;
		if (relation.val() == "OTHER") if (!filterInput("#"+otherRelation.attr('id') ,"#msg-"+otherRelation.attr('id'))) allow = false;
		if (!filterInput("#"+bussines.attr('id') ,"#msg-"+bussines.attr('id'))) allow = false;
		if (!filterSelect("#"+area.attr('id') ,"#msg-"+area.attr('id'))) allow = false;
		if (area.val() == "OTHER") if (!filterInput("#"+otherArea.attr('id') ,"#msg-"+otherArea.attr('id'))) allow = false;
		if (!filterCode("#"+totalGuest.attr('id') ,"#msg-"+totalGuest.attr('id'), true ,1, 3)) allow = false;
		if (!filterName("#"+picName.attr('id') ,"#msg-"+picName.attr('id'))) allow = false;
		if (!filterInput("#"+picDept.attr('id') ,"#msg-"+picDept.attr('id'))) allow = false;
		if (picAg.prop("checked")) if (!filterInput("#"+picNote.attr('id') ,"#msg-"+picNote.attr('id'))) allow = false;
		for (let i = 0; i < guCheckBox.length; i++) {
			if (!filterName("input[id$='gu-form-user-name'][number='"+i+"']", "div[id$='msg-gu-form-user-name'][number='"+i+"']")) allow = false;
			if (!filterCode("input[id$='gu-form-user-identity'][number='"+i+"']", "div[id$='msg-gu-form-user-identity'][number='"+i+"']", true, false, false, 16)) allow = false;
			if (!filterCode("input[id$='gu-form-user-temperature'][number='"+i+"']", "div[id$='msg-gu-form-user-temperature'][number='"+i+"']", true, 1, 4)) allow = false;
			if (!filterInput("input[id$='gu-form-user-no-vak'][number='"+i+"']", "div[id$='msg-gu-form-user-no-vak'][number='"+i+"']")) allow = false;
			if (!filterInput("input[id$='gu-form-user-card'][number='"+i+"']", "div[id$='msg-gu-form-user-card'][number='"+i+"']")) allow = false;
			GU = true;
		}

		if (!GU) allow = false;
		if (!GU) $(".air-badge").html(airBadge("User cannot be empty, please add column", 'danger'));
		if (!allow) return false;

		$(".air-badge").html(loadingBackdrop());
		btnCancel.attr("disabled", true);
		btn.attr("disabled", true);
		company.attr("disabled", true);
		relation.attr("disabled", true);
		if (relation.val() == "OTHER") otherRelation.attr("disabled", true);
		bussines.attr("disabled", true);
		area.attr("disabled", true);
		if (area.val() == "OTHER") otherArea.attr("disabled", true);
		totalGuest.attr("disabled", true);
		picName.attr("disabled", true);
		picDept.attr("disabled", true);
		picAg.attr("disabled", true);
		if (picAg.prop("checked")) picNote.attr("disabled", true);
		turn.attr("disabled", true);
		burn.attr("disabled", true);

		for (let i = 0; i < guCheckBox.length; i++) {
			guCheckBox.eq(i).attr("disabled", true);
			guName.eq(i).attr("disabled", true);
			guIdentity.eq(i).attr("disabled", true);
			guTemp.eq(i).attr("disabled", true);
			guVaksin.eq(i).attr("disabled", true);
			guCard.eq(i).attr("disabled", true);
		}

		const params = {
			"company": company.val().trim(),
			"relation": relation.val().trim(),
			"relation-other": (relation.val() == "OTHER" ? otherRelation.val().trim():"off"),
			"bussines": bussines.val().trim(),
			"area": area.val().trim(),
			"area-other": (area.val() == "OTHER" ? otherArea.val().trim():"off"),
			"guest-total": totalGuest.val().trim(),
			"pic-name": picName.val().trim(),
			"pic-dept": picDept.val().trim(),
			"pic-agre": picAg.prop("checked"),
			"pic-note": (picAg.prop("checked") ? picNote.val().trim():"off"),
		};
		const paramsSec = [];

		for (let i = 0; i < guCheckBox.length; i++) {
			paramsSec.push({
				guName: guName.eq(i).val().trim(),
				guIdentity: guIdentity.eq(i).val().trim(),
				guTemp: guTemp.eq(i).val().trim(),
				guVaksin: guVaksin.eq(i).val().trim(),
				guCard: guCard.eq(i).val().trim(),
			});
		}

		const executePost = {
			'data' : JEncrypt(JSON.stringify(params)),
			'guest' : JSON.stringify(paramsSec),
		}

		const url = baseUrl("/auth/api/v1/record");

		const execute = postField(url, 'POST', executePost, false);

		execute.done(function(result) {
			let obj = JSON.parse(JSON.stringify(result));

			if (obj.code == 200) {
				$(".air-badge").html(airBadge(obj.msg , 'success'));

				// const titleBox = $("#title-rec");
				// const idBox = $("#id-rec");
				// const dateBox = $("#date-rec");
				// const cloneBox = $("#burn-btn");
				// const btnInputIn = $("#gz-form-input-in");
				// const btnInputOut = $("#gz-form-input-out");

				// const idRec = $("#gz-form-record-number");
				// const dateCrRec = $("#gz-form-date-created");
				// const dateInRec = $("#gz-form-date-in");
				// const dateOutRec = $("#gz-form-date-out");

				// titleBox.text(obj.result.title);
				// idRec.val(obj.result.id);
				// dateCrRec.val(obj.result.date_created);
				// dateInRec.val(obj.result.date_in);

				// idBox.removeClass("d-none");
				// dateBox.removeClass("d-none");
				// cloneBox.addClass("d-none");
				// btnInputIn.addClass("d-none");
				// btnInputOut.removeClass("d-none");

				setTimeout(function() {
					window.location = obj.result.url;
				}, 5000);
			} else {
				$(".air-badge").html(airBadge(obj.msg , 'danger'));
				btnCancel.attr("disabled", false);
				btn.attr("disabled", false);
				company.attr("disabled", false);
				relation.attr("disabled", false);
				if (relation.val() == "OTHER") otherRelation.attr("disabled", false);
				bussines.attr("disabled", false);
				area.attr("disabled", false);
				if (area.val() == "OTHER") otherArea.attr("disabled", false);
				totalGuest.attr("disabled", false);
				picName.attr("disabled", false);
				picDept.attr("disabled", false);
				picAg.attr("disabled", false);
				if (picAg.prop("checked")) picNote.attr("disabled", false);
				turn.attr("disabled", false);
				burn.attr("disabled", false);

				for (let i = 0; i < guCheckBox.length; i++) {
					guCheckBox.eq(i).attr("disabled", false);
					guName.eq(i).attr("disabled", false);
					guIdentity.eq(i).attr("disabled", false);
					guTemp.eq(i).attr("disabled", false);
					guVaksin.eq(i).attr("disabled", false);
					guCard.eq(i).attr("disabled", false);
				}
			}
		});

		execute.fail(function() {
			$(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
			btnCancel.attr("disabled", false);
			btn.attr("disabled", false);
			company.attr("disabled", false);
			relation.attr("disabled", false);
			if (relation.val() == "OTHER") otherRelation.attr("disabled", false);
			bussines.attr("disabled", false);
			area.attr("disabled", false);
			if (area.val() == "OTHER") otherArea.attr("disabled", false);
			totalGuest.attr("disabled", false);
			picName.attr("disabled", false);
			picDept.attr("disabled", false);
			picAg.attr("disabled", false);
			if (picAg.prop("checked")) picNote.attr("disabled", false);
			turn.attr("disabled", false);
			burn.attr("disabled", false);

			for (let i = 0; i < guCheckBox.length; i++) {
				guCheckBox.eq(i).attr("disabled", false);
				guName.eq(i).attr("disabled", false);
				guIdentity.eq(i).attr("disabled", false);
				guTemp.eq(i).attr("disabled", false);
				guVaksin.eq(i).attr("disabled", false);
				guCard.eq(i).attr("disabled", false);
			}
		});
	});
});

let formOut = (function () {
	const filterInput = (method1, method2) => {
		let inputBox = $(method1);
		let msgBox = $(method2);

		if (inputBox.val().trim().length >= 1) {
			inputBox.removeClass("is-invalid");
			inputBox.addClass("is-valid");
			msgBox.text("");

			return true;
		} else {
			inputBox.removeClass("is-valid");
			inputBox.addClass("is-invalid");
			msgBox.text("Cannot be empty!");

			return false;
		}
	}

	const filterSelect = (method1, method2) => {
		let inputBox = $(method1);
		let msgBox = $(method2);

		if (inputBox.val() != null && inputBox.val().trim().length >= 1) {
			inputBox.removeClass("is-invalid");
			inputBox.addClass("is-valid");
			msgBox.text("");

			return true;
		} else {
			inputBox.removeClass("is-valid");
			inputBox.addClass("is-invalid");
			msgBox.text("Cannot be empty!");

			return false;
		}
	}

	const filterCode = (method1, method2, status=false, min=false, max=false, must=false) => {
		let inputBox = $(method1);
		let msgBox = $(method2);

		let filter = filterNumb(inputBox, status, min, max, must);

		if (!filter.status) {
			inputBox.removeClass("is-valid");
			inputBox.addClass("is-invalid");
			msgBox.text(filter.msg);
			return false;
		} else {
			inputBox.removeClass("is-invalid");
			inputBox.addClass("is-valid");
			msgBox.text("");
			return true;
		}
	}

	const filterName = (method1, method2) => {
		let inputBox = $(method1);
		let msgBox = $(method2);

		let filter = filterChar(inputBox, [" "], 3);

		if (filter.status) {
			inputBox.removeClass("is-invalid");
			inputBox.addClass("is-valid");
			msgBox.text('');
		}

		if (!filter.status) {
			inputBox.removeClass("is-valid");
			inputBox.addClass("is-invalid");
			msgBox.text(filter.msg);
		}

		return (filter.status == true) ? true:false;
	}

	$("#gz-form-company, #gz-form-bussines, #gz-form-relation-other, #gz-form-area-other, #gz-form-pic-dept").keyup(function () {
		filterInput("#"+this.id, "#msg-"+this.id);
	});

	$("#gz-form-relation, #gz-form-area").change(function () {
		let other = $("#"+ this.id.split("-")[2] +"-other");
		let otherBox = $("#gz-form-"+ this.id.split("-")[2] +"-other");

		filterSelect("#"+this.id, "#msg-"+this.id);

		if (this.value.trim() == "OTHER") {
			other.removeClass("d-none");
			otherBox.attr("disabled", false);
		}

		if (this.value.trim() !== "OTHER") {
			other.addClass("d-none");
			otherBox.attr("disabled", true);
		}
	});

	$("#gz-form-pic-name").keyup(function() {
		filterName("#"+this.id, "#msg-"+this.id);
	});

	$("#gz-form-total-guest").keyup(function() {
		filterCode("#"+this.id, "#msg-"+this.id, true ,1, 3);
	});

	$("#gz-form-total-guest").keypress(function() {
		return allowNumberic(this);
	});

	$("#gz-agreement").change(function() {
		const picAg = $("#gz-agreement");
		const note = $("#note-agreement");
		const noteInput = $("#gz-form-pic-note");

		if (picAg.prop("checked")) {
			noteInput.attr("disabled", false);
			note.removeClass("d-none");
			$("#gz-form-pic-note").focus();
		}

		if (!picAg.prop("checked")) {
			noteInput.attr("disabled", true);
			note.addClass("d-none");
		}
	});

	$("#gz-btn-edit").click(function() {
		const myBtn = $("#gz-btn-edit");
		const btnOut = $("#gz-btn-modal-out");

		const btnSave = $("#gz-btn-modal-save");
		const btnCancel = $("#gz-btn-cancel");

		const pageFormOut = $("#gz-form-input-out");
		const pageFormEdit = $("#gz-form-input-edit");

		const gzFormCompany = $("#gz-form-company");
		const gzFormRelation = $("#gz-form-relation");
		const gzFormRelationOther = $("#gz-form-relation-other");
		const gzFormBussines = $("#gz-form-bussines");
		const gzFormArea = $("#gz-form-area");
		const gzFormAreaOther = $("#gz-form-area-other");
		const gzFormPicName = $("#gz-form-pic-name");
		const gzFormPicDept = $("#gz-form-pic-dept");
		const gzAgreement = $("#gz-agreement");
		const gzFormPicNote = $("#gz-form-pic-note");
		const guFormUserName = $('[id^="gu-form-user-name"]');
		const guFormUserIdentity = $('[id^="gu-form-user-identity"]');
		const guFormUserTemperature = $('[id^="gu-form-user-temperature"]');
		const guFormUserNoVak = $('[id^="gu-form-user-no-vak"]');
		const guFormUserCard = $('[id^="gu-form-user-card"]');

		gzFormCompany.attr("disabled", false);
		gzFormRelation.attr("disabled", false);
		if (gzFormRelation.val().trim() == "OTHER") gzFormRelationOther.attr("disabled", false);
		gzFormBussines.attr("disabled", false);
		gzFormArea.attr("disabled", false);
		if (gzFormArea.val().trim() == "OTHER") gzFormAreaOther.attr("disabled", false);
		gzFormPicName.attr("disabled", false);
		gzFormPicDept.attr("disabled", false);
		gzAgreement.attr("disabled", false);
		if (gzAgreement.prop("checked")) gzFormPicNote.attr("disabled", false);

		for (let i = 0; i < guFormUserName.length; i++) {
			guFormUserName.eq(i).attr("disabled", false);
			guFormUserIdentity.eq(i).attr("disabled", false);
			guFormUserTemperature.eq(i).attr("disabled", false);
			guFormUserNoVak.eq(i).attr("disabled", false);
			guFormUserCard.eq(i).attr("disabled", false);
		}

		myBtn.attr("disabled", true);
		btnOut.attr("disabled", true);

		btnCancel.attr("disabled", false);
		btnSave.attr("disabled", false);

		pageFormOut.addClass("d-none");
		pageFormEdit.removeClass("d-none");
	});

	$("#gz-btn-cancel").click(function() {
		const myBtn = $("#gz-btn-edit");
		const btnOut = $("#gz-btn-modal-out");

		const btnSave = $("#gz-btn-modal-save");
		const btnCancel = $("#gz-btn-cancel");

		const pageFormOut = $("#gz-form-input-out");
		const pageFormEdit = $("#gz-form-input-edit");

		const gzFormCompany = $("#gz-form-company");
		const gzFormRelation = $("#gz-form-relation");
		const gzFormRelationOther = $("#gz-form-relation-other");
		const gzFormBussines = $("#gz-form-bussines");
		const gzFormArea = $("#gz-form-area");
		const gzFormAreaOther = $("#gz-form-area-other");
		const gzFormPicName = $("#gz-form-pic-name");
		const gzFormPicDept = $("#gz-form-pic-dept");
		const gzAgreement = $("#gz-agreement");
		const gzFormPicNote = $("#gz-form-pic-note");
		const guFormUserName = $('[id^="gu-form-user-name"]');
		const guFormUserIdentity = $('[id^="gu-form-user-identity"]');
		const guFormUserTemperature = $('[id^="gu-form-user-temperature"]');
		const guFormUserNoVak = $('[id^="gu-form-user-no-vak"]');
		const guFormUserCard = $('[id^="gu-form-user-card"]');

		gzFormCompany.attr("disabled", true);
		gzFormRelation.attr("disabled", true);
		if (gzFormRelation.val().trim() == "OTHER") gzFormRelationOther.attr("disabled", true);
		gzFormBussines.attr("disabled", true);
		gzFormArea.attr("disabled", true);
		if (gzFormArea.val().trim() == "OTHER") gzFormAreaOther.attr("disabled", true);
		gzFormPicName.attr("disabled", true);
		gzFormPicDept.attr("disabled", true);
		gzAgreement.attr("disabled", true);
		if (gzAgreement.prop("checked")) gzFormPicNote.attr("disabled", true);

		for (let i = 0; i < guFormUserName.length; i++) {
			guFormUserName.eq(i).attr("disabled", true);
			guFormUserIdentity.eq(i).attr("disabled", true);
			guFormUserTemperature.eq(i).attr("disabled", true);
			guFormUserNoVak.eq(i).attr("disabled", true);
			guFormUserCard.eq(i).attr("disabled", true);
		}

		myBtn.attr("disabled", false);
		btnOut.attr("disabled", false);

		btnCancel.attr("disabled", true);
		btnSave.attr("disabled", true);

		pageFormOut.removeClass("d-none");
		pageFormEdit.addClass("d-none");
	});

	$("#gz-btn-modal-save").click(function() {
		const btnEdit = $("#gz-btn-edit");
		const btnOut = $("#gz-btn-modal-out");
		const btnCancel = $("#gz-btn-cancel");
		const myBtn = $("#gz-btn-modal-save");

		const gzFormRecordNumber = $("#gz-form-record-number");
		const gzFormCompany = $("#gz-form-company");
		const gzFormRelation = $("#gz-form-relation");
		const gzFormRelationOther = $("#gz-form-relation-other");
		const gzFormBussines = $("#gz-form-bussines");
		const gzFormArea = $("#gz-form-area");
		const gzFormAreaOther = $("#gz-form-area-other");
		const gzFormPicName = $("#gz-form-pic-name");
		const gzFormPicDept = $("#gz-form-pic-dept");
		const gzAgreement = $("#gz-agreement");
		const gzFormPicNote = $("#gz-form-pic-note");

		const guFormUserId = $('[id^="gu-form-user-id"]');
		const guFormUserName = $('[id^="gu-form-user-name"]');
		const guFormUserIdentity = $('[id^="gu-form-user-identity"]');
		const guFormUserTemperature = $('[id^="gu-form-user-temperature"]');
		const guFormUserNoVak = $('[id^="gu-form-user-no-vak"]');
		const guFormUserCard = $('[id^="gu-form-user-card"]');
		let allow = true;
		let GU = false;

		if (!filterInput("#"+gzFormCompany.attr('id') ,"#msg-"+gzFormCompany.attr('id'))) allow = false;
		if (!filterSelect("#"+gzFormRelation.attr('id') ,"#msg-"+gzFormRelation.attr('id'))) allow = false;
		if (gzFormRelation.val() == "OTHER") if (!filterInput("#"+gzFormRelationOther.attr('id') ,"#msg-"+gzFormRelationOther.attr('id'))) allow = false;
		if (!filterInput("#"+gzFormBussines.attr('id') ,"#msg-"+gzFormBussines.attr('id'))) allow = false;
		if (!filterSelect("#"+gzFormArea.attr('id') ,"#msg-"+gzFormArea.attr('id'))) allow = false;
		if (gzFormArea.val() == "OTHER") if (!filterInput("#"+gzFormAreaOther.attr('id') ,"#msg-"+gzFormAreaOther.attr('id'))) allow = false;
		if (!filterName("#"+gzFormPicName.attr('id') ,"#msg-"+gzFormPicName.attr('id'))) allow = false;
		if (!filterInput("#"+gzFormPicDept.attr('id') ,"#msg-"+gzFormPicDept.attr('id'))) allow = false;
		if (gzAgreement.prop("checked")) if (!filterInput("#"+gzFormPicNote.attr('id') ,"#msg-"+gzFormPicNote.attr('id'))) allow = false;

		for (let i = 0; i < guFormUserName.length; i++) {
			if (!filterName("input[id$='gu-form-user-name'][number='"+i+"']", "div[id$='msg-gu-form-user-name'][number='"+i+"']")) allow = false;
			if (!filterCode("input[id$='gu-form-user-identity'][number='"+i+"']", "div[id$='msg-gu-form-user-identity'][number='"+i+"']", true, false, false, 16)) allow = false;
			if (!filterCode("input[id$='gu-form-user-temperature'][number='"+i+"']", "div[id$='msg-gu-form-user-temperature'][number='"+i+"']", true, 1, 4)) allow = false;
			if (!filterInput("input[id$='gu-form-user-no-vak'][number='"+i+"']", "div[id$='msg-gu-form-user-no-vak'][number='"+i+"']")) allow = false;
			if (!filterInput("input[id$='gu-form-user-card'][number='"+i+"']", "div[id$='msg-gu-form-user-card'][number='"+i+"']")) allow = false;
			GU = true;
		}

		if (!GU) allow = false;
		if (!GU) $(".air-badge").html(airBadge("User cannot be empty, please add column", 'danger'));
		if (!allow) return false;

		$(".air-badge").html(loadingBackdropSecond());
		btnEdit.attr("disabled", true);
		btnOut.attr("disabled", true);
		btnCancel.attr("disabled", true);
		myBtn.attr("disabled", true);

		gzFormCompany.attr("disabled", true);
		gzFormRelation.attr("disabled", true);
		if (gzFormRelation.val() == "OTHER") gzFormRelationOther.attr("disabled", true);
		gzFormBussines.attr("disabled", true);
		gzFormArea.attr("disabled", true);
		if (gzFormArea.val() == "OTHER") gzFormAreaOther.attr("disabled", true);
		gzFormPicName.attr("disabled", true);
		gzFormPicDept.attr("disabled", true);
		gzAgreement.attr("disabled", true);
		if (gzAgreement.prop("checked")) gzFormPicNote.attr("disabled", true);

		for (let i = 0; i < guFormUserName.length; i++) {
			guFormUserName.eq(i).attr("disabled", true);
			guFormUserIdentity.eq(i).attr("disabled", true);
			guFormUserTemperature.eq(i).attr("disabled", true);
			guFormUserNoVak.eq(i).attr("disabled", true);
			guFormUserCard.eq(i).attr("disabled", true);
		}


		const params = {
			"id": gzFormRecordNumber.val().trim(),
			"company": gzFormCompany.val().trim(),
			"relation": gzFormRelation.val().trim(),
			"relation-other": (gzFormRelation.val() == "OTHER" ? gzFormRelationOther.val().trim():"off"),
			"bussines": gzFormBussines.val().trim(),
			"area": gzFormArea.val().trim(),
			"area-other": (gzFormArea.val() == "OTHER" ? gzFormAreaOther.val().trim():"off"),
			"pic-name": gzFormPicName.val().trim(),
			"pic-dept": gzFormPicDept.val().trim(),
			"pic-agre": gzAgreement.prop("checked"),
			"pic-note": (gzAgreement.prop("checked") ? gzFormPicNote.val().trim():"off"),
		};
		const paramsSec = [];

		for (let i = 0; i < guFormUserName.length; i++) {
			paramsSec.push({
				guID: guFormUserId.eq(i).attr("guid").trim(),
				guName: guFormUserName.eq(i).val().trim(),
				guIdentity: guFormUserIdentity.eq(i).val().trim(),
				guTemp: guFormUserTemperature.eq(i).val().trim(),
				guVaksin: guFormUserNoVak.eq(i).val().trim(),
				guCard: guFormUserCard.eq(i).val().trim(),
			});
		}

		const executePost = {
			'data' : JEncrypt(JSON.stringify(params)),
			'guest' : JSON.stringify(paramsSec),
		}

		const url = baseUrl("/auth/api/v1/editrecord");

		const execute = postField(url, 'POST', executePost, false);

		execute.done(function(result) {
			let obj = JSON.parse(JSON.stringify(result));

			if (obj.code == 200) {
				$(".air-badge").html(airBadge(obj.msg , 'success'));
				setTimeout(function() {
					window.location = obj.result.url;
				}, 5000);
			} else {
				$(".air-badge").html(airBadge(obj.msg , 'danger'));
				btnEdit.attr("disabled", false);
				btnOut.attr("disabled", false);
				btnCancel.attr("disabled", false);
				myBtn.attr("disabled", false);

				gzFormCompany.attr("disabled", false);
				gzFormRelation.attr("disabled", false);
				if (gzFormRelation.val() == "OTHER") gzFormRelationOther.attr("disabled", false);
				gzFormBussines.attr("disabled", false);
				gzFormArea.attr("disabled", false);
				if (gzFormArea.val() == "OTHER") gzFormAreaOther.attr("disabled", false);
				gzFormPicName.attr("disabled", false);
				gzFormPicDept.attr("disabled", false);
				gzAgreement.attr("disabled", false);
				if (gzAgreement.prop("checked")) gzFormPicNote.attr("disabled", false);

				for (let i = 0; i < guFormUserName.length; i++) {
					guFormUserName.eq(i).attr("disabled", false);
					guFormUserIdentity.eq(i).attr("disabled", false);
					guFormUserTemperature.eq(i).attr("disabled", false);
					guFormUserNoVak.eq(i).attr("disabled", false);
					guFormUserCard.eq(i).attr("disabled", false);
				}
			}
		});

		execute.fail(function() {
			$(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
			btnEdit.attr("disabled", false);
			btnOut.attr("disabled", false);
			btnCancel.attr("disabled", false);
			myBtn.attr("disabled", false);

			gzFormCompany.attr("disabled", false);
			gzFormRelation.attr("disabled", false);
			if (gzFormRelation.val() == "OTHER") gzFormRelationOther.attr("disabled", false);
			gzFormBussines.attr("disabled", false);
			gzFormArea.attr("disabled", false);
			if (gzFormArea.val() == "OTHER") gzFormAreaOther.attr("disabled", false);
			gzFormPicName.attr("disabled", false);
			gzFormPicDept.attr("disabled", false);
			gzAgreement.attr("disabled", false);
			if (gzAgreement.prop("checked")) gzFormPicNote.attr("disabled", false);

			for (let i = 0; i < guFormUserName.length; i++) {
				guFormUserName.eq(i).attr("disabled", false);
				guFormUserIdentity.eq(i).attr("disabled", false);
				guFormUserTemperature.eq(i).attr("disabled", false);
				guFormUserNoVak.eq(i).attr("disabled", false);
				guFormUserCard.eq(i).attr("disabled", false);
			}
		});
	});

	$("#btn-gz-form-out").click(function () {
		const btn = $("#btn-gz-form-out");
		const edit = $("#gz-btn-edit");
		const modal = $("#modal-sign-out");
		const link = window.location.href;

		modal.modal('hide');
		$(".air-badge").html(loadingBackdrop());
		btn.attr("disabled", true);
		edit.attr("disabled", true);

		const params = {
			"code": link.split("/")[(link.split("/").length-1)],
		};
		const executePost = {
			'data' : JEncrypt(JSON.stringify(params)),
		}

		const url = baseUrl("/auth/api/v1/checkout");

		const execute = postField(url, 'POST', executePost, false);

		execute.done(function(result) {
			let obj = JSON.parse(JSON.stringify(result));

			if (obj.code == 200) {
				$("#gz-form-input-out").remove();
				$(".air-badge").html(airBadge(obj.msg , 'success'));
				setTimeout(function() {
					window.location = obj.result.url;
				}, 5000);
			} else {
				$(".air-badge").html(airBadge(obj.msg , 'danger'));
				btn.attr("disabled", false);
				edit.attr("disabled", false);
			}
		});

		execute.fail(function() {
			$(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
			btn.attr("disabled", false);
			edit.attr("disabled", false);
		});
	});

});

let summaryReport = (function () {
	let options = lineChartOptions();

	const myChart = (options) => {
		let opt = options;
		let total = $('[id^="chart-total"]');
		let date = $('[id^="chart-date"]');

		// data: ,
		// let dataTotal = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
		let dataTotal = [];
		for (let i = 0; i < total.length; i++) {
			dataTotal.push(total[i].innerHTML);
			// dataTotal[i] = total[i].innerHTML;
		}

		let dataDate = [];
		for (let i = 0; i < date.length; i++) {
			dataDate.push(date[i].innerHTML);
		}

		// opt.options.scales.yAxes[0].ticks.max = maxVote.text().trim();

		opt.data.labels = dataDate;
		opt.data.datasets[0].data = dataTotal;

		
	}
	myChart(options);
	let ctx = document.getElementById("myAreaChart");
	let myLineChart = new Chart(ctx, options);

	$("#data-diagram-date").change(function () {
		const input = $("#data-diagram-date");
		const chartDate = $("#diagram-date");
		const chartData = $(".chart-data");
		const tableRecord = $("#table-record");
		const tableDetails = $("#table-details");


		const params = {
			"code": input.val(),
		};
		const executePost = {
			'data' : JEncrypt(JSON.stringify(params)),
		}

		const url = baseUrl("/auth/api/v1/getSummary");

		const execute = postField(url, 'POST', executePost, false);

		execute.done(function(result) {
			let obj = JSON.parse(JSON.stringify(result));

			if (obj.code == 200) {
				let unix_timestamp = obj.result.simp[0].date;
				let date = new Date(unix_timestamp * 1000);

				let labels = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

				let sc = ``;
				let tr = ``;
				for (let i = 0; i < obj.result.simp.length; i++) {
					tr += `
					<tr>
                        <td class="text-wrap align-middle text-center">${obj.result.simp[i].total}</td>
                        <td class="text-wrap align-middle text-center">${labels[(date.getMonth()+i)]+'-'+ date.getFullYear()}</td>
                    </tr>`
					sc += '<div class="d-none" id="chart-total">'+ obj.result.simp[i].total +'</div><div class="d-none" id="chart-date">'+ labels[(date.getMonth()+i)] +'-'+ date.getFullYear() +'</div>';
				}

				let detailsTB = ``;
				for (let x = 0; x < obj.result.details.length; x++) {
					detailsTB += `
					<tr>
                        <td class="text-wrap align-middle">${obj.result.details[x].company}</td>
                        <td class="text-wrap align-middle">${obj.result.details[x].area}</td>
                        <td class="text-wrap align-middle text-center">${obj.result.details[x].guest_total}</td>
                        <td class="text-wrap align-middle text-center">${obj.result.details[x].date_created}</td>
                        <td class="text-wrap align-middle text-center">${obj.result.details[x].date_out}</td>
                    </tr>`;
				}
				
				chartDate.text(date.getFullYear());
				chartData.html(sc);
				tableRecord.html(tr);
				tableDetails.html(detailsTB);

				myChart(options);
				myLineChart.update();
			} else {
				$(".air-badge").html(airBadge(obj.msg , 'danger'));
			}
		});

		execute.fail(function() {
			$(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
		});

	});
});

let main = (function() {
	let isOn = $(".main-cls").attr("main") || false;

	if (isOn == "profile") profile();
	if (isOn == "users-management") usersManagement();
	if (isOn == "web-settings") webSettings();
	if (isOn == "open-form") openForm();
	if (isOn == "out-form") formOut();
	if (isOn == "summary-report") summaryReport();
})();