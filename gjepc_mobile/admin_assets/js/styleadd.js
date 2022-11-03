$(document).ready(function ()
{
	var txtstyleName,txtstatus,txtisFilter,txtstyleId;
	
	$("#btnSubmit").click(function ()
	{
			txtstyleName=$("#txtstyleName").val();
			txtstatus=$("#ActiveContainer").val();
			txtisFilter=$("#FilterContainer").val();
			
			if(txtstyleName=="")
			{
				alert("Enter Style Name.");
				
			}
			else if(txtstatus=="select")
			{
				alert("Select Style status");
			}
			else if(txtisFilter=="select")
			{
				alert("Select Style Filter type.");
			}
			else
			{
				$.ajax({
					url:baseurl+"styles/submitAdd",
					type:"POST",
					data:{
						styleName:txtstyleName,
						Status:txtstatus,
						isFilter:txtisFilter
						
					},
					success:function (data)
					{
						if(data==1)
						{
							alert("Style added successfully.");
							
						}
						else{
							alert('Failed to add style.');
						}
					}
					});
			}
		
		
		});
		
		$("#btnEditSubmit").click(function ()
	{
			txtstyleName=$("#txtstyleName").val();
			txtstatus=$("#ActiveContainer").val();
			txtisFilter=$("#FilterContainer").val();
			txtstyleId=$("#txtStyleId").val();
			
			if(txtstyleName=="")
			{
				alert("Enter Style Name.");
				
			}
			else if(txtstatus=="select")
			{
				alert("Select Style status");
			}
			else if(txtisFilter=="select")
			{
				alert("Select Style Filter type.");
			}
			else
			{
				$.ajax({
					url:baseurl+"styles/submitedit",
					type:"POST",
					data:{
						styleName:txtstyleName,
						Status:txtstatus,
						isFilter:txtisFilter,
						styleId:txtstyleId
						
					},
					success:function (data)
					{
						console.log(data);
						if(data==1)
						{
							alert("Style edited successfully.");
							
						}
						else{
							alert('Failed to edit style.');
						}
					}
					});
			}
		
		
		});
	
	
	
	});