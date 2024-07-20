import React from "react";

const OdometerInfo = () => {
  return (
    <>
      <div className="wrapper">
        <h4 className="color-white">Odometer check</h4>
        <p className="color-grey moveup-10">
          Readings & assessments of the Odometer
        </p>
        <div className="row">
          <div className="col-sm-5">
            <label className="color-grey">Inspection title</label>
            <input
              className="form-input form-ctr ctr-no-bg"
              type="text"
              placeholder="Ex: Tampering check"
              required
            />
          </div>
          <div className="col-sm-4">
            <label className="color-grey">Select summary verdict</label>
            <select className="form-input input-select form-ctr ctr-no-bg">
              <option value="">No problem found</option>
              <option value="">Problem found</option>
            </select>
          </div>
        </div>
        <div className="mt-10">
          <label className="color-grey">
            Write a brief note about assessments
          </label>

          <textarea
            className="form-input form-ctr ctr-no-bg radius-5"
            placeholder="Write a note here"
            rows={4}
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

export default OdometerInfo;
