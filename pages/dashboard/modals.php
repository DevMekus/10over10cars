<!-- Active Modals Start -->

<div class="modal fade mainModals" id="updatePassword" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Update Password</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="passwordForm" style="margin-top:12px">
                <div class="modal-body">

                    <div class="mb-1">
                        <label class="muted small">Current password</label>
                        <input type="password" name="current_password" id="curPass" required />
                    </div>
                    <div>
                        <label class="muted small">New password</label>
                        <input type="password" name="user_password" id="newPass" required />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Change password</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add/Edit Modal -->
<div class="modal fade" id="uploadVehicleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="uploadModalLabel">Upload Vehicle Data</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="formUploadElement">
                <form id="vehForm" enctype="multipart/form-data">
                    <div class="modal-body">
                        <!-- VIN -->
                        <div class="mb-3">
                            <label for="title" class="small muted" data-bs-toggle="tooltip" title="Vehicle Title (usually the Make, Model and Year)">
                                Title *
                            </label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="e.g., 2012 Toyota Corolla" required>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="vin" class="small muted" data-bs-toggle="tooltip" title="Vehicle Identification Number (usually 17 characters long)">
                                        VIN *
                                    </label>
                                    <input type="text" class="form-control vin_border" id="vin" name="vin" placeholder="e.g., 1HGCM82633A004352" required>
                                    <div id="vin_error"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="price" class="small muted" data-bs-toggle="tooltip" title="Vehicle current value">
                                        Price *
                                    </label>
                                    <input type="number" class="form-control" id="price" name="price" placeholder="e.g., 1000" required>
                                </div>
                            </div>
                        </div>

                        <?php
                        $makesAndModels = [
                            "Toyota" => ["Camry", "Corolla", "RAV4", "Yaris", "Highlander"],
                            "Honda" => ["Civic", "Accord", "CR-V", "Pilot", "Fit"],
                            "Ford" => ["F-150", "Escape", "Fusion", "Mustang", "Edge"],
                            "BMW" => ["3 Series", "5 Series", "X5", "X3", "7 Series"],
                            "Mercedes" => ["C-Class", "E-Class", "S-Class", "GLA", "GLC"]
                        ];
                        ?>

                        <!-- Make & Model -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="make" class="small muted" data-bs-toggle="tooltip" title="Select the brand of the vehicle">
                                    Make
                                </label>
                                <select name="make" id="make" class="form-select mb-2" onchange="populateModels()" required>
                                    <option value="">Select Make</option>
                                    <?php foreach ($makesAndModels as $make => $models): ?>
                                        <option value="<?= htmlspecialchars($make) ?>"><?= htmlspecialchars($make) ?></option>
                                    <?php endforeach; ?>
                                    <option value="other">Other</option>
                                </select>
                                <input type="text" name="cmake" id="makeCustom" class="form-control d-none" placeholder="Enter vehicle make">
                                <small class="text-muted">If not listed, select "Other" and type it.</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="model" class="small muted" data-bs-toggle="tooltip" title="Select or enter the vehicle model">
                                    Model
                                </label>
                                <select name="model" id="model" class="form-select mb-2" required>
                                    <option value="">Select Model</option>
                                </select>
                                <input type="text" name="cmodel" id="modelCustom" class="form-control d-none" placeholder="Enter vehicle model">
                                <small class="text-muted">Auto-fills based on Make or enter manually.</small>
                            </div>
                        </div>

                        <!-- Trim & Year -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="trim" class="small muted" data-bs-toggle="tooltip" title="Vehicle's trim level (e.g., LE, SE, Sport)">
                                    Trim
                                </label>
                                <input type="text" class="form-control" id="trim" name="trim" placeholder="e.g., LE, Sport">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="year" class="small muted" data-bs-toggle="tooltip" title="Manufacturing year">
                                    Year
                                </label>
                                <input type="number" class="form-control" id="year" name="year" placeholder="e.g., 2021">
                            </div>
                        </div>



                        <!-- Body Type & Fuel Type -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <?php $bodyTypes = ["Sedan", "Hatchback", "SUV", "Coupe", "Convertible", "Wagon", "Van", "Truck", "Minivan", "Pickup"]; ?>
                                <label for="bodyType" class="small muted" data-bs-toggle="tooltip" title="Vehicle body configuration">
                                    Body Type
                                </label>
                                <select name="body_type" id="bodyType" class="form-select" required>
                                    <option value="">Select Body Type</option>
                                    <?php foreach ($bodyTypes as $type): ?>
                                        <option value="<?= htmlspecialchars($type) ?>"><?= htmlspecialchars($type) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <?php $fuelTypes = ["Petrol", "Diesel", "Electric", "Hybrid", "CNG", "LPG", "Hydrogen", "Ethanol"]; ?>
                                <label for="fuelType" class="small muted" data-bs-toggle="tooltip" title="Type of fuel the vehicle uses">
                                    Fuel Type
                                </label>
                                <select name="fuel" id="fuelType" class="form-select" required>
                                    <option value="">Select Fuel Type</option>
                                    <?php foreach ($fuelTypes as $type): ?>
                                        <option value="<?= htmlspecialchars($type) ?>"><?= htmlspecialchars($type) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Drive Type & Plate -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <?php $driveTypes = ["FWD", "RWD", "AWD", "4WD"]; ?>
                                <label for="driveType" class="small muted" data-bs-toggle="tooltip" title="How power is delivered to wheels">
                                    Drive Type
                                </label>
                                <select name="drive_type" id="driveType" class="form-select" required>
                                    <option value="">Select Drive Type</option>
                                    <?php foreach ($driveTypes as $type): ?>
                                        <option value="<?= htmlspecialchars($type) ?>"><?= htmlspecialchars($type) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="engineNumber" class="small muted" data-bs-toggle="tooltip" title="Vehicle’s Engine number">
                                    Engine Number
                                </label>
                                <input type="text" class="form-control" id="engineNumber" name="engine_number" placeholder="e.g., ABC-1234">
                            </div>

                            <!-- Transmission -->
                            <div class="mb-3 col-md-6">
                                <?php $transmissions = ["Manual", "Automatic", "CVT", "Semi-Automatic", "Dual-Clutch"]; ?>
                                <label for="transmission" class="small muted" data-bs-toggle="tooltip" title="Gear system">
                                    Transmission
                                </label>
                                <select name="transmission" id="transmission" class="form-select" required>
                                    <option value="">Select Transmission</option>
                                    <?php foreach ($transmissions as $trans): ?>
                                        <option value="<?= htmlspecialchars($trans) ?>"><?= htmlspecialchars($trans) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Mileage -->
                            <div class="mb-3 col-md-6">
                                <label for="mileage" class="small muted" data-bs-toggle="tooltip" title="Total kilometers the vehicle has traveled">
                                    Mileage (km)
                                </label>
                                <input type="number" class="form-control" id="mileage" name="mileage" placeholder="e.g., 45300">
                            </div>

                        </div>





                        <!-- Colors -->
                        <?php $colorOptions = ["Black", "White", "Silver", "Blue", "Red", "Grey", "Green", "Yellow", "Brown", "Orange"]; ?>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="exteriorColor" class="small muted" data-bs-toggle="tooltip" title="Color of the car’s outer body">
                                    Exterior Color
                                </label>
                                <select name="exterior_color" id="exteriorColor" class="form-select mb-2" required onchange="toggleCustomColor(this, 'exteriorColorCustom')">
                                    <option value="">Select Exterior Color</option>
                                    <?php foreach ($colorOptions as $color): ?>
                                        <option value="<?= htmlspecialchars($color) ?>"><?= htmlspecialchars($color) ?></option>
                                    <?php endforeach; ?>
                                    <option value="other">Other</option>
                                </select>
                                <input type="text" name="cexterior_color" id="exteriorColorCustom" class="form-control d-none" placeholder="Enter custom exterior color">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="interiorColor" class="small muted" data-bs-toggle="tooltip" title="Color of the car’s interior materials">
                                    Interior Color
                                </label>
                                <select name="interior_color" id="interiorColor" class="form-select mb-2" required onchange="toggleCustomColor(this, 'interiorColorCustom')">
                                    <option value="">Select Interior Color</option>
                                    <?php foreach ($colorOptions as $color): ?>
                                        <option value="<?= htmlspecialchars($color) ?>"><?= htmlspecialchars($color) ?></option>
                                    <?php endforeach; ?>
                                    <option value="other">Other</option>
                                </select>
                                <input type="text" name="cinterior_color" id="interiorColorCustom" class="form-control d-none" placeholder="Enter custom interior color">
                            </div>
                            <div class="col-md-6">
                                <label for="vehicleImages" class="small muted">Vehicle Images</label>
                                <input type="file" id="vehicleImages" name="vehicleImages[]" class="form-control" multiple accept="image/*">
                            </div>

                            <div class="col-md-6">
                                <label for="vehicleDocs" class="small muted">Vehicle Documents</label>
                                <input type="file" id="vehicleDocs" name="vehicleDocs[]" class="form-control" multiple accept=".pdf,.doc,.docx">
                            </div>
                            <input type="hidden" name="userid" value="<?= $userid; ?>" />
                            <div class="col-md-12">
                                <label for="note" class="small muted">Brief Note</label>
                                <textarea class="form-control" rows="3" id="note" name="notes"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Upload vehicle</button>
                    </div>
                </form>
                <script>
                    function toggleCustomColor(selectEl, customInputId) {
                        const customInput = document.getElementById(customInputId);
                        if (selectEl.value === "other") {
                            customInput.classList.remove("d-none");
                            customInput.setAttribute("required", "required");
                        } else {
                            customInput.classList.add("d-none");
                            customInput.removeAttribute("required");
                        }
                    }
                    //Initialize tooltips
                    document.addEventListener("DOMContentLoaded", () => {
                        const tooltips = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                        tooltips.forEach((tooltipEl) => new bootstrap.Tooltip(tooltipEl));
                    });
                </script>

                <script>
                    const makeModelData = <?= json_encode($makesAndModels) ?>;

                    function populateModels() {
                        const make = document.getElementById('make').value;
                        const modelSelect = document.getElementById('model');
                        const modelCustom = document.getElementById('modelCustom');
                        const makeCustom = document.getElementById('makeCustom');

                        modelSelect.innerHTML = '<option value="">Select Model</option>';

                        // Show custom make input
                        if (make === 'other') {
                            makeCustom.classList.remove('d-none');
                            makeCustom.required = true;
                        } else {
                            makeCustom.classList.add('d-none');
                            makeCustom.required = false;
                        }

                        // Populate models if make exists
                        if (makeModelData[make]) {
                            makeModelData[make].forEach(model => {
                                const option = document.createElement('option');
                                option.value = model;
                                option.text = model;
                                modelSelect.appendChild(option);
                            });
                            modelSelect.appendChild(new Option('Other', 'other'));
                        } else {
                            modelSelect.appendChild(new Option('Other', 'other'));
                        }

                        // Reset model input
                        modelCustom.classList.add('d-none');
                        modelCustom.required = false;
                    }

                    document.getElementById('model').addEventListener('change', function() {
                        const selected = this.value;
                        const modelCustom = document.getElementById('modelCustom');
                        if (selected === 'other') {
                            modelCustom.classList.remove('d-none');
                            modelCustom.required = true;
                        } else {
                            modelCustom.classList.add('d-none');
                            modelCustom.required = false;
                        }
                    });
                </script>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="displayDetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="detailModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="detailModalBody"></div>
            </div>
            <div class="modal-footer">
                <div id="detailModalButtons"></div>
            </div>
        </div>
    </div>
