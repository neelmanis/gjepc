jQuery(document).ready(function()
	{

		var txtoldpass, txtnewpass, txtconfpass;

		jQuery("#btnsubmit").click(function ()
			{
					txtoldpass=jQuery("#txtoldpass").val();
					txtnewpass=jQuery("#txtnewpass").val();
					txtconfpass=jQuery("#txtconfpass").val();
					if(txtoldpass=="")
					{
						jQuery(".alert-danger").html("Enter old password");
						jQuery(".alert-danger").show();
						jQuery("#txtoldpass").focus();

					}
					else if(txtnewpass=="")
					{

							jQuery(".alert-danger").html("Enter new password");
						jQuery(".alert-danger").show();
						jQuery("#txtnewpass").focus();
					}
					else if(txtconfpass=="")
					{
							jQuery(".alert-danger").html("Enter confirm password");
						jQuery(".alert-danger").show();
						jQuery("#txtconfpass").focus();

					}
					else if(txtnewpass!=txtconfpass)
					{
							jQuery(".alert-danger").html("New password and confirm password must be same");
						jQuery(".alert-danger").show();
						jQuery("#txtconfpass").focus();

					}
					else
					{
						jQuery(".alert-danger").hide();
						txtpassword=txtconfpass;
						jQuery.ajax({
							url:CI_ROOT+"users/submitchangepassword",
							type:"POST",
							data:{
							oldpassword:txtoldpass,
							password:txtpassword
								},
							success:function (data)
							{
								if(data==1)
								{
									jQuery(".alert-success").html("Password changed successfully.");
									jQuery(".alert-success").show();


								}
								else
								{
									jQuery(".alert-danger").html(data);
									jQuery(".alert-danger").show();

								}

							}
						});

					}
			});
	});