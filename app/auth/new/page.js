"use client";
import React from "react";
import Link from "next/link";
import { useState } from "react";
import { objectFromFormdata } from "@/library/utils/Utility";
import { fetchData } from "@/library/utils/fetchData";
import { sessionManager } from "@/library/utils/sessionManager";

const page = () => {
  const [error, setError] = useState(null);
  const [success, setSuccess] = useState(null);

  async function handleRegistration(event) {
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
        const sessionData = {
          userid: user.userid,
          role: user.role,
        };
        sessionStorage.setItem("user", JSON.stringify(sessionData));
        sessionManager(sessionData);
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
            <h1>Create account</h1>
            <p>Start your verification with a simple step</p>
          </div>

          {error && <p className="color-red">{error}</p>}
          {success && <p className="color-green">{success}</p>}

          <form onSubmit={handleRegistration}>
            <div className="ctr-wrapper">
              <label>Full name</label>
              <input
                className="form-input form-ctr radius-5 .ctr-no-bg"
                type="text"
                name="fullname"
                placeholder="Ex: John Doe"
                required
              />
            </div>
            <div className="ctr-wrapper">
              <label>Email address</label>
              <input
                className="form-input radius-5 form-ctr .ctr-no-bg"
                type="email"
                placeholder="You@email.com"
                name="email_address"
                required
              />
            </div>
            <div className="ctr-wrapper">
              <label className="color-yellow">Password</label>
              <input
                className="form-input radius-5 form-ctr .ctr-no-bg"
                type="password"
                placeholder="********"
                name="user_password"
                required
              />
            </div>
            <input type="hidden" name="action" value="NEW" />

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
