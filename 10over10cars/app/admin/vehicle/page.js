import React from "react";
import Link from "next/link";

const page = () => {
  return (
    <>
      <div className="dash-page">
        <div className="card-primary">
          <h4 class="color-primary">Car Management</h4>
          <p className="color-grey">
            Manage all the car related reports: New cars, verification requests,
            product features, etc.
          </p>
        </div>
        <div className="mt-20">
          <h5 className="color-white">Vehicle Management</h5>
          <p className="color-grey">
            Manage all the car related reports: New cars, features, etc.
          </p>

          <div className="moveup-10">
            <Link href="/admin/vehicle/gallery" className="link decoration">
              <p className="color-grey">
                <i className="fas fa-arrow-right mr-10 color-primary"></i>Get
                started
              </p>
            </Link>
          </div>
        </div>
        <div className="mt-20">
          <h5 className="color-white">Verification requests</h5>
          <p className="color-grey">
            Manage all the car verification requests from members, including
            invoice and payments.
          </p>

          <div className="moveup-10">
            <Link
              href="/admin/vehicle/verification"
              className="link decoration"
            >
              <p className="color-grey">
                <i className="fas fa-arrow-right mr-10 color-primary"></i>Manage
                request
              </p>
            </Link>
          </div>
        </div>
      </div>
    </>
  );
};

export default page;
