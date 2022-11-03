jQuery(document).ready(function ()
	{
		var txtusername,txtpassword;
		jQuery("#btnlogin").click(function ()
			{
				txtusername=jQuery("#txtusername").val();
				txtpassword=jQuery("#txtpassword").val();
					if(txtusername.trim().length==0|| txtusername.trim()=="")
					{
						jQuery(".alert-danger").html("Enter username or email.");
						jQuery(".alert-danger").show();
						jQuery("#txtusername").focus();

					}
					else if(txtpassword==""||txtpassword.length==0)
					{
						jQuery(".alert-danger").html("Enter password.");
						jQuery(".alert-danger").show();
						jQuery("#txtpassword").focus();

						

					}
					else 
					{
						jQuery(".alert-danger").hide();
						jQuery.ajax({
							url:CI_ROOT+"login/signup",
							type:"POST",
							data:{
							username:txtusername,
							password:txtpassword
								},
							success:function (data)
							{
								
								if(data==1)
								{
									jQuery(".alert-success").html("login successfully.");
								jQuery(".alert-success").show();
									window.location.href=CI_ROOT+"dashboard";

								}
								else
								{
									jQuery(".alert-danger").html("Invalid username or password.");
									jQuery(".alert-danger").show();

								}

							}
						});


					}
			});
	});