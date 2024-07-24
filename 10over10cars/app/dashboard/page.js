import Link from "next/link";
import React from "react";
import UserDashboard from "@/components/UserDashboard";
import DashboardsFooter from "@/components/DashboardsFooter";

const page = () => {
  return (
    <>
      <div className="dash-page">
        <div>
          <UserDashboard moreInfo={true} />
        </div>
        <div className="container mt-10">
          <div className="row">
            <div className="col-sm-9">
              <div className="f-width flex space-between align-center">
                <h4 className="color-grey">Most recent company validations</h4>
                <Link href="/" className="no-decoration">
                  <p className="color-green">See all Vehicle registrations</p>
                </Link>
              </div>
              <div className="mt-10">
                <div className="f-width recent-verify flex gap-20">
                  <div className="icon-div">
                    <img
                      src="https://cdn0.iconfinder.com/data/icons/font-awesome-solid-vol-1/512/car-256.png"
                      alt="icon"
                    />
                  </div>
                  <div className="f-width">
                    <p className="small-p">
                      <span className="bold color-black mr-10">
                        VIN No: JTY328288978GH
                      </span>
                      <span className="color-grey">-(Sep 24, 2001)</span>
                    </p>
                    <div className="row">
                      <div className="col-sm-2">
                        <div className="info">
                          <span>
                            <span className="color-grey text-center text-center">
                              Brand
                            </span>
                            <br />
                            <span className="color-grey text-center bold">
                              Totota
                            </span>
                          </span>
                        </div>
                      </div>
                      <div className="col-sm-2">
                        <div className="info">
                          <span>
                            <span className="color-grey text-center">
                              Model
                            </span>
                            <br />
                            <span className="color-grey bold text-center">
                              Camry
                            </span>
                          </span>
                        </div>
                      </div>
                      <div className="col-sm-2">
                        <div className="info">
                          <span>
                            <span className="color-grey text-center">Year</span>
                            <br />
                            <span className="color-grey text-center bold">
                              2021
                            </span>
                          </span>
                        </div>
                      </div>
                      <div className="col-sm-2">
                        <div className="info">
                          <span>
                            <span className="color-grey text-center">
                              Condition
                            </span>
                            <br />
                            <span className="color-grey bold text-center">
                              Used
                            </span>
                          </span>
                        </div>
                      </div>
                      <div className="col-sm-2">
                        <div className="info">
                          <span>
                            <span className="color-grey text-center">
                              Status
                            </span>
                            <br />
                            <span className="color-green bold text-center">
                              Complete
                            </span>
                          </span>
                        </div>
                      </div>
                      <div className="col-sm-2">
                        <div className="info">
                          <button className="button button-sm radius-5 button-primary">
                            <i className="fas fa-eye"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div className="mt-20">
                <h4 class="color-grey">Recent logs</h4>
                <div className="special-bg mt-10 padding-10">
                  <p className="color-grey section-description">
                    <span className="bold">Caught up!</span> You have no recent
                    activity at the moment.
                  </p>
                </div>
              </div>
              <div className="mt-20">
                <h4 class="color-grey">Announcements</h4>
                <div className="special-bg mt-10 padding-10">
                  <p className="color-grey section-description">
                    <span className="bold">Caught up!</span> You have no recent
                    announcement at the moment.
                  </p>
                </div>
              </div>
            </div>
            <div className="col-sm-3">
              <h4 className="color-grey">Recent activities</h4>
              <p className="color-grey small-p">
                Get updated on the current activities
              </p>
              <div className="mt-10 special-bg padding-10">
                <p className="color-white">
                  Get updated on the current activities
                </p>
                <p className="color-grey small-p moveup-10">
                  July 12, 2024 19:20 pm
                </p>
              </div>
              <div className="mt-10 special-bg padding-10">
                <p className="color-white">
                  Get updated on the current activities
                </p>
                <p className="color-grey small-p moveup-10">
                  July 12, 2024 19:20 pm
                </p>
              </div>
              <div className="mt-10 special-bg padding-10">
                <p className="color-white">
                  Get updated on the current activities
                </p>
                <p className="color-grey small-p moveup-10">
                  July 12, 2024 19:20 pm
                </p>
              </div>
              <p className="color-green">Click to see more</p>
            </div>
          </div>
        </div>
      </div>
      <DashboardsFooter />
    </>
  );
};

export default page;
