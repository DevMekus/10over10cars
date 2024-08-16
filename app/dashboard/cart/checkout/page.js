"use client";
import React from "react";
import Link from "next/link";
import DashboardsFooter from "@/components/DashboardsFooter";
import { useState, useEffect } from "react";
import { redirect } from "next/navigation";

import {
  getCartItem,
  tax,
  removeCartItem,
  calculateCartTotal,
  calculateGrandTotal,
} from "@/library/Cartmanager";

import { getCustomUUID } from "@/library/utils/Utility";

import {
  downloadInvoice,
  printInvoice,
  payInvoice,
} from "@/library/InvoiceManager";
import { getSession } from "@/library/utils/sessionManager";

const page = () => {
  const [cart, setcart] = useState([]);
  const [total, setTotal] = useState(0);
  const [grandTotal, setGrandTotal] = useState(0);
  const [invoiceId, setInvoiceID] = useState("");
  const [sessionId, setsessionId] = useState("");
  const [error, setError] = useState(null);
  const [success, setSuccess] = useState(null);

  useEffect(() => {
    const cartItem = getCartItem();
    setsessionId(getSession());

    if (cartItem.length > 0) {
      setcart(cartItem);
      setTotal(calculateCartTotal(cartItem));
      setGrandTotal(calculateGrandTotal(total, tax));
      setInvoiceID(getCustomUUID(16));
    }
  }, []);

  function printInvoice() {
    window.print();
  }

  function handleDownload() {
    const invoice = document.getElementById("invoice");
    /**
     * Make page format
     */
    downloadInvoice(invoice, invoiceId);
  }

  function handlePayment() {
    if (confirm("You wish to make this payment?")) {
      try{
        const invoiceData = {
          invoiceId,
          grandTotal,
          userid: sessionId,
          cart,
          status: "pending",
        };
  
        const payment = payInvoice(invoiceData);
        if (payment && payment["status"] == "success") {
          redirect("/dashboard/cart/success?id=" + payment["paymentId"]);
        } else {
          setError(payment["message"]);
        }
      }catch(error){
        
      }
    }
  }

  return (
    <>
      <div className="dash-page">
        <div className="card-primarys">
          <h3 class="color-primary page-title">Transaction Invoice</h3>
          <p className="small-p color-grey">Checkout</p>
          <p className="color-white">
            Transaction invoice ID{" "}
            <span className="bold color-primary">{invoiceId}</span>,
          </p>
        </div>
        <div className="mt-20">
          <div className="flex gap-10">
            <button
              className="button button-primary radius-5"
              onClick={printInvoice}
            >
              <i className="fas fa-print mr-10"></i>Print
            </button>
            <button
              className="button download-button-dark radius-5"
              onClick={handleDownload}
            >
              <i className="fas fa-download mr-10"></i>Download
            </button>
          </div>
          <div className="row" id="printArea">
            <div className="col-sm-8">
              <div id="invoice">
                <div className="mt-20">
                  {cart && cart.length > 0 && (
                    <div className="row">
                      <div className="col-sm-12">
                        {error && <p className="color-red">{error}</p>}
                        {success && <p className="color-green">{success}</p>}
                        <h4 className="color-white mt-10">Cart Items</h4>
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
                                <tr>
                                  <th scope="row">
                                    <i
                                      className="fas fa-times pointer color-red"
                                      onClick={removeCartItem}
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
                    </div>
                  )}
                </div>
                <div className="mt-10 f-width flex flex-end">
                  <div className="invoice-summary special-bg padding-10">
                    <div className="summary-item">
                      <p className="color-white bold">Sub total</p>
                      <p className="color-grey">
                        {"\u20A6"} {total}
                      </p>
                    </div>
                    <div className="summary-item">
                      <p className="color-white bold">Tax</p>
                      <p className="color-grey">
                        {"\u20A6"} {tax}
                      </p>
                    </div>
                    <div className="summary-item">
                      <p className="color-white bold">Grand total</p>
                      <p className="color-grey">
                        {"\u20A6"} {grandTotal}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <div className="f-width flex flex-end mt-10">
                <p className="color-white small-p">
                  By clicking the pay button, <br />
                  you agree to our{" "}
                  <Link href="/" className="link">
                    Terms & Conditions
                  </Link>
                </p>
              </div>
              <div className="f-width flex flex-end mt-10">
                <div>
                  <button
                    className="button button-success radius-5"
                    onClick={handlePayment}
                  >
                    PAY NOW
                  </button>
                </div>
              </div>
            </div>
            <div className="col-sm-3">
              <div className="card-primary">
                <h5 className="color-primary">Summary</h5>
                <div className="mts-5">
                  <p className="color-white">
                    <i className="fas fa-times-circle mr-10 color-red"></i>{" "}
                    Invoice Unpaid
                  </p>
                  <p className="color-white small-p">
                    To complete transaction, click on{" "}
                    <span className="bold">PAY NOW</span> button
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div className="icon-bottom">
          <div
            className="page-icon"
            style={{
              backgroundImage: `url(https://cdn1.iconfinder.com/data/icons/social-media-2505/24/verified_1-256.png)`,
            }}
          ></div>
        </div>
      </div>
      <DashboardsFooter />
    </>
  );
};

export default page;
