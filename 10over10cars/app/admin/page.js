import Link from "next/link";
import React from "react";

const page = () => {
  return (
    <>
      <div className="dash-page">
        <div className="card-primary">
          <h4 class="color-primary">Admin Dashboard</h4>
          <p className="color-white">
            Welcome{" "}
            <span className="color-primary">
              <strong>James, Okafor</strong>
            </span>
            , to your Admin Dashboard.
          </p>
        </div>
        <section className="mt-20">
          <div className="container">
            <div className="row">
              <div className="col-sm-3">
                <div className="card-primary summary-data">
                  <div>
                    <h5 class="color-primary">Users</h5>
                    <p className="color-grey moveup">
                      Number of users available
                    </p>
                    <Link href="/" className="link">
                      Click to see more!
                    </Link>
                  </div>
                  <h4 className="color-grey">0</h4>
                </div>
              </div>
              <div className="col-sm-3">
                <div className="card-primary summary-data">
                  <div>
                    <h5 class="color-primary">Invoice</h5>
                    <p className="color-grey moveup">
                      Number of unpaid invoice
                    </p>
                    <Link href="/" className="link">
                      Click to see more!
                    </Link>
                  </div>{" "}
                  <h4 className="color-grey">0</h4>
                </div>
              </div>
              <div className="col-sm-3">
                <div className="card-primary summary-data">
                  <div>
                    <h5 class="color-primary">Requests</h5>
                    <p className="color-grey moveup">
                      Number of verification request
                    </p>
                    <Link href="/" className="link">
                      Click to see more!
                    </Link>
                  </div>{" "}
                  <h4 className="color-grey">0</h4>
                </div>
              </div>
            </div>
          </div>
        </section>
        <div className="card-primary mt-20">
          <h5 class="color-primary">Recent logs</h5>
          <p className="color-grey section-description">
            <span className="bold">Caught up!</span> You have no recent activity
            at the moment.
          </p>
        </div>
        <div className="card-primary mt-20">
          <h5 class="color-primary">Support Messages</h5>
          <p className="color-grey section-description">
            <span className="bold">Caught up!</span> You have no pending support
            messages.
          </p>
        </div>
      </div>
    </>
  );
};

export default page;
