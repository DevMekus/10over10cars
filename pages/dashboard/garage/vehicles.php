<?php
require_once ROOT_PATH . '/siteConfig.php';
require_once ROOT_PATH . '/includes/header.php';
require_once ROOT_PATH . '/includes/dashNavbar.php';
?>

<body id="vehicleListingPage" class="theme-light dashboard"
    data-page="<?= $_SESSION['role']; ?>"
    data-id="<?= $_SESSION['userid']; ?>">
    <main class="container p-4">
        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= BASE_URL; ?>dashboard/overview">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dealers</li>
            </ol>
        </nav>
        <div class="page-header mt-3 mb-3" data-aos="fade-down">
            <div class="welcome">Manage Car Listings</div>
            <div class="page-note accent" data-aos="fade-in">
                This page lists all verified and pending car dealers. You can update status, view performance, or remove a dealer.
            </div>
        </div>
        <section class="mb-3 mt-3">
            <div id="vehicleOverview" class="cards" data-aos="fade-up">
            </div>
        </section>
        <section class="mt-4">
            <div class="top-controls">
                <div class="filters">
                    <input type="text" id="searchInput" placeholder="Search by model, brand, vin, dealer..." />
                    <select id="statusFilter">
                        <option>All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="rejected">Rejected</option>
                    </select>

                </div>
                <div class="actions-bar">
                    <button class="btn btn-outline-primary btn-sm">Export CSV</button>
                    <button class="btn btn-outline-secondary btn-sm pdfBtn">Download PDF</button>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#vehicleModal"><i class="fas fa-plus"></i>+ Add Listing</button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="brand-table" id="theftTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Make</th>
                            <th>Model</th>
                            <th>Dealer</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="vehicleListTbody" class="download-section"></tbody>
                </table>
                <div id="no-records" class="no-records text-center mt-4 text-muted" style="display:none">Record not found.</div>
                <div class="pagination" id="pagination"></div>
            </div>
        </section>
    </main>
    <?php require_once ROOT_PATH . '/includes/dash-links.php'; ?>
    <?php require_once ROOT_PATH . '/includes/footer.php'; ?>
    <script type="module" src="<?php echo BASE_URL; ?>assets/js/Class/Vehicle.js"></script>