</div>



<!-- Active Modals End -->










<!-- Modals -->
<div class="modal" id="vehicleModal" aria-hidden="true">
    <div class="modal-card">
        <div class="modal-header">
            <h3 id="vehicleModalTitle">Add Vehicle</h3><button class="icon-btn" data-close="vehicleModal">✕</button>
        </div>
        <form id="vehicleForm">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-top:12px">
                <div><label>Title</label><input type="text" id="vTitle" required /></div>
                <div><label>Price (NGN)</label><input type="number" id="vPrice" required /></div>
                <div><label>VIN</label><input type="text" id="vVin" required /></div>
                <div><label>Status</label><select id="vStatus">
                        <option value="available">Available</option>
                        <option value="pending">Pending</option>
                        <option value="sold">Sold</option>
                    </select></div>
            </div>
            <div style="margin-top:12px"><label>Image (optional)</label><input type="file" id="vImage" accept="image/*" /></div>
            <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:12px"><button type="button" class="btn btn-ghost" data-close="vehicleModal">Cancel</button><button type="submit" class="btn btn-primary">Save Vehicle</button></div>
        </form>
    </div>
</div>

<div class="modal" id="dealerModal" aria-hidden="true">
    <div class="modal-card">
        <div class="modal-header">
            <h3>Approve Dealer</h3><button class="icon-btn" data-close="dealerModal">✕</button>
        </div>
        <form id="approveDealerForm">
            <div style="margin-top:12px"><label>Dealer ID</label><input type="text" id="dealerId" readonly /></div>
            <div style="margin-top:12px"><label>Company</label><input type="text" id="dealerCompany" readonly /></div>
            <div style="margin-top:12px"><label>Decision</label><select id="dealerDecision">
                    <option value="approve">Approve</option>
                    <option value="reject">Reject</option>
                </select></div>
            <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:12px"><button type="button" class="btn btn-ghost" data-close="dealerModal">Cancel</button><button type="submit" class="btn btn-primary">Submit</button></div>
        </form>
    </div>
