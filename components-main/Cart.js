"use client";
import Link from "next/link";
import { useState, useEffect } from "react";
import React from "react";

const Cart = ({ cart, setcart, removeCartItem }) => {
  const [error, setError] = useState(null);
  const [success, setSuccess] = useState(null);
  useEffect(() => {
    //setCartItem(setcart);
    // const data = [
    //   { id: 1, name: "Car verification", price: 2000 },
    //   { id: 2, name: "Purchase", price: 21000 },
    //   { id: 3, name: "Verification", price: 2000 },
    // ];
    // localStorage.setItem("cart", JSON.stringify(data));
  }, []);

  const handleRemoveItem = (id) => {
    const success = removeCartItem(id);
    if (success) {
      setSuccess("Item Deleted.");
      const myCart = localStorage.getItem("cart")
        ? JSON.parse(localStorage.getItem("cart"))
        : [];
      setcart(myCart);
    } else {
      setError("Error encountered");
    }
    setTimeout(() => {
      setSuccess("");
      setError("");
    }, 1500);
  };

  return (
    <>
      <div className="cart">
        <div className="flex">
          <span className="material-symbols-outlined t-nav-icon">
            shopping_cart
          </span>
          {cart && cart.length > 0 && (
            <sup>
              <span className="badge bg-success">
                <span className="badge-count">{cart && cart.length}</span>
              </span>
            </sup>
          )}
        </div>
        <div className="cart-drop padding-10 bg-black">
          <h5 className="color-primary">Shopping cart</h5>
          {error && <p className="color-red small-p">{error}</p>}
          {success && <p className="color-green small-p">{success}</p>}
          <hr />
          {cart && cart.length > 0 ? (
            <div>
              {cart.map((item) => (
                <div
                  className="flex f-width space-between align-center"
                  key={item.id}
                >
                  <div className="flex">
                    <p className="color-white small-p">
                      <i
                        className="fas fa-times color-red mr-10 pointer"
                        onClick={() => handleRemoveItem(item.id)}
                      ></i>
                      {item.name}
                    </p>
                  </div>
                  <p className="color-grey small-p">{item.price}</p>
                </div>
              ))}
              <div className="mt-10 flex f-width flex-end">
                <Link
                  href="/dashboard/cart/"
                  className="button button-primary radius-5 no-decoration"
                >
                  Checkout
                </Link>
              </div>
            </div>
          ) : (
            <p className="color-white small-p">
              Your cart is empty.
              <br />
              Continue shopping!
            </p>
          )}
        </div>
      </div>
    </>
  );
};

export default Cart;
