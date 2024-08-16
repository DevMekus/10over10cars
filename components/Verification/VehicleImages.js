import React from "react";

const VehicleImages = () => {
  return (
    <>
      <div className="wrapper">
        <h4 className="color-white">Vehicle Images</h4>
        <p className="color-grey moveup-10">
          Select all the vehicle images and upload to database.
        </p>
        <div className="row">
          <div className="col-sm-5">
            <label className="color-grey">Select Images</label>
            <input
              className="form-input form-ctr ctr-no-bg"
              type="file"
              placeholder="Ex: Fuel System: Fuel tank"
              required
              accept="image/*"
              multiple
            />
            <p className="color-grey small-pa">
              Acceptable formats include:
              <br /> jpg, jpeg, and png.
            </p>
          </div>
        </div>

        <div className="f-width flex-end flex align-center">
          <button className="button button-primary radius-5">
            Upload Images
          </button>
        </div>
      </div>
    </>
  );
};

export default VehicleImages;
