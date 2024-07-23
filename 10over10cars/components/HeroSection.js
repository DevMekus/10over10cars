import React from "react";
import FrontNav from "@/components/FrontNav";
const HeroSection = () => {
  return (
    <>
      <div className="hero-wrapper">
        <FrontNav />
        <div className="hero-sect hero-yellow"></div>
        <div className="hero-sect hero-dark"></div>
        <div className="hero-title">
          <h1>VEHICLE</h1>
          <h1>VERIFIED!</h1>
        </div>
      </div>
    </>
  );
};

export default HeroSection;
