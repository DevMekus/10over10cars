"use client";
import Link from "next/link";
import { useState, useEffect } from "react";
import React from "react";
import { removeCartItem, getCartItem } from "@/library/Cartmanager";
import GetCart from "@/app/libs/CartManager/GetCart";
import RemoveItem from "@/app/libs/CartManager/RemoveItem";

import { setCartItem } from "@/app/libs/CartManager/Cartmanager";

const Cart = ({ cart }) => {
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
    if (confirm("You wish to continue?")) {
      const newCart = removeCartItem(id);
      if (newCart) {
        setSuccess("Cart item removed");

        setTimeout(() => {
          setSuccess("");
        }, 1000);
      } else {
        setError("Could not delete the cart item");
      }
    }
  };

  return (
    <>
      <div className="cart">
        <div className="flex">
          <span className="material-symbols-outlined t-nav-icon">
            shopping_cart
          </span>
          {cart.length > 0 && (
            <sup>
              <span className="badge bg-success">
                <span className="badge-count">{cart.length}</span>
              </span>
            </sup>
          )}
        </div>
        <div className="cart-drop padding-10">
          <h5 className="color-primary">Shopping cart</h5>
          <hr />
          {cart.length > 0 && (
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
          )}

          {cart.length == 0 && (
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
