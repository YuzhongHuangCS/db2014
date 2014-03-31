$(document).ready(function(){
	//display the student information
	selectStu();
	
});
/*
i is the order of a item in the table list,
later operation is based on the order i,
all the data are acquired by json[i]
*/
function selectStu(listID){
	$.getJSON('php/backend.php', {action: 'select'}, function(json){
		var content='', i;
		window.json = json;
		content =	'<tr><th></th><th>学号:</th><th>姓名:</th><th>年龄:</th></tr>';
		for (i=0; i<json.length; i++) {
			content += '<tr>';
			content += '<td><input type="checkbox" value=' + i + '></td>';
			content += '<td>' + json[i].id + '</td>';
			content += '<td>' + json[i].name + '</td>';
			content += '<td>' + json[i].age + '</td>';
			content += '</tr>';
		};
		$('#infoTable').html(content);
	});
};
function insertStu(){
	var insertData = 'action=insert&';
	insertData += $('#insertInput').serialize();
	$.get('php/backend.php', insertData, function(data){
		if(data == '保存成功'){
			$('#insertResult').fadeOut('fast');
			$('#insertResult').removeClass("alert-danger");
			$('#insertResult').addClass("alert-success");
			$('#insertResult').html(data);
			$('#insertResult').fadeIn('slow', function() {
				setTimeout(function(){
					$('#insertModal').modal('hide');
					selectStu();
					$('#insertResult').hide();
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
function showUpdateStu(){
	var json = window.json;
	var updateArray = $('input:checkbox:checked').map(function (){
		return this.value;
	}).get();
	var content = '';

	$('#updateResult').remove();
	$('#updateInput').empty();

	if(updateArray.length == 1){
		$('#updateModal .btn-warning').show();
		content += '<input type="text" name="id" class="form-control" disabled="disabled" value="' + json[updateArray[0]].id +'">';
		content += '<input type="text" name="name" class="form-control" value="' + json[updateArray[0]].name + '">';
		content += '<input type="text" name="age" class="form-control" value="' + json[updateArray[0]].age + '">';
		$('#updateInput').html(content);
	} else{
		if(updateArray.length == 0){
			content = '<div class="alert alert-danger" id="updateResult">什么都没选呀</div>';
			$('#updateModal .modal-body').prepend(content);
			$('#updateModal .btn-warning').hide();
		} else{
			content = '<div class="alert alert-warning" id="updateResult">一条一条修改嘛</div>';
			$('#updateModal .modal-body').prepend(content);
			$('#updateModal .btn-warning').hide();
		}
	}
};

function updateStu(){
	var json = window.json;
	var updateArray = $('input:checkbox:checked').map(function (){
		return this.value;
	}).get();
	
	var updateData = 'action=update&id=';
	updateData += json[updateArray[0]].id + '&';
	updateData += $('#updateInput').serialize();
	
	$.get('php/backend.php', updateData, function(data){
		if(data == '保存成功'){
			$('#updateModal .modal-body').prepend('<div class="alert alert-success" id="updateResult" style="display: none"></div>');
			$('#updateResult').html(data);
			$('#updateResult').fadeIn('slow', function() {
				setTimeout(function(){
					$('#updateModal').modal('hide');
					selectStu();
				},600);
			});
		} else{
			$('#updateModal .modal-body').prepend('<div class="alert alert-danger" id="updateResult" style="display: none"></div>');
			$('#updateResult').html(data);
			$('#updateResult').fadeIn('slow');
		}
	});
};
/*
deleteArray store the item order in the table list,
access by deleteArray[i], i is the order in the deleteArray
json[deleteArray[i]].id is the item id to delete!!!
*/
function showDeleteStu(){
	var json = window.json;
	var deleteArray = $('input:checkbox:checked').map(function (){
		return this.value;
	}).get();
	var content = '';

	if(deleteArray.length){
		$('#deleteModal .alert-danger').text("你真的要删除这些条目了吗？");
		$('#deleteModal .btn-primary').show();

		content = '<tr><th>学号:</th><th>姓名:</th><th>年龄:</th></tr>'
		for(var i in deleteArray){
			content += '<tr>';
			content += '<td>' + json[deleteArray[i]].id + '</td>';
			content += '<td>' + json[deleteArray[i]].name + '</td>';
			content += '<td>' + json[deleteArray[i]].age + '</td>';
			content += '</tr>';
		};
		$('#deleteTable').html(content);
	} else{
		$('#deleteModal .alert-danger').text("什么都没选呀");
		$('#deleteModal .btn-primary').hide();
		$('#deleteTable').html('');
	}
};
function deleteStu(){
	var json = window.json;
	var deleteArray = $('input:checkbox:checked').map(function (){
		return this.value;
	}).get();
	var errorCount = 0;

	for(var i in deleteArray){
		$.get('php/backend.php', {action: 'delete', id: json[deleteArray[i]].id}, function(data){
			if(data != '删除成功'){
				errorCount++;
			}
		});
	}
	
	if(errorCount == 0){
		$('#deleteTable').fadeOut(function() {
			$('#deleteTable').before('<div class="alert alert-success">所选条目已删除</div>');
			setTimeout(function(){
					$('#deleteModal').modal('hide');
					selectStu();
					$("#deleteModal .alert-success").remove();
					$('#deleteTable').show();
			},600);
		});
	} else{
		$('#deleteTable').before('<div class="alert alert-danger">删除失败，请检查输入</div>');
	}
};