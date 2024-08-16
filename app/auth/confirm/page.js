import Link from "next/link";
import React from "react";

const page = () => {
  return (
    <>
      <div className="auth-page">
        <div className="auth-wrap-center">
          <div className="auth-title-header">
            <h1>Reset account</h1>
            <p className="color-green">
              Enter the OTP password sent to your email.
            </p>
          </div>
          <form>
            <div className="ctr-wrapper">
              <label>Enter the OTP password sent to your email.</label>
              <input
                className="form-input form-ctr .ctr-no-bg"
                type="password"
                placeholder="Ex: 360HJUti"
                required
              />
            </div>
            <div className="ctr-wrapper">
              <label>New Password</label>
              <input
                className="form-input form-ctr .ctr-no-bg"
                type="password"
                placeholder="Ex: ****"
                required
              />
            </div>

            <div className="mt-10 flex align-center space-between">
              <Link
                href="/auth/login"
                className="no-decoration link color-primary"
              >
                <i className="fas fa-arrow-left mr-10"></i>Login Instead
              </Link>
              <button
                type="submit"
                name="signup_"
                className="button button-success radius-5"
              >
                Reset
              </button>
            </div>
            <div className="mt-5 text-center">
              <span className="text-center color-grey">
                This site is protected by{" "}
                <span className="color-primary bold">AutoInspect</span>.<br />{" "}
                Its Privacy Policy and Terms of Service apply.
              </span>
            </div>
          </form>
        </div>
      </div>
    </>
  );
};

export default page;
