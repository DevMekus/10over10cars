"use client";
import React from "react";
import Link from "next/link";

const page = () => {
  return (
    <>
      <div className="dash-page">
        <div className="card-primary">
          <h4 class="color-primary">Messaging & Alert Management</h4>
          <p className="color-grey">
            Manage all the accounts alert, information and messaging including
            Support messages and notifications.
          </p>
        </div>
        <div className="mt-20">
          <h5 className="color-white">Support Management</h5>
          <p className="color-grey">
            Manage all your support messages with the company.
          </p>
          <div className="moveup-10">
            <Link
              href="/dashboard/messaging/support"
              className="link decoration"
            >
              <p className="color-grey">
                <i className="fas fa-arrow-right mr-10 color-primary"></i>
                Support manager
              </p>
            </Link>
          </div>
        </div>
        <div className="mt-20 special-bg padding-10">
          <h5 className="color-white">Event & Notifications</h5>
          <p className="color-grey">
            Manage all the reports of stolen cars in this section.
          </p>
          <div className="moveup-10">
            <Link
              href="/dashboard/messaging/alerts"
              className="link decoration"
            >
              <p className="color-grey">
                <i className="fas fa-arrow-right mr-10 color-primary"></i>
                Manage events
              </p>
            </Link>
          </div>
        </div>
      </div>
    </>
  );
};

export default page;
