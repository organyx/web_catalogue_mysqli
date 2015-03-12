<?php $editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
} ?>



<form method="POST" id="registrationForm" action="javascript:void(null);" >
    <div class="ui-form ui-600">
        <div class="ui-page">
          <div class="ui-field">
                <label></label>
                <div>
                    <p id="returnmessage"></p>
                </div>
            </div>
            <div class="ui-field">
                <label for="first_name">First Name<span class="required">*</span>:</label>
                <div>
                    <input name="first_name" id="first_name" type="text" maxlength="100" size="51" required/>
                </div>
            </div>
            <div class="ui-field">
                <label for="last_name">Last Name:</label>
                <div>
                    <input name="last_name" id="last_name" type="text" maxlength="100" size="51"/>
                </div>
            </div>
            <div class="ui-field">
                <label for="email">Email<span class="required">*</span>:</label>
                <div>
                    <input name="email" id="email" type="email" maxlength="100" size="51" required/>
                </div>
            </div>
            <div class="ui-field">
                <label for="password">Password<span class="required">*</span>:</label>
                <div>
                    <input name="password" id="password" type="password" maxlength="100" size="51" required/>
                </div>
            </div>
            <div class="ui-field">
                <label for="passwordwc">Confirm Password<span class="required">*</span>:</label>
                <div>
                    <input name="passwordwc" id="passwordwc" type="password" maxlength="100" size="51" required/>
                </div>
            </div>
            <div class="ui-field">
                <label for="lang">Language:</label>
                <div>
                    <input name="lang" id="lang" type="text" maxlength="100" size="51"/>
                </div>
            </div>
            <div class="ui-field">
                <label for="url">Url<span class="required">*</span>:</label>
                <div>
                    <input name="url" id="url" type="text" maxlength="100" size="51" required/>
                </div>
            </div>
            <div class="ui-field">
                <label for="title">Title<span class="required">*</span>:</label>
                <div>
                    <input name="title" id="title" type="text" maxlength="100" size="51" required/>
                </div>
            </div>
            <div class="ui-field">
                <label for="descr">Description:</label>
                <div>
                    <textarea name="descr" id="descr" style="width: 385px; height: 80px;"></textarea>
                </div>
            </div>
            <div class="ui-field">
                <label for="file">Preview picture:</label>
                <div>
                    <input name="file" id="file" type="file" title="file" style="width: 385px; height: 30px;"/>
                </div>
            </div>
            <input type="hidden" name="MM_insert" id="MM_insert" value="RegisterForm">
        </div>

        <div class="ui-buttons"> 
            <input type="button" value="Reset" name="reset" id="reset" class="btn" />
            <input type="submit" value="Register" name="submit" id="register" class="btn" />
        </div>
    </div>
</form>
