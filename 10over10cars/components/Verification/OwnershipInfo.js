import React from "react";

const OwnershipInfo = () => {
  /**Get the saved Vin from sessionStorage */
  return (
    <>
      <div className="wrapper">
        <h4 className="color-white">Ownership History</h4>
        <p className="color-grey moveup-10">
          Record the previous owners of this vehicle.
        </p>
        <input type="hidden" name="vin" value="328238292" />
        <div className="row">
          <div className="col-sm-5">
            <label className="color-grey">Owners Fullname</label>
            <br />
            <small className="color-grey">
              <em> Fullname of car's previous owner</em>
            </small>
            <input
              className="form-input form-ctr ctr-no-bg"
              type="text"
              placeholder="Ex: John Doe"
              required
            />
          </div>
          <div className="col-sm-4">
            <label className="color-grey">Purchase date</label>
            <br />
            <small className="color-grey">
              <em>When this owner purchased the car</em>
            </small>
            <input
              className="form-input form-ctr ctr-no-bg"
              type="text"
              placeholder="Ex: 2020"
              required
            />
          </div>
        </div>
        <div className="mt-10">
          <div className="row">
            <div className="col-sm-5">
              <label className="color-grey">Miles Driven per year</label>
              <br />
              <small className="color-grey">
                <em>Estimated total miles the car has gone.</em>
              </small>
              <input
                className="form-input form-ctr ctr-no-bg"
                type="text"
                placeholder="Ex: 4,468ml"
                required
              />
            </div>
            <div className="col-sm-4">
              <label className="color-grey">Odometer reading</label>
              <br />
              <small className="color-grey">
                <em>Purchase date odometer reading</em>
              </small>
              <input
                className="form-input form-ctr ctr-no-bg"
                type="text"
                placeholder="Ex: 4,000ml"
                required
              />
            </div>
          </div>
        </div>
        <div className="mt-10 f-width flex align-center space-between">
          <div className="col-sm-5">
            <label className="color-grey">Est. length of use</label>
            <br />
            <small className="color-grey">
              <em>How long this vehicle served owner</em>
            </small>
            <input
              className="form-input form-ctr ctr-no-bg"
              type="text"
              placeholder="Ex: 0years. 7months"
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

export default OwnershipInfo;
