import React from "react";

const CarInfoFlex = ({ items }) => {
  return (
    <>
      {Object.entries(items).map(([key, value]) => (
        <div className="info" key={key}>
          <div className="flex flex-end">
            <p className="color-white bold">{key}:</p>
          </div>
          <div className="flex flex-start">
            <p className="color-grey">{value}</p>
          </div>
        </div>
      ))}
    </>
  );
};

export default CarInfoFlex;
