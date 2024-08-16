import React from "react";

const NewSupport = () => {
  return (
    <>
      <div className="wrapper padding-10">
        <h5 className="color-white">Create a support</h5>
        <p className="color-grey moveup-10">
          To begin this process, register a Vn
        </p>
        <div className="row">
          <div className="col-sm-5 moveup-10">
            <div className="ctr-wrapper">
              <label className="color-grey">Subject</label>
              <input
                className="form-input form-ctr .ctr-no-bg"
                type="text"
                placeholder="Ex: Verification"
                required
              />
            </div>
          </div>
          <div className="col-sm-4">
            <div className="ctr-wrapper">
              <label className="color-grey">Priority</label>
              <select className="form-input input-select form-ctr .ctr-no-bg">
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
              </select>
            </div>
          </div>
        </div>
        <div>
          <textarea
            className="form-input form-ctr .ctr-no-bg"
            placeholder="Write your message here"
            rows={4}
          ></textarea>
        </div>
        <div className="f-width flex flex-end">
          <button className="button button-primary radius-5 mt-10">
            Create ticket
          </button>
        </div>
      </div>
    </>
  );
};

export default NewSupport;
