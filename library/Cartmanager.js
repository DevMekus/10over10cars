export const tax = 1000.0;

export const getCartItem = () => {
  /**
   * get items from the localstorage
   */
  return localStorage.getItem("cart")
    ? JSON.parse(localStorage.getItem("cart"))
    : [];
};

export function calculateCartTotal(cartItem) {
  let total = 0;
  cartItem.forEach((item) => {
    total += Number(item.price);
  });
  return total;
}

export function calculateGrandTotal(cartTotal, transactionTax) {
  return Number(cartTotal) + Number(transactionTax);
}

export function clearCart() {
  alert("Clearing cart");
}

export function removeCartItem(id) {
  alert("Removing an Item");
}
