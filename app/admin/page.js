import Link from "next/link";
import React from "react";
import StartVerification from "@/components/StartVerification";
const page = () => {
  return (
    <>
      <div className="dash-page">
        <div>
          <StartVerification moreInfo={true} />
        </div>
        <section className="container mt-20">
          <div className="row">
            <div className="col-sm-8">
              <section className="mw">
                <div className="f-width flex space-between align-center">
                  <h4 className="color-grey">Most recent registrations</h4>
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
                              <span className="color-grey text-center">
                                Year
                              </span>
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
              </section>
              <h4 class="color-grey">Recent logs</h4>
              <div className="special-bg mt-20 padding-10">
                <p className="color-grey section-description">
                  <span className="bold">Caught up!</span> You have no recent
                  activity at the moment.
                </p>
              </div>
            </div>
            <div className="col-sm-4">
              <h4 className="color-grey">Recent payments</h4>
              <div className="f-width special-bg padding-10 border-left-3-green recent-payment">
                <p className="color-black bold title">Invoice No: HKG8378G</p>
                <p className="moveup-10 color-grey date">
                  <em>Oct 12, 2001</em>
                </p>
                <p className="moveup-10 color-grey title">Nnaji Nnaemeka</p>
                <p className="color-grey date">
                  <em>Payer's name</em>
                </p>

                <div className="f-width flex space-between">
                  <div>
                    <p className="moveup-10 color-grey title">$ 3,000.00</p>
                    <p className="color-grey date">
                      <em>Amount</em>
                    </p>
                  </div>
                  <div>
                    <p className="moveup-10 color-green bold title">
                      Successful
                    </p>
                    <p className="color-grey date">
                      <em>Status</em>
                    </p>
                  </div>
                </div>
              </div>
              <div className="f-width special-bg padding-10 border-left-3-green recent-payment">
                <p className="color-black bold title">Invoice No: HKG8378G</p>
                <p className="moveup-10 color-grey date">
                  <em>Oct 12, 2001</em>
                </p>
                <p className="moveup-10 color-grey title">Nnaji Nnaemeka</p>
                <p className="color-grey date">
                  <em>Payer's name</em>
                </p>

                <div className="f-width flex space-between">
                  <div>
                    <p className="moveup-10 color-grey title">$ 3,000.00</p>
                    <p className="color-grey date">
                      <em>Amount</em>
                    </p>
                  </div>
                  <div>
                    <p className="moveup-10 color-green bold title">
                      Successful
                    </p>
                    <p className="color-grey date">
                      <em>Status</em>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <div className="icon-bottom">
          <div
            className="page-icon"
            style={{
              backgroundImage: `url(https://cdn1.iconfinder.com/data/icons/radix/15/dashboard-256.png)`,
            }}
          ></div>
        </div>
      </div>
    </>
  );
};

export default page;
