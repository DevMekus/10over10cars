export async function getCartItem() {
  const cart = localStorage.getItem("cart")
    ? JSON.parse(localStorage.getItem("cart"))
    : [];

  return cart;
}

export async function setCartItem(setMyCart) {
  /**
   * Sets the Cart
   */

  setMyCart(await getCartItem());
}

export async function getCartTotal(setTotal) {
  /**
   * Calculates the subtotal of the cart
   */
  let total = 0;
  const cart = await getCartItem();

  if (cart && cart.length > 0) {
    cart.forEach((item) => {
      total += Number(item.price);
    });
  }

  setTotal(total);
}

export async function getGrandTotal(cartTotal, transactionTax, setGTotal) {
  /**
   * Adds the subtotal and the Tax
   */
  setGTotal(Number(cartTotal) + Number(transactionTax));
}

export async function clearCart(setMyCart) {
  /**
   * Removes all the Cart Items
   */
  localStorage.removeItem("cart");
  setMyCart(await getCartItem());
  return true;
}

export async function removeCartItem(id, setMyCart, setTotal) {
  /**
   * Removes a cart Item by its ID
   */
  const myCart = await getCartItem();
  const newCart = myCart.filter((item) => Number(item.id) !== id);
  localStorage.setItem("cart", JSON.stringify(newCart));
  setMyCart(await getCartItem());
  getCartTotal(setTotal);
  return true;
}

export function demoItem() {
  const data = [
    { id: 1, name: "Car verification", price: 2000 },
    { id: 2, name: "Purchase", price: 21000 },
    { id: 3, name: "Verification", price: 2000 },
  ];
  localStorage.setItem("cart", JSON.stringify(data));
}
