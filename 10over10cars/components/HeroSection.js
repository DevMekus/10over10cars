import React from "react";
import FrontNav from "@/components/FrontNav";
const HeroSection = () => {
  return (
    <>
      <div className="hero-top-wrap">
        <FrontNav />
        <div className="hero-wrapper">
          <div className="hero-sect hero-yellow"></div>
          <div className="hero-sect hero-dark"></div>
        </div>
        <div className="absolute-hero-items">
          <h1 className="item-2">
            VERI<span className="color-primary">FIED</span>
          </h1>

          <div className="hero-image">
            <img
              src="/hero-image.webp"
              className="img-fluid"
              alt="hero-image"
            />
          </div>
        </div>
      </div>
    </>
  );
};

export default HeroSection;
