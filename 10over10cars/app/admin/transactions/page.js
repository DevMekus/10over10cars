import React from "react";
import Link from "next/link";

const page = () => {
  return (
    <>
      <div className="dash-page">
        <div className="card-primary">
          <h4 class="color-primary">Transaction & Order Management</h4>
          <p className="color-grey">
            Manage all the car related reports: New cars, verification requests,
            product features, etc.
          </p>
        </div>
        <div className="mt-20">
          <h5 className="color-white">Transaction Management</h5>
          <p className="color-grey">
            Manage all paid & verified order invoice for verification request
            and car purchase
          </p>

          <div className="moveup-10">
            <Link
              href="/admin/transactions/transaction"
              className="link decoration"
            >
              <p className="color-grey">
                <i className="fas fa-arrow-right mr-10 color-primary"></i>See
                transactions
              </p>
            </Link>
          </div>
        </div>
        <div className="mt-20">
          <h5 className="color-white">Order Management</h5>
          <p className="color-grey">
            Manage all customer pending order and uncleared invoice.
          </p>

          <div className="moveup-10">
            <Link
              href="/admin/vehicle/verification"
              className="link decoration"
            >
              <p className="color-grey">
                <i className="fas fa-arrow-right mr-10 color-primary"></i>Manage
                Order
              </p>
            </Link>
          </div>
        </div>
        <div className="icon-bottom">
          <div
            className="page-icon"
            style={{
              backgroundImage: `url(https://cdn3.iconfinder.com/data/icons/pix-glyph-set/50/520947-visa-256.png)`,
            }}
          ></div>
        </div>
      </div>
    </>
  );
};

export default page;
