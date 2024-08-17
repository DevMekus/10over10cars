
export const CartTotal = (cart) => {
  let total=0

  if(cart&&cart.length>0){
    cart.forEach(item => {
        total+=Number(item.price);
    });
  }
  return total;
}
