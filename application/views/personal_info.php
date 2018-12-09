<h1>Enter Personal Information</h1>

<fieldset id="signup_errors"></fieldset>

<form>
  <fieldset>
    <legend>Personal Information</legend>

    <input type="text" id="first_name" placeholder="First Name" />
    <input type="text" id="last_name" placeholder="Last Name" />
    <input type="email" id="email_address" placeholder="Email Address" />
    <input type="tel" id="telephone" placeholder="Telephone" />
    <input type="password" id="password" placeholder="Password" />
    <input type="password" id="password_confirm" placeholder="Retype password" />

    <input type="submit" id="submit_btn" value="Next" />

  </fieldset>
</form>

<script>
  $('#submit_btn').click(function(){
      var form_data = {
          first_name: $('#first_name').val(),
          last_name: $('#last_name').val(),
          email_address: $('#email_address').val(),
          telephone: $('#telephone').val(),
          password: $('#password').val(),
          password_confirm: $('#password_confirm').val()
      };

      $.ajax({
          url: "<?php echo site_url('user_account/submit_personal_info'); ?>",
          type: 'POST',
          data: form_data,
          success: function(msg){
              if(msg != 'success')
              {
                  $('#signup_errors').html(msg).css('display', 'block');
              }
              else
              {
                  window.location = "<?php echo site_url('user_account/address_info') ?>";
              }
          }
      });

      return false;
  });
</script>