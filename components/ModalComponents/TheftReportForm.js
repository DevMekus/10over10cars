import React from "react";

const TheftReportForm = () => {
  return (
    <>
      <div className="wrapper padding-10">
        <div className="row">
          <div className="col-sm-6">
            <h5 className="color-white">Personal Information</h5>
            <p className="color-grey moveup-10">
              Provide us with some information about you
            </p>
            <div className="row">
              <div className="col-sm-6">
                <div className="ctr-wrapper">
                  <label className="color-grey">First name</label>
                  <input
                    className="form-input form-ctr .ctr-no-bg"
                    type="text"
                    placeholder="Ex: John"
                    required
                  />
                </div>
              </div>
              <div className="col-sm-6">
                <div className="ctr-wrapper">
                  <label className="color-grey">Last Name</label>
                  <input
                    className="form-input form-ctr .ctr-no-bg"
                    type="text"
                    placeholder="Ex: Doe"
                    required
                  />
                </div>
              </div>
            </div>
            <div className="row">
              <div className="col-sm-6">
                <div className="ctr-wrapper">
                  <label className="color-grey">Email address</label>
                  <input
                    className="form-input form-ctr .ctr-no-bg"
                    type="email"
                    placeholder="Ex: You@email.com"
                    required
                  />
                </div>
              </div>
              <div className="col-sm-6">
                <div className="ctr-wrapper">
                  <label className="color-grey">Phone number</label>
                  <input
                    className="form-input form-ctr .ctr-no-bg"
                    type="tel"
                    placeholder="Ex: +234-****8"
                    required
                  />
                </div>
              </div>
            </div>
            <h5 className="color-white mt-10">Vehicle Information</h5>
            <p className="color-grey moveup-10">
              Vim, Type, Color etc will help us identify.
            </p>
            <div className="col-sm-12">
              <div className="ctr-wrapper">
                <label className="color-grey">Vim</label>
                <input
                  className="form-input form-ctr .ctr-no-bg"
                  type="text"
                  placeholder="Ex: YSK767908JH87K0"
                  required
                />
              </div>
            </div>
            <div className="row">
              <div className="col-sm-6">
                <div className="ctr-wrapper">
                  <label className="color-grey">Body type</label>
                  <select className="form-input form-ctr ctr-no-bg">
                    <option value="1" selected>
                      Pickup
                    </option>
                    <option value="2">Vedan</option>
                    <option value="3">Humpback</option>
                  </select>
                </div>
              </div>
              <div className="col-sm-6">
                <div className="ctr-wrapper">
                  <label className="color-grey">Vehicle Model</label>
                  <select className="form-input form-ctr ctr-no-bg">
                    <option value="1" selected>
                      2016
                    </option>
                    <option value="2">2002</option>
                    <option value="3">1918</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div className="col-sm-6">
            <div className="special-bg padding-10">
              <h5 className="color-white mt-10">Theft Information</h5>
              <p className="color-grey moveup-10">
                Location, and Date can help in the search.
              </p>
              <div className="col-sm-12">
                <div className="ctr-wrapper">
                  <label className="color-grey">Location</label>
                  <input
                    className="form-input form-ctr .ctr-no-bg"
                    type="text"
                    placeholder="Ex: 39 London Street, New York Avenue, US"
                    required
                  />
                </div>
              </div>
              <div className="row">
                <div className="col-sm-6">
                  <div className="ctr-wrapper">
                    <label className="color-grey">City/State/County</label>
                    <input
                      className="form-input form-ctr .ctr-no-bg"
                      type="text"
                      placeholder="Ex: Houston, Texas"
                      required
                    />
                  </div>
                </div>
                <div className="col-sm-6">
                  <div className="ctr-wrapper">
                    <label className="color-grey">Country</label>
                    <input
                      className="form-input form-ctr .ctr-no-bg"
                      type="text"
                      placeholder="Ex: United States of America"
                      required
                    />
                  </div>
                </div>
              </div>
              {/* <span className="color-grey moveup-10">Date of Incident</span> */}
              <div className="row">
                <div className="col-sm-4">
                  <div className="ctr-wrapper">
                    <label className="color-grey">Date</label>
                    <input
                      className="form-input form-ctr .ctr-no-bg"
                      type="text"
                      placeholder="Ex: 12"
                      required
                    />
                  </div>
                </div>
                <div className="col-sm-4">
                  <div className="ctr-wrapper">
                    <label className="color-grey">Month</label>
                    <input
                      className="form-input form-ctr .ctr-no-bg"
                      type="text"
                      placeholder="Ex: January"
                      required
                    />
                  </div>
                </div>
                <div className="col-sm-4">
                  <div className="ctr-wrapper">
                    <label className="color-grey">Year</label>
                    <input
                      className="form-input form-ctr .ctr-no-bg"
                      type="text"
                      placeholder="Ex: 2000"
                      required
                    />
                  </div>
                </div>
              </div>
              <p className="color-grey">
                By submitting this form, you certify that the information
                provided is true and authentic
              </p>
            </div>
          </div>
        </div>

        <div className="f-width flex flex-end">
          <button type="submit" className="button button-primary radius-5">
            {" "}
            Submit report
          </button>
        </div>
      </div>
    </>
  );
};

export default TheftReportForm;
