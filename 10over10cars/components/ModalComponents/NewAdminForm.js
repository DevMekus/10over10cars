import React from "react";

const NewAdminForm = () => {
  return (
    <>
      <div className="wrapper padding-10">
        <div className="ctr-wrapper">
          <label className="color-grey">Admin Fullname</label>
          <input
            className="form-input form-ctr .ctr-no-bg"
            type="text"
            placeholder="Ex: John Doe"
            required
          />
        </div>
        <div className="ctr-wrapper">
          <label className="color-grey">Email address</label>
          <input
            className="form-input form-ctr .ctr-no-bg"
            type="email"
            placeholder="You@email.com"
            required
          />
        </div>
        <div className="row">
          <div className="col-sm-6">
            <div className="ctr-wrapper">
              <label className="color-grey">Username</label>
              <input
                className="form-input form-ctr .ctr-no-bg"
                type="text"
                placeholder="Ex: JohnDoe"
                required
              />
            </div>
          </div>
          <div className="col-sm-6">
            <div className="ctr-wrapper">
              <label className="color-grey">Password</label>
              <input
                className="form-input form-ctr .ctr-no-bg"
                type="password"
                placeholder="**********"
                required
              />
            </div>
          </div>
        </div>
        <label className="color-grey">
          Select data access level for this admin
        </label>
        <div className="ctr-wrapper col-sm-8">
          <select className="form-input form-ctr ctr-no-bg">
            <option value="1" selected>
              1
            </option>
            <option value="2">2</option>
            <option value="3">3</option>
          </select>
        </div>
        <div className="f-width flex flex-end">
          <button type="submit" className="button button-primary radius-5">
            {" "}
            Create admin
          </button>
        </div>
      </div>
    </>
  );
};

export default NewAdminForm;
