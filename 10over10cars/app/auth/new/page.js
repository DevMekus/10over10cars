import Link from "next/link";
import React from "react";

const page = () => {
  return (
    <>
      <div className="auth-page">
        <div className="auth-wrap-center">
          <div className="auth-title-header">
            <h1>Create account</h1>
            <p>Start your verification with a simple step</p>
          </div>
          <form>
            <div className="ctr-wrapper">
              <label>User fullname</label>
              <input
                className="form-input form-ctr .ctr-no-bg"
                type="text"
                placeholder="Ex: John Doe"
                required
              />
            </div>
            <div className="ctr-wrapper">
              <label>Email address</label>
              <input
                className="form-input form-ctr .ctr-no-bg"
                type="email"
                placeholder="You@email.com"
                required
              />
            </div>
            <div className="ctr-wrapper">
              <label className="color-yellow">Password</label>
              <input
                className="form-input form-ctr .ctr-no-bg"
                type="password"
                placeholder="********"
                required
              />
            </div>

            <div className="mt-10 flex align-center space-between">
              <Link
                href="/auth/login"
                className="no-decoration link color-primary bold"
              >
                Login Instead
              </Link>
              <button
                type="submit"
                name="signup_"
                className="button button-primary semi-pill"
              >
                Create account
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
