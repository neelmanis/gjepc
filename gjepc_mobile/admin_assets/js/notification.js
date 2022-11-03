$(document).ready(function(){
    $(document).ready(function() {
    $('#allchk').click(function(event) {  //on click
        if(this.checked) { // check select status
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"               
            });
        }else{
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                       
            });         
        }
    });
    
});

            $("#btnsubmit").click(function()
                { 
                    var message=$("#txtmsg").val();
					 var body = $("html, body");
                    var Ids = $("#deviceIds:checked").map(function(){
                        return $(this).val();
                                  }).get();
                        if(message=="")
                        {
							
                             body.stop().animate({scrollTop:0}, '500', 'swing', function(){});
                             $(".form_error").css("display","block");
						     $(".form_error").html("Please enter message.").delay(1000).fadeOut(5000);
                        }
                        else if(Ids.length==0)
                        {
                             body.stop().animate({scrollTop:0}, '500', 'swing', function(){});
							 $(".form_error").css("display","block");
						     $(".form_error").html("Please select device.").delay(1000).fadeOut(5000);
                        }
                        else
                        {
                            $.ajax(
                            {
                            url:CI_ROOT+"notification/SendMessage",
                            type:"POST",
                            data:{
                                sendMessage:message,
                                sendIds:Ids
                    
                                    },
                                    success:function (data)
                                    {
										alert(data);
                                        if(data==1)
                                        {
											 body.stop().animate({scrollTop:0}, '500', 'swing', function(){});
											$(".form_success").css("display","block");
						                    $(".form_success").html("Neotification sent.").delay(1000).fadeOut(5000);
                                        }
                                        else
                                        {
											//$(".form_error").css("display","block");
						                    //$(".form_error").html("Failed to send message"+data).delay(1000).fadeOut(5000);
											 body.stop().animate({scrollTop:0}, '500', 'swing', function(){});
											$(".form_error").css("display","block");
						                     $(".form_error").html(data).delay(1000).fadeOut(5000);
											 console.log(data);
                                        }
                                    }

                        });

                        }
                   

                });
        });