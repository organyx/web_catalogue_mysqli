<?php $editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
} ?>

<!--
<div id="returnmessage"><p></p></div>
<form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="RegisterForm" id="RegisterForm">
        <table class="TableStyleBig center WidthAuto">
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><table class="TableStyleRegUp center WidthAuto">
              <tr>
                <td><table >
                  <tr class="updateLayout">
                    <td ><label for="FirstName">
                      <h6>First Name <span class="required">*</span> :</h6>
                      <br>
                      </label>
                      <input name="FirstName" type="text" required="required" class="styletxtfield" id="FirstName"></td>
                    <td><label for="LastName">
                      <h6>Last Name:</h6>
                      <br>
                      </label>
                      <input name="LastName" type="text" class="styletxtfield" id="LastName"></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><label for="Email">
                  <h6>Email <span class="required">*</span> :</h6>
                  <br>
                  </label>
                  <input name="Email" type="email" required="required" class="styletxtfield" id="Email"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><table border="0">
                  <tr class="updateLayout">
                    <td><label for="Password">
                      <h6>Password <span class="required">*</span> :</h6>
                      </label>
                      <input name="Password" type="password" required="required" class="styletxtfield" id="Password"></td>
                    <td><label for="PasswordConfirm">
                      <h6>Confirm Password <span class="required">*</span> :</h6>
                      </label>
                      <input name="PasswordConfirm" type="password" required="required" class="styletxtfield" id="PasswordConfirm"></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><label for="Language">
                  <h6>Language <span class="required">*</span> :</h6>
                  <br>
                  </label>
                  <input name="Language" type="text" required="required" class="styletxtfield" id="Language"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><label for="Url">
                  <h6>URL <span class="required">*</span> :</h6>
                  <br>
                  </label>
                  <input name="Url" type="text" required="required" class="styletxtfield" id="Url"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><label for="Title">
                  <h6>Title <span class="required">*</span> :</h6>
                  <br>
                  </label>
                  <input name="Title" type="text" required="required" class="styletxtfield" id="Title"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><label for="Description">
                  <h6>Description <span class="required">*</span> :</h6>
                  <br>
                  </label>
                  <textarea name="Description" required class="styletxtarea" id="Description"></textarea></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><label for="PreviewPicture">
                  <h6>Preview Picture :</h6>
                  <br>
                  </label>
                  <input name="PreviewPicture" type="file" id="PreviewPicture" title="PreviewPicture"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><input type="submit" name="RegisterButton" id="RegisterButton" value="Register"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>
        <input type="hidden" name="MM_insert" value="RegisterForm">
      </form>
-->

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
                <label>First Name:</label>
                <div>
                    <input name="first_name" id="first_name" type="text" maxlength="100" size="60" required/>
                </div>
            </div>
            <div class="ui-field">
                <label>Last Name:</label>
                <div>
                    <input name="last_name" id="last_name" type="text" maxlength="100" size="60"/>
                </div>
            </div>
            <div class="ui-field">
                <label>Email:</label>
                <div>
                    <input name="email" id="email" type="email" maxlength="100" size="60" required/>
                </div>
            </div>
            <div class="ui-field">
                <label>Password:</label>
                <div>
                    <input name="password" id="password" type="password" maxlength="100" size="60" required/>
                </div>
            </div>
            <div class="ui-field">
                <label>Confirm Password:</label>
                <div>
                    <input name="passwordwc" id="passwordwc" type="password" maxlength="100" size="60" required/>
                </div>
            </div>
            <div class="ui-field">
                <label>Language:</label>
                <div>
                    <input name="lang" id="lang" type="text" maxlength="100" size="60"/>
                </div>
            </div>
            <div class="ui-field">
                <label>Url:</label>
                <div>
                    <input name="url" id="url" type="text" maxlength="100" size="60" required/>
                </div>
            </div>
            <div class="ui-field">
                <label>Title:</label>
                <div>
                    <input name="title" id="title" type="text" maxlength="100" size="60" required/>
                </div>
            </div>
            <div class="ui-field">
                <label>Description:</label>
                <div>
                    <textarea name="descr" id="descr" style="width: 385px; height: 80px;"></textarea>
                </div>
            </div>
            <div class="ui-field">
                <label>Preview picture:</label>
                <div>
                    <input name="file" id="file" type="file" title="file" style="width: 385px; height: 30px;"/>
                </div>
            </div>
            <input type="hidden" name="MM_insert" id="MM_insert" value="RegisterForm">
        </div>

        <div class="ui-buttons"> 
            <input type="button" value="Reset" name="reset" id="reset" class="btn"/>
            <input type="submit" value="Register" name="submit" id="register" class="btn" />
        </div>
      </form>
    </div>