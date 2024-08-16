import React from "react";

const Transmission = () => {
  return (
    <>
      <div className="wrapper">
        <h4 className="color-white">Transmission manager</h4>
        <p className="color-grey moveup-10">
          Add or remove car transmission types from the database.
        </p>
        <div className="row">
          <div className="col-sm-5">
            <label className="color-grey">Add Transmission</label>
            <input
              className="form-input form-ctr ctr-no-bg"
              type="text"
              placeholder="Ex: Automatic"
              required
            />
            <button className="button button-primary radius-5 mt-10">
              Save changes
            </button>
          </div>
          <div className="col-sm-6">
            <div className="special-bg padding-20 scrollable feature-box">
              <div className="f-width flex space-between ">
                <p className="color-grey">Automatic</p>
                <p className="pointer">
                  {" "}
                  <i className="fas fa-times color-red"></i>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </>
  );
};

export default Transmission;