</div>
<!-- Details modal -->
<div class="modal" id="detailModal" aria-hidden="true">
    <div class="modal-card">
        <div style="display:flex;justify-content:space-between;align-items:center">
            <h3>Verification details</h3><button class="icon-btn" data-close="detailModal">✕</button>
        </div>
        <div style="margin-top:12px" class="modal-grid">
            <div>
                <div class="vehicle-media"><img id="detailImage" src="https://source.unsplash.com/800x600/?car" alt="vehicle image" /></div>
                <div style="margin-top:10px;display:flex;gap:8px"><button class="btn btn-primary" id="approveBtn">Approve</button><button class="btn btn-ghost" id="declineBtn">Decline</button></div>
            </div>
            <div>
                <div><strong id="detailTitle">2016 Toyota Corolla</strong>
                    <div class="muted small" id="detailMeta">Lagos • 72,000 km</div>
                </div>
                <div style="margin-top:10px"><strong>VIN</strong>
                    <div class="small" id="detailVin">2HGFB2F50DH512345</div>
                </div>
                <div style="margin-top:10px"><strong>Submitted by</strong>
                    <div class="small" id="detailUser">Nnaemeka N. (dealer: Ace Motors)</div>
                </div>
                <div style="margin-top:10px"><strong>Documents</strong>
                    <ul id="detailDocs" style="margin:6px 0 0 14px"></ul>
                </div>
                <div style="margin-top:12px"><strong>Notes</strong>
                    <div id="detailNotes" class="muted small">No additional notes</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Report Issue -->
