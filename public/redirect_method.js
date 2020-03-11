jQuery(document).ready(function ($) {

	var formid;
	var formid_long;

	// for redirect method 1
	document.addEventListener('wpcf7submit', function (event) {
		var id_long = event.detail.id;
		var id = event.detail.contactFormId;
		var formid = id_long;
		var formid = id;
		var forms = cf7rl_ajax_object.cf7rl_forms;


		var array_list = forms.split(",");
		array_list.forEach(function (item) {
			// check to see if this array item has redirect enabled

			var item_list = item.split("|");
			if (item_list[1] == id) {

				var namea = item_list[5];
				var emaila = item_list[6];
				var inputs = event.detail.inputs;
				for (var i = 0; i < inputs.length; i++) {
					if (namea == inputs[i].name) {
						var namevalue = inputs[i].value;
					}
					if (emaila == inputs[i].name) {
						var emaila = inputs[i].value;
					}
				}
				var name = namevalue;
				var email = emaila;
				var url = item_list[2];
				var tab = item_list[4];
				var redirectm = item_list[7];
				var tab = url + '?name=' + name + '&email=' + email;
				if (redirectm == '1') {
					location = tab;
				}
				if (redirectm == '2') {
					var win = window.open(tab, '_blank');
					win.focus();
				}

			}
		});

	}, false);


});