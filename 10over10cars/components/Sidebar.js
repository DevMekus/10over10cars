import React from "react";
import Link from "next/link";

const Sidebar = ({ links }) => {
  return (
    <>
      <div className="sidebar">
        <div className="logo-section">
          <Link href="/">
            <img
              src="/logo-black-edit.jpg"
              alt="logo"
              className="img-fluid nav-logo"
            />
          </Link>
        </div>
        <div className="sidebar-link">
          {links.map((link) => (
            <div className="link-div" key={link.id}>
              <Link href={`${link.url}`} className="no-decoration">
                <div className="link-item">
                  <span className="material-symbols-outlined icon">
                    {link.icon}
                  </span>
                  <h5 className="link-title">{link.name}</h5>
                </div>
              </Link>
            </div>
          ))}
        </div>
        <div className="bottom">
          <p className="text-center color-grey">
            @2024 10over10 Inc.
            <br /> All rights reserved.
          </p>
        </div>
      </div>
    </>
  );
};

export default Sidebar;
