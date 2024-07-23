import React from "react";
import Link from "next/link";
import HeroSection from "@/components/HeroSection";

const page = () => {
  return (
    <>
      <div className="page-wrapper">
        <HeroSection />
        <h1>Hello, its working</h1>
      </div>
    </>
  );
};

export default page;