<div class="modal" id="reportModal" aria-hidden="true">
    <div class="modal-card">
        <div style="display:flex;justify-content:space-between;align-items:center"><strong>Report an issue</strong><button class="icon-btn" data-close="reportModal">✕</button></div>
        <form id="reportForm" style="margin-top:12px;display:grid;gap:8px">
            <label class="small muted">Describe the issue<textarea name="issue" rows="4" style="width:100%;padding:8px;border-radius:8px;border:1px solid rgba(15,23,36,.06)"></textarea></label>
            <div style="display:flex;gap:8px;justify-content:flex-end">
                <button type="submit" class="btn primary">Send report</button>
                <button type="button" class="btn ghost" data-close="reportModal">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Detail modal -->
<div class="modal" id="detailModalTx" aria-hidden="true">
    <div class="modal-card">
        <div style="display:flex;justify-content:space-between;align-items:center">
            <h3>Transaction details</h3><button class="icon-btn" data-close="detailModal">✕</button>
        </div>
        <div style="margin-top:12px" class="modal-grid">
            <div>
                <div style="background:#f3f6fb;padding:12px;border-radius:8px"><strong id="txId">TXN-000</strong>
                    <div class="muted small" id="txDate">2025-01-01</div>
                </div>
                <div style="margin-top:12px"><strong>Amount</strong>
                    <div id="txAmount" class="big">NGN 0</div>
                </div>
                <div style="margin-top:12px"><strong>Method</strong>
                    <div id="txMethod" class="muted small">Card</div>
                </div>
                <div style="margin-top:12px"><strong>Status</strong>
                    <div id="txStatus" class="muted small">Pending</div>
                </div>
                <div style="margin-top:12px"><strong>Action</strong>
                    <div style="display:flex;gap:8px;margin-top:8px"><button class="btn btn-primary" id="refundBtn">Refund</button><button class="btn btn-ghost" id="blockBtn">Block</button></div>
                </div>
            </div>
            <div>
                <div><strong>User/Dealer</strong>
                    <div id="txUser" class="muted small">John Doe</div>
                </div>
                <div style="margin-top:12px"><strong>Notes</strong>
                    <div id="txNotes" class="muted small">—</div>
                </div>
                <div style="margin-top:12px"><strong>Receipt / Logs</strong>
                    <div id="txLogs" class="muted small">No logs</div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Dealer Detail Modal -->
