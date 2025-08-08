<?php
require_once ROOT_PATH . '/siteConfig.php';
require_once ROOT_PATH . '/includes/header.php';
require_once ROOT_PATH . '/includes/dashNavbar.php';
?>

<body id="theftPage" class="theme-light dashboard"
    data-page="<?= $_SESSION['role']; ?>"
    data-id="<?= $_SESSION['userid']; ?>">
    <main class="container p-4">
        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= BASE_URL; ?>dashboard/overview">Dashboard</a></li>
                <li class="breadcrumb-item" aria-current="page">Reports</li>
                <li class="breadcrumb-item active" aria-current="page">Theft</li>
            </ol>
        </nav>
        <div class="page-header mt-3 mb-3" data-aos="fade-down">
            <div class="welcome">Theft Reports Management</div>
            <p>Welcome to your dashboard to manage your account, view recent transactions, and update your preferences for a seamless experience.
            </p>
        </div>
        <section class="chart">
        </section>
        <section class="mt-4">
            <div class="top-controls">
                <div class="filters">
                    <input type="text" id="searchInput" placeholder="Search by VIN or Owner Name" />
                    <select id="statusFilter">
                        <option value="">All Status</option>
                        <option value="approve">Approve</option>
                        <option value="decline">Decline</option>
                        <option value="missing">Missing</option>
                        <option value="reported">Reported</option>
                        <option value="found">Found</option>

                    </select>
                </div>
                <div class="actions-bar">
                    <button class="btn btn-outline-primary btn-sm">Export CSV</button>
                    <button class="btn btn-outline-secondary btn-sm pdfBtn">Download PDF</button>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#newReportModal"><i class="fas fa-plus"></i>New Report</button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="brand-table" id="theftTable">
                    <thead>
                        <tr>
                            <th>VIN</th>
                            <th>Vehicle</th>
                            <th>Owner</th>
                            <th>Date</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="theftTbody" class="download-section"></tbody>

                </table>
                <div id="no-records" class="no-records text-center mt-4 text-muted" style="display:none">Record not found.</div>
                <div class="pagination" id="pagination"></div>
            </div>
        </section>
    </main>
    <?php require_once ROOT_PATH . '/includes/dash-links.php'; ?>
    <?php require_once ROOT_PATH . '/includes/footer.php'; ?>
    <script type="module" src="<?php echo BASE_URL; ?>assets/js/Class/Dashboard.js"></script>
    <!-- New Report Modal -->
    <div class="modal fade" id="newReportModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Report New Stolen Vehicle</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="theftReport" class="custom-form" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row gy-3">
                            <!-- Section 1: Vehicle Details -->
                            <div class="col-12">
                                <h6 class="fw-bold">Vehicle Details</h6>
                                <p class="text-muted">Please provide basic information about the stolen vehicle.</p>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="vehicleName" class="form-label">Vehicle Make & Model</label>
                                    <input type="text" id="vehicleName" name="vehicleName" class="form-control" placeholder="e.g. Toyota Corolla 2015" required>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="plateNumber" class="form-label">License Plate Number</label>
                                    <input type="text" id="plateNumber" name="plateNumber" class="form-control" placeholder="e.g. AB123XYZ" required>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="vin" class="form-label">Identification Number (VIN)</label>
                                    <input type="text" id="vin" name="vin" class="form-control" placeholder="e.g. 1HGCM82633A004352" required>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="vehicleDesc" class="form-label">Vehicle Description</label>
                                    <textarea id="vehicleDesc" name="vehicleDesc" rows="3" placeholder="Include color, features, dents, stickers, etc."></textarea>
                                </div>
                            </div>

                            <!-- Section 2: Theft Location -->
                            <div class="col-12 mt-3">
                                <h6 class="fw-bold">Theft Location</h6>
                                <p class="text-muted">Where did the theft happen?</p>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="location" class="form-label">Exact Location</label>
                                    <input type="text" id="location" name="location" class="form-control" placeholder="e.g. 24th Street Parking Lot" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="state" class="form-label">State / County</label>
                                    <input type="text" id="state" name="state" class="form-control" placeholder="e.g. Lagos" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="country" class="form-label">Country</label>
                                    <input type="text" id="country" name="country" class="form-control" placeholder="e.g. Nigeria" required>
                                </div>
                            </div>

                            <!-- Section 3: Theft Date -->
                            <div class="col-12 mt-3">
                                <h6 class="fw-bold">Date of Theft</h6>
                                <p class="text-muted">When did the vehicle go missing?</p>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="theftDate" class="form-label">Date of Theft</label>
                                    <input type="text" id="theftDate" name="theftDate" class="form-control" placeholder="Select date..." required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="theftDay" class="form-label">Day</label>
                                    <input type="number" id="theftDay" name="theftDay" class="form-control" placeholder="e.g. 12" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="theftMonth" class="form-label">Month</label>
                                    <input type="text" id="theftMonth" name="theftMonth" class="form-control" placeholder="e.g. July" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="theftYear" class="form-label">Year</label>
                                    <input type="number" id="theftYear" name="theftYear" class="form-control" placeholder="e.g. 2025" required>
                                </div>
                            </div>


                            <!-- Section 4: Uploads -->
                            <div class="col-12 mt-3">
                                <h6 class="fw-bold">Supporting Files</h6>
                                <p class="text-muted">Upload clear photos of the vehicle and any ownership documents.</p>
                            </div>

                            <div class="col-12">
                                <label for="vehicleImages" class="form-label">Vehicle Images</label>
                                <input type="file" id="vehicleImages" name="vehicleImages[]" class="form-control" multiple accept="image/*">
                            </div>

                            <div class="col-12">
                                <label for="vehicleDocs" class="form-label">Vehicle Documents</label>
                                <input type="file" id="vehicleDocs" name="vehicleDocs[]" class="form-control" multiple accept=".pdf,.doc,.docx,.jpg,.png">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit Report</button>
                    </div>
                </form>
                <script>
                    // Helper to get month name from number
                    const getMonthName = (monthIndex) => {
                        return [
                            "January", "February", "March", "April", "May", "June",
                            "July", "August", "September", "October", "November", "December"
                        ][monthIndex];
                    };

                    const picker = new Pikaday({
                        field: document.getElementById('theftDate'),
                        format: 'YYYY-MM-DD', // Optional: date format shown in the input
                        onSelect: function(date) {
                            document.getElementById('theftDay').value = date.getDate();
                            document.getElementById('theftMonth').value = getMonthName(date.getMonth());
                            document.getElementById('theftYear').value = date.getFullYear();
                        }
                    });
                </script>
            </div>
        </div>
    </div>

    <!-- View Detail Modal -->
    <div class="modal fade" id="viewDetailModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="report-title">Stolen Vehicle Details</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="report-detail">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Document Modal -->
    <div class="modal fade" id="docModal" tabindex="-1" aria-labelledby="docModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">📄 Document Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <iframe id="docPreview" src="" width="100%" height="500px" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const docFrame = document.getElementById("doc-frame");

            document.querySelectorAll(".doc-link").forEach((btn) => {
                btn.addEventListener("click", function() {
                    const src = this.getAttribute("data-doc");

                    // If the doc is a PDF, load directly; otherwise, use Google Docs Viewer
                    if (src.endsWith(".pdf")) {
                        docFrame.src = src;
                    } else {
                        docFrame.src = `https://docs.google.com/gview?url=${encodeURIComponent(
            src
          )}&embedded=true`;
                    }
                });
            });
        });
    </script>

</body>

</html