"use client";
import React, { useEffect, useState } from "react";
import FrontNav from "@/components/FrontNav";
const HeroSection = () => {
  const heroImages = ["hero-image.webp", "hero3.png", "hero4.png", "hero5.png"];
  const [currentCar, setCurrentCar] = useState(heroImages[0]);
  let count = 0;

  /**
   * Write a function that switch car photos
   */

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
              src={`/${currentCar}`}
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
