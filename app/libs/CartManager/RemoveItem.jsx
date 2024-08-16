import GetCart from "./GetCart";

const RemoveItem = (id, cart, setCart) => {
    const newCart = cart.filter((item) => Number(item.id) !== id);

    if (newCart.length !== cart.length) {
      localStorage.setItem("cart", JSON.stringify(newCart));
      setCart(newCart);
      return true;  // Return true if an item was removed
    } else {
      return false; // Return false if no item was removed (e.g., item with the given id was not found)
    }
};

export default RemoveItem;
