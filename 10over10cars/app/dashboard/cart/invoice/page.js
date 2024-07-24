import React from "react";
import Link from "next/link";
import DashboardsFooter from "@/components/DashboardsFooter";
const page = () => {
  return (
    <>
      <div className="dash-page">
        <div className="card-primary">
          <h4 class="color-primary">Pending transactions</h4>
          <p className="color-grey">
            Manage all Pending & cart order invoice for verification request and
            car purchase
          </p>
        </div>
        <div className="mt-10 special-bg padding-10">
          <button className="button button-danger radius-5">
            <i className="fas fa-times mr-10"></i>Clear cart
          </button>
          <p className="color-grey">
            To clear all the cart items, click on the item above.
          </p>
        </div>
        <div className="mt-20">
          <h5 className="color-white">Cart Items</h5>
          <div className="mt-10 col-sm-3">
            <div className="ctr-wrapper">
              <label className="color-grey">Search cart</label>
              <input
                className="form-input form-ctr ctr-no-bg"
                type="text"
                placeholder="Ex: Car Purchase, 3678HJU39"
                required
              />
            </div>
          </div>
          <div className="mt-10 scrollable">
            <table className="btable">
              <thead>
                <tr>
                  <th scope="col">#InvoiceId</th>
                  <th scope="col">Purpose</th>
                  <th scope="col">Date</th>
                  <th scope="col">Status</th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">27HJJ937V</th>
                  <td>Car Verification</td>
                  <td>25-10-2021</td>
                  <td>Pending</td>
                  <td className="flex gap-10">
                    <Link
                      href="/dashboard/cart/invoice/id"
                      className="button button-sm radius-5 button-primary"
                      title="invoice"
                    >
                      <i className="fas fa-eye"></i>
                    </Link>
                    <button className="button button-sm radius-5 button-danger">
                      <i className="fas fa-times"></i>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
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
