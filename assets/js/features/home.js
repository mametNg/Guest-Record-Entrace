'use strict';
let home = (function() {

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

		for (var i = 0; i < checkbox.length; i++) {
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

		for (var i = 0; i < guCheckBox.length; i++) {
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
		turn.attr("disabled", true);
		burn.attr("disabled", true);

		for (var i = 0; i < guCheckBox.length; i++) {
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
		};
		const paramsSec = [];

		for (var i = 0; i < guCheckBox.length; i++) {
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
				turn.attr("disabled", false);
				burn.attr("disabled", false);

				for (var i = 0; i < guCheckBox.length; i++) {
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
			turn.attr("disabled", false);
			burn.attr("disabled", false);

			for (var i = 0; i < guCheckBox.length; i++) {
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
	$("#gz-form-out").click(function () {
		const btn = $("#gz-form-out");
		const modal = $("#modal-sign-out");
		const link = window.location.href;

		modal.modal('hide');
		$(".air-badge").html(loadingBackdrop());
		btn.attr("disabled", true);

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
			}
		});

		execute.fail(function() {
			$(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
			btn.attr("disabled", false);
		});
	});
});

let main = (function() {
	let isOn = $(".main-cls").attr("main") || false;

	if (isOn == "home") home();
	if (isOn == "out") formOut();
})();