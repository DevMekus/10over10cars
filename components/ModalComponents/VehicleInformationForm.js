import React from "react";
import { useState } from "react";
import SummaryInfo from "../Verification/SummaryInfo";
import SystemcheckInfo from "../Verification/SystemcheckInfo";
import OdometerInfo from "../Verification/OdometerInfo";
import SalesHistoryInfo from "../Verification/SalesHistoryInfo";
import OwnershipInfo from "../Verification/OwnershipInfo";
import MarketAnalysis from "../Verification/MarketAnalysis";
import VehicleImages from "../Verification/VehicleImages";

const VehicleInformationForm = () => {
  const [selectedComponent, setSelectedComponent] = useState("SummaryInfo");

  const componentMap = {
    SummaryInfo: <SummaryInfo />,
    SystemcheckInfo: <SystemcheckInfo />,
    OdometerInfo: <OdometerInfo />,
    SalesHistoryInfo: <SalesHistoryInfo />,
    OwnershipInfo: <OwnershipInfo />,
    MarketAnalysis: <MarketAnalysis />,
    VehicleImages: <VehicleImages />,
  };

  const switchComponent = (event) => {
    setSelectedComponent(event.target.value);
  };
  return (
    <>
      <div className="wrapper padding-10">
        <div className="form-start">
          <h5 className="color-white">
            Vin <span className="color-green">HJJK7883HJJ</span> registered
          </h5>

          <p className="color-grey moveup-10">
            Select which area of this vehicle to start with
          </p>
          <div className="col-sm-4 moveup-10">
            <div className="ctr-wrapper">
              <select
                className="form-input form-ctr .ctr-no-bg"
                onChange={switchComponent}
              >
                <option value="SummaryInfo">Vehicle summary report</option>
                <option value="OwnershipInfo">Ownership history report</option>
                <option value="OdometerInfo">Odometer report</option>
                <option value="SalesHistoryInfo">Sales history report</option>
                <option value="SystemcheckInfo">System checks report</option>
                <option value="MarketAnalysis">Market analysis report</option>
                <option value="VehicleImages">Vehicle Images</option>
              </select>
            </div>
          </div>
          <div className="mt-10"> {componentMap[selectedComponent]}</div>
        </div>
      </div>
    </>
  );
};

export default VehicleInformationForm;
