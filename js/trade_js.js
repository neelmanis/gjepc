$(document).ready(function() {
  $('#customer_add').change(function() {
    /*alert($( this ).val());*/
    var option = $(this).val();
    var reg_id = $('#registration_id').val();

    $.ajax({
      type: 'POST',
      url: 'ajax_trade.php',
      data: "actiontype=optionValue&&option=" + option + "&&reg_id=" + reg_id,
      dataType: 'html',
      beforeSend: function() {},
      success: function(data) {
        //alert(data);
        //console.log(data);
        if ($.trim(data) != "") {
          //$('#selected_area').html(data);
          data = data.split("#");
          // $("#member_name").val(data[0]);
          $("#address1").val(data[1]);
          $("#address1").attr('data-content', data[1]);
          $("#address2").val(data[2]);
          $("#address2").attr('data-content', data[2]);
          $("#city").val(data[3]);
          $("#pincode").val(data[4]);
          $("#communication_id").val(data[6]);
        }
      }
    });
  });
});

function validate() {
  var permission_no = $("#permission_no").val();
  var membership_id = $("#membership_id").val();
  if (membership_id == '') {
    alert('Please Enter Membership Id');
    $("#membership_id").focus();
    return false;
  }
  var customer_add = $("#customer_add").val();
  if (customer_add == '') {
    alert('Please select customer address');
    $("#customer_add").focus()
    return false;
  }
  var commemail = $("#commemail").val();
  if (commemail == '') {
    alert('Please enter communication email id');
    $("#commemail").focus()
    return false;
  }

  var permission_type = $("#permission_type").val();
  if (permission_type == '') {
    alert('Please select permission type');
    return false;
  } else if (permission_type == 'promotional_tour' || permission_type == 'person_hand') {
    var visiting_countries1 = $("#visiting_countries1").val();
    if (visiting_countries1 == '') {
      alert('Please Enter visiting countries1');
      $("#visiting_countries1").focus();
      return false;
    } else {
      var reg_alpha = /^[a-zA-Z ]{1,20}$/;
      if (!reg_alpha.test($("#visiting_countries1").val())) {
        alert("please Enter Only charatcters for visiting countries1");
        $("#visiting_countries1").focus();
        return false;
      }
    }
  }

  var item1 = $("#item1").val();
  if (item1 == '') {
    alert('Please Enter Item1');
    $("#item1").focus();
    return false;
  } else {
    var invoice_value1 = $("#invoice_value1").val();
    if (invoice_value1 == '') {
      alert('Please Enter Invoice Value 1');
      $("#invoice_value1").focus();
      return false;
    } else {
      var reg_invoice_value1 = /^[0-9 ]{1,20}$/;
      if (!reg_invoice_value1.test($("#invoice_value1").val())) {
        alert("Please Enter Only Numbers for invoice value1");
        $("#invoice_value1").focus();
        return false;
      }
    }
  }
  if (permission_type == 'promotional_tour') {
    var apprx_invoice_value = $("#apprx_invoice_value").val();
    if (apprx_invoice_value > 1000000) {
      alert('Sorry your invoice value is crossing the limit');
      $("#apprx_invoice_value").focus();
      return false;
    } else {
      var reg_apprx_invoice_value = /^[0-9]{1,20}$/;
      if (!reg_apprx_invoice_value.test($("#apprx_invoice_value").val())) {
        alert("please Enter Only numbers for Item");
        $("#apprx_invoice_value").focus();
        return false;
      }
    }
  }

  var bank_name = $("#bank_name").val();
  if (bank_name == '') {
    alert('Please Select Bank Name');
    $("#bank_name").focus();
    return false;
  } else {
    var reg_bank_name = /^[a-zA-Z ]+$/;
    if (!reg_bank_name.test($("#bank_name").val())) {
      alert("Please Enter Only Characters for Bank Name.");
      $("#bank_name").focus();
      return false;
    }
  }
  var bank_branch = $("#bank_branch").val();
  if (bank_branch == '') {
    alert('Please Enter Bank Branch');
    $("#bank_branch").focus();
    return false;
  } else {
    var reg_bank_branch = /^[a-zA-Z ]{1,20}$/;
    if (!reg_bank_branch.test($("#bank_branch").val())) {
      alert("Please Enter Only Characters in Bank Branch.");
      $("#bank_branch").focus();
      return false;
    }
  }
  if (permission_type == 'promotional_tour') {
    var person_name_carrying = $("#person_name_carrying").val();
    if (person_name_carrying == '') {
      alert('Please Enter Person name carrying');
      $("#person_name_carrying").focus();
      return false;
    } else {
      var reg_person_name_carrying = /^[a-zA-Z ]{1,20}$/;
      if (!reg_person_name_carrying.test($("#person_name_carrying").val())) {
        alert("please Enter Only charatcters for Person name carrying");
        $("#person_name_carrying").focus();
        return false;
      }
    }

    var passport_no = $("#passport_no").val();
    if (passport_no == '') {
      alert('Please Enter Passport No');
      $("#passport_no").focus();
      return false;
    }

    var date_of_daparture = $("#date_of_daparture").val();
    if (date_of_daparture == '') {
      alert('Please Enter Date of Departure');
      $("#date_of_daparture").focus();
      return false;
    }
    var from_date = $("#from_date").val();
    if (from_date == '') {
      alert('Please Enter From date');
      $("#from_date").focus();
      return false;
    }

    var to_date = $("#to_date").val();
    if (to_date == '') {
      alert('Please Enter To date');
      $("#to_date").focus();
      return false;
    }
  }
  var region_code = $("#region_code").val();
  if (region_code == '') {
    alert('Please Enter Region code');
    $("#region_code").focus();
    return false;
  }

  from_date = from_date.split('-');
  to_date = to_date.split('-');

  from_date = new Date(from_date[2], from_date[1], from_date[0]);
  to_date = new Date(to_date[2], to_date[1], to_date[0]);
  date1_unixtime = parseInt(from_date.getTime() / 1000);
  date2_unixtime = parseInt(to_date.getTime() / 1000);

  var timeDifference = date2_unixtime - date1_unixtime;
  var timeDifferenceInHours = timeDifference / 60 / 60;
  var timeDifferenceInDays = timeDifferenceInHours / 24;

  if (timeDifferenceInDays > 45) {
    alert("The from date and to date should not exceed 45 days");
    $("#to_date").focus();
    return false;
  }
}

