import React from "react";

const SummaryInfo = () => {
  /**Get the saved Vin from sessionStorage */
  return (
    <>
      <div className="wrapper">
        <h4 className="color-white">Vehicle Information</h4>
        <p className="color-grey moveup-10">
          Select all the information that best describes this vehicle
        </p>
        <input type="hidden" name="vin" value="328238292" />
        <div className="row">
          <div className="col-sm-4">
            <label className="color-grey">Make</label>
            <select className="form-input form-ctr ctr-no-bg">
              <option value="">BMW</option>
              <option value="">Toyota</option>
              <option value="">Mercedeze</option>
              <option value="">Lexus</option>
            </select>
          </div>
          <div className="col-sm-4">
            <label className="color-grey">Model</label>
            <select className="form-input form-ctr ctr-no-bg">
              <option value="">X5</option>
              <option value="">B23</option>
              <option value="">Spider</option>
              <option value="">Antica</option>
            </select>
          </div>
          <div className="col-sm-4">
            <label className="color-grey">Color</label>
            <select className="form-input form-ctr ctr-no-bg">
              <option value="">Green</option>
              <option value="">Blue</option>
              <option value="">Red</option>
              <option value="">Ash</option>
            </select>
          </div>
        </div>
        <div className="mt-10">
          <div className="row">
            <div className="col-sm-4">
              <label className="color-grey">Fuel</label>
              <select className="form-input form-ctr ctr-no-bg">
                <option value="">Gas</option>
                <option value="">Petroleum</option>
                <option value="">Electric</option>
              </select>
            </div>
            <div className="col-sm-4">
              <label className="color-grey">Transmission</label>
              <select className="form-input form-ctr ctr-no-bg">
                <option value="">Automatic</option>
                <option value="">Manual</option>
              </select>
            </div>
            <div className="col-sm-4">
              <label className="color-grey">Body type</label>
              <select className="form-input form-ctr ctr-no-bg">
                <option value="">Pickup</option>
                <option value="">Seden</option>
                <option value="">Sports</option>
              </select>
            </div>
          </div>
        </div>
        <div className="mt-10">
          <div className="row">
            <div className="col-sm-4">
              <label className="color-grey">Engine</label>
              <select className="form-input form-ctr ctr-no-bg">
                <option value="">Gas</option>
                <option value="">Petroleum</option>
                <option value="">Electric</option>
              </select>
            </div>
            <div className="col-sm-4">
              <label className="color-grey">Made In</label>
              <select className="form-input form-ctr ctr-no-bg">
                <option value="">China</option>
                <option value="">UK</option>
                <option value="">Germany</option>
              </select>
            </div>
          </div>
        </div>
        <div className="f-width flex-end flex align-center">
          <button className="button button-primary radius-5">
            Save changes
          </button>
        </div>
      </div>
    </>
  );
};

export default SummaryInfo;
