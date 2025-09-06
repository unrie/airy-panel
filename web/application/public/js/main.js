/*
* @LitePanel
* @Developed by QuickDevel
*/

/* Ошибки, предупреждения... */
function showError(text) {
  $.notify({title: '<strong>Ошибка!</strong>', message: text},{type: 'danger'});
	/*var element = $('<div class="alert alert-danger"><strong>Ошибка!</strong> ' + text + '</div>').prependTo('#content');
	setTimeout(function() {
		element.fadeOut(500, function() {
			$(this).remove();
		});
	}, 10000);*/
}
function showWarning(text) {
  $.notify({title: '<strong>Проверка данных...</strong>', message: text},{type: 'warning'});
	/*var element = $('<div class="alert alert-warning"><strong>Проверка данных...</strong> ' + text + '</div>').prependTo('#content');
	setTimeout(function() {
		element.fadeOut(500, function() {
			$(this).remove();
		});
	}, 10000);*/
}
function showSuccess(text) {
  $.notify({title: '<strong>Выполнено!</strong>', message: text},{type: 'success'});
	/*var element = $('<div class="alert alert-success"><strong>Выполнено!</strong> ' + text + '</div>').prependTo('#content');
	setTimeout(function() {
		element.fadeOut(500, function() {
			$(this).remove();
		});
	}, 10000);*/
}

function redirect(url) {
	document.location.href=url;
}

function reload() {
	window.location.reload();
}

function setNavMode(mode) {
	switch(mode) {
		case "user":
		{
			$('#administratorNavModeBtn').removeClass("active");
			$('#userNavModeBtn').addClass("active");
			$('#administratorNavMode').hide();
			$('#userNavMode').fadeIn(500);
			break;
		}
		case "administrator":
		{
			$('#userNavModeBtn').removeClass("active");
			$('#administratorNavModeBtn').addClass("active");
			$('#userNavMode').hide();
			$('#administratorNavMode').fadeIn(500);
			break;
		}
	}
}
