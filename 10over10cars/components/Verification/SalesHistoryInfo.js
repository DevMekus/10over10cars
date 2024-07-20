import React from "react";

const SalesHistoryInfo = () => {
  return (
    <>
      <div className="wrapper">
        <h4 className="color-white">Sales History</h4>
        <p className="color-grey moveup-10">
          Document all the date, location and cost of the car in history.
        </p>
        <div className="row">
          <div className="col-sm-5">
            <label className="color-grey">Sales location</label>
            <input
              className="form-input form-ctr ctr-no-bg"
              type="text"
              placeholder="Ex: Accra, Ghana"
              required
            />
          </div>
          <div className="col-sm-4">
            <label className="color-grey">Sales Date</label>
            <input
              className="form-input form-ctr ctr-no-bg"
              type="text"
              placeholder="Ex: July 12, 1980"
              required
            />
          </div>
        </div>
        <div className="row">
          <div className="col-sm-5">
            <label className="color-grey">Cost</label>
            <input
              className="form-input form-ctr ctr-no-bg"
              type="text"
              placeholder="Ex: 1,000"
              required
            />
          </div>
          <div className="col-sm-4">
            <label className="color-grey">Odometer </label>
            <input
              className="form-input form-ctr ctr-no-bg"
              type="text"
              placeholder="Ex: 6,907"
              required
            />
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

export default SalesHistoryInfo;
