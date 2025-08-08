<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Vehicle Report Accordion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            padding: 20px;
        }

        .accordion {
            max-width: 900px;
            margin: auto;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .accordion-item {
            border-bottom: 1px solid #ddd;
        }

        .accordion-button {
            width: 100%;
            padding: 1rem;
            background-color: #f8f9fa;
            border: none;
            text-align: left;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.2s ease;
            position: relative;
        }

        .accordion-button:hover {
            background-color: #e2e6ea;
        }

        .accordion-button::after {
            content: "▲";
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            transition: transform 0.2s;
        }

        .accordion-button.collapsed::after {
            content: "▼";
        }

        .accordion-collapse {
            display: none;
            padding: 1rem;
            background-color: #ffffff;
        }

        .accordion-collapse.show {
            display: block;
        }

        .accordion-body {
            line-height: 1.6;
        }

        .section-title {
            font-weight: bold;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

    <div class="accordion" id="vehicleAccordion">

        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-target="#vehicleDocs">
                    📁 Vehicle Documents
                </button>
            </h2>
            <div id="vehicleDocs" class="accordion-collapse collapse">
                <div class="accordion-body">
                    <div class="section-title">Uploaded Documents</div>
                    <ul>
                        <li>Registration Certificate.pdf</li>
                        <li>Insurance Record.jpg</li>
                        <li>Roadworthiness Report.pdf</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-target="#vehicleImages">
                    🖼️ Vehicle Images
                </button>
            </h2>
            <div id="vehicleImages" class="accordion-collapse collapse">
                <div class="accordion-body">
                    <div class="section-title">Vehicle Photos</div>
                    <img src="car-front.jpg" alt="Front View" style="width:100%;max-width:300px;">
                    <img src="car-rear.jpg" alt="Rear View" style="width:100%;max-width:300px;">
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
                    <p><strong>Make:</strong> Toyota</p>
                    <p><strong>Model:</strong> Corolla</p>
                    <p><strong>Year:</strong> 2020</p>
                    <p><strong>Color:</strong> Silver</p>
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-target="#ownershipHistory">
                    🧾 Ownership History
                </button>
            </h2>
            <div id="ownershipHistory" class="accordion-collapse collapse">
                <div class="accordion-body">
                    <ul>
                        <li>Owner 1: John Doe (2019–2022)</li>
                        <li>Owner 2: Jane Smith (2022–Present)</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-target="#specifications">
                    ⚙️ Vehicle Specifications
                </button>
            </h2>
            <div id="specifications" class="accordion-collapse collapse">
                <div class="accordion-body">
                    <p><strong>Engine:</strong> 1.8L I4</p>
                    <p><strong>Transmission:</strong> Automatic</p>
                    <p><strong>Mileage:</strong> 45,000 km</p>
                    <p><strong>Fuel Type:</strong> Petrol</p>
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-target="#valuation">
                    💰 Vehicle Valuation
                </button>
            </h2>
            <div id="valuation" class="accordion-collapse collapse">
                <div class="accordion-body">
                    <p><strong>Current Market Value:</strong> ₦5,200,000</p>
                    <p><strong>Last Updated:</strong> July 2025</p>
                </div>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const accordionButtons = document.querySelectorAll(".accordion-button");

            accordionButtons.forEach(button => {
                button.addEventListener("click", function() {
                    const targetId = this.getAttribute("data-target");
                    const targetContent = document.querySelector(targetId);

                    // Close all other sections
                    document.querySelectorAll(".accordion-collapse").forEach(panel => {
                        if (panel !== targetContent) {
                            panel.classList.remove("show");
                            panel.previousElementSibling?.querySelector(".accordion-button")?.classList.add("collapsed");
                        }
                    });

                    // Toggle selected section
                    targetContent.classList.toggle("show");
                    this.classList.toggle("collapsed");
                });
            });
        });
    </script>

</body>

</html>