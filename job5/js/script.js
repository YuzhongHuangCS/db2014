$(document).ready(function(){
	$.getJSON('php/backend.php', {action: 'select'}, function(json){
		var content='', i;
		for (i=0; i<json.length; i++) {
			content += '<tr>';
			content +=		'<td>' + json[i].id 	+ '</td>';
			content +=		'<td>' + json[i].name	+ '</td>';
			content +=		'<td>' + json[i].age	+ '</td>';
			content += '</tr>';
		};
		console.log(content);
		$("#table").append(content);
	});
});