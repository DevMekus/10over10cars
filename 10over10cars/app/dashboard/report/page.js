import React from "react";
import Link from "next/link";
import DashboardsFooter from "@/components/DashboardsFooter";

const page = () => {
  return (
    <>
      <div className="dash-page">
        <div className="card-primary">
          <h4 class="color-primary">Reports Management</h4>
          <p className="color-grey">
            Manage all the accounts reports in the application, admin and users
            included.
          </p>
        </div>
        <div className="mt-20 ">
          <h5 className="color-white">Unpaid Invoice</h5>
          <p className="color-grey">
            Manage all unpaid invoice still in your cart.
          </p>
          <div className="moveup-10">
            <Link href="/dashboard/cart/invoice" className="link decoration">
              <p className="color-grey">
                <i className="fas fa-arrow-right mr-10 color-primary"></i>Manage
                invoice
              </p>
            </Link>
          </div>
        </div>
        <div className="mt-20 special-bg padding-10">
          <h5 className="color-white">Theft Reports</h5>
          <p className="color-grey">
            Manage all the reports of stolen cars in this section.
          </p>
          <div className="moveup-10">
            <Link href="/dashboard/report/theft" className="link decoration">
              <p className="color-grey">
                <i className="fas fa-arrow-right mr-10 color-primary"></i>Manage
                reports
              </p>
            </Link>
          </div>
        </div>
      </div>
      <DashboardsFooter />
    </>
  );
};

export default page;
