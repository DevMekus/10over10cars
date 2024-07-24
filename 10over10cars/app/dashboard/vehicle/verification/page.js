import React from "react";
import Link from "next/link";
import CarVerification from "@/components/CarVerification";
import Pagination from "@/components/Pagination";

const page = () => {
  return (
    <>
      <div className="dash-page">
        <section className="container ">
          <div className="row">
            <div className="col-sm-3">
              <CarVerification />
            </div>
            <div className="col-sm-9">
              <h4 className="color-grey mt-10">Verification Requests</h4>
              <p className="color-grey">
                One of the functions of 10over10 Cars is to protect the
                properties of citizens.
              </p>
              <div className="mt-10 col-sm-3">
                <div className="ctr-wrapper">
                  <label className="color-grey">Search requests</label>
                  <input
                    className="form-input form-ctr ctr-no-bg"
                    type="text"
                    placeholder="Ex: 637HJH939e7KL"
                    required
                  />
                </div>
              </div>
              <div className="mt-10">
                <div className="mt-10 scrollable">
                  <table className="btable">
                    <thead>
                      <tr>
                        <th scope="col">#Id</th>
                        <th scope="col">Vin</th>
                        <th scope="col">PayId</th>
                        <th scope="col">Date</th>
                        <th scope="col">Status</th>
                        <th scope="col"></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row">278HK</th>
                        <td>27HHKG278VG</td>
                        <td>537HK930</td>

                        <td>25-10-2021</td>
                        <td>Delivered</td>
                        <td className="flex gap-10">
                          <Link
                            href="/dashboard/vehicle/id"
                            className="button button-sm radius-5 button-primary"
                            title="Car Information"
                          >
                            <i className="fas fa-eye"></i>
                          </Link>
                          <Link
                            href="/dashboard/transactions/transaction/id"
                            className="button button-sm radius-5 button-success"
                            title="Transaction Invoice"
                          >
                            <i className="fas fa-file"></i>
                          </Link>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div className="mt-10 f-width flex flex-end">
                  <Pagination />
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </>
  );
};

export default page;
