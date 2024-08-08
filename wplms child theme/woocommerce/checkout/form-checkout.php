<?php

/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if (!defined('ABSPATH')) {
    exit;
}

do_action('woocommerce_before_checkout_form', $checkout);

// If checkout registration is disabled and not logged in, the user cannot checkout.
if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
    echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
    return;
}

?>

<style>
    .woocommerce form.checkout .woocommerce-billing-fields__field-wrapper label,
    .woocommerce-terms-and-conditions-wrapper {
        display: none;
    }

    .woocommerce-checkout #content .container {
        max-width: 100%;
        padding: 0;
        width: 100%;
    }

    .mha_checkout_leftside {
        padding-left: 16% !important;
        padding-right: 2% !important;
        background: #fff;
    }

    .mha_checkout_rightside {
        padding-right: 16% !important;
        padding-left: 2% !important;
        background: #F7F9FA;
    }

    .mha_checkout_leftside h1 {
        font-family: "Public Sans", sans-serif;
        font-size: 32px;
        font-weight: 700;
        line-height: 37.97px;
        color: #2B354E;
    }

    .mha_checkout_leftside h4 {
        font-family: "Inter", sans-serif;
        font-size: 18px;
        font-weight: 500;
        line-height: 24px;
        color: #2B354E;
    }

    .mha_checkout_leftside h2 {
        font-family: "Inter", sans-serif;
        font-size: 22px;
        font-weight: 700;
        line-height: 37.97px;
        color: #2B354E;
    }

    .mha_checkout_leftside td {
        border: 0 !important;
    }

    .mha_checkout_leftside .product-name {
        font-family: "Inter", sans-serif;
        font-size: 14px;
        font-weight: 700;
        line-height: 22.4px;
        color: #2B354E;
    }

    .mha_checkout_leftside .product-total {
        font-weight: 600;
    }

    .mha_checkout_leftside .product-total span {
        color: #2B354E;
    }

    #customer_details .woocommerce-billing-fields h3 {
        font-family: "Inter", sans-serif;
        font-size: 22px;
        font-weight: 700;
        line-height: 37.97px;
        color: #2B354E;
    }

    #customer_details .input-text,
    #customer_details .select2-selection {
        background: #F8FAFC;
        border: 0;
        padding: 12px 15px;
        font-family: "Inter", sans-serif;
        font-size: 12px;
        font-weight: 500;
        line-height: 20px;
        color: #64748B;
        height: 44px;
    }

    #customer_details .select2-selection {
        padding: 0 15px;
        display: flex;
        align-items: center;
    }

    #customer_details .select2-selection__rendered {
        padding: 0;
        font-family: "Inter", sans-serif;
        font-size: 12px;
        font-weight: 500;
        line-height: 20px;
        color: #64748B;
    }

    #customer_details .select2-selection__arrow {
        top: 8px;
        right: 20px;
    }

    .payment_title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }

    .payment_title span {
        font-family: "Inter", sans-serif;
        font-size: 12px;
        font-weight: 500;
        line-height: 27.79px;
        color: #64748B;
    }

    .mha_checkout_rightside>h1 {
        font-family: "Inter", sans-serif;
        font-size: 24px;
        font-weight: 700;
        line-height: 38.4px;
        color: #2B354E;
    }

    .mha_checkout_rightside table {
        width: 100%;
    }

    .mha_checkout_rightside table th {
        font-family: "Inter", sans-serif;
        font-size: 14px;
        font-weight: 400;
        line-height: 22.4px;
        color: #64748B;
        padding: 8px 0;
    }

    .mha_checkout_rightside table td {
        font-family: "Inter", sans-serif;
        font-size: 14px;
        font-weight: 400;
        line-height: 22.4px;
        color: #64748B;
        padding: 8px 0;
        text-align: right;
    }

    .mha_checkout_rightside table .order-total {
        border-top: 1px solid #E0DFFF;
    }

    .mha_checkout_rightside table .order-total th {
        font-size: 16px;
        font-weight: 700;
        line-height: 25.6px;
        color: #2B354E;
    }

    .mha_checkout_rightside table .order-total td {
        font-size: 16px;
        font-weight: 700;
        line-height: 25.6px;
        color: #2B354E;
    }

    .mha_checkout_rightside .terms_con_txt {
        font-family: "Inter", sans-serif;
        font-size: 12px;
        font-weight: 400;
        line-height: 19.2px;
        color: #64748B;
        margin: 10px 0;
    }

    .mha_checkout_rightside .terms_con_txt a {
        color: #5B3671;
    }

    .mha_checkout_rightside #place_order {
        background: #5B3671 !important;
        width: 100%;
        height: 45px;
        font-family: "Inter", sans-serif;
        font-size: 14px;
        font-weight: 600;
        line-height: 22.4px;
        border-radius: 4px;
    }

    .mha_checkout_rightside .money_back_gurantee {
        display: block;
        font-family: "Inter", sans-serif;
        font-size: 12px;
        font-weight: 400;
        line-height: 19.2px;
        text-align: center;
        margin-top: 8px;
    }

    .woocommerce-checkout #payment ul {
        padding: 0 !important;
        border-bottom: 0 !important;
    }

    .woocommerce-checkout #payment {
        border: 1px solid #E0DFFF;
        border-radius: 0;
    }

    .woocommerce-checkout #payment ul.payment_methods li {
        background: #F7F9FA;
    }

    .woocommerce-checkout #payment div.payment_box {
        background: #fff;
        border-top: 0.58px solid #E0DFFF;
        margin: 0;
        padding: 20px 17px;
    }

    .woocommerce-checkout #payment div.payment_box:before {
        display: none;
    }

    .woocommerce-checkout #payment ul.payment_methods li input[type="radio"] {
        accent-color: #4D4D4D;
        margin: 0 0 0 23px;
    }

    .woocommerce-checkout #payment ul.payment_methods li>label {
        color: #2B354E;
        font-family: "Inter", sans-serif;
        font-size: 16px;
        font-weight: 600;
        line-height: 27.79px;
        margin: 0;
        padding: 12px 10px;
    }

    .woocommerce-checkout #payment div.payment_box p {
        color: #2B354E;
        font-family: "Inter", sans-serif;
        font-size: 16px;
        font-weight: 400;
        line-height: 25.6px;
    }


    .woocommerce-checkout #payment .payment_method_paypal .about_paypal {
        padding-right: 23px;
    }

    .woocommerce-checkout .container-fluid>.row {
        display: flex;
    }

    @media (max-width: 991px) {
        .mha_checkout_leftside {
            padding: 15px !important;
        }

        .mha_checkout_rightside {
            background: #fff;
            padding: 15px !important;
        }

        .woocommerce-checkout .container-fluid>.row {
            flex-direction: column;
        }
    }

    .woocommerce form .form-row label {
        font-family: "Inter", sans-serif;
        font-size: 16px;
        font-weight: 600;
        line-height: 25.6px;
        color: #2B354E;
    }

    .wc-stripe-elements-field,
    .wc-stripe-iban-element-field {
        border: 1.16px solid #E0DFFF;
        padding: 13px 24px;
        font-family: "Inter", sans-serif;
        font-size: 12px;
        font-weight: 500;
        line-height: 23.16px;
        color: #64748B;
    }

    .woocommerce-checkout #payment div.form-row {
        padding: 0;
    }

    #billing_first_name_field {
        width: 50%;
        display: inline-block;
    }

    #billing_last_name_field {
        width: 50%;
        display: inline-block;
    }

    button[type="submit"].button,
    a.button {
        color: #fff !important;
        border: 1px solid rgba(91, 54, 113, 1) !important;
    }
