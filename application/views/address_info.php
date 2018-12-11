<h1>Enter Address Information</h1>

<fieldset id="signup_errors"></fieldset>

<form>
    <fieldset>
        <legend>Address Information</legend>

        <input type="text" id="street" placeholder="Street" />
        <input type="text" id="house_number" placeholder="House number" />
        <input type="text" id="zip_code" placeholder="Zip code" />
        <input type="text" id="city" placeholder="City" />

        <input type="submit" id="submit_btn" value="Next" />

    </fieldset>
</form>

<script>
    $('#submit_btn').click(function(){
        var form_data = {
            street: $('#street').val(),
            house_number: $('#house_number').val(),
            zip_code: $('#zip_code').val(),
            city: $('#city').val()
        };

        $.ajax({
            url: "<?=site_url('user_account/submit_address_info')?>",
            type: 'POST',
            data: form_data,
            success: function(msg){
                if(msg != 'success')
                {
                    $('#signup_errors').html(msg).css('display', 'block');
                }
                else
                {
                    window.location = "<?=site_url('user_account/payment_info')?>";
                }
            }
        });

        return false;
    });
</script>