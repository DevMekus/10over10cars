import Utility from "../Class/Utility.js";
import VehicleStatic from "../Class/Vehicle.js";

export default class VehicleUI {
  static manageVehicleDocs(listing) {
    const container = document.getElementById("docThumbnails");
    let display = "";
    const docs = listing.files_url ? JSON.parse(listing.files_url) : [];

    if (!docs || docs.length === 0) {
      container.innerHTML = `<div class="alert alert-warning">📄 No documents found for this VIN</div>`;
      return;
    }

    display += `<div class="row g-3">`;

    docs.forEach((doc, i) => {
      const fileName = `Document ${i + 1}`;
      display += `
      <div class="col-md-4 col-sm-6">
        <div class="card shadow-sm h-100 border-0 position-relative bg-light">
          <div class="card-body d-flex flex-column justify-content-between">
            <div class="mb-2">
              <i class="fas fa-file-alt fa-2x text-primary"></i>
              <h6 class="mt-2 mb-0">${fileName}</h6>
              <small class="text-muted">${doc.split("/").pop()}</small>
            </div>

            <div class="d-flex justify-content-between">
              <a href="${doc}" class="btn btn-sm btn-outline-primary" target="_blank">
                <i class="fas fa-download me-1"></i>Download
              </a>
              <button 
                class="btn btn-sm btn-outline-error delete_Btns" 
                data-type="document" data-url="${doc}" 
                title="Delete">
                <i class="fas fa-trash-alt"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    `;
    });

    display += `</div>`;
    container.innerHTML = display;
    VehicleStatic.delete_vehicle_uploads();
  }

  static manageVehicleImages(listing) {
    const container = document.getElementById("imageThumbnails");
    let display = "";
    const images = listing.image_url ? JSON.parse(listing.image_url) : [];

    if (!images || images.length === 0) {
      container.innerHTML = `<div class="alert alert-warning">🚫 No images found for this VIN</div>`;
      return;
    }

    display += `<div class="row g-3">`;

    images.forEach((image, i) => {
      display += `
      <div class="col-6 col-sm-4 col-md-3">
        <div class="card shadow-sm border-0 position-relative h-100">
          <img src="${image}" class="card-img-top object-fit-cover rounded-top" alt="Vehicle Image ${i}" style="height: 180px;">
          
          <button 
            class="btn btn-sm btn-outline-error position-absolute top-0 end-0 m-1 delete_Btns" 
            title="Delete Image"
            data-type="images" 
            data-url="${image}"            
            style="z-index: 2;"
          >
            <i class="fas fa-trash-alt"></i>
          </button>

        </div>
      </div>
    `;
    });

    display += `</div>`;
    container.innerHTML = display;

    VehicleStatic.delete_vehicle_uploads();
  }

  static async manageVehicleData(listing) {
    const container = document.getElementById("vehicleInfo");
    const vehicleData = listing.vehicle_data
      ? JSON.parse(listing.vehicle_data)
      : [];

    if (!vehicleData || Object.keys(vehicleData).length === 0) {
      container.innerHTML = `<div class="alert alert-warning">No vehicle data was found for this VIN</div>`;
      return;
    }

    // Keys to exclude from display
    const excludedFields = ["userid", "vin"];

    // Header + Card-style layout
    let form = `
  <div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-primary text-white">
      <h5 class="mb-0">🚘 Vehicle Information</h5>
    </div>
    <div class="card-body">
      <form class="vehicleDataForm" data-form="vehicle_information">
        <div class="row g-4">
`;

    for (let key in vehicleData) {
      if (excludedFields.includes(key)) continue;

      const label = Utility.toTitleCase(key);
      const value = vehicleData[key];

      form += `
    <div class="col-md-6">
      <div class="form-floating">
        <input 
          type="text" 
          class="form-control vehicle-input" 
          name="${key}" 
          value="${value}" 
          id="input-${key}" 
          placeholder="${label}" 
          data-original="${value}"
        />
        <label for="input-${key}">${label}</label>
      </div>
    </div>
  `;
    }

    form += `
        </div>
        
        <div class="mt-4 d-flex justify-content-between align-items-center">
          <button type="submit" class="btn btn-outline-accent px-4">
            💾 Save Changes
          </button>
          <span id="saveStatus" class="text-muted small"></span>
        </div>
      </form>
    </div>
  </div>
`;
    container.innerHTML = form;
  }

