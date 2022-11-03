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
    	var CurrencyId=[];
															
	$('.chk1:checked').each(function(i){
         CurrencyId[i] = $(this).val();
      	 });
    	var CatLenght=CurrencyId.length;
    	if($(this).val()!="select")
    	{
    		if(CatLenght>0)
    		{
				var txtActionType=$(this).val();
			
			$.ajax({
				url:baseurl+"currency/ActionTask",
				type:"POST",
				data:{
					Type:txtActionType,
					CurrencyIds:CurrencyId
					},
				success:function (data)
				{
					if(data>0)
					{
						alert(data+" currency modified.");
						
					}
					else
					{
						alert(data);
					}
				}	
				
				
				});
			}
			else
			{
				alert("atlease select one currency");
			}
			
		}
		
		
    	
    	
    	});
    
    
    
    
	});