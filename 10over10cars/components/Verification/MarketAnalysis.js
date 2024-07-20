import React from "react";

const MarketAnalysis = () => {
  return (
    <>
      <div className="wrapper">
        <h4 className="color-white">Market Analysis</h4>
        <p className="color-grey moveup-10">
          write your Market projections for this vehicle.
        </p>
        <div className="mt-10">
          <label className="color-grey">
            Write a brief note about this system
          </label>

          <textarea
            className="form-input form-ctr ctr-no-bg radius-5"
            placeholder="Write your projections here"
            rows={3}
          ></textarea>
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

export default MarketAnalysis;
