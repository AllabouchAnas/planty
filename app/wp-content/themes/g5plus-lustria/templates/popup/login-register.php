<?php
/**
 * Created by PhpStorm.
 * User: MyPC
 * Date: 13/04/2018
 * Time: 10:37 SA
 */
?>
<div id="gsf-popup-login-wrapper" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog woocommerce">
        <form id="gsf-popup-login-form" class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="<?php esc_attr_e('Close', 'g5plus-lustria'); ?>"><i class="fas fa-times"></i>
            </button>
            <div class="modal-header">
                <h4 class="modal-title"><?php esc_html_e('Login', 'g5plus-lustria'); ?></h4>
            </div>
            <div class="modal-body">
                <div class="gsf-popup-login-content">
                    <div class="form-group">
                        <div class="form-row">
                            <input type="text" class="input-text" name="username"
                                   required="required"
                                   placeholder="<?php esc_attr_e('Username', 'g5plus-lustria') ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <input type="password" name="password" class="input-text"
                                   required="required"
                                   placeholder="<?php esc_attr_e('Password', 'g5plus-lustria') ?>">
                        </div>
                    </div>
                    <div class="login-message text-left fs-12"></div>
                </div>
            </div>
            <div class="modal-footer">
                <?php do_action('login_form'); ?>
                <input type="hidden" name="action" value="gsf_user_login_ajax"/>
                <div class="modal-footer-left">
                    <input id="remember-me" type="checkbox" name="rememberme" checked="checked"/>
                    <label for="remember-me"></label>
                    <?php esc_html_e('Remember me', 'g5plus-lustria') ?>
                </div>
                <div class="modal-footer-right">
                    <button data-style="zoom-in" data-spinner-size="30" data-spinner-color="#fff"
                            type="submit"
                            class="ladda-button btn btn-black btn-classic btn-square btn-sm"><?php esc_html_e('Login', 'g5plus-lustria'); ?></button>
                </div>
            </div>
        </form>
    </div>
</div>
<div id="gsf-popup-register-wrapper" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog woocommerce">
        <form id="gsf-popup-register-form" class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="<?php esc_attr_e('Close', 'g5plus-lustria'); ?>"><i class="fas fa-times"></i>
            </button>
            <div class="modal-header">
                <h4 class="modal-title"><?php esc_html_e('Register', 'g5plus-lustria'); ?></h4>
            </div>
            <div class="modal-body">
                <div class="gsf-popup-login-content">
                    <div class="form-group">
                        <div class="form-row">
                            <input type="text" class="input-text" name="username"
                                   required="required"
                                   placeholder="<?php esc_attr_e('Username', 'g5plus-lustria') ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <input type="email" name="email" class="input-text"
                                   required="required"
                                   placeholder="<?php esc_attr_e('Email', 'g5plus-lustria') ?>">
                        </div>
                    </div>
                    <div class="login-message text-left fs-12"></div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="action" value="gsf_user_sign_up_ajax"/>
                <div class="">
                    <button data-style="zoom-in" data-spinner-size="30" data-spinner-color="#fff" type="submit"
                            class="ladda-button btn btn-black btn-classic btn-square btn-sm"><?php esc_html_e('Register', 'g5plus-lustria'); ?></button>
                </div>
                <div class="register-password-mail"><?php esc_html_e('The password will be emailed to you!', 'g5plus-lustria') ?></div>
            </div>
        </form>
    </div>
</div>