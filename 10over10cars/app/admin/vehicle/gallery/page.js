"use client";
import React from "react";
import Link from "next/link";
import StartVerification from "@/components/StartVerification";

const page = () => {
  return (
    <>
      <div className="dash-page mt-20">
        <StartVerification />
        <div className="mt-20">
          <h5 className="color-white">Vehicle listing</h5>
          <p className="color-grey">
            List of all the vehicles in the system, verified and non-verified
          </p>

          <div className="moveup-10">
            <Link href="/admin/vehicle/listing" className="link decoration">
              <p className="color-grey">
                <i className="fas fa-arrow-right mr-10 color-primary"></i>Manage
                list
              </p>
            </Link>
          </div>
        </div>
        <div className="mt-20 special-bg padding-10">
          <h5 className="color-white">Vehicle Gallery</h5>
          <p className="color-grey">
            Visit the vehicle gallery and choose its display to car lovers
          </p>

          <div className="moveup-10">
            <Link href="/admin/vehicle/gallery/buy" className="link decoration">
              <p className="color-grey">
                <i className="fas fa-arrow-right mr-10 color-primary"></i>Open
                Gallery
              </p>
            </Link>
          </div>
        </div>
        <div className="mt-20">
          <h5 className="color-white">Vehicle feature manager</h5>
          <p className="color-grey">
            Add, and delete car feature, including colors, model, body etc.
          </p>

          <div className="moveup-10">
            <Link
              href="/admin/vehicle/gallery/features"
              className="link decoration"
            >
              <p className="color-grey">
                <i className="fas fa-arrow-right mr-10 color-primary"></i>Get
                started
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
