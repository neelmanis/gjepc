$(document).ready(function()
{
	var txtCategoryName,txtParentCategory,txtstatus,txtisMenu,txtisFilter;
	
			$("#btnSubmit").click(function ()
			{
				txtCategoryName=$("#txtCategoryName").val();
				txtParentCategory=$("#CategoryContainer").val();
				txtstatus=$("#ActiveContainer").val();
				txtisMenu=$("#MenuContainer").val();
				txtisFilter=$("#FilterContainer").val();
				
				if(txtCategoryName=="")
				{
					alert("Enter Category Name.");
					
				}
				else if(txtParentCategory=="select")
				{
					alert("Select Parent of Category");
				}
				else if(txtstatus=="select")
				{
					alert("Select Status of Category.");
				}
				else if(txtisMenu=="select")
				{
					alert("Select Status of menu for Category.");
				}
				else if(txtisFilter=="select")
				{
					alert("Select Status of filter for Category.");
				}
				else
				{
					$.ajax({
						url:baseurl+"photocategory/submitAdd",
						type:"POST",
						data:{
							CategoryName:txtCategoryName,
							ParentCategory:txtParentCategory,
							Status:txtstatus,
							isMenu:txtisMenu,
							isFilter:txtisFilter
							
						},
						success:function (data)
						{
							if(data==1)
							{
								alert("New Category added Successfully");
								
							}
							else
							{
								alert("Failed to add new Category");
							}
						}
						});
				}
				});
	
	
	
	$("#btnEditSubmit").click(function ()
	{
				txtCategoryName=$("#txtCategoryName").val();
				txtParentCategory=$("#CategoryContainer").val();
				txtstatus=$("#ActiveContainer").val();
				var txtCategoryID=$("#CategoryID").val();
				txtisMenu=$("#MenuContainer").val();
				txtisFilter=$("#FilterContainer").val();
				
				if(txtCategoryName=="")
				{
					alert("Enter Category Name.");
					
				}
				else if(txtParentCategory=="select")
				{
					alert("Select Parent of Category");
				}
				else if(txtstatus=="select")
				{
					alert("Select Status of Category.");
				}
				else if(txtisMenu=="select")
				{
					alert("Select Status of menu for Category.");
				}
				else if(txtisFilter=="select")
				{
					alert("Select Status of filter for Category.");
				}
				else
				{
					$.ajax({
						url:baseurl+"photocategory/submitedit",
						type:"POST",
						data:{
							CategoryName:txtCategoryName,
							ParentCategory:txtParentCategory,
							Status:txtstatus,
							CategoryId:txtCategoryID,
							isMenu:txtisMenu,
							isFilter:txtisFilter
							
						},
						success:function (data)
						{
							
							if(data==1)
							{
								alert("Category updated Succefully");
								
								
							}
							else
							{
								alert("Failed to update Category");
							}
						}
						});
				}
		
		});
		
		
		
    

		
		
	});