import React from "react";

const Models = () => {
  return (
    <>
      <div className="wrapper">
        <h4 className="color-white">Model manager</h4>
        <p className="color-grey moveup-10">
          Add or remove car models from the database.
        </p>
        <div className="row">
          <div className="col-sm-5">
            <label className="color-grey">Add Model</label>
            <input
              className="form-input form-ctr ctr-no-bg"
              type="text"
              placeholder="Ex: X5"
              required
            />
            <button className="button button-primary radius-5 mt-10">
              Save changes
            </button>
          </div>
          <div className="col-sm-6">
            <div className="special-bg padding-20 scrollable feature-box">
              <div className="f-width flex space-between ">
                <p className="color-grey">X5</p>
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

export default Models;
