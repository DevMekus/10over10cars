import React from "react";
import Link from "next/link";

const page = () => {
  return (
    <>
      <div className="dash-page">
        <div className="card-primary">
          <h4 class="color-primary">Vehicle Management</h4>
          <p className="color-grey">
            Manage all the car related data: New cars, verification requests.
          </p>
        </div>
        <div className="mt-20">
          <h5 className="color-white">Gallery</h5>
          <p className="color-grey">
            Manage all the car related reports: New cars, features, etc.
          </p>

          <div className="moveup-10">
            <Link href="/dashboard/vehicle/gallery" className="link decoration">
              <p className="color-grey">
                <i className="fas fa-arrow-right mr-10 color-primary"></i>Open
                gallery
              </p>
            </Link>
          </div>
        </div>
        <div className="mt-20 special-bg padding-10">
          <h5 className="color-white">Verification requests</h5>
          <p className="color-grey">
            Manage all the car verification requests from members, including
            invoice and payments.
          </p>

          <div className="moveup-10">
            <Link
              href="/dashboard/vehicle/verification"
              className="link decoration"
            >
              <p className="color-grey">
                <i className="fas fa-arrow-right mr-10 color-primary"></i>Manage
                request
              </p>
            </Link>
          </div>
        </div>
        <div className="icon-bottom">
          <div
            className="page-icon"
            style={{
              backgroundImage: `url(https://cdn1.iconfinder.com/data/icons/ionicons-sharp-vol-1/512/car-sport-sharp-256.png)`,
            }}
          ></div>
        </div>
      </div>
    </>
  );
};

export default page;
