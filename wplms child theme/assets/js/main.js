jQuery(document).ready(function ($) {
  // Using event delegation on the closest static parent element
  $(document.body).on(
    "click",
    ".woocommerce-cart-form__cart-item button.plus, .woocommerce-cart-form__cart-item button.minus",
    function () {
      // Get current quantity values
      var qty = $(this)
        .closest(".woocommerce-cart-form__cart-item")
        .find(".qty");
      var val = parseFloat(qty.val());
      var max = parseFloat(qty.attr("max"));
      var min = parseFloat(qty.attr("min"));
      var step = parseFloat(qty.attr("step"));
      var updateCart = $("button[name='update_cart'].button");
      // Change the value if plus or minus
      if ($(this).is(".plus")) {
        if (max && max <= val) {
          qty.val(max);
        } else {
          qty.val(val + step);
          if (updateCart.attr("disabled")) {
            updateCart.removeAttr("disabled");
          }
        }
      } else {
        if (min && min >= val) {
          qty.val(min);
        } else if (val > 1) {
          qty.val(val - step);
          if (updateCart.attr("disabled")) {
            updateCart.removeAttr("disabled");
          }
        }
      }
    }
  );
});


// didn't used 
function decrementControls() {
  // Create decrement button
  const updateCart = document.querySelector(
    "button[name='update_cart'].button"
  );
  const inputElement = document.querySelector(".qty");

  const decrementBtn = document.querySelector(".a2n_minus");
  decrementBtn.onclick = () => {
    if (inputElement.value > 0) {
      inputElement.value = parseInt(inputElement.value) - 1;
    }
    if (updateCart.disabled) {
      updateCart.removeAttribute("disabled");
    }
  };
}

function incrementControls() {
  const updateCart = document.querySelector(
    "button[name='update_cart'].button"
  );
  const inputElement = document.querySelector(".qty");

  // Create increment button
  const incrementBtn = document.querySelector(".a2n_plus");
  incrementBtn.onclick = () => {
    inputElement.value = parseInt(inputElement.value) + 1;
    if (updateCart.disabled) {
      updateCart.removeAttribute("disabled");
    }
  };
}
