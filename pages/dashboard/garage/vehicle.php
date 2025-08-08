<?php
require_once ROOT_PATH . '/siteConfig.php';
require_once ROOT_PATH . '/includes/header.php';
require_once ROOT_PATH . '/includes/dashNavbar.php';
$vin = $_GET['vin'] ?? null;
?>

<body id="vehicle-manager" class="theme-light dashboard"
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
            <div class="welcome">Manage Vehicle</div>
            <div class="page-note accent" data-aos="fade-in">
                This page lists all verified and pending car dealers. You can update status, view performance, or remove a dealer.
            </div>
        </div>
        <div class="card shadow-sm border-0 p-4 mb-4">
            <div class="card-header bg-primary text-white rounded-top py-3 px-4">
                <h5 class="mb-0"><i class="fas fa-car me-2"></i>Manage Vehicle Data</h5>
            </div>

            <div class="card-body">
                <form id="vinForm" class="row g-3 align-items-end">
                    <div class="col-md-6">
                        <label for="vin" class="form-label">Enter Vehicle VIN</label>
                        <input
                            type="text"
                            id="vin"
                            name="vin"
                            class="form-control"
                            value="<?php echo $vin; ?>"
                            placeholder="e.g. 1HGCM82633A123456"
                            required />
                    </div>

                    <div class="col-md-3">
                        <button type="submit" class="btn btn-accent w-100">
                            <i class="fas fa-search me-1"></i>Verify VIN
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <section id="vehicleData" class="custom-form" style="display:none;">
            <div class="accordion" id="vehicleAccordion">

                <!-- Example Section -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-target="#vehicleDocs">
                            📁 Vehicle Documents
                        </button>
                    </h2>
                    <div id="vehicleDocs" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            <div class="content">
                                <div class="data-section">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <form class="newFile" data-file="document" enctype="multipart/form-data">
                                                <label>New Document</label>
                                                <input type="file" id="vehicleDocs" name="vehicleDocs[]" class="vehicleDocs  form-control" multiple accept=".pdf,.doc,.docx">

                                                <button type="submit" class="btn btn-sm btn-outline-primary mt-2">Upload Doc</button>
                                            </form>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="data-entry">
                                                <div id="docThumbnails">
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Repeat for each section -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-target="#vehicleImages">
                            🖼️ Vehicle Images
                        </button>
                    </h2>
                    <div id="vehicleImages" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            <div class="content">
                                <div class="data-section">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <form class="newFile" data-file="images" enctype="multipart/form-data">
                                                <label>New Image</label>
                                                <input type="file" id="vehicleDocs" name="vehicleImages[]" class="vehicleDocs  form-control" multiple accept="image/*">

                                                <button type="submit" class="btn btn-sm btn-outline-primary mt-2">Upload Image</button>
                                            </form>
                                        </div>
                                        <form class="vehicleDataForm" data-form="vehicle_information">
                                            <div class="col-sm-8">
                                                <div class="data-entry">
                                                    <div class="thumbnails" id="imageThumbnails">
                                                    </div>
                                                </div>
                                            </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-target="#vehicleInfoSection">
                            🛠️ Vehicle Basic Info
                        </button>
                    </h2>
                    <div id="vehicleInfoSection" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            <div class="content">
                                <div class="data-section">
                                    <div id="vehicleInfo"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Repeat for Ownership History, Specifications, Valuation, etc. -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-target="#vehicleOwnershipSection">
                            🧾 Ownership History
                        </button>
                    </h2>
                    <div id="vehicleOwnershipSection" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            <div class="content">
                                <div class="card shadow-sm border-0">
                                    <div class="card-body">
                                        <div class="row g-4">
                                            <!-- Form Section -->
                                            <div class="col-md-4">
                                                <div id="ownershipForm"></div>

                                            </div>

                                            <!-- Display Section -->
                                            <div class="col-md-8">
                                                <div class="bg-white p-3 rounded border">
                                                    <h6 class="mb-3">Previous Records</h6>

                                                    <div id="ownershipRecords">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-target="#vehicleSpecsSection">
                            ⚙️ Vehicle Specifications
                        </button>
                    </h2>
                    <div id="vehicleSpecsSection" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            <div class="content">
                                <div class="vehicle-specs-container">
                                    <!-- Left: Add/Edit Spec -->
                                    <div id="specification"></div>

                                    <!-- Right: Existing Specs -->
                                    <div class="spec-list">
                                        <h3>Existing Specifications</h3>
                                        <div id="specLists"></div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-target="#vehicleValuationSection">
                            💰 Vehicle Valuation
                        </button>
                    </h2>
                    <div id="vehicleValuationSection" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            <div class="content">
                                <div class="card mb-4">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Valuation Report</h5>
                                        <button class="btn btn-primary btn-sm" id="addValuationBtn">+ Add Valuation</button>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Left Column: Add/Edit Valuation Form -->
                                            <div class="col-md-6">
                                                <form id="valuationForm" class="border p-3 rounded bg-light d-none">
                                                    <div class="mb-3">
                                                        <label for="condition" class="form-label">Vehicle Condition</label>
                                                        <input type="text" class="form-control" id="condition" name="condition" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="price" class="form-label">Assessed Price</label>
                                                        <input type="number" class="form-control" id="price" name="price" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="assessor" class="form-label">Assessor Name</label>
                                                        <input type="text" class="form-control" id="assessor" name="assessor">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="date" class="form-label">Assessment Date</label>
                                                        <input type="date" class="form-control" id="date" name="date" required>
                                                    </div>
                                                    <div class="d-flex justify-content-end gap-2">
                                                        <button type="submit" class="btn btn-success">Save</button>
                                                        <button type="button" class="btn btn-secondary" id="cancelValuation">Cancel</button>
                                                    </div>
                                                </form>
                                            </div>

                                            <!-- Right Column: Existing Valuation Records -->
                                            <div class="col-md-6">
                                                <div id="valuationContainer"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-target="#vehicleInspectSection">
                            🛠️ Vehicle Inspections Info
                        </button>
                    </h2>
                    <div id="vehicleInspectSection" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            <div class="content">
                                <div class="row mt-4">
                                    <!-- Left: Dynamic Inspection Form -->
                                    <div class="col-md-6">
                                        <div class="card shadow-sm">
                                            <div class="card-header bg-primary text-white">
                                                <strong>Record Vehicle Inspection</strong>
                                            </div>
                                            <div class="card-body">
                                                <form class="vehicleDataForm" data-form="inspections">
                                                    <div class="mb-3">
                                                        <label class="form-label">Inspection Date</label>
                                                        <input type="date" class="form-control" name="inspectionDate" required>
                                                    </div>

                                                    <div id="inspectionItems">
                                                        <!-- Dynamic inspection items will appear here -->
                                                    </div>

                                                    <button type="button" class="btn btn-sm btn-outline-secondary mb-3" onclick="addInspectionItem()">➕ Add Inspection Item</button>

                                                    <div class="mb-3">
                                                        <label class="form-label">Other Notes</label>
                                                        <textarea class="form-control" name="notes" rows="3"></textarea>
                                                    </div>

                                                    <button type="submit" class="btn btn-success w-100">Save Inspection</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right: Inspection Records -->
                                    <div class="col-md-6">
                                        <div class="card shadow-sm">
                                            <div class="card-header bg-secondary text-white">
                                                <strong>Inspection Records</strong>
                                            </div>
                                            <div class="card-body">
                                                <div id="inspectionRecords">


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>



    </main>
    <?php require_once ROOT_PATH . '/includes/dash-links.php'; ?>
    <?php require_once ROOT_PATH . '/includes/footer.php'; ?>
    <script type="module" src="<?php echo BASE_URL; ?>assets/js/Class/Vehicle.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const accordionButtons = document.querySelectorAll(".accordion-button");

            accordionButtons.forEach(button => {
                button.addEventListener("click", function() {
                    const targetId = this.getAttribute("data-target");
                    const targetContent = document.querySelector(targetId);

                    // Close all other accordion items
                    document.querySelectorAll(".accordion-collapse").forEach(panel => {
                        if (panel !== targetContent) {
                            panel.classList.remove("show");
                            panel.previousElementSibling?.querySelector(".accordion-button")?.classList.add("collapsed");
                        }
                    });

                    // Toggle clicked section
                    targetContent.classList.toggle("show");
                    this.classList.toggle("collapsed");
                });
            });
        });
    </script>
    <script>
        const addBtn = document.getElementById('addValuationBtn');
        const form = document.getElementById('valuationForm');
        const cancelBtn = document.getElementById('cancelValuation');

        addBtn.addEventListener('click', () => {
            form.classList.remove('d-none');
        });

        cancelBtn.addEventListener('click', () => {
            form.classList.add('d-none');
            form.reset();
        });
    </script>
    <script>
        let itemCount = 0;

        function addInspectionItem(key = '', value = 'Good') {
            const id = `item-${itemCount++}`;
            const container = document.getElementById("inspectionItems");

            container.insertAdjacentHTML('beforeend', `
            <div class="row g-2 align-items-center mb-2" id="${id}">
                <div class="col-5">
                <input type="text" class="form-control" name="itemKey[]" placeholder="Item (e.g. Battery)" value="${key}" required>
                </div>
                <div class="col-5">
                <select class="form-select" name="itemValue[]" required>
                    <option ${value === 'Excellent' ? 'selected' : ''}>Excellent</option>
                    <option ${value === 'Good' ? 'selected' : ''}>Good</option>
                    <option ${value === 'Fair' ? 'selected' : ''}>Fair</option>
                    <option ${value === 'Poor' ? 'selected' : ''}>Poor</option>
                </select>
                </div>
                <div class="col-2">
                <button type="button" class="btn btn-outline-danger btn-sm w-100" onclick="removeItem('${id}')">🗑</button>
                </div>
            </div>
            `);
        }

        function removeItem(id) {
            const el = document.getElementById(id);
            if (el) el.remove();
        }

        // Optional: You can use this to prepopulate one item on page load
        document.addEventListener("DOMContentLoaded", () => {
            addInspectionItem();
        });
    </script>


</body>


</html