$(document).ready(function(){
	//display the student information
	select();
	
});
function select(listID){
	$.getJSON('php/backend.php', {action: 'select'}, function(json){
		var content='', i;
		content =	'<tr><th></th><th>学号:</th><th>姓名:</th><th>年龄:</th></tr>';
		for (i=0; i<json.length; i++) {
			content += '<tr>';
			content += '<td><input type="checkbox" value=' + json[i].id + '></td>';
			content += '<td>' + json[i].id + '</td>';
			content += '<td>' + json[i].name + '</td>';
			content += '<td>' + json[i].age + '</td>';
			content += '</tr>';
		};
		$("#table").html(content);
	});
};
function insert(){
	var getData = 'action=insert&';
	getData += $('#insertInput').serialize();
	$.get('php/backend.php', getData, function(data){
		if(data == '保存成功'){
			$('#insertResult').fadeOut('fast');
			$('#insertResult').removeClass("alert-danger");
			$('#insertResult').addClass("alert-success");
			$('#insertResult').html(data);
			$('#insertResult').fadeIn('slow', function() {
				setTimeout(function(){
					$('#insert').modal('hide');
					select();
				},600);
			});
		} else{
			$('#insertResult').fadeOut('fast');
			$('#insertResult').addClass("alert-danger");
			$('#insertResult').html(data);
			$('#insertResult').fadeIn('slow');
		}
	});
};
function my(){
	var deleteArray = $('input:checkbox:checked').map(function (){
		return this.value;
	}).get();

	alert(deleteArray);
};