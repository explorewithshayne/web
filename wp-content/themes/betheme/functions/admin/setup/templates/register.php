<div id="mfn-setup" class="mfn-ui mfn-setup unregistered loading clearfix">

  <span class="mfn-color-scheme">
    <i class="icon-moon dark"></i>
    <i class="icon-light-up light"></i>
  </span>

  <div class="mfn-wrapper">

    <div class="setup-register">

      <div class="register-header">

        <span class="logo"></span>

        <h2>Welcome to Betheme</h2>
        <p>
          Please register this version of theme to get access to all built-in premium features.
        </p>

      </div>

      <form class="register-content mfn-form-reg" method="post">

        <input type="hidden" name="mfn-setup-nonce" value="<?php echo wp_create_nonce( 'mfn-setup-register' ); ?>">
        <input type="hidden" name="mfn-builder-nonce" value="<?php echo wp_create_nonce( 'mfn-builder-nonce' ); ?>">
        <input type="hidden" name="action" value="mfn_setup_register">
        <input type="submit" name="submit" value="mfn_setup_register" style="display:none">

        <div class="input-wrapper">
          <i class="icon-key-line"></i>
          <input type="text" name="code" placeholder="Paste your purchase code here" >
        </div>

        <a id="register" class="mfn-btn mfn-btn-blue btn-large">Register theme</a>

        <div class="form-message"></div>

        <div class="where-is-code">
          <p class="question"><i class="far fa-question-circle"></i> Where can I find my purchase code?</p>
          <ol class="answear">
            <li>Please go to <a target="_blank" href="https://themeforest.net/downloads">themeforest.net/downloads</a></li>
            <li>Click the <strong>Download</strong> button in Betheme row</li>
            <li>Select <strong>License Certificate &amp; Purchase code</strong></li>
            <li>Copy <strong>Item Purchase Code</strong></li>
          </ol>
        </div>

      </form>

      <div class="register-footer">

        <p>
          Don't have license or need another one?<br />
          <a target="_blank" href="https://1.envato.market/DENky">Purchase new license</a>
        </p>

      </div>

    </div>

  </div>

</div>
