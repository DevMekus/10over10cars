import Link from "next/link";
import React from "react";

const page = () => {
  return (
    <>
      <div className="auth-page">
        <div className="auth-wrap-center">
          <div className="auth-title-header">
            <h1>Reset Password</h1>
            <p>Start your reset process with a simple step</p>
          </div>
          <form>
            <div className="ctr-wrapper">
              <label>Email address</label>
              <input
                className="form-input form-ctr .ctr-no-bg"
                type="email"
                placeholder="You@email.com"
                required
              />
            </div>

            <div className="mt-10 flex align-center space-between">
              <button
                type="submit"
                name="signup_"
                className="button button-primary semi-pill"
              >
                Proceed
              </button>
              <Link
                href="/auth/login"
                className="link color-primary no-decoration"
              >
                Login Instead
              </Link>
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
