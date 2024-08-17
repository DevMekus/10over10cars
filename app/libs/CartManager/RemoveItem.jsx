

const RemoveItem = (id, cart, setCart) => {
  console.log(cart)
    const newCart = cart.filter((item) => Number(item.id) !== id);

    if (newCart.length !== cart.length) {
      localStorage.setItem("cart", JSON.stringify(newCart));
      setCart(newCart);
      return true;  
    } else {
      return false; 
    }
};

export default RemoveItem;
