<?php
    if (validation_errors())  // validation errors exist
    {
        echo "<div class='alert alert-danger' role='alert'>";
        echo validation_errors();
        echo "</div>";
    }
    
    if (isset($error_message))  // error message exist
    {
        echo "<div class='alert alert-danger' role='alert'>";
        echo $error_message;
        echo "</div>";
    }
    
    if (isset($logout_message))  // display logout message
    {
        echo "<div class='alert alert-success' role='alert'>";
        echo $logout_message;
        echo "</div>";
    }
    
    echo form_open('/upload/user_login_process');
?>

<br>
<div class="row">
    <div class="col-sm-4">
    </div>
    <div class="col-sm-4">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Product Uploader Login</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="emailAddress">Email Address:</label>
                    <input type="text" id="emailAddress" name="emailAddress" value="<?php echo set_value('emailAddress'); ?>" class="form-control">
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" value="<?php echo set_value('password'); ?>" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary btn-block btn-lg">Login</button>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
    </div>
</div>

</form>
</body>
</html>