  static vehicleOwnershipForm() {
    const domEl = document.getElementById("ownershipForm");
    if (!domEl) return;
    domEl.innerHTML = `
        <div class="border rounded p-3 bg-light">
            <h6 class="mb-3">Add Ownership Record</h6>
            <form class="vehicleDataForm" data-form="vehicle_ownerships">
                <div class="mb-3">
                    <label for="owner" class="form-label">Owner Name</label>
                    <input type="text" class="form-control" name="owner" id="owner" placeholder="e.g. Jane Smith" required>
                </div>

                <div class="mb-3">
                    <label for="duration" class="form-label">Ownership Duration</label>
                    <input type="text" class="form-control" name="duration" id="duration" placeholder="e.g. 2 years">
                </div>

                <div class="mb-3">
                    <label for="note" class="form-label">Note</label>
                    <input type="text" class="form-control" name="note" id="note" placeholder="e.g. Transferred after lease">
                </div>

                <button type="submit" class="btn btn-outline-accent w-100">💾 Save Record</button>
            </form>
        </div>
    
    `;
  }

  // static async manageVehicleHistory(listing) {
  //   const container = document.getElementById("vehicleInfo");
  //   const vehicleData = listing.vehicle_data
  //     ? JSON.parse(listing.vehicle_data)
  //     : [];

  //   if (!vehicleData || Object.keys(vehicleData).length === 0) {
  //     container.innerHTML = `<div class="alert alert-warning">No vehicle data was found for this VIN</div>`;
  //     return;
  //   }

  //   // Keys to exclude from display
  //   const excludedFields = ["vin"];

  //   let form = `
  //   <div class="row">
  //     <div class="col-md-8">
  //       <form id="vehicleDataForm">
  //         <div class="row g-3">
  // `;

  //   for (let key in vehicleData) {
  //     if (excludedFields.includes(key)) continue;

  //     const label = Utility.toTitleCase(key);
  //     const value = vehicleData[key];

  //     form += `
  //     <div class="col-md-6">
  //       <label class="form-label">${label}</label>
  //       <input
  //         type="text"
  //         class="form-control vehicle-input"
  //         name="${key}"
  //         value="${value}"
  //         data-original="${value}"
  //       />
  //     </div>
  //   `;
  //   }

  //   form += `
  //         </div>
  //         <div class="mt-4 d-flex gap-2">
  //           <button type="submit" class="btn btn-primary">Save Changes</button>
  //           <span id="saveStatus" class="text-muted"></span>
  //         </div>
  //       </form>
  //     </div>
  //   </div>
  // `;

  //   container.innerHTML = form;
  // }

  static async manageVehicleOwnership(listing) {
    const container = document.getElementById("ownershipRecords");
    const ownershipData = listing.ownership_data
      ? JSON.parse(listing.ownership_data)
      : [];

    if (!ownershipData || ownershipData.length === 0) {
      container.innerHTML = `<div class="alert alert-warning">No vehicle data was found for this VIN</div>`;
      return;
    }

    let output = "";
    ownershipData.forEach((record, i) => {
      const owner = record.owner || "Unknown";
      const duration = record.duration || "Not specified";
      const note = record.note || "";

      output += `
      <div class="d-flex justify-content-between align-items-center border-bottom py-2">
        <div>
          <strong>${owner}</strong><br>
          <small>Duration: ${duration}</small><br>
          <small>Note: ${note}</small>
        </div>
        <div>
          <button class="btn btn-sm btn-outline-secondary me-1 edit-ownership" data-index="${i}">✏️ Edit</button>
          <button class="btn btn-sm btn-outline-danger delete-ownership" data-index="${i}">🗑 Delete</button>
        </div>
      </div>
    `;
    });

    container.innerHTML = output;
  }

  static specificationForm() {
    const domEl = document.getElementById("specification");
    if (!domEl) return;
    domEl.innerHTML = `
     <div class="spec-form">
          <h3>Add / Edit Specification</h3>
           <form class="vehicleDataForm" data-form="vehicle_specs">
              <div class="mb-3">
                  <label for="specTitle" class="form-label">Part</label>
                  <input type="text" class="form-control" id="specTitle" name="part" placeholder="e.g., Engine Type" required>
              </div>
              <div class="mb-3">
                  <label for="specValue" class="form-label">Value</label>
                  <input type="text" class="form-control" id="specValue" name="value" placeholder="e.g., V6 Turbo" required>
              </div>
              <input type="hidden" id="editIndex" value=""> <!-- For editing -->
              <button type="submit" class="btn btn-outline-accent">Save Specification</button>
          </form>
      </div>
    
    `;
  }

