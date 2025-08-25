<?php

namespace App\Services;

use App\Utils\Response;
use configs\DB;
use App\Services\Activity;
use App\Utils\Utility;


class ReportService
{
    protected $db;
    protected $theftReport;
    protected $profile;
    protected $account;


    public function __construct()
    {
        $this->db = new DB();
        $this->theftReport = Utility::$theft_tbl;
        $this->profile = Utility::$profile_tbl;
        $this->account = Utility::$account_tbl;
    }



    public function theftReport($id)
    {
        try {
            return $this->db->joinTables(
                "$this->theftReport r",
                [
                    [
                        "type" => "LEFT",
                        "table" => "$this->profile u",
                        "on" => "u.userid = r.userid"
                    ],
                    [
                        "type" => "LEFT",
                        "table" => "$this->account a",
                        "on" => "u.userid = a.userid"
                    ]
                ],
                ["r.*", "u.fullname", "a.role_id"],
                [
                    "OR" => [
                        "r.userid"   => $id,
                        "r.id"       => $id,
                        "r.theft_id" => $id
                    ]
                ],
                ["order" => "u.id DESC"]
            );
        } catch (\Throwable $th) {
            Response::error(500, "An error occurred while updating user details");
            Utility::log($th->getMessage(), 'error', 'ReportService::theftReport', ['userid' => $id], $th);
        }
    }

    public function theftReportAll()
    {
        $data = $this->db->joinTables(
            "$this->theftReport u",
            [
                [
                    "type" => "LEFT",
                    "table" => "$this->profile a",
                    "on" => "u.userid = a.userid"
                ]
            ],
            ["u.*", "a.*"],
        );

        echo json_encode($data);
    }

    public function theftsReports()
    {
        try {
            return $this->db->joinTables(
                "$this->theftReport u",
                [
                    [
                        "type" => "LEFT",
                        "table" => "$this->profile a",
                        "on" => "u.userid = a.userid"
                    ]
                ],
                ["u.*", "a.*"]
            );
        } catch (\Throwable $th) {
            Response::error(500, "An error occurred while updating user details");
            Utility::log($th->getMessage(), 'error', 'ReportService::getTheftReports', ['userid' => $_SESSION['userid']], $th);
        }
    }

    public function getTheftReport($id)
    {

        $report = $this->theftReport($id);

        if (empty($report)) Response::error(404, "Theft report not found");
        Response::success($report, "Theft report found");
    }

    public function getTheftReports()
    {
        $reports = $this->theftsReports();
        if (empty($reports)) Response::error(404, "Theft reports not found");
        Response::success($reports, "Theft reports found");
    }

    public function uploadNewTheftReport($data)
    {
        try {
            $report = $this->theftReport($data['theftId']);
            if (!empty($report)) Response::error(409, "Theft report already exists");

            #process Image
            if (
                isset($_FILES['vehicleImages']) &&
                isset($_FILES['vehicleImages']['tmp_name'][0]) &&
                is_uploaded_file($_FILES['vehicleImages']['tmp_name'][0])
            ) {
                $target_dir = "public/UPLOADS/vehicles/";
                $vehicle_image = Utility::uploadDocuments('vehicleImages', $target_dir);
                if (!$vehicle_image || !$vehicle_image['success']) {
                    Response::error(500, "Image upload failed");
                }

                $data['vehicle_image'] = $vehicle_image['files'];
            }

            #process docs
            if (
                isset($_FILES['vehicleDocs']) &&
                isset($_FILES['vehicleDocs']['tmp_name'][0]) &&
                is_uploaded_file($_FILES['vehicleDocs']['tmp_name'][0])
            ) {
                $target_dir = "public/UPLOADS/reports/";
                $vehicle_docs = Utility::uploadDocuments('vehicleDocs', $target_dir);
                if (!$vehicle_docs || !$vehicle_docs['success']) {
                    Response::error(500, "File upload failed");
                }

                $data['vehicleDocs'] = $vehicle_docs['files'];
            }
            $reportArray = [
                'theft_id' => $data['theftId'],
                'userid' => $data['userid'],
                'vin' => $data['vin'],
                'report_data' => json_encode($data)
            ];
            if ($this->db->insert($this->theftReport, $reportArray)) {

                Activity::newActivity([
                    'userid' => $data['userid'] ?? $_SESSION['userid'],
                    'actions' => "New theft report",
                ]);

                Response::success(['Report' => $data['theftId']], 'Theft Reporting successful');
            }
            Response::error(500, "An error has occurred");
        } catch (\Throwable $th) {
            Response::error(500, "An error occurred while reporting theft details");
            Utility::log($th->getMessage(), 'error', 'ReportService::uploadNewTheftReport', ['userid' => $data['userid']], $th);
        }
    }

    public function updateTheftReport($id, $data)
    {
        try {
            $report = $this->theftReport($id);
            if (empty($report)) Response::error(404, "Theft report not found");
            $currentReport = $report[0];

            $updateArray = [
                'report_status' => $data['report_status'] ?? $currentReport['report_status']
            ];
            if (
                $this->db->update($this->theftReport,  $updateArray, ["theft_id" => $id])
            ) {
                Activity::newActivity([
                    'userid' => $currentReport['userid'] ?? $_SESSION['userid'],
                    'actions' => 'Theft report updated',
                ]);
                Response::success([], "Theft Report Update Successful");
            }
            Response::error(500, "An error has occurred");
        } catch (\Throwable $th) {
            Response::error(500, "An error occurred while updating theft report");
            Utility::log($th->getMessage(), 'error', 'ReportService::updateTheftReport', ['userid' => $data['userid']], $th);
        }
    }

    public function deleteTheftReport($id)
    {
        try {
            $report = $this->theftReport($id);
            if (empty($report)) Response::error(404, "Theft report not found");

            $currentReport = $report[0];

            $reportData = json_decode($currentReport['report_data'], true);
            $reportImages = $reportData['vehicle_image'];
            $reportDocs = $reportData['vehicleDocs'];



            # Find and remove the former images
            if (isset($reportImages)) {
                foreach ($reportImages as $image) {
                    $imageFile = basename($image);
                    $target_dir = "../public/UPLOADS/vehicles/" . $imageFile;
                    if (file_exists($target_dir)) {
                        unlink($target_dir);
                    }
                }
            }

            # Find and remove the former docs
            if (isset($reportDocs)) {
                foreach ($reportDocs as $doc) {
                    $docFile = basename($doc);
                    $target_dir = "../public/UPLOADS/reports/" . $docFile;
                    if (file_exists($target_dir)) {
                        unlink($target_dir);
                    }
                }
            }



            if ($this->db->delete($this->theftReport, ["theft_id" => $id])) {
                if (Activity::newActivity([
                    'userid' => $currentReport['userid'] ?? $_SESSION['userid'],
                    'actions' => 'Theft report deleted',
                ]));
                Response::success([], "Theft report deleted");
            }

            Response::error(500, "An error has occurred");
        } catch (\Throwable $th) {
            Response::error(500, "An error occurred while updating theft report");
            Utility::log($th->getMessage(), 'error', 'ReportService::deleteTheftReport', ['userid' => $_SESSION['userid']], $th);
        }
    }
}
