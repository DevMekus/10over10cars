import Link from "next/link";
import React from "react";

const page = () => {
  return (
    <>
      <div className="auth-page">
        <div className="auth-wrap-center">
          <div className="auth-title-header">
            <h1>Login to account</h1>
            <p>Start your verification with a simple step</p>
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
            <div className="ctr-wrapper">
              <label className="color-yellow">Password</label>
              <input
                className="form-input form-ctr .ctr-no-bg"
                type="password"
                placeholder="********"
                required
              />
            </div>
            <div className="full-w flex space-between mt-10 align-center">
              <div className="flex gap-10 align-center">
                <input type="checkbox" id="cookie" className="checkbox-c" />
                <label htmlFor="cookie" className="color-grey pointer">
                  Remember me
                </label>
              </div>
              <Link className="no-decoration pointer" href="/auth/reset">
                <label className="color-grey pointer">Forgot password?</label>
              </Link>
            </div>
            <div className="mt-10 flex align-center space-between">
              <button
                type="submit"
                name="signup_"
                className="button button-primary semi-pill"
              >
                Login account
              </button>
              <Link
                href="/auth/new"
                className="link color-primary no-decoration bold"
              >
                Create account
              </Link>
            </div>
            <div className="mt-5 text-center">
              <span className="text-center color-grey">
                This site is protected by{" "}
                <span className="color-primary bold">AutoInspect</span>. <br />{" "}
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
