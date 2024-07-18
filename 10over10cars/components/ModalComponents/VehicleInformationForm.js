import React from "react";

const VehicleInformationForm = () => {
  return (
    <>
      <div className="wrapper padding-10">
        <div className="row">
          <div className="col-sm-6">
            <h5 className="color-white">Vehicle Information</h5>
            <p className="color-grey moveup-10">
              Enter a car Vim to begin registration
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

export default VehicleInformationForm;
