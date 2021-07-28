$(document).ready(()=>{
	console.log("Script Loaded!");
	$("#table-body").on('click', '.edit-btn', function () {
		let id = $(this).closest('tr').children('td.id').text();
		let username = $(this).closest('tr').children('td.un').text();
		let password = $(this).closest('tr').children('td.pw').text();

		$('input[name="id"]').val(id);
		$('input[name="username"]').val(username);
		$('input[name="password"]').val(password);

		$('input[name="save"]').hide();
		$('input[name="update"]').show();

	});
});