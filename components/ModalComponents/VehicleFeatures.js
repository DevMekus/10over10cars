import React from "react";
import { useState } from "react";
import Colors from "../Features/Colors";
import Models from "../Features/Models";
import Body from "../Features/Body";
import Engine from "../Features/Engine";
import Fuel from "../Features/Fuel";
import Make from "../Features/Make";
import Transmission from "../Features/Transmission";

const VehicleFeatures = () => {
  const [selectedComponent, setSelectedComponent] = useState("Colors");
  const componentMap = {
    Colors: <Colors />,
    Models: <Models />,
    Body: <Body />,
    Engine: <Engine />,
    Fuel: <Fuel />,
    Make: <Make />,
    Transmission: <Transmission />,
  };

  const switchComponent = (event) => {
    setSelectedComponent(event.target.value);
  };
  return (
    <>
      <div className="wrapper padding-10">
        <h5 className="color-white">Feature Manager</h5>

        <p className="color-grey moveup-10">
          Select and manage various features of a car which includes color,
          model etc.
        </p>
        <div className="col-sm-4 moveup-10">
          <div className="ctr-wrapper">
            <select
              className="form-input form-ctr .ctr-no-bg"
              onChange={switchComponent}
            >
              <option value="Colors">Color Manager</option>
              <option value="Models">Models Manager</option>
              <option value="Body">Body Manager</option>
              <option value="Make">Make Manager</option>
              <option value="Fuel">Fuel Manager</option>
              <option value="Transmission">Transmission Manager</option>
              <option value="Engine">Engine Manager</option>
            </select>
          </div>
        </div>
        <div className="mt-10"> {componentMap[selectedComponent]}</div>
      </div>
    </>
  );
};

export default VehicleFeatures;
