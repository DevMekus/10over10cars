import React from "react";
import Link from "next/link";

const page = () => {
  return (
    <>
      <div className="dash-page">
        <div className="card-primary">
          <h4 class="color-primary">Transaction Manager</h4>
          <p className="color-grey">
            Manage all paid & verified order invoice for verification request
            and car purchase
          </p>
        </div>
        <div className="mt-20">
          <h5 className="color-white">Transaction List</h5>
          <div className="mt-10 col-sm-3">
            <div className="ctr-wrapper">
              <label className="color-grey">Search transaction</label>
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
                  <th scope="col">#ReceiptId</th>
                  <th scope="col">#InvoiceId</th>
                  <th scope="col">PaymentID</th>
                  <th scope="col">Purpose</th>
                  <th scope="col">Transaction Date</th>
                  <th scope="col">Status</th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">27HJJ937V</th>
                  <th scope="row">27HJJ937V</th>
                  <td>27HJJ937V</td>
                  <td>Car Verification</td>
                  <td>25-10-2021</td>
                  <td>Successful</td>
                  <td className="flex gap-10">
                    <Link
                      href="/dashboard/transactions/transaction/id"
                      className="button button-sm radius-5 button-primary"
                    >
                      <i className="fas fa-eye"></i>
                    </Link>
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
    </>
  );
};

export default page;
