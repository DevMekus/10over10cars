import React from "react";

const Body = () => {
  return (
    <>
      <div className="wrapper">
        <h4 className="color-white">Body manager</h4>
        <p className="color-grey moveup-10">
          Add or remove car body types from the database.
        </p>
        <div className="row">
          <div className="col-sm-5">
            <label className="color-grey">Add Body Type</label>
            <input
              className="form-input form-ctr ctr-no-bg"
              type="text"
              placeholder="Ex: Sedan, Hilux"
              required
            />
            <button className="button button-primary radius-5 mt-10">
              Save changes
            </button>
          </div>
          <div className="col-sm-6">
            <div className="special-bg padding-20 scrollable feature-box">
              <div className="f-width flex space-between ">
                <p className="color-grey">Pickup</p>
                <p className="pointer">
                  {" "}
                  <i className="fas fa-times color-red"></i>
                </p>
              </div>
              <div className="f-width flex space-between ">
                <p className="color-grey">Hilux</p>
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

export default Body;
