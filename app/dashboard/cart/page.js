"use client";
import React from "react";
import Link from "next/link";
import DashboardsFooter from "@/components/DashboardsFooter";
import { useState, useEffect } from "react";
import {
  setCartItem,
  getCartTotal,
  removeCartItem,
  clearCart,
} from "@/app/libs/CartManager/Cartmanager";
import { useRouter } from "next/navigation";
import GetCart from "@/app/libs/CartManager/GetCart";
import RemoveItem from "@/app/libs/CartManager/RemoveItem";

const page = () => {
  const { cart, setcart } = GetCart();

  const [total, setTotal] = useState(0);
  const [error, setError] = useState(null);
  const [success, setSuccess] = useState(null);
  const router = useRouter();
  useEffect(() => {
    checkoutTotal();
  }, []);

  function checkoutTotal() {
    getCartTotal(setTotal);
  }

  function clearMessages() {
    setTimeout(() => {
      // window.location.reload();
      setError("");
      setSuccess("");
    }, 1500);
  }

  const handleClearCart = () => {
    if (confirm("You are about to clear your cart?")) {
      if (clearCart(setcart)) {
        setSuccess("Cart cleared successfully!");
      } else {
        setError("Error encountered.");
      }
      clearMessages();
    }
  };

  // const handleRemoveItem = (id) => {
  //   if (confirm("You wish to continue?")) {
  //     const newCart = removeCartItem(id, setcart, setTotal);

  //     if (newCart) {
  //       setSuccess("Cart item removed");
  //     } else {
  //       setError("Could not delete the cart item");
  //     }

  //     clearMessages();
  //   }
  // };

  const handleRemoveItem = (id) => {
    if (confirm("You wish to continue?")) {
      const removed = RemoveItem(id, cart, setcart);

      if (removed) {
        setSuccess("Cart item removed");
      } else {
        setError("Could not delete the cart item");
      }
      // Triggering the state to update
      const updatedCart = localStorage.getItem("cart")
        ? JSON.parse(localStorage.getItem("cart"))
        : [];
      setcart(updatedCart);
      clearMessages();
    }
  };
  return (
    <>
      <div className="dash-page">
        <div className="bg-whites padding-20">
          <h3 className="color-primary page-title">Pending transactions</h3>
          <p className="small-p color-white">
            Manage all pending transactions and in-cart orders.
          </p>
          {error && <p className="color-red">{error}</p>}
          {success && <p className="color-green">{success}</p>}
        </div>

        <div className="mt-20">
          {cart && cart.length > 0 && (
            <div className="row">
              <div className="col-sm-8">
                <h4 className="color-white">Cart Items</h4>
                <div className="mt-10 scrollable">
                  <table className="btable">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Product</th>
                        <th scope="col">Price ({"\u20A6"})</th>
                        <th scope="col">Subtotal ({"\u20A6"})</th>
                      </tr>
                    </thead>
                    <tbody>
                      {cart.map((item) => (
                        <tr key={item.id}>
                          <th scope="row">
                            <i
                              className="fas fa-times pointer color-red"
                              onClick={() => handleRemoveItem(item.id)}
                            ></i>
                          </th>
                          <td>{item.name}</td>
                          <td>{item.price}</td>
                          <td> {item.price}</td>
                        </tr>
                      ))}
                    </tbody>
                  </table>
                </div>
              </div>
              <div className="col-sm-4">
                <div className="card-primary padding-20">
                  <div className="flex space-between align-center f-width">
                    <h5 className="color-white">Cart totals</h5>
                    <h5 className="color-white">({"\u20A6"})</h5>
                  </div>
                  <table className="btable mt-10">
                    <thead btable="ptable-success">
                      <tr>
                        <th></th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                          <div className="percenter100 text-center">
                            Subtotal
                          </div>
                        </td>
                        <td>
                          <div>{total}</div>
                        </td>
                      </tr>

                      <tr>
                        <td>
                          <div>Total</div>
                        </td>
                        <td>
                          <div className="">{total}</div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <div className="mt-20 flex f-width gap-10 space-between align-center flex-wrap">
                    <button
                      className="button button-danger radius-5"
                      onClick={handleClearCart}
                    >
                      <i className="fas fa-times mr-10"></i>Clear
                    </button>
                    <Link
                      href="/dashboard/cart/checkout"
                      className="button no-decoration radius-5 button-primary"
                      title="invoice"
                    >
                      Checkout ({"\u20A6"}) {total}{" "}
                      <i className="fas fa-arrow-right"></i>
                    </Link>
                  </div>
                </div>
              </div>
            </div>
          )}
          {cart.length == 0 && (
            <div>
              <h5 className="color-white">Empty Cart</h5>
              <p className="color-white small-p">
                You have no item in your cart
              </p>
            </div>
          )}
        </div>

        <div className="icon-bottom">
          <div
            className="page-icon"
            style={{
              backgroundImage: `url(https://cdn0.iconfinder.com/data/icons/basic-e-commerce-line/48/Receipt_success-256.png)`,
            }}
          ></div>
        </div>
      </div>
      <DashboardsFooter />
    </>
  );
};

export default page;
