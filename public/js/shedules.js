$(function() {
	$('#sunday_from').datetimepicker({
		format : 'HH:mm'
	});
});
$(function() {
	$('#sunday_to').datetimepicker({
		format : 'HH:mm'
	});
});
$(document).ready(function() {

	$(document).on('click', '.sunday_work', function() {
		if (this.value == 0) {
			$(".sunday_work_shedule").hide();
		} else {
			$(".sunday_work_shedule").show();
		}
	})
});
$(function() {
	$('#saturday_from').datetimepicker({
		format : 'HH:mm'
	});
});
$(function() {
	$('#saturday_to').datetimepicker({
		format : 'HH:mm'
	});
});
$(document).ready(function() {

	$(document).on('click', '.saturday_work', function() {
		if (this.value == 0) {
			$(".saturday_work_shedule").hide();
		} else {
			$(".saturday_work_shedule").show();
		}
	})
});
$(function() {
	$('#friday_from').datetimepicker({
		format : 'HH:mm'
	});
});
$(function() {
	$('#friday_to').datetimepicker({
		format : 'HH:mm'
	});
});
$(document).ready(function() {

	$(document).on('click', '.friday_work', function() {
		if (this.value == 0) {
			$(".friday_work_shedule").hide();
		} else {
			$(".friday_work_shedule").show();
		}
	})
});
$(function() {
	$('#monday_from').datetimepicker({
		format : 'HH:mm'
	});
});
$(function() {
	$('#monday_to').datetimepicker({
		format : 'HH:mm'
	});
});
$(document).ready(function() {

	$(document).on('click', '.monday_work', function() {
		if (this.value == 0) {
			$(".monday_work_shedule").hide();
		} else {
			$(".monday_work_shedule").show();
		}
	})
});
$(function() {
	$('#tuesday_from').datetimepicker({
		format : 'HH:mm'
	});
});
$(function() {
	$('#tuesday_to').datetimepicker({
		format : 'HH:mm'
	});
});
$(document).ready(function() {

	$(document).on('click', '.tuesday_work', function() {
		if (this.value == 0) {
			$(".tuesday_work_shedule").hide();
		} else {
			$(".tuesday_work_shedule").show();
		}
	})
});
$(function() {
	$('#wednesday_from').datetimepicker({
		format : 'HH:mm'
	});
});
$(function() {
	$('#wednesday_to').datetimepicker({
		format : 'HH:mm'
	});
});
$(document).ready(function() {

	$(document).on('click', '.wednesday_work', function() {
		if (this.value == 0) {
			$(".wednesday_work_shedule").hide();
		} else {
			$(".wednesday_work_shedule").show();
		}
	})
});
$(function() {
	$('#thursday_from').datetimepicker({
		format : 'HH:mm'
	});
});
$(function() {
	$('#thursday_to').datetimepicker({
		format : 'HH:mm'
	});
});
$(document).ready(function() {

	$(document).on('click', '.thursday_work', function() {
		if (this.value == 0) {
			$(".thursday_work_shedule").hide();
		} else {
			$(".thursday_work_shedule").show();
		}
	})
});