</body>
<!-- Modal -->
<div class="modal fade" id="vehicleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Upload Vehicle Information
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="new-vehicle" class="p-3 border rounded shadow-sm bg-light custom-form" enctype="multipart/form-data">
                <div class="modal-body">
                    <!-- VIN -->
                    <div class="mb-3">
                        <label for="vin" class="form-label" data-bs-toggle="tooltip" title="Vehicle Identification Number (usually 17 characters long)">
                            VIN *
                        </label>
                        <input type="text" class="form-control" id="vin" name="vin" placeholder="e.g., 1HGCM82633A004352" required>
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
                            <label for="make" class="form-label" data-bs-toggle="tooltip" title="Select the brand of the vehicle">
                                Make
                            </label>
                            <select name="make" id="make" class="form-select mb-2" onchange="populateModels()" required>
                                <option value="">Select Make</option>
                                <?php foreach ($makesAndModels as $make => $models): ?>
                                    <option value="<?= htmlspecialchars($make) ?>"><?= htmlspecialchars($make) ?></option>
                                <?php endforeach; ?>
                                <option value="other">Other</option>
                            </select>
                            <input type="text" name="makeCustom" id="makeCustom" class="form-control d-none" placeholder="Enter custom make">
                            <small class="text-muted">If not listed, select "Other" and type it.</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="model" class="form-label" data-bs-toggle="tooltip" title="Select or enter the vehicle model">
                                Model
                            </label>
                            <select name="model" id="model" class="form-select mb-2" required>
                                <option value="">Select Model</option>
                            </select>
                            <input type="text" name="modelCustom" id="modelCustom" class="form-control d-none" placeholder="Enter custom model">
                            <small class="text-muted">Auto-fills based on Make or enter manually.</small>
                        </div>
                    </div>

                    <!-- Trim & Year -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="trim" class="form-label" data-bs-toggle="tooltip" title="Vehicle's trim level (e.g., LE, SE, Sport)">
                                Trim
                            </label>
                            <input type="text" class="form-control" id="trim" name="trim" placeholder="e.g., LE, Sport">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="year" class="form-label" data-bs-toggle="tooltip" title="Manufacturing year">
                                Year
                            </label>
                            <input type="number" class="form-control" id="year" name="year" placeholder="e.g., 2021">
                        </div>
                    </div>

                    <!-- Mileage -->
                    <div class="mb-3">
                        <label for="mileage" class="form-label" data-bs-toggle="tooltip" title="Total kilometers the vehicle has traveled">
                            Mileage (km)
                        </label>
                        <input type="number" class="form-control" id="mileage" name="mileage" placeholder="e.g., 45300">
                    </div>

                    <!-- Body Type & Fuel Type -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <?php $bodyTypes = ["Sedan", "Hatchback", "SUV", "Coupe", "Convertible", "Wagon", "Van", "Truck", "Minivan", "Pickup"]; ?>
                            <label for="bodyType" class="form-label" data-bs-toggle="tooltip" title="Vehicle body configuration">
                                Body Type
                            </label>
                            <select name="bodyType" id="bodyType" class="form-select" required>
                                <option value="">Select Body Type</option>
                                <?php foreach ($bodyTypes as $type): ?>
                                    <option value="<?= htmlspecialchars($type) ?>"><?= htmlspecialchars($type) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <?php $fuelTypes = ["Petrol", "Diesel", "Electric", "Hybrid", "CNG", "LPG", "Hydrogen", "Ethanol"]; ?>
                            <label for="fuelType" class="form-label" data-bs-toggle="tooltip" title="Type of fuel the vehicle uses">
                                Fuel Type
                            </label>
                            <select name="fuelType" id="fuelType" class="form-select" required>
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
                            <label for="driveType" class="form-label" data-bs-toggle="tooltip" title="How power is delivered to wheels">
                                Drive Type
                            </label>
                            <select name="driveType" id="driveType" class="form-select" required>
                                <option value="">Select Drive Type</option>
                                <?php foreach ($driveTypes as $type): ?>
                                    <option value="<?= htmlspecialchars($type) ?>"><?= htmlspecialchars($type) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="plateNumber" class="form-label" data-bs-toggle="tooltip" title="Vehicle’s plate/license number">
                                Plate Number
                            </label>
                            <input type="text" class="form-control" id="plateNumber" name="plateNumber" placeholder="e.g., ABC-1234">
                        </div>
                    </div>

                    <!-- Transmission -->
                    <div class="mb-3">
                        <?php $transmissions = ["Manual", "Automatic", "CVT", "Semi-Automatic", "Dual-Clutch"]; ?>
                        <label for="transmission" class="form-label" data-bs-toggle="tooltip" title="Gear system">
                            Transmission
                        </label>
                        <select name="transmission" id="transmission" class="form-select" required>
                            <option value="">Select Transmission</option>
                            <?php foreach ($transmissions as $trans): ?>
                                <option value="<?= htmlspecialchars($trans) ?>"><?= htmlspecialchars($trans) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Colors -->
                    <?php $colorOptions = ["Black", "White", "Silver", "Blue", "Red", "Grey", "Green", "Yellow", "Brown", "Orange"]; ?>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="exteriorColor" class="form-label" data-bs-toggle="tooltip" title="Color of the car’s outer body">
                                Exterior Color
                            </label>
                            <select name="exteriorColor" id="exteriorColor" class="form-select mb-2" required onchange="toggleCustomColor(this, 'exteriorColorCustom')">
                                <option value="">Select Exterior Color</option>
                                <?php foreach ($colorOptions as $color): ?>
                                    <option value="<?= htmlspecialchars($color) ?>"><?= htmlspecialchars($color) ?></option>
                                <?php endforeach; ?>
                                <option value="other">Other</option>
                            </select>
                            <input type="text" name="exteriorColorCustom" id="exteriorColorCustom" class="form-control d-none" placeholder="Enter custom exterior color">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="interiorColor" class="form-label" data-bs-toggle="tooltip" title="Color of the car’s interior materials">
                                Interior Color
                            </label>
                            <select name="interiorColor" id="interiorColor" class="form-select mb-2" required onchange="toggleCustomColor(this, 'interiorColorCustom')">
                                <option value="">Select Interior Color</option>
                                <?php foreach ($colorOptions as $color): ?>
                                    <option value="<?= htmlspecialchars($color) ?>"><?= htmlspecialchars($color) ?></option>
                                <?php endforeach; ?>
                                <option value="other">Other</option>
                            </select>
                            <input type="text" name="interiorColorCustom" id="interiorColorCustom" class="form-control d-none" placeholder="Enter custom interior color">
                        </div>
                        <div class="col-md-6">
                            <label for="vehicleImages" class="form-label">Vehicle Images</label>
                            <input type="file" id="vehicleImages" name="vehicleImages[]" class="form-control" multiple accept="image/*">
                        </div>

                        <div class="col-md-6">
                            <label for="vehicleDocs" class="form-label">Vehicle Documents</label>
                            <input type="file" id="vehicleDocs" name="vehicleDocs[]" class="form-control" multiple accept=".pdf,.doc,.docx">
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Upload Vehicle</button>
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
                // Initialize tooltips
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

</html