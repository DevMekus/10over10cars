"use client";
import React from "react";
import Link from "next/link";
import { useEffect, useState } from "react";
import { objectFromFormdata } from "@/library/utils/Utility";
import { fetchData } from "@/library/utils/fetchData";
import { sessionManager } from "@/library/utils/sessionManager";

const page = () => {
  const [error, setError] = useState(null);
  const [success, setSuccess] = useState(null);
  const path = window.location.href;

  useEffect(() => {
    if (path.includes("?auth=false")) {
      setError("Unauthorized Access. Please login");
    }
  }, []);

  async function handleLogin(event) {
    event.preventDefault();
    setError("");
    setSuccess("");
    const formData = new FormData(event.target);
    const data = objectFromFormdata(formData);

    try {
      const user = await fetchData("account", "POST", data);

      if (user["status"] == "error") {
        setError(user["message"]);
      } else {
        setSuccess(user["message"]);

        sessionManager({
          userid: user.userid,
          role: user.role,
        });

        // sessionStorage.setItem("data", JSON.stringify([user.user_data]));
      }
    } catch (error) {
      setError(error.message);
    }
  }

  return (
    <>
      <div className="auth-page">
        <div className="auth-wrap-center">
          <div className="auth-title-header">
            <h1>Login to account</h1>
            <p>Start your verification with a simple step</p>
          </div>

          {error && <p className="color-red">{error}</p>}
          {success && <p className="color-green">{success}</p>}

          <form onSubmit={handleLogin}>
            <div className="ctr-wrapper">
              <label>Email address</label>
              <input
                className="form-input radius-5 form-ctr ctr-no-bg"
                type="email"
                placeholder="You@email.com"
                name="email_address"
                required
              />
            </div>
            <div className="ctr-wrapper">
              <label className="color-yellow">Password</label>
              <input
                className="form-input radius-5 form-ctr ctr-no-bg"
                type="password"
                placeholder="********"
                name="user_password"
                required
              />
            </div>

            <input type="hidden" name="action" value="LOGIN" />

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
              <Link
                href="/auth/new"
                className="link color-primary no-decoration"
              >
                <i className="fas fa-arrow-left mr-10"></i>Create account
              </Link>
              <button
                type="submit"
                name="signup_"
                className="button button-success radius-5"
              >
                Login account
              </button>
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
