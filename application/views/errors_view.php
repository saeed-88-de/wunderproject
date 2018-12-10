<?php

if($errors == 'validation_error')
{
    echo validation_errors('<p>');
}
else if($errors == 'emailexists')
{
    echo '<p>Email address already exists!</p>';
}
else if($errors == 'login_error')
{
    echo 'You have entered an invalid email address and/or password!';
}

?>