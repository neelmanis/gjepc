$(document).ready(function ()
{
	$('#SelectAll').click(function(event) {  //on click 
        if(this.checked) { // check select status
            $('.chk1').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"               
            });
        }else{
            $('.chk1').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                       
            });         
        }
    });
    
    
    
    
    
    $("#ActionsContainer").change(function ()
    {
    	var CatId=[];
															
	$('.chk1:checked').each(function(i){
         CatId[i] = $(this).val();
      	 });
    	var CatLenght=CatId.length;
    	if($(this).val()!="select")
    	{
    		if(CatLenght>0)
    		{
				var txtActionType=$(this).val();
			
			$.ajax({
				url:baseurl+"photocategory/ActionTask",
				type:"POST",
				data:{
					Type:txtActionType,
					CategoryId:CatId
					},
				success:function (data)
				{
					if(data>0)
					{
						alert(data+" categories modified.");
						location.reload();
						
					}
					else
					{
						alert(data+" failed to modify Category");
					}
				}	
				
				
				});
			}
			else
			{
				alert("atlease select one Category");
			}
			
		}
		
		
    	
    	
    	});
    
    
    
    
	});