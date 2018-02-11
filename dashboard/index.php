 <?php  
 include_once "dbconfig.php";
 $query = "SELECT * FROM blog ORDER BY id DESC";  
 $result = mysqli_query($connect, $query);  
 ?>  
 <!DOCTYPE html>  
 <html>  
      <head>  
           <title>Control Panel</title>
		   <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
      </head>
	  <style>
		html body{
			max-width:100%;
			overflow-x:hidden;
		}
	    @media (max-width: 768px) {
		.btn-responsive {
			padding:2px 4px;
			font-size:87%;
			line-height: 2;
			border-radius:3px;
		}
		}

		@media (min-width: 769px) and (max-width: 992px) {
		.btn-responsive {
			padding:1px 1px;
			font-size:95%;
			line-height: 2.2;
		}
		}
		.popover{
			max-width:180px;
			width:auto;
		}
		textarea{
			resize:none;
		}
	  </style>
      <body>  
           <br /><br />  
           <div class="container" style="width:700px; max-width:100%;">  
                <h3 align="center">Таблица със случаи</h3>
			</div>
                <br /> 
                     <div class="container" style="width:700px; max-width:100%;" align="right">  
                          <button  type="button" name="add" id="add" data-toggle="modal" data-target="#add_data_Modal" class="btn btn-warning"><span class="glyphicon glyphicon-pencil"></span>&nbsp;Добави случай</button>  
                     </div>
                     <br />
					<div class="container" style="width:700px; max-width:100%;">
                     <div id="cases_table" class="table-responsive" style="">  
                          <table class="table table-bordered">  
                               <tr>  
                                    <th width="55%">Заглавие</th>  
                                    <th width="15%">Редактиране</th>  
                                    <th width="15%">Разглеждане</th>
									<th width="15%">Изтриване</th>
                               </tr>  
                               <?php  
                               while($row = mysqli_fetch_array($result))  
                               {  
                               ?>  
                               <tr>  
                                    <td><?php echo $row["header"]; ?></td>  
                                    <td><button name="edit" id="<?php echo $row["id"]; ?>" class="btn btn-warning btn-sm btn-responsive edit_data"><span class="glyphicon glyphicon-edit"></span>&nbsp;Редактирай</button></td>  
                                    <td><button name="view" id="<?php echo $row["id"]; ?>" class="btn btn-info btn-sm btn-responsive view_data"><span class="glyphicon glyphicon-eye-open"></span>&nbsp;Разгледай</button></td>
									<td><button name="delete" id="<?php echo $row["id"]; ?>" class="btn btn-danger btn-sm btn-responsive delete_data"><span class="glyphicon glyphicon-trash"></span>&nbsp;Изтрий</button></td>
                               </tr>  
                               <?php  
                               }  
                               ?>  
                          </table>  
                     </div> 
           </div>
      </body>  
 </html>  
 <div id="dataModal" class="modal fade">  
      <div class="modal-dialog">  
           <div class="modal-content">  
                <div class="modal-header">  
                     <button type="button" class="close" data-dismiss="modal">&times;</button>  
                     <h4 class="modal-title">Детайли за случая</h4>  
                </div>  
                <div class="modal-body" id="case_detail">  
                </div>  
                <div class="modal-footer">  
                     <button type="button" class="btn btn-default" data-dismiss="modal">Затвори</button>  
                </div>  
           </div>  
      </div>  
 </div>  
 <div id="add_data_Modal" class="modal fade">  
      <div class="modal-dialog">  
           <div class="modal-content">  
                <div class="modal-header">  
                     <button type="button" class="close" data-dismiss="modal">&times;</button>  
                     <h4 class="modal-title">Добави нов случай</h4>  
                </div>  
                <div class="modal-body" style="width:100%;">  
                     <form method="post" id="insert_form" autocomplete="off">  
                          <label>Заглавие на случая:</label>  
                          <input type="text" name="title" id="title" class="form-control" />
						  <span id="titleError" style="color:red;"></span>
                          <br />  
                          <label>Описание(инструкции) на случая:</label>  
                          <textarea name="description" id="description" class="form-control"></textarea>
						  <span id="descriptionError" style="color:red;"></span>
                          <br />
						  <label>Категория на случая:</label>  
                            <select name="category" id="category" class="form-control">
								<?php 
								$cats = "select * from cats"; 
								$catsquery = mysqli_query($connect, $cats);
								
								while($row = mysqli_fetch_array($catsquery)){
									
								?>
									<option value="<?php echo $row['cid']; ?>"><?php echo $row['cname']; ?></option>
								<?php
								}
								?>
						    </select>
						  <label id="photos_title">Снимки към случая:</label>
						  <div class="container" style="width:100%; border:3px dashed black;" id="photos_container">
						  <div class="row" id="case_photos" style="margin-bottom:20px;"> 
						  </div>
						  </div>
						  <label>Добави снимки:</label>
						  <div class="container" style="width:100%; border:3px dashed black; margin-bottom:10px;">
						  <div class="row" id="container" style="margin-bottom:20px;">
						  </div>
						  </div>
						  <button type="button" class="btn btn-info" id="add_more"><span class="glyphicon glyphicon-plus"></span>&nbsp;Добави файл</button>
                          <input type="hidden" name="case_id" id="case_id" />  
                          <input type="submit" name="insert" id="insert" value="Добави" class="btn btn-success"/> 
                     </form>  
                </div>  
                <div class="modal-footer">  
                     <button type="button" class="btn btn-default" data-dismiss="modal">Затвори</button>  
                </div>  
           </div>  
      </div>  
 </div>  
 <script>  
 $(document).ready(function(){  
		var max_fields = 10;
		var wrapper = $("#container");
		var add_button = $("#add_more");
		$('#add').click(function(){
		   $('#photos_title').hide();
		   $('#photos_container').hide();
		   if($('#case_photos').is(':visible')){
			  $('#case_photos').hide(); 
		   }
           $('#insert').val("Добави");
           $('#insert_form')[0].reset();
		   $('#insert_form span').text("");
		   $(wrapper).html("");
		});
		
		var margin_top = '';
		var file_title_height = '';
		
		function object_size(object){
			var objectsize = 0;
			for(var key in object){
				if(object.hasOwnProperty(key)){
					objectsize++;
				}
			}
			return objectsize;
		}
		
		
		/*var popover_content = '<form method="post" autocomplete="off" id="photo_form">'
		+'<div class="form-group"><label class="control-label">Файл:</label></div>'
		+'<div class="form-group"><label class="control-label">Избери нов файл:</label><input class="form-control" type="text" placeholder="Нов файл.." /></div>'
		+'<div class="form-group"><button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-saved"></span>&nbsp;Промени</button></div>'
		+'</form>';*/
		

		var x = 1;
		$(add_button).click(function(event){
		event.preventDefault();
			if(x < max_fields){
			x++;
			$(wrapper).append(
			'<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 file_divs" style="margin-top:20px;">'
			+ '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border:1px solid black; padding-left:5px; padding-top:5px; padding-right:5px;">'
			+ '<p><b>Избери файл:</b></p><button type="button" class="btn btn-info file_button"><span class="glyphicon glyphicon-open"></span>&nbsp;Избери..</button>'
			+ '<input class="files" style="width:100%; display:none;" type="file" name="file[]" />'
			+ '<span style="color:black; word-wrap: break-word; word-break:break-all;"></span><br>'
		    + '<span style="color:red;" class="fileError"></span></br>'
			+ '<p><b>Име на снимката:</b></p><input class="form-control" type="text" name="caption[]">'
			+ '<span style="color:red;" class="captionError"></span></br>'
			+ '<button type="button" class="btn btn-danger" id="remove_button" style="margin-bottom:10px;"><span class="glyphicon glyphicon-remove-sign"></span>&nbsp;Премахни</button>'
			+ '</div></div>');
			
			}
		});
		
		$(wrapper).on('click', '.file_button', function(e){
			e.preventDefault();
			$(this).siblings('.files').click();
		});
			
		$(wrapper).on('change', '.files', function(){
				var filename = this.value.replace("C:\\fakepath\\", "");
				$(this).next('span').text(filename);
		});
	  
		$(wrapper).on('click', "#remove_button", function(e){
			e.preventDefault();
			$(this).parent('div').parent('div').remove();
			x--;
		});
		
		$(document).on('click','.delete_photo', function(e){
				var photo_id = $(this).attr('id');
				var confirm = window.confirm("Сигурен ли си, че искаш да изтриеш тази снимка ?");
				if(confirm == true){
					$.ajax({
						url:"/new1/dashboard/photo_delete",
						type:"POST",
						dataType:"JSON",
						data:{photo_id:photo_id},
						success:function(response){
							alert("Снимката беше успешно изтрита!");					
							$("#case_photos").html(response.output);
						}
					});
				}
			e.preventDefault();	
		});
		
		$(document).on('click','.update_photo',function(e){
				var el = $(this);
				$('.update_photo').not(this).popover('hide');
					var image_id = $(el).attr('id');
					//var popover_content = '';
					$.ajax({
						url:"/new1/dashboard/photo_details",
						type:"POST",
						data:{image_id:image_id},
						success:function(data){
							//console.log(data);
							$(el).popover({
									html:true,
									container: $('#case_photos'),
									content: data,
									trigger: 'manual'
							});
							$(el).popover('toggle');		
							$(document).on('click', '.new_file_button', function(e){
								e.preventDefault();
								var elem = $(this);
								$(elem).siblings('.new_files').click();			
							});
							$('.popover').each(function(){
								var ele = $(this);
								$(ele).on('change', '.new_files', function(){
								var filename = this.value.replace('C:\\fakepath\\', '');
								$(ele).find('.new_file').text(filename);				
								});
							});
						}
				});
				e.preventDefault();
		});
		
		
		$(window).off("resize").on("resize", function() {
			$('.popover').each(function(){
				var popover = $(this);
				var span_text = $(popover).find('.new_file').text();			
				if ($(popover).is(":visible")) {
						var ctrl = $(popover.context);
						ctrl.popover('show');
						$(popover).find('.new_file').text(span_text);
				}
			});
		});
		
		$(document).on('click', '#photo_update', function(event){
			event.preventDefault();
			var button = $(this);
			var current_form = $(button).parent('form').attr('id');
			var popover_class = $("#"+current_form).closest('.popover').attr('class');
			var popover_split = popover_class.split(" ");
			var popover = popover_split[0];
			var form_data = new FormData($("#" + current_form)[0]);
			$.ajax({
				url:"/new1/dashboard/photo_update",
				type:"POST",
				dataType:"JSON",
				enctype:"multipart/form-data",
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,
				success:function(response){
					if(response.success == false){
						$("#"+current_form).find('.new_fileError').text(response.chosen_fileError);
						$("#"+current_form).find('.file_titleError').text(response.file_nameError);
					}
					else{
						$('.'+popover).popover('hide');
						$('#case_photos').html(response.output);
					}
				}
			});
		});
		
		$(document).on('click', '.edit_data', function(){  
           var case_id = $(this).attr("id");
		   $('#insert_form')[0].reset();
		   $(wrapper).html(""); 
		   $('#insert_form span').text("");
		   
		   
           $.ajax({  
                url:"fetch.php",  
                method:"POST",  
                data:{case_id:case_id},  
                dataType:"json",  
                success:function(data){
                     $('#title').val(data.case_data.header);  
                     $('#description').val(data.case_data.description); 
                     $('#category').val(data.case_data.cid);  
                     $('#case_id').val(data.case_data.id);
					 if(data.images_data != ""){
						$('#case_photos').html(data.images_data);
						$('#photos_title').show();
						$('#photos_container').show();
						$('#case_photos').show();
							
					 }
					 else{
						$('#case_photos').html('<p style="margin-left:5px; margin-right:5px; margin-top:10px;">Няма снимки за този случай, но можете да добавите.</p>');
						$('#photos_title').show();
						$('#photos_container').show();
						$('#case_photos').show();
					 }
                     $('#insert').val("Промени");  
                     $('#add_data_Modal').modal('show');  
                }
           });
		   
		});  
		$('#insert_form').on("submit", function(event){  
           event.preventDefault();
		   /*var valid = true;
		   if($('#title').val() == "")  
           {  
               
				valid = false;
           }
		   else if(($("#title").val()).length < 5){
			    
				valid = false;
		   }
		   if($('#description') == ""){
			    
				valid = false;
		   }
		   else if(($("#description").val()).length < 10){
			    
				valid = false;
		   }
           if(valid == true)  
           {*/ 
			if($('.popover').is(':visible')){
			   $('.update_photo').popover('hide');
			}
			var formarray = new FormData($("#insert_form")[0]); 
                $.ajax({  
                     url:"upload.php",  
                     method:"POST",
					 dataType: "JSON",
					 enctype:"multipart/form-data",
					 cache: false,
					 contentType: false,
					 processData: false,
                     data: formarray,  
                     /*beforeSend:function(){
						  if($('#insert').val() == "Добави"){
							  $('#insert').val("Добавяне...");
						  }
                          else if($('#insert').val() == "Промени"){
							  $('#insert').val("Променяне...");
						  } 
                     },*/ 
                     success:function(responseText){
						 //console.log(responseText);
						  if(responseText.success == false){
							$("#titleError").text(responseText.titleError);
							$("#descriptionError").text(responseText.descError);  
							if($(".file_divs").length > 0){
								if(object_size(responseText.caperrors) > 0){
									for(var key in responseText.caperrors){
										var capterr = $(".captionError");
										$(capterr[key]).text(responseText.caperrors[key]);
									}
								}
								
								if(object_size(responseText.fileerrors) > 0){
									for(var key in responseText.fileerrors){
										var fileerr = $(".fileError");
										$(fileerr[key]).text(responseText.fileerrors[key]);
									}	
								}
							}
						  }
						  else{
							if($('#insert').val() == "Добави"){
							  $('#insert').val("Добавяне...");
							}
							else if($('#insert').val() == "Промени"){
							  $('#insert').val("Променяне...");
							}
							$('#insert_form')[0].reset();  
							$('#add_data_Modal').modal('hide');  
							$('#cases_table').html(responseText.output);
						  } 
                     }
                });  
           /*}
		   else {
			   alert("Всички полета са задължителни!");
		   }*/
		});	
			
		$(document).on('click', '.view_data', function(){  
           var case_id = $(this).attr("id");  
           if(case_id != '')  
           {  
                $.ajax({  
                     url:"select.php",  
                     method:"POST",  
                     data:{case_id:case_id},  
                     success:function(data){  
                          $('#case_detail').html(data);  
                          $('#dataModal').modal('show');  
                     }  
                });  
           }
			return false;
		});
		
		$(document).on('click', '.delete_data', function(){
		  var confirm = window.confirm("Сигурен ли си, че искаш да изтриеш този случай ?");
		  if(confirm){
			var case_id = $(this).attr("id");
			if(case_id != ''){
				$.ajax({
					url:"delete.php",
					method:"POST",
					data:{case_id:case_id},
					success:function(data){
						$("#cases_table").html(data);
					}
				});
			}
		  }
		  return false;
		});	
 });  
 </script>