import React from "react";
import Link from "next/link";

const loading = () => {
  return (
    <div className="loading-wrapper">
      <div className="logo-section">
        <Link href="/">
          <img
            src="/logo-black-edit.jpg"
            alt="logo"
            className="img-fluid nav-logo"
          />
        </Link>
      </div>
    </div>
  );
};

export default loading;