<div class="modal" id="detailModalDealer" aria-hidden="true">
    <div class="modal-card">
        <div style="display:flex;justify-content:space-between;align-items:center">
            <h3>Dealer details</h3><button class="ghost" data-close="detailModal">✕</button>
        </div>
        <div id="detailBody" style="margin-top:10px"></div>
        <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:12px">
            <button id="approveBtn" class="ghost">Approve</button>
            <button id="suspendBtn" class="ghost">Suspend</button>
            <button id="deleteBtn" class="ghost">Delete</button>
        </div>
    </div>
</div>

<!-- Add Dealer Modal -->
<div class="modal" id="addModal" aria-hidden="true">
    <div class="modal-card">
        <div style="display:flex;justify-content:space-between;align-items:center">
            <h3>Add dealer</h3><button class="ghost" data-close="addModal">✕</button>
        </div>
        <form id="addForm" style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:10px">
            <div><label class="small muted">Dealer name</label><input required name="name" style="width:100%;padding:8px;border:1px solid rgba(15,23,36,.1);border-radius:10px" /></div>
            <div><label class="small muted">Email</label><input type="email" required name="email" style="width:100%;padding:8px;border:1px solid rgba(15,23,36,.1);border-radius:10px" /></div>
            <div><label class="small muted">Phone</label><input required name="phone" style="width:100%;padding:8px;border:1px solid rgba(15,23,36,.1);border-radius:10px" /></div>
            <div><label class="small muted">City/State</label><input required name="state" style="width:100%;padding:8px;border:1px solid rgba(15,23,36,.1);border-radius:10px" /></div>
            <div style="grid-column:1/-1"><label class="small muted">About</label><textarea name="about" rows="3" style="width:100%;padding:8px;border:1px solid rgba(15,23,36,.1);border-radius:10px"></textarea></div>
            <div style="grid-column:1/-1;display:flex;gap:8px;justify-content:flex-end"><button type="submit" class="ghost">Save</button></div>
        </form>
    </div>
</div>

<!-- Confirmation modal -->
<div class="modal" id="confirmModal" aria-hidden="true">
    <div class="modal-card" data-aos="zoom-in">
        <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 16px;border-bottom:1px solid rgba(15,23,36,0.06)"><strong>Submit application?</strong><button class="icon-btn"><i class="bi bi-x-lg"></i></button></div>
        <div style="padding:16px">
            <p class="muted">
                You are about to submit your dealer application. Please ensure all details are correct. Our verification team will review your submission and contact you with the next steps.
            </p>

            <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:12px">
                <button class="btn btn-ghost">Cancel</button>
                <button id="confirmSubmit" class="btn btnpro
                 ">Yes, submit</button>
            </div>
        </div>
    </div>
</div>


<!-- Detail Modal -->
<div class="modal" id="detailModalVehi" aria-hidden="true">
    <div class="modal-card">
        <div style="display:flex;justify-content:space-between;align-items:center">
            <h3>Vehicle details</h3><button class="toolbar btn" data-close="detailModal">✕</button>
        </div>
        <div id="detailBodyVehi" style="margin-top:10px"></div>
        <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:12px">
            <button id="approveBtn" class="btn">Approve</button>
            <button id="rejectBtn" class="btn">Reject</button>
            <button id="deleteBtn" class="btn">Delete</button>
        </div>
    </div>
