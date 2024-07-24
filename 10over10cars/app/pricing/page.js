import React from "react";
import FrontNav from "@/components/FrontNav";
import Footer from "@/components/Footer";
import Link from "next/link";

const page = () => {
  return (
    <>
      <section className="page-wrapper">
        <FrontNav />
        <section className="page-hero">
          <div className="container flex">
            <div className="hero-side hero-side-a">
              <div>
                <h1 className="hero-title">
                  Pricing <span className="color-green"></span>
                </h1>
                <p className="color-white">
                  We provide everything you need to build an Amazing dealership{" "}
                </p>
              </div>
            </div>
            <div className="hero-side hero-side-img"></div>
          </div>
        </section>
        <Footer />
      </section>
    </>
  );
};

export default page;