function getexportdata1(val) {
  var actual_invoice_amt = $("#actual_invoice_amt").val();
  var amt = actual_invoice_amt - val;
  if (amt < 0)
    amt = 0
  $('#sold_amt').val(amt);
}

$(document).ready(function() {
  $('#permission_type').change(function() {
    var p_type = $(this).val();
    if (p_type == "exhibition") {
      $("#visiting_countries1").attr("disabled", "disabled");
      $("#city1").attr("disabled", "disabled");
      $("#visiting_countries2").attr("disabled", "disabled");
      $("#city2").attr("disabled", "disabled");
      $("#visiting_countries3").attr("disabled", "disabled");
      $("#city3").attr("disabled", "disabled");
      $("#visiting_countries4").attr("disabled", "disabled");
      $("#city4").attr("disabled", "disabled");
      $("#visiting_countries5").attr("disabled", "disabled");
      $("#city5").attr("disabled", "disabled");
      $("#visiting_countries6").attr("disabled", "disabled");
      $("#city6").attr("disabled", "disabled");
      $("#reg_brand_name_of_j").attr("disabled", "disabled");
      $("#reg_brand_name_of_a").attr("disabled", "disabled");
      $("#address_of_place_of_dis").attr("disabled", "disabled");
      $("#type_of_good").attr("disabled", "disabled");
      $("#date_of_daparture").attr("disabled", "disabled");
      $('.repeatInThis').hide();
      $('.exh_date').hide();
      $('.from_date').attr("disabled", "disabled");
      $('.to_date').attr("disabled", "disabled");
    } else if (p_type == "branded_jewellery") {
      $("#visiting_countries1").attr("disabled", "disabled");
      $("#city1").attr("disabled", "disabled");
      $("#visiting_countries2").attr("disabled", "disabled");
      $("#city2").attr("disabled", "disabled");
      $("#visiting_countries3").attr("disabled", "disabled");
      $("#city3").attr("disabled", "disabled");
      $("#visiting_countries4").attr("disabled", "disabled");
      $("#city4").attr("disabled", "disabled");
      $("#visiting_countries5").attr("disabled", "disabled");
      $("#city5").attr("disabled", "disabled");
      $("#visiting_countries6").attr("disabled", "disabled");
      $("#city6").attr("disabled", "disabled");

      $("#reg_brand_name_of_j").removeAttr('disabled');
      $("#reg_brand_name_of_a").removeAttr('disabled');
      $("#address_of_place_of_dis").removeAttr('disabled');
      $("#type_of_good").attr("disabled", "disabled");
      $("#person_name_carrying").attr("disabled", "disabled");
      $("#passport_no").attr("disabled", "disabled");
      $("#date_of_daparture").attr("disabled", "disabled");
      $('.repeatInThis').show();
      $('.exh_date').show();
      $('.from_date').removeAttr('disabled');
      $('.to_date').removeAttr('disabled');
    } else if (p_type == "promotional_tour") {
      $("#visiting_countries1").removeAttr('disabled');
      $("#city1").removeAttr('disabled');
      $("#visiting_countries2").removeAttr('disabled');
      $("#city2").removeAttr('disabled');
      $("#visiting_countries3").removeAttr('disabled');
      $("#city3").removeAttr('disabled');
      $("#visiting_countries4").removeAttr('disabled');
      $("#city4").removeAttr('disabled');
      $("#visiting_countries5").removeAttr('disabled');
      $("#city5").removeAttr('disabled');
      $("#visiting_countries6").removeAttr('disabled');
      $("#city6").removeAttr('disabled');
      $("#reg_brand_name_of_j").attr("disabled", "disabled");
      $("#reg_brand_name_of_a").attr("disabled", "disabled");
      $("#address_of_place_of_dis").attr("disabled", "disabled");
      $("#address_of_place_of_dis").attr("disabled", "disabled");
      $("#type_of_good").removeAttr('disabled');
      $("#person_name_carrying").removeAttr('disabled');
      $("#passport_no").removeAttr('disabled');
      $("#date_of_daparture").removeAttr('disabled');
      $('.repeatInThis').show();
      $('.exh_date').show();
      $('.from_date').removeAttr('disabled');
      $('.to_date').removeAttr('disabled');
    } else {
      $("#visiting_countries1").removeAttr('disabled');
      $("#city1").removeAttr('disabled');
      $("#visiting_countries2").removeAttr('disabled');
      $("#city2").removeAttr('disabled');
      $("#visiting_countries3").removeAttr('disabled');
      $("#city3").removeAttr('disabled');
      $("#visiting_countries4").removeAttr('disabled');
      $("#city4").removeAttr('disabled');
      $("#visiting_countries5").removeAttr('disabled');
      $("#city5").removeAttr('disabled');
      $("#visiting_countries6").removeAttr('disabled');
      $("#city6").removeAttr('disabled');
      $("#reg_brand_name_of_j").attr("disabled", "disabled");
      $("#reg_brand_name_of_a").attr("disabled", "disabled");
      $("#address_of_place_of_dis").attr("disabled", "disabled");
      $("#address_of_place_of_dis").attr("disabled", "disabled");
      $("#type_of_good").attr("disabled", "disabled");
      $("#person_name_carrying").attr("disabled", "disabled");
      $("#passport_no").attr("disabled", "disabled");
      $("#date_of_daparture").attr("disabled", "disabled");
      $('.repeatInThis').show();
      $('.exh_date').show();
      $('.from_date').removeAttr('disabled');
      $('.to_date').removeAttr('disabled');
    }
  });
});

$(document).ready(function() {
  var maxField = 6; //Input fields increment limitation
  var addButton = $('.add_button'); //Add button selector
  var wrapper = $('.repeatInThis'); //Input field wrapper
  var fieldHTML = jQuery('.repeatThis').html();
  var fieldHTML = "<div>" + fieldHTML + "<button href='javascript:void(0);' class='btn remove_button' title='Remove field'><i class='fa fa-minus' aria-hidden='true'> Remove</button><div class='clear'></div></div>";
  //console.log(fieldHTML);
  var x = 1; //Initial field counter is 1
  $(addButton).click(function() { //Once add button is clicked
    if (x < maxField) { //Check maximum number of input fields
      x++; //Increment field counter
      console.log(x);
      $(wrapper).append(fieldHTML); // Add field html
    }

    $('.remove_button').on("click", function() { //Once remove button is clicked
      //event.preventDefault();
      $(this).parent('div').remove(); //Remove field html
      x--; //Decrement field counter
      console.log(x);
    });

  });

});