  static async manageVehicleSpecifications(listing) {
    const container = document.getElementById("specLists");
    const specsData = listing.specs_data ? JSON.parse(listing.specs_data) : [];

    if (!specsData || specsData.length === 0) {
      container.innerHTML = `<div class="alert alert-warning">No vehicle data was found for this VIN</div>`;
      return;
    }

    // Clear existing contents
    container.innerHTML = "";

    // Loop through specsData and render each item
    specsData.forEach((spec, index) => {
      const specItem = document.createElement("div");
      specItem.className =
        "spec-item d-flex justify-content-between align-items-center border-bottom py-2";
      specItem.innerHTML = `
      <div>
        <strong>${spec.part}</strong>: ${spec.value}
      </div>
      <div>
        <button class="btn btn-sm btn-outline-secondary edit" data-id="${index}">✏️ Edit</button>
        <button class="btn btn-sm btn-outline-error delete_data" data-table="document" data-id="${index}">🗑 Delete</button>
                
                
      </div>
    `;
      container.appendChild(specItem);
    });
  }

  static async manageVehicleValuations(listing) {
    const container = document.getElementById("valuationContainer");
    const valuationData = listing.valuation_data
      ? JSON.parse(listing.valuation_data)
      : [];

    if (!valuationData || valuationData.length === 0) {
      container.innerHTML = `<div class="alert alert-warning">No vehicle data was found for this VIN</div>`;
      return;
    }

    // Clear previous contents
    container.innerHTML =
      '<div id="valuationList" class="d-flex flex-column gap-3"></div>';
    const valuationList = container.querySelector("#valuationList");

    valuationData.forEach((valuation, index) => {
      const valuationCard = document.createElement("div");
      valuationCard.className =
        "border rounded p-3 shadow-sm bg-white position-relative";

      valuationCard.innerHTML = `
      <div>
        <p class="mb-1"><strong>Condition:</strong> ${valuation.condition}</p>
        <p class="mb-1"><strong>Price:</strong> ₦${Number(
          valuation.price
        ).toLocaleString()}</p>
        <p class="mb-1"><strong>Assessor:</strong> ${valuation.assessor}</p>
        <p class="text-muted small mb-0">Date: ${valuation.date}</p>
      </div>
      <div class="position-absolute top-0 end-0 mt-2 me-2">
        <button class="btn btn-sm btn-outline-primary me-1 edit" data-id="${index}" title="Edit">
          <i class="fas fa-edit"></i>
        </button>
        <button class="btn btn-sm btn-outline-danger delete" data-id="${index}" title="Delete">
          <i class="fas fa-trash"></i>
        </button>
      </div>
    `;

      valuationList.appendChild(valuationCard);
    });
  }

  static async manageVehicleInspection(listing) {
    const container = document.getElementById("inspectionRecords");
    const inspectionData = listing.inspection_result
      ? JSON.parse(listing.inspection_result)
      : [];

    if (!inspectionData || inspectionData.length === 0) {
      container.innerHTML = `<div class="alert alert-warning">No vehicle data was found for this VIN</div>`;
      return;
    }

    // Clear previous content
    container.innerHTML = "";

    inspectionData.forEach((record, index) => {
      const { inspectionDate, notes, items } = record;

      // Loop through the array of inspection items
      const itemList = Array.isArray(items)
        ? items
            .map(
              ({ key, value }) => `<li><strong>${key}:</strong> ${value}</li>`
            )
            .join("")
        : "";

      const notesPart = notes
        ? `<li><strong>Notes:</strong> ${notes}</li>`
        : "";

      const inspectionHTML = `
      <div class="border rounded p-3 mb-3 position-relative bg-light">
        <small class="text-muted">Date: ${inspectionDate || "N/A"}</small>
        <ul class="mb-2">
          ${itemList}
          ${notesPart}
        </ul>
        <div class="d-flex justify-content-end">        
          <button class="btn btn-sm btn-outline-error" data-index="${index}">Delete</button>
        </div>
      </div>
    `;

      container.insertAdjacentHTML("beforeend", inspectionHTML);
    });
  }
}