</div>







<div class="modal" id="confirmModal" aria-hidden="true">
    <div class="modal-card">
        <div style="display:flex;justify-content:space-between;align-items:center"><strong id="confirmTitle">Confirm</strong><button class="btn ghost" data-close="confirmModal">✕</button></div>
        <div id="confirmBody" style="margin-top:10px"></div>
        <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:12px"><button id="confirmOk" class="btn primary">Yes</button><button class="btn ghost" data-close="confirmModal">Cancel</button></div>
    </div>
</div>



<!-- Delete confirm Modal -->
<div class="modal" id="delModal" aria-hidden="true">
    <div class="modal-card" data-aos="zoom-in">
        <div style="padding:12px 16px;border-bottom:1px solid rgba(15,23,36,0.06);display:flex;justify-content:space-between;align-items:center"><strong>Delete account</strong><button class="icon-btn" onclick="closeModal('delModal')"><i class="bi bi-x-lg"></i></button></div>
        <div style="padding:16px">
            <p class="muted">This action is irreversible in production. In this demo it will clear local demo data. Proceed?</p>
            <div style="display:flex;justify-content:flex-end;gap:8px;margin-top:12px"><button class="btn btn-ghost">Cancel</button><button id="confirmDelete" class="action-btn" style="background:linear-gradient(90deg,#ef4444,#f97316)">Delete</button></div>
        </div>
    </div>
</div>

<!-- DETAIL MODAL -->
<div class="modal" id="detailModal" aria-hidden="true">
    <div class="modal-card" role="dialog" aria-modal="true" aria-labelledby="detailTitle">
        <div style="display:flex;justify-content:space-between;align-items:center">
            <h3 id="detailTitle">Notification</h3><button class="icon-btn" data-close="detailModal" aria-label="Close">✕</button>
        </div>
        <div id="detailBody" style="margin-top:12px"></div>
        <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:12px">
            <button id="detailMark" class="btn ghost">Mark read</button>
            <button id="detailArchive" class="btn ghost">Archive</button>
            <button id="detailDelete" class="btn" style="background:var(--danger);color:#fff">Delete</button>
        </div>
    </div>
</div>

<!-- CREATE MODAL -->
<div class="modal" id="createModal" aria-hidden="true">
    <div class="modal-card" role="dialog" aria-modal="true" aria-labelledby="createTitle">
        <div style="display:flex;justify-content:space-between;align-items:center">
            <h3 id="createTitle">Create / Broadcast Notification</h3><button class="icon-btn" data-close="createModal" aria-label="Close">✕</button>
        </div>
        <form id="createForm" style="margin-top:12px;display:grid;gap:8px">
            <label>Title<input name="title" required placeholder="Short title" style="width:100%;padding:8px;border-radius:8px;border:1px solid rgba(15,23,36,.06)"></label>
            <label>Message<textarea name="message" required rows="4" style="width:100%;padding:8px;border-radius:8px;border:1px solid rgba(15,23,36,.06)"></textarea></label>
            <div style="display:flex;gap:8px;flex-wrap:wrap">
                <select name="type" style="padding:8px;border-radius:8px;border:1px solid rgba(15,23,36,.06)">
                    <option value="system">System</option>
                    <option value="user">User</option>
                    <option value="dealer">Dealer</option>
                    <option value="transaction">Transaction</option>
                </select>
                <select name="priority" style="padding:8px;border-radius:8px;border:1px solid rgba(15,23,36,.06)">
                    <option value="normal">Normal</option>
                    <option value="high">High</option>
                    <option value="low">Low</option>
                </select>
                <label style="display:flex;align-items:center;gap:6px"><input type="checkbox" name="broadcast"> Broadcast to all</label>
            </div>
            <div style="display:flex;gap:8px;justify-content:flex-end"><button type="submit" class="btn primary">Send</button><button type="button" class="btn ghost" data-close="createModal">Cancel</button></div>
        </form>
    </div>
</div>