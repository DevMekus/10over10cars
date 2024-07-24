import React from "react";
import Link from "next/link";
import DashboardsFooter from "@/components/DashboardsFooter";
const page = () => {
  return (
    <>
      <div className="dash-page">
        <div className="card-primary">
          <h4 class="color-primary">Transaction Invoice</h4>
          <p className="color-grey">
            Transaction invoice{" "}
            <span className="bold color-primary">#7823HJKH36LH</span>, issued to{" "}
            <span className="bold color-primary">John Doe</span>
          </p>
        </div>
        <div className="mt-20">
          <div className="flex gap-10">
            <button className="button button-primary  radius-5">
              <i className="fas fa-print mr-10"></i>Print
            </button>
            <button className="button download-button-dark radius-5">
              <i className="fas fa-download mr-10"></i>Download
            </button>
          </div>
          <div className="row">
            <div className="col-sm-8">
              <div className="moveup-10s">
                <p className="color-grey">#7823HJKH36LH</p>
                <p className="bold color-white moveup-10">John Doe</p>
                <p className="moveup-10 color-grey">Car Verifiction</p>
                <p className="color-grey moveup-10">
                  <em>Receipient</em>
                </p>
              </div>
              <div className="mt-10 scrollable">
                <table className="btable">
                  <thead>
                    <tr>
                      <th scope="col">#Ref</th>
                      <th scope="col">Item</th>
                      <th scope="col">Amount ($)</th>
                      <th scope="col">Qty</th>
                      <th scope="col">Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th scope="row">27HJJ937</th>
                      <td>Car Verification</td>
                      <td>5,000.00</td>
                      <td>1</td>
                      <td>5,000.00</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div className="mt-10 f-width flex flex-end">
                <div className="invoice-summary special-bg padding-10">
                  <div className="summary-item">
                    <p className="color-grey bold">Sub total:</p>
                    <p className="color-grey">$ 5,000.00</p>
                  </div>
                  <div className="summary-item">
                    <p className="color-grey bold">Tax:</p>
                    <p className="color-grey">$ 2.00</p>
                  </div>
                  <div className="summary-item">
                    <p className="color-grey bold">Grand total:</p>
                    <p className="color-grey">$ 5,002.00</p>
                  </div>
                </div>
              </div>
              <div className="f-width flex flex-end mt-10">
                <p className="color-grey ">
                  By clicking the pay button, <br />
                  you agree to our Terms & Conditions
                </p>
              </div>
              <div className="f-width flex flex-end mt-10">
                <div>
                  <button className="button button-success radius-5">
                    <i className="fas fa-print mr-10"></i>Pay
                  </button>
                </div>
              </div>
            </div>
            <div className="col-sm-3">
              <div className="card-primary">
                <h5 className="color-primary">Administrative summary</h5>
                <div className="mts-5">
                  <p className="color-white">
                    <i className="fas fa-times-circle mr-10 color-red"></i>{" "}
                    Invoice Unpaid
                  </p>
                  <p className="color-grey small-p">
                    Click on the Pay Button to complete transaction
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