</style>


<form name="checkout" method="post" class="checkout woocommerce-checkout"
    action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">

    <section class="container-fluid">
        <div class="row">
            <div class="col-md-7 mha_checkout_leftside">
                <h1>Checkout</h1>
                <h4>Checkout your cart</h4>
                <h2>Order Details</h2>
                <?php if ($checkout->get_checkout_fields()): ?>

                    <?php do_action('woocommerce_checkout_before_customer_details'); ?>

                    <div class="col2-set" id="customer_details">
                        <div class="col-1">
                            <?php do_action('woocommerce_checkout_billing'); ?>
                        </div>

                        <div class="col-2">
                            <?php do_action('woocommerce_checkout_shipping'); ?>
                        </div>
                    </div>

                    <?php do_action('woocommerce_checkout_after_customer_details'); ?>

                <?php endif; ?>


                <?php do_action('woocommerce_checkout_before_order_review'); ?>
                <div class="payment_title">
                    <h2>Payment method</h2><span>Secured connection </span>
                </div>
                <div id="order_review" class="woocommerce-checkout-review-order">
                    <?php do_action('woocommerce_review_order_before_payment'); ?>
                    <div id="payment" class="woocommerce-checkout-payment">



                    </div>
                    <?php do_action('woocommerce_review_order_before_submit'); ?>
                    <button type="submit" class="button alt" name="woocommerce_checkout_place_order" id="place_order"
                        value="Place Order" data-value="Place Order">Place Order</button>
                    <?php do_action('woocommerce_review_order_after_submit'); ?>
                    <?php do_action('woocommerce_review_order_after_payment'); ?>
                </div>

                <?php do_action('woocommerce_checkout_after_order_review'); ?>



            </div>
            <div class="col-md-5 mha_checkout_rightside">
                <h1>Summery </h1>
                <table>
                    <tfoot>

                        <tr class="cart-subtotal">
                            <th><?php esc_html_e('Orginal Price:', 'woocommerce'); ?></th>
                            <td><?php wc_cart_totals_subtotal_html(); ?></td>
                        </tr>

                        <?php foreach (WC()->cart->get_coupons() as $code => $coupon): ?>
                            <tr class="cart-discount coupon-<?php echo esc_attr(sanitize_title($code)); ?>">
                                <th><?php wc_cart_totals_coupon_label($coupon); ?></th>
                                <td><?php wc_cart_totals_coupon_html($coupon); ?></td>
                            </tr>
                        <?php endforeach; ?>

                        <?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()): ?>

                            <?php do_action('woocommerce_review_order_before_shipping'); ?>

                            <?php wc_cart_totals_shipping_html(); ?>

                            <?php do_action('woocommerce_review_order_after_shipping'); ?>

                        <?php endif; ?>

                        <?php foreach (WC()->cart->get_fees() as $fee): ?>
                            <tr class="fee">
                                <th><?php echo esc_html($fee->name); ?></th>
                                <td><?php wc_cart_totals_fee_html($fee); ?></td>
                            </tr>
                        <?php endforeach; ?>

                        <?php if (wc_tax_enabled() && !WC()->cart->display_prices_including_tax()): ?>
                            <?php if ('itemized' === get_option('woocommerce_tax_total_display')): ?>
                                <?php foreach (WC()->cart->get_tax_totals() as $code => $tax): // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited 
                                                ?>
                                    <tr class="tax-rate tax-rate-<?php echo esc_attr(sanitize_title($code)); ?>">
                                        <th><?php echo esc_html($tax->label); ?></th>
                                        <td><?php echo wp_kses_post($tax->formatted_amount); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr class="tax-total">
                                    <th><?php echo esc_html(WC()->countries->tax_or_vat()); ?></th>
                                    <td><?php wc_cart_totals_taxes_total_html(); ?></td>
                                </tr>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php do_action('woocommerce_review_order_before_order_total'); ?>

                        <tr class="order-total">
                            <th><?php esc_html_e('Total:', 'woocommerce'); ?></th>
                            <td><?php wc_cart_totals_order_total_html(); ?></td>
                        </tr>

                        <?php do_action('woocommerce_review_order_after_order_total'); ?>

                    </tfoot>
                </table>


            </div>
        </div>
    </section>





</form>

<?php do_action('woocommerce_after_checkout_form', $checkout); ?>