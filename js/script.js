$(document).ready(function() {
    $('.edit_row').click(function(){
		var row = $(this).parent().parent();
		if(!row.hasClass('ed'))
		{
			row.addClass('ed');
			$('td:eq(1)', row).html('<input type="text" value="'+$('td:eq(1)', row).text()+'" />');
			$('td:eq(2)', row).html('<input type="text" value="'+$('td:eq(2)', row).text()+'" />');
			$('td:eq(3)', row).html('<input type="text" value="'+$('td:eq(3)', row).text()+'" />');
			$('td:eq(4)', row).html(select_input(5, parseInt($('td:eq(4)', row).text())));
			$(this).val('Применить');
		}
		else
		{
			var row = $(this).parent().parent();
			var id = row.attr('row-id');
			var sitename = $('td:eq(1) input', row).val();
			var url = $('td:eq(2) input', row).val();
			var description = $('td:eq(3) input', row).val();
			var rate = $('td:eq(4) select', row).val();
			post('/omniweb/cgi/update.php', {id: id, sitename: sitename, url: url, description: description, rate: rate});
		}
	});
	
	$('.delete_row').click(function(){
		var row = $(this).parent().parent();
		var id = row.attr('row-id');
		post('/omniweb/cgi/delete.php', {id: id});
	});
	
	$('.add-site').click(function()
	{
		var form = $('.add-item-form');
		var name = $('.new-site-name', form);
		var url = $('.new-site-url', form);
		var description = $('.new-site-desc', form);
		var rate = $('.new-site-rate', form);
		
		var err = false;
		
		if(name.val() == '')
		{
			name.addClass('input_error');
			err = true;
		}
		else
		{
			name.removeClass('input_error');
		}
		
		if(url.val() == '')
		{
			url.addClass('input_error');
			err = true;
		}
		else
		{
			url.removeClass('input_error');
		}
		
		if(description.val() == '')
		{
			description.addClass('input_error');
			err = true;
		}
		else
		{
			description.removeClass('input_error');
		}
		
		if(!err)
		{
			post('/omniweb/cgi/insert.php', {sitename: name.val(), url: url.val(), description: description.val(), rate: rate.val()});
		}
	});
});

var select_input = function(n, selected_i)
{
	var select = "<select>";
	
	for(var i=1;i<=n;i++)
	{
		select += "<option "+((i==selected_i)?"selected=\"selected\"":"")+" value=\""+i+"\">"+i+"</option>";
	}
	
	select += "</select>";
	
	return select;
}

var post = function(url, data)
{
	$.post(url, data, function(data){
		if(data.hasOwnProperty('error'))
		{
			alert(data.error_text);
		}
		else
		{
			location.reload();
		}
	});
}