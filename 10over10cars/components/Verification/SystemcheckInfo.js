import React from "react";

const SystemcheckInfo = () => {
  return (
    <>
      <div className="wrapper">
        <h4 className="color-white">Systems check</h4>
        <p className="color-grey moveup-10">
          Record all the basic and advanced systems like censors, electrical,
          etc
        </p>
        <div className="row">
          <div className="col-sm-5">
            <label className="color-grey">System title</label>
            <input
              className="form-input form-ctr ctr-no-bg"
              type="text"
              placeholder="Ex: Fuel System: Fuel tank"
              required
            />
          </div>
          <div className="col-sm-4">
            <label className="color-grey">Inspection date</label>
            <input
              className="form-input form-ctr ctr-no-bg"
              type="text"
              placeholder="Ex: July 10, 1990"
              required
            />
          </div>
        </div>
        <div className="mt-10">
          <label className="color-grey">
            Write a brief note about this system
          </label>

          <textarea
            className="form-input form-ctr ctr-no-bg radius-5"
            placeholder="Write your message here"
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

export default SystemcheckInfo;
